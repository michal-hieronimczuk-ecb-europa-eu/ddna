<?php

namespace Drupal\ddna\Plugin\Node;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Node;
use Drupal\ddna\NodePluginBase;

/**
 * Plugin implementation of the node.
 */
#[Node(id: 'core', label: new TranslatableMarkup('Core'), description: new TranslatableMarkup('Core description.'))]
class Core extends NodePluginBase {

}
