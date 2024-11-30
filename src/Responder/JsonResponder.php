<?php
namespace Drupal\rest_output\Responder;

use Drupal\rest_output\ApiResponse\ApiResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonResponder implements ApiResponderInterface {

  public function getResponse(ApiResponseInterface $apiResponse, $msg = NULL, $data = []) {
    return new JsonResponse($apiResponse->getFormat($msg, $data), $apiResponse->getStatusCode());
  }
}
