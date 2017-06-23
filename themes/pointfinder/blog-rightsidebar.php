<?php 
/*
Template Name: Blog Right Side Bar
*/

get_header();
	
	if(function_exists('PFGetHeaderBar')){PFGetHeaderBar();}
	
	echo '<div class="pf-blogpage-spacing pfb-top"></div>';
	echo '<section role="main">';
		echo '<div class="pf-container">';
			echo '<div class="pf-row">';
				echo '<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">';

					get_template_part('loop');
					

				echo '</div>';
				echo '<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">';

					get_sidebar('blogpages' ); 
					

				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';
	echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';


get_footer();
?>