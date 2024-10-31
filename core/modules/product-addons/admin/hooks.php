<?php

namespace Quicker\Core\Modules\Product_Addons\Admin;
use Quicker\Utils\Singleton;

defined( "ABSPATH" ) || exit;

/**
 * Product Addons activities.
 */
class Hooks {

	use Singleton;

	/**
	 * Call hooks
	 */
	public function init() {
		// add assets.
		add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_assets'] );
		add_action( 'woocommerce_product_write_panel_tabs', [ $this, 'panel_tab' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'panel_content' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'process_product_meta_data' ], 1 );

		add_action( 'wp_ajax_add_pao', [ $this, 'add_pao_fields' ] );
		add_action( 'wp_ajax_nopriv_add_pao', [ $this, 'add_pao_fields' ] );

	}

	/**
	 * enqueue all css and js with localization data
	 */
	public function admin_enqueue_assets() {
		wp_enqueue_script( 'jquery-ui-sortable');
		wp_enqueue_style( 'quicker_pro_pao', \Quicker::core_url() . 'modules/product-addons/assets/css/admin.css', [], \Quicker::get_version(), 'all' );
		wp_enqueue_script( 'quicker_pro_pao', \Quicker::core_url() . 'modules/product-addons/assets/js/admin.js', ['jquery','jquery-ui-sortable'], \Quicker::get_version(), true );

		$translation_data = [
				'ajax_url'              => admin_url( 'admin-ajax.php' ),
				'add_pao_nonce'         => wp_create_nonce( 'quicker_pao_nonce_value' ),
				'remove_pao_nonce'      => wp_create_nonce( 'remove_pao_nonce_value' ),
				'add_option_nonce'      => wp_create_nonce( 'add_option_nonce_value' ),
				'remove_option_nonce'   => wp_create_nonce( 'remove_option_nonce_value' ),
				'addons'                => array( 'option_name'=> esc_html__('Please fill the Option field','quicker-pro') ,
				'pao_title'=> esc_html__('Please fill the Title field','quicker-pro') ),
				'repeater_text'         => array('opt_name'=> esc_html__('Option name'), 'def_select' => esc_html__('Default selected','quicker-pro'),
				'qty_based' => esc_html__('Quantity Based','quicker-pro'))
		];

		wp_localize_script( 'quicker_pro_pao', 'quicker_pro_pao_obj', $translation_data );
	}

	/**
	 * Add extra tab to show panel
	 */
	public function panel_tab() {
		?>
			<li class="quicker_pro_pao_tab quicker_pro_pao show_if_simple show_if_variable">
				<a href="#quicker_pao_content">
			<span><?php esc_html_e( 'Product Addons', 'quicker-pro' ); ?></span></a></li>
		<?php
	}

	/**
	 * Panel content area to show addon fields
	 */
	public function panel_content() {
		global $post;

		$product      = wc_get_product( $post );
		$product_paos = array_filter( (array) $product->get_meta( '_quicker_pao_data' ) );
		include( dirname( __FILE__ ) . '/templates/fields-area.php' );
	}

	/**
	 * Save fields to product as meta data
	 *
	 * @param int $post_id param.
	 */
	public function process_product_meta_data( $post_id ) {
		$pao_data = $this->process_addon_data( $_POST );
		$product = wc_get_product( $post_id );
		$product->update_meta_data( '_quicker_pao_data', $pao_data );
		$product->save();
	}

	/**
	 * Process product addon data
	 *
	 * @param [type] $content param.
	 */
	public function process_addon_data( $content = [] ) {
		$pao_data = [];

		if ( isset( $content['quicker_pao_title'] ) ) {
			$pao_type                  = $content['quicker_pao_type'];
			$pao_title                 = $content['quicker_pao_title'];
			$pao_title_format          = $content['quicker_pao_title_format'];

			$pao_place_holder          = isset( $content['quicker_pao_place_holder'] ) ? $content['quicker_pao_place_holder'] : [];
			$pao_char_limit_enable     = isset( $content['quicker_pao_char_limit_enable'] ) ? $content['quicker_pao_char_limit_enable'] : []; // checkbox
			$pao_char_min              = isset( $content['quicker_pao_char_min'] ) ? $content['quicker_pao_char_min'] : [];
			$pao_char_max              = isset( $content['quicker_pao_char_max'] ) ? $content['quicker_pao_char_max'] : [];

			$pao_desc_enable           = isset( $content['quicker_pao_desc_enable'] ) ? $content['quicker_pao_desc_enable'] : []; // checkbox
			$pao_desc                  = $content['quicker_pao_desc'];
			$pao_required              = isset( $content['quicker_pao_required'] ) ? $content['quicker_pao_required'] : []; // checkbox
			$pao_option_label          = $content['quicker_pao_option_label'];
			$pao_option_price          = $content['quicker_pao_option_price'];
			$pao_option_price_type     = $content['quicker_pao_option_price_type'];
			$pao_option_default        = isset( $content['quicker_pao_option_default'] ) ? $content['quicker_pao_option_default'] : []; // radio
			$pao_position              = isset( $content['quicker_pao_position'] ) ? $content['quicker_pao_position'] : []; // for sort situation.

			for ( $i = 0; $i < count( $pao_title ); $i++ ) {
				// if not exist or empty then no need to process
				if ( ! isset( $pao_title[ $i ] ) || ( empty( $pao_title[ $i ] ) ) ) {
					continue;
				}

				$single_type = $pao_type[ $i ];

				$pao_options = [];
				if ( isset( $pao_option_label[ $i ] ) ) {
					$option_label       = $pao_option_label[ $i ];
					$option_price       = $pao_option_price[ $i ];
					$option_price_type  = $pao_option_price_type[ $i ];
					$option_default     = isset( $pao_option_default[ $i ] ) ? $pao_option_default[ $i ] : [];

					if ( $single_type == 'text' ) {
							$option_label   = [ 'dummy' ];
							$option_default = [];
					}

					for ( $opt = 0; $opt < count( $option_label ); $opt++ ) {
						$label = $this->clean_field( $option_label[ $opt ] );
						if ( ! empty( $label ) ) {
								$price      = wc_format_decimal( $this->clean_field( $option_price[ $opt ] ) );
								$price_type = $this->clean_field( $option_price_type[ $opt ] );
								$default    = in_array( $opt, $option_default ) ? 1 : 0;

								if ( $single_type == 'text' ) {
										$label = '';
								}

								$pao_options[] = [
										'label'      => $label,
										'price'      => $price,
										'price_type' => $price_type,
										'default'    => $default,
								];
						}
					}
				}

				$data                 = [];
								$data['type']         = $this->clean_field( $pao_type[ $i ] );
				$data['title']        = $this->clean_field( $pao_title[ $i ] );
								$data['title_format'] = $this->clean_field( $pao_title_format[ $i ] );
								$data['place_holder'] = isset( $pao_place_holder[ $i ] ) ? $this->clean_field( $pao_place_holder[ $i ] ) : '';
								$data['char_limit']   = isset( $pao_char_limit_enable[ $i ] ) ? 1 : 0;

								$char_min = isset( $pao_char_min[ $i ] ) ? absint( $pao_char_min[ $i ] ) : 0;
								$char_max = isset( $pao_char_max[ $i ] ) ? absint( $pao_char_max[ $i ] ) : 0;

								if ( $char_min > $char_max ) {
										$temp     = $char_min;
										$char_min = $char_max;
										$char_max = $temp;
								}

								$data['char_min'] = $char_min;
								$data['char_max'] = $char_max;

								$data['desc_enable']  = isset( $pao_desc_enable[ $i ] ) ? 1 : 0;
								$data['desc']         = wp_kses_post( wp_unslash( $pao_desc[ $i ] ) );
								$data['required']     = isset( $pao_required[ $i ] ) ? 1 : 0;
								$data['position']     = isset( $pao_position[ $i ] ) ? absint( $pao_position[ $i ] ) : 0;

								if ( ! empty( $pao_options ) ) {
					$data['options'] = $pao_options;
				}

				$pao_data[] = $data;
			}
		}

		uasort( $pao_data, [ $this, 'addon_rows_position_compare' ] );

		return $pao_data;
	}

	/**
	 * Clean input data
	 *
	 * @param [type] $item param.
	 * @return string
	 */
	public function clean_field( $item ) {
			return sanitize_text_field( wp_unslash( $item ) );
	}

	/**
	 * Sort addon fields block
	 *
	 * @param [type] $a param.
	 * @param [type] $b param.
	 */
	public function addon_rows_position_compare( $a, $b ) {
		if ( $a['position'] == $b['position'] ) {
			return 0;
		}

		return ( $a['position'] < $b['position'] ) ? -1 : 1;
	}

	/**
	 * Add new addon fields block
	 **/
	public function add_pao_fields() {
			$status_code = 0;
			$message     = '';
			$content     = '';

			if ( ! wp_verify_nonce( $_POST['security'], 'quicker_pao_nonce_value' ) ) {
					$message = esc_html__( 'Nonce is not valid! Please try again.', 'quicker-pro' );
			} else {
					ob_start();
					$counter = isset( $_POST['next_pao_index'] ) ? absint( $_POST['next_pao_index'] ) : 0;

					include( dirname( __FILE__ ) . '/templates/single-field.php' );
					$content     = ob_get_clean();

					$status_code = 1;
					$message     = esc_html__( 'New fields block is added successfully.', 'quicker-pro' );
			}

			$response = [
					'status_code' => $status_code,
					'message'     => $message,
					'content'     => $content,
			];
			echo json_encode( $response );
			wp_die();
	}

}
