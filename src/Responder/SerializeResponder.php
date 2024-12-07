<?php
namespace Drupal\rest_output\Responder;

use Drupal\rest_output\ApiResponse\ApiResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class SerializeResponder implements ApiResponderInterface {

  private $format;

  public function __construct($format) {
    $this->format = $format;
  }

  public function getResponse(ApiResponseInterface $apiResponse, $msg = NULL, $data = []) {
    $serializer = \Drupal::service('serializer');
    $content = $serializer->serialize($apiResponse->getFormat($msg, $data), $this->format);
    return new Response($content, $apiResponse->getStatusCode());
  }
}
