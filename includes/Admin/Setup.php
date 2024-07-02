<?php

namespace AnalyticsTest\Admin;

/**
 * AnalyticsTest Setup Class
 */
class Setup {
	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'woocommerce_analytics_report_menu_items', array( $this, 'register_page' ) );
	}

	/**
	 * Load all necessary dependencies.
	 *
	 * @since 1.0.0
	 */
	public function register_scripts() {
		if ( ! method_exists( 'Automattic\WooCommerce\Admin\PageController', 'is_admin_or_embed_page' ) ||
		! \Automattic\WooCommerce\Admin\PageController::is_admin_or_embed_page()
		) {
			return;
		}

		$script_path       = '/build/index.js';
		$script_asset_path = dirname( MAIN_PLUGIN_FILE ) . '/build/index.asset.php';
		$script_asset      = file_exists( $script_asset_path )
		? require $script_asset_path
		: array(
			'dependencies' => array(),
			'version'      => filemtime( $script_path ),
		);
		$script_url        = plugins_url( $script_path, MAIN_PLUGIN_FILE );

		wp_register_script(
			'analytics-test',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		wp_register_style(
			'analytics-test',
			plugins_url( '/build/index.css', MAIN_PLUGIN_FILE ),
			// Add any dependencies styles may have, such as wp-components.
			array(),
			filemtime( dirname( MAIN_PLUGIN_FILE ) . '/build/index.css' )
		);

		wp_enqueue_script( 'analytics-test' );
		wp_enqueue_style( 'analytics-test' );
	}

	/**
	 * Register page in wc-admin.
	 *
	 * @since 1.0.0
	 */
	public function register_page( $report_pages ) {
		$report_pages[] = array(
			'id'     => 'order-attribution',
			'title'  => __( 'Order Attribution', 'magnolia' ),
			'parent' => 'woocommerce-analytics',
			'path'   => '/analytics/order-attribution',
		);
		return $report_pages;
	}
}
