<?php
	
	// Prevent direct file access
	if ( ! defined ( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * Extension of WP_Widget class in accordance with standard Wordpress practice to create widgets.
	 */
	class WP_Notes_Widget extends WP_Widget {

	    /**
	     *
	     * The variable name is used as the text domain when internationalizing strings
	     * of text. Its value should match the Text Domain file header in the main
	     * widget file.
	     *
	     * @since    0.1.0
	     *
	     * @var      string
	     */
	    protected $widget_slug = 'wp-notes-class';

		/*--------------------------------------------------*/
		/* Constructor
		/*--------------------------------------------------*/

		/**
		 * Specifies the classname and description, instantiates the widget,
		 * loads localization files, and includes necessary stylesheets and JavaScript.
		 */
		public function __construct() {
			
			parent::__construct(
				$this->get_widget_slug(),
				__( 'WP Notes Widget', $this->get_widget_slug() ),
				array(
					'classname'  => $this->get_widget_slug().'-widget',
					'description' => __( 'Displays all of the published notes in a "sticky note" styling.', $this->get_widget_slug() )
				)
			);

			// Refreshing the widget's cached output with each new post
			add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
			add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
			
		} // end constructor


	    /**
	     * Return the widget slug.
	     *
	     * @since    0.1.0
	     *
	     * @return    Plugin slug variable.
	     */
	    public function get_widget_slug() {
	        return $this->widget_slug;
	    }


		/*--------------------------------------------------*/
		/* Widget API Functions
		/*--------------------------------------------------*/
		/**
		 * Outputs the content of the widget.
		 *
		 * @param array args  The array of form elements
		 * @param array instance The current instance of the widget
		 */
		public function widget( $args, $instance ) {

			/**
			 *
			 * @since    0.1.0
			 * @var      int    $hide_if_empty    Flag to determine if widget should still be displayed when there are no published posts.
			 */
			$hide_if_empty;

			/**
			 *
			 * @since    0.1.0
			 * @var      array    $wp_notes_data    A multidimensional associative array containing all the data for the notes (title, text, date).
			 */
			$wp_notes_data = array();



			$hide_if_empty = (!empty($instance['hide_if_empty']) ? 1 : 0);

			$note_query_args = array (  'post_type' => 'nw-item', 
		                     'posts_per_page' => -1,
		                     'order' => 'ASC',
		                     'orderby' => 'menu_order date'
		                    );

			/**
			 * Since we need to run WP_Query to determine the number of active notes, we iterate through the results and store the 
			 * values in $wp_notes_data to be used later. This prevents the need to run WP_Query again later. 
			 */
		    $note_query = new WP_Query( $note_query_args );
		    global $post;
		    $count = 0;
			if ( $note_query->have_posts()  ) {
		        while ( $note_query->have_posts() ) : $note_query->the_post();

		    		$wp_notes_data[$count]['data'] = get_post_meta( $post->ID, 'WP_Notes_data', true );
		    		$wp_notes_data[$count]['title'] = get_the_title();
		    		$wp_notes_data[$count]['date'] = get_the_date();

		    		$count++;
		    	endwhile;
		    } else if ($hide_if_empty) {
		    	return;
		    }
		    


			// Check if there is a cached output
			$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

			if ( !is_array( $cache ) )
				$cache = array();

			if ( ! isset ( $args['widget_id'] ) )
				$args['widget_id'] = $this->id;

			if ( isset ( $cache[ $args['widget_id'] ] ) )
				return print $cache[ $args['widget_id'] ];
			
			
			$title = (isset( $instance['title']) ? sanitize_text_field($instance['title']) : '');
			$thumb_tack_colour = (isset($instance['thumb_tack_colour']) ? sanitize_text_field($instance['thumb_tack_colour']) : '');
			$text_colour = (isset($instance['text_colour']) ? sanitize_text_field($instance['text_colour']) : '');
			$background_colour = (isset($instance['background_colour']) ? sanitize_text_field($instance['background_colour']) : '');
			$use_custom_style = (!empty($instance['use_custom_style']) ? sanitize_text_field($instance['use_custom_style']) : '');
			$wrap_widget = (!empty($instance['wrap_widget'] ) ? sanitize_text_field($instance['wrap_widget']) : '');

			extract( $args, EXTR_SKIP );
			
			$widget_string = ((bool)$wrap_widget) ?  $before_widget : '';

			ob_start();

			include( plugin_dir_path( dirname( __FILE__ ) ) . 'public/public-widget-view.php' );
			
			$widget_string .= ob_get_clean();
			
			$widget_string .= ((bool)$wrap_widget) ?  $after_widget : '';

			$cache[ $args['widget_id'] ] = $widget_string;

			wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

			print $widget_string;

		} // end widget
		
		
		public function flush_widget_cache() 
		{
	    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
		}


		/**
		 * Processes the widget's options to be saved.
		 *
		 * @param array new_instance The new instance of values to be generated via the update.
		 * @param array old_instance The previous instance of values before the update.
		 */
		public function update( $new_instance, $old_instance ) {

			$instance = $old_instance;

			$instance = array();

			$instance['title']					= ( !empty($new_instance['title']) ? sanitize_text_field( $new_instance['title']) : '' );
			$instance['thumb_tack_colour']		= ( !empty($new_instance['thumb_tack_colour']) ? sanitize_text_field($new_instance['thumb_tack_colour']) : '' );
			$instance['text_colour']			= ( !empty($new_instance['text_colour']) ? sanitize_text_field( $new_instance['text_colour']) : '' );
			$instance['background_colour']		= ( !empty($new_instance['background_colour']) ? sanitize_text_field($new_instance['background_colour']) : '' );
			$instance['use_custom_style']		= ( !empty($new_instance['use_custom_style']) ? sanitize_text_field( $new_instance['use_custom_style']) : '' );
			$instance['hide_if_empty']			= ( !empty($new_instance['hide_if_empty']) ? sanitize_text_field( $new_instance['hide_if_empty']) : '' );
			$instance['wrap_widget']			= ( !empty($new_instance['wrap_widget']) ? sanitize_text_field( $new_instance['wrap_widget']) : '' );

			do_action( 'wp_editor_widget_update', $new_instance, $instance );

	 	 	return apply_filters( 'wp_editor_widget_update_instance', $instance, $new_instance );


		} // end widget

		/**
		 * Generates the administration form for the widget.
		 *
		 * @param array instance The array of keys and values for the widget.
		 */
		public function form( $instance ) {

			
			$instance = wp_parse_args(
				(array) $instance
			);
			
			$title = (isset( $instance['title']) ? esc_html($instance['title']) : __( 'New title', 'wp-notes-widget' ));
			$thumb_tack_colour = (isset($instance['thumb_tack_colour']) ? esc_html($instance['thumb_tack_colour']) : 'red');
			$text_colour = (isset($instance['text_colour']) ? esc_html($instance['text_colour']) : 'red');
			$background_colour = (isset($instance['background_colour']) ? esc_html($instance['background_colour']) : 'yellow');
			$use_custom_style = (!empty($instance['use_custom_style']) ? esc_html($instance['use_custom_style']) : '');
			$hide_if_empty = (!empty($instance['hide_if_empty']) ? esc_html($instance['hide_if_empty']) : '');
			$wrap_widget = (!empty($instance['wrap_widget']) ? esc_html($instance['wrap_widget']) : '');

			// Display the admin form
			include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/admin-widget-view.php' );

		} // end form


	} // end wp-notes-widget class


class WP_Notes_Widget_Container {

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

	function register_wp_notes_widget() {
		register_widget( 'WP_Notes_Widget' );
	}

} //end wp-notes-widget-container class