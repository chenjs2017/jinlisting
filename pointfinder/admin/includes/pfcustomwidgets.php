<?php
/**********************************************************************************************************************************
*
* Custom Widgets for PointFinder
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/
// REGISTER WIDGETS ***************************************************************************************************************
add_action( 'widgets_init','pointfinder_extrafunction_03' );
function pointfinder_extrafunction_03(){
    register_widget( 'pf_recent_items_w' );
    register_widget( 'pf_featured_items_w' );
    register_widget( 'pf_search_items_w' );
    register_widget( 'pf_twitter_w' );
    register_widget( 'pf_featured_agents_w' );
};


// AGENTS LIST WIDGET *************************************************************************************************************


/**
*START: SEARCH ITEMS WIDGET
**/

    class pf_search_items_w extends WP_Widget {

        function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pf_search_items_w', 

            // Widget name will appear in UI
            esc_html__('PointFinder Search', 'pointfindert2d'), 

            // Widget description
            array( 'description' => esc_html__( 'Search PF Items', 'pointfindert2d' ),'classname' => 'widget_pfitem_recent_entries' ) 
        );
        }


        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', $instance['title'] );
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) ){
                echo $args['before_title'] . $title . $args['after_title'];
            }


            if(!wp_style_is('pfsearch-select2-css', 'enqueued')){wp_enqueue_style('pfsearch-select2-css');}
            if(!wp_script_is('pfsearch-select2-js', 'enqueued')){wp_enqueue_script('pfsearch-select2-js');}    
        

              /**
              *Start: Search Form
              **/
              ?>
              <form id="pointfinder-search-form-manual" method="get" action="<?php echo esc_url(home_url()); ?>" data-ajax="false">
              <div class="pfsearch-content golden-forms">
              <div class="pfsearchformerrors">
                <ul>
                </ul>
                <a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d')?></a>
              </div>
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
                    
                        $PFListSF->GetValue($value['title'],$value['url'],$value['select'],1,$pfformvars);
                        
                    }

                  
                    /*Sense Category*/
                    $current_post_id = get_the_id();

                    if (!empty($current_post_id) && (is_single())) {
                        $current_post_terms = get_the_terms( $current_post_id, 'pointfinderltypes');

                        if (isset($current_post_terms) && $current_post_terms != false) {
                            foreach ($current_post_terms as $key => $value) {
                                $category_selected_auto = $value->term_id;
                            }
                            
                        }
                    }elseif( !empty($current_post_id) && (is_category() || is_archive() || is_tag())){
                        global $wp_query;

                        if(isset($wp_query->query_vars['taxonomy'])){
                            $taxonomy_name = $wp_query->query_vars['taxonomy'];
                            if ($taxonomy_name == 'pointfinderltypes') {
                                $term_slug = $wp_query->query_vars['term'];
                                $term_name = get_term_by('slug', $term_slug, $taxonomy_name,'ARRAY_A');
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

                    $stp_syncs_it = PFSAIssetControl('stp_syncs_it','',1);
                    $stp_syncs_co = PFSAIssetControl('stp_syncs_co','',1);
                    $setup4_sbf_c1 = PFSAIssetControl('setup4_sbf_c1','',1);

                    $second_request_process = false;
                    $second_request_text = "{features:'',itemtypes:'',conditions:''}";
                    $multiple_itemtypes = $multiple_features = $multiple_conditions =  '';

                    if (!empty($features_field) || !empty($itemtypes_field) || !empty($conditions_field)) {
                        $second_request_process = true;
                        $second_request_text = '{';
                        if (!empty($features_field) && $setup4_sbf_c1 == 0) {
                            $second_request_text .= "features:'$features_field'";
                            $multiple_features = PFSFIssetControl('setupsearchfields_'.$features_field.'_multiple','','0');
                        }
                        if (!empty($itemtypes_field) && $stp_syncs_it == 0) {
                            $second_request_text .= ",itemtypes:'$itemtypes_field'";
                            $multiple_itemtypes = PFSFIssetControl('setupsearchfields_'.$itemtypes_field.'_multiple','','0');
                        }
                        if (!empty($conditions_field) && $stp_syncs_co == 0) {
                            $second_request_text .= ",conditions:'$conditions_field'";
                            $multiple_conditions = PFSFIssetControl('setupsearchfields_'.$conditions_field.'_multiple','','0');
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

                    $pfformvars_json = (isset($pfformvars))?json_encode($pfformvars):json_encode(array());
                
                    echo $PFListSF->FieldOutput;
                    echo '<div id="pfsearchsubvalues"></div>';
                    echo '<input type="hidden" name="s" value=""/>';
                    echo '<input type="hidden" name="serialized" value="1"/>';
                    echo '<input type="hidden" name="action" value="pfs"/>';
                    echo '<a class="button pfsearch" id="pf-search-button-manual"><i class="pfadmicon-glyph-627"></i> '.esc_html__('SEARCH', 'pointfindert2d').'</a>';
                    echo '<script type="text/javascript">
                    (function($) {
                        "use strict";
                        $.pffieldsids = '.$second_request_text.'
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
                            $as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');

                            if ($as_mobile_dropdowns == 1) {
                                echo '
                                $(function(){
                                    $("#'.$fltf.'" ).change(function(e) {
                                      $.PFGetSubItems($("#'.$fltf.'" ).val(),"'.base64_encode($pfformvars_json).'",1,0);
                                      ';
                                      if ($second_request_process) {
                                        echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
                                      }
                                      echo '
                                    });
                                    $(document).one("ready",function(){
                                        if ($("#'.$fltf.'" ).val() !== 0) {
                                           $.PFGetSubItems($("#'.$fltf.'" ).val(),"'.base64_encode($pfformvars_json).'",1,0);
                                           ';
                                           if ($second_request_process) {
                                             echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
                                           }
                                           echo '
                                        }
                                    });
                                    setTimeout(function(){
                                       $(".select2-container" ).attr("title","");
                                       $("#'.$fltf.'" ).attr("title","")
                                        
                                    },300);
                                });
                                ';
                            }else{
                                echo '
                               
                                $("#'.$fltf.'" ).change(function(e) {
                                  $.PFGetSubItems($("#'.$fltf.'" ).val(),"'.base64_encode($pfformvars_json).'",1,0);
                                  ';
                                  if ($second_request_process) {
                                    echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
                                  }
                                  echo '
                                });
                                $(document).one("ready",function(){
                                    if ($("#'.$fltf.'" ).val() !== 0) {
                                       $.PFGetSubItems($("#'.$fltf.'" ).val(),"'.base64_encode($pfformvars_json).'",1,0);
                                       ';
                                       if ($second_request_process) {
                                         echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
                                       }
                                       echo '
                                    }
                                });
                                setTimeout(function(){
                                   $(".select2-container" ).attr("title","");
                                   $("#'.$fltf.'" ).attr("title","")
                                    
                                },300);
                              
                                ';
                            }
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
                  
                    unset($PFListSF);
              ?>
              </div>
              </form>
              <?php
              /**
              *End: Search Form
              **/
            echo $args['after_widget'];
        }

            
        // Widget Backend 
        public function form( $instance ) {
            $setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            ?>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','pointfindert2d'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
        <?php
        }
        
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            
            return $instance;
        }
    } 

/**
*END: SEARCH ITEMS WIDGET
**/





/**
*START: RECENT ITEMS WIDGET
**/

    class pf_recent_items_w extends WP_Widget {

        function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pf_recent_items_w', 

            // Widget name will appear in UI
            esc_html__('PointFinder Recent Items', 'pointfindert2d'), 

            // Widget description
            array( 'description' => esc_html__( 'Recent posts', 'pointfindert2d' ),'classname' => 'widget_pfitem_recent_entries') 
        );
        }


        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) ){
                echo $args['before_title'] . $title . $args['after_title'];
            }

            
            if ( !$number = (int) $instance['number'] ){
                $number = 10;
            }else if ( $number < 1 ){
                $number = 1;
            }else if ( $number > 15 ){
                $number = 15;
            }
            $ltype = 0;
            $laddress = 1;
            $limage = 1;
            
            $sense = empty($instance['sense']) ? 0 : $instance['sense'];

            $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

            $args2 = array(
                'showposts' => $number, 
                'nopaging' => 0, 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => true, 
                'post_type' => array($setup3_pointposttype_pt1),
                'orderby'=>'date',
                'order'=>'DESC'
            );

            /* On/Off filter for items */
            $args2['meta_query'][] = array('relation' => 'OR',
                array(
                    'key' => 'pointfinder_item_onoffstatus',
                    'compare' => 'NOT EXISTS'
                    
                ),
                array(
                        'key'=>'pointfinder_item_onoffstatus',
                        'value'=> 0,
                        'compare'=>'=',
                        'type' => 'NUMERIC'
                )
                
            );


            /*Sense Category*/
            if ((is_single() || is_category() || is_archive()) && $sense == 1) {
                $current_post_id = get_the_id();

                if (!empty($current_post_id)) {
                    $current_post_terms = get_the_terms( $current_post_id, 'pointfinderltypes');
                    if (isset($current_post_terms) && $current_post_terms != false) {
                        foreach ($current_post_terms as $key => $value) {
                            if ($value->parent == 0) {
                                $args2['tax_query']=
                                    array(
                                        'relation' => 'AND',
                                        array(
                                            'taxonomy' => 'pointfinderltypes',
                                            'field' => 'id',
                                            'terms' => $key,
                                            'operator' => 'IN'
                                        )
                                    );
                            }else{
                                $args2['tax_query']=
                                    array(
                                        'relation' => 'AND',
                                        array(
                                            'taxonomy' => 'pointfinderltypes',
                                            'field' => 'id',
                                            'terms' => $value->parent,
                                            'operator' => 'IN'
                                        )
                                    );
                            }
                        }
                        
                    }
                }
            }


            $r = new WP_Query($args2);
            if ($r->have_posts()) {
            echo '<ul class="pf-widget-itemlist">';
                while ($r->have_posts()) : $r->the_post(); 
                    echo '<li class="clearfix">';
                        $mytitle = get_the_title();
                        $myid = get_the_ID();
                        echo '<a href="'.get_the_permalink().'" title="';
                                esc_attr($mytitle ? $mytitle : $myid); 
                                echo '">';
                        if($limage == 1){
                        
                            if ( has_post_thumbnail()) {

                                $general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
                                
                                $attachment_img_pf = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumbnail');
                                if($general_retinasupport != 1){
                                    $attachment_img_pf_url = aq_resize($attachment_img_pf[0],70,70,true);
                                }else{
                                    $attachment_img_pf_url = aq_resize($attachment_img_pf[0],140,140,true);
                                }

                                if ($attachment_img_pf_url == false) {
                                    $attachment_img_pf_url = $attachment_img_pf[0];
                                }
                                echo '<img src="'.$attachment_img_pf_url.'" alt="">';
                            
                            }
                            }
                           
                            echo '<div class="pf-recent-items-title">';
                                
                                if ( $mytitle ){ 
                                    if (strlen($mytitle) > 34) {
                                        echo mb_substr($mytitle, 0, 34,'UTF-8').'...';
                                    } else {
                                        echo $mytitle;
                                    }
                                }else{
                                    echo $myid;  
                                }; 
                               
                            echo '</div>';
                            if($laddress == 1){
                                echo '<div class="pf-recent-items-address">';
                                $mypostmeta = esc_html(get_post_meta( get_the_ID(), 'webbupointfinder_items_address', true ));
                                if (strlen($mypostmeta) > 34) {
                                    echo mb_substr($mypostmeta, 0, 34,'UTF-8').'...';
                                } else {
                                    echo $mypostmeta;
                                }
                                echo '</div>';
                            }
                            if($ltype == 1){
                                echo '<div class="pf-recent-items-terms">';
                                echo GetPFTermInfo(get_the_ID(),'pointfinderltypes');
                                echo '</div>';
                                echo '<div class="pf-recent-items-terms">';
                                echo GetPFTermInfo(get_the_ID(),'pointfinderitypes');
                                echo '</div>';
                            }
                         echo '</a>';
                    echo '</li>';
                
                endwhile; 
            echo '</ul>';
           
            
            wp_reset_postdata();

            }
            echo $args['after_widget'];
        }

            
        // Widget Backend 
        public function form( $instance ) {
            $setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            if ( !isset($instance['number']) || !$number = (int) $instance['number'] ){$number = 5;}
            if ( isset($instance['sense']) && $instance['sense'] == 1 ){$sense_checked = " checked = 'checked'";}else{$sense_checked ='';}
            ?>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','pointfindert2d'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number of posts to show:','pointfindert2d'); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('sense'); ?>"><?php esc_html_e('Filter Category:','pointfindert2d'); ?></label>
                <input id="<?php echo $this->get_field_id('sense'); ?>" name="<?php echo $this->get_field_name('sense'); ?>" type="checkbox" value="1"<?php echo $sense_checked;?> /><br/>
                <small><?php echo esc_html__('If this enabled, this widget will show only page category items.','pointfindert2d');?></small>
            </p>
          
        <?php
        }
        
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['number'] = (int) $new_instance['number'];
            $instance['sense'] = isset($new_instance['sense'])? $new_instance['sense']:0;

            return $instance;
        }
    } 

/**
*END: RECENT ITEMS WIDGET
**/





/**
*START: FEATURED ITEMS WIDGET
**/
    class pf_featured_items_w extends WP_Widget {

        function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pf_featured_items_w', 

            // Widget name will appear in UI
            esc_html__('PointFinder Featured Items', 'pointfindert2d'), 

            // Widget description
            array( 'description' => esc_html__( 'Featured posts', 'pointfindert2d' ),'classname' => 'widget_pfitem_recent_entries' ) 
        );
        }


        public function widget( $args, $instance ) {
            
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) ){
                echo $args['before_title'] . $title . $args['after_title'];
            }

            if ( !$number = (int) $instance['number'] ){
                $number = 10;
            }else if ( $number < 1 ){
                $number = 1;
            }else if ( $number > 15 ){
                $number = 15;
            }
            $ltype = 0;
            $laddress = 1;
            $limage = 1;
            
            $sense = empty($instance['sense']) ? 0 : $instance['sense'];
            $rnd_feature = empty($instance['rnd']) ? 0 : $instance['rnd'];
            
            $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');


            $args2 = array(
                'showposts' => $number, 
                'nopaging' => 0, 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => true, 
                'post_type' => array($setup3_pointposttype_pt1),
                'orderby'=>'date',
                'order'=>'DESC',
                'meta_query' => array(array('key' => 'webbupointfinder_item_featuredmarker','value' => '1','compare' => '='))
            );

            if ($rnd_feature != 0) {
                $args2['orderby']='rand';
            }

            /* On/Off filter for items */
            $args2['meta_query'][] = array('relation' => 'OR',
                array(
                    'key' => 'pointfinder_item_onoffstatus',
                    'compare' => 'NOT EXISTS'
                    
                ),
                array(
                        'key'=>'pointfinder_item_onoffstatus',
                        'value'=> 0,
                        'compare'=>'=',
                        'type' => 'NUMERIC'
                )
                
            );

            /*Sense Category*/
           
            if ((is_single() || is_category() || is_archive()) && $sense == 1) {
                $current_post_id = get_the_id();

                if (!empty($current_post_id)) {
                    $current_post_terms = get_the_terms( $current_post_id, 'pointfinderltypes');
                    if (isset($current_post_terms) && $current_post_terms != false) {
                        foreach ($current_post_terms as $key => $value) {
                            if ($value->parent == 0) {
                                $args2['tax_query']=
                                    array(
                                        'relation' => 'AND',
                                        array(
                                            'taxonomy' => 'pointfinderltypes',
                                            'field' => 'id',
                                            'terms' => $key,
                                            'operator' => 'IN'
                                        )
                                    );
                            }else{
                                $args2['tax_query']=
                                    array(
                                        'relation' => 'AND',
                                        array(
                                            'taxonomy' => 'pointfinderltypes',
                                            'field' => 'id',
                                            'terms' => $value->parent,
                                            'operator' => 'IN'
                                        )
                                    );
                            }
                        }
                        
                    }
                }
            }
            
            
            $r = new WP_Query($args2);
            if ($r->have_posts()) {
            echo '<ul class="pf-widget-itemlist">';
                while ($r->have_posts()) : $r->the_post(); 
                    echo '<li class="clearfix">';
                        $mytitle = get_the_title();
                        $myid = get_the_ID();
                        echo '<a href="'.get_the_permalink().'" title="';
                                esc_attr($mytitle ? $mytitle : $myid); 
                                echo '">';
                        if($limage == 1){
                        
                            if ( has_post_thumbnail()) {

                                    $general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
                                    
                                    $attachment_img_pf = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumbnail');
                                    if($general_retinasupport != 1){
                                        $attachment_img_pf_url = aq_resize($attachment_img_pf[0],70,70,true);
                                    }else{
                                        $attachment_img_pf_url = aq_resize($attachment_img_pf[0],140,140,true);
                                    }
                                    if ($attachment_img_pf_url == false) {
                                        $attachment_img_pf_url = $attachment_img_pf[0];
                                    }
                                    echo '<img src="'.$attachment_img_pf_url.'" alt="">';

                            }
                        }
                            
                            
                        echo '<div class="pf-recent-items-title">';
                            if ( $mytitle ){ 
                                if (strlen($mytitle) > 34) {
                                    echo mb_substr($mytitle, 0, 34,'UTF-8').'...';
                                } else {
                                    echo $mytitle;
                                }
                            }else{
                                echo $myid;  
                            }; 
                            
                        echo '</div>';
                        if($laddress == 1){
                        echo '<div class="pf-recent-items-address">';
                        $mypostmeta = esc_html(get_post_meta( get_the_ID(), 'webbupointfinder_items_address', true ));
                        if (strlen($mypostmeta) > 34) {
                            echo mb_substr($mypostmeta, 0, 34,'UTF-8').'...';
                        } else {
                            echo $mypostmeta;
                        }
                        echo '</div>';
                        }
                        if($ltype == 1){
                        echo '<div class="pf-recent-items-terms">';
                        echo GetPFTermInfo(get_the_ID(),'pointfinderltypes');
                        echo '</div>';
                        echo '<div class="pf-recent-items-terms">';
                        echo GetPFTermInfo(get_the_ID(),'pointfinderitypes');
                        echo '</div>';
                        }
                    echo '</a>';
                    echo '</li>';
                
                endwhile; 
            echo '</ul>';
           
            
            wp_reset_postdata();

            }
            echo $args['after_widget'];
        }

            
        // Widget Backend 
        public function form( $instance ) {
            $setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';

            if ( !isset($instance['number']) || !$number = (int) $instance['number'] ){$number = 5;}
            if ( isset($instance['sense']) && $instance['sense'] == 1 ){$sense_checked = " checked = 'checked'";}else{$sense_checked ='';}
            if ( isset($instance['rnd']) && $instance['rnd'] == 1 ){$rnd_checked = " checked = 'checked'";}else{$rnd_checked ='';}
            ?>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','pointfindert2d'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number of posts to show:','pointfindert2d'); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('sense'); ?>"><?php esc_html_e('Filter Category:','pointfindert2d'); ?></label>
                <input id="<?php echo $this->get_field_id('sense'); ?>" name="<?php echo $this->get_field_name('sense'); ?>" type="checkbox" value="1"<?php echo $sense_checked;?> /><br/>
                <small><?php echo esc_html__('If this enabled, this widget will show only page category items.','pointfindert2d');?></small>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('rnd'); ?>"><?php esc_html_e('Random Posts:','pointfindert2d'); ?></label>
                <input id="<?php echo $this->get_field_id('rnd'); ?>" name="<?php echo $this->get_field_name('rnd'); ?>" type="checkbox" value="1"<?php echo $rnd_checked;?> /><br/>
                <small><?php echo esc_html__('If this enabled, this widget will show random items.','pointfindert2d');?></small>
            </p>
        <?php
        }
        
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['number'] = (int) $new_instance['number'];
            $instance['sense'] = isset($new_instance['sense'])? $new_instance['sense']:0;
            $instance['rnd'] = isset($new_instance['rnd'])? $new_instance['rnd']:0;

            return $instance;
        }
    } 

/**
*END: FEATURED ITEMS WIDGET
**/




/**
*START: TWITTER WIDGET
**/
    class pf_twitter_w extends WP_Widget {

        function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pf_twitter_w', 

            // Widget name will appear in UI
            esc_html__('PointFinder Twitter Widget', 'pointfindert2d'), 

            // Widget description
            array( 'description' => esc_html__( 'Twitter feeds', 'pointfindert2d' ),'classname' => 'widget_pfitem_recent_entries' ) 
        );
        }


        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) ){
                echo $args['before_title'] . $title . $args['after_title'];
            }

            
            if ( !$number = (int) $instance['number'] ){
                $number = 10;
            }else if ( $number < 1 ){
                $number = 1;
            }else if ( $number > 15 ){
                $number = 15;
            }
            
            $scname = empty($instance['scname']) ? 0 : $instance['scname'];

            $twitterpage= '
            <!-- Twitter page begin -->

                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        jQuery(function () {
                            jQuery.JQTWEET.loadTweets("'.$scname.'","'.$number.'");
                        });     
                    });
                </script>

                <div id="jstwitter"></div>

            <!-- Twitter End -->';

            echo $twitterpage;
            
            echo $args['after_widget'];
        }

            
        // Widget Backend 
        public function form( $instance ) {

            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';

            if ( !isset($instance['number']) || !$number = (int) $instance['number'] ){$number = 5;}
            if ( !isset($instance['scname'])){$scname = '';}else{$scname = $instance['scname'];}
            ?>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','pointfindert2d'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
            
            <p>
                <label for="<?php echo $this->get_field_id('scname'); ?>"><?php esc_html_e('Screen Name:','pointfindert2d'); ?></label>
                <input id="<?php echo $this->get_field_id('scname'); ?>" name="<?php echo $this->get_field_name('scname'); ?>" type="text" value="<?php echo $scname; ?>" size="15" />
            </p>


            <p>
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number of tweets:','pointfindert2d'); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            </p>

        <?php
        }
        
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

            $instance['number'] = (int) $new_instance['number'];
            $instance['scname'] = $new_instance['scname'];
            
            return $instance;
        }
    } 

/**
*END: TWITTER WIDGET
**/




/**
*START: FEATURED AGENTS WIDGET
**/
    class pf_featured_agents_w extends WP_Widget {

        function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pf_featured_agents_w', 

            // Widget name will appear in UI
            esc_html__('PointFinder List Agents', 'pointfindert2d'), 

            // Widget description
            array( 'description' => esc_html__( 'List agents', 'pointfindert2d' ),'classname' => 'widget_pfitem_recent_entries' ) 
        );
        }


        public function widget( $args, $instance ) {
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) ){
                echo $args['before_title'] . $title . $args['after_title'];
            }

            
            if ( !$number = (int) $instance['number'] ){
                $number = 10;
            }else if ( $number < 1 ){
                $number = 1;
            }else if ( $number > 15 ){
                $number = 15;
            }

            if ( !empty($instance['number2']) ){
                $post_numbers = pfstring2BasicArray($instance['number2']);
            }else{
                $post_numbers = array();
            }

           
            $limage = 1;

            $setup3_pointposttype_pt8 = PFSAIssetControl('setup3_pointposttype_pt8','','agents');
            $r = new WP_Query(array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'post_type' => array($setup3_pointposttype_pt8),'orderby'=>'title','order'=>'ASC','post__in'=> $post_numbers));
           


            if ($r->have_posts()) {
            echo '<ul class="pf-widget-itemlist">';
                while ($r->have_posts()) : $r->the_post(); 
                    echo '<li class="clearfix">';
                        $mytitle = get_the_title();
                        $myid = get_the_ID();
                        $mycontent = get_the_content();
                        echo '<a href="'.get_the_permalink().'" title="';
                                esc_attr($mytitle ? $mytitle : $myid); 
                                echo '">';
                        if($limage == 1){
                        
                            if ( has_post_thumbnail()) {

                                    $general_retinasupport = PFSAIssetControl('general_retinasupport','','0');
                                    
                                    $attachment_img_pf = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumbnail');
                                    if($general_retinasupport != 1){
                                        $attachment_img_pf_url = aq_resize($attachment_img_pf[0],70,70,true);
                                    }else{
                                        $attachment_img_pf_url = aq_resize($attachment_img_pf[0],140,140,true);
                                    }
                                    echo '<img src="'.$attachment_img_pf_url.'" alt="">';

                            }
                        }
                            
                            
                        echo '<div class="pf-recent-items-title">';
                            if ( $mytitle ){ 
                                if (strlen($mytitle) > 34) {
                                    echo mb_substr($mytitle, 0, 34,'UTF-8').'...';
                                } else {
                                    echo $mytitle;
                                }
                            }else{
                                echo $myid;  
                            }; 
                            
                        echo '</div>';

                        echo '<div class="pf-recent-items-address">';
                             if (strlen($mycontent) > 34) {
                                    echo mb_substr($mycontent, 0, 34,'UTF-8').'...';
                                } else {
                                    echo $mycontent;
                                }
                        echo '</div>';

                    echo '</a>';
                    echo '</li>';
                
                endwhile; 
            echo '</ul>';
           
            
            wp_reset_postdata();

            }
            echo $args['after_widget'];
        }

            
        // Widget Backend 
        public function form( $instance ) {
            $setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            if ( !isset($instance['number']) || !$number = (int) $instance['number'] ){$number = 5;}
            if ( !isset($instance['number2']) || !$number2= $instance['number2'] ){$number2 = '';}
            ?>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','pointfindert2d'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p>
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number of posts to show:','pointfindert2d'); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('number2'); ?>"><?php esc_html_e('Agent ID Numbers:','pointfindert2d'); ?></label><br/>
                <input id="<?php echo $this->get_field_id('number2'); ?>" name="<?php echo $this->get_field_name('number2'); ?>" type="text" value="<?php echo $number2; ?>" style="width:100%" /><br/>
                <small><?php esc_html_e('Please write like ex: 12,13,14','pointfindert2d'); ?></small>
            </p>
        <?php
        }
        
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['number'] = (int) $new_instance['number'];
            $instance['number2'] = $new_instance['number2'];
            return $instance;
        }
    } 

/**
*END: FEATURED AGENTS WIDGET
**/
?>