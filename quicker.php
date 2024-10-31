<?php
/**
 * Plugin Name:       Quicker
 * Plugin URI:        https://woooplugin.com/quicker/
 * Description:       Quicker comes to speedup you WooCommerce Checkout from multiple steps to single step.
 * Version:           1.0.16
 * Requires at least: 5.2
 * Requires PHP:      7.3
 * Author:            Woooplugin
 * Author URI:        https://woooplugin.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       quicker
 * Domain Path:       /languages
 * @package Quicker
 * @category Core
 * @author Quicker
 * @version 1.0.0
 */

use Quicker\Utils\Helper;

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * The Main Plugin Requirements Checker
 *
 * @since 1.0.0
 */
final class Quicker {

	private static $instance;

	/**
     * Current  Version
     *
     * @return string
     */
    public static function get_version() {
		if( ! function_exists('get_plugin_data') ){
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$plugin_data = get_plugin_data( __FILE__ );
		return !empty($plugin_data['Version']) ? $plugin_data['Version'] : '';
    }

	/**
     * Singleton Instance
     *
     * @return Quicker
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

	/**
     * Setup Plugin Requirements
     *
     * @since 1.0.0
     */
    private function __construct() {
        // Load modules
		add_action( 'plugins_loaded', array( $this, 'initialize_modules' ), 999 );

    }

	/**
	 * Initialize Modules
	 *
	 * @since 1.1.0
	 */
	public function initialize_modules() {
		do_action( 'quicker/before_load' );

		require_once plugin_dir_path( __FILE__ ) . 'autoloader.php';
		require_once plugin_dir_path( __FILE__ ) . 'wrapper.php';
		// required plugin check
		$this->required_plugin();
		// Localization.
		$this->load_text_domain();
		// Load Plugin modules and classes
		\Quicker\Wrapper::instance();

		do_action( 'quicker/after_load' );
	}

	/**
	 * Check required plugin and throw notice
	 *
	 * @return void
	 */
	public function required_plugin() {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
		$plugins = array( array( 'name' => 'woccommerce' , 'slug' => 'woocommerce/woocommerce.php'  ) );

		foreach ( $plugins as $key => $value) {
			if ( !is_plugin_active( $value['slug'] ) ) {
				add_action( 'admin_notices', [$this, 'woo_plugin_notice'] );
			}
		}
	}

	/**
     * Load on plugin
     *
     * @return void
     */
    public function woo_plugin_notice( $slug ) {

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
		
        if ( class_exists( 'WooCommerce' ) ) {
            $btn['label'] = esc_html__( 'Activate WooCommerce', 'quicker' );
            $btn['url']   = wp_nonce_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=all&paged=1', 'activate-plugin_woocommerce/woocommerce.php' );
        } else {
            $btn['label'] = esc_html__( 'Install WooCommerce', 'quicker' );
            $btn['url']   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
        }

        Helper::push(
            [
                'id'          => 'unsupported-woocommerce-version',
                'type'        => 'error',
                'dismissible' => true,
                'btn'         => $btn,
                'message'     => sprintf( esc_html__( 'Quicker requires WooCommerce , which is currently NOT RUNNING.', 'quicker' ) ),
            ]
        );
    }

	/**
     * Load Localization Files
     *
     * @since 1.0.0
     * @return void
     */
	public function load_text_domain() {
		load_plugin_textdomain( 'basic-plugin', false, self::plugin_dir() . 'languages/' );
    }

	/**
	 * Assets Directory Url
	 *
	 */
	public static function assets_url() {
		return trailingslashit( self::plugin_url() . 'assets' );
	}

	/**
	 * Assets Folder Directory Path
	 *
	 * @since 1.0.0
	 */
	public static function assets_dir() {
		return trailingslashit( self::plugin_dir() . 'assets' );
	}

	/**
	 * Plugin Core File Directory Url
	 *
	 * @since 1.0.0
	 *
	 */
	public static function core_url() {
		return trailingslashit( self::plugin_url() . 'core' );
	}

	/**
	 * Plugin Core File Directory Path
	 *
	 * @since 1.0.0
	 *
	 */
	public static function base_dir() {
		return trailingslashit( self::plugin_dir() . 'base' );
	}

	/**
	 * Plugin Core File Directory Path
	 *
	 * @since 1.0.0
	 *
	 */
	public static function core_dir() {
		return trailingslashit( self::plugin_dir() . 'core' );
	}

	/**
	 * Plugin Template File Directory Path
	 *
	 * @since 1.0.0
	 *
	 */
	public static function template_dir() {
		return trailingslashit( self::plugin_dir() . 'templates' );
	}

	/**
	 * Plugin Url
	 *
	 * @since 1.0.0
	 *
	 */
	public static function plugin_url() {
		return trailingslashit( plugin_dir_url( self::plugin_file() ) );
	}

	/**
	 * Plugin Directory Path
	*
	* @since 1.0.0
	*
	*/
	public static function plugin_dir() {
		return trailingslashit( plugin_dir_path( self::plugin_file() ) );
	}

	/**
	 * Plugins Basename
	 *
	 * @since 1.0.0
	 */
	public static function plugins_basename(){
		return plugin_basename( self::plugin_file() );
	}

	/**
	 * Plugin File
	 *
	 * @since 1.0.0
	 *
	 */
	public static function plugin_file(){
		return __FILE__;
	}


}

// Initiate Plugin
Quicker::get_instance();

