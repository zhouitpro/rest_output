<?php

namespace Drupal\rest_output\EventSubscriber;

use Drupal\rest_output\ApiHelper;
use Drupal\rest_output\ApiResponse\Successful;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RestResponseFilterSubscriber.
 */
class RestResponseFilterSubscriber implements EventSubscriberInterface {

  use ApiHelper;

  private $exception = false;

  public function onRespose(ResponseEvent $event) {
    if ($this->isRestPage() || $this->isJsonApi()) {
      $res = json_decode($event->getResponse()->getContent(), 1);
      if (!$this->exception && (!isset($res['success']) || !isset($res['errorCode']) || (!isset($res['message'])))) {
        return $event->setResponse($this->jsonResponse(new Successful(), NULL, $res));
      }
    }
  }

  public function onException(ExceptionEvent $event) {
    if ($this->isRestPage() || $this->isJsonApi()){
      $exception = $event->getThrowable();
      $this->exception = true;
      if (!method_exists($exception, 'getCode')) {
        $res = $this->apiServerError();
      } else {
        switch ($exception->getCode()) {
          case 403:
            $res = $this->apiUnauthorized();
            break;
          case 404:
            $res = $this->apiDataNotFound();
            break;
          case 500:
          default:
            $res = $this->apiServerError();
            break;
        }
      }

      return $event->setResponse($res);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'onRespose',
      KernelEvents::EXCEPTION => 'onException'
    ];
  }

}
