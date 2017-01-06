<?php

  namespace Drupal\rest_client_nour\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\rest_client_nour\Http\CustomGuzzleHttp;
use function drupal_set_message;

  class UploadMultipleForm extends FormBase {

    public function getFormId() {
      return 'form_upload_multiple';
    }

    protected function getEditableConfigNames() {
      return 'upload_multiple.settings';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
      $config = $this->config('upload_multiple.settings');

      $form['dossier'] = [
        '#type' => 'textfield',
        '#title' => $this->t('dossier'),
        '#description' => $this->t('le dossier dans lequel vous souhaitez sauver l\'image'),
      ];
      //File
      $form['upload_multiple'] = array(
        '#type' => 'file',
        '#title' => $this->t('Upload Image'),
        '#description' => $this->t('Liste des fichiers autorisés : png, jpeg, jpg, jpe, gif'),
        '#multiple' => TRUE
      );

      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Save'),
        '#button_type' => 'primary',
      );

      return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
      $config = Drupal::service('config.factory')->getEditable('upload_multiple.settings');
      $guzzle = new CustomGuzzleHttp();
      $login = $form_state->getValue('login');
      $password = $form_state->getValue("password");
      $resultat = $guzzle->connect($login, $password);
      drupal_set_message(t('login:%login password:%password, resultat:%resultat', [
        '%login' => $login,
        "%password" => $password,
        "%resultat" => $resultat,
      ]));
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
      $files = $_FILES['files']['name']['upload_multiple'];
      var_dump($files); die;
      $this->validFile($file);
      //$file->get('langcode')->value;
    }

    private function validFile($file) {
      if ($file == "") {
        drupal_set_message($message = 'Ce champ ne peut pas etre vide.', $type = 'error', $repeat = FALSE);
      } else {
        file_save_upload(
            'upload_multiple', array(
          'file_validate_is_image' => array(), // Validates file is really an image.
          'file_validate_extensions' => array('png gif jpg jpeg'), // Validate extensions.
            ), $this->path()
        );
        drupal_set_message($this->t('L\'upload d\'image s\'est déroulé correctement.'));
      }
    }

    private function path() {
      return $path = "public://";
    }

  }
  