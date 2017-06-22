<?php
//$useragent=$_SERVER['HTTP_USER_AGENT'];
//$if_mobile=False;
//if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
//    $if_mobile=True;
//}
//$location=$_GET['field296725954161956900000'];

//if(empty($location) && isset($_COOKIE[jinlisting_zipcode])) {
//	$location= $_COOKIE[jinlisting_zipcode];
//}
//if ( empty($location) && ($if_mobile == true))
//{
//    $location='10001';
//}
//$tax_id    = get_queried_object()->term_id;
//$new_url="?field_listingtype=".$tax_id."&pointfinder_radius_search=10&field296725954161956900000=".$location."&ne=&ne2=&sw=&sw2=&s=&serialized=1&action=pfs";
//if (!(is_wp_error( $tax_id ))) {
//	header("Location: " . $new_url);
//}
get_header();

	global $wp_query;
	$pf_category = 0;

	if(isset($wp_query->query_vars['taxonomy'])){
		$taxonomy_name = $wp_query->query_vars['taxonomy'];
		if (in_array($taxonomy_name, array('pointfinderltypes','pointfinderitypes','pointfinderconditions','pointfinderlocations','pointfinderfeatures'))) {
			
			$term_slug = $wp_query->query_vars['term'];
			$pf_category = 1;
			$term_name = get_term_by('slug', $term_slug, $taxonomy_name,'ARRAY_A');
			
			$get_termname = $term_name['name'];
			$get_term_nameforlink = '<a href="'.get_term_link( $term_name['term_id'], $taxonomy_name ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s","pointfindert2d" ), $term_name['name']) ) . '">'.$term_name['name'].'</a>';

			if (!empty($term_name['parent'])) {
				$term_parent_name = get_term_by('id', $term_name['parent'], $taxonomy_name,'ARRAY_A');
				$get_termname = $term_parent_name['name'].' / '.$term_name['name'];
				$get_term_nameforlink = '<a href="'.get_term_link( $term_name['parent'], $taxonomy_name ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s","pointfindert2d" ), $term_parent_name['name']) ) . '">'.$term_parent_name['name'].'</a> / '.'<a href="'.get_term_link( $term_name['term_id'], $taxonomy_name ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s","pointfindert2d" ), $term_name['name']) ) . '">'.$term_name['name'].'</a>';
			}

			$filter_text = '';

			switch ($taxonomy_name) {
				case 'pointfinderltypes':
					$filter_text .= 'listingtype = "'.$term_name['term_id'].'"';
					break;
				
				case 'pointfinderitypes':
					$filter_text .= 'itemtype = "'.$term_name['term_id'].'"';
					break;

				case 'pointfinderlocations':
					$filter_text .= 'locationtype = "'.$term_name['term_id'].'"';
					break;

				case 'pointfinderfeatures':
					$filter_text .= 'features = "'.$term_name['term_id'].'"';
					break;

				case 'pointfinderconditions':
					$filter_text .= 'conditions = "'.$term_name['term_id'].'"';
					break;
			}

		}
	}
		
	
	
	if ($pf_category == 0) {
		$setup_item_blogcatpage_sidebarpos = PFASSIssetControl('setup_item_blogcatpage_sidebarpos','','2');
		if(function_exists('PFGetDefaultPageHeader')){PFGetDefaultPageHeader();}
		echo '<div class="pf-blogpage-spacing pfb-top"></div>';
		echo '<section role="main">';
			echo '<div class="pf-container">';
				echo '<div class="pf-row">';
					if ($setup_item_blogcatpage_sidebarpos == 3) {
		        		echo '<div class="col-lg-12">';

							get_template_part('loop');

						echo '</div>';
		        	}else{
		        	
			            if($setup_item_blogcatpage_sidebarpos == 1){
			                echo '<div class="col-lg-3 col-md-4">';
			                    if (is_active_sidebar( 'pointfinder-blogcatpages-area' )) {

			                    	get_sidebar('catblog' );
			                    } else {
			                    	get_sidebar();
			                    }
			                    
			                echo '</div>';
			            }
			              
			            echo '<div class="col-lg-9 col-md-8">'; 
			            
			            get_template_part('loop');

			            echo '</div>';
			            if($setup_item_blogcatpage_sidebarpos == 2){
			                echo '<div class="col-lg-3 col-md-4">';
			                    if (is_active_sidebar( 'pointfinder-blogcatpages-area' )) {
			                    	get_sidebar('catblog' );
			                    } else {
			                    	get_sidebar();
			                    }
			                echo '</div>';
			            }

		            }
				echo '</div>';
			echo '</div>';
		echo '</section>';
		echo '<div class="pf-blogpage-spacing pfb-bottom"></div>';

	}else{

        $setup_item_catpage_sidebarpos = PFASSIssetControl('setup_item_catpage_sidebarpos','','2');
        
		
		$pointfinderltypesas_vars = get_option('pointfinderltypesas_vars');
        $pf_cat_imagebg = (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_imagebg']))? $pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_imagebg']: 2;

        if ($pf_cat_imagebg == 1) {
        	if(function_exists('PFGetDefaultCatPageHeader')){
        		PFGetDefaultCatPageHeader(
        			array(
        				'taxname' => $get_termname,
        				'taxnamebr' => $get_term_nameforlink,
        				'taxinfo'=>$term_name['description'],
        				'pf_cat_textcolor' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_textcolor']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_textcolor']:'',
        				'pf_cat_backcolor' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_backcolor']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_backcolor']:'',
        				'pf_cat_bgimg' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgimg']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgimg']:'',
        				'pf_cat_bgrepeat' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgrepeat']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgrepeat']:'',
        				'pf_cat_bgsize' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgsize']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgsize']:'',
        				'pf_cat_bgpos' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgpos']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_bgpos']:'',
        				'pf_cat_headerheight' => (isset($pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_headerheight']))?$pointfinderltypesas_vars[$term_name['term_id']]['pf_cat_headerheight']:'',
        			)
        		);
        	}
        }else{
        	if(function_exists('PFGetDefaultPageHeader')){
        		PFGetDefaultPageHeader(
        			array(
        				'taxname' => $get_termname,
        				'taxnamebr' => $get_term_nameforlink,
        				'taxinfo'=>$term_name['description']
        			)
        		);
        	}
        }


		$setup42_authorpagedetails_grid_layout_mode = PFSAIssetControl('setup22_searchresults_grid_layout_mode','','1');
		$setup42_authorpagedetails_defaultppptype = PFSAIssetControl('setup22_searchresults_defaultppptype','','10');

		$setup22_searchresults_defaultsortbytype = PFSAIssetControl('setup22_searchresults_defaultsortbytype','','Date');
		$setup22_searchresults_defaultsorttype = PFSAIssetControl('setup22_searchresults_defaultsorttype','','DESC');
		$setup22_searchresults_defaultlistingtype = PFSAIssetControl('setup22_dlcfc','','3');

		$setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');
		$setup42_authorpagedetails_grid_layout_mode = ($setup42_authorpagedetails_grid_layout_mode == 1) ? 'fitRows' : 'masonry' ;
		$setup22_searchresults_background2 = PFSAIssetControl('setup22_searchresults_background2','','#ffffff');
		$setup22_searchresults_status_catfilters = PFSAIssetControl('setup22_searchresults_status_catfilters','','1');
		$stp22_infscrl_c = PFSAIssetControl('stp22_infscrl_c','',0);
		$stp22_infscrl_c2 = PFSAIssetControl('stp22_infscrl_c2','',0);
		
		if ($setup22_searchresults_status_catfilters == 1) {
			$filters_text = 'true';
		}else{
			$filters_text = 'false';
		}

		$listing_cat_filter = (PFASSIssetControl('setup_gridsettings_ltype_filter','',0) == 1)?'yes':'';
		$item_cat_filter = (PFASSIssetControl('setup_gridsettings_itype_filter','',0) == 1)?'yes':'';
		$loc_cat_filter = (PFASSIssetControl('setup_gridsettings_location_filter','',0) == 1)?'yes':'';
		
		echo '<section role="main">';
	        echo '<div class="pf-page-spacing"></div>';
	        echo '<div class="pf-container"><div class="pf-row clearfix">';
	        	if ($setup_item_catpage_sidebarpos == 3) {
	        		echo '<div class="col-lg-12"><div class="pf-page-container">';
						echo do_shortcode('[pf_itemgrid2 listingtypefilters="'.$listing_cat_filter.'" itemtypefilters="'.$item_cat_filter.'" locationfilters="'.$loc_cat_filter.'" orderby="" sortby="" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" filters="'.$filters_text.'" itemboxbg="'.$setup22_searchresults_background2.'" infinite_scroll="'.$stp22_infscrl_c.'" infinite_scroll_lm="'.$stp22_infscrl_c2.'" '.$filter_text.']' );
					echo '</div></div>';
	        	}else{
	        		if($setup_item_catpage_sidebarpos == 1){
		                echo '<div class="col-lg-3 col-md-4">';
		                    get_sidebar('itemcats' ); 
		                echo '</div>';
		            }
		              
		            echo '<div class="col-lg-9 col-md-8"><div class="pf-page-container">';
                    $useragent=$_SERVER['HTTP_USER_AGENT'];
                    if(false && preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
                        ?>
                        <div class="sidebar-widget">
                            <div id="pf_search_items_w-14" class="widget_pfitem_recent_entries">
                                <div class="pfwidgettitle">
                                    <div class="widgetheader">商家搜索</div>
                                </div>
                                <div class="pfwidgetinner">
                                    <form id="pointfinder-search-form-manual" method="get"
                                          action="<?php echo esc_url(home_url()); ?>" data-ajax="false">
                                        <div class="pfsearch-content golden-forms">
                                            <div class="pfsearchformerrors">
                                                <ul>
                                                </ul>
                                                <a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE', 'pointfindert2d') ?></a>
                                            </div>
                                            <?php
                                            $setup1s_slides = PFSAIssetControl('setup1s_slides', '', '');

                                            if (is_array($setup1s_slides)) {

                                                /**
                                                 *Start: Get search data & apply to query arguments.
                                                 **/

                                                $pfgetdata = $_GET;

                                                if (is_array($pfgetdata)) {

                                                    $pfformvars = array();

                                                    foreach ($pfgetdata as $key => $value) {
                                                        if (!empty($value) && $value != 'pfs') {
                                                            $pfformvars[$key] = $value;
                                                        }
                                                    }

                                                    $pfformvars = PFCleanArrayAttr('PFCleanFilters', $pfformvars);

                                                }
                                                /**
                                                 *End: Get search data & apply to query arguments.
                                                 **/
                                                $PFListSF = new PF_SF_Val();
                                                foreach ($setup1s_slides as &$value) {

                                                    $PFListSF->GetValue($value['title'], $value['url'], $value['select'], 1, $pfformvars);

                                                }


                                                /*Sense Category*/
                                                $current_post_id = get_the_id();

                                                if (!empty($current_post_id) && (is_single())) {
                                                    $current_post_terms = get_the_terms($current_post_id, 'pointfinderltypes');

                                                    if (isset($current_post_terms) && $current_post_terms != false) {
                                                        foreach ($current_post_terms as $key => $value) {
                                                            $category_selected_auto = $value->term_id;
                                                        }

                                                    }
                                                } elseif (!empty($current_post_id) && (is_category() || is_archive() || is_tag())) {
                                                    global $wp_query;

                                                    if (isset($wp_query->query_vars['taxonomy'])) {
                                                        $taxonomy_name = $wp_query->query_vars['taxonomy'];
                                                        if ($taxonomy_name == 'pointfinderltypes') {
                                                            $term_slug = $wp_query->query_vars['term'];
                                                            $term_name = get_term_by('slug', $term_slug, $taxonomy_name, 'ARRAY_A');
                                                            if (isset($term_name['term_id'])) {
                                                                $category_selected_auto = $term_name['term_id'];
                                                            }
                                                        }

                                                    }
                                                }


                                                /*Get Listing Type Item Slug*/
                                                $fltf = pointfinder_find_requestedfields('pointfinderltypes');
                                                $features_field = pointfinder_find_requestedfields('pointfinderfeatures');
                                                $itemtypes_field = pointfinder_find_requestedfields('pointfinderitypes');
                                                $conditions_field = pointfinder_find_requestedfields('pointfinderconditions');

                                                $stp_syncs_it = PFSAIssetControl('stp_syncs_it', '', 1);
                                                $stp_syncs_co = PFSAIssetControl('stp_syncs_co', '', 1);
                                                $setup4_sbf_c1 = PFSAIssetControl('setup4_sbf_c1', '', 1);

                                                $second_request_process = false;
                                                $second_request_text = "{features:'',itemtypes:'',conditions:''}";
                                                $multiple_itemtypes = $multiple_features = $multiple_conditions = '';

                                                if (!empty($features_field) || !empty($itemtypes_field) || !empty($conditions_field)) {
                                                    $second_request_process = true;
                                                    $second_request_text = '{';
                                                    if (!empty($features_field) && $setup4_sbf_c1 == 0) {
                                                        $second_request_text .= "features:'$features_field'";
                                                        $multiple_features = PFSFIssetControl('setupsearchfields_' . $features_field . '_multiple', '', '0');
                                                    }
                                                    if (!empty($itemtypes_field) && $stp_syncs_it == 0) {
                                                        $second_request_text .= ",itemtypes:'$itemtypes_field'";
                                                        $multiple_itemtypes = PFSFIssetControl('setupsearchfields_' . $itemtypes_field . '_multiple', '', '0');
                                                    }
                                                    if (!empty($conditions_field) && $stp_syncs_co == 0) {
                                                        $second_request_text .= ",conditions:'$conditions_field'";
                                                        $multiple_conditions = PFSFIssetControl('setupsearchfields_' . $conditions_field . '_multiple', '', '0');
                                                    }

                                                    if (!empty($multiple_itemtypes)) {
                                                        $second_request_text .= ",mit:'1'";
                                                    }

                                                    if (!empty($multiple_features)) {
                                                        $second_request_text .= ",mfe:'1'";
                                                    }

                                                    if (!empty($multiple_conditions)) {
                                                        $second_request_text .= ",mco:'1'";
                                                    }


                                                    $second_request_text .= '}';
                                                }

                                                $pfformvars_json = (isset($pfformvars)) ? json_encode($pfformvars) : json_encode(array());

                                                echo $PFListSF->FieldOutput;
                                                echo '<div id="pfsearchsubvalues"></div>';
                                                echo '<input type="hidden" name="s" value=""/>';
                                                echo '<input type="hidden" name="serialized" value="1"/>';
                                                echo '<input type="hidden" name="action" value="pfs"/>';
												echo  '<input type="submit" style="display:none"/>';
                                                echo '<a class="button pfsearch" id="pf-search-button-manual"><i class="pfadmicon-glyph-627"></i> ' . esc_html__('搜索', 'pointfindert2d') . '</a>';
                                                echo '<script type="text/javascript">
                    (function($) {
                        "use strict";
                        $.pffieldsids = ' . $second_request_text . '
                        $.pfsliderdefaults = {};$.pfsliderdefaults.fields = Array();

                        $(function(){
                        ' . $PFListSF->ScriptOutput;
                                                echo 'var pfsearchformerrors = $(".pfsearchformerrors");
                        
                            $("#pointfinder-search-form-manual").validate({
                                  debug:false,
                                  onfocus: false,
                                  onfocusout: false,
                                  onkeyup: false,
                                  rules:{' . $PFListSF->VSORules . '},messages:{' . $PFListSF->VSOMessages . '},
                                  ignore: ".select2-input, .select2-focusser, .pfignorevalidation",
                                  validClass: "pfvalid",
                                  errorClass: "pfnotvalid pfadmicon-glyph-858",
                                  errorElement: "li",
                                  errorContainer: pfsearchformerrors,
                                  errorLabelContainer: $("ul", pfsearchformerrors),
                                  invalidHandler: function(event, validator) {
                                    var errors = validator.numberOfInvalids();
                                    if (errors) {
                                        pfsearchformerrors.show("slide",{direction : "up"},100)
                                        $(".pfsearch-err-button").click(function(){
                                            pfsearchformerrors.hide("slide",{direction : "up"},100)
                                            return false;
                                        });
                                    }else{
                                        pfsearchformerrors.hide("fade",300)
                                    }
                                  }
                            });
                        ';

                                                if ($fltf != 'none') {
                                                    $as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns', '', '0');

                                                    if ($as_mobile_dropdowns == 1) {
                                                        echo '
                                $(function(){
                                    $("#' . $fltf . '" ).change(function(e) {
                                      $.PFGetSubItems($("#' . $fltf . '" ).val(),"' . base64_encode($pfformvars_json) . '",1,0);
                                      ';
                                                        if ($second_request_process) {
                                                            echo '$.PFRenewFeatures($("#' . $fltf . '").val(),"' . $second_request_text . '");';
                                                        }
                                                        echo '
                                    });
                                    $(document).one("ready",function(){
                                        if ($("#' . $fltf . '" ).val() !== 0) {
                                           $.PFGetSubItems($("#' . $fltf . '" ).val(),"' . base64_encode($pfformvars_json) . '",1,0);
                                           ';
                                                        if ($second_request_process) {
                                                            echo '$.PFRenewFeatures($("#' . $fltf . '").val(),"' . $second_request_text . '");';
                                                        }
                                                        echo '
                                        }
                                    });
                                    setTimeout(function(){
                                       $(".select2-container" ).attr("title","");
                                       $("#' . $fltf . '" ).attr("title","")
                                        
                                    },300);
                                });
                                ';
                                                    } else {
                                                        echo '
                               
                                $("#' . $fltf . '" ).change(function(e) {
                                  $.PFGetSubItems($("#' . $fltf . '" ).val(),"' . base64_encode($pfformvars_json) . '",1,0);
                                  ';
                                                        if ($second_request_process) {
                                                            echo '$.PFRenewFeatures($("#' . $fltf . '").val(),"' . $second_request_text . '");';
                                                        }
                                                        echo '
                                });
                                $(document).one("ready",function(){
                                    if ($("#' . $fltf . '" ).val() !== 0) {
                                       $.PFGetSubItems($("#' . $fltf . '" ).val(),"' . base64_encode($pfformvars_json) . '",1,0);
                                       ';
                                                        if ($second_request_process) {
                                                            echo '$.PFRenewFeatures($("#' . $fltf . '").val(),"' . $second_request_text . '");';
                                                        }
                                                        echo '
                                    }
                                });
                                setTimeout(function(){
                                   $(".select2-container" ).attr("title","");
                                   $("#' . $fltf . '" ).attr("title","")
                                    
                                },300);
                              
                                ';
                                                    }
                                                }
                                                echo '
                        });' . $PFListSF->ScriptOutputDocReady;
                                            }

                                            if (!empty($category_selected_auto)) {
                                                echo '
                            $(document).ready(function(){
                                if ($("#' . $fltf . '" )) {
                                    $("#' . $fltf . '" ).select2("val","' . $category_selected_auto . '");
                                }
                            });
                        ';
                                            }
                                            echo '   
                        
                    })(jQuery);
                    </script>';

                                            unset($PFListSF);
                                            ?>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <?php
                    }

		            echo do_shortcode('[pf_itemgrid2 listingtypefilters="'.$listing_cat_filter.'" itemtypefilters="'.$item_cat_filter.'" locationfilters="'.$loc_cat_filter.'" orderby="" sortby="" items="'.$setup42_authorpagedetails_defaultppptype.'" cols="'.$setup22_searchresults_defaultlistingtype.'" grid_layout_mode="'.$setup42_authorpagedetails_grid_layout_mode.'" filters="'.$filters_text.'" itemboxbg="'.$setup22_searchresults_background2.'" infinite_scroll="'.$stp22_infscrl_c.'" infinite_scroll_lm="'.$stp22_infscrl_c2.'" '.$filter_text.']' );

		            echo '</div></div>';
		            if($setup_item_catpage_sidebarpos == 2){
		                echo '<div class="col-lg-3 col-md-4">';
		                    get_sidebar('itemcats' );
		                echo '</div>';
		            }
	        	}
	            
	        echo '</div></div>';
	        echo '<div class="pf-page-spacing"></div>';
	    echo '</section>';

	}


get_footer();
?>
