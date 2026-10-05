<?php

namespace Drupal\ddna;

/**
 * Interface for seed plugins.
 */
interface SeedInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
