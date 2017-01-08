<?php

/**
 * Class Wp_Songs_Library_Custom_Table
 */
class Wp_Songs_Library_Custom_Table {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function register_custom_tables() {
		global $wpdb;

		$wpdb->albummeta = $wpdb->prefix . 'albummeta';
	}

	/**
	 * Creates the custom tables.
	 */
	public static function create_custom_tables() {
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