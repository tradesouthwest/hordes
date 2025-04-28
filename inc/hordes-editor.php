<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Add meta box to editor
 * 
 * @strings $id, $title, $callback, $screen, $context, $priority, $args  
 * function's action_added in register cpt 
 */
function hordes_link_meta_box() 
{
    add_meta_box(
        'hordes_link_meta', 
        __( 'Hordes List Link', 'hordes' ), 
        'hordes_link_meta_box_cb',    //callback
        'hordes',                    // post type screen 
        'advanced',                 
        'default' 
    );
}
//'register_meta_box_cb' => 'hordes_link_meta_box',
add_action( 'add_meta_boxes', 'hordes_link_meta_box' );
/**
 * Output the HTML for the metabox.
 */
function hordes_link_meta_box_cb($post) {
    global $post;
    $hordes_link = ''; $hordes_thumb = '';
	
    // Output the field
	$hordes_link = get_post_meta( $post->ID, 'hordes_link', true );    
    $html = '';
    $html .= '<input id="hordes_link" type="url" name="hordes_link" 
    value="' . esc_attr($hordes_link) . '" class="widefat">';

    $html .= wp_nonce_field( 'hordes_field', 'hordes_field' );
    echo $html;       // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Save meta box content.
 * https://metabox.io/how-to-create-custom-meta-boxes-custom-fields-in-wordpress/
 * @param int $post_id Post ID
 */
add_action( 'save_post', 'hordes_update_link_meta', 10, 2 );
function hordes_update_link_meta( $post_id ) 
{
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }

    $fields = [
        'hordes_link',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {    // phpcs:ignore WordPress.Security.NonceVerification.Missing
            update_post_meta( $post_id, $field, 
                sanitize_text_field( wp_unslash( $_POST[$field] ) ) 
            );
        }
     }
} 

// TODO i18n in sprintf
// add custom post messages in the admin for our post type
add_filter( 'post_updated_messages', function($messages) {
    global $post, $post_ID;
    $link = esc_url( get_permalink($post_ID) );

    $messages['hordes'] = array(
        0 => '',
        1 => sprintf( 'Link updated. <a href="%s" title="%s">View listing</a>', 
                    $link,
                    $link 
                ),
    );
    return $messages;
}); 