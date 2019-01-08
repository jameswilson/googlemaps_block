<?php

namespace Drupal\googlemaps_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Zend\Escaper\Escaper;

/**
 * Provides a 'Google Maps' Block.
 *
 * @Block(
 *   id = "googlemaps_block",
 *   admin_label = @Translation("Embed a custom map with a marker using Google Maps Javascript API."),
 *   category = @Translation("Google Maps"),
 * )
 */
class GoogleMapsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'api_key' => '',
      'height' => '400px',
      'width' => '100%',
      'zoom' => 17,
      'min_zoom' => 7,
      'max_zoom' => 19,
      'lat' => '',
      'lng' => '',
      'info_window_title' => '',
      'info_window_description' => ['value' => '', 'format' => filter_default_format()],
      'info_window_visible_on_load' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Google Cloud API key'),
      '#description' => $this->t('The Google Maps Javascript API requires an API key to work. Valid billing information and credit card info are required to use the Javascript API, though typical usage does not cost anything.'),
      '#default_value' => $this->configuration['api_key'],
    ];

    $form['height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Height'),
      '#description' => $this->t('The height of the map on the page. Eg "400px" or "100%".'),
      '#default_value' => $this->configuration['height'],
    ];

    $form['width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Width'),
      '#description' => $this->t('The width of the map on the page. Use the default value of 100% to inherit the parent element‘s width.'),
      '#default_value' => $this->configuration['width'],
    ];

    $form['zoom'] = [
      '#type' => 'number',
      '#title' => $this->t('Default zoom'),
      '#description' => $this->t('The zoom level to use when the map loads. Should be a number between 0 and 20 (where 20 is zoomed into the max, and 0 is zoomed out to the max)'),
      '#default_value' => $this->configuration['zoom'],
    ];

    $form['min_zoom'] = [
      '#type' => 'number',
      '#title' => $this->t('Minimum zoom'),
      '#description' => $this->t('The minimum zoom out level to allow.'),
      '#default_value' => $this->configuration['min_zoom'],
    ];

    $form['max_zoom'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum zoom'),
      '#description' => $this->t('The maximum zoom in level to allow.'),
      '#default_value' => $this->configuration['max_zoom'],
    ];

    $form['lat'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Map marker latitude'),
      '#description' => $this->t('The decimal coordinate where the map should be centered.'),
      '#default_value' => $this->configuration['lat'],
    ];

    $form['lng'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Map marker longitude'),
      '#description' => $this->t('The decimal coordinate where the map should be centered.'),
      '#default_value' => $this->configuration['lng'],
    ];

    $form['info_window_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->configuration['info_window_title'],
      '#description' => $this->t('The map marker title, also used for the popup info window title.'),
    ];

    $form['info_window_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Body'),
      '#default_value' => $this->configuration['info_window_description']['value'],
      '#rows' => 4,
      '#format' => $this->configuration['info_window_description']['format'],
      '#description' => $this->t('Description for the popup info window. Leave blank to disable the popup.'),
    ];

    $form['info_window_visible_on_load'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show info window on load'),
      '#description' => $this->t('Leave unchecked to require a click on the map marker to load the info window.'),
      '#default_value' => $this->configuration['info_window_visible_on_load'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    foreach ($this->defaultConfiguration() as $key => $default_value) {
      $this->configuration[$key] = $form_state->getValue($key);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $escaper = new Escaper();
    return [
      '#theme' => 'googlemaps_block',
      '#api_key' => urlencode($this->configuration['api_key']),
      '#height' => $this->configuration['height'],
      '#width' => $this->configuration['width'],
      '#zoom' => $this->configuration['zoom'],
      '#min_zoom' => $this->configuration['min_zoom'],
      '#max_zoom' => $this->configuration['max_zoom'],
      '#lat' => $this->configuration['lat'],
      '#lng' => $this->configuration['lng'],
      '#info_window_title' => $escaper->escapeJs($this->configuration['info_window_title']),
      '#info_window_description' => $escaper->escapeJs(check_markup(
        $this->configuration['info_window_description']['value'],
        $this->configuration['info_window_description']['format']
      )),
      '#info_window_visible_on_load' => (bool) $this->configuration['info_window_visible_on_load'],
    ];
  }

}
