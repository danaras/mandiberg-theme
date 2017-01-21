


<?php

/* Single page template */

	get_header(); 

	//get_template_part( 'Parsedown' );  // includes parsedown (markdown interpreter) to display posts in markdown format

?>

<div id="barba-wrapper">
	<div class="barba-container" data-namespace="postpage">
		<?php

			$Parsedown = new Parsedown();

		// Start the loop.
		while ( have_posts() ) : the_post();


			?>
		<div class="row">
			<div class="col-md-8 post-content">
			<?php
				$content = $post->post_content;
				echo $Parsedown->text($content);
				//	echo $post->post_content;
			?>
			</div>
		
			<?php

			// $categories = get_the_category();
			// if ( ! empty( $categories ) ) {
			    //echo '<br />'.esc_html( $categories[1]->name );   
			// 	foreach ($categories as $category) {
					//echo '<br/>'.$category->name;
			// 	}
			// }
			// If comments are open, load up the comment template.
			//if ( comments_open() || get_comments_number() ) :
			//	comments_template();
			// endif;

			$t = wp_get_post_tags($post->ID);
			
			// get quantity of tags attached... (array length)
			$tagLength = count($t);
			
			if ($tagLength >= 1) {
				
			?> 
				<div class="col-md-4 related-works">
					<h1>Related Works</h1>
				<?php

				/* get categories presented in menu */

				//$menu = wp_get_nav_menu_object( "Category Menu" );

				//print_r($menu);

				$menuItems = wp_get_nav_menu_items("Category Menu");
				// select menu category items

				//print_r($menuItems);
				
				$menuCategories = [];

				foreach ($menuItems as $menuItem) {
					// get/add ID of each menu item to array
					if($menuItem->object === "category"){
						$menuID = $menuItem->ID;
					array_push($menuCategories, $menuID);
					//print_r($menuItem);
					}
					

				}

				$taxonomy = 'post_tag';
				$term_name = $t[0]->name; // name of tag
				$term_slug = $t[0]->slug; //slug of tag
				$term = get_term_by('name', $term_name, $taxonomy);
				$tagPostLength = $term->count; // amount of posts this tag contains

				$tagIDArray = [];

				foreach ($t as $givenTag) {
					
					$givenTagID = $givenTag->term_id;

					array_push($tagIDArray, $givenTagID);

				}
					# choose 3 random ones and display
					
					# search query
				$args = array(
				    'post_type' => 'post',
				    'orderby'   => 'rand',
				    'posts_per_page' => 3,
				    'cat' => $menuCategories, 
				    'tag__in' => $tagIDArray
			    ); // filter for posts

			    // array( ) is for all categories...s
				
				print_r($args);

				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {

					 while ( $the_query->have_posts() ) {
					 	 $the_query->the_post();

					 	 ?>
				<div class="row">
					<div class="col-sm-12 related-work"> <?php

					 	 echo '<h1><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';
					 	 if ( has_post_thumbnail() ) {
							//if the post has a thumbnail image show it:
							the_post_thumbnail();
						 } else if(has_excerpt()){
							// else if it has an exerpt statement, show it:
							the_excerpt();
							
						 } 

					 	 ?>
					 	 	
					</div>
				</div><?php
					 } //while end

				}else{}
				wp_reset_postdata();

			?>
				</div> 
		<?php

			}

			?>
		</div>
			<?php
		// End the loop.
		endwhile;
		?>


        <div class="lightbox-frame">
          <div class="lightbox-background">
          </div>
          	<span class="helper"></span>
            <img class="displayed-image" src="">
        </div>



<?php get_footer(); ?>

	</div> <!-- .barba-container -->
</div> <!-- #barba-wrapper -->

