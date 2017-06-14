<?php 
/*
Template Name: Terms & Conditions
*/

get_header();

	echo '<section role="main">';

		echo '<div class="pf-termsconditions-class">'; 
			if (have_posts()){ 
    			while (have_posts()) : the_post();
				the_content();
				endwhile;
			};
		echo '</div>';

    echo '</section>';

get_footer();
?>