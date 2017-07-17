<?php 
//jschen, add events
$the_post_id = get_the_id();
$can_edit = pf_current_user_can_edit_post($the_post_id);
if ($can_edit) {      

	$pf_size = PFSAIssetControl('setup4_submitpage_imagesizelimit','','2');/*Image size limit*/
	$stp4_Filelimit = PFSAIssetControl("setup4_submitpage_imagelimit","","10");
	$images_of_thispost = get_post_meta($the_post_id, 'webbupointfinder_item_images');
	$images_count = count($images_of_thispost) + 1;
	$pf_count = $stp4_Filelimit - $images_count;

	?>
	<form id="myform"> 
			<div class="pfsearchformerrors">
							<ul>
							</ul>
			<a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d');?></a>
			</div>
	<div class="pftcmcontainer golden-forms hidden-print pf-itempagedetail-element">
		<div class="pfitempagecontainerheader" id="event">添加最新活动:</div>
			<section>
					<input name="event_title" class="input" placeholder="活动标题" type="text" >
			</section>
			<section>
					<textarea name="event_content" class="textarea" placeholder="活动内容" ></textarea>
			</section>
			<?php echo pf_get_upload_image_section($pf_count, $pf_size, true);?>
			<input name='itemid' type="hidden" value='<?php echo $the_post_id?>'/>
			<input type="submit" class="button green" value='提交活动' text="提交活动"/>
		</div>
	</form>
	<style>
	.my-error-class {
			color:#FF0000;  /* red */
	}
	</style>
	<script type='text/javascript'>
		(function($) {
					"use strict";
					$(document).ready(function () {
							$('#myform').validate({ 
									errorClass: "my-error-class",
									rules: {
											event_title: {
													required: true,
											},
											event_content: {
													required: true,
													minlength: 5
											}
									},
									submitHandler: function (form) { 
											var datastring = $("#myform").serialize();
											$.pfEventwithAjax(datastring);
											return false;
									},
							});
					});
		 })(jQuery);
	</script>
<?php
}?>
