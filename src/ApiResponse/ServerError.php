<?php
namespace Drupal\rest_output\ApiResponse;

class ServerError extends ApiBase implements ApiResponseInterface {

  /**
   * @var bool $success.
   */
  protected bool $success = false;

  /**
   * @var int $statusCode.
   */
  protected int $statusCode = 500;

  /**
   * @var string $message.
   */
  protected string $message = 'System error, please contact the administrator';

  /**
   * system error.
   *
   * @var int
   */
  protected int $errorCode = 4002;
}
