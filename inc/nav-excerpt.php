<?php 
/**
 * get_prev/next_posts_link ($label, $max_page)
 * @since 1.0.3
 * @see https://docs.pluginize.com/article/81-cleanly-done-pagination-with-custom-wpquery-objects
 */
?>
<div id="hordes-pagination" class="pagination">
    <nav>
<?php 
/*
printf( '<div class="alignright">%s</div>', 
    get_next_posts_link( 'Older Listings', $wp_query->max_num_pages ) ); 
printf( '<div class="alignleft">%s</div>', 
    get_previous_posts_link( 'Newer Listings', $wp_query->max_num_pages ) ); 
*/
$prevpost = get_previous_posts_link( 'Newer Listings', $query->max_num_pages );
$nextpost = get_next_posts_link( 'Older Listings', $query->max_num_pages );
?>  

        <?php echo '<div class="alignleft">' . wp_kses_post( $prevpost ) . '</div>'; ?>
        
        <?php echo '<div class="alignright">' . wp_kses_post( $nextpost ) .'</div>'; ?>
 
    </nav>
</div>