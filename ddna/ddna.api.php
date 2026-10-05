<?php
/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alter the plugin definition of contextual links.
 *
 * @param array $registry_plugins
 *
 * @ingroup hooks
 */
function hook_ddna_registry_plugins(array &$registry_plugins) {
  $ddna_plugin_definition = [
    'node_connection' => [
      'group' => 'standard',
      'node'  => 'core',
      'display' => [
        'shape' => 'shape_tabbed_table',
        'seeds' => [
          'content_type_config_extractor' => [
            'params' => [
              'regexp' => '*node*',
            ],
          ],
        ],
      ],
    ],
  ];
  $registry_plugins['core'] = $ddna_plugin_definition;
}

/**
 * @} End of "addtogroup hooks".
 */
