<?php

/**
 * Class Wp_Songs_Library_Cpt
 */
class Wp_Songs_Library_Cpt {

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

	public function register_song_cpt() {
		$labels = array(
			'name'               => _x( 'Songs', 'post type general name', $this->plugin_name ),
			'singular_name'      => _x( 'Song', 'post type singular name', $this->plugin_name ),
			'menu_name'          => _x( 'Songs', 'admin menu', $this->plugin_name ),
			'name_admin_bar'     => _x( 'Song', 'add new on admin bar', $this->plugin_name ),
			'add_new'            => _x( 'Add New', 'song', $this->plugin_name ),
			'add_new_item'       => __( 'Add New Song', $this->plugin_name ),
			'new_item'           => __( 'New Song', $this->plugin_name ),
			'edit_item'          => __( 'Edit Song', $this->plugin_name ),
			'view_item'          => __( 'View Song', $this->plugin_name ),
			'all_items'          => __( 'All Songs', $this->plugin_name ),
			'search_items'       => __( 'Search Songs', $this->plugin_name ),
			'parent_item_colon'  => __( 'Parent Songs:', $this->plugin_name ),
			'not_found'          => __( 'No songs found.', $this->plugin_name ),
			'not_found_in_trash' => __( 'No songs found in Trash.', $this->plugin_name )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', $this->plugin_name ),
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
            'name'               => _x( 'Albums', 'post type general name', $this->plugin_name ),
            'singular_name'      => _x( 'Album', 'post type singular name', $this->plugin_name ),
            'menu_name'          => _x( 'Albums', 'admin menu', $this->plugin_name ),
            'name_admin_bar'     => _x( 'Album', 'add new on admin bar', $this->plugin_name ),
            'add_new'            => _x( 'Add New', 'album', $this->plugin_name ),
            'add_new_item'       => __( 'Add New Album', $this->plugin_name ),
            'new_item'           => __( 'New Album', $this->plugin_name ),
            'edit_item'          => __( 'Edit Album', $this->plugin_name ),
            'view_item'          => __( 'View Album', $this->plugin_name ),
            'all_items'          => __( 'All Albums', $this->plugin_name ),
            'search_items'       => __( 'Search Albums', $this->plugin_name ),
            'parent_item_colon'  => __( 'Parent Albums:', $this->plugin_name ),
            'not_found'          => __( 'No albums found.', $this->plugin_name ),
            'not_found_in_trash' => __( 'No albums found in Trash.', $this->plugin_name )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Description.', $this->plugin_name ),
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
