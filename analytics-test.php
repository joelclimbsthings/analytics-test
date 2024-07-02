<?php
/**
 * Plugin Name: Analytics Test 2
 * Version: 0.1.0
 * Author: The WordPress Contributors
 * Author URI: https://woocommerce.com
 * Text Domain: analytics-test
 * Domain Path: /languages
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package extension
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'MAIN_PLUGIN_FILE' ) ) {
	define( 'MAIN_PLUGIN_FILE', __FILE__ );
}

require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload_packages.php';

use AnalyticsTest\Admin\Setup;

// phpcs:disable WordPress.Files.FileName

/**
 * WooCommerce fallback notice.
 *
 * @since 0.1.0
 */
function analytics_test_2_missing_wc_notice() {
	/* translators: %s WC download URL link. */
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Analytics Test 2 requires WooCommerce to be installed and active. You can download %s here.', 'analytics_test_2' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}

register_activation_hook( __FILE__, 'analytics_test_2_activate' );

/**
 * Activation hook.
 *
 * @since 0.1.0
 */
function analytics_test_2_activate() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'analytics_test_2_missing_wc_notice' );
		return;
	}
}

if ( ! class_exists( 'analytics_test_2' ) ) :
	/**
	 * The analytics_test_2 class.
	 */
	class analytics_test_2 {
		/**
		 * This class instance.
		 *
		 * @var \analytics_test_2 single instance of this class.
		 */
		private static $instance;

		/**
		 * Constructor.
		 */
		public function __construct() {
			if ( is_admin() ) {
				new Setup();
			}
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'analytics_test_2' ), $this->version );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'analytics_test_2' ), $this->version );
		}

		/**
		 * Gets the main instance.
		 *
		 * Ensures only one instance can be loaded.
		 *
		 * @return \analytics_test_2
		 */
		public static function instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
endif;

add_action( 'plugins_loaded', 'analytics_test_2_init', 10 );

/**
 * Initialize the plugin.
 *
 * @since 0.1.0
 */
function analytics_test_2_init() {
	load_plugin_textdomain( 'analytics_test_2', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'analytics_test_2_missing_wc_notice' );
		return;
	}

	analytics_test_2::instance();

}
