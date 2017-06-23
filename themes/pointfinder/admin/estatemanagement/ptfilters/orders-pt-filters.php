<?php
/**********************************************************************************************************************************
*
* Orders Post Type Custom Filters
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
	
	$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

	if ($setup4_membersettings_paymentsystem == 1) {
		/**
		*Start: Order List Filters
		**/
			add_action( 'restrict_manage_posts', 'pf_orders_item_filter' );
		    add_filter('parse_query','pf_orders_item_filter_query');
		    function pf_orders_item_filter() {

		        // only display these taxonomy filters on desired custom post_type listings
		        global $typenow;
		        if ($typenow == 'pointfinderorders' ) {
		            echo '<input type="text" name="itemnumber" value="" placeholder="'.esc_html__('Item Number','pointfindert2d').'" />';
		        }
		    }

			function pf_orders_item_filter_query($query) {
		        global $pagenow;
		        global $typenow;
		        if ($pagenow=='edit.php' && $typenow == 'pointfinderorders' && isset($_GET['itemnumber'])) {
		            $query->query_vars['meta_key'] = 'pointfinder_order_itemid';
		            $query->query_vars['meta_value'] = $_GET['itemnumber'];
		        }
		        return $query;
		    }

			
			add_filter( 'manage_edit-pointfinderorders_columns', 'pointfinder_edit_orders_columns' );
			function pointfinder_edit_orders_columns( $columns ) {
			    
			        $columns = array(
			            'cb' => '<input type="checkbox" />',
			            'title' => esc_html__( 'Title','pointfindert2d' ),
			            'istatus' => esc_html__( 'Status','pointfindert2d' ),
			            'itemname' => esc_html__( 'Item','pointfindert2d' ),
			            'price' => esc_html__( 'Total','pointfindert2d' ),
			            'itime' => esc_html__( 'Time','pointfindert2d' ),
			            'itype' => esc_html__( 'Type','pointfindert2d' ),
			            'date' => esc_html__( 'Create Date','pointfindert2d' ),
			            'idate' => esc_html__( 'Expire Date','pointfindert2d' ),
			        );
			    

			    return $columns;
			}

			
			add_filter( 'manage_edit-pointfinderorders_sortable_columns', 'pointfinder_orders_sortable_columns' );

			function pointfinder_orders_sortable_columns( $columns ) {

			    $columns['istatus'] = 'istatus';

			    return $columns;
			}


			
			add_action( 'manage_pointfinderorders_posts_custom_column', 'pointfinder_manage_orders_columns', 10, 2 );

			function pointfinder_manage_orders_columns( $column, $post_id ) {
			    global $post;

			    switch( $column ) {
			        

			        case 'istatus' :

			            $value2 = '';
			            
			            $value2 = get_post_status( $post_id );
			            
			            if($value2 == 'publish'){ 
			                $value2 = '<span style="color:green">'.esc_html__( 'Published', 'pointfindert2d' ).'</span>';
			            }elseif($value2 == 'pendingapproval'){ 
			                $value2 = '<span style="color:red">'.esc_html__( 'Pending Approval', 'pointfindert2d' ).'</span>';
			            }elseif ($value2 == 'pendingpayment') {
			                $value2 = '<span style="color:red">'.esc_html__( 'Pending Payment', 'pointfindert2d' ).'</span>';
			            }elseif ($value2 == 'pfsuspended') {
			                $value2 = '<span style="color:red">'.esc_html__( 'Suspended', 'pointfindert2d' ).'</span>';
			            }elseif ($value2 == 'completed') {
			                $value2 = '<span style="color:green">'.esc_html__( 'Completed', 'pointfindert2d' ).'</span>';
			            }elseif ($value2 == 'pfcancelled') {
			                $value2 = '<span style="color:red">'.esc_html__( 'Cancelled', 'pointfindert2d' ).'</span>';
			            }
			            echo $value2;
			            break;

			        case 'itemname':

			            $prderinfo_itemid = esc_attr(get_post_meta( $post_id , 'pointfinder_order_itemid', true ));
			            
			            if(!empty($prderinfo_itemid)){
			                //echo '<a href="'.get_permalink($item_id).'" target="_blank">'.get_the_title($item_id).'('.$item_id.')</a>';
			                echo '<a href="'.get_edit_post_link($prderinfo_itemid).'" target="_blank"><strong>'.get_the_title($prderinfo_itemid).'('.$prderinfo_itemid.')</strong></a>';
			            }
			            break;

			        case 'price':
			            echo esc_attr(get_post_meta( $post_id, 'pointfinder_order_price', true ));
			            echo esc_attr(get_post_meta( $post_id, 'pointfinder_order_pricesign', true ));
			            break;


			        case 'itime':
			            echo esc_attr(get_post_meta( $post_id, 'pointfinder_order_listingtime', true )).' '.esc_html__('Days','pointfindert2d');
			            break;


			        case 'itype':
			        	$nameofb = esc_attr(get_post_meta( $post_id, 'pointfinder_order_listingpname', true ));

			            if(esc_attr(get_post_meta( $post_id, 'pointfinder_order_recurring', true )) == 1){
			            	echo esc_html__('Recurring','pointfindert2d').' : '.$nameofb;
			            }else{
			            	echo esc_html__('Direct','pointfindert2d').' : '.$nameofb;
			            }
			            break;


			        case 'idate':
			            echo esc_attr(get_post_meta( $post_id, 'pointfinder_order_expiredate', true ));
			            break;

			    }
			}
		/**
		*End: Order List Filters
		**/
	} else {
		/**
		*Start: Order Membership List Filters
		**/
			add_action( 'restrict_manage_posts', 'pf_morders_item_filter' );
		    add_filter('parse_query','pf_morders_item_filter_query');
		    function pf_morders_item_filter() {

		        // only display these taxonomy filters on desired custom post_type listings
		        global $typenow;
		        if ($typenow == 'pointfindermorders' ) {
		            echo '<input type="text" name="usernumber" value="" placeholder="'.esc_html__('User ID','pointfindert2d').'" />';
		            echo '<input type="text" name="itemtitle" value="" placeholder="'.esc_html__('Order ID (Title)','pointfindert2d').'" />';
		        }
		    }

			function pf_morders_item_filter_query($query) {
		        global $pagenow;
		        global $typenow;
		        if ($pagenow=='edit.php' && $typenow == 'pointfindermorders' && isset($_GET['usernumber'])) {
		            $query->query_vars['meta_key'] = 'pointfinder_order_userid';
		            $query->query_vars['meta_value'] = $_GET['usernumber'];
		        }
		        if ($pagenow=='edit.php' && $typenow == 'pointfindermorders' && isset($_GET['itemtitle'])) {
		            $query->query_vars['search_prod_titlex'] = $_GET['itemtitle'];
		            if (!function_exists('pointfinder_orders_titlexe_filter')) {
		            	function pointfinder_orders_titlexe_filter( $where, &$wp_query )
						{
							global $wpdb;
							if ( $search_term = $wp_query->get( 'search_prod_titlex' ) ) {
								if($search_term != ''){
									$search_term = $wpdb->esc_like( $search_term );
									$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql(  $search_term ) . '%\' and post_type = "pointfindermorders"';
								}
							}
							return $where;
						}
		            }

			  		add_filter( 'posts_where', 'pointfinder_orders_titlexe_filter', 10, 2 );
			  		wp_reset_postdata();
		        }
		        return $query;
		    }

			
			add_filter( 'manage_edit-pointfindermorders_columns', 'pointfinder_edit_morders_columns' );
			function pointfinder_edit_morders_columns( $columns ) {
	    		$columns = array(
		            'cb' => '<input type="checkbox" />',
		            'title' => esc_html__( 'Title','pointfindert2d' ),
		            'istatus' => esc_html__( 'Status','pointfindert2d' ),
		            'packageinfo' => esc_html__( 'Package','pointfindert2d' ),
		            'userinfo' => esc_html__( 'User','pointfindert2d' ),
		            'itype' => esc_html__( 'Type','pointfindert2d' ),
		            'date' => esc_html__( 'Create Date','pointfindert2d' ),
		            'idate' => esc_html__( 'Expire Date','pointfindert2d' ),
		        );
			    return $columns;
			}

			
			add_filter( 'manage_edit-pointfindermorders_sortable_columns', 'pointfinder_morders_sortable_columns' );

			function pointfinder_morders_sortable_columns( $columns ) {

			    $columns['istatus'] = 'istatus';

			    return $columns;
			}


			
			add_action( 'manage_pointfindermorders_posts_custom_column', 'pointfinder_manage_morders_columns', 10, 2 );

			function pointfinder_manage_morders_columns( $column, $post_id ) {
			    global $post;

			    switch( $column ) {

			        case 'istatus' :

			            $value2 = '';
			            
			            $value2 = get_post_status( $post_id );
			            
			            if($value2 == 'publish'){ 
			                $value2 = '<span style="color:green">'.esc_html__( 'Published', 'pointfindert2d' ).'</span>';
			            }elseif($value2 == 'pendingapproval'){ 
			                $value2 = '<span style="color:red">'.esc_html__( 'Pending Approval', 'pointfindert2d' ).'</span>';
			            }elseif ($value2 == 'pendingpayment') {
			                $value2 = '<span style="color:red">'.esc_html__( 'Pending Payment', 'pointfindert2d' ).'</span>';
			            }elseif ($value2 == 'pfsuspended') {
			                $value2 = '<span style="color:red">'.esc_html__( 'Suspended', 'pointfindert2d' ).'</span>';
			            }elseif ($value2 == 'completed') {
			                $value2 = '<span style="color:green">'.esc_html__( 'Completed', 'pointfindert2d' ).'</span>';
			            }elseif ($value2 == 'pfcancelled') {
			                $value2 = '<span style="color:red">'.esc_html__( 'Cancelled', 'pointfindert2d' ).'</span>';
			            }
			            echo $value2;
			            break;

			        case 'packageinfo':

		        		$prderinfo_itemid = esc_attr(get_post_meta( $post_id , 'pointfinder_order_packageid', true ));
		            
			            if(!empty($prderinfo_itemid)){
			                echo '<a href="'.get_edit_post_link($prderinfo_itemid).'" target="_blank"><strong>'.get_the_title($prderinfo_itemid).'</strong></a>';
			            }
			            break;

			        case 'userinfo':

		        		$user_id = get_post_meta( $post_id, 'pointfinder_order_userid', true );
		            	$userdata = get_user_by('id',$user_id);
		            	echo '<a href="'.get_edit_user_link($user_id).'" target="_blank" title="'.esc_html__('Click for user details','pointfindert2d').'">'.$user_id.' - '.$userdata->nickname.'</a>';
			            break;



			        case 'itype':
			        	$nameofb = esc_attr(get_post_meta( $post_id, 'pointfinder_order_listingpname', true ));

			            if(esc_attr(get_post_meta( $post_id, 'pointfinder_order_recurring', true )) == 1){
			            	echo esc_html__('Recurring','pointfindert2d');
			            }else{
			            	echo esc_html__('Direct','pointfindert2d');
			            }
			            break;


			        case 'idate':
			            echo PFU_DateformatS(get_post_meta( $post_id, 'pointfinder_order_expiredate', true ),1);
			            break;

			    }
			}
		/**
		*End: Order Membership List Filters
		**/
	}

?>