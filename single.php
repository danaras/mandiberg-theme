


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
				//$content = strip_shortcodes( $content );
				$content = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $content);
				echo $Parsedown->text($content);
				$posttitle = $post->post_title;

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
			
			if ($tagLength >= 1) { // if post has at least one tag associated with it
				
			?> 
				<div class="col-md-4 related-works">
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

				

				/*
				1. initially filter just tags identical to the project name
				2. then tags that...
				3. remainder of tags


				GOALS:
				1. limit to 6 entries per project
				
				*/

				$post_slug = $post->post_name; //get slug of this post

				# $post_slug probably has a hyphen. but related tags dont. so we create a post_slug without a hyphen:

				$hyphen_check = strpos($post_slug, '-');
				if($hyphen_check){

					$post_slug_nohyphen = str_replace('-','', $post_slug);

				}


				$tag_amount = sizeof($t);

			//	echo $post_slug.'<br>';

				$taxonomy = 'post_tag';
				// $term_name = $t[0]->name; // name of first tag
				// $term_slug = $t[0]->slug; //slug of first tag
				$term_slug = $post_slug; # in case there is no match
				$term_slug_nohyphen = $post_slug_nohyphen; # in case there's no match


				// foreach ($t as $main_tag) { // compare Post slug to slugs of associated tags to see if the tags exist...

				// 	$tag_slug = $main_tag->slug;

				// 	if ($post_slug == $tag_slug) {
				// 		# if a tag exists equivalent to the post's title, then use the slug
				// 		$term_slug = $post_slug;  

				// 	}

				// 	if($post_slug_nohyphen == $tag_slug){
				// 		# if a tag exists equivalent to the post's title w/out a hyphen (potentially in addition to the hyphenated one)
				// 		$term_slug_nohyphen = $post_slug_nohyphen;


				// 	}


				// };
				
				$tagIDArray = []; // create array for tag IDs for query
				$postTagIDArray = [];


				# potentially hyphenated
				$term = get_term_by('slug', $term_slug, $taxonomy); //input new slug
				$tagPostLength = $term->count; // amount of posts this tag contains

				array_push($tagIDArray, $term->term_id); // add this post's equivilant tag's id
				array_push($postTagIDArray, $term->term_id);


				#not hyphenated

				if(!empty($term_slug_nohyphen)){
					$term_nh  = get_term_by('slug', $term_slug_nohyphen, $taxonomy);
					array_push($tagIDArray, $term_nh->term_id); // add this post's equivilant tag's id
					array_push($postTagIDArray, $term_nh->term_id);

				}
				







				foreach ($t as $givenTag) { // random order of related Tags
					
					$givenTagID = $givenTag->term_id;

					if(!in_array($givenTagID, $tagIDArray)){ // if the tag ID isn't already in the array
						array_push($tagIDArray, $givenTagID);
						//echo $givenTagID." was added to the list of tag IDs for general query<br>";
					
					} else{ # if the tag ID is already in the array, remove it
						foreach (array_keys($tagIDArray, $givenTagID) as $removalKey){
							unset($tagIDArray[$removalKey]);
						}
	
					}
				}


				

				# search query for tag equal to post slug
				$post_args = array(
				    'post_type' => 'post',
				    'orderby'   => 'modified',
				    'posts_per_page' => 7,
				    'category__in' => array(), 
				    'tag__in' => $postTagIDArray
			    ); // filter for posts

				
				$the_first_query = new WP_Query( $post_args);

				$remainder = 7 - $the_first_query->post_count;  #has seven because it counts itself

				echo $remainder;


				# search query for tags not identical to post slug
				$args = array(
				    'post_type' => 'post',
				    'orderby'   => 'rand',
				    'posts_per_page' => $remainder,
				    'category__in' => array(), 
				    'tag__in' => $tagIDArray
			    ); // filter for posts


				$the_query = new WP_Query( $args );
 

				$postTitleArray = [];

				if ($the_first_query->have_posts() ){
					# needs to not show if only current title is displayed

					if($the_first_query->post_count > 1){
						?><h1>More from <?php echo $posttitle; ?> </h1> <?php
					}

					 while ( $the_first_query->have_posts() ) {
					 	 $the_first_query->the_post();

					 	if ($posttitle != get_the_title()) { // if related post isn't current post
					 		
					 	


					 	 ?>
				<div class="row">
					<div class="col-sm-12 related-work"> <?php

					 	 echo '<a href="'.get_permalink().'"><h1>'.get_the_title().'</h1>';
					 	 array_push($postTitleArray, get_the_title());

					 	 if ( has_post_thumbnail() ) {
							//if the post has a thumbnail image show it:
							the_post_thumbnail();
						 } else if(has_excerpt()){
							// else if it has an exerpt statement, show it:
							the_excerpt();
							
						 } 

						 echo '</a>';

					 	 ?>
					 	 	
					</div>
				</div><?php
					 
					} // if post title is equivilant end
					 } //while end
				} // end of first query




				if ( $the_query->have_posts() ) {

					?><h1>Related</h1> <?php

					 while ( $the_query->have_posts() ) {
					 	 $the_query->the_post();

					 	if ($posttitle != get_the_title()) { // if related post isn't current post
					 		
						 	if (!in_array(get_the_title(), $postTitleArray)) { // if this project isnt already displayed
						 		
						 	


						 	 ?>
					<div class="row">
						<div class="col-sm-12 related-work"> <?php

						 	 echo '<a href="'.get_permalink().'"><h1>'.get_the_title().'</h1>';
						 	 if ( has_post_thumbnail() ) {
								//if the post has a thumbnail image show it:
								the_post_thumbnail();
							 } else if(has_excerpt()){
								// else if it has an exerpt statement, show it:
								the_excerpt();
								
							 } 

							 echo '</a>';

						 	 ?>
						 	 	
						</div>
					</div><?php
					 	}
					} // if post title is equivilant end
					 } //while end

				} else{

					// theoretically add category related works...

				}
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

