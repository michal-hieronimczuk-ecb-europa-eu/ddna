<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'block_type_config_extractor', label: new TranslatableMarkup('Block Type Config Extractor'), description: new TranslatableMarkup('Block Type Config Extractor.'))]
class BlockTypeConfigExtractor extends SeedPluginBase {

  /**
   * Returns the block table data as JSON.
   *
   * @return string
   *   The encoded headers and block rows.
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
   * Returns the block table column labels.
   *
   * @return string[]
   *   The column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'block_id' => 'Block ID',
      'block_label' => 'Block label',
      'plugin_id' => 'Plugin ID',
      'plugin_label' => 'Plugin',
      'status' => 'Status',
      'theme_region' => 'Theme region',
      'theme' => 'Theme',
      'weight' => 'Weight',
      'settings' => 'Settings',
      'visibility' => 'Visibility conditions',
    ];
  }

  /**
   * Builds rows for matching block configuration.
   *
   * @return array
   *   The block data rows.
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

    $blocks = \Drupal::entityTypeManager()->getStorage('block')->loadMultiple();
    $block_plugin_manager = \Drupal::service('plugin.manager.block');
    foreach ($configs as $element) {
      $block_id = substr($element, strlen('block.block.'));
      if (!isset($blocks[$block_id])) {
        continue;
      }

      $block = $blocks[$block_id];
      $plugin_definition = $block_plugin_manager->getDefinition($block->getPluginId(), FALSE);
      $settings = $block->get('settings');
      $table_rows[] = (object) [
        'block_id' => $block->id(),
        'block_label' => $settings['label'] ?? ($plugin_definition['admin_label'] ?? $block->getPluginId()),
        'plugin_id' => $block->getPluginId(),
        'plugin_label' => $plugin_definition['admin_label'] ?? $block->getPluginId(),
        'status' => $block->status() ? 'Enabled' : 'Disabled',
        'theme_region' => $block->getRegion(),
        'theme' => $block->getTheme(),
        'weight' => $block->getWeight(),
        'settings' => json_encode($settings, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
        'visibility' => json_encode($block->getVisibility(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
      ];
    }

    return $table_rows;
  }

}
