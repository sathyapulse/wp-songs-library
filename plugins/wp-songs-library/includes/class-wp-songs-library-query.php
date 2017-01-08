<?php

/**
 * Created by PhpStorm.
 */
class Wp_Songs_Library_Query {
	/**
	 * @var array
	 */
	private $default_args = [
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'posts_per_page'      => 20,
	];

	private $query_args = [];

	private $cache_key;

	private $cache_expiry;

	function __construct( $args, $cache_key, $cache_expiry = 0 ) {
		$this->query_args = wp_parse_args( $args, $this->default_args );

		if ( ! empty( $cache_key ) ) {
			$this->cache_key = $cache_key;
		}

		if ( ! empty( $cache_expiry ) ) {
			$this->cache_expiry = $cache_expiry;
		}
	}

	private function query() {
		$posts = new WP_Query( $this->query_args );

		if ( ! $posts->have_posts() ) {
			return [];
		}

		return $posts;
	}

	public function get_posts() {
		$posts = wp_cache_get( $this->cache_key );

		if ( ! is_array( $posts ) ) {
			$posts = $this->query();

			wp_cache_set( $this->cache_key, $posts, '', $this->cache_expiry );
		}

		return $posts;
	}
}