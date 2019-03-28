<?php

namespace Drupal\natal\Plugin\Block; // hello_world = natal

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Natal' Block.
 *
 * @Block(
 *   id = "natal_block",
 *   admin_label = @Translation("Natal block"),
 *   category = @Translation("Natal"),
 * )
 */
class NatalBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $default_config = \Drupal::config('natal.settings');
    return [
      'natal_block_name' => $default_config->get('natal.name'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['natal_block_name'])) {
      $name = $config['natal_block_name'];
    }
    else {
      $name = $this->t('to no one');
    }
    return array(
      '#markup' => $this->t('Hello @name!', array(
        '@name' => $name,
      )),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['natal_block_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => isset($config['natal_block_name']) ? $config['natal_block_name'] : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['natal_block_name'] = $form_state->getValue('natal_block_name');
  }


}