<?php

declare(strict_types=1);

namespace Drupal\rest_output\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest_output\ApiHelper;
use Drupal\rest_output\Responder\JsonResponder;
use Drupal\rest_output\Responder\ResourceResponder;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Represents TestApi records as resources.
 *
 * @RestResource (
 *   id = "rest_output_testapi",
 *   label = @Translation("TestApi"),
 *   uri_paths = {
 *     "canonical" = "/api/testapi"
 *   }
 * )
 *
 * For entities, it is recommended to use REST resource plugin provided by
 * Drupal core.
 * @see \Drupal\rest\Plugin\rest\resource\EntityResource
 */
final class TestapiResource extends ResourceBase {
  use ApiHelper;

  /**
   * Responds to GET requests.
   */
  public function get() {
    $data = [
      'userid' => 1,
      'username' => 'xiukunabcd'
    ];
    \Drupal::entityTypeManager()->getStorage('abcd');
    return new JsonResponse($data);

    $response = $this->apiSuccess($data);
    $response->send();

    //先输出内容. 后面用于写入日志啊这种不需要响应给用户的处理
    sleep(20);
    file_put_contents('test.txt', 'test');
  }
}
