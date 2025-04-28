<?php
/**
 * @package Hordes
 * @subpackage hordes/inc/hordes-functions
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */

function hordes_admin_login_redirect( $redirect_to, $request, $user ) 
{

    $rediradmin = ( empty( get_option('hordes_settings')['hordes_checkbox_rediradmin'] ) )
    ? '0' : get_option('hordes_settings')['hordes_checkbox_rediradmin']; 
    //is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        //check for subscribers
        if ( $rediradmin == '1' && in_array('administrator', $user->roles) ) {
            // redirect them to another URL, in this case, the homepage 
            $redirect_to = hordes_get_shortcoded_page_rediradmin();
        }
    }

    return $redirect_to;
}
add_filter( 'login_redirect', 'hordes_admin_login_redirect', 10, 3 );

/**
 * Find page link for form success message
 * @param string $shrtpage
 * @return $page link
 */
function hordes_get_shortcoded_page()
{

    global $post;
    $shrtpage = ( empty( get_option('hordes_settings')['hordes_text_field_0'] ) )
                    ? '' : get_option('hordes_settings')['hordes_text_field_0']; 
    $page =  get_the_title( $shrtpage );
    
        return site_url('/') . sanitize_title_with_dashes($page);
}

/**
 * Find page link for form page
 * @param string $formpage
 * @return $page link
 */
function hordes_get_shortcoded_page_rediradmin()
{

    global $post;
    $formpage = ( empty( get_option('hordes_settings')['hordes_rediradmin_dropdown'] ) )
                    ? '' : get_option('hordes_settings')['hordes_rediradmin_dropdown']; 
    $page =  get_the_title( $formpage );
    
        return site_url('/') . sanitize_title_with_dashes($page);
}

/**
 * Modify the main WordPress query to include an array of 
 * post types instead of the default 'post' post type.
 *
 * @param object $query  The original query.
 * @return object $query The amended query.
 */
function hordes_hordes_query_filter($wp_query) 
{
    if ( !is_admin() && $wp_query->is_main_query() ) 
    { 
      if ($wp_query->is_search || $wp_query->is_tax() ) {

          $wp_query->set('post_type', array( 'post', 'hordes', 'archive' ) );
      }
      elseif ( $wp_query->is_tag() ) {
          $wp_query->set( 'post_type', array( 'post', 'object' ) );
      }  
          return $wp_query;
    }
}
add_filter('pre_get_posts','hordes_hordes_query_filter');

/**
 * turn on comments for CPT    
 * Also requires $admin_options to operate correctly on page.
 */
function hordes_default_comments_setopen( $data ) 
{
    if( $data['post_type'] == 'hordes' ) {
        $data['comment_status'] = "open";
    }

        return $data;
} 
add_filter( 'wp_insert_post_data', 'hordes_default_comments_setopen', 20 );

/**
 * @uses hordes_settings option
 * Retrieves the value associated with option.
 */
function hordes_activate_front_form()
{
    $hordes_use_formpage = get_option( 'hordes_settings' )['hordes_use_formpage'];
    if( empty( $hordes_use_formpage ) ) { $hordes_use_formpage = absint(0); } 
    else { $hordes_use_formpage = $hordes_use_formpage; }

    if( $hordes_use_formpage == absint(1) ) : 
        return true;
    endif;
}

/**
 * Retrieve thumbnail and display on page 
 * @uses WP featured image
 */
function hordes_display_thumbnail()
{  
    global $post;
    $alts = esc_attr( get_the_title( $post->ID  ) );
    if ( has_post_thumbnail() ) {
        $img            = get_the_post_thumbnail_url(get_the_ID(),'hordes_thumb'); 
        $attachment_img = '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $alts ) . '" 
            title="' . esc_attr( $alts ) . '" class="hrds-thumb"/>';
            
            return $attachment_img;
  } else {
    $default_thumbnail = HORDES_FORMS_URL . 'public/imgs/default-placeholder150x150.png';
    ob_start();
    echo '<span class="hrds-thumb"><img src="' . esc_url( $default_thumbnail ) . '" 
        alt="' . esc_attr( $alts ) . '" title="' . esc_attr( $alts ) . '" class="hrds-thumb"/></span>';
    $default_thumb = ob_get_clean();

            return $default_thumb;
  }   
}

/**
 * Retrieve favicon to display
 * 
 * @param $hordes_link
 * @uses google favicon repository
 * @return favicon
 */
function hordes_get_favicon_fromurl($hordes_link)
{

if (!empty($hordes_link)) { 
    $url = preg_replace('/^https?:\/\//', '', $hordes_link); 
    if ($url != "") { 
      $imgurl = "https://www.google.com/s2/favicons?domain=" . $url; 
      $favicon = '<img src="' . $imgurl . '" width="16" height="16" />';	
    }
    else {
    $favicon = sprintf('<img src="%s" width="16" height="16" alt="%s"/>', 
    HORDES_FORMS_URL . 'public/imgs/favicons.png', esc_attr('url') );
    }
          return $favicon;
  }
}  


/**
 * @uses wp_get_term_list
 * Retrieves the terms associated with the term_id
 */
function hordes_get_category_display()
{ 
 
    if ( 'hordes' === get_post_type() ) {
        echo get_the_term_list( $post->ID, 'hordes_categories', '', ', ' );
    }
}


/**
 * Display list of categories on front side form.
 * 
 * @param $args
 * @param 'hordes_categories', array('hordes')
 * $taxonomy, $object_type, $args
 * @uses wp_dropdown_categories
 */
function  hordes_category_displayin_frontside( $taxonomy ) 
{    

    $taxonomy    = (empty ( $taxonomy ) ) ? 'hordes_categories' : $taxonomy;
    $terms       = wp_get_post_terms( get_the_ID(), $taxonomy );
    $selected_id = '';
    if(isset($terms[0]->term_id)){
        $selected_id = $terms[0]->term_id;
    }
    $hordes_cats = wp_dropdown_categories( array(
        'show_option_all'    => 'Choose a Category',
        'show_option_none'   => '',
        'orderby'            => 'ID', 
        'order'              => 'ASC',
        'show_count'         => 0,
        'hide_empty'         => 0, 
        'child_of'           => 0,
        'exclude'            => '',
        'echo'               => 1,
        'selected'           => $selected_id,
        'hierarchical'       => 1, 
        'name'               => 'hordes_categories',    
        'id'                 => 'hordes_categoriesDropdown',
        'class'              => 'form-no-clear',
        'depth'              => 0,
        'tab_index'          => 4,
        'taxonomy'           => $taxonomy,
        'hide_if_empty'      => true
    ) );
return $hordes_cats;
}

/**
 * get tags list
 */
function hordes_get_terms_tag_list()
{

global $post;
$terms = wp_get_post_terms($post->ID, 'hordes_tags');
    if ( $terms ) { 
    
      $output = array();
      foreach ($terms as $term) {

    $output[] = '<a href="' . esc_url_raw( get_term_link( $term->slug, 'hordes_tags' )) .'">
        ' . $term->name .'</a>'; 

      } 
    
    echo join( ", ", wp_kses_post( $output ));
    }
}

/**
 * @param $hordes_layout 
 * @uses get_option _checkbox_1
 * Determines if public layout is tall or short.
 */
function hordes_get_layout_option()
{  
   $hordes_layout = 0; 
   $hordes_layout = get_option('hordes_settings')['hordes_checkbox_1']; 
   switch ($hordes_layout) {
    case 0:
    $hordes_layout = 'hordes_tall';
    break;
    case 1: 
    $hordes_layout = 'hordes_short';
    break;
    default: 'hordes_tall';
   }
   return $hordes_layout;
}

/**
 * @param $hordes_settings 
 * @uses get_option 
 * Adds styles to footer.
 */
function hordes_inline_public_styles()
{ 
    $options = get_option('hordes_settings'); 
    $hordes_favicon = ( '0' == $options['hordes_use_formpage'] )? 
                      'visible' : 'hidden'; 
    $hordes_color_3 = (empty($options['hordes_color_field_3'] ) )?  
    $hordes_color_3 = '#002e63' : 
    $hordes_color_3 = $options['hordes_color_field_3'];
    $hordes_color_4 = (empty($options['hordes_color_field_4'] ) )?  
    $hordes_color_4 = '#3388bb' : 
    $hordes_color_4 = $options['hordes_color_field_4'];
    $hordes_color_5 = (empty($options['hordes_color_field_5'] ) )?  
    $hordes_color_5 = '#fafafa' : 
    $hordes_color_5 = $options['hordes_color_field_5'];
    $hordes_color_6 = (empty($options['hordes_color_field_6'] ) )?  
    $hordes_color_6 = '#fafafa' : 
    $hordes_color_6 = $options['hordes_color_field_6'];
    $hordes_qwerty = (empty($options['hordes_icons_alphaqwerty'] ) )?  
    $hordes_qwerty = '6' : 
    $hordes_qwerty = $options['hordes_icons_alphaqwerty'];

    $htm = ''; 
    $htm .= '.hordes-fanning-panel,.hordes-wrapper,.hrds-entry,.hordes-single{background:' . $hordes_color_5 . ';}.hordes-sidebar{background:' . $hordes_color_6 . ';}.hrds-favicos{visibility: ' . $hordes_favicon . ';}.hrds-list-inline li a.hrds-link,li.hrds-inline a.hrds-link,p.hrds-inline a.hrds-link,.hrds-excerpts a, .hordes-archive-title a:last-child{color:' . $hordes_color_4 . '!important;}.hrds-excerpts span.title a, .hrds-excerpts span.title,.hordes-archive-title a:first-child{color:' . $hordes_color_3 .'!important;}ul.hordes-pagination.pagination-alpha li i,.hordes-fanning-panel ul li i{padding:4px;position: relative !important;top:' . $hordes_qwerty . 'px;}';
    wp_register_style( 'hordes-entry-set', false );
    wp_enqueue_style(   'hordes-entry-set' );
    wp_add_inline_style( 'hordes-entry-set', $htm );
}
add_action( 'wp_enqueue_scripts', 'hordes_inline_public_styles' );