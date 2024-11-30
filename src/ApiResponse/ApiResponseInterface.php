<?php

namespace Drupal\rest_output\ApiResponse;

/**
 * Defines an interface for Sms plugin plugins.
 */
interface ApiResponseInterface {

  // Add get/set methods for your plugin type here.
  public function getStatusCode():int;

  public function getMessage():string;

  public function getErrorCode():int;

  public function getSuccess():bool;
}
