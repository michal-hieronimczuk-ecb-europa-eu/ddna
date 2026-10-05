<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'menu_type_config_extractor', label: new TranslatableMarkup('Menu Type Config Extractor'), description: new TranslatableMarkup('Menu Type Config Extractor.'))]
class MenuTypeConfigExtractor extends SeedPluginBase {

  /**
   * Returns menu table data as JSON.
   *
   * @return string
   *   The encoded headers and menu rows.
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
   * Returns the menu table column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'title' => 'Title',
      'machine_name' => 'Machine name',
      'description' => 'Description',
      'link_count' => 'Configured menu links',
    ];
  }

  /**
   * Builds rows for matching menus.
   *
   * @return array
   *   The menu data rows.
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

    $menus = \Drupal::entityTypeManager()->getStorage('menu')->loadMultiple();
    $menu_tree = \Drupal::menuTree();
    foreach ($configs as $element) {
      [, , $menu_id] = explode('.', $element);
      if (!isset($menus[$menu_id])) {
        continue;
      }

      $tree = $menu_tree->load($menu_id, new MenuTreeParameters());
      $table_rows[] = (object) [
        'title' => $menus[$menu_id]->label(),
        'machine_name' => $menus[$menu_id]->id(),
        'description' => $menus[$menu_id]->getDescription() ?: '-',
        'link_count' => $this->countMenuLinks($tree),
      ];
    }

    return $table_rows;
  }

  /**
   * Counts visible links in a menu tree.
   *
   * @param array $tree
   *   The menu tree.
   *
   * @return int
   *   The number of visible links.
   */
  protected function countMenuLinks(array $tree): int {
    $count = 0;
    foreach ($tree as $item) {
      $count++;
      $count += $this->countMenuLinks($item->subtree);
    }

    return $count;
  }

}
