<?php
/**********************************************************************************************************************************
*
* Ajax Payment System
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/


add_action( 'PF_AJAX_HANDLER_pfget_itemsystem', 'pf_ajax_itemsystem' );
add_action( 'PF_AJAX_HANDLER_nopriv_pfget_itemsystem', 'pf_ajax_itemsystem' );

function pf_ajax_itemsystem(){
  check_ajax_referer( 'pfget_itemsystem', 'security');
	header('Content-Type: application/json; charset=UTF-8;');

	/* Get form variables */
  if(isset($_POST['formtype']) && $_POST['formtype']!=''){
    $formtype = $processname = esc_attr($_POST['formtype']);
  }

  /* Get data*/
  $vars = array();
  if(isset($_POST['dt']) && $_POST['dt']!=''){
    if ($formtype == 'delete') {
      $pid = sanitize_text_field($_POST['dt']);
    }else{
      $vars = array();
      parse_str($_POST['dt'], $vars);

      if (is_array($vars)) {
          $vars = PFCleanArrayAttr('PFCleanFilters',$vars);
      } else {
          $vars = esc_attr($vars);
      }
    }
    
  }

  /* WPML Fix */
  $lang_c = '';
  if(isset($_POST['lang']) && $_POST['lang']!=''){
    $lang_c = sanitize_text_field($_POST['lang']);
  }
  if(function_exists('icl_t')) {
    if (!empty($lang_c)) {
      do_action( 'wpml_switch_language', $lang_c );
    }
  }


  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;

  $returnval = $errorval = $pfreturn_url = $msg_output = $overlay_add = $sccval = '';
  $icon_processout = 62;
	
  $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

  if ($formtype == 'delete') {
    /**
    *Start: Delete Item for PPP/Membership
    **/
      if($user_id != 0){

        $delete_postid = (is_numeric($pid))? $pid:'';

        if ($delete_postid != '') {
          $old_status_featured = false;
          $setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');
      
          if ($setup4_membersettings_paymentsystem == 2) {

            /*Check if item user s item*/
            global $wpdb;

            $result = $wpdb->get_results( $wpdb->prepare( 
              "SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
              $delete_postid,
              $user_id,
              $setup3_pointposttype_pt1
            ) );
            
            if (is_array($result) && count($result)>0) {  
              if ($result[0]->ID == $delete_postid) {
                $delete_item_images = get_post_meta($delete_postid, 'webbupointfinder_item_images');
                if (!empty($delete_item_images)) {
                  foreach ($delete_item_images as $item_image) {
                    wp_delete_attachment(esc_attr($item_image),true);
                  }
                }
                wp_delete_attachment(get_post_thumbnail_id( $delete_postid ),true);
                $old_status_featured = get_post_meta( $delete_postid, 'webbupointfinder_item_featuredmarker', true );
                wp_delete_post($delete_postid);


                $membership_user_activeorder = get_user_meta( $user_id, 'membership_user_activeorder', true );
                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $membership_user_activeorder,
                    'processname' => esc_html__('Item deleted by USER.','pointfindert2d'),
                    'membership' => 1
                    )
                );

                /* - Create a record for payment system. */
              
                $sccval .= esc_html__('Item successfully deleted. Refreshing...','pointfindert2d');
              }

            }else{
              $icon_processout = 485;
              $errorval .= esc_html__('Wrong item ID or already deleted. Item can not delete.','pointfindert2d');
            }

            /*Membership limits for item /featured limit*/
            
            $membership_user_item_limit = get_user_meta( $user_id, 'membership_user_item_limit', true );
            $membership_user_featureditem_limit = get_user_meta( $user_id, 'membership_user_featureditem_limit', true );
            
            $membership_user_package_id = get_user_meta( $user_id, 'membership_user_package_id', true );
            $packageinfox = pointfinder_membership_package_details_get($membership_user_package_id);

            if ($membership_user_item_limit == -1) {
              /* Do nothing... */
            }else{

              if ($membership_user_item_limit >= 0) {
                $membership_user_item_limit = $membership_user_item_limit + 1;
                if ($membership_user_item_limit <= $packageinfox['webbupointfinder_mp_itemnumber']) {
                  update_user_meta( $user_id, 'membership_user_item_limit', $membership_user_item_limit);
                }
              }
            }


            if($old_status_featured != false && $old_status_featured != 0){

              $membership_user_featureditem_limit = $membership_user_featureditem_limit + 1;
              if ($membership_user_featureditem_limit <= $packageinfox['webbupointfinder_mp_fitemnumber']) {
                update_user_meta( $user_id, 'membership_user_featureditem_limit', $membership_user_featureditem_limit);
              } 
            }
              
            
          } else {
            /*Check if item user s item*/
            global $wpdb;

            $result = $wpdb->get_results( $wpdb->prepare( 
              "SELECT ID, post_author FROM $wpdb->posts WHERE ID = %s and post_author = %s and post_type = %s", 
              $delete_postid,
              $user_id,
              $setup3_pointposttype_pt1
            ) );


            $result_id = $wpdb->get_var( $wpdb->prepare(
              "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s and meta_value = %s", 
              'pointfinder_order_itemid',
              $delete_postid
            ) );

            $pointfinder_order_recurring = esc_attr(get_post_meta( $result_id, 'pointfinder_order_recurring', true ));

            if($pointfinder_order_recurring == 1){

              $pointfinder_order_recurringid = esc_attr(get_post_meta( $result_id, 'pointfinder_order_recurringid', true ));
              PF_Cancel_recurring_payment(
               array( 
                      'user_id' => $user_id,
                      'profile_id' => $pointfinder_order_recurringid,
                      'item_post_id' => $delete_postid,
                      'order_post_id' => $result_id,
                  )
               );
            }

            
            if (is_array($result) && count($result)>0) {  
              if ($result[0]->ID == $delete_postid) {
                $delete_item_images = get_post_meta($delete_postid, 'webbupointfinder_item_images');
                if (!empty($delete_item_images)) {
                  foreach ($delete_item_images as $item_image) {
                    wp_delete_attachment(esc_attr($item_image),true);
                  }
                }
                wp_delete_attachment(get_post_thumbnail_id( $delete_postid ),true);
                wp_delete_post($delete_postid);

                /* - Creating record for process system. */
                PFCreateProcessRecord(
                  array( 
                    'user_id' => $user_id,
                    'item_post_id' => $delete_postid,
                    'processname' => esc_html__('Item deleted by USER.','pointfindert2d')
                    )
                );

                /* - Create a record for payment system. */
              
                $sccval .= esc_html__('Item successfully deleted. Refreshing...','pointfindert2d');
              }

            }else{
              $icon_processout = 485;
              $errorval .= esc_html__('Wrong item ID (Not your item!). Item can not delete.','pointfindert2d');
            }
          }
      
        }else{
          $icon_processout = 485;
          $errorval .= esc_html__('Wrong item ID.','pointfindert2d');
        }
      }else{
        $icon_processout = 485;
        $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
      }

        if (!empty($sccval)) {
          $msg_output .= $sccval;
          $overlay_add = ' pfoverlayapprove';
        }elseif (!empty($errorval)) {
          $msg_output .= $errorval;
        }
    /**
    *End: Delete Item for PPP/Membership
    **/
  } else {
    /**
    *Start: New/Edit Item Form Request
    **/ 

      if(isset($_POST) && $_POST!='' && count($_POST)>0){
				//jschen added, no login as anonymous
					if ($user_id==0) {
						$user_id=65;
						$vars['item_desc'] = '来自：' . $vars['item_url'] . '<br/>联系电话：'. $vars['item_phone'] .'<br/>电子邮件:'. $vars['item_email'] .'<p>内容:</p>'. $vars['item_desc'];

					}
          if($user_id != 0){
            if($vars['action'] == 'pfget_edititem'){
              
              
              if (isset($vars['edit_pid']) && !empty($vars['edit_pid'])) {
                $edit_postid = $vars['edit_pid'];
                global $wpdb;

                $result = $wpdb->get_results( $wpdb->prepare( 
                  "
                    SELECT ID, post_author
                    FROM $wpdb->posts 
                    WHERE ID = %s and post_author = %s and post_type = %s
                  ", 
                  $edit_postid,
                  $user_id,
                  $setup3_pointposttype_pt1
                ) );

                if (is_array($result) && count($result)>0) {
                  if ($result[0]->ID == $edit_postid) {
                    $returnval = PFU_AddorUpdateRecord(
                      array(
                        'post_id' => $edit_postid,
                            'order_post_id' => PFU_GetOrderID($edit_postid,1),
                            'order_title' => PFU_GetOrderID($edit_postid,0),
                        'vars' => $vars,
                        'user_id' => $user_id
                      )
                    );
                  }else{
                    $icon_processout = 485;
                    $errorval .= esc_html__('This is not your item.','pointfindert2d');
                  }
                }else{
                  $icon_processout = 485;
                  $errorval .= esc_html__('Wrong Item ID','pointfindert2d');
                }
              }else{
                $icon_processout = 485;
                $errorval .= esc_html__('There is no item ID to edit.','pointfindert2d');
              }
            }elseif ($vars['action'] == 'pfget_uploaditem') {           
              $returnval = PFU_AddorUpdateRecord(
                array(
                  'post_id' => '',
                      'order_post_id' => '',
                      'order_title' => '',
                  'vars' => $vars,
                  'user_id' => $user_id
                )
              );   
            }
          }else{
              $icon_processout = 485;
              $errorval .= esc_html__('Please login again to upload/edit item (Invalid UserID).','pointfindert2d');
          }   
      }

      if (is_array($returnval) && !empty($returnval)) {
        if (isset($returnval['sccval'])) {
          $msg_output .= $returnval['sccval'];
          $overlay_add = ' pfoverlayapprove';
        }elseif (isset($returnval['errorval'])) {
          $msg_output .= $returnval['errorval'];
        }
      }else{
        $msg_output .= $errorval;
      }
    /**
    *End: New/Edit Item Form Request
    **/
  }
  
  

  
  $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
  $setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
  $pfmenu_perout = PFPermalinkCheck();
	$back_url = html_entity_decode($vars['item_url']);
	if ($back_url == '') 
	{
  	$pfreturn_url = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';
	}
	else {
  	$pfreturn_url = $back_url;
	}

  $output_html = '';
  $output_html .= '<div class="golden-forms wrapper mini" style="height:200px">';
  $output_html .= '<div id="pfmdcontainer-overlay" class="pftrwcontainer-overlay">';
  $output_html .= "<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div>";
  $output_html .= "<div class='pfrevoverlaytext".$overlay_add."'><i class='pfadmicon-glyph-".$icon_processout."'></i><span>".$msg_output."</span></div>";
  $output_html .= '</div>';
  $output_html .= '</div>';    

  if (!empty($errorval)) {  
    echo json_encode( 
      array( 
        'process'=>false, 
        'processname'=>$processname, 
        'mes'=>$output_html, 
        'returnurl' => $pfreturn_url
        )
      );
  }else{
      echo json_encode( 
        array( 
          'process'=>true, 
          'processname'=>$processname, 
          'returnval'=>$returnval, 
          'mes'=>$output_html, 
          'returnurl' => $pfreturn_url
          )
        );
  }


die();
}

?>
