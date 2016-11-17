<?php

/**
 * Class Wp_Songs_Library_Metabox
 */
class Wp_Songs_Library_Metabox {
    public function __construct() {
        add_action( 'add_meta_boxes_album', [ $this, 'register_album_metaboxes' ] );
        add_action( 'add_meta_boxes_song', [ $this, 'register_song_metaboxes' ] );
    }

    public function register_album_metaboxes() {
        add_meta_box(
            'wsl-album-year',
            esc_html__( 'Album year', 'wp-songs-library' ),
            [$this, 'build_album_year_metabox'],
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
            [$this, 'build_song_year_metabox'],
            'song',
            'normal',
            'default'
        );
    }

    public function build_song_year_metabox() {

    }
}

global $wp_song_library_metabox;

$wp_song_library_metabox = new Wp_Songs_Library_Metabox();