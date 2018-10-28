<table class="hordes-table"><tbody>
<?php 
while ( $query->have_posts() ) : 
			$query->the_post(); 
			$hordes_link = get_post_meta( $post->ID, 'hordes_link', true );  	 
			$favicon     = hordes_get_favicon_fromurl( $hordes_link );
	?>  
 
<tr class="hrds-first hrds-entry hrdstall"><td>
    
	<?php echo hordes_display_thumbnail(); ?>

	<i class="hrds-favicos"> <?php print( $favicon ); ?> </i>
	<span class="title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </span>
<!--</td></tr>  
<tr class="hrds-second hrds-entry hrdstall"><td>  -->  
	<p class="hrds-second hrds-entry hrdstall"> <?php 
	printf( ' <a href="%s" title="%s" rel="%s" class="%s" target="%s">%s</a>',
					esc_url( $hordes_link ),
					esc_attr( get_the_title() ),
                    'bookmark',
					'hrds-link',
					'_blank',
					esc_html( $hordes_link ) ); ?></p>
</td></tr>
<tr class="hrds-third hrds-entry hrdstall"><td>
		<footer class="hrds-meta_footer">
    	<div class="hrds-list-inline">
			<span>
				<span class="hrds-tagcats">
	<?php echo get_the_term_list( $post->ID, 'hordes_categories', '', ', ' ); ?>
	
	<i> | </i><time><?php echo esc_attr( get_the_date() ); ?></time>
					<span class="hrds-tags"> | <?php the_tags(); ?></span>
				</span>
			</span>	
		</div>
		</footer>
</td></tr>
<?php 
	endwhile; wp_reset_postdata(); 
    ?>

</tbody></table>