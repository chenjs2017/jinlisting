<?php 
get_header();

    if (have_posts()){
        
        while (have_posts()){
            the_post();
            $post_id = get_the_id();

            $pf_page_status = 'show';

            if (function_exists('is_bbpress')) {
                if (is_bbpress()) {
                    
                    $setupbbpress_general_sidebarpos = PFASSIssetControl('setupbbpress_general_sidebarpos','','2');
                   
                    if(function_exists('PFGetDefaultPageHeader')){PFGetDefaultPageHeader();}

                    echo '<section role="main">';
                        echo '<div class="pf-bbpress-spacing"></div>';
                        echo '<div class="pf-container"><div class="pf-row clearfix">';

                            if ($setupbbpress_general_sidebarpos == 3) {
                                echo '<div class="col-lg-12"><div class="pf-bbpress-forum-container">';
                                    echo the_content();
                                echo '</div></div>';
                            }else{
                                if($setupbbpress_general_sidebarpos == 1){
                                    echo '<div class="col-lg-3 col-md-4">';
                                        get_sidebar('bbPress' ); 
                                    echo '</div>';
                                }
                                
                                echo '<div class="col-lg-9 col-md-8"><div class="pf-bbpress-forum-container">'; 

                                the_content();

                                echo '</div></div>';

                                if($setupbbpress_general_sidebarpos == 2){
                                    echo '<div class="col-lg-3 col-md-4">';
                                        get_sidebar('bbPress' ); 
                                    echo '</div>';
                                }
                            }

                        echo '</div></div>';
                        echo '<div class="pf-bbpress-spacing"></div>';
                    echo '</section>';
                    $pf_page_status = 'hide';

                }
            }


            if($pf_page_status == 'show'){
             
                if(PFSAIssetControl('setup4_membersettings_loginregister','','1') == 1){
                  
                    get_template_part('admin/estatemanagement/includes/pages/dashboard/dashboard','ipnlistener'); 
                    get_template_part('admin/estatemanagement/includes/pages/dashboard/dashboard','page'); 
               
                }else{
                    
                    if(function_exists('PFGetHeaderBar')){
                      PFGetHeaderBar($post_id);
                    }
                 
                   if (!has_shortcode( get_the_content() , 'vc_row' )) {
                        echo '<div class="pf-blogpage-spacing pfb-top"></div>';
                        echo '<section role="main">';
                            echo '<div class="pf-container">';
                                echo '<div class="pf-row">';
                                    echo '<div class="col-lg-12">';
                                        the_content();
                                      
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</section>';
                        echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';
                    }else{
                        the_content();
                    }
                }
            }
            
        };

     }else{
     	if(function_exists('PFPageNotFound')){
        	PFPageNotFound();
        } 
     };
     

get_footer(); 
?>