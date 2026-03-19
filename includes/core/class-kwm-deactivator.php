<?php
/**
 * Plugin Deactivator Class
 *
 * Runs on plugin deactivation.
 *
 * @package KaddoraWhatsAppMarketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KWM_Deactivator' ) ) {

	class KWM_Deactivator {

		/**
		 * Run deactivation tasks.
		 *
		 * @return void
		 */
		public static function deactivate() {

			// Clear scheduled cron jobs
			self::clear_scheduled_events();

			// Flush rewrite rules (cleanup endpoints)
			flush_rewrite_rules();
		}

		/**
		 * Clear scheduled cron events.
		 *
		 * @return void
		 */
		private static function clear_scheduled_events() {

			// Abandoned cart recovery cron
			if ( wp_next_scheduled( 'kwm_abandoned_cart_cron' ) ) {
				wp_clear_scheduled_hook( 'kwm_abandoned_cart_cron' );
			}

			// Campaign scheduler cron
			if ( wp_next_scheduled( 'kwm_campaign_cron' ) ) {
				wp_clear_scheduled_hook( 'kwm_campaign_cron' );
			}

			// General queue / retry cron (future-safe)
			if ( wp_next_scheduled( 'kwm_queue_cron' ) ) {
				wp_clear_scheduled_hook( 'kwm_queue_cron' );
			}
		}
	}
}