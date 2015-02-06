<?php
	/**
	 * Usually not best practice to use nested functions in PHP because of how PHP stores functions at compile.
	 * However, a function_exists wrapper seems to be suitable.
	 * This file will be included inside other functions. This approach seems to works best with how the Wordpress callback 
	 * functions work for hooks.
	 */
	if (!function_exists('getNotePostData')) {
		
		/**
		 * Fetches all of the Note meta data and related attributes. Packages everything in an array for easy access
		 *
		 * @since  0.1.3
		 * @param  int 		$id 			The Wordpress ID of the note
		 * @return array 	$wp_notes_data	An array of all the meta data and other attributes for the note
		 */
		function getNotePostData($id) {
			
			$wp_notes_data = get_post_meta( $id, 'WP_Notes_data', true );
			
			$wp_notes_data['text'] 								= !empty($wp_notes_data['text']) 								? esc_textarea($wp_notes_data['text']) : '';
			$wp_notes_data['action_text']					= !empty($wp_notes_data['action_text']) 				? sanitize_text_field($wp_notes_data['action_text']) : '';
			$wp_notes_data['action_link'] 				= !empty($wp_notes_data['action_link']) 				? sanitize_text_field($wp_notes_data['action_link']) : '';
			$wp_notes_data['image_id'] 						= !empty($wp_notes_data['image_id']) 						? sanitize_text_field($wp_notes_data['image_id']) : '';
			$wp_notes_data['action_link_type'] 		= !empty($wp_notes_data['action_link_type']) 		?	sanitize_text_field($wp_notes_data['action_link_type']) : '';
			$wp_notes_data['download_id'] 				= !empty($wp_notes_data['download_id']) 				? sanitize_text_field($wp_notes_data['download_id']) : '';
			$wp_notes_data['plain_link_new_tab'] 	= !empty($wp_notes_data['plain_link_new_tab']) 	? sanitize_text_field($wp_notes_data['plain_link_new_tab']) : '';

			$wp_notes_data['image_meta'] = array(); 
			if ((bool)$wp_notes_data['image_id']) {
				
				$img_obj = wp_get_attachment_image_src($wp_notes_data['image_id'], 'wp-notes-widget-image' );
        if (!$img_obj) {
        	//if 'wp-notes-widget-image' sized image has not been generated yet, grab the medium size.
        	$img_obj = wp_get_attachment_image_src($wp_notes_data['image_id'], 'medium' );
        }

        $wp_notes_data['image_meta']['src'] = $img_obj[0];
        $wp_notes_data['image_meta']['width'] = $img_obj[1];
        $wp_notes_data['image_meta']['alt'] = get_post_meta($wp_notes_data['image_id'], '_wp_attachment_image_alt', true);

			} else {
				$wp_notes_data['image_meta']['src'] = '';
		    $wp_notes_data['image_meta']['alt'] = '';
			}

			if ((bool)$wp_notes_data['download_id']) {
		    $wp_notes_data['download_link'] = wp_get_attachment_url( $wp_notes_data['download_id'] );
			} else {
				$wp_notes_data['download_link']= '';	
			}

			return $wp_notes_data;

		}
	}