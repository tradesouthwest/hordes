<?php
/** 
 * Hordes 
 * @package hordes
 * @since 1.0.0
 */ 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Save post metadata when a post is saved.
 *
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 *
 */
function hordes_front_post_creation() 
{ 
	$sub_success ='FAILURE' ;
	global $wpdb, $post; 

	if ( isset( $_GET['_wpnonce'] ) 
		&& !wp_verify_nonce( $_GET['_wpnonce'], 'new-post' ) ) {
		die( 'Security Check!' );
	}
	if( 'POST' == $_SERVER['REQUEST_METHOD']   // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
		&& !empty( sanitize_text_field( wp_unslash( $_POST['action'] ) ) )
		&&  sanitize_text_field( wp_unslash( $_POST['action'] == "new_post" ) ) )
	{
		$errors = new WP_Error();
		$default_category = esc_attr__( 'General', 'hordes' );
		// Do some minor form validation to make sure there is content
		if (isset ( $_POST['title'] )) {
			$title = sanitize_text_field( wp_unslash( $_POST['title'] ) );
			} else {
			$errors->add('empty_title', __('<strong>Notice</strong>: Please enter a title for your post.', 'hordes')
			);
		}
		//custom meta input
		if (isset ($_POST['hordes_link'])) {
			$hordes_link = sanitize_url( wp_unslash($_POST['hordes_link'] ) );
			} else {
			$errors->add('empty_content', __('<strong>Notice</strong>: Please enter the contents of your post.', 'hordes')
			);
		}
		//custom cat input
		if( isset( $_POST['hordes_categories'] )) { 
			$hordes_cat  = sanitize_text_field( wp_unslash( $_POST['hordes_categories'] ) ); 
			$hordes_cats = get_term_by( 'id', $hordes_cat, 'hordes_categories' );
			$custom_cat  = $hordes_cats->slug;
			
			} else { 
			$custom_cat  = esc_html__( 'General', 'hordes' );
		}
		// custom tag input
		if( isset( $_POST['hordes_tags'] ) ) {
			$hordes_tags = sanitize_text_field( wp_unslash( $_POST['hordes_tags'] ) );
			if( $hordes_tags ) { 
				
		    wp_set_post_terms( $hordes_tags, array(
				sanitize_text_field( wp_unslash( $_POST['hordes_tags'] ) ),
					'hordes_tags',
					false )
				);
				
			} else {	
				$hordes_tags =	'';
				}
		} 
			
		// ADD THE FORM INPUT TO $new_post ARRAY
		$new_post = array(
		'post_status'	=> 'publish', //get_option('hordes_post_status'), 
		'post_type'  	=> 'hordes',
		'post_title'	=> sanitize_title( $title ),
		'meta_input'    => array(
			'hordes_link' => $hordes_link,
			),
			//taxonomy input
			'tax_input'   =>	array( 
				'hordes_categories' => $custom_cat,
				'hordes_tags'       => $hordes_tags,
			),
        );

		//SAVE THE POST
        $query = $wpdb->prepare('SELECT ID FROM ' . $wpdb->posts . ' 
        WHERE post_title = %s', $title  );
		$wpdb->query( $query );        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		if (!$wpdb->num_rows ) 
		{	
			if ( !$errors->get_error_code() ) 
			{ 
				$post_id = wp_insert_post( $new_post );
				//$object_id, $terms, $taxonomy, $append
				wp_set_object_terms( $post_id, 
									 $custom_cat, 
									 'hordes_categories' );
			    wp_set_post_tags( $post_id, 
								  $hordes_tags );
			}
				if ( $post_id ) 
					 $sub_success ='Success' ;
				/**
				 * hordes_updated_post_send_email( $post_id );
				 * TODO
				 */ 
		}
	}

	if($sub_success == 'Success') { 
	/**
	 * This will redirect you to the newly created post
     * $post = get_post($post_id);
	 * wp_redirect($post->guid);
	 */	
	if( function_exists( 'hordes_get_shortcoded_page' ) ) : 
		$pgwith_shortcode   = hordes_get_shortcoded_page();
	else:
		$pgwith_shortcode = '';
	endif;

		echo '<div class="hordes-success">' . esc_html__( 'Link curated succesfully.', 'hordes' ) 
		    . ' <a href="' . esc_url( $pgwith_shortcode ) . '">View List</a></div>';
		$sub_success = null;
	} 
	if (isset($errors) && count($errors)>0 && $errors->get_error_code() ) :
		echo '<ul class="hordes-errors">';
		foreach ($errors->errors as $error) {
			echo '<li>'. wp_kses_post( $error[0] ).'</li>';
		}
	    echo '</ul>';
	endif; 

	//only logged in admins, editors can post from front end.	
	if ( is_user_logged_in() && current_user_can( 'edit_others_posts' ) ) 
	{ 
	//only show name if not admin
		$author = wp_get_current_user();
		if( current_user_can('administrator') ) 
		{ 
			$hrdscls = 'hordes-hidden'; } 
		else { 
			$hrdscls = 'hordes-inline-block'; }
	?>
<div class="hordes-wrapper">
	<header>
	<h4><?php echo esc_html__( 'Add your link ', 'hordes' ) . '<span class="' . esc_attr( $hrdscls ) . '">' . esc_html( $author->nickname ) . '</span>'; ?></h4>
	</header>
<form id="new_post" name="new_post" method="post" action="" enctype="multipart/form-data">
	<!-- post name -->
	<fieldset name="name">
		<label for="title">Link title:</label>
		<input type="text" id="title" value="" tabindex="2" name="title" />
	</fieldset>

	<!-- post CuratedLink -->
	<fieldset class="content">
		<label for="hordes_link"><?php esc_html_e( 'URL/Link: ', 'hordes' ); ?></label>
		<input type="text" id="hordes_link" value="" tabindex="3" name="hordes_link" />
	</fieldset>

	<!-- post Category -->
	<fieldset class="category">
		<label for="hordes_categories"><?php esc_html_e( 'Categorize as: ', 'hordes' ); ?></label>
		<?php $taxonomy = 'hordes_categories'; 
		hordes_category_displayin_frontside( 'hordes_categories'); 
		
		?>
	</fieldset>

	<!-- post tags -->
	<fieldset class="tags">
		<label for="hordes_tags"><?php esc_html_e( 'Lookup keywords (comma separated): ', 'hordes' ); ?></label>
		<input type="text" tabindex="5" value="" name="hordes_tags" id="hordes_tags" />
	</fieldset>

	<fieldset class="submit">
		<input type="submit" value="<?php esc_html_e( 'Submit Link', 'hordes' ); ?>" tabindex="6" id="submit" name="submit" />
	</fieldset>

	<input type="hidden" name="action" value="new_post" />
	<?php wp_nonce_field( 'new-post' ); ?>
</form>
</div>
<?php 
	} else { 
		echo '<h4>' . esc_html__( 'Please LogIn', 'hordes' ) . '</h4> 
			<p><a href="' . esc_url_raw( wp_login_url( home_url() ) ) . '" 
			title="' . esc_attr__( 'Please LogIn', 'hordes' ) . '" 
			class="hrds-btn btn btn-primary button button-primary">
			' . esc_html__( 'LogIn', 'hordes' ) . '</a></p>'; 
	} 
}

//hordes_list shortcode
function hordes_template_public_list()
{
    global $post, $paged;

    if ( get_query_var('paged') ) $paged = get_query_var('paged'); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
    if ( get_query_var('page') ) $paged = get_query_var('page'); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
    
    $query = new WP_Query( array( 
		'post_type' => 'hordes', 
		'paged'     => $paged
		) );
    if( $query ) { 
		if ( !is_admin() && is_main_query() ) :    
    ?>

<div class="hrds-excerpts">
   
    <?php // grab layout value  
    $hordes_layout     = hordes_get_layout_option();
	if( $hordes_layout == 'hordes_tall' ) 
	{ ?>
	
	<?php include 'tmplt-hordes-tall.php'; ?>

		<?php // display short list 
    	} else { ?>
	
	<?php include 'tmplt-hordes-short.php'; ?>
      
    <?php 
    }   //ends hordes_layout choice 
    ?>
	
	<?php include 'nav-excerpt.php'; ?>
	
	<?php //ends all hordes query
	endif; // yep I guess that was the main query
	$query = null;
        } else {
        esc_html_e( 'No listing in the hordes taxonomy!', 'hordes' ); 
	} ?>

</div><?php //ends hordes excerpts div 
    print( '<div class="hrdsclearfix"></div>' );		
} 
