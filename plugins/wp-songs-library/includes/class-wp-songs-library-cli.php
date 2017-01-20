<?php

/**
 * Class Wp_Songs_Library_Cli
 */
class Wp_Songs_Library_Cli extends WP_CLI_Command {
	public function __construct() {
		WP_CLI::add_command( 'wsl', $this );
	}

	public function generate_sample_posts( $args, $args_assc ) {
		$count = absint( $args[0] );
		if ( empty( $args[0] ) || ! $count ) {
			\WP_CLI::error( 'Provide the number of posts to generate.' );
		}

		$options = array(
			'return'     => true,  // Return 'STDOUT'; use 'all' for full object.
			'parse'      => 'json', // Parse captured STDOUT to JSON array.
			'launch'     => true, // Reuse the current process.
			'exit_error' => true,  // Halt script execution on error.
		);

		$post_title = 'Created using WP_CLI';
		$post_content_response = \WP_CLI\Utils\http_request( 'GET', 'http://loripsum.net/api/10' );
		$post_content = $post_content_response->body;

		for ( $i = 0; $i < $count; $i++ ) {
			$post_create_command = sprintf( 'post create --porcelain --format="ids" --post_title="%1s" --post_content="%2s" --post_status="publish"', $post_title, $post_content );
			$created_post = \WP_CLI::runcommand( $post_create_command, $options );

			if ( empty( $created_post ) ) {
				\WP_CLI::error( 'There was a problem creating a post.' );
			} else {
				\WP_CLI::success( 'The post created with the id: ' . $created_post );
			}
		}
	}
}
