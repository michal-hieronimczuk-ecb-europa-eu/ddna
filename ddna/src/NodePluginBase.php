<?php

namespace Drupal\ddna;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for node plugins.
 */
abstract class NodePluginBase extends PluginBase implements NodeInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function shape() {
    // Get a shape plugin configuration value.
    return $this->configuration['shape'];
  }

  /**
   * {@inheritdoc}
   */
  public function seeds() {
    // Get seeds plugin configuration list value.
    return $this->configuration['seeds'];
  }
}
