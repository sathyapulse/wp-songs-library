<?php

/**
 * Class Wp_Songs_Library_Shortcode
 */
class Wp_Songs_Library_Shortcode extends Wp_Songs_Library_Utilities {
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

	function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	private function album_shortcode_output( $attributes, $content, $shortcode ) {
		$album_term_id = $this->get_album_meta( get_the_ID(), 'wsl_album_term_id', true );

		$query_args = [
			'post_type' => 'song',
			'tax_query' => [
				'taxonomy' => 'album',
				'field'    => 'term_id',
				'terms'    => $album_term_id,
			],
		];

		$cache_key = sanitize_key( 'wsl_album_' . get_the_ID() . 'songs' );
		$songs_query = new Wp_Songs_Library_Query( $query_args, $cache_key, 5 * MINUTE_IN_SECONDS );
		$songs = $songs_query->get_posts();

		if ( ! $songs->have_posts() ) {
			return 'There is no songs available in this album.';
		}

		$first_song_id = $songs->posts[0]->ID;

		$shortcode_args = [
			'song_post_id' => $first_song_id,
			'id'           => 'wsl_album_player',
		];

		?>
		<div class="wsl_audio_container">

			<?php echo $this->song_shortcode_output( $shortcode_args ); ?>

			<ul class="wsl_album_songs_list">
			<?php while ( $songs->have_posts() ) : $songs->the_post(); ?>
				<?php
					$attachment_id = get_post_meta( get_the_iD(), 'wsl_song_attachment_id', true )
				?>
				<li
					song_post_id="<?php echo esc_attr( get_the_ID() ); ?>"
					song_attachment_id="<?php echo esc_attr( $attachment_id ); ?>"
					song_location="<?php echo esc_url( get_post_meta( get_the_iD(), 'wsl_song_location', true ) ); ?>"
					type="<?php echo esc_attr( get_post_mime_type( $attachment_id ) ); ?>"
					id="wsl_song_<?php echo esc_attr( get_the_ID() ); ?>">
					<?php echo get_the_title(); ?>
				</li>
			<?php endwhile; ?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}

	public function register_album_shortcode() {
		add_shortcode( 'wsl_album', [ $this, 'album_shortcode_output' ] );

		if ( class_exists( 'Shortcode_UI' ) ) {
			$this->register_album_shortcode_ui();
		}
	}

	public function register_album_shortcode_ui() {
		//TODO: Register Shortcode UI for getting the values from user.
	}


	public function add_album_shortcode_to_album_post( $content ) {
		// Check if we're inside the main loop in a single post page.
		if ( ! is_singular( 'album' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		return $content . $this->album_shortcode_output();
	}

	private function song_shortcode_output( $attributes = [], $content ) {
		$defaults = [
			'song_post_id' => get_the_ID(),
			'src'          => '',
			'id'           => 'wsl-song-' . get_the_ID(),
			'class'        => 'video-js vjs-default-skin vjs-fluid vjs-16-9 vjs-big-play-centered',
			'poster'       => WSL_PLUGIN_PATH . 'public/images/default_album_art.jpeg',
			'preload'      => 'auto',
			'width'        => '640',
			'height'       => '360',
		];

		$shortcode_attributes = shortcode_atts( $defaults, $attributes );

		$attachment_id = get_post_meta( $shortcode_attributes['song_post_id'], 'wsl_song_attachment_id', true );
		$shortcode_attributes['src'] = wp_get_attachment_url( $attachment_id );

		$album = get_the_terms( $shortcode_attributes['song_post_id'], 'album' );
		$album_id = $album[0]->term_id;
		$poster = get_the_post_thumbnail_url( $album_id );
		if ( ! empty( $poster ) ) {
			$shortcode_attributes['poster'] = $poster;
		}

		ob_start();
		?>
		<audio
			id="<?php echo esc_attr( $shortcode_attributes['id'] ); ?>"
			song_post_id = "<?php echo esc_attr( $shortcode_attributes['song_post_id'] ); ?>"
			class="<?php echo esc_attr( $shortcode_attributes['class'] ); ?>"
			controls
			preload="<?php echo esc_attr( $shortcode_attributes['preload'] ); ?>"
			width="<?php echo esc_attr( $shortcode_attributes['width'] ); ?>"
			height="<?php echo esc_attr( $shortcode_attributes['height'] ); ?>"
			poster="<?php echo esc_url( $shortcode_attributes['poster'] ); ?>"
			data-setup="{}">
			<source src="<?php echo esc_url( $shortcode_attributes['src'] ); ?>" type="<?php echo esc_attr( get_post_mime_type( $attachment_id ) ); ?>">
		</audio>
		<?php
		return ob_get_clean();
	}

	public function register_song_shortcode() {
		add_shortcode( 'wsl_song', [ $this, 'song_shortcode_output' ] );

		if ( class_exists( 'Shortcode_UI' ) ) {
			$this->register_song_shortcode_ui();
		}
	}

	public function register_song_shortcode_ui() {
		//TODO: Register Shortcode UI for getting the values from user.
	}

	public function add_song_shortcode_to_song_post( $content ) {
		// Check if we're inside the main loop in a single post page.
		if ( ! is_singular( 'song' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		return $content . $this->song_shortcode_output();
	}
}