<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'image_style_type_config_extractor', label: new TranslatableMarkup('Images Styles Type Config Extractor'), description: new TranslatableMarkup('Images Styles Type Config Extractor.'))]
class ImageStyleTypeConfigExtractor extends SeedPluginBase {

  /**
   * Returns image style summary data as JSON.
   *
   * @return string
   *   The encoded headers and image style rows.
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
   * Returns the image style summary column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'style_name' => 'Image style',
      'machine_name' => 'Machine name',
      'effect_count' => 'Effect count',
      'effects' => 'Effects',
      'effect_configuration' => 'Effect configuration',
    ];
  }

  /**
   * Builds one row for each image style.
   *
   * @return array
   *   The image style rows.
   *
   * @throws \JsonException
   */
  protected function getTableRows(): array {
    $table_rows = [];
    $configs = \Drupal::service('ddna_config_matcher')
      ->matchAllConfigs($this->configuration['params']['regexp']);
    if (!$configs) {
      return [];
    }

    $image_styles = \Drupal::entityTypeManager()->getStorage('image_style')->loadMultiple();
    foreach ($configs as $config_name) {
      [, , $style_id] = explode('.', $config_name);
      if (!isset($image_styles[$style_id])) {
        continue;
      }

      $style = $image_styles[$style_id];
      $effects = $style->get('effects');
      $effect_labels = [];
      foreach ($effects as $effect) {
        $definition = \Drupal::service('plugin.manager.image.effect')
          ->getDefinition($effect['id'], FALSE);
        $effect_labels[] = $definition ? (string) $definition['label'] : $effect['id'];
      }
      $table_rows[] = (object) [
        'style_name' => $style->label(),
        'machine_name' => $style->id(),
        'effect_count' => count($effects),
        'effects' => $effect_labels ? implode(', ', $effect_labels) : 'None',
        'effect_configuration' => $effects ? json_encode($effects, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) : '-',
      ];
    }

    return $table_rows;
  }

}
