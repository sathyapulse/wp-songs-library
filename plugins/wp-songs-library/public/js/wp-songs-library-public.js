(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 */
	 $(function() {
		var videojs_obj = videojs( document.getElementById('wsl_album_player') );
	 	$( '.wsl_album_songs_list' ).find('li').on('click', function () {
			if( this.getAttribute('song_post_id') != $('#wsl_album_player').attr('song_post_id') ) {

                videojs_obj.src( [
					{
						type: this.getAttribute('type'),
						src: this.getAttribute('song_location')
					}
				] );
                videojs_obj.load();
                videojs_obj.play();

                $('#wsl_album_player').attr('song_post_id', this.getAttribute('song_post_id'))
			}
		})
	 });

	/**
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
