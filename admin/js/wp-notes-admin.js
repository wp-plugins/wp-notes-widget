// Overall, the javascript used here may need to be refactored to use properly implemented backbone.js models, view, events, etc.
// Right now it is at the reasonable limit as to what can be cleanly maintained just using jQuery.

(function( $ ) {
	
	// Name space for WP Notes Widget javascript 
    wpNotesMediaControls = function() {

      	var add_image_frame; // Wordpress media frame which controls the selection, change, or removal of an image
      	var add_download_frame; // Wordpress media frame which controls the selection, change, or removal of download file
     	var fade_time = 200; // The fade time (in milliseconds) of the link type background change, and image selection or removal

	    jQuery('#wp-notes-add-image-button').live('click', function(e) { 
	        e.preventDefault(); // Prevents page from jumping to top of screen when clicked
	        
	        if ( $(this).hasClass('disabled') ) {
	            return;
	        }

	        add_image_frame = wp.media({
               	title : 'Choose an image for the note',
               	frame: 'select',
               	multiple : false,
               	library : { type : 'image' },
               	button : { text : 'Add Image' }
			});

	        add_image_frame.on('close',function() {
	            var selection = add_image_frame.state().get('selection');
	            var url, is, alt;

	            if (!selection.length) {
	                wpNotesRemoveImage();
	                return;
	            }

	            // although the selection will only be 1 image, it is treated like an array in case future version feature a gallery of images
	            selection.each(function(attachment) {
	                url = attachment.attributes.url;
	                id = attachment.attributes.id;
	                alt = attachment.attributes.alt;
	                wpNotesShowImage(url, alt, id);
	            });

	        });

	        add_image_frame.on('open', function() {   
	            
	            var $image_id = jQuery('#WP_Notes_image_id');
	            var selection = add_image_frame.state().get('selection');
	              
	            ids = $image_id.val().split(',');
	            ids.forEach(function(id) {
	               	attachment = wp.media.attachment(id);
	                attachment.fetch();
	                selection.add( attachment ? [ attachment ] : [] );
	            });

	        });
	        add_image_frame.open(); 
	    });


	    jQuery('#wp-notes-add-download').live('click', function(e) { 
	        e.preventDefault();
	        if ( $(this).hasClass('disabled') ) {
	            return;
	        }

	        add_download_frame = wp.media({
                title : 'Choose an file to attach as a download',
                frame: 'select',
                multiple : false,
                button : { text : 'Add Download' }
            });

	        add_download_frame.on('close',function() {
	            var $download_link = $('input#WP_Notes_download_link');
	            var $download_id = $('input#WP_Notes_download_id');
	            var selection = add_download_frame.state().get('selection');
	            var url, id;

	            if (!selection.length) {
	                $download_link.attr('value', '');
	                $download_id.attr('value', '');
	                return;
	            }
	            
	            selection.each(function(attachment) {
	                url = attachment.attributes.url;
	                id = attachment.attributes.id;
	                $download_link.attr('value', url);
	                $download_id.attr('value', id);
	            });
  
	        });

	        add_download_frame.on('open', function() {   
	            var selection = add_download_frame.state().get('selection');

	            if (vals = jQuery('#WP_Notes_download_id').val()) {
	                
	                ids = vals.split(',');
	                ids.forEach(function(id) {
	                  	attachment = wp.media.attachment(id);
	                  	attachment.fetch();
	                  	selection.add( attachment ? [ attachment ] : [] );
	                });

	            }
	        });

	        add_download_frame.open(); 
	    });
	    
	    $('#WP_Notes_action_link_type_plain').live('change', function() {
	        
	        //if the 'plain link' option is chosen we want to hide all download elements and display 'plain link' elements
	        if ($(this).is(':checked') ){
	            var $action_link_control = $('.wp-notes-action-link-control');
	            var $download_components = $( ".wp-notes-download-components" );
	            var $add_download = $('a#wp-notes-add-download');
	            var $plain_link_components = $(".wp-notes-plain-link-components");

                $action_link_control.removeClass('checked');
                $(this).parent().addClass('checked');

                $download_components .fadeOut( fade_time, function() {
                    $add_download.addClass('disabled');
                    $download_components .addClass('wp-notes-hidden');
                    $plain_link_components.removeClass('wp-notes-hidden');
                    $plain_link_components.fadeIn( fade_time, function() {});
                });

	        }

	    });

	    $('#WP_Notes_action_link_type_download').live('change', function() {

	    	//if the download option is chosen we want to hide all 'plain link' elements and display download elements
	        if ($(this).is(':checked') ){
	            var $add_download = $('a#wp-notes-add-download');
	            var $action_link_control = $('.wp-notes-action-link-control');
	            var $plain_link_components = $( ".wp-notes-plain-link-components" );
	            var $download_components = $( ".wp-notes-download-components" );

	            $add_download.removeClass('disabled');
	            $action_link_control.removeClass('checked');
	            $(this).parent().addClass('checked');

	            $plain_link_components.fadeOut( fade_time, function() {
                   	$plain_link_components.addClass('wp-notes-hidden');
                   	$download_components.removeClass('wp-notes-hidden');
	                $download_components.fadeIn( fade_time, function() {});
	            });

	          } 
	    });

	    $('#wp-notes-remove-image-button').live('click', function(e) {
	        e.preventDefault();
	        if ( $(this).hasClass('disabled') ) {
	            return;
	        }
	        wpNotesRemoveImage();
	    });

	    //removes the image and displays a 'no image selected' box
	    function wpNotesRemoveImage() {
	    	var $image_container = $('.wp-notes-image-container .image');
	    	var $no_image_container = $('.wp-notes-image-container .no-image');
	    	var $image = $('img#WP_Notes_image');
	    	var $image_id = $('input#WP_Notes_image_id');
	    	var $remove_image_button = $('#wp-notes-remove-image-button');

	        $image_container.fadeOut( fade_time, function() {
	            $image_container.addClass('wp-notes-hidden');
	            $no_image_container.removeClass('wp-notes-hidden');
	            $image.attr('src', '');
	            $image.attr('alt', '');
	            $image_id.attr('value', '');
	            $no_image_container.fadeIn( fade_time, function() {
	                $remove_image_button.addClass('disabled');
	            });
	        });

	    }

	    //removes the 'no image selected' box and displays the new image
	    function wpNotesShowImage(url, alt, id) {
	    	var $image_container = $('.wp-notes-image-container .image');
	    	var $no_image_container = $('.wp-notes-image-container .no-image');
	    	var $image = $('img#WP_Notes_image');
	    	var $image_id = $('input#WP_Notes_image_id');
	    	var $remove_image_button = $('#wp-notes-remove-image-button');

	        $no_image_container.fadeOut( fade_time, function() {
	            $no_image_container.addClass('wp-notes-hidden');
	            $image_container.removeClass('wp-notes-hidden');
	            $image.attr('src', url);
	            $image.attr('alt', alt);
	            $image_id.attr('value', id);
	            $image_container.fadeIn( fade_time, function() {
	                $remove_image_button.removeClass('disabled');
	            });
	        });
	    }
    }
    wpNotesMediaControls();            

})( jQuery );


