<?php

namespace Quicker;

use Quicker;

Class Wrapper{

	private static $instance;

	/**
	 * __construct function
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Load autoload method.
		Autoloader::run();
		
		//pro & others menu
		add_filter( 'plugin_action_links_'.Quicker::plugins_basename(), array( $this , 'add_action_links' ) );
		// Core files
		\Quicker\Core\Core::instance()->init();
		// Enqueue Assets
		\Quicker\Base\Enqueue::instance()->init();
	}
	
	/**
	 * Add required links
	 *
	 * @param [type] $actions
	 * @return array
	 */
	public function add_action_links( $actions ) {
		$this->custom_css();

		$actions[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=quicker') ) .'">'.
		esc_html__('Settings','quicker').'</a>';
		if ( !class_exists('QuickerPro') ) {
			$actions[] = '<a href="https://woooplugin.com/quicker/" class="quicker-go-pro" target="_blank">'.esc_html__('Go To Premium','quicker').'</a>';
		}

		return $actions;
	}

	/**
	 * Custom css
	 *
	 * @param string $template
	 * @return void
	 */
	public function custom_css() {
		global $custom_css;
			$custom_css = '
				.quicker-go-pro {
					color: #086808;
					font-weight: bold;
				}
			';
		
		wp_register_style( 'quicker-go-pro', Quicker::get_version() );
		wp_enqueue_style( 'quicker-go-pro' );
		wp_add_inline_style('quicker-go-pro',$custom_css);
	}

	/**
	 * Singleton Instance
	 *
	 * @return Wrapper
	 */
	public static function instance() {

		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}