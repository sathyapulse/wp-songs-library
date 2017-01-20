<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/sathyapulse
 * @since      1.0.0
 *
 * @package    Wp_Songs_Library
 * @subpackage Wp_Songs_Library/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Songs_Library
 * @subpackage Wp_Songs_Library/includes
 * @author     Sathiyamoorthy <sathyapulse@gmail.com>
 */
class Wp_Songs_Library {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Songs_Library_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-songs-library';
		$this->version = '1.0.0';

		/**
		 * Stores the plugin path in the constant variable.
		 */
		define( 'WSL_PLUGIN_PATH', plugin_dir_url( dirname( __FILE__ ) ) );

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->define_taxonomy_hooks();
		$this->define_metabox_hooks();
		$this->define_cpt_hooks();
		$this->define_shortcode_hooks();

		$this->define_custom_tables();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Songs_Library_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Songs_Library_i18n. Defines internationalization functionality.
	 * - Wp_Songs_Library_Admin. Defines all hooks for the admin area.
	 * - Wp_Songs_Library_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-songs-library-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-songs-library-public.php';

		/**
		 * The class responsible for defining all the utility functions used in the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-utilities.php';

		/**
		 * Registers the Taxonomies for the songs and albums.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-taxonomy.php';

		/**
		 * Registers the Metaboxes for the songs and albums.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-metabox.php';

		/**
		 * Registers the Custom Post Type for the songs and albums.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-cpt.php';

		/**
		 * Registers the Custom table for the album meta.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-custom-table.php';

		/**
		 * Registers the Shortcode for the song and album.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-shortcode.php';

		/**
		 * The class is responsible for defining all the custom query.
		 */
		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-songs-library-query.php';

		$this->loader = new Wp_Songs_Library_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Songs_Library_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Songs_Library_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Songs_Library_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Songs_Library_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	private function define_taxonomy_hooks() {
		$plugin_taxonomy = new Wp_Songs_Library_Taxonomy( $this->get_plugin_name(), $this->get_version() );

		// Hook into the init action and call register_song_taxonomies when it fires.
		$this->loader->add_action( 'init', $plugin_taxonomy, 'register_album_taxonomy' );
		$this->loader->add_action( 'init', $plugin_taxonomy, 'register_artist_taxonomy' );

		$this->loader->add_action( 'save_post_album', $plugin_taxonomy, 'insert_album_taxonomy', 10, 3 );
		$this->loader->add_action( 'save_post_artist', $plugin_taxonomy, 'insert_artist_taxonomy', 10, 3 );
	}

	/**
	 * Registers the metabox.
	 */
	private function define_metabox_hooks() {
		$plugin_metabox = new Wp_Songs_Library_Metabox( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'add_meta_boxes_album', $plugin_metabox, 'register_album_metaboxes' );
		$this->loader->add_action( 'add_meta_boxes_song', $plugin_metabox, 'register_song_metaboxes' );

		$this->loader->add_action( 'save_post_album', $plugin_metabox, 'save_album_meta', 10, 3 );
		$this->loader->add_action( 'save_post_song', $plugin_metabox, 'save_song_meta', 10, 3 );
	}

	/**
	 * Registers the custom post types.
	 */
	private function define_cpt_hooks() {
		$plugin_cpt = new Wp_Songs_Library_Cpt( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_cpt, 'register_song_cpt' );
		$this->loader->add_action( 'init', $plugin_cpt, 'register_album_cpt' );
		$this->loader->add_action( 'init', $plugin_cpt, 'register_artist_cpt' );
	}

	/**
	 * Registers the Shortcode hooks.
	 */
	private function define_shortcode_hooks() {
		$plugin_shortcode = new Wp_Songs_Library_Shortcode( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_shortcode, 'register_album_shortcode' );
		$this->loader->add_action( 'init', $plugin_shortcode, 'register_song_shortcode' );

		$this->loader->add_filter( 'the_content', $plugin_shortcode, 'add_album_shortcode_to_album_post' );
		$this->loader->add_filter( 'the_content', $plugin_shortcode, 'add_song_shortcode_to_song_post' );
	}

	private function define_custom_tables() {
		$plugin_custom_table = new Wp_Songs_Library_Custom_Table( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'plugins_loaded', $plugin_custom_table, 'register_custom_tables' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Songs_Library_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
