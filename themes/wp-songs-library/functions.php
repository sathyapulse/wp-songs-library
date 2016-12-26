<?php
/**
 * Functionality specifically related to The Songs Library child theme
 *
 * @package WordPress
 * @subpackage The Songs Library Theme
 */

/**
 * Include all the necessary files.
 */
require_once __DIR__ . '/includes/shortcodes/album.php';
require_once __DIR__ . '/includes/shortcodes/song.php';

function songs_library_enqueue_styles() {
	wp_enqueue_style( 'twenty-seventeen-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'songs_library_enqueue_styles' );

function songs_library_filter_the_content_in_the_main_loop( $content ) {
	// Check if we're inside the main loop in a single post page.
	if ( is_single() && in_the_loop() && is_main_query() ) {
		return $content . "I'm filtering the content inside the main loop";
	}

	return $content;
}
add_filter( 'the_content', 'songs_library_filter_the_content_in_the_main_loop' );
