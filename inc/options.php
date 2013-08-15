<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'charlie_may_options', 'charlie_may_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', THEME_NAME ), __( 'Theme Options', THEME_NAME ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}



/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . wp_get_theme() . __( ' Theme Options', THEME_NAME ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', THEME_NAME ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'charlie_may_options' ); ?>
			<?php $options = get_option( 'charlie_may_theme_options' ); ?>

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e( 'Account Page ID', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[account_page_id]" class="regular-text" type="text" name="charlie_may_theme_options[account_page_id]" value="<?php esc_attr_e( $options['account_page_id'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Cart Page ID', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[cart_page_id]" class="regular-text" type="text" name="charlie_may_theme_options[cart_page_id]" value="<?php esc_attr_e( $options['cart_page_id'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Terms &amp; Conditions Page ID', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[tnc_page_id]" class="regular-text" type="text" name="charlie_may_theme_options[tnc_page_id]" value="<?php esc_attr_e( $options['tnc_page_id'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Gallery Page ID', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[gallery_page_id]" class="regular-text" type="text" name="charlie_may_theme_options[gallery_page_id]" value="<?php esc_attr_e( $options['gallery_page_id'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Submit Photo Page ID', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[submit_photo_page_id]" class="regular-text" type="text" name="charlie_may_theme_options[submit_photo_page_id]" value="<?php esc_attr_e( $options['submit_photo_page_id'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Celebrity Bear Page ID', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[celebrity_bear_page_id]" class="regular-text" type="text" name="charlie_may_theme_options[celebrity_bear_page_id]" value="<?php esc_attr_e( $options['celebrity_bear_page_id'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'All Bears Category ID', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[all_bears_category_id]" class="regular-text" type="text" name="charlie_may_theme_options[all_bears_category_id]" value="<?php esc_attr_e( $options['all_bears_category_id'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Customer Service Page ID', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[customer_service_page_id]" class="regular-text" type="text" name="charlie_may_theme_options[customer_service_page_id]" value="<?php esc_attr_e( $options['customer_service_page_id'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Facebook URL', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[facebook_url]" class="regular-text" type="text" name="charlie_may_theme_options[facebook_url]" value="<?php esc_attr_e( $options['facebook_url'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Twitter URL', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[twitter_url]" class="regular-text" type="text" name="charlie_may_theme_options[twitter_url]" value="<?php esc_attr_e( $options['twitter_url'] ); ?>" />
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Pinterest URL', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[pinterest_url]" class="regular-text" type="text" name="charlie_may_theme_options[pinterest_url]" value="<?php esc_attr_e( $options['pinterest_url'] ); ?>" />
					</td>
				</tr>
				

				<tr valign="top"><th scope="row"><?php _e( 'Google Plus URL', THEME_NAME ); ?></th>
					<td>
						 <input id="charlie_may_theme_options[google_plus_url]" class="regular-text" type="text" name="charlie_may_theme_options[google_plus_url]" value="<?php esc_attr_e( $options['google_plus_url'] ); ?>" />
					</td>
				</tr>

				
			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', THEME_NAME ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	$input['account_page_id'] = wp_filter_nohtml_kses( $input['account_page_id'] );
	$input['cart_page_id'] = wp_filter_nohtml_kses( $input['cart_page_id'] );
	$input['tnc_page_id'] = wp_filter_nohtml_kses( $input['tnc_page_id'] );
	$input['gallery_page_id'] = wp_filter_nohtml_kses( $input['gallery_page_id'] );
	$input['submit_photo_page_id'] = wp_filter_nohtml_kses( $input['submit_photo_page_id'] );
	$input['celebrity_bear_page_id'] = wp_filter_nohtml_kses( $input['celebrity_bear_page_id'] );
	$input['all_bears_category_id'] = wp_filter_nohtml_kses( $input['all_bears_category_id'] );
	$input['customer_service_page_id'] = wp_filter_nohtml_kses( $input['customer_service_page_id'] );
	$input['facebook_url'] = wp_filter_nohtml_kses( $input['facebook_url'] );
	$input['twitter_url'] = wp_filter_nohtml_kses( $input['twitter_url'] );
	$input['pinterest_url'] = wp_filter_nohtml_kses( $input['pinterest_url'] );
	$input['google_plus_url'] = wp_filter_nohtml_kses( $input['google_plus_url'] );
	return $input;
}