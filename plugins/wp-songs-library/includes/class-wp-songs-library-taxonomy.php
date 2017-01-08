<?php

/**
 * Class Wp_Songs_Library_Taxonomy
 */
class Wp_Songs_Library_Taxonomy extends Wp_Songs_Library_Utilities {
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

	public function register_album_taxonomy() {
		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'                       => _x( 'Albums', 'taxonomy general name', 'wp-songs-library' ),
			'singular_name'              => _x( 'Album', 'taxonomy singular name', 'wp-songs-library' ),
			'search_items'               => __( 'Search Albums', 'wp-songs-library' ),
			'popular_items'              => __( 'Popular Albums', 'wp-songs-library' ),
			'all_items'                  => __( 'All Albums', 'wp-songs-library' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Album', 'wp-songs-library' ),
			'update_item'                => __( 'Update Album', 'wp-songs-library' ),
			'add_new_item'               => __( 'Add New Album', 'wp-songs-library' ),
			'new_item_name'              => __( 'New Album Name', 'wp-songs-library' ),
			'separate_items_with_commas' => __( 'Separate albums with commas', 'wp-songs-library' ),
			'add_or_remove_items'        => __( 'Add or remove albums', 'wp-songs-library' ),
			'choose_from_most_used'      => __( 'Choose from the most used albums', 'wp-songs-library' ),
			'not_found'                  => __( 'No albums found.', 'wp-songs-library' ),
			'menu_name'                  => __( 'Albums', 'wp-songs-library' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'album' ),
		);

		register_taxonomy( 'album', 'song', $args );
	}

	public function register_artist_taxonomy() {
		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'                       => _x( 'Artists', 'taxonomy general name', 'wp-songs-library' ),
			'singular_name'              => _x( 'Artist', 'taxonomy singular name', 'wp-songs-library' ),
			'search_items'               => __( 'Search Artists', 'wp-songs-library' ),
			'popular_items'              => __( 'Popular Artists', 'wp-songs-library' ),
			'all_items'                  => __( 'All Artists', 'wp-songs-library' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Artist', 'wp-songs-library' ),
			'update_item'                => __( 'Update Artist', 'wp-songs-library' ),
			'add_new_item'               => __( 'Add New Artist', 'wp-songs-library' ),
			'new_item_name'              => __( 'New Artist Name', 'wp-songs-library' ),
			'separate_items_with_commas' => __( 'Separate artists with commas', 'wp-songs-library' ),
			'add_or_remove_items'        => __( 'Add or remove artist', 'wp-songs-library' ),
			'choose_from_most_used'      => __( 'Choose from the most used artists', 'wp-songs-library' ),
			'not_found'                  => __( 'No artists found.', 'wp-songs-library' ),
			'menu_name'                  => __( 'Artists', 'wp-songs-library' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'artist' ),
		);

		register_taxonomy( 'artist', [ 'song', 'album' ], $args );
	}

	/**
	 * Insert/update taxonomy when a album custom post is saved.
	 *
	 * @param int $post_id The post ID.
	 * @param post $post The post object.
	 * @param bool $update Whether this is an existing post being updated or not.
	 */
	public function insert_album_taxonomy( $post_id, $post, $update ) {
		if ( 'auto-draft' === $post->post_status ||
			'draft' === $post->post_status ||
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
			return;
		}

		if ( $term_id = wpcom_vip_term_exists( $post->post_name ) ) {
			wp_update_term( $term_id, 'album', [
				'name' => $post->post_title,
				'slug' => $post->post_name,
			]);
		} else {
			$term = wp_insert_term( $post->post_title, 'album', [
				'slug' => $post->post_name,
			]);

			$this->add_album_meta( $post_id, 'wsl_album_term_id', $term['term_id'] );
		}
	}

	/**
	 * Insert/update taxonomy when a Artist custom post is saved.
	 *
	 * @param int $post_id The post ID.
	 * @param post $post The post object.
	 * @param bool $update Whether this is an existing post being updated or not.
	 */
	public function insert_artist_taxonomy( $post_id, $post, $update ) {
		if ( 'auto-draft' === $post->post_status ||
			'draft' === $post->post_status ||
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
			return;
		}

		if ( $term_id = wpcom_vip_term_exists( $post->post_name ) ) {
			wp_update_term( $term_id, 'artist', [
				'name' => $post->post_title,
				'slug' => $post->post_name,
			]);
		} else {
			$term = wp_insert_term( $post->post_title, 'artist', [
				'slug' => $post->post_name,
			]);

			add_post_meta( $post_id, 'wsl_artist_term_id', $term['term_id'] );
		}
	}
}
