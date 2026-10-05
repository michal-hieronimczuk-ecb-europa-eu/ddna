<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\Config\Entity\ConfigEntityTypeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;
use Drupal\field\FieldConfigInterface;
use Drupal\migrate_plus\Entity\Migration;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'bundle_type_config_extractor', label: new TranslatableMarkup('Bundle Type Config Extractor'), description: new TranslatableMarkup('Bundle Type Config Extractor.'))]
class BundleTypeConfigExtractor extends SeedPluginBase {

  /**
   * Returns bundle table data as JSON.
   *
   * @return string
   *   The encoded headers and bundle rows.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \JsonException
   */
  public function getElements(): string {
    return json_encode([
      'headers' => (object) $this->getTableHeader(),
      'rows' => $this->getTableRows(),
    ], JSON_THROW_ON_ERROR);
  }

  /**
   * Returns the bundle table column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'name' => 'Name',
      'machine_name' => 'Machine name',
      'entity_type' => 'Entity type',
      'bundle_entity_name' => 'Bundle entity name',
      'description' => 'Description',
      'examples' => 'Example(s)',
      'moderated' => 'Moderated',
      'layout_builder' => 'Layout builder',
      'translatable' => 'Translatable',
      'migrated' => 'Migrated (Content will be populated via migration)',
      'scheduled' => 'Scheduled (Scheduled updates are enabled)',
      'searchable' => 'Searchable (Is indexed for site search)',
      'type' => 'Type',
      'url_alias_pattern' => 'Url alias pattern',
      'field_count' => 'Configured field count',
      'workflow' => 'Moderation workflow',
      'scheduler' => 'Scheduled publishing',
    ];
  }

  /**
   * Builds rows for matched bundle configuration.
   *
   * @return array
   *   The bundle data rows.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function getTableRows(): array {
    $table_rows = [];
    $configs = \Drupal::service('ddna_config_matcher')
      ->matchAllConfigs($this->configuration['params']['regexp']);
    if (empty($configs)) {
      return [];
    }

    $entity_type_manager = \Drupal::entityTypeManager();
    $config_names = array_fill_keys($configs, TRUE);
    $bundle_entity_types = [];
    foreach ($entity_type_manager->getDefinitions() as $entity_type_id => $entity_type) {
      $bundle_entity_type_id = $entity_type->getBundleEntityType();
      if (!$bundle_entity_type_id || !$entity_type_manager->hasDefinition($bundle_entity_type_id)) {
        continue;
      }

      $bundle_entity_type = $entity_type_manager->getDefinition($bundle_entity_type_id);
      if (!$bundle_entity_type instanceof ConfigEntityTypeInterface) {
        continue;
      }

      $config_prefix = $bundle_entity_type->getConfigPrefix();
      $bundle_entity_types[$config_prefix][$bundle_entity_type_id][$entity_type_id] = $entity_type;
    }

    foreach ($bundle_entity_types as $config_prefix => $bundle_types) {
      foreach ($bundle_types as $bundle_entity_type_id => $entity_types) {
        foreach ($entity_type_manager->getStorage($bundle_entity_type_id)->loadMultiple() as $bundle) {
          $config_name = $config_prefix . '.' . $bundle->id();
          if (!isset($config_names[$config_name])) {
            continue;
          }

          foreach ($entity_types as $entity_type_id => $entity_type) {
            $workflow_names = $this->getModerationWorkflows($entity_type_id, $bundle->id());
            $scheduler_settings = $bundle->getThirdPartySettings('scheduler');
            $scheduler_enabled = !empty($scheduler_settings['publish_enable']) || !empty($scheduler_settings['unpublish_enable']);
            $view_display = \Drupal::service('entity_display.repository')
              ->getViewDisplay($entity_type_id, $bundle->id());
            $layout_builder_enabled = $view_display->getThirdPartySetting('layout_builder', 'enabled', FALSE);
            $translation_enabled = \Drupal::moduleHandler()->moduleExists('content_translation')
              && \Drupal::service('content_translation.manager')->isEnabled($entity_type_id, $bundle->id());
            $pathauto_patterns = $this->getPathautoPatterns($entity_type_id, $bundle->id());
            $migration_ids = $this->getMigrationIds($entity_type_id, $bundle->id());
            $field_definitions = \Drupal::service('entity_field.manager')
              ->getFieldDefinitions($entity_type_id, $bundle->id());

            $table_rows[] = (object) [
              'name' => (string) $bundle->label(),
              'machine_name' => $bundle->id(),
              'entity_type' => $entity_type_id,
              'bundle_entity_name' => $bundle_entity_type_id,
              'description' => method_exists($bundle, 'getDescription') ? ($bundle->getDescription() ?: '-') : '-',
              'examples' => $this->getExamples($entity_type_id, $bundle->id()),
              'moderated' => $workflow_names ? 'Yes' : 'No',
              'layout_builder' => $layout_builder_enabled ? 'Yes' : 'No',
              'translatable' => $translation_enabled ? 'Yes' : 'No',
              'migrated' => $migration_ids ? 'Yes: ' . implode(', ', $migration_ids) : 'No',
              'scheduled' => $scheduler_enabled ? 'Yes' : 'No',
              'searchable' => $this->isSearchable($entity_type_id) ? 'Yes' : 'No',
              'type' => (string) $entity_type->getLabel(),
              'url_alias_pattern' => $pathauto_patterns ? implode(', ', $pathauto_patterns) : '-',
              'field_count' => count(array_filter($field_definitions, static fn ($field) => $field instanceof FieldConfigInterface)),
              'workflow' => $workflow_names ? implode(', ', $workflow_names) : '-',
              'scheduler' => $scheduler_enabled ? json_encode($scheduler_settings, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) : '-',
            ];
          }
        }
      }
    }

    return $table_rows;
  }

  /**
   * Finds moderation workflows that apply to a bundle.
   *
   * @param string $entity_type_id
   *   The entity type ID.
   * @param string $bundle_id
   *   The bundle ID.
   *
   * @return string[]
   *   Workflow labels for the bundle.
   */
  protected function getModerationWorkflows(string $entity_type_id, string $bundle_id): array {
    static $all_workflows;
    $entity_type_manager = \Drupal::entityTypeManager();
    if (!$entity_type_manager->hasDefinition('workflow')) {
      return [];
    }

    $workflows = [];
    $all_workflows ??= $entity_type_manager->getStorage('workflow')->loadMultiple();
    foreach ($all_workflows as $workflow) {
      $entity_types = $workflow->getTypePlugin()->getConfiguration()['entity_types'] ?? [];
      $bundles = $entity_types[$entity_type_id] ?? [];
      if (isset($bundles[$bundle_id]) || in_array($bundle_id, $bundles, TRUE)) {
        $workflows[] = (string) $workflow->label();
      }
    }

    return $workflows;
  }

  /**
   * Finds Pathauto patterns that apply to a bundle.
   *
   * @param string $entity_type_id
   *   The entity type ID.
   * @param string $bundle_id
   *   The bundle ID.
   *
   * @return string[]
   *   Matching pattern names and path templates.
   */
  protected function getPathautoPatterns(string $entity_type_id, string $bundle_id): array {
    static $all_patterns;
    $entity_type_manager = \Drupal::entityTypeManager();
    if (!$entity_type_manager->hasDefinition('pathauto_pattern')) {
      return [];
    }

    $patterns = [];
    $all_patterns ??= $entity_type_manager->getStorage('pathauto_pattern')->loadMultiple();
    foreach ($all_patterns as $pattern) {
      foreach ($pattern->get('selection_criteria') ?? [] as $criterion) {
        if (($criterion['id'] ?? '') === 'entity_bundle:' . $entity_type_id
          && in_array($bundle_id, array_keys($criterion['bundles'] ?? []), TRUE)) {
          $patterns[] = $pattern->label() . ': ' . $pattern->get('pattern');
          break;
        }
      }
    }

    return $patterns;
  }

  /**
   * Finds migrations with a fixed destination bundle.
   *
   * @param string $entity_type_id
   *   The entity type ID.
   * @param string $bundle_id
   *   The bundle ID.
   *
   * @return string[]
   *   Matching migration IDs.
   */
  protected function getMigrationIds(string $entity_type_id, string $bundle_id): array {
    static $all_migrations;
    $migration_ids = [];
    $all_migrations ??= Migration::loadMultiple();
    foreach ($all_migrations as $migration) {
      $configuration = $migration->toArray();
      $destination_plugin = $configuration['destination']['plugin'] ?? '';
      $destination_entity_type = str_starts_with($destination_plugin, 'entity:')
        ? substr($destination_plugin, strlen('entity:'))
        : ($destination_plugin === 'book' ? 'node' : '');
      $destination_bundle = $configuration['process']['type']['default_value'] ?? NULL;
      if ($destination_entity_type === $entity_type_id && $destination_bundle === $bundle_id) {
        $migration_ids[] = $migration->id();
      }
    }

    return $migration_ids;
  }

  /**
   * Determines whether the entity type is indexed by Drupal Search.
   *
   * @param string $entity_type_id
   *   The entity type ID.
   *
   * @return bool
   *   TRUE when Drupal Search indexes the entity type.
   */
  protected function isSearchable(string $entity_type_id): bool {
    return $entity_type_id === 'node' && \Drupal::moduleHandler()->moduleExists('search');
  }

  /**
   * Returns up to three accessible published examples for a bundle.
   *
   * @param string $entity_type_id
   *   The entity type ID.
   * @param string $bundle_id
   *   The bundle ID.
   *
   * @return string
   *   Example labels or a message when no examples are accessible.
   */
  protected function getExamples(string $entity_type_id, string $bundle_id): string {
    $entity_type_manager = \Drupal::entityTypeManager();
    $entity_type = $entity_type_manager->getDefinition($entity_type_id);
    $bundle_key = $entity_type->getKey('bundle');
    if (!$bundle_key) {
      return 'No bundle query available';
    }

    $query = $entity_type_manager->getStorage($entity_type_id)
      ->getQuery()
      ->accessCheck(TRUE)
      ->condition($bundle_key, $bundle_id);
    $published_key = $entity_type->getKey('published');
    if ($published_key) {
      $query->condition($published_key, 1);
    }
    $entity_ids = $query->range(0, 3)->execute();
    if (!$entity_ids) {
      return 'No accessible examples';
    }

    $examples = [];
    foreach ($entity_type_manager->getStorage($entity_type_id)->loadMultiple($entity_ids) as $entity) {
      $examples[] = (string) $entity->label();
    }

    return $examples ? implode(', ', $examples) : 'No accessible examples';
  }

}
