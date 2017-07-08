<?php
add_shortcode( 'pf_searchw', 'pf_searchw_func' );
function pf_searchw_func( $atts ) {
	$output = $title = $number = $el_class = $mini_style = '';
	extract( shortcode_atts( array(
    'minisearchc' => 1,
    'searchbg' => '',
    'searchtext' => '',
    'mini_padding_tb' => 0,
    'mini_padding_lr' => 0,
    'mini_bg_color' => ''
  	), $atts ) );
	
  $coln = '<div class="col-lg-6 col-md-6 col-sm-6 colhorsearch">';

  switch ($minisearchc) {
      case '1':
        $coln = '<div class="col-lg-6 col-md-6 col-sm-6 colhorsearch">';
        break;
      
      case '2':
        $coln = '<div class="col-lg-4 col-md-4 col-sm-4 colhorsearch">';
        break;

      case '3':
        $coln = '<div class="col-button col-md-3 col-sm-3 colhorsearch">';
        break;

      default:
        $coln = '<div class="col-lg-6 col-md-6 col-sm-6 colhorsearch">';
        break;
  }

	/**
	*START: SEARCH ITEMS WIDGET
	**/  
        $mini_style = " style='";
        if (!empty($mini_bg_color)) {
          $mini_style .= "background-color:".$mini_bg_color.';';
        }
        $mini_style .= "padding: ".$mini_padding_tb."px ".$mini_padding_lr."px;";
        $mini_style .= "'";
        if ($searchbg != '' && $searchtext != '') {
          $searchb_style = " style='color:".$searchtext."!important;background-color:".$searchbg."!important'";
        } else {
          $searchb_style = "";
        }
        
        if(!wp_style_is('pfsearch-select2-css', 'enqueued')){wp_enqueue_style('pfsearch-select2-css');}
        if(!wp_script_is('pfsearch-select2-js', 'enqueued')){wp_enqueue_script('pfsearch-select2-js');}    
    	  ob_start();

          /**
          *Start: Search Form
          **/
          ?>
          <div class="pointfinder-mini-search"<?php echo $mini_style;?>>
          <form id="pointfinder-search-form-manual" class="pfminisearch" method="get" action="<?php echo esc_url(home_url()); ?>" data-ajax="false">
          <div class="pfsearch-content golden-forms">
          <div class="pf-row">
          <?php 
            $setup1s_slides = PFSAIssetControl('setup1s_slides','','');
            
            if(is_array($setup1s_slides)){
                
                /**
                *Start: Get search data & apply to query arguments.
                **/

                    $pfgetdata = $_GET;
                    
                    if(is_array($pfgetdata)){
                        
                        $pfformvars = array();
                        
                        foreach ($pfgetdata as $key => $value) {
                            if (!empty($value) && $value != 'pfs') {
                                $pfformvars[$key] = $value;
                            }
                        }
                        
                        $pfformvars = PFCleanArrayAttr('PFCleanFilters',$pfformvars);

                    }       
                /**
                *End: Get search data & apply to query arguments.
                **/
                $PFListSF = new PF_SF_Val();
                foreach ($setup1s_slides as &$value) {
                
                    $PFListSF->GetValue($value['title'],$value['url'],$value['select'],1,$pfformvars,1,1,$minisearchc);
                    
                }


                /*Get Listing Type Item Slug*/
                $fltf = pointfinder_find_requestedfields('pointfinderltypes');

                $pfformvars_json = (isset($pfformvars))?json_encode($pfformvars):json_encode(array());
            
								$mobile =	pf_is_mobile();
								if (!$mobile) {
									$divBegin = $coln;
									$divEnd = '</div>';
								}else {
								}
                echo $PFListSF->FieldOutput;
								echo $divBegin;
                echo '<div id="pfsearchsubvalues"></div>';
                echo '<input type="hidden" name="s" value=""/>';
                echo '<input type="hidden" name="serialized" value="1"/>';
                echo '<input type="hidden" name="action" value="pfs"/>';
                echo  '<input type="submit" style="display:none"/>';
                echo '<a class="button pfsearch" id="pf-search-button-manual"'.$searchb_style.'><i class="pfadmicon-glyph-627"></i> '.esc_html__('搜索', 'pointfindert2d').'</a>';
               	echo $divEnd;
              }
              unset($PFListSF);
          ?>
          </div>
          </div>
          </form>
          </div>
          <?php
          /**
          *End: Search Form
          **/   


	/**
	*END: SEARCH ITEMS WIDGET
	**/

	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
