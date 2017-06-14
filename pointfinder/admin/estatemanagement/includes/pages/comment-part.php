<?php 
/**********************************************************************************************************************************
*
* Single Blog Page - Comments Content
* 
* Author: Webbu Design
***********************************************************************************************************************************/



echo '<div class="pfitempagecontainerheader hidden-print" id="comments">';
	if ( comments_open() ){
	   comments_popup_link( esc_html__('No comments yet','pointfindert2d'), esc_html__('1 comment','pointfindert2d'), esc_html__('% comments','pointfindert2d'), 'comments-link', esc_html__('Comments are off for this post','pointfindert2d'));
	}else{
		esc_html_e('Comments','pointfindert2d');
	};
echo '</div>';
echo '<div class="pftcmcontainer golden-forms hidden-print">';
	comments_template();


echo '</div>';

?>