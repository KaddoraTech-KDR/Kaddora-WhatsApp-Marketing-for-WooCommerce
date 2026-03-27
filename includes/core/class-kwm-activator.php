<?php
/**
 * Plugin Activator Class
 *
 * Runs on plugin activation.
 *
 * @package KaddoraWhatsAppMarketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KWM_Activator' ) ) {

	class KWM_Activator {

		/**
		 * Run activation tasks.
		 *
		 * @return void
		 */
		public static function activate() {

			// Set default options
			self::set_default_options();

			// Create database tables
			if ( class_exists( 'KWM_Installer' ) ) {
				KWM_Installer::install();
			}

			// Set plugin version
			update_option( 'kwm_version', KWM_VERSION );

			// Flush rewrite rules (for webhook endpoints if needed)
			flush_rewrite_rules();
		}

		/**
		 * Set default plugin options.
		 *
		 * @return void
		 */
		private static function set_default_options() {

			$defaults = array(

				// WhatsApp Settings
				'kwm_whatsapp_enabled'        => 'no',
				'kwm_api_token'               => '',
				'kwm_phone_number_id'         => '',
				'kwm_business_account_id'     => '',

				// Order Notifications
				'kwm_order_notifications'     => 'yes',
				'kwm_notify_processing'       => 'yes',
				'kwm_notify_completed'        => 'yes',
				'kwm_notify_cancelled'        => 'yes',
				'kwm_notify_failed'           => 'yes',

				// Abandoned Cart
				'kwm_abandoned_cart_enabled'  => 'yes',
				'kwm_cart_delay_minutes'      => 30,
				'kwm_cart_message_template'   => '',

				// Campaigns
				'kwm_campaigns_enabled'       => 'yes',

				// Click to Chat
				'kwm_click_to_chat_enabled'   => 'yes',
				'kwm_floating_button_enabled' => 'yes',
				'kwm_button_position'         => 'right',

				// Logging
				'kwm_logging_enabled'         => 'yes',

			);

			foreach ( $defaults as $key => $value ) {
				if ( get_option( $key ) === false ) {
					add_option( $key, $value );
				}
			}
		}
	}
}