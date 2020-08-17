<?php
/**
 * The `Button Widget` bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * Button Widget is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * @link                    https://www.mypreview.one
 * @since                   1.2.1
 * @package                 button-widget
 * @author                  MyPreview (Github: @mahdiyazdani, @mypreview)
 * @copyright               © 2015 - 2020 MyPreview. All Rights Reserved.
 *
 * @wordpress-plugin
 * Plugin Name:             Button Widget
 * Plugin URI:              https://www.mypreview.one
 * Description:             A simple customizable button widget for your sidebars to allow users take actions, and make choices, with a single tap.
 * Version:                 1.2.1
 * Author:                  MyPreview
 * Author URI:              https://mahdiyazdani.com
 * License:                 GPL-3.0
 * License URI:             http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:             button-widget
 * Domain Path:             /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	wp_die();
}

/**
 * Gets the path to a plugin file or directory.
 *
 * @see     https://codex.wordpress.org/Function_Reference/plugin_basename
 * @see     http://php.net/manual/en/language.constants.predefined.php
 */
$button_widget_plugin_data = get_file_data(
	__FILE__,
	array(
		'author_uri' => 'Author URI',
		'version'    => 'Version',
	),
	'plugin'
);
define( 'BUTTON_WIDGET_VERSION', $button_widget_plugin_data['version'] );
define( 'BUTTON_WIDGET_AUTHOR_URI', $button_widget_plugin_data['author_uri'] );
define( 'BUTTON_WIDGET_SLUG', 'button-widget' );
define( 'BUTTON_WIDGET_FILE', __FILE__ );
define( 'BUTTON_WIDGET_BASENAME', basename( BUTTON_WIDGET_FILE ) );
define( 'BUTTON_WIDGET_PLUGIN_BASENAME', plugin_basename( BUTTON_WIDGET_FILE ) );
define( 'BUTTON_WIDGET_DIR_URL', plugin_dir_url( BUTTON_WIDGET_FILE ) );
define( 'BUTTON_WIDGET_DIR_PATH', plugin_dir_path( BUTTON_WIDGET_FILE ) );

if ( ! class_exists( 'Button_Widget' ) ) :

	/**
	 * The Button Widget - Class
	 */
	final class Button_Widget {

		/**
		 * Instance of the class.
		 *
		 * @var  object   $instance
		 */
		private static $instance = null;

		/**
		 * Main `Button_Widget` instance
		 * Ensures only one instance of `Button_Widget` is loaded or can be loaded.
		 *
		 * @access  public
		 * @return  instance
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Setup class.
		 *
		 * @access  protected
		 * @return  void
		 */
		protected function __construct() {
			add_action( 'init', array( $this, 'textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'widgets_init', array( $this, 'register_widget' ) );
			add_filter( sprintf( 'plugin_action_links_%s', BUTTON_WIDGET_PLUGIN_BASENAME ), array( $this, 'additional_links' ) );
		}

		/**
		 * Cloning instances of this class is forbidden.
		 *
		 * @access  protected
		 * @return  void
		 */
		protected function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html_x( 'Cloning instances of this class is forbidden.', 'clone', 'button-widget' ), esc_html( BUTTON_WIDGET_VERSION ) );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @access  public
		 * @return  void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html_x( 'Unserializing instances of this class is forbidden.', 'wakeup', 'button-widget' ), esc_html( BUTTON_WIDGET_VERSION ) );
		}

		/**
		 * Load languages file and text domains.
		 * Define the internationalization functionality.
		 *
		 * @access  public
		 * @return  void
		 */
		public function textdomain() {
			load_plugin_textdomain( 'button-widget', false, dirname( dirname( BUTTON_WIDGET_PLUGIN_BASENAME ) ) . '/languages/' );
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @access  public
		 * @return  void
		 */
		public function enqueue() {
			global $pagenow;

			$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_register_style( sprintf( '%s-style', BUTTON_WIDGET_SLUG ), sprintf( '%sassets/css/style%s.css', BUTTON_WIDGET_DIR_URL, $min ), array( 'wp-color-picker' ), BUTTON_WIDGET_VERSION, 'screen' );
			wp_register_script( sprintf( '%s-script', BUTTON_WIDGET_SLUG ), sprintf( '%sassets/js/script%s.js', BUTTON_WIDGET_DIR_URL, $min ), array( 'jquery', 'wp-color-picker' ), BUTTON_WIDGET_VERSION, true );

			// Enqueue admin scrips and styles, only in the customizer or the old widgets page.
			if ( is_customize_preview() || 'widgets.php' === $pagenow ) {
				wp_enqueue_style( sprintf( '%s-style', BUTTON_WIDGET_SLUG ) );
				wp_enqueue_script( sprintf( '%s-script', BUTTON_WIDGET_SLUG ) );
			}
		}

		/**
		 * Registers all custom and built-in widgets right after all default
		 * WordPress widgets have been registered.
		 *
		 * @access  public
		 * @return  void
		 */
		public function register_widget() {
			require_once sprintf( '%sbutton-widget-register.php', BUTTON_WIDGET_DIR_PATH );
			register_widget( 'Button_Widget_Register' );
		}

		/**
		 * Display additional links in plugins table page.
		 * Filters the list of action links displayed for a specific plugin in the Plugins list table.
		 *
		 * @access  public
		 * @param   array $links  An array of plugin action links.
		 * @return  array
		 */
		public function additional_links( $links ) {
			$plugin_links = array();
			/* translators: 1: Open anchor tag, 2: Close anchor tag. */
			$plugin_links[] = sprintf( _x( '%1$sHire Me!%2$s', 'plugin link', 'button-widget' ), sprintf( '<a href="%s" class="button-link-delete" target="_blank" rel="noopener noreferrer nofollow" title="%s">', esc_url( BUTTON_WIDGET_AUTHOR_URI ), esc_attr_x( 'Looking for help? Hire Me!', 'upsell', 'button-widget' ) ), '</a>' );
			/* translators: 1: Open anchor tag, 2: Close anchor tag. */
			$plugin_links[] = sprintf( _x( '%1$sSupport%2$s', 'plugin link', 'button-widget' ), '<a href="https://wordpress.org/support/plugin/button-widget" target="_blank" rel="noopener noreferrer nofollow">', '</a>' );

			return array_merge( $plugin_links, $links );
		}

	}
endif;

if ( ! function_exists( 'button_widget_init' ) ) :

	/**
	 * Returns the main instance of Button_Widget to prevent the need to use globals.
	 *
	 * @return  object(class)   Button_Widget::instance
	 */
	function button_widget_init() {
		return Button_Widget::instance();
	}

	button_widget_init();
endif;
