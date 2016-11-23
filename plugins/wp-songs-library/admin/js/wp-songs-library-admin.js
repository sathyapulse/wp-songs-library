(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 */
	 $(function() {

		 // Uploading files
		 var file_frame;
		 jQuery('#wsl_upload_song').on('click', function(event) {

			 event.preventDefault();

			 // If the media frame already exists, reopen it.
			 if (file_frame) {
				 file_frame.open();
				 return;
			 }

			 // Create the media frame.
			 file_frame = wp.media.frames.file_frame = wp.media({
				 frame: "select",
				 title: "Select the Audio",
				 button: {
					 text: "Set song location",
				 },
				 multiple: false // Set to true to allow multiple files to be selected
			 });

			 // When a file is selected, run a callback.
			 file_frame.on('select', function(){
				 // We set multiple to false so only get one image from the uploader
				 var attachment = file_frame.state().get('selection').first().toJSON();


				 //var all = JSON.stringify( attachment );
				 //var id = attachment.id;
				 //var title = attachment.title;
				 //var filename = attachment.filename;
				 var url = attachment.url;
				 //var link = attachment.link;
				 //var alt = attachment.alt;
				 //var author = attachment.author;
				 //var description = attachment.description;
				 //var caption = attachment.caption;
				 //var name = attachment.name;
				 //var status = attachment.status;
				 //var uploadedTo = attachment.uploadedTo;
				 //var date = attachment.date;
				 //var modified = attachment.modified;
				 //var type = attachment.type;
				 //var subtype = attachment.subtype;
				 //var icon = attachment.icon;
				 //var dateFormatted = attachment.dateFormatted;
				 //var editLink = attachment.editLink;
				 //var fileLength = attachment.fileLength;

				 var field = document.getElementById("wsl_song_location");

				 field.value = url; //set which variable you want the field to have
			 });

			 // Finally, open the modal
			 file_frame.open();
		 });

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
