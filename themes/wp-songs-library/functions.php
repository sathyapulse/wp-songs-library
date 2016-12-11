<?php
/**
 * Functionality specifically related to The Songs Library child theme
 *
 * @package WordPress
 * @subpackage The Songs Library Theme
 */

function songs_library_enqueue_styles() {
	wp_enqueue_style( 'twenty-seventeen-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'songs_library_enqueue_styles' );
