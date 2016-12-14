<?php 

/* header page*/


 ?>
<head>
	<title>Michael Mandiberg</title>
<?php    wp_head();  ?>
</head>


<body>
	


<div class="header">

<?php 

		wp_nav_menu( array( 'theme_location' => 'header-menu', 
						  'cointainer' => 'div', 
						  'container_class' => 'menu',
						  'walker' => new Description_Walker 
						  ) );

/*

	- things still to do
		- //figure out how to wrap all subcategories into one <span> (to hide)
		- //on click of category links to category page and reveals subcategories. 
		- //current page italics
		- //wrap entire category in span (for organizing, siblings)
		- filter based on category
			- display category name in page


	- different ways to pull
		- class = .active = get category by name of .text(), send ajax request to pull info


		

	- reference links
		- http://wordpress.stackexchange.com/questions/191352/help-needed-for-custom-walker-menu
		- *** http://stackoverflow.com/questions/24180836/custom-wordpress-walker-advice-needed
		- https://codex.wordpress.org/Class_Reference/Walker

		- http://wordpress.stackexchange.com/questions/36812/how-to-style-current-page-menu-item-when-using-a-walker



*/


if ( is_singular( 'post' ) ){

	echo "SINGLE POST<br>";

	$categories = get_the_category();
	print_r($categories);
	echo "<br />";
}


				  ?>

</div>