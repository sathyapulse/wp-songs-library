<?php

/**
 * Class Wp_Songs_Library_Taxonomy
 */
class Wp_Songs_Library_Taxonomy {
    public function __construct() {
        // Hook into the init action and call register_song_taxonomies when it fires.
        add_action( 'init', [ $this, 'register_album_taxonomy' ] );
        add_action( 'init', [ $this, 'register_person_taxonomy' ] );
        add_action( 'save_post_album', [ $this, 'insert_album_taxonomy' ], 10, 3 );
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

    public function register_person_taxonomy() {
        // Add new taxonomy, NOT hierarchical (like tags)
        $labels = array(
            'name'                       => _x( 'Persons', 'taxonomy general name', 'wp-songs-library' ),
            'singular_name'              => _x( 'Person', 'taxonomy singular name', 'wp-songs-library' ),
            'search_items'               => __( 'Search Persons', 'wp-songs-library' ),
            'popular_items'              => __( 'Popular Persons', 'wp-songs-library' ),
            'all_items'                  => __( 'All Persons', 'wp-songs-library' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Person', 'wp-songs-library' ),
            'update_item'                => __( 'Update Person', 'wp-songs-library' ),
            'add_new_item'               => __( 'Add New Person', 'wp-songs-library' ),
            'new_item_name'              => __( 'New Person Name', 'wp-songs-library' ),
            'separate_items_with_commas' => __( 'Separate persons with commas', 'wp-songs-library' ),
            'add_or_remove_items'        => __( 'Add or remove person', 'wp-songs-library' ),
            'choose_from_most_used'      => __( 'Choose from the most used persons', 'wp-songs-library' ),
            'not_found'                  => __( 'No persons found.', 'wp-songs-library' ),
            'menu_name'                  => __( 'Persons', 'wp-songs-library' ),
        );

        $args = array(
            'hierarchical'          => false,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'person' ),
        );

        register_taxonomy( 'person', [ 'song', 'album' ], $args );
    }

    /**
     * Insert/update taxonomy when a album custom post is saved.
     *
     * @param int $post_id The post ID.
     * @param post $post The post object.
     * @param bool $update Whether this is an existing post being updated or not.
     */
    public function insert_album_taxonomy( $post_id, $post, $update ) {
        if( $term_id = term_exists( $post->post_name ) ) {
            wp_update_term( $term_id, 'album', [
                'name' => $post->post_title,
                'slug' => $post->post_name,
            ]);
        }
        else {
            wp_insert_term( $post->post_title, 'album', [
                'slug' => $post->post_name,
            ]);
        }
    }
}

global $wp_song_library_taxonomy;

$wp_song_library_taxonomy = new Wp_Songs_Library_Taxonomy();