<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;
use Drupal\views\Views;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'view_type_config_extractor', label: new TranslatableMarkup('View Type Config Extractor'), description: new TranslatableMarkup('View Type Config Extractor.'))]
class ViewTypeConfigExtractor extends SeedPluginBase {

  /**
   * Returns view table data as JSON.
   *
   * @return string
   *   The encoded headers and view display rows.
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
   * Returns the view table column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'view_name' => 'View name',
      'base_table' => 'Base table',
      'base_field' => 'Base field',
      'machine_name' => 'Machine name',
      'tag' => 'Tags',
      'display_machine_name' => 'Display machine name',
      'display_title' => 'Display title',
      'display_plugin' => 'Display plugin',
      'page_path' => 'Page path',
      'style_plugin' => 'Style plugin',
      'row_plugin' => 'Row plugin',
      'pager_plugin' => 'Pager plugin',
      'access_configuration' => 'Access configuration',
      'display_configuration' => 'Display configuration',
      'status' => 'Status',
      'description' => 'Description',
    ];
  }

  /**
   * Builds rows for matching views and displays.
   *
   * @return array
   *   The view display data rows.
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

    $views_displays_data = [];
    $views = \Drupal::entityTypeManager()->getStorage('view')->loadMultiple();
    $views_displays = Views::getViewsAsOptions();
    foreach ($views_displays as $config => $view) {
      [$view_machine_name, $display] = explode(':', $config);
      if (empty($views_displays_data[$view_machine_name])) {
        $views_displays_data[$view_machine_name] = [];
      }
      $views_displays_data[$view_machine_name][] = $display;
    }

    foreach ($configs as $element) {
      [, , $view_id] = explode('.', $element);
      if (!isset($views[$view_id])) {
        continue;
      }

      foreach ($views_displays_data[$view_id] ?? [] as $display_id) {
        $display = $views[$view_id]->getDisplay($display_id);
        $display_options = $display['display_options'] ?? [];
        $access = $display_options['access'] ?? [];
        $table_rows[] = (object) [
          'view_name' => (string) $views[$view_id]->label(),
          'base_table' => $views[$view_id]->get('base_table'),
          'base_field' => $views[$view_id]->get('base_field'),
          'machine_name' => $views[$view_id]->id(),
          'tag' => $views[$view_id]->get('tag') ?: '-',
          'display_machine_name' => $display['id'],
          'display_title' => $display['display_title'] ?? '-',
          'display_plugin' => $display['display_plugin'],
          'page_path' => $display_options['path'] ?? '-',
          'style_plugin' => $display_options['style']['type'] ?? '-',
          'row_plugin' => $display_options['row']['type'] ?? '-',
          'pager_plugin' => $display_options['pager']['type'] ?? '-',
          'access_configuration' => $access ? json_encode($access, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) : '-',
          'display_configuration' => json_encode($display_options, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
          'status' => $views[$view_id]->status() ? 'Enabled' : 'Disabled',
          'description' => $views[$view_id]->get('description') ?: '-',
        ];
      }
    }

    return $table_rows;
  }

}
