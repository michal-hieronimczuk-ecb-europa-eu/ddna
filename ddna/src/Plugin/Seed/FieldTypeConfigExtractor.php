<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;
use Drupal\field\FieldConfigInterface;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'field_type_config_extractor', label: new TranslatableMarkup('Field Type Config Extractor'), description: new TranslatableMarkup('Field Type Config Extractor.'))]
class FieldTypeConfigExtractor extends SeedPluginBase {

  /**
   * Returns the field table data as JSON.
   *
   * @return string
   *   The encoded headers and field rows.
   *
   * @throws \JsonException
   */
  public function getElements(): string {
    return json_encode([
      'headers' => (object) $this->getTableHeader(),
      'rows' => $this->getTableRows(),
    ], JSON_THROW_ON_ERROR);
  }

  /**
   * Returns the field table column labels.
   *
   * @return string[]
   *   The column labels keyed by the corresponding row property.
   */
  protected function getTableHeader(): array {
    return [
      'entity_type' => 'Entity type',
      'bundle' => 'Bundle',
      'field_label' => 'Field label',
      'machine_name' => 'Machine name',
      'field_group' => 'Field group',
      'field_type' => 'Field type',
      'target_bundle' => 'Target bundle for reference fields',
      'required' => 'Required',
      'translatable' => 'Translatable',
      'cardinality' => 'Cardinality, -1 means unlimited list',
      'default_value' => 'Default value',
      'default_value_callback' => 'Default value callback',
      'form_widget' => 'Form widget',
      'widget_settings' => 'Widget settings',
      'help_text' => 'Help text',
    ];
  }

  /**
   * Builds rows for all matching bundle fields.
   *
   * @return array
   *   The field data rows.
   */
  protected function getTableRows(): array {
    $table_rows = [];
    $configs = \Drupal::service('ddna_config_matcher')
      ->matchAllConfigs($this->configuration['params']['regexp']);
    if (empty($configs)) {
      return [];
    }

    $entity_field_manager = \Drupal::service('entity_field.manager');
    $entity_display_repository = \Drupal::service('entity_display.repository');
    foreach ($configs as $element) {
      [, , $entity_type_id, $bundle] = explode('.', $element);
      $fields_definition = $entity_field_manager->getFieldDefinitions($entity_type_id, $bundle);
      $field_storage_definitions = $entity_field_manager->getFieldStorageDefinitions($entity_type_id);
      $form_display = $entity_display_repository->getFormDisplay($entity_type_id, $bundle);
      $field_groups = $form_display->getThirdPartySettings('field_group');

      foreach ($fields_definition as $definition) {
        if (!$definition instanceof FieldConfigInterface) {
          continue;
        }

        $field_name = $definition->getName();
        $field_storage_definition = $field_storage_definitions[$field_name] ?? NULL;
        $field_settings = $definition->getSettings();
        $target_bundles = $field_settings['handler_settings']['target_bundles'] ?? NULL;
        if (!empty($field_settings['target_type'])) {
          $target_bundle_value = empty($target_bundles)
            ? 'All bundles'
            : implode(', ', array_keys($target_bundles));
        }
        else {
          $target_bundle_value = '-';
        }

        $component = $form_display->getComponent($field_name);
        $widget_id = $component['type'] ?? NULL;
        $widget_definition = $widget_id
          ? \Drupal::service('plugin.manager.field.widget')->getDefinition($widget_id, FALSE)
          : NULL;
        $widget_label = $widget_definition ? (string) $widget_definition['label'] : ($widget_id ?: '-');
        $widget_settings = $component['settings'] ?? [];
        $default_values = $definition->getDefaultValueLiteral();
        $field_description = trim((string) $definition->getDescription());

        $table_rows[] = (object) [
          'entity_type' => $entity_type_id,
          'bundle' => $definition->getTargetBundle(),
          'field_label' => $definition->getLabel(),
          'machine_name' => $field_name,
          'field_group' => $this->getFieldGroupLabel($field_name, $field_groups),
          'field_type' => $definition->getType(),
          'target_bundle' => $target_bundle_value,
          'required' => $definition->isRequired() ? 'Yes' : 'No',
          'translatable' => $definition->isTranslatable() ? 'Yes' : 'No',
          'cardinality' => $field_storage_definition ? $field_storage_definition->getCardinality() : '-',
          'default_value' => $default_values ? json_encode($default_values, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) : '-',
          'default_value_callback' => $definition->getDefaultValueCallback() ?: '-',
          'form_widget' => $widget_label,
          'widget_settings' => $widget_settings ? json_encode($widget_settings, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) : '-',
          'help_text' => $field_description !== '' ? $field_description : '-',
        ];
      }
    }

    return $table_rows;
  }

  /**
   * Returns the configured field group path for a field.
   *
   * @param string $field_name
   *   The field machine name.
   * @param array $field_groups
   *   Field Group third-party settings from an entity form display.
   *
   * @return string
   *   The group labels, or a dash when the field is not grouped.
   */
  protected function getFieldGroupLabel(string $field_name, array $field_groups): string {
    $labels = [];
    foreach ($field_groups as $group_id => $group) {
      if (!in_array($field_name, $group['children'] ?? [], TRUE)) {
        continue;
      }

      $labels[] = $group['label'] ?? $group_id;
      $parent_name = $group['parent_name'] ?? '';
      while ($parent_name !== '' && isset($field_groups[$parent_name])) {
        array_unshift($labels, $field_groups[$parent_name]['label'] ?? $parent_name);
        $parent_name = $field_groups[$parent_name]['parent_name'] ?? '';
      }
    }

    return $labels ? implode(' / ', array_unique($labels)) : '-';
  }

}
