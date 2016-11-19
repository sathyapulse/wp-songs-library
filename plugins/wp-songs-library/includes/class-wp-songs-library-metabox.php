<?php

/**
 * Class Wp_Songs_Library_Metabox
 */
class Wp_Songs_Library_Metabox {
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

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function register_album_metaboxes() {
		add_meta_box(
			'wsl-album-year',
			esc_html__( 'Album year', 'wp-songs-library' ),
			[ $this, 'build_album_year_metabox' ],
			'album',
			'normal',
			'default'
		);
	}

	public function build_album_year_metabox() {

	}

	public function register_song_metaboxes() {
		add_meta_box(
			'wsl-song-year',
			esc_html__( 'Song year', 'wp-songs-library' ),
			[ $this, 'build_song_year_metabox' ],
			'song',
			'normal',
			'default'
		);
	}

	public function build_song_year_metabox() {

	}
}
