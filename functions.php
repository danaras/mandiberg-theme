<?php
/*
ToC

- function to add scripts
- load fonts
- add thumbnail support
- load menu
- 


*/

	//hides admin bar (REMOVE BEFORE PUBLISHING:)
	show_admin_bar( false );

	//function to initiate any js files, etc
	function mandiberg_scripts() {

		//include bootstrap:
		wp_register_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
		wp_enqueue_style( 'bootstrap-style');



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

	// function load_fonts() {
 //            wp_register_style('et-googleFonts', 'https://fonts.googleapis.com/css?family=Roboto:400,400i');
 //            wp_enqueue_style( 'et-googleFonts');
 //    }
 //    add_action('wp_print_styles', 'load_fonts');


/* add Thumbnail images to posts */

	add_theme_support( 'post-thumbnails' ); 

/* LOAD MENUS */

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
	        
	    	$class_names = $value = '';

	        $classes = empty( $item->classes ) ? array() : (array) $item->classes; //array of all classes associated with each category + subcategory


	        // posts are sequential
	        // pages exist outside time sequence

	        if ( is_singular( 'post' ) ){ //if the given page is just a post
	        	
	        	$categories = get_the_category();
				
				if ( ! empty( $categories ) ) {  // if category array has contents: 
				    
				   // echo esc_html( $categories[0]->name ); //gives category or subcategory name

				   // print_r($categories);

					// this tests what parents each category has:
					//$parentCategory = get_category_parents( $categories );
						//print_r($parentCategory);

				
					foreach ($categories as $category) {

						
						// i think this conditional isn't inclusive enough

						// does this try and define a step by stepp basis? 

						if ($category->parent === 0) { //for categories:
							//echo $category->parent;
							// if category->parent is equal to 0

							// definine category name as active or not active
							$category_names = ($category->name == $item->title) ? ' active' : 'notactive';
							// this isnt showing up on new.mandiberg.com


							

						} else{ //for subcategories: 

							$category_names = ($category->name == $item->title) ? ' active' : 'notactive';

							// Define subcategory class...
							$subcategory_names = ($category->name == $item->title) ? 'sub-active' : 'sub-notactive';

							$posting = get_post();
							//$post_name =  $posting->post_title;

							// add the post name into the title:
							$post_name = ($category->name == $item->title) ? ' →<a class="active-title" href="'.$posting->post_url.'">'.$posting->post_title.'</a>' : '';


						}
					}	
					//if 'current-menu-item' is in array of item classes
					

				}

			} else{ //for the rest of the pages (not a single post):

				$category_names = in_array("current-menu-item", $item->classes) ? ' active' : 'notactive';
	        $subcategory_names = in_array("current-menu-item", $item->classes) ? 'sub-active' : 'sub-notactive'; // conditional for if/else the array of classes ^^ is current or not

	        $post_name = '';
			}

	        //wraps category section and category name (see end_el for end of ca)
	        if ( $depth === 0 ) {
	        	$output .= sprintf( "\n<span class='category-group' id='category-section-".$item->ID."'><a href='%s' class='category %s' id='category-".$item->ID."' > %s</a>\n",
		            $item->url,
		            $category_names, //if $classes[4] === current_page_item
		            $item->title
		        );
	        } 	



	    	//if the depth of the menu exceeds the top level (0), generate a new wrapper for each object.
	    	if ( $depth > 0 ) {
		        $output .= sprintf( "\n<span class='subcategory %s'><a href='%s' id='subcategory-".$item->ID."'  >%s</a>%s,</span>\n",
		        	$subcategory_names, //if $classes[4] === current_page_item
		            $item->url,
		            $item->title,
		            $post_name
		        );
	    	}
	    } //end of start_el


	    function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	    	//ends wrap of category section
	    	if ( $depth === 0 ) {
	        	$output .= sprintf( "\n</span>\n"
		        );

	        }
	    } //end of end_el function 

	} //end of extends walker function


/*

	- things still to do
		- //figure out how to wrap all subcategories into one <span> (to hide)
		- //on click of category links to category page and reveals subcategories. 
		- //current page italics
		- //wrap entire category in span (for organizing, siblings)
		- //filter based on category
			- //display category name in page
		- //receive filler images
		- //have menu show post title if on single page	

		- //have homepage only show tagged:featured work
			- //means adding theme support for thumbnails & excerpt text

		- //install Bootstrap
		- css
		- //how to show single page (linked from the menu)
			- //if category returns only one post -> go directly to post 

		- footer
			- mailing list — ?????
			- //social links (can be added)

		- project/ post page
			- related news...?
			- 

		- menu
			- how to deal with multiple subcategories?
				- ignore for now

		- post initial launch
			- barba fades
				- menu fade ? inactive visibility none? 





	- different ways to pull
		- class = .active = get category by name of .text(), send ajax request to pull info

	- reference links
		- http://wordpress.stackexchange.com/questions/191352/help-needed-for-custom-walker-menu
		- *** http://stackoverflow.com/questions/24180836/custom-wordpress-walker-advice-needed
		- https://codex.wordpress.org/Class_Reference/Walker

		- http://wordpress.stackexchange.com/questions/36812/how-to-style-current-page-menu-item-when-using-a-walker


		- https://code.tutsplus.com/articles/11-quick-tips-securing-your-wordpress-site--wp-22446

*/

	










?>
