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
        $coln = '<div class="col-lg-3 col-md-3 col-sm-3 colhorsearch">';
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
            
                echo $PFListSF->FieldOutput;
                echo $coln;
                echo '<div id="pfsearchsubvalues"></div>';
                echo '<input type="hidden" name="s" value=""/>';
                echo '<input type="hidden" name="serialized" value="1"/>';
                echo '<input type="hidden" name="action" value="pfs"/>';
                echo  '<input type="submit" style="display:none"/>';
                echo '<a class="button pfsearch" id="pf-search-button-manual"'.$searchb_style.'><i class="pfadmicon-glyph-627"></i> '.esc_html__('搜索', 'pointfindert2d').'</a>';
                echo '<script type="text/javascript">
                (function($) {
                    "use strict";
                    $.pfsliderdefaults = {};$.pfsliderdefaults.fields = Array();

                    $(function(){
                    '.$PFListSF->ScriptOutput;
                    echo 'var pfsearchformerrors = $(".pfsearchformerrors");
                    
                        $("#pointfinder-search-form-manual").validate({
                              debug:false,
                              onfocus: false,
                              onfocusout: false,
                              onkeyup: false,
                              rules:{'.$PFListSF->VSORules.'},messages:{'.$PFListSF->VSOMessages.'},
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
                        echo '
                        setTimeout(function(){
                           $(".select2-container" ).attr("title","");
                           $("#'.$fltf.'" ).attr("title","")
                            
                        },300);
                        ';
                    }
                    echo '
                    });'.$PFListSF->ScriptOutputDocReady;
                }

                if (!empty($category_selected_auto)) {
                    echo '
                        $(document).ready(function(){
                            if ($("#'.$fltf.'" )) {
                                $("#'.$fltf.'" ).select2("val","'.$category_selected_auto.'");
                            }
                        });
                    ';
                }
                echo'   
                    
                })(jQuery);
                </script>';
                echo '</div>';
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