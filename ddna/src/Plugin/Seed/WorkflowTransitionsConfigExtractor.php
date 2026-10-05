<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'workflow_transitions_config_extractor', label: new TranslatableMarkup('Workflow Transitions Config Extractor'), description: new TranslatableMarkup('Workflow Transitions Config Extractor.'))]
class WorkflowTransitionsConfigExtractor extends SeedPluginBase {

  /**
   * Returns workflow transition table data as JSON.
   *
   * @return string
   *   The encoded headers and transition rows.
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
   * Returns the workflow transition column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'workflow_name' => 'Workflow name',
      'workflow_machine_name' => 'Workflow machine name',
      'workflow_type' => 'Workflow type',
      'entity_type' => 'Entity type',
      'entity_bundle' => 'Entity bundle',
      'workflow_transition_label' => 'Transition label',
      'workflow_transition_machine_name' => 'Transition machine name',
      'from_state' => 'From state',
      'from_state_label' => 'From state label',
      'to_state' => 'To state',
      'to_state_label' => 'To state label',
      'transition_weight' => 'Transition weight',
    ];
  }

  /**
   * Builds rows for workflow transitions and their assigned bundles.
   *
   * @return array
   *   The workflow transition data rows.
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

    foreach ($configs as $element) {
      [, , $workflow_id] = explode('.', $element);
      $workflow = \Drupal::entityTypeManager()->getStorage('workflow')->load($workflow_id);
      if (!$workflow) {
        continue;
      }

      $workflow_type = $workflow->getTypePlugin();
      $workflow_configuration = $workflow_type->getConfiguration();
      $entity_bundles = $this->getWorkflowEntityBundles($workflow_configuration['entity_types'] ?? []);
      if (!$entity_bundles) {
        $entity_bundles = [['entity_type' => '-', 'bundle' => '-']];
      }
      foreach ($workflow_configuration['transitions'] as $transition_id => $workflow_transition) {
        foreach ($workflow_transition['from'] as $from_state) {
          foreach ($entity_bundles as $entity_bundle) {
            $table_rows[] = (object) [
              'workflow_name' => $workflow->label(),
              'workflow_machine_name' => $workflow->id(),
              'workflow_type' => $workflow_type->label(),
              'entity_type' => $entity_bundle['entity_type'],
              'entity_bundle' => $entity_bundle['bundle'],
              'workflow_transition_label' => $workflow_transition['label'],
              'workflow_transition_machine_name' => $transition_id,
              'from_state' => $from_state,
              'from_state_label' => $workflow_configuration['states'][$from_state]['label'] ?? $from_state,
              'to_state' => $workflow_transition['to'],
              'to_state_label' => $workflow_configuration['states'][$workflow_transition['to']]['label'] ?? $workflow_transition['to'],
              'transition_weight' => $workflow_transition['weight'] ?? 0,
            ];
          }
        }
      }
    }

    return $table_rows;
  }

  /**
   * Flattens workflow entity bundle configuration.
   *
   * @param array $entity_types
   *   Entity types and bundle IDs from workflow configuration.
   *
   * @return array
   *   Entity type and bundle pairs.
   */
  protected function getWorkflowEntityBundles(array $entity_types): array {
    $entity_bundles = [];
    foreach ($entity_types as $entity_type_id => $bundles) {
      foreach ($bundles as $key => $value) {
        $entity_bundles[] = [
          'entity_type' => $entity_type_id,
          'bundle' => is_int($key) ? $value : $key,
        ];
      }
    }

    return $entity_bundles;
  }

}
