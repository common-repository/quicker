<?php

namespace Quicker\Base;

defined( 'ABSPATH' ) || exit;

use Quicker\Utils\Singleton;

/**
 * Enqueue all css and js file class
 */
class Enqueue {

    use Singleton;

    /**
     * Main calling function
     */
    public function init() {
        // backend asset
        add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_assets'] );
        // frontend asset
        add_action( 'wp_enqueue_scripts', [$this, 'frontend_enqueue_assets'] );
        // enqueue editor css.
        add_action( 'elementor/editor/before_enqueue_styles', [$this, 'elementor_editor_css'] );
        // enqueue editor js.
        add_action( 'elementor/frontend/before_enqueue_scripts', [$this, 'elementor_js'] );
    }
  

    /**
     * all admin js files function
     */
    public function admin_get_scripts() {
		$script_arr = array(
            'quicker-select2'  => array(
                'src'     => \Quicker::assets_url() . 'js/quicker-select2.js',
                'version' => \Quicker::get_version(),
                'deps'    => ['jquery'],
            ),
            'quicker-repeater'  => array(
                'src'     => \Quicker::assets_url() . 'js/quicker-repeater.js',
                'version' => \Quicker::get_version(),
                'deps'    => ['jquery'],
            ),
            'quicker-admin-js' => array(
                'src'     => \Quicker::assets_url() . 'js/admin.js',
                'version' => \Quicker::get_version(),
                'deps'    => ['jquery','quicker-select2'],
            ),
        );
        
        return $script_arr;
    }

    /**
     * all admin css files function
     *
     * @param array
     */
    public function admin_get_styles() {
        return array(
            'quicker-select2' => array(
                'src'     => \Quicker::assets_url() . 'css/select2.css',
                'version' => \Quicker::get_version(),
            ),
            'quicker-admin-css' => array(
                'src'     => \Quicker::assets_url() . 'css/admin.css',
                'version' => \Quicker::get_version(),
            )
        );
    }

    /**
     * Enqueue admin js and css function
     *
     * @param  $var
     */
    public function admin_enqueue_assets() {
        $screen = get_current_screen();
        $pages  = \Quicker\Utils\Helper::admin_pages_id();

        // load js in specific pages
        if ( is_admin() && ( in_array( $screen->id , $pages ) ) ) {
                foreach ( $this->admin_get_scripts() as $key => $value ) {
                    $deps       = !empty( $value['deps'] ) ? $value['deps'] : false;
                    $version    = !empty( $value['version'] ) ? $value['version'] : false;
                    wp_enqueue_script( $key, $value['src'], $deps, $version, true );
                }

                // css

                foreach ( $this->admin_get_styles() as $key => $value ) {
                    $deps       = isset( $value['deps'] ) ? $value['deps'] : false;
                    $version    = !empty( $value['version'] ) ? $value['version'] : false;
                    wp_enqueue_style( $key, $value['src'], $deps, $version, 'all' );
                }

                // localize for admin
                $settings = \Quicker\Utils\Helper::get_settings();
                $form_data                          = array();
                $form_data['ajax_url']              = admin_url( 'admin-ajax.php' );
                $form_data['nonce']                 = wp_create_nonce( 'quicker' );
                $form_data['up_sell_products']      = $settings['up_sell_products'];
                $form_data['cross_sell_products']   = $settings['cross_sell_products'];
                $form_data['extra_fees']            = $settings['extra_fees'];
                wp_localize_script( 'quicker-admin-js', 'quicker_admin_data', $form_data );
        }

    }

    /**
     * all js files function
     */
    public function frontend_get_scripts() {
        $script_arr = array(
            'frontend-js'     => array(
                'src'     => \Quicker::assets_url() . 'js/frontend.js',
                'version' => \Quicker::get_version(),
                'deps'    => ['jquery','quicker-swiper'],
            ),
            'quicker-swiper' => array(
                'src'     => \Quicker::assets_url() . 'js/quicker-swiper-element-bundle.min.js',
                'version' => \Quicker::get_version(),
                'deps'    => ['jquery'],
            ),
        );

        return $script_arr;
    }

    /**
     * all css files function
     */
    public function frontend_get_styles() {
        $enequeue =  array(
            'quicker-public' => array(
                'src'     => \Quicker::assets_url() . 'css/public.css',
                'version' => \Quicker::get_version(),
            ),
            'quicker-swiper' => array(
                'src'     => \Quicker::assets_url() . 'css/quicker-swiper-bundle.min.css',
                'version' => \Quicker::get_version(),
            )
        );

        return $enequeue;
    }

    /**
     * Enqueue admin js and css function
     */
    public function frontend_enqueue_assets() {
        // js
        $scripts = $this->frontend_get_scripts();

        foreach ( $scripts as $key => $value ) {
            $deps       = isset( $value['deps'] ) ? $value['deps'] : false;
            $version    = !empty( $value['version'] ) ? $value['version'] : false;
            wp_enqueue_script( $key, $value['src'], $deps, $version, true );
        }

        // css
        $styles = $this->frontend_get_styles();

        foreach ( $styles as $key => $value ) {
            $deps = isset( $value['deps'] ) ? $value['deps'] : false;
            $version    = !empty( $value['version'] ) ? $value['version'] : false;
            wp_enqueue_style( $key, $value['src'], $deps, $version, 'all' );
        }

        // localize for frontend
        $form_data                        = array();
        $form_data['quicker_ajax_url']        = admin_url( 'admin-ajax.php' );
        $form_data['nonce']               = wp_create_nonce( 'quicker' );

        wp_localize_script( 'quicker-js', 'quicker_client_data',  $form_data ); 
    }

    /**
     * Elementor editor css loaded
     */
    public function elementor_editor_css() {
    }

    /**
     * Elementor js loaded
     */
    public function elementor_js() {
    }

}


