<?php

namespace Drupal\rest_client_nour\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a "rest_client" block
 * 
 * @Block(
 *   id = "rest_block",
 *   admin_label = @Translation("rest blockz"),
 * )
 */
class RestBlock extends BlockBase implements BlockPluginInterface {

    /**
     * {@inheritdoc}
     */
    public function build() {
        $config = $this->getConfiguration();
        if (!empty($config["url"])) {
            $url = $config["url"];
        }
        else {
            $url = $this->t("www.singlewave.com/url/de/wildfly/rest/adapter");
        }
        return array(
            "#plain_text" => $this->t("prefix/"),
            "#markup" => $this->t("Checking @url#!", array(
                "@url" =>$url,
            )),
            "#suffix" => $this->t("suffix/"),
            "#otherMark" => "this is another markup by Nour !",
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        parent::blockForm($form, $form_state);
        
        $config = $this->getConfiguration();
        
        $form["rest_block_url"] = array (
            "#type" => "textfield",
            "#title" => $this->t("url"),
            "#description" => $this->t("which url do you want to try"),
            "#default_value" => isset($config["url"]) ? $config["url"] . " hihouu" : "",
        );
        
        return $form;
    }
    
    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        //parent::blockSubmit($form, $form_state);
        $this->setConfigurationValue("url", $form_state->getValue("rest_block_url"));
    }
    
    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        //parent::defaultConfiguration();
        $default_config = Drupal::config("rest_client_nour.settings");
        
        //\Drupal::logger("RestBlock")->notice("valeur de rest.url: " . $default_config->get("rest.url") . " ## " .$default_config->getRawData()["rest"]["url"]);
        return array(
            "url" => $default_config->get("rest.url") . " hihou"
        );
    }
}
