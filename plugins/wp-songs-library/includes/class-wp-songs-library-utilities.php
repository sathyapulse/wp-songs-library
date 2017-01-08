<?php

/**
 * Class Wp_Songs_Library_Utilities
 */
class Wp_Songs_Library_Utilities {
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

	public function add_album_meta( $post_id, $meta_key, $meta_value, $unique = false ) {
		return add_metadata( 'album', $post_id, $meta_key, $meta_value, $unique );
	}

	public function update_album_meta() {

	}

	public function get_album_meta( $post_id, $meta_key = '', $single = false ) {
		return get_metadata( 'album', $post_id, $meta_key, $single );
	}

	public function delete_album_meta() {

	}
}