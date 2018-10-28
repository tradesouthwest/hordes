<?php
/**
 * Hordes Single Template
 */
get_header(); ?>
<div class="hrdsclearfix"></div>
<div id="content" class="hordes-row">
    <div class="hordes-single">
<?php 
if( is_single() ) : 
    $hordes_link = hordes_get_custom_field( 'hordes_link' );
    $alts        = esc_attr( get_the_title($post->ID) );
?>

  
  <?php 
    if( have_posts() ) : while( have_posts() ) : the_post(); ?>
 
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> 
             itemscope itemtype="https://schema.org/Article">


    <div class="entry hordes-single-entry">
        <header class="single-entry-header">
            <h1 class="single-entry-title"><?php the_title(); ?></h1>
        </header>
        <figure>  
        <?php $url = wp_get_attachment_url( get_post_thumbnail_id()); ?>
        <span><a href="<?php echo esc_url( $url ); ?>" 
                 title="<?php the_title_attribute(); ?>">
            <img src="<?php echo esc_url( $url ); ?>" 
                 alt="<?php the_title_attribute(); ?>" 
                 class="hordes-thumb" /></a></span>
                 </figure>

        <div class="entry-content">         

    <?php 
    echo '<p><a href ="' . esc_url( $hordes_link ) . '" 
                title="' . esc_attr( get_the_title() ) . '" target="_blank" 
                rel  ="bookmark" 
                class="hrds-link">' . esc_html( $hordes_link ) . '</a></p>'; 
    ?>        
        </div>
        
        <footer class="entry-footer">
          <ul class="hrds-list-inline">
            <li><span class="hrds-tagcats"><?php echo get_the_term_list( $post->ID, 
                                                            'hordes_categories', 
                                                            '', 
                                                            ', ' ); ?>
            <i> | </i><em class="byline"><?php the_author(); ?></em>
            <i> | </i><time><?php echo esc_attr( get_the_date() ); ?></time>
            <span class="hrds-tags"> | <?php printf( hordes_get_terms_tag_list() ); ?></span>
            </li>
          </ul>
          <p class="edit-link"><?php edit_post_link(__( 'Edit', 'hordes'), ' '); ?></p>
        </footer>
    </div>

    <?php 
    endwhile; wp_reset_postdata(); 
    ?>
    </article><div class="hrdsclearfix"></div>

    <div class="comments">

            <?php if ( ! post_password_required() && (
            comments_open() || get_comments_number() ) )
            { ?>
            <ul class="list-unstyled">
            <li><?php
            $dsp = '<span class="comment-icon"> &#9776; </span> ';
            comments_popup_link(
            $dsp . __( 'Leave a comment', "appeal"),
            $dsp . __( '1 Comment', "appeal"),
            $dsp . __( '% Comments', "appeal")); ?></li>
            </ul>
            <?php 
            } ?>
        <div id="respond" class="comment-respond">
            
            <?php comments_template(); ?>
    
        </div>
        </div>
    <?php endif; ?>
     
  <?php //ends-if-single
  /**
   * see hidden reference in docs file for credit
   * 10-7 wordpress get category from url
   * @uses get_term_link() Generate a permalink for a taxonomy term archive.
   * 
   */ 
  elseif( is_tax() ) : 
         
    ?> 
    <?php 
    $categories = get_terms( 'hordes_categories' );
    $taxonomy   = get_queried_object();
   
    $count = count( $categories );
    if( $count ) { 
    ?>
<h2><?php echo sanitize_title( $taxonomy->name ); ?></h2>
    <ul class="archives">
    <?php 
    while (have_posts() ) : the_post(); 
    $hordes_link = ( empty (hordes_get_custom_field( 'hordes_link' ))) 
                     ? '' : hordes_get_custom_field( 'hordes_link' );
    ?>  

        <li id="post-<?php the_ID(); ?>" class="hordes-archive-title"><small><em><?php esc_html_e( 'post > ', 'hordes' ); ?></em></small> <a href="<?php the_permalink(); ?>">
        <?php echo get_the_title(); ?></a> <small><em><?php esc_html_e( 'link > ', 'hordes' ); ?></em></small> 
        <?php 
		printf( ' <a href="%s" title="%s" rel="%s" class="%s" target="%s">%s</a>',
					esc_url( $hordes_link ),
					esc_attr( get_the_title() ),
                    'bookmark',
					'hrds-link',
					'_blank',
					esc_html( $hordes_link ) ); ?></li>

    <?php 
     endwhile; wp_reset_postdata(); 
    //ends loop
    echo '</ul>';        
    }
    ?>

<?php elseif( is_tag() ):
    // is_tag
    $terms_tags = get_terms( 'hordes_tags' );
    $count = count( $term_tags );
    if( $count ) { 
        ob_start();
    ?>

    <ul class="hordes-taglist">
    <?php 
    while (have_posts() ) : the_post(); 
    $hordes_link = ( empty (hordes_get_custom_field( 'hordes_link' ))) 
                     ? '' : hordes_get_custom_field( 'hordes_link' );
    ?>
      <li id="post-<?php the_ID(); ?>" class="hordes-archive-title">
      <small><em><?php esc_html_e( 'post > ', 'hordes' ); ?></em></small> 
      <a href="<?php the_permalink(); ?>"> <?php echo get_the_title(); ?></a>
       <small><em><?php esc_html_e( 'link > ', 'hordes' ); ?></em></small> 
        <?php 
        printf( ' 
        <a href="%s" title="%s" rel="%s" class="%s" target="%s">%s</a>',
					esc_url( $hordes_link ),
					esc_attr( get_the_title() ),
                    'bookmark',
					'hrds-link',
					'_blank',
                    esc_html( $hordes_link ) ); ?></li>
                    
    <?php  endwhile; wp_reset_postdata(); 
    //ends loop
    echo '</ul>';  
    return ob_get_clean();     
    }
    ?>

<?php else:
    // is_none-404
    ?>
    <div class="hordes-search">
    
        <?php do_shortcode('[hordes_search]' ); ?>

    </div>    

<?php  
endif; // all the decision making is done
?>
    </div>

    <div class="hordes-sidebar">

        <?php the_widget( 'Hordes_Cat_Widget' ); ?>

    </div>

</div><div class="hrdsclearfix"></div>
<?php get_footer(); ?>