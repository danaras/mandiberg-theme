<?php 

/* header page*/


 ?>
<head>
	<title>Michael Mandiberg</title>
<?php    wp_head();  ?>
</head>


<body>
	


<div class="header">
<p style="text-transform: uppercase;">Michael Mandiberg</p>
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

</div>