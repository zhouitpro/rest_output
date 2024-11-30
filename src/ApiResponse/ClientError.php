<?php
namespace Drupal\rest_output\ApiResponse;

class ClientError extends ApiBase implements ApiResponseInterface {

  /**
   * @var bool $success.
   */
  protected bool $success = false;

  /**
   * @var int $statusCode.
   */
  protected int $statusCode = 400;

  /**
   * @var string $message.
   */
  protected string $message = 'Client error';

  /**
   * @var int $errorCode.
   */
  protected int $errorCode = 4001;

}
