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



echo "<br><br>";

 //echo $category_id;


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
$posts_array = get_posts( $args ); 

//prints full array content from above
foreach ($posts_array as $post) {
	//echo apply_filters( 'post_content', $post->post_content ); //prints content of post
	
	echo '<a href="'.apply_filters( 'guid', $post->guid ).'">'.apply_filters( 'post_title', $post->post_title.'</a>' );
	echo '<br>';
	print_r($post);
	echo '<br>';
	//echo apply_filters( 'guid', $post->guid );

	//print_r($post); //prints full object
}




?>

	</div>
</div>




<?php get_footer(); ?>
