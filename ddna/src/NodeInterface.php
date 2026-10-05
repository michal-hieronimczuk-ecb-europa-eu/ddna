<?php

namespace Drupal\ddna;

/**
 * Interface for node plugins.
 */
interface NodeInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
