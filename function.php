<?
/**
 * Plugin Name: easy-payment
 * Plugin URI: https://itshare.asia
 * Description: This is Easy Payment Plugin paypment 
 * Version: 1.0
 * Author: TUAN 'RENT' M.NGUYEN
 * Author URI: https://itshare.asia
 * License: GPLv2 or later 
 */
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

if(!defined('STRIPE_BASE_URL')) {
	define('STRIPE_BASE_URL', plugin_dir_url(__FILE__));
}

if(!defined('STRIPE_BASE_DIR')) {
	define('STRIPE_BASE_DIR', dirname(__FILE__));
}

include( plugin_dir_path( __FILE__ ) . 'inc/shortcode.php');
include( plugin_dir_path( __FILE__ ) . 'inc/process.php');
require_once('vendor/autoload.php');
/*==================================== MENU SETTING FIELD ===================================*/
function register_mysettings() {
	// Advance meta for plugin's back-end.
	register_setting( 'mfpd-settings-group', 'organization_name_payment');
	register_setting( 'mfpd-settings-group', 'your_name_payment');
	register_setting( 'mfpd-settings-group', 'email_address_payment');
	register_setting( 'mfpd-settings-group', 'success_message_payment');

	// Advance meta sandbox/live mode for stripe mayment.
	register_setting( 'mfpd-settings-group', 'sandbox_stripe_api_publishable_key');
	register_setting( 'mfpd-settings-group', 'sandbox_stripe_api_secret_key');
	register_setting( 'mfpd-settings-group', 'livemode_stripe_api_publishable_key');
	register_setting( 'mfpd-settings-group', 'livemode_stripe_api_secret_key');

	// Advance meta sandbox/live mode for paypal mayment.
	register_setting( 'mfpd-settings-group', 'sandbox_paypal_api_key_client_id');
	register_setting( 'mfpd-settings-group', 'sandbox_paypal_api_key_secret_key');
	register_setting( 'mfpd-settings-group', 'livemode_paypal_api_key_client_id');
	register_setting( 'mfpd-settings-group', 'livemode_paypal_api_key_secret_key');

	// Advance meta type of payment. [yes/no]:
	/**
	 * YES: Livemode
	 * NO : Sandbox
	 */
	register_setting( 'mfpd-settings-group-type-payment', 'emp_type_payment');

	register_setting( 'mfpd-settings-group', 'func');
	register_setting( 'mfpd-settings-group', 'starting_amount_payment');

	// Advance meta for plugin's front-end.
	register_setting( 'mfpd-settings-group-frontend', 'epm_font_size');
	register_setting( 'mfpd-settings-group-frontend', 'epm_font_family');
	register_setting( 'mfpd-settings-group-frontend', 'epm_main_color');
}
/*==================================== MENU ADMIN ===================================*/
function mfpd_create_menu() {
	add_menu_page('Plugin Settings', 'Easy Payment Plugin', 'administrator', __FILE__, 'mfpd_settings_page_payment', plugins_url('/images/icon.jpg', __FILE__), 1);
	add_submenu_page( __FILE__, 'Settings page title', 'Settings [Frontend]', 'administrator', 'setting-ease-payment', 'mfpd_settings_page_payment_setting');
	add_action( 'admin_init', 'register_mysettings' );
}
add_action('admin_menu', 'mfpd_create_menu');

/*==================================== ENTER FIELD ===================================*/
function mfpd_settings_page_payment() {
	?>
	<div id="payment_ease_paypal" class="wrap">
		<h2>Easy Payment Plugin</h2>
		<div class="clear_payment"></div>
		<div class="thanks_message">
			Thank you for downloading the plugin, we hope to make charitable giving as seamless as possible. If there are any features or elements that you would like to be but into this platform please let us know at <a href="http://bitly.com.pluginform">http://bitly.com.pluginform</a>

			<div class="way-to-use" style="margin-top: 20px;">
				After you've been insert Stripe (Publishable API API key - Secret key) & Paypal (Client id key - Secret key). You can copy this shortcode <code>[easy_payments]</code> and paste anywhere you want to display.
				Thanks
			</div>
		</div>
		<div class="clear_payment"></div>
		<?php if( isset($_GET['settings-updated']) ) { ?>
			<div id="message" class="updated">
				<p><strong><?php _e('Settings saved.') ?></strong></p>
			</div>
		<?php } ?>
		<form method="post" id="payment-settings" action="options.php">
			<?php settings_fields( 'mfpd-settings-group' ); ?>
			<div id="field_payment" class="form-table">
				<div class="input_field_payment_style">
					<input type="text" placeholder="Organization Name" name="organization_name_payment" value="<?php echo get_option('organization_name_payment'); ?>" />
				</div>
				<div class="input_field_payment_style">
					<input type="text" placeholder="Your Name" name="your_name_payment" value="<?php echo get_option('your_name_payment'); ?>" />
				</div>
				<div class="input_field_payment_style">
					<input type="text" placeholder="Email Address" name="email_address_payment" value="<?php echo get_option('email_address_payment'); ?>" />
				</div>
				<div class="clear_payment"></div>
				<div class="border_payment"></div>
				<div class="clear_payment"></div>
				<!-- Stripe -->
				<div class="title_p"><?php _e( 'Settings', 'epm_efe' ); ?></div>
				<div class="clear_payment"></div>
				<div class="title_tripe"><?php _e( 'Stripe Sandbox', 'epm_efe' ); ?></div>
				<div class="input_field_payment_style">
					<input type="text" autocomplete="off" placeholder="Sandbox Publishable key" name="sandbox_stripe_api_publishable_key" value="<?php echo get_option('sandbox_stripe_api_publishable_key'); ?>" />
				</div>
				<div class="input_field_payment_style">
					<input type="text" autocomplete="off" placeholder="Sandbox Secret key" name="sandbox_stripe_api_secret_key" value="<?php echo get_option('sandbox_stripe_api_secret_key'); ?>" />
				</div>
				
				<div class="clear_payment"></div>
				<div class="title_tripe"><?php _e( 'Stripe Live mode', 'epm_efe' ) ?></div>
				<div class="input_field_payment_style">
					<input type="text" autocomplete="off" placeholder="Live mode Publishable key" name="livemode_stripe_api_publishable_key" value="<?php echo get_option('livemode_stripe_api_publishable_key'); ?>" />
				</div>
				<div class="input_field_payment_style">
					<input type="text" autocomplete="off" placeholder="Live mode Secret key" name="livemode_stripe_api_secret_key" value="<?php echo get_option('livemode_stripe_api_secret_key'); ?>" />
				</div>

				<!-- paypal-->
				<div class="clear_payment"></div>
				<div class="title_tripe"><?php _e( 'Paypal sandbox', 'epm_efe' ); ?></div>
				<div class="input_field_payment_style">
					<input type="text" autocomplete="off" placeholder="Sandbox Paypal API Client ID key" name="sandbox_paypal_api_key_client_id" value="<?php echo get_option('sandbox_paypal_api_key_client_id'); ?>" />
				</div>
				<div class="input_field_payment_style">
					<input type="text" autocomplete="off" placeholder="Sandbox Paypal API Secret key" name="sandbox_paypal_api_key_secret_key" value="<?php echo get_option('sandbox_paypal_api_key_secret_key'); ?>" />
				</div>
	
				<div class="clear_payment"></div>
				<div class="title_tripe"><?php _e( 'Paypal live mode', 'epm_efe' ); ?></div>
				<div class="input_field_payment_style">
					<input type="text" autocomplete="off" placeholder="Live Mode Paypal API Client ID key" name="livemode_paypal_api_key_client_id" value="<?php echo get_option('livemode_paypal_api_key_client_id'); ?>" />
				</div>
				<div class="input_field_payment_style">
					<input type="text" autocomplete="off" placeholder="Live Mode Paypal API Secret key" name="livemode_paypal_api_key_secret_key" value="<?php echo get_option('livemode_paypal_api_key_secret_key'); ?>" />
				</div>

				<!-- Accepting payments-->
				<div class="clear_payment"></div>
				<div class="title_tripe">Accepting payments</div>
				<div class="clear_payment"></div>
				<div class="can-toggle can-toggle--size-large">
					<?php
					$type_payment = get_option('emp_type_payment');
					if ( $type_payment == '' || $type_payment == 'on' ) {
						$type_payment = 'sandbox';
					}
					?>
					<input id="c" type="checkbox" class="emp_type_payment" data-check-custom="<?php echo $type_payment; ?>" <?php checked('sandbox' == $type_payment); ?>>
					<label for="c" class="emp_type_payment">
						<div class="can-toggle__switch" data-checked="Sandbox" data-unchecked="Live"></div>
						<!-- <div class="can-toggle__label-text"></div> -->
					</label>
				</div>

				<div class="clear_payment"></div>
				<div class="input_field_payment_style">
					<input class="message_payment" type="text" placeholder="Success Message" name="success_message_payment" value="<?php echo get_option('success_message_payment'); ?>" />
					<div class="title-label-input"><?php _e( 'Enter a message for your community once there is a successful donation', 'epm_efe' ); ?></div>
				</div>
				<div class="clear_payment"></div>
				<div class="input_field_payment_style">
					<input class="message_payment" type="text" placeholder="Starting Amount" name="starting_amount_payment" value="<?php echo get_option('starting_amount_payment'); ?>" />
					<div class="title-label-input"><?php _e( 'This is the starting amount in the slider, if left blank defaults to $1', 'epm_efe' ); ?></div>
				</div>

			</div>
			<?php submit_button(); ?>
		</form>
		<script>
			jQuery(document).ready(function() {
				jQuery('#payment_ease_paypal input.emp_type_payment').on('click', function(event) {
				    var __target 	= jQuery(this);
				    var __val 		= __target.attr('data-check-custom');
				    if ( __val == 'sandbox' ) {
				    	__target.attr('data-check-custom', 'livemode');
				    	__val = 'livemode';
				    } else if ( __val == 'livemode' ) {
				    	__target.attr('data-check-custom', 'sandbox');
				    	__val = 'sandbox';
				    }

				    jQuery.ajax({
				    	type: 'POST',
				    	url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				    	data: {
				    		action: 'emp_type_payment',
				    		_value: __val
				    	},
				    	success: function(response) {
				    		console.log (response);
				    	},
				    	error: function(err) {
				    		console.log (err);
				    	}
				    });

				});
			});
		</script>
	</div>
<?php }
/*==================================== LOAD STYLE  ===================================*/

add_action('wp_ajax_emp_type_payment', 'emp_type_payment_func');
function emp_type_payment_func() {
	$__val_payment_type = $_POST['_value'];
	if ( isset( $__val_payment_type ) ) {
		update_option( 'emp_type_payment', $__val_payment_type );
	}

	// echo 'Server: ' . get_option('emp_type_payment');

	die();
}

add_action('admin_init','load_file_folder');
function load_file_folder()
{
	wp_register_style('style',plugins_url('css/style.css',__FILE__));
	wp_register_style('style-frontend',plugins_url('css/style.frontend.css',__FILE__));
	wp_enqueue_style('style');
	wp_enqueue_style('style-frontend');
}
add_action('wp_enqueue_scripts', 'enqueue_scripts_and_styles_function');
function enqueue_scripts_and_styles_function(){
	wp_register_style('style',plugins_url('css/style.css',__FILE__));
	// wp_register_style('style-frontend',plugins_url('css/style.frontend.css',__FILE__));
	// wp_enqueue_style('style');
	wp_enqueue_style('style-frontend');
	wp_register_style('quinn',plugins_url('css/jquery-ui.css',__FILE__));
	wp_enqueue_style('quinn');
	wp_register_style('font-awesome','https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array());
	wp_enqueue_style('font-awesome');
	wp_register_style('rangeslider-css',plugins_url('css/rangeslider.css',__FILE__));
	wp_enqueue_style('rangeslider-css');
	wp_enqueue_script('jquerys-js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array());
	wp_enqueue_script('jquerys-link-js', 'https://code.jquery.com/jquery-1.12.4.js', array());
	wp_enqueue_script('12-js', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array());
	// wp_enqueue_script('examples-js', plugins_url('js/rangeslider.js',__FILE__));
	wp_enqueue_script('jquery-quinnjs', plugins_url('js/rangeslider.min.js',__FILE__));
	wp_enqueue_script('jquery-js_custom', plugins_url('js/js_custom.js',__FILE__));
 
	wp_enqueue_script('jquery');
	wp_enqueue_script('stripe', 'https://js.stripe.com/v1/');
	wp_enqueue_script('stripe-processing', plugin_dir_url(__FILE__) . 'js/stripe-processing.js');
	$publishable_key 	= get_option('sandbox_stripe_api_publishable_key');
	// Get notication message from setting plugin.
    $msg_notify         = get_option('success_message_payment');
    $msg_notify         = $msg_notify != '' ? $msg_notify : 'Thanks for your donation..';
	wp_localize_script('stripe-processing', 'stripe_vars', array(
			'publishable_key' 	=> $publishable_key,
			'baseUrlPlugin' 	=> STRIPE_BASE_URL,
			'msg_success' 		=> $msg_notify
		)
	);
}
/*==================================== CREATE DATABASE  ===================================*/

function ratings_fansub_create_payment() {
	global $wpdb;
	$table_name = $wpdb->prefix. "payment_ease";
	global $charset_collate;
	$charset_collate = $wpdb->get_charset_collate();
	global $db_version;

	if ( $wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") !=  $table_name) {
		$create_sql = "CREATE TABLE " . $table_name . " (
		id_member INT(11) NOT NULL auto_increment,
		amout INT(11) NOT NULL ,
		payment_option TEXT NOT NULL,
		email TEXT NOT NULL,
		credit_Car INT(11) NOT NULL,
		donation INT(11) NOT NULL,
		PRIMARY KEY (id_member))$charset_collate;";
	}
	require_once(ABSPATH . "wp-admin/includes/upgrade.php");
	dbDelta( $create_sql );

    //register the new table with the wpdb object
	if (!isset($wpdb->ratings_fansub)) {
		$wpdb->ratings_fansub = $table_name;
        //add the shortcut so you can use $wpdb->stats
		$wpdb->tables[] = str_replace($wpdb->prefix, '', $table_name);
	}

}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'ratings_fansub_create_payment');

/*==================================== SETTING PAYMENT ===================================*/
function mfpd_settings_page_payment_setting() {
	?>
	<h3>Setting frontend</h3>
	
	<div class="clear_payment"></div>
	<?php if( isset($_GET['settings-updated']) ) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php } ?>
	<form method="post" action="options.php">
		<?php settings_fields( 'mfpd-settings-group-frontend' ); ?>
		<div class="field">
			<label for="main-color">Main color: </label>
			<div class="right">
				<input type="text" autocomplete="off" id="main-color" name="epm_main_color" style="width: 100%;" placeholder="Main color" value="<?php echo get_option('epm_main_color'); ?>">
				<?php
				$color__ = get_option('epm_main_color');
				$color__ = $color__ != '' ? $color__ : '#009999';
				?>
				<small style="position: relative;">Set main color for plugin. [Default: <code style="font-size: 11px; ?>">#009999</code>]. Current color: <span style="position: absolute; top: -2px; width: 15px; height: 15px; background: <?php echo $color__; ?>"></span> </small>
			</div>
		</div>
		<div class="field">
			<label for="main-font-family">Font Family: </label>
			<div class="right">
				<input type="text" autocomplete="off" id="main-font-family" name="epm_font_family"  style="width: 100%;" placeholder="Font Family" value="<?php echo get_option('epm_font_family'); ?>">
				<small>Set Font family for plugin's text.  [Default: <code style="font-size: 11px; ?>">Helvetica</code>]</small>
			</div>
		</div>
		<div class="field">
			<label for="main-font-size">Font size: </label>
			<div class="right">
				<input type="text" autocomplete="off" id="main-font-size" name="epm_font_size"  style="width: 100%;" placeholder="Font size" value="<?php echo get_option('epm_font_size'); ?>">
				<small>Set font size for plugin's text. [Default: <code style="font-size: 11px; ?>">20px</code>]</small>
			</div>
		</div>
		<?php submit_button(); ?>
	</form>
	<style>
		.field {
		    display: grid;
		    grid-template-columns: .1fr .4fr;
		    margin-bottom: 16px;
		}
	</style>
	<?php

}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), '__add_link_to_list_plugin_func');
function __add_link_to_list_plugin_func( $links ) {
	$links[] = '<a href="' .
		admin_url( 'admin.php?page=easypaymentplugin%2Ffunction.php' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}

