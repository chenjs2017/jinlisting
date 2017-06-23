<?php

/**
 * bbPress User Profile Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="golden-forms">
<form id="bbp-your-profile" action="<?php bbp_user_profile_edit_url( bbp_get_displayed_user_id() ); ?>" method="post" enctype="multipart/form-data">
	<div class="pf-row"><div class="col-lg-6 col-md-6">
	<div class="pfuaprofileformbb">
	<div class="form-enclose"><div class="form-section">
	<?php do_action( 'bbp_user_edit_before' ); ?>
	
	

		<?php do_action( 'bbp_user_edit_before_name' ); ?>
		<section>
			<label for="user_login" class="lbl-text"><?php _e( 'Username', 'pointfindert2d' ); ?></label>
			<input type="text" name="user_login" id="user_login" value="<?php bbp_displayed_user_field( 'user_login', 'edit' ); ?>" disabled="disabled" class="input" tabindex="<?php bbp_tab_index(); ?>" />
		</section>

		<section>
			<label for="email" class="lbl-text"><?php _e( 'Email', 'pointfindert2d' ); ?></label>

			<input type="text" name="email" id="email" value="<?php bbp_displayed_user_field( 'user_email', 'edit' ); ?>" class="input" tabindex="<?php bbp_tab_index(); ?>" />

			<?php

			// Handle address change requests
			$new_email = get_option( bbp_get_displayed_user_id() . '_new_email' );
			if ( !empty( $new_email ) && $new_email !== bbp_get_displayed_user_field( 'user_email', 'edit' ) ) : ?>

				<span class="updated inline">

					<?php printf( __( 'There is a pending email address change to <code>%1$s</code>. <a href="%2$s">Cancel</a>', 'pointfindert2d' ), $new_email['newemail'], esc_url( self_admin_url( 'user.php?dismiss=' . bbp_get_current_user_id()  . '_new_email' ) ) ); ?>

				</span>

			<?php endif; ?>

		</section>

		<section id="password">
			<label for="pass1" class="lbl-text"><?php _e( 'New Password', 'pointfindert2d' ); ?></label>
			<fieldset class="bbp-form password">
				<section>
				<label class="lbl-ui">
				<input type="password" name="pass1" id="pass1" size="16" class="input" value="" autocomplete="off" tabindex="<?php bbp_tab_index(); ?>" />
				</label>
				<span class="description"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.', 'pointfindert2d' ); ?></span>
				</section>
				<section>
				<label class="lbl-ui">
				<input type="password" name="pass2" class="input" id="pass2" size="16" value="" autocomplete="off" tabindex="<?php bbp_tab_index(); ?>" />
				</label>
				<span class="description"><?php _e( 'Type your new password again.', 'pointfindert2d' ); ?></span><br />
				</section>
				<section>
				<div id="pass-strength-result"></div>
				<span class="description indicator-hint"><?php _e( 'Your password should be at least ten characters long. Use upper and lower case letters, numbers, and symbols to make it even stronger.', 'pointfindert2d' ); ?></span>
				</section>
			</fieldset>
		</section>

		<section>
			<label for="first_name" class="lbl-text"><?php _e( 'First Name', 'pointfindert2d' ) ?></label>
			<label class="lbl-ui">
			<input type="text" name="first_name" id="first_name"  value="<?php bbp_displayed_user_field( 'first_name', 'edit' ); ?>" class="input" tabindex="<?php bbp_tab_index(); ?>" />
			</label>
		</section>

		<section>
			<label for="last_name" class="lbl-text"><?php _e( 'Last Name', 'pointfindert2d' ) ?></label>
			<label class="lbl-ui">
			<input type="text" name="last_name" id="last_name" value="<?php bbp_displayed_user_field( 'last_name', 'edit' ); ?>" class="input" tabindex="<?php bbp_tab_index(); ?>" />
			</label>
		</section>

		<section>
			<label for="nickname" class="lbl-text"><?php _e( 'Nickname', 'pointfindert2d' ); ?></label>
			<label class="lbl-ui">
			<input type="text" name="nickname" id="nickname" value="<?php bbp_displayed_user_field( 'nickname', 'edit' ); ?>" class="input" tabindex="<?php bbp_tab_index(); ?>" />
			</label>
		</section>

		<section>
			<label for="display_name" class="lbl-text"><?php _e( 'Display Name', 'pointfindert2d' ) ?></label>
			<label class="select">
			<?php bbp_edit_user_display_name(); ?>
			</label>

		</section>


		<section>
			<label for="description" class="lbl-text"><?php _e( 'Biographical Info', 'pointfindert2d' ); ?></label>
			<textarea name="description" id="description" rows="5" cols="30" tabindex="<?php bbp_tab_index(); ?>"><?php bbp_displayed_user_field( 'description', 'edit' ); ?></textarea>
		</section>

		<?php do_action( 'bbp_user_edit_after_name' ); ?>
	</div></div></div>
	
    </div>
    <div class="col-lg-5 col-md-5 col-lg-offset-1 col-md-offset-1">
	<div class="pfuaprofileformbb">
	<div class="form-enclose clearfix"><div class="form-section">

		<?php do_action( 'bbp_user_edit_before_contact' ); ?>

		<section>
			<label for="url" class="lbl-text"><?php _e( 'Website', 'pointfindert2d' ) ?></label>
			<input type="text" name="url" id="url" value="<?php bbp_displayed_user_field( 'user_url', 'edit' ); ?>" class="input code" tabindex="<?php bbp_tab_index(); ?>" />
		</section>

		<?php foreach ( bbp_edit_user_contact_methods() as $name => $desc ) : ?>

			<section>
				<label for="<?php echo esc_attr( $name ); ?>" class="lbl-text"><?php echo apply_filters( 'user_' . $name . '_label', $desc ); ?></label>
				<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php bbp_displayed_user_field( $name, 'edit' ); ?>" class="input" tabindex="<?php bbp_tab_index(); ?>" />
			</section>

		<?php endforeach; ?>
		
		<?php if ( current_user_can( 'edit_users' ) && ! bbp_is_user_home_edit() ) : ?>
			

				<?php do_action( 'bbp_user_edit_before_role' ); ?>

				<?php if ( is_multisite() && is_super_admin() && current_user_can( 'manage_network_options' ) ) : ?>

					<section>
						<label for="super_admin"><?php _e( 'Network Role', 'pointfindert2d' ); ?></label>
						<label>
							<input class="checkbox" type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( bbp_get_displayed_user_id() ) ); ?> tabindex="<?php bbp_tab_index(); ?>" />
							<?php _e( 'Grant this user super admin privileges for the Network.', 'pointfindert2d' ); ?>
						</label>
					</section>

				<?php endif; ?>

				<?php bbp_get_template_part( 'form', 'user-roles' ); ?>

				<?php do_action( 'bbp_user_edit_after_role' ); ?>



		<?php endif; ?>

		<section>

			<?php bbp_edit_user_form_fields(); ?>

			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_user_edit_submit" name="bbp_user_edit_submit" class="button submit user-submit"><?php bbp_is_user_home_edit() ? _e( 'Update Profile', 'pointfindert2d' ) : _e( 'Update User', 'pointfindert2d' ); ?></button>
		</section>


		<?php do_action( 'bbp_user_edit_after_contact' ); ?>



   </div></div></div>
   </div></div>
	
	

	

	

	<?php //do_action( 'bbp_user_edit_after' ); ?>

</form>
</div>