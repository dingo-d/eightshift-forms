<?php
/**
 * The Forms specific functionality.
 *
 * @package Eightshift_Forms\Admin
 */

namespace Eightshift_Forms\Admin;

use Eightshift_Libs\Core\Service;

/**
 * Class Forms
 */
class Forms implements Service {

  /**
   * Post type slug costant.
   *
   * @var string
   */
  const POST_TYPE_SLUG = 'eightshift-forms';

  /**
   * Browser url slug constant.
   *
   * @var string
   */
  const URL_SLUG = 'eightshift-forms';

  /**
   * Rest API Endpoint slug costant.
   *
   * @var string
   */
  const REST_API_ENDPOINT_SLUG = 'eightshift-forms';

  /**
   * Location of menu in sidebar.
   *
   * @var string
   */
  const MENU_POSITION = 50;

  /**
   * Set menu icon.
   *
   * @var string
   */
  const MENU_ICON = 'dashicons-media-document';

  /**
   * Register all the hooks
   */
  public function register() {
    add_action( 'init', [ $this, 'register_post_type' ] );
  }

  /**
   * Register custom post type
   *
   * @return void
   */
  public function register_post_type() {

    $template = [
      ['eightshift-forms/form', []],
    ];

    $args = array(
      'label'              => esc_html( 'Eightshift Forms', 'eightshift-forms' ),
      'public'             => true,
      'menu_position'      => static::MENU_POSITION,
      'menu_icon'          => static::MENU_ICON,
      'supports'           => array( 'title', 'editor', 'thumbnail' ),
      'has_archive'        => false,
      'show_in_rest'       => true,
      'publicly_queryable' => true,
      'can_export'         => true,
      'capability_type'    => 'page',
      'rest_base'          => static::REST_API_ENDPOINT_SLUG,
      'template'           => $template,
    );

    register_post_type( static::POST_TYPE_SLUG, $args );
  }
}
