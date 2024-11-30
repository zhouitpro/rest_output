<?php
namespace Drupal\rest_output\Responder;

use Drupal\rest\ResourceResponse;

class ResourceResponder implements ApiResponderInterface {

  public function getResponse($apiResponse, $msg = NULL, $data = [])
  {
    $build = array(
      '#cache' => array(
        'max-age' => 0,
      ),
    );
    return (new ResourceResponse($apiResponse->getFormat($msg, $data), $apiResponse->getStatusCode()))
      ->addCacheableDependency($build);
  }
}
