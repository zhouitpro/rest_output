<?php
namespace Drupal\rest_output\ApiResponse;

class Unauthorized  extends ApiBase  implements ApiResponseInterface {

  /**
   * @var bool $success.
   */
  protected bool $success = false;

  /**
   * @var int $statusCode.
   */
  protected int $statusCode = 403;

  /**
   * @var string $message.
   */
  protected string $message = 'Forbidden';

  /**
   * @var int $errorCode.
   */
  protected int $errorCode = 4003;
}
