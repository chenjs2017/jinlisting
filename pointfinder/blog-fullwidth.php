<?php 
/*
Template Name: Blog Full Width
*/

get_header();
	
	if(function_exists('PFGetHeaderBar')){PFGetHeaderBar();}

	echo '<div class="pf-blogpage-spacing pfb-top"></div>';
	echo '<section role="main" class="blog-full-width">';
		echo '<div class="pf-container">';
			echo '<div class="pf-row">';
				echo '<div class="col-lg-12">';

					get_template_part('loop');
					

				echo '</div>';
				
			echo '</div>';
		echo '</div>';
	echo '</section>';
	echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';


get_footer();
?>