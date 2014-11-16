<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    WP_Notes
 * @subpackage WP_Notes/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    WP_Notes
 * @subpackage WP_Notes/admin
 */
class WP_Notes_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}



	/**
	 * Create the Notes post type
	 * 
	 * @since 0.1.0
	 */
 	 function notes_post_type_init() {

	  	$labels = array(
			'name'               => _x( 'Notes', 'post type general name', 'wp-notes-widget' ),
			'singular_name'      => _x( 'Note', 'post type singular name', 'wp-notes-widget' ),
			'menu_name'          => _x( 'Notes', 'admin menu', 'wp-notes-widget' ),
			'name_admin_bar'     => _x( 'Note', 'add new on admin bar', 'wp-notes-widget' ),
			'add_new'            => _x( 'Add New', 'nw-item', 'wp-notes-widget' ),
			'add_new_item'       => __( 'Add New Note', 'wp-notes-widget' ),
			'new_item'           => __( 'New Note', 'wp-notes-widget' ),
			'edit_item'          => __( 'Edit Note', 'wp-notes-widget' ),
			'view_item'          => __( 'View Note', 'wp-notes-widget' ),
			'all_items'          => __( 'All Notes', 'wp-notes-widget' ),
			'search_items'       => __( 'Search Notes', 'wp-notes-widget' ),
			'parent_item_colon'  => __( 'Parent Notes:', 'wp-notes-widget' ),
			'not_found'          => __( 'No notes found.', 'wp-notes-widget' ),
			'not_found_in_trash' => __( 'No notes found in Trash.', 'wp-notes-widget' )
		);

		$args = array(
		    'labels' => $labels,
		    'public' => false,
		    'publicly_queryable' => false,
		    'exclude_from_search' => true,
		    'show_ui' => true, 
		    'show_in_menu' => true, 
		    'query_var' => true,
		    'rewrite' => false,
		    'capability_type' => 'post',
		    'has_archive' => false, 
		    'hierarchical' => false,
		    'menu_position' => null,
		    'supports' => array('title','page-attributes')
		); 

	  	register_post_type('nw-item',$args);

	} // end notes_post_type_init



	/**
	 * Create new image size for image displayed in note
	 * 
	 * @since    0.1.3
	 */
	function add_notes_image_size() {
		add_image_size( 'wp-notes-widget-image', 400 );
	}



 	/**
	 * Adds the meta box below the post content editor on the post edit dashboard.
	 * 
	 * @since    0.1.0
	 */
	function add_note_metabox() {

		add_meta_box(
			'WP_Notes_item_content',
			__( 'Note Content', 'wp-notes-widget' ),
			array( $this, 'WP_Notes_meta_display' ),
			'nw-item',
			'normal',
			'high'
		);

	}


	/**
	 * Notes update messages.
	 *
	 * See /wp-admin/edit-form-advanced.php
	 * @since    0.1.3
	 * @param array $messages Existing post update messages.
	 * @return array Amended post update messages with new Note update messages.
	 */
	function notes_post_updated_messages( $messages ) {

		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );
		
		$messages['nw-item'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Note updated.' ),
			2  => __( 'Note details updated.' ),
			3  => __( 'Note details deleted.'),
			4  => __( 'Note updated.' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Note restored to revision from %s.' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Note published.' ),
			7  => __( 'Note saved.' ),
			8  => __( 'Note submitted.' ),
			9  => sprintf(
				__( 'Note scheduled for: <strong>%1$s</strong>.' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Note draft updated.' )
		);
	 
		return $messages;
	} // end notes_post_updated_messages



	/**
	 * Renders the nonce, textarea, and text inputs for the note.
	 *
	 * @since   0.1.0
	 * @param  	$post 	current post object 
	 */
	function WP_Notes_meta_display( $post ) {
		
		include( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-notes-post-data.php' );
		
		$wp_notes_data = getNotePostData( $post->ID);

		function WP_Notes_get_hidden_class_output($action_link_type,  $link_type ) {
			
			switch ($link_type) {
				case 'plain':
					if ( $action_link_type == 'download') {
						echo 'wp-notes-hidden';
					}
			   		break;
			  	case 'download':
			    	if ( (!(bool)$action_link_type) || $action_link_type == 'plain') {
			    		echo 'wp-notes-hidden';
					}
			    	break;
			}
		}

		function WP_Notes_get_selected_output($action_link_type, $link_type ) {
			switch ($link_type) {
				case 'plain':
					if ( (!(bool)$action_link_type) || $action_link_type == 'plain') {
						echo 'checked';
					}
			   		break;
			  	case 'download':
			    	if ( $action_link_type == 'download') {
			    		echo 'checked';
					}
			    	break;
			}
		}

		wp_nonce_field( plugin_basename( __FILE__ ), 'WP_Notes_nonce' );

		ob_start();

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/admin-post-view.php' );
		
		$html = ob_get_clean();

		echo $html;

	} // end WP_Notes_meta_display


 	/**
	 * Saves the note for the given post.
	 *
	 * @since    0.1.0
	 * @param	$post_id	The ID of the post that we're serializing
	 */
	function save_note( $post_id ) {

		if( isset( $_POST['WP_Notes_nonce'] ) && isset( $_POST['post_type'] ) ) {

			// Don't save if the user hasn't submitted the changes
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			} 

			// Verify that the input is coming from the proper form
			if( ! wp_verify_nonce( $_POST['WP_Notes_nonce'], plugin_basename( __FILE__ ) ) ) {
				return;
			} 

			// Make sure the user has permissions to post
			if( 'nw-item' == $_POST['post_type']) {
				if( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				} 
			} 

			/**
			 * sanitize all of the POST data and place it into an array.
			 */
			$wp_notes_data = array();
			$wp_notes_data['text'] = isset( $_POST['WP_Notes_text'] ) ?  implode( "\n", array_map( 'sanitize_text_field', explode( "\n", $_POST['WP_Notes_text'] ) ))  : '';
			$wp_notes_data['action_text'] = isset( $_POST['WP_Notes_action_text'] ) ? sanitize_text_field($_POST['WP_Notes_action_text']) : '';
			$wp_notes_data['action_link'] = isset( $_POST['WP_Notes_action_link']) ? wpnw_addhttp( sanitize_text_field($_POST['WP_Notes_action_link'])) : '';
			$wp_notes_data['image_id'] = isset( $_POST['WP_Notes_image_id'] ) ? sanitize_text_field($_POST['WP_Notes_image_id']) : '';
			$wp_notes_data['download_id'] = isset( $_POST['WP_Notes_download_id'] ) ? sanitize_text_field($_POST['WP_Notes_download_id']) : '';
			$wp_notes_data['plain_link_new_tab'] = isset( $_POST['WP_Notes_plain_link_new_tab'] ) ? sanitize_text_field($_POST['WP_Notes_plain_link_new_tab']) : '';
			$wp_notes_data['action_link_type'] = isset( $_POST['WP_Notes_action_link_type'] ) ? sanitize_text_field($_POST['WP_Notes_action_link_type']) : '';
			

			/**
			 * Wordpress automatically serializes the data and updates database with the new values.
			 */
			update_post_meta( $post_id, 'WP_Notes_data', $wp_notes_data );
			

		} // end if

	} // end save_note

	

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Notes_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Notes_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/wp-notes-admin.css', array(), $this->version, 'all' );
	}


	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Notes_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Notes_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 *
		 * Need to evaluate best approach for enqueing js/css files needed to select media.
		 * wp_enqueue_media() works, but it breaks the consistency of how hooks are queued in the plugin. 
		 */
		
		wp_enqueue_media();  
		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/wp-notes-admin.js', array( 'jquery' ), $this->version, false );

	}


}
