<?php
namespace Drupal\rest_output\ApiResponse;

use Drupal\Core\StringTranslation\StringTranslationTrait;

class ApiBase implements ApiResponseInterface {
  use StringTranslationTrait;

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
  protected string $message = 'Client error';

  /**
   * @var int $errorCode.
   */
  protected int $errorCode = 4001;

  public function getStatusCode():int {
    return $this->statusCode;
  }

  public function getMessage():string {
    return $this->t($this->message);
  }

  public function getErrorCode():int {
    return $this->errorCode;
  }

  public function getSuccess():bool {
    return $this->success;
  }

  public function getFormat($msg = '', $data = []) {
    return [
      "success" => $this->getSuccess(),
      "errorCode" => $this->getErrorCode(),
      "message" => $msg ?? $this->getMessage(),
      "data" => $data
    ];
  }
}
