<?php
add_shortcode( 'pf_infobox', 'pf_infobox_func' );
function pf_infobox_func( $atts,$content ) {
	extract(shortcode_atts(array(
		'onclick'	=> 'link_no',
		'link'	=> '',
		'box_bg_opacity'	=> '0',
		'box_border_radius'	=> '0',
		'box_content_border_color'	=> '#efefef',
		'box_content_bg_color'	=> '#fafafa',
		'box_content_textsize'	=> '13',
		'box_title_color'	=> '#444',
		'box_title_hover_color'	=> '#000',
		'box_title'	=> '',
		'box_title_textsize'	=> '16',
		'box_icon_size'	=> '28',
		'box_icon_border_color'	=> '',
		'box_icon_bg_color'	=> '#ccc',
		'box_icon_color'	=> '#000',
		'box_image1'	=> '',
		'iconbox_style'	=> 'type1',
		'iconbox_icon_name'	=> '',
		'css_animation' => '',
		'icon_type'	=> 'font',
		'icon_style_outside'	=> 'none',
		//'box_icon_image_size'	=> '',
		'readmore' => 'text_no',
		'readmore_text' => 'Read more',
		'icon_box_align' => 'left'
	), $atts));
	
	//pointfinderhex2rgb($hex,$opacity) box_content_textsize
	$align_icon_size = ($box_icon_size + (2 + 30));
	if($icon_style_outside != 'none'){$align_icon_size2 = ($box_icon_size + (2 +20));$margin_right_number=22;}else{$align_icon_size2 = ($box_icon_size + (2 +10));$margin_right_number=12;}
	$box_style_text = ' ';
	$icon_style_text = $icon_style_text2 = ' ';
	$box_title_style_text = ' ';
	$box_content_style_text = ' ';
	$topmargin_style_text = ' ';
	$box_readmore_style_text = ' ';
	$cssanimation_text = '';
	
	$link = ($link=='||') ? '' : $link;
	$link = vc_build_link($link);
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];
	
	if($iconbox_icon_name != ''){
		$icon_style_text .= 'style="';
		$icon_style_text2 .= 'style="';

		if($box_icon_color != ''){ $icon_style_text .= 'color:'.$box_icon_color.';';}
		
		if($icon_style_outside != 'none'){
			if($box_icon_bg_color != ''){ $icon_style_text .= 'background-color:'.$box_icon_bg_color.';';}
			if($box_icon_border_color != ''){ $icon_style_text .= 'border:1px solid '.$box_icon_border_color.';';}
			
		}
		
		if($box_icon_size != ''){ 
			$icon_style_text .= 'font-size:'.$box_icon_size.'px;';
		}

		if($box_icon_size != '' && ($iconbox_style == 'type5' || $iconbox_style == 'type4' || $iconbox_style == 'type3') && $icon_style_outside != 'none'){ 
			$icon_style_text .= 'line-height:'.($box_icon_size + ($box_icon_size/2)).'px;width:'.($box_icon_size*2).'px;height:'.($box_icon_size*2).'px;';
			$icon_style_text2 .= 'line-height:'.($box_icon_size + ($box_icon_size/2)).'px;';
		}

		if($box_icon_size != '' && ($iconbox_style == 'type1' || $iconbox_style == 'type2') && $icon_style_outside != 'none'){ 
			$icon_style_text .= 'line-height:'.($box_icon_size + ($box_icon_size/2)).'px;width:'.($box_icon_size*2).'px;height:'.($box_icon_size*2).'px;';
			$icon_style_text2 .= 'line-height:'.($box_icon_size + ($box_icon_size/2)).'px;';
		}
		if($box_icon_size != '' &&  ($iconbox_style == 'type1' || $iconbox_style == 'type2') && $icon_style_outside == 'none'){ 
			$icon_style_text .= 'margin-left:0;';
		}
		
		if(($iconbox_style == 'type5' || $iconbox_style == 'type4' || $iconbox_style == 'type3') && $icon_style_outside == 'none'){
			$icon_style_text .= 'margin-top: -2px;';
		}
		if(($iconbox_style == 'type3') && $icon_box_align == 'center' && $icon_style_outside == 'none'){
			$icon_style_text .= 'margin-top: 20px;';
		}
		
		/*Special actions*/
		if($iconbox_style == 'type3'){
			if($icon_style_outside != 'none'){
				$icon_style_text .= 'margin-left:-'.($align_icon_size/2).'px;top:-'.($align_icon_size/2).'px;';
			}else{
				$icon_style_text .= 'margin-left:-'.(($align_icon_size/2)+5).'px;top:2px;';
			}
		}
		
		$icon_style_text .= '"';
		$icon_style_text2 .= '"';
	}
	
	$box_style_text .= 'style="';
	if($iconbox_style != '' && $iconbox_style != 'type1' && $iconbox_style != 'type4' && $iconbox_style != 'type5'){
		
		$box_style_text .= 'background:'.pointfinderhex2rgb($box_content_bg_color,$box_bg_opacity).';';
		$box_style_text .= 'border:1px solid '.pointfinderhex2rgb($box_content_border_color,$box_bg_opacity).';';
		/*Special actions*/
		if($iconbox_style == 'type3' && $icon_style_outside != 'none' && $icon_type == 'font'){
			$box_style_text .= 'margin-top:'.(($align_icon_size/2)+18).'px;';
		}elseif($iconbox_style == 'type3' && $icon_style_outside == 'none'){
			$box_style_text .= 'margin-top:18px;';
		}elseif($iconbox_style == 'type3' && $icon_style_outside != 'none' && $icon_type != 'font'){
			$box_style_text .= 'margin-top:18px;';
		}
		
		if($box_border_radius != '0'){
			$box_style_text .= 'border-radius:'.$box_border_radius.'px; -webkit-border-radius:'.$box_border_radius.'px; -moz-border-radius:'.$box_border_radius.'px; -o-border-radius:'.$box_border_radius.'px; -ms-border-radius:'.$box_border_radius.'px;';
		}
		
	}
	if($iconbox_style != 'type3' ){
		$box_style_text .= 'margin-top:18px;';
		if($iconbox_style == 'type5' || $iconbox_style == 'type4' ){$box_style_text .= 'margin-bottom:15px;';}
	}
	$box_style_text .= '"';

	$output = '';
	
	if ( $css_animation != '' ) {
		wp_enqueue_script( 'waypoints' );
		$cssanimation_text = ' wpb_animate_when_almost_visible wpb_'.$css_animation;
	}
	
	$output .= '<div class="pf-iconbox-wrapper pfib-'.$iconbox_style.$cssanimation_text.'"'.$box_style_text.'>';
	
	if($iconbox_icon_name != '' && $icon_type == 'font'){//If icon exist
		$output .= '<div class="pficonboxcover pf-iconbox-'. $icon_style_outside .'-cover"'.$icon_style_text.'>';
		$output .= '<i class="'.$iconbox_icon_name .'"'.$icon_style_text2.'></i>';
		$output .= '</div>';
	}
	
	if($iconbox_style == 'type3'){//Margin for type3 
		$topmargin_style_text .= 'style="';
		if($icon_type == 'font'){
			
			if ($icon_box_align == 'center' && $icon_style_outside == 'none') {
				$topmargin_style_text .= 'margin-top:'.($box_icon_size+3).'px';
			}else{
				$topmargin_style_text .= 'margin-top:'.($box_icon_size-17).'px';
			}
		}
		$topmargin_style_text .= '"';
		$output .= '<div class="pf-iconbox-topmargin"'.$topmargin_style_text.'></div>';
	}
	
	if($box_title != ''){//if title exist
		$box_title_style_text .= 'style="';
		if($icon_type != 'font' && $iconbox_style == 'type2'){$box_title_style_text .= 'display:block;';}
		if($iconbox_style != 'type4'){$box_title_style_text .= 'text-align:'.$icon_box_align.';';};
		if($box_title_color != ''){$box_title_style_text .= 'color:'.$box_title_color.';';};
		if($box_title_textsize != ''){$box_title_style_text .= 'font-size:'.$box_title_textsize.'px;';};
		if($iconbox_style == 'type1' || $iconbox_style == 'type2'){
			$box_title_style_text .= 'margin-left:2px;';
		}
		if($iconbox_style == 'type5'){$box_title_style_text .= 'margin-left:'.($align_icon_size2 + $margin_right_number).'px;';}
		if($iconbox_style == 'type4'){$box_title_style_text .= 'margin-right:'.($align_icon_size2 + $margin_right_number).'px;';}
		$box_title_style_text .= '"';
		
		if($onclick != 'link_no'){
			//wp_die(print_r($link));
			$output .= '<a href="'.$link['url'].'" title="'.$link['title'].'" target="'.$link['target'].'" onMouseOver="this.style.color=\''.$box_title_hover_color.'\'" onMouseOut="this.style.color=\''.$box_title_color.'\'"';
		}else{
			$output .= '<div';
		}
		
		$output .= ' class="pf-iconbox-title"'.$box_title_style_text.' >'.$box_title.'';
		
		if($onclick != 'link_no'){
			$output .= '</a>';
		}else{
			$output .= '</div>';
		}
	}
	
	if($content != ''){//If content exist
		$box_content_style_text .= 'style="';
		if($iconbox_style != 'type4'){$box_content_style_text .= 'text-align:'.$icon_box_align.';';};
		if($box_content_textsize != ''){$box_content_style_text .= 'font-size:'.$box_content_textsize.'px;';}
		
		if($iconbox_style == 'type5'){$box_content_style_text .= 'margin-left:'.($align_icon_size2 + $margin_right_number).'px;';}
		if($iconbox_style == 'type4'){$box_content_style_text .= 'margin-right:'.($align_icon_size2 + $margin_right_number).'px;';}
		
		$box_content_style_text .= '"';
		
		$output .= '<div class="pf-iconbox-text"'.$box_content_style_text.'>'.wpb_js_remove_wpautop($content, true).'';
		
		if($readmore != 'text_no'){
		
		$box_readmore_style_text .= 'style="';
		if($iconbox_style != 'type4'){$box_readmore_style_text .= 'text-align:'.$icon_box_align.';';};
		if($box_content_textsize != ''){$box_readmore_style_text .= 'font-size:'.$box_content_textsize.'px;';}
		if($box_title_color != ''){$box_readmore_style_text .= 'color:'.$box_title_color.';';};
		$box_readmore_style_text .= '"';
		
		if($onclick != 'link_no'){
				$output .= '<a href="'.$link['url'].'" title="'.$link['title'].'" target="'.$link['target'].'" onMouseOver="this.style.color=\''.$box_title_hover_color.'\'" onMouseOut="this.style.color=\''.$box_title_color.'\'"';
			}else{
				$output .= '<div';
			}
			$output .= ' class="pf-iconbox-readmore"'.$box_readmore_style_text.' >'.$readmore_text.'';
			if($onclick != 'link_no'){
				$output .= '</a>';
			}else{
				$output .= '</div>';
			}
		}

		
		$output .= '</div>';
	}
	
	
	$output .= '</div>';
	
	
return $output;
}