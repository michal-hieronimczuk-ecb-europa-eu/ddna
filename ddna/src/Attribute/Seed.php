<?php

namespace Drupal\ddna\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the seed plugin attribute.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Seed extends Plugin {

  /**
   * Constructs a seed plugin attribute.
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
