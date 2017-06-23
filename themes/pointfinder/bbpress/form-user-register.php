<?php

/**
 * User Registration Form
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="golden-forms">
<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form pfuaprofileformbb">
	<div class="form-enclose clearfix"><div class="form-section">
	
		<div class="bbp-template-notice">
			<p><?php _e( 'Your username must be unique, and cannot be changed later.', 'pointfindert2d' ) ?></p>
			<p><?php _e( 'We use your email address to email you a secure password and verify your account.', 'pointfindert2d' ) ?></p>

		</div>

		<div class="bbp-username">
			<label for="user_login" class="lbl-text"><?php _e( 'Username', 'pointfindert2d' ); ?>: </label>
			<input type="text" name="user_login" value="<?php bbp_sanitize_val( 'user_login' ); ?>" size="20" id="user_login" class="input" tabindex="<?php bbp_tab_index(); ?>" />
		</div>

		<div class="bbp-email">
			<label for="user_email" class="lbl-text"><?php _e( 'Email', 'pointfindert2d' ); ?>: </label>
			<input type="text" name="user_email" value="<?php bbp_sanitize_val( 'user_email' ); ?>" size="20" id="user_email" class="input" tabindex="<?php bbp_tab_index(); ?>" />
		</div>

		<?php do_action( 'register_form' ); ?>

		<div class="bbp-submit-wrapper">

			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" name="user-submit" class="button submit user-submit"><?php _e( 'Register', 'pointfindert2d' ); ?></button>

			<?php bbp_user_register_fields(); ?>

		</div>
	
	</div></div>
</form>
</div>
