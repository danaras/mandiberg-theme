<?php 

/* header page*/


 ?>
<head>
	<title>Michael Mandiberg</title>
<?php    wp_head();  ?>
</head>


<body>


<header class="header col-md-12">
<h1><a href="<?php echo get_site_url(); ?>">Michael Mandiberg</a></h1>
<?php 

		wp_nav_menu( array( 'theme_location' => 'header-menu', 
						  'cointainer' => 'div', 
						  'container_class' => 'menu',
						  'walker' => new Description_Walker 
						  ) );

if ( is_singular( 'post' ) ){

	//echo "SINGLE POST<br>";

	//$categories = get_the_category();
	//print_r($categories);
	//echo "<br />";

}



				  ?>

</header>