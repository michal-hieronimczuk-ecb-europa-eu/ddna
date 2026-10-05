<?php

namespace Drupal\ddna\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element to display an entity.
 *
 * Properties:
 * - #entity_type: The entity type.
 * - #entity_id: The entity ID.
 * - #view_mode: The view mode that should be used to render the entity.
 * - #langcode: For which language the entity should be rendered.
 *
 * Usage Example:
 *
 * @code
 * $build['node'] = [
 *   '#type' => 'shape_tabbed_table',
 *   '#seeds' => [],
 * ];
 * @endcode
 *
 * @RenderElement("shape_tabbed_table")
 */
class ShapeTabbedTable extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return [
      '#pre_render' => [
        [get_class($this), 'preRenderElement'],
      ],
      '#seeds' => [],
    ];
  }

  /**
   * Entity element pre render callback.
   *
   * @param array $element
   *   An associative array containing the properties of the entity element.
   *
   * @return array
   *   The modified element.
   */
  public static function preRenderElement(array $element) {
    if (empty($element['#seeds'])) {
      return ['#markup' => 'There are no seeds available'];
    }

    $tabs = [];
    $tabs_content = [];
    foreach ($element['#seeds'] as $idx => $seed) {
      $tabs[] = $seed->configuration['label'];
      $table_data_json = $seed->getElements();
      $page['table'] = [
        '#type' => 'container',
        '#attributes' => [
          'id' => "js-table-{$idx}",
          'class' => ['ddna-table-container'],
          'data-table-json' => $table_data_json,
        ],
      ];
      $tabs_content[] = $page;
    }
    // dump($tabs_content);
    $element['tabs'] = [
      '#theme' => 'ddna_tabbed_table',
      '#tabs' => $tabs,
      '#content' => $tabs_content,
      '#attached' => [
        'library' => [
          'ddna/ddna_tabbed_table',
          'ddna/ddna_json_value_viewer',
        ],
      ],
    ];

    return $element;
    // Return ['#markup' => 'TabbedTable'];.
  }

}
