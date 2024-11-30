<?php

namespace Drupal\rest_output;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\rest_output\ApiResponse\ApiResponseInterface;
use Drupal\rest_output\ApiResponse\ClientError;
use Drupal\rest_output\ApiResponse\ServerError;
use Drupal\rest_output\ApiResponse\Successful;
use Drupal\rest_output\ApiResponse\Unauthorized;
use Drupal\rest\ResourceResponse;
use Drupal\rest_output\Responder\ApiResponderInterface;
use Drupal\rest_output\Responder\JsonResponder;
use Symfony\Component\HttpFoundation\Response;

trait ApiHelper {

  use StringTranslationTrait;

  private $responder = NULL;

  public function getResponder() {
    return  $this->responder;
  }

  public function setResponder(ApiResponderInterface $responder) :self {
    $this->responder = $responder;
    return $this;
  }

  /**
   * check current response is json api.
   *
   * @return bool
   */
  public function isJsonApi(): bool {
    $route = \Drupal::routeMatch()->getRouteObject();
    return $route && $route->hasDefault('_is_jsonapi');
  }

  /**
   * check current response is rest api.
   *
   * @return bool
   */
  public function isRestPage(): bool {
    $route = \Drupal::routeMatch()->getRouteObject();
    return $route && $route->hasDefault('_rest_resource_config');
  }

  /**
   * return reuest fail.
   *
   * @param null $msg
   * @return ResourceResponse
   */
  public function apiRequestFail($msg = NULL): Response {
   return $this->responseData(new ClientError(), $msg);
  }

  /**
   * return data not found.
   *
   * @param null $msg
   * @return ResourceResponse
   */
  public function apiDataNotFound($msg = NULL): Response {
    if (!$msg) {
      $msg = $this->t('Data does not exist');
    }
    return $this->responseData(new ClientError(), $msg);
  }

  /**
   * miss parameter.
   *
   * @param null $msg
   * @return ResourceResponse
   */
  public function apiMissingParameter($msg = NULL): Response {
    if (!$msg) {
      $msg = $this->t('Missing parameter');
    }
    return $this->apiClientError($msg);
  }

  /**
   * return success.
   *
   * @param array $data
   * @param null $msg
   * @return ResourceResponse
   */
  public function apiSuccess($data = [], $msg = NULL): Response {
    return $this->responseData(new Successful(), $msg, $data);
  }

  /**
   * return server error.
   *
   * @return ResourceResponse
   */
  public function apiServerError($msg = NULL): Response {
    return $this->responseData(new ServerError(), $msg, []);
  }

  /**
   * return 403
   *
   * @return ResourceResponse
   */
  public function apiUnauthorized(): ResourceResponse  {
    return $this->responseData(new Unauthorized(), NULL, [
      'user_is_login' => (!\Drupal::currentUser()->isAnonymous())
    ]);
  }

  /**
   * return client error.
   *
   * @return ResourceResponse
   */
  public function apiClientError(): ResourceResponse {
    return $this->responseData(new ClientError());
  }

  /**
   * @param ApiResponseInterface $apiResponse
   * @param null $msg
   * @param array $data
   * @return mixed
   */
  public function responseData(ApiResponseInterface $apiResponse, $msg = NULL, $data = []) {
    if (!$this->getResponder()) {
      $this->setResponder(new JsonResponder());
    }

    return $this->getResponder()->getResponse($apiResponse, $msg, $data);
  }
}
