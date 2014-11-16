
	<div class="wp-notes-widget-admin-container">
		
			<p><?php echo __('This plugin displays all of the published notes in the specified order. Notes can be managed on the', 'wp-notes-widget') . ' ' . '<a href="/wp-admin/edit.php?post_type=nw-item">'. __('Edit Notes','wp-notes-widget') . '</a> '. ' ' .  __('Page','wp-notes-widget'); ?></p>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wp-notes-widget' ); ?> <span class="wp-notes-secondary-text" >(<?php _e('optional','wp-notes-widget'); ?>)</span></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('thumb_tack_colour'); ?>"> <?php _e('Thumb Tack Color', 'wp-notes-widget'); ?></label>
					
					<select name="<?php echo $this->get_field_name( 'thumb_tack_colour' ); ?>" id="<?php echo $this->get_field_id( 'thumb_tack_colour' ); ?>">
						<option value="red" <?php echo ( $thumb_tack_colour == 'red' ) ? 'selected="selected"' : ''; ?> > 		<?php _e('Red', 'wp-notes-widget' ) ?> </option>
						<option value="blue" <?php echo ( $thumb_tack_colour == 'blue' ) ? 'selected="selected"' : ''; ?> >  	<?php _e('Blue', 'wp-notes-widget' ) ?> </option>
						<option value="green" <?php echo ( $thumb_tack_colour == 'green' ) ? 'selected="selected"' : ''; ?> > 	<?php _e('Green', 'wp-notes-widget' ) ?> </option>
						<option value="gray" <?php echo ( $thumb_tack_colour == 'gray' ) ? 'selected="selected"' : ''; ?> > 	<?php _e('Gray', 'wp-notes-widget' ) ?>  </option>
						<option value="orange" <?php echo ( $thumb_tack_colour == 'orange' ) ? 'selected="selected"' : ''; ?> > <?php _e('Orange', 'wp-notes-widget' ) ?> </option>
						<option value="pink" <?php echo ( $thumb_tack_colour == 'pink' ) ? 'selected="selected"' : ''; ?> > 	<?php _e('Pink', 'wp-notes-widget' ) ?> </option>
						<option value="teal" <?php echo ( $thumb_tack_colour == 'teal' ) ? 'selected="selected"' : ''; ?> > 	<?php _e('Teal', 'wp-notes-widget' ) ?> </option>
						<option value="yellow" <?php echo ( $thumb_tack_colour == 'yellow' ) ? 'selected="selected"' : ''; ?> > <?php _e('Yellow', 'wp-notes-widget' ) ?> </option>
					</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('background_colour'); ?>"><?php _e('Background Color', 'wp-notes-widget'); ?></label>
					
					<select name="<?php echo $this->get_field_name( 'background_colour' ); ?>" id="<?php echo $this->get_field_id( 'background_colour' ); ?>">
						<option value="yellow" <?php echo ( $background_colour == 'yellow' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Yellow', 'wp-notes-widget' ) ?></option>
						<option value="blue" <?php echo ( $background_colour == 'blue' ) ? 'selected="selected"' : ''; ?> >		<?php _e('Blue', 'wp-notes-widget' ) ?></option>
						<option value="green" <?php echo ( $background_colour == 'green' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Green', 'wp-notes-widget' ) ?></option>
						<option value="pink" <?php echo ( $background_colour == 'pink' ) ? 'selected="selected"' : ''; ?> >		<?php _e('Pink', 'wp-notes-widget' ) ?></option>
						<option value="orange" <?php echo ( $background_colour == 'orange' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Orange', 'wp-notes-widget' ) ?></option>
						<option value="white" <?php echo ( $background_colour == 'white' ) ? 'selected="selected"' : ''; ?> >	<?php _e('White', 'wp-notes-widget' ) ?></option>
						<option value="dark-grey" <?php echo ( $background_colour == 'dark-grey' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Dark Grey', 'wp-notes-widget' ) ?></option>
						<option value="light-grey" <?php echo ( $background_colour == 'light-grey' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Light Grey', 'wp-notes-widget' ) ?></option>
					</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('text_colour'); ?>"><?php _e('Text Color', 'wp-notes-widget'); ?></label>
					
					<select name="<?php echo $this->get_field_name( 'text_colour' ); ?>" id="<?php echo $this->get_field_id( 'text_colour' ); ?>">
						<option value="red" <?php echo ( $text_colour == 'red' ) ? 'selected="selected"' : ''; ?> >		<?php _e('Red', 'wp-notes-widget' ) ?></option>
						<option value="blue" <?php echo ( $text_colour == 'blue' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Blue', 'wp-notes-widget' ) ?></option>
						<option value="black" <?php echo ( $text_colour == 'black' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Black', 'wp-notes-widget' ) ?></option>
						<option value="pink" <?php echo ( $text_colour == 'pink' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Pink', 'wp-notes-widget' ) ?></option>
						<option value="white" <?php echo ( $text_colour == 'white' ) ? 'selected="selected"' : ''; ?> >	<?php _e('White', 'wp-notes-widget' ) ?></option>
						<option value="dark-grey" <?php echo ( $text_colour == 'dark-grey' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Dark Grey', 'wp-notes-widget' ) ?></option>
						<option value="light-grey" <?php echo ( $text_colour == 'light-grey' ) ? 'selected="selected"' : ''; ?> >	<?php _e('Light Grey', 'wp-notes-widget' ) ?></option>
					</select>
			</p>
			
			<p>
				<input type="checkbox" <?php if((bool)$show_date) echo 'checked="checked"' ?> value="checked" name="<?php echo $this->get_field_name( 'show_date' ); ?>" id="<?php echo $this->get_field_id('show_date'); ?>" />
				<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display date when note was published', 'wp-notes-widget'); ?></label>
					
			</p>

			<p>
				<input type="checkbox" <?php if((bool)$use_custom_style) echo 'checked="checked"' ?> value="checked" name="<?php echo $this->get_field_name( 'use_custom_style' ); ?>" id="<?php echo $this->get_field_id('use_custom_style'); ?>" />
				<label for="<?php echo $this->get_field_id('use_custom_style'); ?>"><?php _e('I will use my own CSS styles for WP Notes Widget', 'wp-notes-widget'); ?></label>
					
			</p>

			<p>
				<input type="checkbox" <?php if((bool)$wrap_widget) echo 'checked="checked"' ?> value="checked" name="<?php echo $this->get_field_name( 'wrap_widget' ); ?>" id="<?php echo $this->get_field_id('wrap_widget'); ?>" />
				<label for="<?php echo $this->get_field_id('wrap_widget'); ?>"><?php _e("Use my theme's widget wrapper for WP Notes Widget", 'wp-notes-widget'); ?></label>
					
			</p>

			<p>
				<input type="checkbox" <?php if((bool)$hide_if_empty) echo 'checked="checked"' ?> value="checked" name="<?php echo $this->get_field_name( 'hide_if_empty' ); ?>" id="<?php echo $this->get_field_id('hide_if_empty'); ?>" />
				<label for="<?php echo $this->get_field_id('hide_if_empty'); ?>"><?php _e('Hide WP Notes Widget if there are no published notes available', 'wp-notes-widget'); ?></label>
					
			</p>

			<p>
				<input type="checkbox" <?php if((bool)$multiple_notes) echo 'checked="checked"' ?> value="checked" name="<?php echo $this->get_field_name( 'multiple_notes' ); ?>" id="<?php echo $this->get_field_id('multiple_notes'); ?>" />
				<label for="<?php echo $this->get_field_id('multiple_notes'); ?>"><?php _e('Use individual "sticky notes" for each note', 'wp-notes-widget'); ?></label>
					
			</p>
		
	</div>

