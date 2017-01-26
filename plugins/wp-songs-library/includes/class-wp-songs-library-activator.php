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
		self::create_custom_table();
	}

	private function create_custom_table() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'albummeta';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			meta_id bigint(20) NOT NULL AUTO_INCREMENT,
			album_id bigint(20) DEFAULT 0 NOT NULL,
			meta_key varchar(255),
			meta_value longtext,
			PRIMARY KEY (meta_id),
			INDEX (album_id),
			INDEX (meta_key)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
