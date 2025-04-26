<?php
/**
 * Register widget with WordPress.
 */
class Hordes_Search_Widget extends WP_Widget {

function __construct() {
    parent::__construct(
    // Base ID of widget
    'Hordes_Search_Widget',

    // Widget name will appear in UI
    __( 'Hordes SearchForm in Sidebar', 'hordes' ), // Name
	array(
        'description' => __( 'Add Search for Hordes', 'hordes' ),
        )
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
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
			if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
            //do_shortcode('[hordes-categories]');
           ?>
            <form class="search" action="<?php echo home_url( '/' ); ?>">
            <input type="search" name="s" placeholder="Search&hellip;">
            <input type="submit" value="Search">
            <input type="hidden" name="post_type" value="hordes">
          </form><?php

	// return after widget parts
    echo $args['after_widget'];
    }
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
            } else {
            $title = __( 'Listing Search', 'hordes' );
        }
    // Widget admin form
    ?>

    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">
    <?php esc_html_e( 'Title:', 'hordes' ); ?></label> <input class="widefat" 
    id="<?php echo $this->get_field_id( 'title' ); ?>" 
    name="<?php echo $this->get_field_name( 'title' ); ?>" 
    type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

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
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? 
	strip_tags( $new_instance['title'] ) : '';
	return $instance;
	}
} // Ends class Depict_Widget 
?>
