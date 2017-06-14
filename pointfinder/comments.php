<div class="comments">
	<?php if (post_password_required()){ ?>
	<p><?php esc_html_e( 'Post is password protected. Enter the password to view any comments.', 'pointfindert2d' ); ?></p>
</div>

	<?php return; }; ?>

<?php if (have_comments()){ ?>
	<ul>
		<?php wp_list_comments('type=comment&callback=pointfindert2dcomments'); ?>
	</ul>

<?php }elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ){ ?>
	
	<p><?php esc_html_e( 'Comments are closed here.', 'pointfindert2d' ); ?></p>
	
<?php
	  };
echo '<div class="pointfinder-comments-paging">';
paginate_comments_links(); 
echo '</div>';

/**
*Start : Comments Form Customization
**/
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$commenter = wp_get_current_commenter();
	$comment_args = array( 
		'must_log_in' => '<p class="must-log-in">'.sprintf(esc_html__('You must be %s logged in %s to post a comment.','pointfindert2d'),'<a class="pf-login-modal">','</a>').'</p>',
		'fields' => apply_filters( 'comment_form_default_fields', 
			array(
				'author' => '
					<section>
			       		<div class="row">
			            	<div class="col6 first">
			                   
			                    <label class="lbl-ui">
			                    	<input type="text" name="author" id="author" class="input" placeholder="' . esc_html__( 'Name','pointfindert2d' ) . '' . ( $req ? '*' : '' ) .'"' . $aria_req . ' value="' . esc_attr( $commenter['comment_author'] ) . '" />
			                    </label>
			                </div>
			                <div class="col6 last colspacer-two">
			                    
			                    <label class="lbl-ui">
			                    	<input type="email" name="email" id="email" class="input" placeholder="' . esc_html__( 'Email Address','pointfindert2d' ) . '' . ( $req ? '*' : '' ) .'"' . $aria_req . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" />
			                    </label>
			                </div>
			            </div>                       
			        </section> 
				',
				'email'  => '',
				'url'    => ''
				) 
			),
		'comment_field' => '
			<section>
	            <label class="lbl-ui">
	            	<textarea id="comment" name="comment" class="textarea" placeholder="' . esc_html__( 'Your comment','pointfindert2d' ) . '"></textarea>
	            </label>                          
	        </section>
		'
	);
	

	
    ob_start();
	comment_form($comment_args);
	$output_cmform = ob_get_contents();
	ob_end_clean();
    $output_cmform = str_replace('class="comment-form"','class="comment-form golden-forms"',$output_cmform);
    echo $output_cmform;
    

/**
*End : Comments Form Customization
**/
?>
<script type="text/javascript">
	(function($) {
  		"use strict";
  		$(function(){
  			$('#submit').addClass('button');
  		})
  	})(jQuery);
</script>

</div>