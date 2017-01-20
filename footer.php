

<footer class="row">
	<div class="col-sm-10">
		<div class="row">
		<?php 
		// include page for footer:

		$page = get_posts( array( 'name' => 'footer-left','post_type' => 'page' ) );

		//print_r($page);

		if ( $page )
		{
			?><div class="col-sm-4"><?php
		    //echo $page[0]->post_content;
			$ParsedownFooter = new Parsedown();
		    $content = $page[0]->post_content;
			echo $ParsedownFooter->text($content);
			?></div> <?php
		}

		$pageRight = get_posts( array( 'name' => 'footer-right','post_type' => 'page' ) );

		//print_r($page);

		if ( $pageRight )
		{
			?><div class="col-sm-6"> <?php
		    //echo $page[0]->post_content;
			$ParsedownFooterRight = new Parsedown();
		    $content = $pageRight[0]->post_content;
			echo $ParsedownFooter->text($content);
			?> </div><?php
		}



		 ?>
		</div>
	</div>
</footer>


<?php    wp_footer();  ?>
</body>