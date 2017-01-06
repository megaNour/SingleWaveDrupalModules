<?php

  namespace Drupal\rest_client_nour\Http;

  use Drupal\Core\StringTranslation\StringTranslationTrait;
  use GuzzleHttp\Client;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Psr7\Request;

  /**
   * Get a response code from any URL using Guzzle in Drupal 8!
   * 
   * Usage: 
   * In the head of your document:
   * 
   * use Drupal\custom_guzzle_request\Http\CustomGuzzleHttp;
   * 
   * In the area you want to return the result, using any URL for $url:
   *
   * $check = new CustomGuzzleHttp();
   * $response = $check->performRequest($url);
   *  
   * */
  class CustomGuzzleHttp {

    use StringTranslationTrait;

    private $siteUrl;

    public function __construct() {
      $this->siteUrl = "192.168.4.82:8080/RestAdapter/resources/connexion";
    }

    public function performRequest() {
      $client = new Client();
      $url = $this->siteUrl . "/megaNour";
      try {
        $res = $client->get($url, ['http_errors' => false]);
        return($res->getStatusCode());
      } catch (RequestException $e) {
        return($this->t('Error: ' . e));
      }
    }

    public function connect($login, $password) {
      $result = false;
      $client = new Client();
      $url = $this->siteUrl . "/post";
      try {
        $response = $client->request('POST', $url, [
          "json" => [
            "login" => $login,
            "password" => $password,
          ],
        ]);
        return $response->getBody();
      } catch (Exception $ex) {
        return($this->t("Error: " . e));
      }
    }

    public function upload($login, $folder, $files) {
      $result = false;
      $client = new Client();
      $url = $this->siteUrl . "/upload";
      $multipart = $this->createMultipartBody($login, $folder, $files);
      try {
        $response = $client->request('POST', $url, $multipart);
        return $response->getBody();
      } catch (Exception $ex) {
        return($this->t("Error: " . e));
      }
    }

    public function createMultipartBody($login, $folder, $files) {
      $multipart = [
            'multipart' => [
              [
                'login' => $login,
                'folder' => $folder
              ],
            ]
      ];
      
      $chunks = array_chunk($files, 1);
      foreach ($chunks as $file) {
        var_dump($file);
      }
      die;
    }

  }
  