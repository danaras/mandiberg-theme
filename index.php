<?php
/**
 * The main template file
 
 * @package WordPress
 * @subpackage Mandiberg

 */

get_header(); ?>

	

<!-- barba js wrapper for smooth transitions -->

<div id="barba-wrapper">
	<div class="barba-container" data-namespace="homepage">
<?php 
	


$category = get_category( get_query_var( 'cat' ) ); 
$cat_id = $category->cat_ID; //gets id of current category

//print_r($cat_id);

 //echo $category_id;

// new definitions for argument array
	$args = array(
	'posts_per_page'   => 50,
	'offset'           => 0,
	'category'         => $cat_id,
	'category_name'    => '',
	'orderby'          => 'date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => '',
	'author_name'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);

/*if $category == none{
	
	show content tagged as featured

} else if(page has content){
	
	show content of page


}else{
	
show filtered posts

} */

$posts_array = get_posts( $args ); 





if ($cat_id) {
	
	$counter = 0;
	$arrayLength = count($posts_array); 
	//echo $arrayLength;
	//prints full array content from above
	 
	foreach ($posts_array as $post) {

	if ($counter === 0) {
			?> <div class="row"> <?php
	
	}	
		$counter = $counter + 1;

	//echo apply_filters( 'post_content', $post->post_content ); //prints content of post
	?> 
	<div class="col-md-4">
	<?php 
	echo '<h1><a href="'.get_permalink().'">'.apply_filters( 'post_title', $post->post_title.'</a></h1>' );
			if ( has_post_thumbnail() ) {
				//if the post has a thumbnail image show it:
				the_post_thumbnail('large');

			} else if(has_excerpt()){
				// else if it has an exerpt statement, show it:
				the_excerpt();
				
			} 
			//else the post just shows the title
	
	// print_r($post);

	?>	
	</div>
	<?php
	//echo apply_filters( 'guid', $post->guid );
		if($counter % 3 === 0 && $counter !== $arrayLength) {
		     
        	?> </div><div class="row"><?php 
        } else if ($counter === $arrayLength){
        	?> </div> <?php
        } else if($counter % 3 === 0 && $counter === $arrayLength){
			?> </div> <?php
        }
		
	}

} else{
	

		//featured works (on homepage!)
		$taxonomy = 'post_tag';
		$term_name = 'featured works';
		$term = get_term_by('name', $term_name, $taxonomy);
		$arrayLength = $term->count;
		//print_r($term);
		
/* */
		$the_query = new WP_Query( 'tag=featured-works' );

		if ( $the_query->have_posts() ) {
			$number = 0;
		   // echo '<ul>';
		    while ( $the_query->have_posts() ) {

		    	if ($number === 0) {
					?> <div class="row"> <?php
			
				}
				$number = $number + 1;



		        $the_query->the_post();
		       // echo '<li>' . get_the_title() . $number . '</li>';
		        
		        ?> 
				<div class="col-md-4">
				<?php 
				echo '<h1><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';
						if ( has_post_thumbnail() ) {
							//if the post has a thumbnail image show it:
							the_post_thumbnail('large');
						} else if(has_excerpt()){
							// else if it has an exerpt statement, show it:
							the_excerpt();
							
						} 
						//else the post just shows the title
				
				// print_r($post);

				?>	
				</div>
				<?php


				if($number % 3 === 0 && $number !== $arrayLength) {
			     
		        	?> </div><div class="row" ><?php 
		        } else if ($number === $arrayLength){
		        	?> </div> <?php
		        } else if($number % 3 === 0 && $number === $arrayLength){
					?> </div> <?php
		        }




		    }
		   // echo '</ul>';
		} else {
		    // no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();
/* */


}








?>

<?php get_footer(); ?>
	</div>
</div>

