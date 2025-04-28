<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * custom post type to handle form retrieval
 * register_post_type( $post_type, $args )
 *
 * Link: http://codex.wordpress.org/Function_Reference/register_post_type
 */
function hordes_custom_post_type() {
$labels = array(
        'name'               => _x( 'Hordes', 'post type general name', 'hordes' ),
        'singular_name'      => _x( 'Hordes', 'post type singular name', 'hordes' ),
        'menu_name'          => _x( 'Hordes Links', 'admin menu',       'hordes' ),
        'name_admin_bar'     => _x( 'Horde', 'add new on admin bar',    'hordes' ),
        'add_new'            => _x( 'Add New', 'hordes_client', 'hordes' ),
        'add_new_item'       => __( 'Add New Horde', 'hordes' ),
        'new_item'           => __( 'New Horde', 'hordes' ),
        'edit_item'          => __( 'Edit Horde', 'hordes' ),
        'view_item'          => __( 'View Horde', 'hordes' ),
        'all_items'          => __( 'All Hordes', 'hordes' ),
        'search_items'       => __( 'Search Horde', 'hordes' ),
        'parent_item_colon'  => __( 'Parent Horde:', 'hordes' ),
        'not_found'          => __( 'No Hordes found.', 'hordes' ),
        'not_found_in_trash' => __( 'No Hordes found in Trash.', 'hordes' )
    );
    $args = array(
      'labels'             => $labels,
        'description'        => __( 'Hordes List', 'hordes' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'capability_type'    => 'post',
        'rewrite'            => array( 'slug'       => 'hordes', 
                                       'with_front' => false ),
        'map_meta_cap'       => true,
        'supports'           => array( 'title', 'thumbnail', 'revisions' ),
        'taxonomies'         => array( 'hordes_categories', 'hordes_tags' ), 
        'has_archive'           => true,        
        'exclude_from_search'   => false,
        'hierarchical'       => true,
        'menu_position'      => null,
    );
    register_post_type( 'hordes', $args );
}

//register_taxonomy( $taxonomy, $object_type, $args )
function hordes_register_custom_taxonomies() 
{
    
    $args = array(
        'labels'              => __( 'Hordes Categories', 'hordes' ),
        'desc'                => '', 
        'hierarchical'        => true,
        'sort'                => true,
        'show_in_nav_menus'   => false,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'query_var'           => true,
        'public'              => true,            
        'capabilities'        => array(
            'edit_terms' => 'administrator'
            ), 
        'show_admin_column'   => true,
        'show_ui'             => true,
        'rewrite' => array( 'slug' => 'hordes_categories',
                            'with_front' => false,
                            'hierarchical' => true ) 
        ); 
    register_taxonomy( 'hordes_categories', 'hordes', $args );
} 

//register_taxonomy tag( $taxonomy, $object_type, $args )
function hordes_register_custom_posttag() 
{
    register_taxonomy( 'hordes_tags', 'hordes', array(
        'labels'              => __( 'Hordes Tags', 'hordes' ),
        'desc'                => __( 'Identifier and search tags', 'hordes' ), 
        'hierarchical'        => false,
        'sort'                => true,
        'query_var'           => true,
        'public'              => true,
        'show_in_nav_menus'   => false,
        'capabilities'        => array(
            'edit_terms' => 'administrator'
            ), 
        'show_admin_column'   => false,
        'show_ui'             => true,
        'show_tagcloud'       => true,
        'rewrite' => array( 'slug' => 'hordes_tags',
                            'with_front' => false,
                            'hierarchical' => false ) 
        ) ); 
} 