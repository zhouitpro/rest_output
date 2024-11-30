<?php
namespace Drupal\rest_output\Responder;

use Drupal\rest_output\ApiResponse\ApiResponseInterface;

interface ApiResponderInterface {

  public function getResponse(ApiResponseInterface $apiResponse, $msg = NULL, $data = []);
}
