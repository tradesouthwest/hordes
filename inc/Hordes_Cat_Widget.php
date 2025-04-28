<?php
/**
 * Register widget with WordPress.
 */
class Hordes_Cat_Widget extends WP_Widget {

function __construct() {
    parent::__construct(
    // Base ID of widget
    'Hordes_Cat_Widget',
    __( 'Hordes Category Tag Widget', 'hordes' ), // Name
	array(
        'description' => __( 'Category Widget for Hordes Plugin', 'hordes' ),
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
	public function widget( $args, $instance ) 
	{
		// before and after widget arguments are defined by themes
		echo wp_kses_post( $args['before_widget'] );
			if ( ! empty( $instance[ 'title' ] ) )
			echo $args['before_title']                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				. wp_kses_post( apply_filters( 'widget_title', $instance['title'] ) ) 
			    . $args['after_title'];              // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			?><div class="hordes-widget"><?php  
			$list = wp_list_categories( array( 
				'hide_empty' => 1, 
				'child_of'   => 0,
				'show_count' => 1,
 				'title_li'   => '',
				'taxonomy'   => 'hordes_categories' 
				) );
			echo wp_kses_post( $list ); 
			
	echo '</div>
	<div class="hrds-widget widget-divider">
			<hr>';
/** 
 * Retrieve an array of objects for each term in post_tag taxonomy. 
 */
		$tags = get_terms( 'hordes_tags', array(
						   'hide_empty' => false,
						) );
    if ( $tags > 0 ):  
		print(
		'<aside class="hrds-cats">');
	foreach ( $tags as $tag ) :
		echo '<span><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" 
		title="' . esc_attr( $tag->name ) . '">' . esc_html( $tag->name ) . '</a> | </span>';
	endforeach;
	print( '</aside>
	</div>' );
	endif;
	// return after widget parts
    echo wp_kses_post( $args['after_widget'] );
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
		}
		else { $title = esc_html__( 'New title', 'hordes' ); }
    ?>

	<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'hordes' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		
			return $instance;
	}
} // Ends class Hordes_Cat_Widget
?>