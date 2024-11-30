<?php
namespace Drupal\rest_output\ApiResponse;

class Successful extends ApiBase implements ApiResponseInterface {

  /**
   * @var bool $success.
   */
  protected bool $success = true;

  /**
   * @var int $statusCode.
   */
  protected int $statusCode = 200;

  /**
   * @var string $message.
   */
  protected string $message = 'OK';

  /**
   * @var int $errorCode.
   */
  protected int $errorCode = 4000;
}
