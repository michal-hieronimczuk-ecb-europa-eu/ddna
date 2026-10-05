<?php

namespace Drupal\ddna\Plugin\Seed;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ddna\Attribute\Seed;
use Drupal\ddna\SeedPluginBase;

/**
 * Plugin implementation of the seed.
 */
#[Seed(id: 'user_role_config_extractor', label: new TranslatableMarkup('User Roles Config Extractor'), description: new TranslatableMarkup('User Roles Config Extractor.'))]
class UserRoleConfigExtractor extends SeedPluginBase {

  /**
   * Returns user role table data as JSON.
   *
   * @return string
   *   The encoded headers and role rows.
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
   * Returns the user role table column labels.
   *
   * @return string[]
   *   Column labels keyed by row property.
   */
  protected function getTableHeader(): array {
    return [
      'role_name' => 'Role name',
      'machine_name' => 'Machine name',
      'weight' => 'Weight',
      'administrator' => 'Administrator role',
      'permission_count' => 'Permission count',
      'permissions' => 'Permissions',
    ];
  }

  /**
   * Builds rows for matching user roles.
   *
   * @return array
   *   The user role data rows.
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

    $user_roles = \Drupal::entityTypeManager()->getStorage('user_role')->loadMultiple();
    foreach ($configs as $element) {
      [, , $user_role_id] = explode('.', $element);
      if (!isset($user_roles[$user_role_id])) {
        continue;
      }

      $user_role = $user_roles[$user_role_id];
      $permissions = $user_role->getPermissions();
      $table_rows[] = (object) [
        'role_name' => $user_role->label(),
        'machine_name' => $user_role->id(),
        'weight' => $user_role->getWeight(),
        'administrator' => $user_role->isAdmin() ? 'Yes' : 'No',
        'permission_count' => $user_role->isAdmin() ? 'All' : count($permissions),
        'permissions' => $user_role->isAdmin() ? 'All permissions' : ($permissions ? implode(', ', $permissions) : 'None'),
      ];
    }

    return $table_rows;
  }

}
