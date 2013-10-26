<?php
/**
 * Adds Foo_Widget widget.  Via http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class To_Do_List_Member_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'to_do_list_member_widget', // Base ID
			__('LowRize Task List', 'text_domain'), // Name
			array( 'description' => __( 'Display tasks assigned to team members', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		// For some reason, it won't let me output this lower down in the code unless it is in a variable...
		$after_widget = $args['after_widget'];
		
		echo do_shortcode('[todolists_tasklist id="'. $instance[ 'to_do_list_member_taxonomy_id' ] .'"]');
		
		echo $after_widget;
		
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Task List', 'text_domain' );
		}
		if ( isset( $instance[ 'to_do_list_member_taxonomy_id' ] ) ) {
			$to_do_list_member_taxonomy_id = $instance[ 'to_do_list_member_taxonomy_id' ];
		}
		else {
			$to_do_list_member_taxonomy_id = __( '', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('to_do_list_member_taxonomy_id'); ?>"><?php _e('Task Category ID:', 'text_domain'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('to_do_list_member_taxonomy_id'); ?>" name="<?php echo $this->get_field_name('to_do_list_member_taxonomy_id'); ?>" type="text" value="<?php echo $to_do_list_member_taxonomy_id; ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['to_do_list_member_taxonomy_id'] = strip_tags($new_instance['to_do_list_member_taxonomy_id']);
		return $instance;
	}

} // class Foo_Widget

// register Foo_Widget widget
function register_to_do_list_member_widget() {
    register_widget( 'To_Do_List_Member_Widget' );
}
add_action( 'widgets_init', 'register_to_do_list_member_widget' );                                                                                                                                                                 
