<?php

/**
 * Class Wp_Songs_Library_Taxonomy
 */
class Wp_Songs_Library_Taxonomy {
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
            'name'                       => _x( 'Albums', 'taxonomy general name', $this->plugin_name ),
            'singular_name'              => _x( 'Album', 'taxonomy singular name', $this->plugin_name ),
            'search_items'               => __( 'Search Albums', $this->plugin_name ),
            'popular_items'              => __( 'Popular Albums', $this->plugin_name ),
            'all_items'                  => __( 'All Albums', $this->plugin_name ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Album', $this->plugin_name ),
            'update_item'                => __( 'Update Album', $this->plugin_name ),
            'add_new_item'               => __( 'Add New Album', $this->plugin_name ),
            'new_item_name'              => __( 'New Album Name', $this->plugin_name ),
            'separate_items_with_commas' => __( 'Separate albums with commas', $this->plugin_name ),
            'add_or_remove_items'        => __( 'Add or remove albums', $this->plugin_name ),
            'choose_from_most_used'      => __( 'Choose from the most used albums', $this->plugin_name ),
            'not_found'                  => __( 'No albums found.', $this->plugin_name ),
            'menu_name'                  => __( 'Albums', $this->plugin_name ),
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
            'name'                       => _x( 'Persons', 'taxonomy general name', $this->plugin_name ),
            'singular_name'              => _x( 'Person', 'taxonomy singular name', $this->plugin_name ),
            'search_items'               => __( 'Search Persons', $this->plugin_name ),
            'popular_items'              => __( 'Popular Persons', $this->plugin_name ),
            'all_items'                  => __( 'All Persons', $this->plugin_name ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Person', $this->plugin_name ),
            'update_item'                => __( 'Update Person', $this->plugin_name ),
            'add_new_item'               => __( 'Add New Person', $this->plugin_name ),
            'new_item_name'              => __( 'New Person Name', $this->plugin_name ),
            'separate_items_with_commas' => __( 'Separate persons with commas', $this->plugin_name ),
            'add_or_remove_items'        => __( 'Add or remove person', $this->plugin_name ),
            'choose_from_most_used'      => __( 'Choose from the most used persons', $this->plugin_name ),
            'not_found'                  => __( 'No persons found.', $this->plugin_name ),
            'menu_name'                  => __( 'Persons', $this->plugin_name ),
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