<?php
function add_pointfindermappagedetails_code () {
	global $pointfindertheme_option;
	$setup42_itempagedetails_configuration = (isset($pointfindertheme_option['setup42_itempagedetails_configuration']))? $pointfindertheme_option['setup42_itempagedetails_configuration'] : array();
	
	$street_view_height = (isset($setup42_itempagedetails_configuration['streetview']['mheight']))?$setup42_itempagedetails_configuration['streetview']['mheight']:340;
	$location_view_height = (isset($setup42_itempagedetails_configuration['location']['mheight']))?$setup42_itempagedetails_configuration['location']['mheight']:340;

	$pfid = get_the_id();
	$pfstview = array('heading'=>'0','pitch'=>0,'zoom'=>0);

	if (PFcheck_postmeta_exist('webbupointfinder_item_streetview',$pfid)) {
		$pfstview = get_post_meta( $pfid, 'webbupointfinder_item_streetview', true );
	}

	$pfstview = PFCleanArrayAttr('PFCleanFilters',$pfstview);

	if (PFcheck_postmeta_exist('webbupointfinder_items_location',$pfid)) {
		$pfstviewcor = esc_attr(get_post_meta( $pfid, 'webbupointfinder_items_location', true ));
	}

	if (empty($pfstviewcor) || $pfstviewcor == ",") {
		$pfstviewcor = '0,0';
	}


	/*Point settings*/
	$setup10_infowindow_height = PFSAIssetControl('setup10_infowindow_height','','136');
	$setup10_infowindow_width = PFSAIssetControl('setup10_infowindow_width','','350');
	if($setup10_infowindow_height != 136){ $heightbetweenitems = $setup10_infowindow_height - 136;}else{$heightbetweenitems = 0;}
	if($setup10_infowindow_width != 350){ $widthbetweenitems = (($setup10_infowindow_width - 350)/2);}else{$widthbetweenitems = 0;}
	$s10_iw_w_m = PFSAIssetControl('s10_iw_w_m','','184');
	$s10_iw_h_m = PFSAIssetControl('s10_iw_h_m','','136');
	if($s10_iw_h_m != 136){ $heightbetweenitems2 = $s10_iw_h_m - 136;}else{$heightbetweenitems2 = 0;}
	if($s10_iw_w_m != 184){ $widthbetweenitems2 = (($s10_iw_w_m - 184)/2);}else{$widthbetweenitems2 = "-89";}

?>
	<script type="text/javascript">
	(function($) {
		"use strict";

		// ITEM DETAIL PAGE MAP FUNCTION STARTED --------------------------------------------------------------------------------------------
		$.pfitemdetailpagemap = function(){
			
			$(function(){
				$('#pf-itempage-header-map').css('height','<?php echo esc_js($location_view_height); ?>px');
				$('#pf-itempage-header-map').gmap3({
				  defaults:{ 
		            classes:{
		              Marker:RichMarker
		            }
		          },
				  map:{
					  options:{
						zoom: 15, 
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						mapTypeControl: true,
						zoomControl: true,
						panControl: true,
						scaleControl: true,
						navigationControl: true,
						draggable:true,
						scrollwheel: false,
						streetViewControl: false,
						streetViewControlOptions: {position: google.maps.ControlPosition.LEFT_BOTTOM},
						styles: [{
							featureType: 'poi',
							elementType: 'labels',
							stylers: [{ visibility: 'off' }]
						}]
					  },

					  callback: function(){
					  	<?php if($pfstviewcor != '0,0'){ ?>
						$.pfloadmarker_itempage("<?php echo get_the_id();?>");
						<?php }?>
					  }
				  }
				});

				//Auto complete for get directions
					var map = $("#pf-itempage-header-map").gmap3("get");
					var input = document.getElementById("gdlocations");
					$("#gdlocations").bind("keypress", function(e) {
					  if (e.keyCode == 13) {               
					    e.preventDefault();
					    return false;
					  }
					});

					var autocomplete = new google.maps.places.Autocomplete(input);
					autocomplete.bindTo("bounds", map);

					google.maps.event.addListener(autocomplete, "place_changed", function() {


					    var place = autocomplete.getPlace();
					    if (!place.geometry) {
					      return;
					    }

					});
				//end
			});
		};

		// ITEM DETAIL PAGE MAP FUNCTION FINISHED --------------------------------------------------------------------------------------------


		// ITEM PAGE HEADER MAP FUNCTION STARTED --------------------------------------------------------------------------------------------
		$.pfitemdetailpagetopmap = function(){
			
			$(function(){
				$('#item-map-page').gmap3({
				  defaults:{ 
		            classes:{
		              Marker:RichMarker
		            }
		          },
				  map:{
					  options:{
					  	center:[<?php echo $pfstviewcor;?>],
						zoom: 16, 
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						mapTypeControl: true,
						zoomControl: true,
						panControl: false,
						scaleControl: true,
						navigationControl: false,
						draggable:true,
						scrollwheel: false,
						streetViewControl: $.pf_mobile_check(),
						streetViewControlOptions: {position: google.maps.ControlPosition.LEFT_BOTTOM},
						styles: [{
							featureType: 'poi',
							elementType: 'labels',
							stylers: [{ visibility: 'off' }]
						}]
					  },

					  callback: function(){
					  	<?php if($pfstviewcor != '0,0'){ ?>
						$.pfloadmarker_itempage_top("<?php echo get_the_id();?>",(!$.pf_mobile_check())? "<?php echo esc_js($widthbetweenitems2);?>" :"<?php echo esc_js($widthbetweenitems);?>",(!$.pf_mobile_check())? "<?php echo esc_js($heightbetweenitems2);?>" :"<?php echo esc_js($heightbetweenitems);?>","<?php echo PF_current_language();?>");
						<?php }?>
					  }
				  }
				});
			});
		};
		// ITEM PAGE HEADER MAP FUNCTION FINISHED --------------------------------------------------------------------------------------------


		// ITEM DETAIL PAGE STREETVIEW FUNCTION STARTED --------------------------------------------------------------------------------------------
		$.pfitemdetailpagestview = function(){
			$('#pf-itempage-header-streetview').css('height','<?php echo esc_js($street_view_height); ?>px');
			$(function(){
				function pf_init_stvmap() {
				  var pfpanoramaOptions = {
				    position: new google.maps.LatLng(<?php echo $pfstviewcor;?>),
				    pov: {
				      heading: <?php echo $pfstview['heading'];?>,
				      pitch: <?php echo $pfstview['pitch'];?>
				    },
				    zoom: <?php echo $pfstview['zoom'];?>
				  };
				  var pfstpano = new google.maps.StreetViewPanorama(
				      document.getElementById('pf-itempage-header-streetview'),
				      pfpanoramaOptions);
				  pfstpano.setVisible(true);
				}

				pf_init_stvmap();

				

			});
		};

		// ITEM DETAIL PAGE STREETVIEW FUNCTION FINISHED --------------------------------------------------------------------------------------------



		// LOAD MAP STARTED --------------------------------------------------------------------------------------------
		$(function(){
			$.pfitemdetailpagemap();
			if($('#item-map-page').length > 0){
				<?php if($pfstviewcor != '0,0'){ ?>
				$.pfitemdetailpagetopmap();
				<?php }?>
			};
			<?php if($setup42_itempagedetails_configuration['streetview']['status'] == 1 && $pfstviewcor != '0,0'){ ?>
			if($('#pf-itempage-header-streetview').length > 0){
			$.pfitemdetailpagestview();
			}
			<?php }?>
			<?php if($pfstviewcor != '0,0'){ ?>
			// Get directions Auto complete button
				if ($(".pf-gdirections-locatemebut").length) {$(".pf-gdirections-locatemebut").svgInject();};
				$("#pf_gdirections_geolocateme").live("click",function(){
					$(".pf-gdirections-locatemebut").hide("fast"); $(".pf-search-locatemebutloading").show("fast");
					$("#pf-itempage-header-map").gmap3({
						getgeoloc:{
							callback : function(latLng){
							  if (latLng){
								var geocoder = new google.maps.Geocoder();
								geocoder.geocode({"latLng": latLng}, function(results, status) {
								    if (status == google.maps.GeocoderStatus.OK) {
								      if (results[0]) {
								        $("#gdlocations").val(results[0].formatted_address);
								      } 
								    }
								});

							  }
							  $(".pf-gdirections-locatemebut").show("fast");
							  $(".pf-search-locatemebutloading").hide("fast");
							}
						  },
					});
					return false;
				});
			// End 
			<?php }?>
		});
		
		<?php if($pfstviewcor != '0,0'){ ?>
		$('#pfidplocation').one().live('click',function(){
			$('#pf-itempage-header-map').css('height','<?php echo esc_js($location_view_height); ?>px');
			setTimeout(function(){
			$('#pf-itempage-header-map').gmap3({trigger:"resize"});
				var map = $('#pf-itempage-header-map').gmap3('get');
				var marker = $("#pf-itempage-header-map").gmap3({get:"marker"});
				$.pfmap_recenter(map,marker.getPosition(),0,0);
			}, 400);
		});

		$('#pfidpstreetview').one().live('click',function(){
			$('#pf-itempage-header-streetview').css('height','<?php echo esc_js($street_view_height); ?>px');
			setTimeout(function(){
				$.pfitemdetailpagestview();
			}, 400);
		});
		<?php }?>
		// LOAD MAP FINISHED --------------------------------------------------------------------------------------------



		// GET DIRECTION BUTTON PRESSED STARTED --------------------------------------------------------------------------------------------
		<?php if($pfstviewcor != '0,0'){ ?>
		$('#pf-itempage-page-map-directions .gdbutton').live('click',function(event) {
			var directionsDisplay;
			var directionsService = new google.maps.DirectionsService();

			$('#pf-itempage-header-map').gmap3({clear: {id: "gdirectionpanel"}});
			$('#pf-itempage-header-map').gmap3({clear: {id: "gdirectionpanel2"}});
			$('#directions-panel + .pfpfgooglemap').remove();
			$('#directions-panel').html('');
			$("#pf-itempage-header-map").gmap3({ 
			  getroute:{
			  	id:"gdirectionpanel2",
			    options:{
			        origin:document.getElementById("gdlocations").value,
			        destination:document.getElementById("gdlocationend").value,
			        travelMode: google.maps.DirectionsTravelMode[document.getElementById("gdtype").value]
			    },
			    callback: function(results){
			      if (!results){
			      	  $('#directions-panel').html('<?php echo sprintf(__('<span class="gdirectionsspan">Direction Not Found<br/> <strong><a href="https://maps.google.com?saddr=Current+Location&daddr=%s" target="_blank" rel="nofollow">View google map direction</a></strong></span>','pointfindert2d'),$pfstviewcor);?>')
			      }else{
				      $(this).gmap3({
				        map:{
				          options:{
				            zoom: 13,  
				          }
				        },
				        directionsrenderer:{
				          container: $(document.createElement("div")).addClass("pfpfgooglemap").insertAfter($("#directions-panel")),
				          options:{
				            directions:results
				          },
				          id:"gdirectionpanel"
				        }
				      });
			  	  };
			    }
			  }
			});


		});
		<?php }?>
		// GET DIRECTION BUTTON PRESSED END --------------------------------------------------------------------------------------------

	})(jQuery);
	</script>
	<?php
}

add_action('wp_footer', 'add_pointfindermappagedetails_code',220);

?>