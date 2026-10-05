<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'image_style_config_extractor', label: new TranslatableMarkup('Image Style Config Extractor'), description: new TranslatableMarkup('Image Style Config Extractor.'))]
class ImageStyleConfigExtractor extends SeedPluginBase {

  /**
   * Returns image style effect data as JSON.
   *
   * @return string
   *   The encoded headers and effect rows.
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
   * Returns the image style effect column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'style_name' => 'Style name',
      'machine_name' => 'Machine name',
      'effect_id' => 'Effect ID',
      'effect_configuration' => 'Configuration',
      'effect' => 'Effect plugin ID',
      'effect_label' => 'Effect',
      'effect_weight' => 'Effect weight',
      'summary' => 'Summary',
    ];
  }

  /**
   * Builds rows for each configured image style effect.
   *
   * @return array
   *   The image effect data rows.
   *
   * @throws \JsonException
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

    $image_styles = \Drupal::entityTypeManager()->getStorage('image_style')->loadMultiple();
    foreach ($configs as $element) {
      [, , $image_style_id] = explode('.', $element);
      if (empty($image_styles[$image_style_id])) {
        continue;
      }
      $image_style = $image_styles[$image_style_id];
      $image_style_effects = iterator_to_array($image_style->getEffects());
      if (!$image_style_effects) {
        $table_rows[] = (object) [
          'style_name' => $image_style->label(),
          'machine_name' => $image_style->id(),
          'effect_id' => '-',
          'effect_configuration' => '-',
          'effect' => '-',
          'effect_label' => 'None',
          'effect_weight' => '-',
          'summary' => '-',
        ];
        continue;
      }

      foreach ($image_style_effects as $effect) {
        $effect_definition = $effect->getPluginDefinition();
        $effect_configuration = $effect->getConfiguration();
        $table_rows[] = (object) [
          'style_name' => $image_style->label(),
          'machine_name' => $image_style->id(),
          'effect_id' => $effect->getConfiguration()['uuid'] ?? '-',
          'effect_configuration' => json_encode($effect_configuration, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
          'effect' => $effect->getPluginId(),
          'effect_label' => (string) ($effect_definition['label'] ?? $effect->getPluginId()),
          'effect_weight' => $effect->getConfiguration()['weight'] ?? '-',
          'summary' => (string) ($effect_definition['description'] ?? '-'),
        ];
      }
    }
    return $table_rows;
  }

}
