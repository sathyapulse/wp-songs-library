<?php

/**
 * Class Wp_Songs_Library_Cpt
 */
class Wp_Songs_Library_Cpt {

	public function __construct() {
		add_action( 'init', array( $this, 'register_song_cpt' ) );
		add_action( 'init', array( $this, 'register_album_cpt' ) );
	}

	public function register_song_cpt() {
		$labels = array(
			'name'               => _x( 'Songs', 'post type general name', 'wp-songs-library' ),
			'singular_name'      => _x( 'Song', 'post type singular name', 'wp-songs-library' ),
			'menu_name'          => _x( 'Songs', 'admin menu', 'wp-songs-library' ),
			'name_admin_bar'     => _x( 'Song', 'add new on admin bar', 'wp-songs-library' ),
			'add_new'            => _x( 'Add New', 'song', 'wp-songs-library' ),
			'add_new_item'       => __( 'Add New Song', 'wp-songs-library' ),
			'new_item'           => __( 'New Song', 'wp-songs-library' ),
			'edit_item'          => __( 'Edit Song', 'wp-songs-library' ),
			'view_item'          => __( 'View Song', 'wp-songs-library' ),
			'all_items'          => __( 'All Songs', 'wp-songs-library' ),
			'search_items'       => __( 'Search Songs', 'wp-songs-library' ),
			'parent_item_colon'  => __( 'Parent Songs:', 'wp-songs-library' ),
			'not_found'          => __( 'No songs found.', 'wp-songs-library' ),
			'not_found_in_trash' => __( 'No songs found in Trash.', 'wp-songs-library' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'wp-songs-library' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'song' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
            'taxonomies'         => [ 'album', 'category', 'post_tag' ],
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'song', $args );
	}

	public function register_album_cpt() {
        $labels = array(
            'name'               => _x( 'Albums', 'post type general name', 'wp-songs-library' ),
            'singular_name'      => _x( 'Album', 'post type singular name', 'wp-songs-library' ),
            'menu_name'          => _x( 'Albums', 'admin menu', 'wp-songs-library' ),
            'name_admin_bar'     => _x( 'Album', 'add new on admin bar', 'wp-songs-library' ),
            'add_new'            => _x( 'Add New', 'album', 'wp-songs-library' ),
            'add_new_item'       => __( 'Add New Album', 'wp-songs-library' ),
            'new_item'           => __( 'New Album', 'wp-songs-library' ),
            'edit_item'          => __( 'Edit Album', 'wp-songs-library' ),
            'view_item'          => __( 'View Album', 'wp-songs-library' ),
            'all_items'          => __( 'All Albums', 'wp-songs-library' ),
            'search_items'       => __( 'Search Albums', 'wp-songs-library' ),
            'parent_item_colon'  => __( 'Parent Albums:', 'wp-songs-library' ),
            'not_found'          => __( 'No albums found.', 'wp-songs-library' ),
            'not_found_in_trash' => __( 'No albums found in Trash.', 'wp-songs-library' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Description.', 'wp-songs-library' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'album' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'author', 'thumbnail', 'excerpt', 'comments' ),
        );

        register_post_type( 'album', $args );
    }
}

global $wp_song_library_cpt;

$wp_song_library_cpt = new Wp_Songs_Library_Cpt();