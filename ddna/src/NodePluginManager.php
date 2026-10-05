<?php

namespace Drupal\ddna;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\ddna\Annotation\Node as NodeAnnotation;
use Drupal\ddna\Attribute\Node as NodeAttribute;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Node plugin manager.
 */
class NodePluginManager extends DefaultPluginManager {

  /**
   * Constructs NodePluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/Node',
      $namespaces,
      $module_handler,
      'Drupal\ddna\NodeInterface',
      NodeAttribute::class,
      NodeAnnotation::class
    );
    $this->alterInfo('node_info');
    $this->setCacheBackend($cache_backend, 'node_plugins');
  }

}
