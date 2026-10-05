<?php

namespace Drupal\ddna\Controller;

use Drupal\ddna\DrupalDnaManager;
use Drupal\Core\Config\StorageInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a controller for the ddna module.
 */
class DrupalDnaController extends ControllerBase {

  /**
   * Builds a page listing all configuration keys to inspect.
   *
   * @return array
   *   A render array representing the list.
   */
  public function overview() {

    $registry = [];
    $registry_plugins = \Drupal::service('module_handler')->invokeAll('ddna_registry_plugins', $registry);
    $nodes_groups = [];
    foreach($registry_plugins as $plugin) {
      $seeds = [];
      foreach($plugin['node_connection']['display']['seeds'] as $seed_provider => $seed) {
        $seeds[] = \Drupal::service('plugin.manager.seed')->createInstance($seed_provider, [
          'label' => $seed['label'],
          'params' => $seed['params'],
        ]);
      }

      $node = \Drupal::service('plugin.manager.node')->createInstance($plugin['node_connection']['node'], [
        'label' => $plugin['node_connection']['node'],
        'shape' => $plugin['node_connection']['display']['shape'],
        'seeds' => $seeds,
      ]);
      $nodes_groups[$plugin['node_connection']['group']][] = $node;
    }

    $renderrer = [];
    foreach($nodes_groups as $node_group => $node_connection) {
      foreach($node_connection as $node) {
        $renderrer['ddna_component_renderer'][$node_group] = [
          '#type' => $node->shape(),
          '#seeds' =>  $node->seeds(),
        ];
      }
    }

//  $navigator_user_space = [];
    return $renderrer;
  }

}
