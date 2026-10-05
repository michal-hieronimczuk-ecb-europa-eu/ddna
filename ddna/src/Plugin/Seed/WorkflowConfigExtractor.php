<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'workflow_config_extractor', label: new TranslatableMarkup('Workflow Config Extractor'), description: new TranslatableMarkup('Workflow Config Extractor.'))]
class WorkflowConfigExtractor extends SeedPluginBase {

  /**
   * Returns workflow state table data as JSON.
   *
   * @return string
   *   The encoded headers and workflow state rows.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
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
   * Returns the workflow state table column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'workflow_name' => 'Workflow name',
      'workflow_machine_name' => 'Workflow machine name',
      'workflow_type' => 'Workflow type',
      'entity_type' => 'Entity type',
      'entity_bundle' => 'Entity bundle',
      'state_name' => 'State name',
      'state_machine_name' => 'State machine name',
      'initial_state' => 'Initial state',
      'published' => 'Published state',
      'default_revision' => 'Default revision',
      'state_weight' => 'State weight',
      'default_moderation_state' => 'Default moderation state',
    ];
  }

  /**
   * Builds rows for workflow states and their assigned bundles.
   *
   * @return array
   *   The workflow state data rows.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function getTableRows(): array {
    $table_rows = [];
    $configs = \Drupal::service('ddna_config_matcher')
      ->matchAllConfigs($this->configuration['params']['regexp']);
    if (empty($configs)) {
      return [];
    }

    foreach ($configs as $element) {
      [, , $workflow_id] = explode('.', $element);
      $workflow = \Drupal::entityTypeManager()->getStorage('workflow')->load($workflow_id);
      if (!$workflow) {
        continue;
      }

      $workflow_type = $workflow->getTypePlugin();
      $workflow_configuration = $workflow_type->getConfiguration();
      $initial_state_id = $workflow_type->getPluginId() === 'content_moderation'
        ? ($workflow_configuration['default_moderation_state'] ?? 'draft')
        : $workflow_type->getInitialState()->id();
      $entity_bundles = $this->getWorkflowEntityBundles($workflow_configuration['entity_types'] ?? []);
      if (!$entity_bundles) {
        $entity_bundles = [['entity_type' => '-', 'bundle' => '-']];
      }
      foreach ($workflow_configuration['states'] as $state_id => $workflow_state) {
        foreach ($entity_bundles as $entity_bundle) {
          $table_rows[] = (object) [
            'workflow_name' => $workflow->label(),
            'workflow_machine_name' => $workflow->id(),
            'workflow_type' => $workflow_type->label(),
            'entity_type' => $entity_bundle['entity_type'],
            'entity_bundle' => $entity_bundle['bundle'],
            'state_name' => $workflow_state['label'],
            'state_machine_name' => $state_id,
            'initial_state' => $state_id === $initial_state_id ? 'Yes' : 'No',
            'published' => !empty($workflow_state['published']) ? 'Yes' : 'No',
            'default_revision' => !empty($workflow_state['default_revision']) ? 'Yes' : 'No',
            'state_weight' => $workflow_state['weight'] ?? 0,
            'default_moderation_state' => $workflow_configuration['default_moderation_state'] ?? '-',
          ];
        }
      }
    }

    return $table_rows;
  }

  /**
   * Flattens workflow entity bundle configuration.
   *
   * @param array $entity_types
   *   Entity types and bundle IDs from workflow configuration.
   *
   * @return array
   *   Entity type and bundle pairs.
   */
  protected function getWorkflowEntityBundles(array $entity_types): array {
    $entity_bundles = [];
    foreach ($entity_types as $entity_type_id => $bundles) {
      foreach ($bundles as $key => $value) {
        $entity_bundles[] = [
          'entity_type' => $entity_type_id,
          'bundle' => is_int($key) ? $value : $key,
        ];
      }
    }

    return $entity_bundles;
  }

}
