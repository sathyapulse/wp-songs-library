<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/sathyapulse
 * @since      1.0.0
 *
 * @package    Wp_Songs_Library
 * @subpackage Wp_Songs_Library/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Songs_Library
 * @subpackage Wp_Songs_Library/includes
 * @author     Sathiyamoorthy <sathyapulse@gmail.com>
 */
class Wp_Songs_Library_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		Wp_Songs_Library_Custom_Table::create_custom_tables();
	}
}
