<div class="sidebar-widget">
	<?php 
	$_page_sidebar = redux_post_meta("pointfinderthemefmb_options", get_the_id(), "webbupointfinder_page_sidebar");
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($_page_sidebar));
	?>
</div>