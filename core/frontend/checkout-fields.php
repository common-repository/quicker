<?php

namespace Quicker\Core\Frontend;

defined( 'ABSPATH' ) || exit;

use Quicker\Utils\Singleton;

/**
 * Base Class
 *
 * @since 1.0.0
 */
class CheckoutFields {

 	use Singleton;
	
	/**
	 * Initialize all modules.
	*
	* @since 1.0.0
	*
	* @return void
	*/
	public function init() {
		if ( ! class_exists('WooCommerce') ) {
			return;
		}

		extract(\Quicker\Utils\Helper::get_settings());

		if ( "yes" == $enable_buy_now ) {
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'add_content_after_addtocart' ) );
			add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'checkout_after_btn' ), 10, 3 );
		}
		
		// customize checkout field
		add_filter( 'woocommerce_checkout_fields' , array( $this , 'customize_checkout_fields' ) );
	}

	/**
	 * Add buy now button in shop
	*/
	public function add_content_after_addtocart() {
		$current_product_id = get_the_ID();
		$product            = wc_get_product( $current_product_id );
		echo \Quicker\Utils\Helper::instance()->kses( $this->get_checkout_btn( $product , 'buy-now' ) );

	}
	
	/**
	 * Add product link
	 *
	 * @param [type] $add_to_cart_html
	 * @param [type] $product
	 * @param [type] $args
	 */
	public function checkout_after_btn( $add_to_cart_html, $product, $args ) {
		$after    = "";
		$after    = $this->get_checkout_btn( $product , 'shop-buy-now' );

		return $add_to_cart_html . $after;
	}
	
	/**
	 * Add text in button
	 *
	 * @param [type] $product
	 * @param string $btn_class
	 */
	public function get_checkout_btn($product , $btn_class="" ) {
		$btn="";
		
		extract(\Quicker\Utils\Helper::get_settings());
		$btn_text = $one_click_button_text == '' ? esc_html__( 'Buy Now', 'quicker' ) : $one_click_button_text;
		if ( $product->is_type( 'simple' ) ) {
			$btn = '<a href="' . wc_get_checkout_url() . '?add-to-cart=' . $product->get_id() . '" class="'.$btn_class.' button">' . $btn_text . '</a>';
		}

		return $btn;
	}

	/**
	 * Over Ridding, Removing, Creating New Fields.
	 *
	 * @param [type] $fields
	 * @return void
	 */
	public function customize_checkout_fields($fields) {
		$change_fields  = $this->change_checkout_fields($fields);
		$result_fields  = $this->new_checkout_fields($change_fields);

		return $result_fields;
	}

	public function change_checkout_fields($fields) {
		$checkout_fields = \Quicker\Utils\Helper::get_checkout_fields( -1 );
		foreach ($checkout_fields as $key => $value ) {
			if ( 
				$value['field_name'] !== "" && 
				empty($value['field_position']) && 
			\Quicker\Utils\Helper::format_input_value($value['field_enabled']) == true ) {
				$fields[$value['field_type']][ $value['field_name'] ] = array(
					'type'          => 'text',
					'label'         => $value['field_label'],
					'placeholder'   => $value['field_placeholder'],
					'required'      => \Quicker\Utils\Helper::format_input_value($value['field_required']),
					'class'         => array('form-row-wide'),
					'clear'         => true
				);
			}else{
				unset($fields[$value['field_type']][$value['field_name']]);
			}
		}

		return $fields;
	}

	public function new_checkout_fields($fields) {
		return $fields;
	}

}
