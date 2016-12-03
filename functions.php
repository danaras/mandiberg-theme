<?php
/*



*/

	//hides admin bar

	show_admin_bar( false );

	//function to initiate any js files, etc
	function mandiberg_scripts() {

		// Register the style like this for a theme:
	    wp_register_style( 'mandiberg-style', get_template_directory_uri() . '/style.css', array(), '20120208', 'all' );
		wp_enqueue_style( 'mandiberg-style');

		//barba js for transitions

		 wp_register_script('barba', get_template_directory_uri() . '/build/barba.min.js', array ( 'jquery' ),'1.1', true);
		 wp_enqueue_script('barba');

		//js
		wp_register_script('js-file', get_template_directory_uri() . '/build/script.js', array ( 'jquery' ),'1.1', true);
		 wp_enqueue_script('js-file');

		

	}
	add_action( 'wp_enqueue_scripts', 'mandiberg_scripts' );

/*load fonts: */

function load_fonts() {
            wp_register_style('et-googleFonts', 'https://fonts.googleapis.com/css?family=Roboto:400,400i');
            wp_enqueue_style( 'et-googleFonts');
        }
    add_action('wp_print_styles', 'load_fonts');


/* load menus */

function register_my_menu() {
  register_nav_menu('header-menu',__( 'Category Menu' ));
}
add_action( 'init', 'register_my_menu' );

// offers alternate to the menu walker key: 

class Description_Walker extends Walker {

    // Tell Walker where to inherit it's parent and id values
    var $db_fields = array(
        'parent' => 'menu_item_parent', 
        'id'     => 'db_id' 
    );


    // Configure the start of each level
	function start_lvl(&$output, $depth = 0, $args = array()) {
	    $output .= "<span class='subcategories'>";
	}

	// Configure the end of each level
	function end_lvl(&$output, $depth = 0, $args = array()) {
	    $output .= "</span>";
	}


    // outlines new wrapping (generalized across all categories)
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        
        //wraps category section and category name (see end_el for end of ca)
        if ( $depth === 0 ) {
        	$output .= sprintf( "\n<span id='category-section-".$item->ID."'><a class='category' id='category-".$item->ID."' href='%s' %s >%s</a>\n",
	            $item->url,
	            ( $item->object_id === get_the_ID() ) ? ' class="current"' : '',
	            $item->title
	        );

        }
    	

    	//if the depth of the menu exceeds the top level (0), generate a new wrapper for each object.
    	if ( $depth > 0 ) {
	        $output .= sprintf( "\n<a class='subcategory' id='subcategory-".$item->ID."' href='%s' %s >%s</a>,\n",
	            $item->url,
	            ( $item->object_id === get_the_ID() ) ? ' class="category"' : '',
	            $item->title
	        );
    	}
    } //end of start_el


    function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    	//ends wrap of category section
    	if ( $depth === 0 ) {
        	$output .= sprintf( "\n</span>\n",
	            $item->url,
	            ( $item->object_id === get_the_ID() ) ? ' class="current"' : '',
	            $item->title
	        );

        }
    } //end of end_el function 

} //end of extends walker function

// add 'active' state filter of current and potential parent(s) and wrapper to produce italics line
//if category is clicked, reveal subcategories

add_filter('menu' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('category', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}




/*

add_filter needs to:

if(category){

	1. reveal subcategories (i.e. display sibling .subcategories)
	2. italicize this category

}

if(subcategory){
	
	1. italicize this subcategory
	2. italicize parent (i.e. parent sibling .category)
	3. move this subcategory to beginning of span .subcategories (i.e. parent)

}




*/


?>
