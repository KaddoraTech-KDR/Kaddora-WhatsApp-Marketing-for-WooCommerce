<?php
/**
 * Plugin Name:       Kaddora WhatsApp Marketing for WooCommerce
 * Description:       WooCommerce WhatsApp marketing plugin for abandoned cart recovery, order notifications, broadcast campaigns, and click-to-chat features.
 * Version:           1.0.0
 * Author:            Kaddora
 * Text Domain:       kaddora-whatsapp-marketing
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * WC requires at least: 6.0
 * WC tested up to:   9.0
 *
 * @package KaddoraWhatsAppMarketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
|--------------------------------------------------------------------------
| Plugin Constants
|--------------------------------------------------------------------------
*/
define( 'KWM_VERSION', '1.0.0' );
define( 'KWM_PLUGIN_FILE', __FILE__ );
define( 'KWM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'KWM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'KWM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'KWM_PLUGIN_NAME', 'Kaddora WhatsApp Marketing' );
define( 'KWM_TEXT_DOMAIN', 'kaddora-whatsapp-marketing' );

/*
|--------------------------------------------------------------------------
| Minimum Requirements
|--------------------------------------------------------------------------
*/
if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
	add_action(
		'admin_notices',
		function () {
			?>
			<div class="notice notice-error">
				<p>
					<?php esc_html_e( 'Kaddora WhatsApp Marketing requires PHP 7.4 or higher.', 'kaddora-whatsapp-marketing' ); ?>
				</p>
			</div>
			<?php
		}
	);
	return;
}

/*
|--------------------------------------------------------------------------
| Include Core Files
|--------------------------------------------------------------------------
*/
require_once KWM_PLUGIN_DIR . 'includes/core/class-kwm-loader.php';
require_once KWM_PLUGIN_DIR . 'includes/core/class-kwm-activator.php';
require_once KWM_PLUGIN_DIR . 'includes/core/class-kwm-deactivator.php';
require_once KWM_PLUGIN_DIR . 'includes/core/class-kwm-installer.php';
require_once KWM_PLUGIN_DIR . 'includes/core/class-kwm-helper.php';
require_once KWM_PLUGIN_DIR . 'includes/core/class-kwm-logger.php';

require_once KWM_PLUGIN_DIR . 'includes/admin/class-kwm-admin.php';

require_once KWM_PLUGIN_DIR . 'includes/frontend/class-kwm-public.php';
require_once KWM_PLUGIN_DIR . 'includes/frontend/class-kwm-click-to-chat.php';

require_once KWM_PLUGIN_DIR . 'includes/integrations/woocommerce/class-kwm-woocommerce.php';
require_once KWM_PLUGIN_DIR . 'includes/integrations/whatsapp/class-kwm-whatsapp.php';
require_once KWM_PLUGIN_DIR . 'includes/integrations/whatsapp/class-kwm-webhook.php';

require_once KWM_PLUGIN_DIR . 'includes/modules/class-kwm-abandoned-cart.php';
require_once KWM_PLUGIN_DIR . 'includes/modules/class-kwm-order-messages.php';
require_once KWM_PLUGIN_DIR . 'includes/modules/class-kwm-campaigns.php';

/*
|--------------------------------------------------------------------------
| Activation / Deactivation Hooks
|--------------------------------------------------------------------------
*/
register_activation_hook( __FILE__, array( 'KWM_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'KWM_Deactivator', 'deactivate' ) );

/*
|--------------------------------------------------------------------------
| Main Plugin Class
|--------------------------------------------------------------------------
*/
if ( ! class_exists( 'KWM_Plugin' ) ) {

	class KWM_Plugin {

		/**
		 * Loader instance.
		 *
		 * @var KWM_Loader
		 */
		protected $loader;

		/**
		 * Admin instance.
		 *
		 * @var KWM_Admin
		 */
		protected $admin;

		/**
		 * Public instance.
		 *
		 * @var KWM_Public
		 */
		protected $public;

		/**
		 * WooCommerce integration instance.
		 *
		 * @var KWM_WooCommerce
		 */
		protected $woocommerce;

		/**
		 * WhatsApp integration instance.
		 *
		 * @var KWM_WhatsApp
		 */
		protected $whatsapp;

		/**
		 * Webhook instance.
		 *
		 * @var KWM_Webhook
		 */
		protected $webhook;

		/**
		 * Abandoned cart module instance.
		 *
		 * @var KWM_Abandoned_Cart
		 */
		protected $abandoned_cart;

		/**
		 * Order messages module instance.
		 *
		 * @var KWM_Order_Messages
		 */
		protected $order_messages;

		/**
		 * Campaigns module instance.
		 *
		 * @var KWM_Campaigns
		 */
		protected $campaigns;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->load_textdomain();
			$this->init_components();
			$this->register_hooks();
		}

		/**
		 * Load plugin text domain.
		 *
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain(
				KWM_TEXT_DOMAIN,
				false,
				dirname( KWM_PLUGIN_BASENAME ) . '/languages'
			);
		}

		/**
		 * Initialize plugin components.
		 *
		 * @return void
		 */
		private function init_components() {
			$this->loader         = new KWM_Loader();
			$this->admin          = new KWM_Admin();
			$this->public         = new KWM_Public();
			$this->woocommerce    = new KWM_WooCommerce();
			$this->whatsapp       = new KWM_WhatsApp();
			$this->webhook        = new KWM_Webhook();
			$this->abandoned_cart = new KWM_Abandoned_Cart();
			$this->order_messages = new KWM_Order_Messages();
			$this->campaigns      = new KWM_Campaigns();
		}

		/**
		 * Register all plugin hooks.
		 *
		 * @return void
		 */
		private function register_hooks() {
			/*
			|--------------------------------------------------------------------------
			| Core Hooks
			|--------------------------------------------------------------------------
			*/
			$this->loader->add_action( 'plugins_loaded', $this, 'on_plugins_loaded' );
			$this->loader->add_action( 'init', $this, 'init' );

			/*
			|--------------------------------------------------------------------------
			| Admin Hooks
			|--------------------------------------------------------------------------
			*/
			if ( is_admin() ) {
				$this->loader->add_action( 'admin_menu', $this->admin, 'register_menu' );
				$this->loader->add_action( 'admin_init', $this->admin, 'register_settings' );
				$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'enqueue_assets' );
			}

			/*
			|--------------------------------------------------------------------------
			| Frontend Hooks
			|--------------------------------------------------------------------------
			*/
			$this->loader->add_action( 'wp_enqueue_scripts', $this->public, 'enqueue_assets' );
			$this->loader->add_action( 'init', $this->public, 'register_shortcodes' );
			$this->loader->add_action( 'wp_footer', $this->public, 'render_floating_button' );

			/*
			|--------------------------------------------------------------------------
			| WooCommerce / Module Hooks
			|--------------------------------------------------------------------------
			*/
			$this->loader->add_action( 'init', $this->woocommerce, 'init' );
			$this->loader->add_action( 'init', $this->abandoned_cart, 'init' );
			$this->loader->add_action( 'init', $this->order_messages, 'init' );
			$this->loader->add_action( 'init', $this->campaigns, 'init' );

			/*
			|--------------------------------------------------------------------------
			| Webhook / API Hooks
			|--------------------------------------------------------------------------
			*/
			$this->loader->add_action( 'rest_api_init', $this->webhook, 'register_routes' );

			/*
			|--------------------------------------------------------------------------
			| Run Registered Hooks
			|--------------------------------------------------------------------------
			*/
			$this->loader->run();
		}

		/**
		 * Callback when plugins are loaded.
		 *
		 * @return void
		 */
		public function on_plugins_loaded() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				add_action(
					'admin_notices',
					function () {
						?>
						<div class="notice notice-error">
							<p>
								<?php esc_html_e( 'Kaddora WhatsApp Marketing requires WooCommerce to be installed and active.', 'kaddora-whatsapp-marketing' ); ?>
							</p>
						</div>
						<?php
					}
				);
			}
		}

		/**
		 * General plugin init hook.
		 *
		 * @return void
		 */
		public function init() {
			// Reserved for future shared init logic.
		}
	}
}

/*
|--------------------------------------------------------------------------
| Run Plugin
|--------------------------------------------------------------------------
*/
function kwm_run_plugin() {
	return new KWM_Plugin();
}

$GLOBALS['kwm_plugin'] = kwm_run_plugin();