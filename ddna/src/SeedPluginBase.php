<?php

namespace Drupal\ddna;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for seed plugins.
 */
abstract class SeedPluginBase extends PluginBase implements SeedInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  /**
   * @return string
   * @throws \JsonException
   */
  public function getElements(): string {
    return json_encode([
      ['header name'],
      \Drupal::service('ddna_config_matcher')
        ->matchAllConfigs($this->configuration['params']['regexp']),
    ], JSON_THROW_ON_ERROR);
  }

}
