<?php
/**
 * Add different flags ($use_custom_style, empty($title)) to control what CSS is activated
 */
?>

<div class="wp-notes-widget-container <?php if (!(bool)$use_custom_style)  echo 'use-wp-notes-style'  ?>  <?php if ( !((bool)$title) )  echo 'wp-notes-no-title'  ?>">
	<div class="wp-notes-widget background-colour-<?php echo $background_colour ?> text-colour-<?php echo $text_colour ?>">
		<div class="header-area">
			<div class="pushpin thumb-tack-colour-<?php echo $thumb_tack_colour ?> "></div>
			
				<h3 ><?php echo $title; ?></h3>
			
		</div>
			
		<ul class="wp-notes-widget-list" >


			<?php
				/**
				 * This iterates through all of the notes and outputs the appropriate HTML markup.
				 */

			    foreach($wp_notes_data as $wp_note_data ) {
			    	?>
						
						

						<li >
							<p class="wp-notes-widget-date" ><?php echo $wp_note_data['date']; ?></p>
							<h5><?php echo $wp_note_data['title']; ?></h5>
						    
						    <?php  if (isset($wp_note_data['data']['text'])) { echo  wpautop(esc_textarea( $wp_note_data['data']['text'] )); } ?>
						    
				            <?php if (!empty($wp_note_data['data']['action_link']) && !empty($wp_note_data['data']['action_text']) ) {  ?>
						    	<p><a class="wp-notes-action-link" href="<?php  echo sanitize_text_field($wp_note_data['data']['action_link']); ?>"><?php echo sanitize_text_field($wp_note_data['data']['action_text']); ?></a></p> 	
						    <?php } ?>

						</li>

			    	<?php
			    }

			    /**
			     * If there are no published notes to display, and the widget is set to still display even if no notes are present,
			     * a statement is displayed indicating there are no notes to display.
			     */
			    if (!count($wp_notes_data)) {
			        print '<li><p class="wp-notes-widget-no-notes" >' . __('There are no notes to display right now.', 'wp-notes-widget') . '</p></li>';

			    }


			?>

		</ul>
	</div>
</div>
