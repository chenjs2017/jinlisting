<?php
/**********************************************************************************************************************************
*
* Update notice
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
if (current_user_can( 'activate_plugins' )) {

    /*add_action('admin_notices', 'pointfinder_afterinstall_admin_notice');*/

    function pointfinder_afterinstall_admin_notice() {
    	global $current_user ;
        $user_id = $current_user->ID;

    	if ( ! get_user_meta($user_id, 'pointfinder_afterinstall_admin_notice') ) {
            echo '<div class="updated pointfinder-install-nag" style="position:relative"><p>'; 
            echo '<h3>Point Finder Help Doc Information</h3>';

            echo '<ul>';

                echo '<li><strong>Help Docs : </strong>';
                echo '<a href="http://docs.pointfindertheme.com" target="_blank">http://docs.pointfindertheme.com</a>';
                echo '</li>';

                echo '<li><strong>Ideal Hosting Settings : </strong>';
                echo '<a href="http://docs.pointfindertheme.com/?p=142" target="_blank">View</a>';
                echo '</li>';

                echo '<li><strong>Common Installation Errors & Solutions : </strong>';
                echo '<a href="http://docs.pointfindertheme.com/?p=140" target="_blank">View</a>';
                echo '</li>';

                echo '<li><strong>Changelog : </strong>';
                printf('<a href="%1$s" target="_blank">View</a>','http://support.webbudesign.com/forums/topic/changelog/');
                echo '</li>';

            echo '</ul>';

            echo '<a id="pfnoticedismiss" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></a>';
            echo "</p></div>";

            echo "
            <script>
            (function($) {
            'use strict';
            $('#pfnoticedismiss').click(function(){
                var ntype = 'install';
                var nstatus = 0;

                $.ajax({
                    beforeSend:function(){},
                    url: '".get_template_directory_uri()."/admin/core/pfajaxhandler.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'pfget_nagsystem',
                        ntype: ntype,
                        nstatus: nstatus,
                        security: '".wp_create_nonce('pfget_nagsystem')."'
                    },
                }).success(function(obj){
                    console.log(obj);
                    $('.pointfinder-install-nag').hide();

                }).complete(function(){

                });
            });
            })(jQuery);
            </script>
            ";
            
    	}
    }

    /*add_action('admin_init', 'pointfinderafterinstall_nag_enable');*/
    
    function pointfinderafterinstall_nag_enable() {
            global $current_user;
            $user_id = $current_user->ID;
            if ( isset($_GET['pointfinderafterinstall_nag_enable']) && '0' == $_GET['pointfinderafterinstall_nag_enable'] ) {
                 delete_user_meta($user_id, 'pointfinder_afterinstall_admin_notice');
            }
    }



    /*Important notice
    add_action('admin_notices', 'pointfinder_afterinstall_admin_notice2');
    */
    function pointfinder_afterinstall_admin_notice2() {
       /*
        global $current_user ;
        $user_id = $current_user->ID;

        if ( ! get_user_meta($user_id, 'pointfinder_afterinstall_admin_notice2') ) {
            echo '<div class="updated pointfinder-install-nag2" style="position:relative"><p>'; 
            echo '<h3>Point Finder v1.6.4.5 Notice</h3>';

            echo '<ul>';

                echo '<li>';
                echo '<font style="color:#DC0000"><strong>If you are using Paypal or Stripe payment system. Please read this warning.</strong><br/><br/>The new panel <a href="'.admin_url('admin.php?page=_pfpgconf').'"><strong>Payment Gateways</strong></a> added under the <a href="'.admin_url('admin.php?page=pointfinder_tools').'"><strong>PF Settings</strong></a>. Paypal and Stripe settings was automatically copied into this panel. Please control all Paypal and Stripe Payment API information by using <a href="'.admin_url('admin.php?page=_pfpgconf').'"><strong>Payment Gateways</strong></a> panel. Pointfinder will stay to use informations from Options Panel. But I am planning to remove Paypal and Stripe settings under Options Panel with next update (v1.7).</font>';
                echo '</li>';

            echo '</ul>';

            echo '<a id="pfnoticedismiss2" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></a>';
            echo "</p></div>";

            echo "
            <script>
            (function($) {
            'use strict';
            $('#pfnoticedismiss2').click(function(){
                var ntype = 'install2';
                var nstatus = 0;

                $.ajax({
                    beforeSend:function(){},
                    url: '".get_template_directory_uri()."/admin/core/pfajaxhandler.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'pfget_nagsystem',
                        ntype: ntype,
                        nstatus: nstatus,
                        security: '".wp_create_nonce('pfget_nagsystem')."'
                    },
                }).success(function(obj){
                    console.log(obj);
                    $('.pointfinder-install-nag2').hide();

                }).complete(function(){

                });
            });
            })(jQuery);
            </script>
            ";
            
        }
        */
    }

    /*add_action('admin_init', 'pointfinderafterinstall_nag_enable2');*/

    function pointfinderafterinstall_nag_enable2() {
        /*
            global $current_user;
            $user_id = $current_user->ID;
            if ( isset($_GET['pointfinderafterinstall_nag_enable2']) && '0' == $_GET['pointfinderafterinstall_nag_enable2'] ) {
                 delete_user_meta($user_id, 'pointfinder_afterinstall_admin_notice2');
            }
            */
    }
}