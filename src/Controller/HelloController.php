<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\PizzaController.
 */
namespace Drupal\rest_client_nour\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\rest_client_nour\Http\CustomGuzzleHttp;

class HelloController extends ControllerBase {
  public function content() {
    $guzzle = new CustomGuzzleHttp;
    $guzzle->performRequest();
//    return array(
//      '#type' => 'markup',
//      '#markup' => $this->t('Hello, World!'),
//    );
  }
}
