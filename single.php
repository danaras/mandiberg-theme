


<?php

/* Single page template */

	get_header(); 

	get_template_part( 'parsedown' );  // includes parsedown (markdown interpreter) to display posts in markdown format

?>

<div id="barba-wrapper">
	<div class="barba-container" data-namespace="homepage">
		<?php



		// Start the loop.
		while ( have_posts() ) : the_post();

			//get_template_part( 'content', get_post_format() );

			?>
		<div class="col-md-12"> 
			<?php
			echo $post->post_title;
			?>
		</div>

		<div class="col-md-8"><?php

			$Parsedown = new Parsedown();
			$content = $post->post_content;
			echo $Parsedown->text($content);

				//echo $post->post_content;
			?>
		</div>
			<?php
			

			$categories = get_the_category();
 
			if ( ! empty( $categories ) ) {
			    //echo '<br />'.esc_html( $categories[1]->name );   
			
				foreach ($categories as $category) {
					//echo '<br/>'.$category->name;
				}

			}

			// If comments are open, load up the comment template.
			//if ( comments_open() || get_comments_number() ) :
			//	comments_template();
			// endif;
			?> 
			<div class="col-md-4">
			<?php
			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentyfifteen' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:', 'twentyfifteen' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );
			?>
			</div> 
			<?php
		// End the loop.
		endwhile;
		?>

	</div>
</div>

<?php get_footer(); ?>
