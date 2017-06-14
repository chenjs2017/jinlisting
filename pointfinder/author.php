<?php 
get_header();
	
	if(isset($_GET['author_name'])){
		$current_author = get_user_by('login',$author_name);
	}else{
		$current_author = get_userdata(intval($author));
	}
	
	if(!empty($current_author)){

		get_template_part('admin/estatemanagement/includes/functions/authorpage','functions');
		if(function_exists('PFGetDefaultPageHeader')){
			PFGetDefaultPageHeader(array('author_id'=>$current_author->ID));
		}

		$setup42_itempagedetails_sidebarpos_auth = PFSAIssetControl('setup42_itempagedetails_sidebarpos_auth','','2');
		echo '<section role="main" class="pf-itempage-maindiv">';
			echo '<div class="pf-container clearfix">';
			echo '<div class="pf-row clearfix">';
    		if ($setup42_itempagedetails_sidebarpos_auth == 2) {
				if(function_exists('PFGetAuthorPageCol1')){PFGetAuthorPageCol1($current_author->ID);}
          		if(function_exists('PFGetAuthorPageCol2')){PFGetAuthorPageCol2();}
			} elseif ($setup42_itempagedetails_sidebarpos_auth == 1) {
				if(function_exists('PFGetAuthorPageCol2')){PFGetAuthorPageCol2();}
          		if(function_exists('PFGetAuthorPageCol1')){PFGetAuthorPageCol1($current_author->ID);}
			}else{
				if(function_exists('PFGetAuthorPageCol1')){PFGetAuthorPageCol1($current_author->ID);}
			}
    		echo '</div>';
        	echo '</div>';
        echo '</section>';
		                
	}else{

		PFPageNotFound(); 

	}


get_footer();
?>