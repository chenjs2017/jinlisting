<?php

/**
 * User Lost Password Form
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="golden-forms">
<form method="post" action="<?php bbp_wp_login_action( array( 'action' => 'lostpassword', 'context' => 'login_post' ) ); ?>" class="bbp-login-form pfuaprofileformbb">
	<div class="form-enclose clearfix"><div class="form-section">

		<div class="bbp-username">
			<p>
				<label for="user_login" class="hide lbl-text"><?php _e( 'Username or Email', 'pointfindert2d' ); ?>: </label>
				<input type="text" name="user_login" value="" size="20" id="user_login" class="input" tabindex="<?php bbp_tab_index(); ?>" />
			</p>
		</div>

		<?php do_action( 'login_form', 'resetpass' ); ?>

		<div class="bbp-submit-wrapper">

			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" name="user-submit" class="button submit user-submit"><?php _e( 'Reset My Password', 'pointfindert2d' ); ?></button>

			<?php bbp_user_lost_pass_fields(); ?>

		</div>
	</div></div>
</form>
</div>