<?php

namespace Drupal\rest_output\EventSubscriber;

use Drupal\Core\Http\Exception\CacheableAccessDeniedHttpException;
use Drupal\rest_output\ApiHelper;
use Drupal\rest_output\Responder\SerializeResponder;
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
      $format = $_GET['_format'] ?? 'json';

      // parse response.
      $res = \Drupal::service('serializer')
        ->deserialize($event->getResponse()->getContent(), 'array', $format);

      if (!$this->exception && (!isset($res['success']) || !isset($res['errorCode']) || (!isset($res['message'])))) {
        return $event->setResponse($this->apiSuccess($res));
      }
    }
  }

  public function onException(ExceptionEvent $event) {
    if ($this->isRestPage() || $this->isJsonApi()){
      $exception = $event->getThrowable();
      $this->exception = true;

      if ($exception instanceof CacheableAccessDeniedHttpException) {
        $res = $this->apiUnauthorized();
      } else {
        $res = $this->apiServerError();
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
