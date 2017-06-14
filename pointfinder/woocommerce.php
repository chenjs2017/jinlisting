<?php 
get_header();

    if(function_exists('PFGetHeaderBar')){
        PFGetDefaultPageHeader();
    }


    $setup_item_woocom_sidebarpos = PFASSIssetControl('setup_item_woocom_sidebarpos','','2');

        echo '<section role="main">';
            echo '<div class="pf-blogpage-spacing pfb-top"></div>';
            echo '<div class="pf-container"><div class="pf-row">';
                
                if ($setup_item_woocom_sidebarpos == 3) {
                    echo '<div class="col-lg-12">';
                    echo '<div class="">'; 
                        woocommerce_content();
                    echo '</div>';
                    echo '</div>';
                }else{
                    if($setup_item_woocom_sidebarpos == 1){
                        echo '<div class="col-lg-3 col-md-4">';
                            get_sidebar('woocom'); 
                        echo '</div>';
                    }
                      
                    echo '<div class="col-lg-9 col-md-8">'; 
                    echo '<div class="">'; 
                        woocommerce_content();
                    echo '</div>';
                    echo '</div>';
                    if($setup_item_woocom_sidebarpos == 2){
                        echo '<div class="col-lg-3 col-md-4">';
                            get_sidebar('woocom');
                        echo '</div>';
                    }
                }
                
            echo '</div></div>';
            echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';
        echo '</section>';
    

get_footer(); 
?>