<?php 
/**********************************************************************************************************************************
*
* Item Detail Page - Comments Content
* 
* Author: Webbu Design
***********************************************************************************************************************************/


$setup3_modulessetup_allow_comments = PFSAIssetControl('setup3_modulessetup_allow_comments','','0');
if($setup3_modulessetup_allow_comments == 1){
	
	echo '<div class="pftcmcontainer golden-forms hidden-print pf-itempagedetail-element">';
	echo '<div class="pfitempagecontainerheader" id="comments">';
		if ( comments_open() ){
		   comments_popup_link( esc_html__('No comments yet','pointfindert2d'), esc_html__('1 comment','pointfindert2d'), esc_html__('% comments','pointfindert2d'), 'comments-link', esc_html__('Comments are off for this post','pointfindert2d'));
		}else{
			esc_html_e('Comments','pointfindert2d');
		};
	echo '</div>';
	
		comments_template();


	echo '</div>';
}
?>