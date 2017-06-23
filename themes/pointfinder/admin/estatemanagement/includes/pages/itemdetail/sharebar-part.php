<?php 
/**********************************************************************************************************************************
*
* Item Detail Page - Sharebar Content
* 
* Author: Webbu Design
***********************************************************************************************************************************/

global $claim_list_permission;

$setup42_itempagedetails_share_bar = PFSAIssetControl('setup42_itempagedetails_share_bar','','1');
$setup42_itempagedetails_report_status = PFSAIssetControl('setup42_itempagedetails_report_status','','1');
$setup42_itempagedetails_claim_status = PFSAIssetControl('setup42_itempagedetails_claim_status','','0');
$setup4_membersettings_favorites = PFSAIssetControl('setup4_membersettings_favorites','','1');

$favtitle_text = esc_html__('Add to Favorites','pointfindert2d');
$fav_check = 'false';
$faviconname = 'pfadmicon-glyph-376';
$post_id = get_the_id();

if (is_user_logged_in()) {
	$user_favorites_arr = get_user_meta( get_current_user_id(), 'user_favorites', true );
	if (!empty($user_favorites_arr)) {
		$user_favorites_arr = json_decode($user_favorites_arr,true);
	}else{
		$user_favorites_arr = array();
	}
}

if (is_user_logged_in() && count($user_favorites_arr)>0) {
	if (in_array($post_id, $user_favorites_arr)) {
		$fav_check = 'true';
		$faviconname = 'pfadmicon-glyph-375';
		$favtitle_text = esc_html__('Remove from Favorites','pointfindert2d');
	}
}


if($setup42_itempagedetails_share_bar == 1){
	$item_title = get_the_title();
	$item_permalink = get_the_permalink();
	$item_thumnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
	$item_thumnail2 = $item_thumnail[0];


	echo '<div class="pf-itempage-sharebar clearfix hidden-print pf-itempagedetail-element golden-forms">';
		
?>
		<ul class="pf-sharebar-icons clearfix">
			<li><a href="http://www.facebook.com/share.php?u=<?php echo $item_permalink;?>&title=<?php echo $item_title;?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=640,height=480')" class="pfsharebar-fb info-tip2" aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Share','pointfindert2d');?></span><span class="pfadmicon-glyph-770"></span></a></li>
			
			<li><a href="http://twitter.com/share?text=<?php echo $item_title;?>&url=<?php echo $item_permalink;?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=640,height=480')" class="pfsharebar-twitter info-tip2" aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Share','pointfindert2d');?></span><span class="pfadmicon-glyph-769"></span></a></li>
			
			<li><a href="https://plus.google.com/share?url=<?php echo $item_permalink;?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=640,height=480')" class="pfsharebar-google info-tip2" aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Share','pointfindert2d');?></span><span class="pfadmicon-glyph-813"></span></a></li>
	
			<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $item_permalink;?>&title=<?php echo $item_title;?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=640,height=480')" class="pfsharebar-linkedin info-tip2" aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Share','pointfindert2d');?></span><span class="pfadmicon-glyph-824"></span></a></li>
	
			<li><a href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $item_thumnail2;?>&url=<?php echo $item_permalink;?>&description=<?php echo $item_title;?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=640,height=480')" class="pfsharebar-pinterest info-tip2" aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Share','pointfindert2d');?></span><span class="pfadmicon-glyph-810"></span></a></li>
			
			<li><a href="http://vk.com/share.php?url=<?php echo $item_permalink;?>&image=<?php echo $item_thumnail2;?>&title=<?php echo $item_title;?>&description=<?php echo $item_title;?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=640,height=480')" class="pfsharebar-vk info-tip2" aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Share','pointfindert2d');?></span><span class="pfadmicon-glyph-980"></span></a></li>
		</ul>
<?php
	echo '<ul class="pf-sharebar-others">';

	if ($setup4_membersettings_favorites == 1) {
		echo '
		<li>
			<a class="pf-favorites-link" data-pf-num="'.$post_id.'" data-pf-active="'.$fav_check.'" data-pf-item="true" title="'.$favtitle_text.'">
				<i class="'.$faviconname.'"></i> 
				<span id="itempage-pffav-text" class="hidden-xs hidden-sm">'.$favtitle_text.'</span>
			</a>
		</li>
		';
	}


	if($setup42_itempagedetails_report_status == 1){
		echo '
		<li>
			<a class="pf-report-link" data-pf-num="'.$post_id.'">
				<i class="pfadmicon-glyph-485"></i> 
				<span class="hidden-xs hidden-sm">'.esc_html__('Report','pointfindert2d').'</span>
			</a>
		</li>
		';
	}

	$listing_verified = get_post_meta( $post_id, 'webbupointfinder_item_verified', true );
	if($setup42_itempagedetails_claim_status == 1 && $claim_list_permission == 1 && $listing_verified != 1){
		echo '
		<li>
			<a id="pfclaimitem" class="pf-claim-link" data-pf-num="'.$post_id.'">
				<i class="pfadmicon-glyph-658"></i> 
				<span class="hidden-xs hidden-sm">'.esc_html__('Claim','pointfindert2d').'</span>
			</a>
		</li>
		';
	}

	echo '
	<li class="hidden-xs hidden-sm"><a onclick="javascript:window.print();"><i class="pfadmicon-glyph-388"></i> '.esc_html__('Print','pointfindert2d').'</a></li>
	</ul>';
	echo '</div>';
}
?>