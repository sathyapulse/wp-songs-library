<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/sathyapulse
 * @since             1.0.0
 * @package           Wp_Songs_Library
 *
 * @wordpress-plugin
 * Plugin Name:       Songs Library
 * Plugin URI:        https://github.com/sathyapulse/wp-songs-library
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Sathiyamoorthy
 * Author URI:        https://github.com/sathyapulse
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-songs-library
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-songs-library-activator.php
 */
function activate_wp_songs_library() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-songs-library-activator.php';
	Wp_Songs_Library_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-songs-library-deactivator.php
 */
function deactivate_wp_songs_library() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-songs-library-deactivator.php';
	Wp_Songs_Library_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_songs_library' );
register_deactivation_hook( __FILE__, 'deactivate_wp_songs_library' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-songs-library.php';

/**
 * Registers the Taxonomies for the songs and albums.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-songs-library-taxonomy.php';

/**
 * Registers the Metaboxes for the songs and albums.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-songs-library-metabox.php';

/**
 * Registers the Custom Post Type for the songs and albums.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-songs-library-cpt.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_songs_library() {

	$plugin = new Wp_Songs_Library();
	$plugin->run();

}
run_wp_songs_library();
