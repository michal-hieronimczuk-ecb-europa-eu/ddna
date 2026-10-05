<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;
use Drupal\migrate_plus\Entity\Migration;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'migrate_config_extractor', label: new TranslatableMarkup('Migrate Config Extractor'), description: new TranslatableMarkup('Migrate Config Extractor.'))]
class MigrateConfigExtractor extends SeedPluginBase {

  /**
   * Returns migration table data as JSON.
   *
   * @return string
   *   The encoded headers and migration rows.
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
   * Returns the migration table column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'migrate_label' => 'Migrate label',
      'migrate_machine_name' => 'Migrate machine name',
      'status' => 'Enabled',
      'migration_group' => 'Migration group',
      'migration_tags' => 'Migration tags',
      'migrate_source_plugin' => 'Migrate source plugin',
      'source_configuration' => 'Source configuration',
      'migrate_destination_plugin' => 'Migrate destination plugin',
      'destination_configuration' => 'Destination configuration',
      'dependencies' => 'Migration dependencies',
    ];
  }

  /**
   * Builds rows for matching migrations.
   *
   * @return array
   *   The migration data rows.
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
      [, , $migration_id] = explode('.', $element);
      $migration_entity = Migration::load($migration_id);
      if (!$migration_entity) {
        continue;
      }
      $migration = $migration_entity->toArray();
      $migration_tags = $migration['migration_tags'] ?? [];
      $table_rows[] = (object) [
        'migrate_label' => $migration['label'],
        'migrate_machine_name' => $migration['id'],
        'status' => !empty($migration['status']) ? 'Enabled' : 'Disabled',
        'migration_group' => $migration['migration_group'] ?? '-',
        'migration_tags' => $migration_tags ? implode(', ', $migration_tags) : 'None',
        'migrate_source_plugin' => $migration['source']['plugin'],
        'source_configuration' => json_encode($this->redactSensitiveValues($migration['source']), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
        'migrate_destination_plugin' => $migration['destination']['plugin'],
        'destination_configuration' => json_encode($this->redactSensitiveValues($migration['destination']), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
        'dependencies' => json_encode($migration['migration_dependencies'] ?? [], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
      ];
    }

    return $table_rows;
  }

  /**
   * Redacts common credential values from migration configuration.
   *
   * @param mixed $value
   *   A migration configuration value.
   *
   * @return mixed
   *   The configuration with likely secrets redacted.
   */
  protected function redactSensitiveValues(mixed $value): mixed {
    if (is_array($value)) {
      $redacted = [];
      foreach ($value as $key => $item) {
        $redacted[$key] = preg_match('/password|secret|token|api[_-]?key|authorization|credential|private[_-]?key/i', (string) $key)
          ? '[redacted]'
          : $this->redactSensitiveValues($item);
      }
      return $redacted;
    }

    if (is_string($value)) {
      $value = preg_replace('/(https?:\/\/)[^\/@\s]+@/i', '$1[redacted]@', $value);
      return preg_replace('/([?&](?:password|secret|token|api[_-]?key)=)[^&]*/i', '$1[redacted]', $value);
    }

    return $value;
  }

}
