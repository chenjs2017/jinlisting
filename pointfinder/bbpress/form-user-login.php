<?php

/**
 * User Login Form
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="golden-forms">
<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form pfuaprofileformbb">
	<div class="form-enclose clearfix"><div class="form-section">
		

		<div class="bbp-username">
			<label for="user_login" class="lbl-text"><?php _e( 'Username', 'pointfindert2d' ); ?>: </label>
			<input type="text" name="log" value="<?php bbp_sanitize_val( 'user_login', 'text' ); ?>" size="20" id="user_login" tabindex="<?php bbp_tab_index(); ?>" class="input" />
		</div>

		<div class="bbp-password">
			<label for="user_pass" class="lbl-text"><?php _e( 'Password', 'pointfindert2d' ); ?>: </label>
			<input type="password" name="pwd" value="<?php bbp_sanitize_val( 'user_pass', 'password' ); ?>" size="20" id="user_pass" tabindex="<?php bbp_tab_index(); ?>" class="input" />
		</div>

		<div class="bbp-remember-me">
			<input type="checkbox" name="rememberme" value="forever" <?php checked( bbp_get_sanitize_val( 'rememberme', 'checkbox' ) ); ?> id="rememberme" tabindex="<?php bbp_tab_index(); ?>" />
			<label for="rememberme"><?php _e( 'Keep me signed in', 'pointfindert2d' ); ?></label>
		</div>

		<?php do_action( 'login_form' ); ?>

		<div class="bbp-submit-wrapper">

			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" name="user-submit" class="button submit user-submit"><?php _e( 'Log In', 'pointfindert2d' ); ?></button>

			<?php bbp_user_login_fields(); ?>

		</div>
	</div></div>
</form>
</div>
