<?php

/**
 * Class Wp_Songs_Library_Metabox
 */
class Wp_Songs_Library_Metabox {
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

	public function register_album_metaboxes( $post ) {
		add_meta_box(
			'wsl_album_metabox',
			esc_html__( 'Album attributes', 'wp-songs-library' ),
			[ $this, 'build_album_metabox' ],
			'album',
			'normal',
			'default'
		);
	}

	public function register_song_metaboxes( $post ) {
		add_meta_box(
			'wsl_song_metabox',
			esc_html__( 'Song attributes', 'wp-songs-library' ),
			[ $this, 'build_song_metabox' ],
			'song',
			'normal',
			'default'
		);
	}

	/**
	 * Render Year Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function build_album_metabox( $post, $metabox ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wsl_album_metabox', 'wsl_album_metabox_nonce' );

		$this->build_director_metabox( $post );
		echo '<br/><br/>';

		$this->build_music_director_metabox( $post );
		echo '<br/><br/>';

		$this->build_artists_metabox( $post );
		echo '<br/><br/>';

		$this->build_year_metabox( $post );
	}

	public function build_song_metabox( $post, $metabox ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wsl_song_metabox', 'wsl_song_metabox_nonce' );

		$this->build_music_director_metabox( $post );
		echo '<br/><br/>';

		$this->build_artists_metabox( $post );
		echo '<br/><br/>';

		$this->build_lyricist_metabox( $post );
		echo '<br/><br/>';

		$this->build_year_metabox( $post );
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 * @return mixed
	 */
	public function save_album_meta( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wsl_album_metabox_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['wsl_album_metabox_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wsl_album_metabox' ) ) {
			return $post_id;
		}

		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'album' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		$director = $_POST['wsl_director'];
		$music_director = $_POST['wsl_music_director'];
		$artists = $_POST['wsl_artists'];
		$year = sanitize_text_field( $_POST['wsl_year'] );

		// Update the meta field.
		update_post_meta( $post_id, 'wsl_director', $director );
		update_post_meta( $post_id, 'wsl_music_director', $music_director );
		update_post_meta( $post_id, 'wsl_artists', $artists );
		update_post_meta( $post_id, 'wsl_year', $year );
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 * @return mixed
	 */
	public function save_song_meta( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wsl_song_metabox_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['wsl_song_metabox_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wsl_song_metabox' ) ) {
			return $post_id;
		}

		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'song' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		$music_director = $_POST['wsl_music_director'];
		$artists = $_POST['wsl_artists'];
		$lyricist = $_POST['wsl_lyricist'];
		$year = sanitize_text_field( $_POST['wsl_year'] );

		// Update the meta field.
		update_post_meta( $post_id, 'wsl_music_director', $music_director );
		update_post_meta( $post_id, 'wsl_artists', $artists );
		update_post_meta( $post_id, 'wsl_lyricist', $lyricist );
		update_post_meta( $post_id, 'wsl_year', $year );
	}

	public function build_director_metabox( $post ) {
		// Use get_post_meta to retrieve an existing value from the database.
		$persons = get_the_terms( $post->ID, 'person' );

		if ( ! empty( $persons ) ) {
			$director = get_post_meta( $post->ID, 'wsl_director', true );
			// Display the form, using the current value.
			?>
			<label for="wsl_director">Select Director</label>
			<select name="wsl_director">
				<option value="0">Select</option>
				<?php
				$option_values = wp_list_pluck( $persons, 'name', 'term_id' );

				foreach ( $option_values as $key => $value ) {
					if ( $key == $director ) {
						?>
						<option selected value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
						<?php
					} else {
						?>
						<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
						<?php
					}
				}
				?>
			</select>
			<?php
		} else {
			echo 'Please tag persons in the person metabox to select Director.';
		}
	}

	public function build_music_director_metabox( $post ) {
		// Use get_post_meta to retrieve an existing value from the database.
		$persons = get_the_terms( $post->ID, 'person' );

		if ( ! empty( $persons ) ) {
			$music_director = get_post_meta( $post->ID, 'wsl_music_director', true );
			// Display the form, using the current value.
			?>
			<label for="wsl_music_director">Select Music Director</label>
			<select name="wsl_music_director">
				<option value="0">Select</option>
				<?php
				$option_values = wp_list_pluck( $persons, 'name', 'term_id' );

				foreach ( $option_values as $key => $value ) {
					if ( $key == $music_director ) {
						?>
						<option selected value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
						<?php
					} else {
						?>
						<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
						<?php
					}
				}
				?>
			</select>
			<?php
		} else {
			echo 'Please tag persons in the person metabox to select Music Director.';
		}
	}

	public function build_artists_metabox( $post ) {
		$persons = get_the_terms( $post->ID, 'person' );

		if ( ! empty( $persons ) ) {
			$option_values = wp_list_pluck( $persons, 'name', 'term_id' );
			$artists = get_post_meta( $post->ID, 'wsl_artists', true );
			?>
			<label for="wsl_artists">Select Artists</label>
			<?php
			foreach ( $option_values as $key => $value ) {
				if ( ! empty( $artists[ $key ] ) ) {
					?>
					<input name="wsl_artists[<?php echo esc_attr( $key ); ?>]" type="checkbox" value="<?php echo esc_attr( $key ); ?>" checked>
					<?php echo esc_html( $value );
				} else {
					?>
					<input name="wsl_artists[<?php echo esc_attr( $key ); ?>]" type="checkbox" value="<?php echo esc_attr( $key ); ?>">
					<?php echo esc_html( $value );
				}
			}
		} else {
			echo 'Please tag persons in the person metabox to select Artists.';
		}
	}

	public function build_lyricist_metabox( $post ) {
		// Use get_post_meta to retrieve an existing value from the database.
		$persons = get_the_terms( $post->ID, 'person' );

		if ( ! empty( $persons ) ) {
			$lyricist = get_post_meta( $post->ID, 'wsl_lyricist', true );
			// Display the form, using the current value.
			?>
			<label for="wsl_lyricist">Select Lyricist</label>
			<select name="wsl_lyricist">
				<option value="0">Select</option>
				<?php
				$option_values = wp_list_pluck( $persons, 'name', 'term_id' );

				foreach ( $option_values as $key => $value ) {
					if ( $key == $lyricist ) {
						?>
						<option selected value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
						<?php
					} else {
						?>
						<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
						<?php
					}
				}
				?>
			</select>
			<?php
		} else {
			echo 'Please tag persons in the person metabox to select Lyricist.';
		}
	}

	public function build_year_metabox( $post ) {
		$year = get_post_meta( $post->ID, 'wsl_year', true );
		?>
		<label for="wsl_year">
			<?php esc_html_e( 'Enter the year', 'wp-songs-library' ); ?>
		</label>
		<input type="text" id="wsl_year" name="wsl_year" value="<?php echo esc_attr( $year ); ?>" size="25" />
		<?php
	}
}
