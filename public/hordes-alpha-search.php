<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @package hordes plugin
 * @sub-package hordes/public/hordes-alphabetical-list
 */
function hordes_display_alphabetic_view( $atts = null, $content = null ) 
{ 
  
$hordes_qwerty = (empty(get_option('hordes_settings')['hordes_checkbox_alphaqwerty'])) 
                  ? 0 : get_option('hordes_settings')['hordes_checkbox_alphaqwerty'];
?>
<div class="hordes-fanning-panel" role="search">
    <form method="POST" action="" id="AlphaForm" name="reqform">
    <?php
    if(  $hordes_qwerty != absint( 1 ) ) : 
    ?>
<ul class="hordes-pagination pagination-alpha">
<li><input type="checkbox" name="olreq" value="a" />
<i><?php esc_html_e( 'a', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="b" />
<i><?php esc_html_e( 'b', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="c" />
<i><?php esc_html_e( 'c', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="d" />
<i><?php esc_html_e( 'd', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="e" />
<i><?php esc_html_e( 'e', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="f" />
<i><?php esc_html_e( 'f', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="g" />
<i><?php esc_html_e( 'g', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="h" />
<i><?php esc_html_e( 'h', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="i" />
<i><?php esc_html_e( 'i', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="j" />
<i><?php esc_html_e( 'j', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="k" />
<i><?php esc_html_e( 'k', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="l" />
<i><?php esc_html_e( 'l', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="m" />
<i><?php esc_html_e( 'm', 'hordes' ); ?></i></li></ul><ul class="hordes-pagination pagination-alpha">
<li><input type="checkbox" name="olreq" value="n" />
<i><?php esc_html_e( 'n', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="o" />
<i><?php esc_html_e( 'o', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="p" />
<i><?php esc_html_e( 'p', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="q" />
<i><?php esc_html_e( 'q', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="r" />
<i><?php esc_html_e( 'r', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="s" />
<i><?php esc_html_e( 's', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="t" />
<i><?php esc_html_e( 't', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="u" />
<i><?php esc_html_e( 'u', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="v" />
<i><?php esc_html_e( 'v', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="w" />
<i><?php esc_html_e( 'w', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="x" />
<i><?php esc_html_e( 'x', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="y" />
<i><?php esc_html_e( 'y', 'hordes' ); ?></i></li>
<li><input type="checkbox" name="olreq" value="z" />
<i><?php esc_html_e( 'z', 'hordes' ); ?></i></li></ul>

<?php else: ?>
<?php include plugin_dir_path( __FILE__ ) . 'hordes-qwerty-search.php'; ?>
<?php endif; ?>

    <p><input type="submit" name="reqform" 
          value="<?php esc_attr_e( 'FIND IT', 'hordes' ); ?>"></p>
    </form>
</div>

<div class="hordes-fanning-results">
    <?php 
    if ( isset( $_POST['olreq'] ) ) { 

//get all post IDs for posts start with letter A, in title order,
//display posts
global $wpdb;
$first_char = $_POST['olreq'];
$postids = $wpdb->get_col($wpdb->prepare("
SELECT      ID
FROM        $wpdb->posts
WHERE       SUBSTR($wpdb->posts.post_title,1,1) = %s
ORDER BY    $wpdb->posts.post_title",$first_char)); 

if ($postids) {
$args=array(
  'post__in' => $postids,
  'post_type' => 'hordes',
  'post_status' => 'publish',
  'posts_per_page' => -1
);
    $my_query = null;
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
        print( '<p class="hrds-search-title">' );
        esc_attr_e( 'List of Listings beginning with the letter ', 'hordes' ); 
        print( '<span>' ); print( $first_char ); print( '</span></p>' );
    while ($my_query->have_posts()) : $my_query->the_post(); ?>
        <p class="hordes-block hordes-tall"><a href="<?php the_permalink() ?>" 
           rel="bookmark" title="Permanent Link to <?php the_title_attribute(); 
           ?>"><?php the_title(); ?></a><?php the_excerpt(); ?></p>
    <?php
    endwhile;
    } else { esc_html_e( 'No Listings for This Search Filter', 'hordes' ); } 
    wp_reset_query();
  } 

} print '</div>  <div class="hrdsclearfix"></div>';

} 