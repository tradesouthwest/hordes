<?php
/**
 * search form and rendering
 *
 */
echo '<div class="hordes-searching-panel" role="search">';
//do_action( 'hordes_searching_form' );
echo '</div>';
print( '<ul class="entry hrds-entry hrdsshort">' );  
		while ( $query->have_posts() ) : 
			$query->the_post(); 
            $hordes_link = get_post_meta( $post->ID, 'hordes_link', true );
        ?>
        <li class="hrds-inline"><span class="title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
		<?php 
		printf( ' <a href="%s" title="%s" rel="%s" class="%s" target="%s">%s</a>',
					esc_url( $hordes_link ),
					esc_attr( get_the_title() ),
                    'bookmark',
					'hrds-link',
					'_blank',
					esc_html( $hordes_link ) ); ?></li>
		
	<?php 
	//ends disply of shortlist 
	endwhile; wp_reset_postdata(); 
    ?>    
    </ul>
