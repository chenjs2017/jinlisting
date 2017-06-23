<?php 
/**********************************************************************************************************************************
*
* Item Detail Page - Review Functions
* 
* Author: Webbu Design
***********************************************************************************************************************************/


function pfcalculate_total_rusers($pid){
	/*$pid = post id of reviewed item.*/
	global $wpdb;

	$reviews = $wpdb->get_results($wpdb->prepare("
		SELECT key2.meta_value FROM $wpdb->postmeta as key1 
		INNER JOIN $wpdb->posts as posts 
		ON key1.post_id = posts.ID and posts.post_status = %s
		INNER JOIN $wpdb->postmeta as key2 
		ON key1.post_id = key2.post_id and key2.meta_key = %s 
		where key1.meta_key = %s and key1.meta_value = %d
		",
		"publish",
		"webbupointfinder_review_rating",
		"webbupointfinder_review_itemid",
		$pid
		),
	'ARRAY_A');

	if (!empty($reviews)) {
		return count($reviews);
	}
}

function pfcalc_json_arr($values){

	$all_reviews = json_decode($values);

	$review_total = 0;

	if (PFControlEmptyArr($all_reviews) != false) {
		foreach ($all_reviews as $single_review) {
			$review_total = $review_total + $single_review;
		}
	}

	return $review_total;
}

function pf_number_of_rev_criteria(){
	/*Get number of criteria */
	global $pfitemreviewsystem_options;
	$setup11_reviewsystem_criterias = $pfitemreviewsystem_options['setup11_reviewsystem_criterias'];
	$review_status = PFControlEmptyArr($setup11_reviewsystem_criterias);

	$criteria_number = 0;

	if($review_status != false){
		$criteria_number = count($setup11_reviewsystem_criterias);
	}
	return $criteria_number;
}


function pfcalculate_single_review($pid){
	/*$pid = post_meta id of review post.*/
	$all_reviews = get_post_meta( $pid, 'webbupointfinder_review_rating', true );

	if (!empty($all_reviews)) {
		$review_total = pfcalc_json_arr($all_reviews);
		return round(($review_total/pf_number_of_rev_criteria()),1);
	}
}



function pf_get_review_post_ID($pid){
	/*$pid = post id of reviewed item.*/
	global $wpdb;
	$review_post_ID = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta where meta_key = %s and meta_value = %d","webbupointfinder_review_itemid",$pid));
	return $review_post_ID;
}



function pf_get_review_user_avatar($rid){
	/*$rid = post id of review post.*/
	global $wpdb;
	$review_user_ID = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta where post_ meta_key = %s and post_id = %d","webbupointfinder_review_userid",$rid));
	
	if (!empty($review_user_ID)) {
		return get_avatar( $review_user_ID ,128 );
	}else{
		return get_template_directory_uri().'/images/empty_avatar.jpg';
	}

	
}


function pfcalculate_total_review($pid){
	/*$pid = post id of reviewed item.*/
	global $wpdb;

	$reviews = $wpdb->get_results($wpdb->prepare("
		SELECT key2.meta_value FROM $wpdb->postmeta as key1 
		INNER JOIN $wpdb->posts as posts 
		ON key1.post_id = posts.ID and posts.post_status = %s 
		INNER JOIN $wpdb->postmeta as key2 
		ON key1.post_id = key2.post_id and key2.meta_key = %s 
		where key1.meta_key = %s and key1.meta_value = %d
		",
		"publish",
		"webbupointfinder_review_rating",
		"webbupointfinder_review_itemid",
		$pid
		)
	,'ARRAY_A');


	if (!empty($reviews)) {
		
		$criteria_number = pf_number_of_rev_criteria();

		$review_total = 0;

		if (PFControlEmptyArr($reviews) != false) {
			foreach ($reviews as $single_review) {
				$review_total = $review_total + (pfcalc_json_arr($single_review['meta_value'])/$criteria_number);
			}

			foreach ($reviews as $single_review_peritem) {
				$single_review_peritem = json_decode($single_review_peritem['meta_value']);
				for ($k=0; $k < $criteria_number; $k++) { 
					if (!isset($review_total_peritem[$k])) {
						$review_total_peritem[$k] = $single_review_peritem[$k];
					}else{
						$review_total_peritem[$k] = $review_total_peritem[$k] + $single_review_peritem[$k];
					}
				}
			}

			if(PFControlEmptyArr($review_total_peritem)!= false ){
				$review_count = count($reviews);

				foreach ($review_total_peritem as $review_total_single) {
					$review_total_result[] = round(($review_total_single / $review_count),0);
				}
			}

		}

		$review_number = 0;

		$review_number = count($reviews);
		$total_results_exit = round(($review_total/$review_number),1);
		
		$return_results = array('totalresult'=> $total_results_exit, 'peritemresult'=>$review_total_result);

		return $return_results;

	}
}





function pfcalculate_total_review_ot($pid){
	/*$pid = post id of reviewed item.*/
	global $wpdb;

	$reviews = $wpdb->get_results($wpdb->prepare("
		SELECT key2.meta_value FROM $wpdb->postmeta as key1 
		INNER JOIN $wpdb->posts as posts 
		ON key1.post_id = posts.ID and posts.post_status = %s 
		INNER JOIN $wpdb->postmeta as key2 
		ON key1.post_id = key2.post_id and key2.meta_key = %s 
		where key1.meta_key = %s and key1.meta_value = %d
		",
		"publish",
		"webbupointfinder_review_rating",
		"webbupointfinder_review_itemid",
		$pid
		)
	,'ARRAY_A');


	if (!empty($reviews)) {
		
		$criteria_number = pf_number_of_rev_criteria();

		$review_total = 0;

		if (PFControlEmptyArr($reviews) != false) {
			foreach ($reviews as $single_review) {
				$review_total = $review_total + (pfcalc_json_arr($single_review['meta_value'])/$criteria_number);
			}

			foreach ($reviews as $single_review_peritem) {
				$single_review_peritem = json_decode($single_review_peritem['meta_value']);
				for ($k=0; $k < $criteria_number; $k++) { 
					if (!isset($review_total_peritem[$k])) {
						$review_total_peritem[$k] = $single_review_peritem[$k];
					}else{
						$review_total_peritem[$k] = $review_total_peritem[$k] + $single_review_peritem[$k];
					}
				}
			}

		}

		$review_number = 0;

		$review_number = count($reviews);

		$return_results = array('totalresult'=> round(($review_total/$review_number),1));

		return $return_results;

	}
}



function pfget_reviews_peritem($pid){
	$reviews = get_post_meta( $pid, 'webbupointfinder_review_rating', true );
	$reviews = json_decode($reviews);
	if (is_array($reviews)) {
		global $pfitemreviewsystem_options;
		$setup11_reviewsystem_criterias = $pfitemreviewsystem_options['setup11_reviewsystem_criterias'];
		$mixed_arr = '<div class="pfreviewcriterias">';
		$criteria_number = pf_number_of_rev_criteria();
			$i = 0;
			
			foreach ($setup11_reviewsystem_criterias as $key => $value) {

				$mixed_arr .= '
					<span class="pf-rating-block clearfix">
			       		<span class="pf-rev-cr-text">'.$value.':</span>
			            <span class="pf-rev-stars">';
			            if (isset($reviews[$key])) {
			            	for ($m=0; $m < $reviews[$key]; $m++) { 
				           		$mixed_arr .= '<i class="pfadmicon-glyph-377" ></i>';
				           	}
				           	for ($s=0; $s < (5-$reviews[$key]); $s++) { 
				           		$mixed_arr .= '<i class="pfadmicon-glyph-378 nostarp" ></i>';
				           	}
			            }
			           	
			            $mixed_arr .= '</span>
			 		</span>
				';
				$i++;
			}

		$mixed_arr .= '</div>';

		return $mixed_arr;
	}
	
	
}
?>