<?php
/**
 * Plugin Name: plugin_name
 * Plugin URI: https://example.com/
 * Description: A brief description of this plugin.
 * Version: 1.0.0
 * Author: Shohei Tanaka
 * Author URI: https://example.com/
 * License: GPL-3.0-or-later
 * Text Domain: plugin-name
 * Domain Path: /i18n
 * Requires at least: 6.4
 * Tested up to: 6.8.2
 * Requires PHP: 8.2
 * WC requires at least: 9.0
 * WC tested up to: 10.1
 * Network: false
 *
 * @package Plugin_Name
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WC Detection
 */
if ( ! function_exists( 'is_woocommerce_active' ) ) {
	/**
	 * Check if WooCommerce is active.
	 *
	 * @return bool True if WooCommerce is active, false otherwise.
	 */
	function is_woocommerce_active() {
		if ( ! isset( $active_plugins ) ) {
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( is_multisite() ) {
				$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
			}
		}
		return in_array( 'woocommerce/woocommerce.php', $active_plugins, true ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
	}
}

if ( is_woocommerce_active() ) {

	if ( ! defined( 'PLUGIN_NAME_PATH' ) ) {
		define( 'PLUGIN_NAME_PATH', __DIR__ );
		define( 'PLUGIN_NAME_URL', plugins_url( '/', __FILE__ ) );
		define( 'PLUGIN_NAME_VERSION', '1.0.0' );
	}

	// Load includes in dependency order.
	$plugin_name_includes = array(
		'/includes/saai_framework/class-saai-wc-user.php',
		'/includes/saai_framework/class-saai-admin-page.php',
		'/includes/class-plugin-name.php',
		'/includes/admin/class-saai-admin-plugin-name.php',
	);

	foreach ( $plugin_name_includes as $file ) {
		$file_path = __DIR__ . $file;
		if ( file_exists( $file_path ) ) {
			require_once $file_path;
		}
	}

	register_activation_hook( __FILE__, array( 'Plugin_Name', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'Plugin_Name', 'deactivate' ) );

	add_action( 'plugins_loaded', 'plugin_name_init', 10 );

	/**
	 * Initialize the plugin.
	 *
	 * Loads the text domain and initializes the main plugin class.
	 */
	function plugin_name_init() {
		load_plugin_textdomain( 'plugin-name', false, plugin_basename( __DIR__ ) . '/i18n' );
		Plugin_Name::instance();
	}

	/**
	 * Declare plugin compatibility with WooCommerce HPOS.
	 */
	add_action(
		'before_woocommerce_init',
		function () {
			if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
			}
		}
	);
}
