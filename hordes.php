<?php
/*
Plugin Name: Hordes
Plugin URI: http://themes.tradesouthwest.com/wordpress/plugins/
Description: Save all your website links and organize them with ease.
Version: 1.0.3
Author: tradesouthwest
Author URI: http://tradesouthwest.com/
Requires PHP: 7.4
Requires CP:  2.1
Text Domain:  vertycal
Domain Path:  /languages
License:      GPLv2 or up
License URI:  License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
*/
if ( ! function_exists( 'add_action' ) ) {
	die( 'Nothing to see here...' );
}
/* Important constants */
define( 'HORDES_VERSION', '1.0.3' );
define( 'HORDES_FORMS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Upon plugin activation, always make sure init hook for a CPT 
 * has ran first or you will have to run `flush_rewrite()`.
*/
require_once ( plugin_dir_path( __FILE__ ) . 'hordes-register.php' );
add_action( 'init', 'hordes_custom_post_type', 1 );
add_action( 'init', 'hordes_register_custom_taxonomies', 1 ); 
add_action( 'init', 'hordes_register_custom_posttag', 1 ); 

/** 
 * Custom post type onlist_post.
 * Outputs for meta box fields
 * @since 1.0.0
 */
if( !function_exists( 'hordes_get_custom_field' ) ) : 
    // Function to return a custom field value
    function hordes_get_custom_field( $value )
    {
        global $post;
        $custom_field = get_post_meta( $post->ID, $value, true );
        if ( !empty( $custom_field ) )
            return is_array( $custom_field ) ? 
                stripslashes_deep( $custom_field ) :
                stripslashes( wp_kses_decode_entities( $custom_field ) );
                return false;
    }
endif;   

//activate/deactivate hooks
function hordes_plugin_activation() 
{
    flush_rewrite_rules(); 
    return false;
}

function hordes_plugin_deactivation() 
{
    flush_rewrite_rules();
    return false;
}

/**
 * reactivate plugin
*/
function hordes_plugin_reactivate() 
{ 
    // clean up any CPT cache
    flush_rewrite_rules();    
    return false;      
}

/**
 * Include loadable plugin files
 */
// Initialise - load in translations
function hordes_loadtranslations () {
    $plugin_dir = basename(dirname(__FILE__)).'/languages';
        load_plugin_textdomain( 'hordes', false, $plugin_dir );
}
add_action('plugins_loaded', 'hordes_loadtranslations');

// hook the plugin activation
register_activation_hook(   __FILE__, 'hordes_plugin_activation');
register_deactivation_hook( __FILE__, 'hordes_plugin_deactivation');
register_uninstall_hook(__FILE__,     'hordes_plugin_uninstall');
add_action( 'after_switch_theme',     'hordes_plugin_reactivate' );	

/**
 * Plugin Scripts
 *
 * Register and Enqueues plugin scripts
 *
 * @since 0.0.1
 */
if( is_admin() ) : 
function hordes_admin_enqueue_scripts()
{
    
    wp_enqueue_style( 'hordes-admin', HORDES_FORMS_URL 
                    . 'css/hordes-admin.css', HORDES_VERSION, false );
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script('hordes-plugin', 
        plugins_url(  'js/hordes-plugin.js', __FILE__ ), 
               array( 'wp-color-picker' ), false, true );
    if ( ! did_action('wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'hordes_admin_enqueue_scripts' );  
endif;

/**
 * Register Scripts - note: not using ajax but script can be used for 
 * validation or class structuring.
 */
function hordes_enqueue_scripts() 
{
    /* wp_register_script( 'hordes-public', plugins_url(
                        'js/hordes-public.js', __FILE__ ), 
                        array( 'jquery' ), true ); */
    // Register Styles
    wp_register_style( 'hordes-style', 
    HORDES_FORMS_URL . 'css/hordes-style.css' );

    wp_enqueue_style( 'hordes-style' );
    //wp_enqueue_script( 'hordes-public' );
}
add_action( 'wp_enqueue_scripts', 'hordes_enqueue_scripts' );

//add theme support for custom features
    add_theme_support('post-thumbnails', array( 'post', 'hordes' ) );    
    set_post_thumbnail_size( 150, 150 );
    add_image_size('hordes_thumb', 50, 9999 );
    // check for comments theme support
    if ( !current_theme_supports( 'comments' ) ) 
    { 
        add_post_type_support( 'hordes', array( 'comments' ) );
    }

//include admin and public views
require_once ( plugin_dir_path( __FILE__ ) . 'inc/hordes-editor.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'inc/hordes-adminpage.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'inc/hordes-functions.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'public/hordes-templater.php' );    

// Register and load the widget
function hordes_load_widgets() 
{ 
    require_once ( plugin_dir_path( __FILE__ ) . 'inc/Hordes_Cat_Widget.php' );
        register_widget( 'Hordes_Cat_Widget' );
}
add_action( 'widgets_init', 'hordes_load_widgets' );

// Include shortcode paramaters
require_once ( plugin_dir_path( __FILE__ ) . 'inc/hordes-formpage.php' );    
require_once ( plugin_dir_path( __FILE__ ) . 'public/hordes-alpha-search.php' ); 

// Register and load the shortcodes
function hordes_register_plugin_shortcodes() 
{   
        add_shortcode( 'hordes_submit_post', 'hordes_front_post_creation' );
        add_shortcode( 'hordes_list',        'hordes_template_public_list' );
        add_shortcode( 'hordes_search_bar',  'hordes_display_alphabetic_view' );
} 
add_action( 'init', 'hordes_register_plugin_shortcodes' ); 
?>