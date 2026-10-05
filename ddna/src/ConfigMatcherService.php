<?php

namespace Drupal\ddna;

use Drupal\Core\Config\StorageInterface;

/**
 * Manages plugins for configuration translation mappers.
 */
class ConfigMatcherService {

  /**
   * The config storage.
   *
   * @var \Drupal\Core\Config\StorageInterface
   */
  protected $configStorage;

  /**
   * Cached configuration names.
   *
   * @var string[]
   */
  protected array $config = [];

  /**
   * {@inheritdoc}
   */
  public function __construct(StorageInterface $storage) {
    $this->configStorage = $storage;
  }

  /**
   * Returns the names of configurations matching a regular expression.
   *
   * @param string $regexp
   *   The regular expression to match against configuration names.
   *
   * @return string[]
   *   The matching configuration names.
   */
  public function matchAllConfigs(string $regexp): array {
    $configs = [];
    foreach ($this->getAllConfigs() as $config) {
      if (preg_match($regexp, $config)) {
        $configs[] = $config;
      }
    }

    return $configs;
  }

  /**
   * Returns all configuration names.
   *
   * @return string[]
   *   The configuration names.
   */
  private function getAllConfigs(): array {
    if (empty($this->config)) {
      $this->config = $this->configStorage->listAll();
    }

    return $this->config;
  }

}
