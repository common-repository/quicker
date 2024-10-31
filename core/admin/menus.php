<?php
/**
 * Menu class
 *
 */

namespace Quicker\Core\Admin;

use Quicker\Utils\Singleton;

/**
 * Class Menu
 */
class Menus
{

    use Singleton;
	private $capability = 'read';
    /**
     * Initialize
     *
     * @return void
     */
    public function init()
    {
        add_action('admin_menu', array($this, 'register_admin_menu'));
    }


    /**
     * Register admin menu
     *
     * @return void
     */

    public function register_admin_menu() {
        $slug       = 'quicker';

		// Add main page
		if ( empty ( $GLOBALS['admin_page_hooks'][$slug] ) ) {
			$logo = file_get_contents(  \Quicker::assets_url() . 'images/logo.svg' );

			add_menu_page(
				esc_html__('Quicker', 'quicker'),
				esc_html__('Quicker', 'quicker'),
				$this->capability,
				$slug,
				array($this,'quicker_view'),
				'data:image/svg+xml;base64,' . base64_encode($logo ),
				10
			);
		}

		// Add submenu pages
		if (count( $this->sub_menu_pages() ) > 0 ) {
			foreach ( $this->sub_menu_pages() as $key => $value ) {
				add_submenu_page( $value['parent_slug'], $value['page_title'], $value['menu_title'],
				$value['capability'], $value['menu_slug'], $value['cb_function'] , $value['position'] );
			}
		}

    }

	/**
	 * Create menu page
	 * @param [type] $cb_function
	 */
	public function sub_menu_pages() {
		$sub_pages  = array(
			array(
				"parent_slug" => 'quicker',
				"page_title"  => esc_html__('Overview','quicker'),
				"menu_title"  => esc_html__('Overview','quicker'),
				"capability"  => $this->capability,
				"menu_slug"   => 'quicker',
				"cb_function" => array($this,'quicker_view'),
				"position"    => 11
			),
			array(
				"parent_slug" => 'quicker',
				"page_title"  => esc_html__('Settings', 'quicker'),
				"menu_title"  => esc_html__('Settings', 'quicker'),
				"capability"  => $this->capability,
				"menu_slug"   => 'quicker-settings',
				"cb_function" => array($this,'quicker_view'),
				"position"    => 12
			),
			array(
				"parent_slug" => 'quicker',
				"page_title"  => esc_html__('Checkout Fields', 'quicker'),
				"menu_title"  => esc_html__('Checkout Fields', 'quicker'),
				"capability"  => $this->capability,
				"menu_slug"   => 'quicker-checkout-fields',
				"cb_function" => array($this,'quicker_view'),
				"position"    => 12
			)
		);

		return $sub_pages;
	}
	/**
     * Modules pages view
     */
    public function quicker_view() {
		$url_part 		= '';
		$current_page 	= ( isset( $_GET['page'] ) ) ? sanitize_text_field( $_GET['page'] ) : 'quicker';		
		if (file_exists(\Quicker::core_dir() . 'admin/header.php')) {
			require_once \Quicker::core_dir().'admin/header.php';
		}

		switch ( $current_page ) {
			case 'quicker':
				$url_part ='admin/overview.php';
				break;
			case 'quicker-settings':
				$url_part ='admin/settings/form.php';
				break;
			case 'quicker-checkout-fields':
				$url_part ='admin/checkout-fields.php';
				break;
			default:
				break;
		}
		if ( file_exists( \Quicker::core_dir() . $url_part ) ) {
			include_once \Quicker::core_dir() . $url_part; 
		}
    }

}

