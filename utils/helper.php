<?php

namespace Quicker\Utils;

defined( 'ABSPATH' ) || exit;

/**
 * Helper function
 */
class Helper {

	use Singleton;
	
	/**
	 * Html markup validation
	 */
	public static function kses( $raw ) {
		$allowed_tags = [
			'a'                             => [
				'class'  => [],
				'href'   => [],
				'rel'    => [],
				'title'  => [],
				'target' => [],
			],
			'input'                         => [
				'value'       => [],
				'type'        => [],
				'size'        => [],
				'name'        => [],
				'checked'     => [],
				'placeholder' => [],
				'id'          => [],
				'class'       => [],
				'data-name'  => []
			],

			'select'                        => [
				'value'       => [],
				'type'        => [],
				'size'        => [],
				'name'        => [],
				'placeholder' => [],
				'id'          => [],
				'class'       => [],
				'multiple'    => [],
				'data-option' => [],
				'data-name'   => [],
				'data-id'     => []
			],
			'option'      => [
				'selected'    	=> [],
				'value'   		=> [],
				'disabled'    	=> []
			],
			'textarea'                      => [
				'value'       => [],
				'type'        => [],
				'size'        => [],
				'name'        => [],
				'rows'        => [],
				'cols'        => [],
				'placeholder' => [],
				'id'          => [],
				'class'       => [],
			],
			'abbr'                          => [
				'title' => [],
			],
			'b'                             => [],
			'blockquote'                    => [
				'cite' => [],
			],
			'cite'                          => [
				'title' => [],
			],
			'code'                          => [],
			'del'                           => [
				'datetime' => [],
				'title'    => [],
			],
			'dd'                            => [],
			'div'                           => [
				'data'  => [],
				'class' => [],
				'id' => [],
				'title' => [],
				'style' => [],
			],
			'dl'                            => [],
			'dt'                            => [],
			'em'                            => [],
			'h1'                            => [
				'class' => [],
			],
			'h2'                            => [
				'class' => [],
			],
			'h3'                            => [
				'class' => [],
			],
			'h4'                            => [
				'class' => [],
			],
			'h5'                            => [
				'class' => [],
			],
			'h6'                            => [
				'class' => [],
			],
			'i'                             => [
				'class' => [],
			],
			'img'                           => [
				'alt'    => [],
				'class'  => [],
				'height' => [],
				'src'    => [],
				'width'  => [],
			],
			'li'                            => [
				'class' => [],
			],
			'ol'                            => [
				'class' => [],
			],
			'p'                             => [
				'class' => [],
			],
			'q'                             => [
				'cite'  => [],
				'title' => [],
			],
			'span'                          => [
				'class' => [],
				'title' => [],
				'style' => [],
			],
			'small'                          => [
				'class' => [],
				'title' => [],
				'style' => [],
			],
			'iframe'                        => [
				'width'       => [],
				'height'      => [],
				'scrolling'   => [],
				'frameborder' => [],
				'allow'       => [],
				'src'         => [],
			],
			'strike'                        => [],
			'br'                            => [],
			'strong'                        => [],
			'data-wow-duration'             => [],
			'data-wow-delay'                => [],
			'data-wallpaper-options'        => [],
			'data-stellar-background-ratio' => [],
			'ul'                            => [
				'class' => [],
			],
			'label'                         => [
				'class' => [],
				'for' => [],
			],
		];

		if ( function_exists( 'wp_kses' ) ) { // WP is here
			return wp_kses( $raw, $allowed_tags );
		} else {
			return $raw;
		}

	}

	/**
	 * Show Notices
	 */
	public static function push( $notice ) {

		$defaults = array(
			'id'               => '',
			'type'             => 'info',
			'show_if'          => true,
			'message'          => '',
			'class'            => 'active-notice',
			'dismissible'      => false,
			'btn'              => array(),
			'dismissible-meta' => 'user',
			'dismissible-time' => WEEK_IN_SECONDS,
			'data'             => '',
		);

		$notice = wp_parse_args( $notice, $defaults );

		$classes = array( 'notice', 'notice' );

		$classes[] = $notice['class'];

		if ( isset( $notice['type'] ) ) {
			$classes[] = 'notice-' . $notice['type'];
		}

		// Is notice dismissible?
		if ( true === $notice['dismissible'] ) {
			$classes[] = 'is-dismissible';

			// Dismissable time.
			$notice['data'] = ' dismissible-time=' . esc_attr( $notice['dismissible-time'] ) . ' ';
		}

		// Notice ID.
		$notice_id    = 'sites-notice-id-' . $notice['id'];
		$notice['id'] = $notice_id;

		if ( ! isset( $notice['id'] ) ) {
			$notice_id    = 'sites-notice-id-' . $notice['id'];
			$notice['id'] = $notice_id;
		} else {
			$notice_id = $notice['id'];
		}

		$notice['classes'] = implode( ' ', $classes );

		// User meta.
		$notice['data'] .= ' dismissible-meta=' . esc_attr( $notice['dismissible-meta'] ) . ' ';

		if ( 'user' === $notice['dismissible-meta'] ) {
			$expired = get_user_meta( get_current_user_id(), $notice_id, true );
		} elseif ( 'transient' === $notice['dismissible-meta'] ) {
			$expired = get_transient( $notice_id );
		}
		
		// Notice visible after transient expire.
		if ( isset( $notice['show_if'] ) ) {
			if ( true === $notice['show_if'] ) {
				// Is transient expired?
				if ( false === $expired || empty( $expired ) ) {
					self::markup( $notice );
				}
			}
		} else {
			self::markup( $notice );
		}
	}

	/**
	 * Markup Notice.
	 */
	public static function markup( $notice = [] ) {
		?>
		<div id="<?php echo esc_attr( $notice['id'] ); ?>" class="<?php echo esc_attr( $notice['classes'] ); ?>" <?php echo esc_html( $notice['data'] ); ?>>
			<p>
				<?php echo esc_html($notice['message']); ?>
			</p>

			<?php if ( !empty( $notice['btn'] ) ): ?>
				<p>
					<a href="<?php echo esc_url( $notice['btn']['url'] ); ?>" class="button-primary"><?php echo esc_html( $notice['btn']['label'] ); ?></a>
				</p>
			<?php endif;?>
		</div>
		<?php
	}

	/**
	 * Admin pages array
	 *
	 * @return array
	 */
	public static function admin_pages_id( ) {
		$admin_pages =  array(
		'toplevel_page_quicker',
		'quicker_page_quicker-settings',
		'quicker_page_quicker-license',
		'quicker_page_quicker-checkout-fields');

		return $admin_pages;
	}
	
	/** 
	 * Default Field
	*/
	public static function checkout_fields_defaults() {
		return array( 
			array('field_type'=>'billing','field_label'=>esc_html__('First Name','quicker') , 'field_name'=>'billing_first_name' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => ''),
			array('field_type'=>'billing','field_label'=>esc_html__('Last Name','quicker') , 'field_name'=>'billing_last_name' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' ),
			array('field_type'=>'billing','field_label'=>esc_html__('Company Name','quicker') , 'field_name'=>'billing_company' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' ),
			array('field_type'=>'billing','field_label'=>esc_html__('Country/Region','quicker') , 'field_name'=>'billing_country' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' ),
			array('field_type'=>'billing','field_label'=>esc_html__('Address 1','quicker') , 'field_name'=>'billing_address_1' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' ),
			array('field_type'=>'billing','field_label'=>esc_html__('Address 2','quicker') , 'field_name'=>'billing_address_2' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' ),
			array('field_type'=>'billing','field_label'=>esc_html__('City','quicker') , 'field_name'=>'billing_city' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' ),
			array('field_type'=>'billing','field_label'=>esc_html__('Country/State','quicker') , 'field_name'=>'billing_state' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' ),
			array('field_type'=>'billing','field_label'=>esc_html__('Postcode','quicker') , 'field_name'=>'billing_postcode' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' ),
			array('field_type'=>'billing','field_label'=>esc_html__('Phone','quicker') , 'field_name'=>'billing_phone' , 'field_placeholder' => '' , 'field_required' => 'Yes' , 'field_enabled' => 'Yes','field_position' => '' )
		);
	}

	/** 
	 * Default Field Key
	*/
	public static function checkout_fields_defaults_key() {
		return array( 'field_type' , 'field_label' , 'field_name' , 'field_placeholder' , 'field_required' , 'field_enabled', 'field_position' );
	}

	/**
	 * Settings option
	 * 
	 */
	public static function get_settings_key() {

		$settings_key = array(
		'enable_buy_now'=>'',
		'custom_price'=> '' , 'custom_price_label' => '',
		'quicker_view'=>'no',
		'mix_max_order'=>'',
		'quicker_view_btn'=>esc_html__('Quick View','quicker'),
		'min_order_amount'=>'',
		'max_order_amount'=>'',
		'enable_mini_cart'=>'yes',
		'up_sell_products'=>array(),
		'cross_sell_products'=>array(),
		'side_cart_style'=>'1',
		'cart_order_bump_style'=>'1',
		'price_field_type' => '' , 
		'extra_fees' => array(),
		'multi_step_checkout' => '',
		'cod_charge' => 'no',
		'show_coupon_form' => 'yes',
		'cod_charge_amount' => '',
		'cod_charge_label' => esc_html__('Delivery Charge','quicker'),
		'cod_min_cart' => '',
		'cod_min_cart_charge' => '',
		'one_click_button_text' => esc_html__('Buy Now','quicker')
	 );

		return $settings_key;
	}

	/**
	 * Admin pages array
	 */
	public static function get_settings() {
		$settings 				= array();
		$get_settings 			= get_option('quicker_settings', true );
		$settings_key 			= self::get_settings_key();

		foreach ($settings_key as $key => $value) {
			$settings[$key] = !empty($get_settings[$key]) ? $get_settings[$key] : $value;
		}
		
		return $settings;
	}

	/**
	 * Get all checkout fields
	 *
	 * @return array
	 */
	public static function get_checkout_fields( $limit = -1 ){
		$all_fields = get_posts(array('post_type'=>'quicker_ch_fields','posts_per_page'=> $limit));
		if (empty($all_fields)) {
			foreach(self::checkout_fields_defaults() as $key=>$value ){
				\Quicker\Core\Admin\Settings\Settings::instance()->insert_fields( $value );
			}

			$all_fields = get_posts(array('post_type'=>'quicker_ch_fields','posts_per_page'=> $limit));
		}

		return self::get_fields_arr( $all_fields );
	}

	/**
	 * Get all checkout fields 
	 *
	 * @return array
	 */
	public static function get_fields_arr( $all_fields ){
		$fields_arr = array();
		if (!empty($all_fields)) {
			foreach ($all_fields as $key => &$value) {
				$single = self::single_fields( $value );
				array_push($fields_arr,$single);
			}
		}

		return $fields_arr;
	}

	public static function single_fields($item) {
		$new_result = array();
		$new_result['ID'] = $item->ID;
		$new_result['input_type'] = get_post_meta($item->ID, 'input_type' ,true) == '' ? 'text' : get_post_meta($item->ID, 'input_type' ,true);
		$new_result['field_type'] = get_post_meta($item->ID, 'field_type' ,true) == '' ? 'billing' : get_post_meta($item->ID, 'field_type' ,true);
		$new_result['field_label'] = get_post_meta($item->ID, 'field_label' ,true);
		$new_result['field_name'] = get_post_meta($item->ID, 'field_name' ,true);
		$new_result['field_placeholder'] = get_post_meta($item->ID, 'field_placeholder' ,true);
		$new_result['field_required'] = get_post_meta($item->ID, 'field_required' ,true);
		$new_result['field_enabled'] = get_post_meta($item->ID, 'field_enabled' ,true);
		$new_result['field_position'] = get_post_meta($item->ID, 'field_position' ,true);

		return $new_result;
	}

	/**
	 * Get woo products
	 */
	public static function get_products($type = 'all') {
		$products = wc_get_products(array(
			'limit'  => -1, 
			'status' => 'publish',
		) );

		$products_arr = array();
		foreach ($products as $key => $value) {
			if ( $type == 'all' ) {
				$products_arr[$value->get_id()] = $value->get_name();
			} 
			else if( "simple" == $value->get_type() ){
				$products_arr[$value->get_id()] = $value->get_name();
			}
		}

		return $products_arr;
	}

	/**
	 * New checkout field
	 *
	 * @return array
	 */
	public static function checkout_field_type( $select = "single" ) {
		if ( $select == "single" ) {
			return array(
				'before_checkout_billing_form' => esc_html__('Before Billing Form','quicker'),
				'after_checkout_billing_form'=> esc_html__('After Billing Form','quicker'),
				'before_checkout_shipping_form'=> esc_html__('Before Shipping Form','quicker'),
				'after_checkout_shipping_form'=> esc_html__('After Shipping Form','quicker'),
				'before_order_notes'=> esc_html__('Before Order Notes','quicker'),
				'after_order_notes'=> esc_html__('After Order Notes','quicker'),
			);
		}
		else{
			return array(
				'before_checkout_billing_form' => array('type'=>'billing'),
				'after_checkout_billing_form'=> array('type'=>'billing'),
				'before_checkout_shipping_form'=> array('type'=>'shipping'),
				'after_checkout_shipping_form'=> array('type'=>'shipping'),
				'before_order_notes'=> array('type'=>'order'),
				'after_order_notes'=> array('type'=>'order'),
			);
		}
	}


	/**
	 * Format Value
	 */
	public static function format_input_value(  $input ) {
		if ( $input == "Yes" || $input == "yes") {
			return true;
		}
		else if ( $input == "No" || $input == "no") {
			return false ;
		}
	}

	/**
	 * check nonce
	 *
	 */
	public function verify_nonce($nonce_index,$nonce_value) {
		if ( is_null( $nonce_index ) || ! wp_verify_nonce( $nonce_value, $nonce_index ) ) {
			wp_send_json_error( array(
				'message'  	=> __( 'Security check failed', 'quicker' ),
				'code' 		=> 401
			) );
		}
	}

	public static function cart_btn($args){
		extract( $args );
		$icon 		= empty($args['cart_icon']) ? '<svg class="cart-icon" viewBox="0 0 256 256" xml:space="preserve">
		<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
			<path class="quicker-cart-icon" d="M 72.975 58.994 H 31.855 c -1.539 0 -2.897 -1.005 -3.347 -2.477 L 15.199 13.006 H 3.5 c -1.933 0 -3.5 -1.567 -3.5 -3.5 s 1.567 -3.5 3.5 -3.5 h 14.289 c 1.539 0 2.897 1.005 3.347 2.476 l 13.309 43.512 h 36.204 l 10.585 -25.191 h -6.021 c -1.933 0 -3.5 -1.567 -3.5 -3.5 s 1.567 -3.5 3.5 -3.5 H 86.5 c 1.172 0 2.267 0.587 2.915 1.563 s 0.766 2.212 0.312 3.293 L 76.201 56.85 C 75.655 58.149 74.384 58.994 72.975 58.994 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
			<circle class="quicker-cart-icon" cx="28.88" cy="74.33" r="6.16" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
			<circle class="quicker-cart-icon" cx="74.59" cy="74.33" r="6.16" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
			<path class="quicker-cart-icon" d="M 62.278 19.546 H 52.237 V 9.506 c 0 -1.933 -1.567 -3.5 -3.5 -3.5 s -3.5 1.567 -3.5 3.5 v 10.04 h -10.04 c -1.933 0 -3.5 1.567 -3.5 3.5 s 1.567 3.5 3.5 3.5 h 10.04 v 10.04 c 0 1.933 1.567 3.5 3.5 3.5 s 3.5 -1.567 3.5 -3.5 v -10.04 h 10.041 c 1.933 0 3.5 -1.567 3.5 -3.5 S 64.211 19.546 62.278 19.546 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
		</g></svg>' : $cart_icon;
		$btn_text   = empty($btn_txt) ? '' : $btn_txt;
		$cart_html 	= "";
	
		switch ( $product->get_type() ) {
		case ($product->get_type() == 'simple' ) && $product->is_in_stock() == true :
		$cart_html .= '<a href="'.$product->add_to_cart_url().'" value="'. intval( $product->get_id() ) .'"
			class="ajax_add_to_cart add_to_cart_button"
			data-product_id="'. intval( $product->get_id() ).'"
			data-product_sku="'.esc_attr($product->get_sku()).'"
			> 
			'. $icon . $btn_text .'</a>';
		break;
		case ($product->get_type() !== 'simple' )  && $product->is_in_stock() == true :
			$cart_html .= '<a href="'.$product->get_permalink().'" class="">'. $icon . $btn_text  .'</a>';
	
			break;
		
		default:
			$cart_html .= esc_html__('Out of Stock','quicker');
		}
		
		return $cart_html;
	}

	public static function is_pro_active() {
		if( !class_exists('QuickerPro') ){
			return false;
		}
		return true;
	}

	/**
	 * Templates
	 *
	 * @param integer $template
	 * @return array
	 */
	public static function get_templates( $template = 1 ) {
		$styles = array();
		for ($i=1; $i <= $template ; $i++) { 
			$styles[$i] = esc_html__('Template','quicker') .' -'.$i;
		}

		return $styles;
	}

	/**
	 * Add custom class
	 *
	 * @param [type] $data
	 * @return string
	 */
	public static function d_none_class( $data ) {
		return ( $data == 'yes' ) ?  '' : 'd-none';
	}

}
