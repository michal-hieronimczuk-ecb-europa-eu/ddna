<?php

namespace Drupal\ddna\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the node plugin attribute.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Node extends Plugin {

  /**
   * Constructs a node plugin attribute.
   *
   * @param string $id
   *   The plugin ID.
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $label
   *   The human-readable name of the plugin.
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup|null $description
   *   A description of the plugin.
   */
  public function __construct(
    string $id,
    public readonly TranslatableMarkup $label,
    public readonly ?TranslatableMarkup $description = NULL,
  ) {
    parent::__construct($id);
  }

}
