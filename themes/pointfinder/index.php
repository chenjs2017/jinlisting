<?php 
get_header();

if (is_home() && (get_option('show_on_front') == 'posts' || get_option('show_on_front') == 'page')) {
	echo '<div class="pf-blogpage-spacing pfb-top"></div>';
	echo '<section role="main">';
		echo '<div class="pf-container">';
			echo '<div class="pf-row">';
				echo '<div class="col-lg-12">';

					get_template_part('loop');
					

				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</section>';
	echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';
}else{

	if(function_exists('PFPageNotFound')){
    	PFPageNotFound();
    } 
}

get_footer();
?>