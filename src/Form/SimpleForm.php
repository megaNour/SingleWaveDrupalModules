<?php

  namespace Drupal\rest_client_nour\Form;

  use Drupal\Core\Form\FormBase;
  use Drupal\Core\Form\FormStateInterface;
  use Drupal\rest_client_nour\Http\CustomGuzzleHttp;

  /**
   * Implements the SimpleForm form controller.
   *
   * This example demonstrates a simple form with a singe text input element. We
   * extend FormBase which is the simplest form base class used in Drupal.
   *
   * @see FormBase
   */
  class SimpleForm extends FormBase {

    /**
     * Build the simple form.
     *
     * A build form method constructs an array that defines how markup and
     * other form elements are included in an HTML form.
     *
     * @param array $form
     *   Default form array structure.
     * @param FormStateInterface $form_state
     *   Object containing current form state.
     *
     * @return array
     *   The render array defining the elements of the form.
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

      $form['login'] = [
        '#type' => 'textfield',
        '#title' => $this->t('login'),
        '#description' => $this->t('le login utilisateur'),
        '#required' => TRUE,
      ];
      $form['password'] = [
        '#type' => 'password',
        '#title' => $this->t('password'),
        '#description' => $this->t('le mot de passe utilisateur'),
        '#required' => TRUE,
      ];

      // Group submit handlers in an actions element with a key of "actions" so
      // that it gets styled correctly, and so that other modules may add actions
      // to the form. This is not required, but is convention.
      $form['actions'] = [
        '#type' => 'actions',
      ];

      // Add a submit button that handles the submission of the form.
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('connexion'),
      ];

      return $form;
    }

    /**
     * Getter method for Form ID.
     *
     * The form ID is used in implementations of hook_form_alter() to allow other
     * modules to alter the render array built by this form controller.  it must
     * be unique site wide. It normally starts with the providing module's name.
     *
     * @return string
     *   The unique ID of the form defined by this class.
     */
    public function getFormId() {
      return 'rest_client_nour_connexion_form';
    }

    /**
     * Implements form validation.
     *
     * The validateForm method is the default method called to validate input on
     * a form.
     *
     * @param array $form
     *   The render array of the currently built form.
     * @param FormStateInterface $form_state
     *   Object describing the current state of the form.
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
      $login = $form_state->getValue('login');
      if (strlen($login) < 5) {
        // Set an error for the form element with a key of "title".
        $form_state->setErrorByName('login', $this->t("message login non valide (trop court)"));
      }
      $password = $form_state->getValue('password');
      if (strlen($password) < 8) {
        $form_state->setErrorByName("password", $this->t("mot de passe non valide (trop court)"));
      }
    }

    /**
     * Implements a form submit handler.
     *
     * The submitForm method is the default method called for any submit elements.
     *
     * @param array $form
     *   The render array of the currently built form.
     * @param FormStateInterface $form_state
     *   Object describing the current state of the form.
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      /*
       * This would normally be replaced by code that actually does something
       * with the title.
       */
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

  }
  