<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/sathyapulse
 * @since      1.0.0
 *
 * @package    Wp_Songs_Library
 * @subpackage Wp_Songs_Library/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Songs_Library
 * @subpackage Wp_Songs_Library/includes
 * @author     Sathiyamoorthy <sathyapulse@gmail.com>
 */
class Wp_Songs_Library_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-songs-library',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
