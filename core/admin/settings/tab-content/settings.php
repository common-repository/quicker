<?php

	defined( 'ABSPATH' ) || exit;

	use Quicker\Utils\Helper;

	$args = array(
		'label'=>esc_html__("Enable One-Click Checkout","quicker"),
		'id' => 'enable_buy_now',
		'checked' => $enable_buy_now
	);
	quicker_checkbox_field($args);

	$button_text = $one_click_button_text == '' ? esc_html__('Buy Now','quicker') : $one_click_button_text;
	$args = array('label'=>esc_html__("One Click Button Text","quicker"),
	'condition_class' => Helper::instance()->d_none_class( $enable_buy_now ).' enable_buy_now',
	'id' => 'one_click_button_text',
	'value' => $button_text );
	quicker_number_input_field($args);

	$args = array(
		'label'=>esc_html__('Enable Quick View on Shop Page','quicker'),
		'id' => 'quicker_view',
		'disable' => $disable , 
		'checked' => $quicker_view
	);
	quicker_checkbox_field($args);

	$block_quicker_view = $quicker_view == 'yes' ? '' : 'd-none';
	$args = array(
		'label'=>esc_html__('Quick View Button Text/Icon','quicker'),
		'extra_label'=>esc_html__('For Instance: <span><i class=\'fa fa-eye\'></i>Quick View</span>','quicker'),
		'id' => 'quicker_view_btn',
		'condition_class' => 'quicker_view '. $block_quicker_view,
		'field_type' => 'text',
		'disable' => $disable , 
		'value' => $quicker_view_btn
	);
	quicker_number_input_field($args);

	$args = array(
		'label'=>esc_html__("Enable Min/Max Order Amount","quicker"),
		'id' => 'mix_max_order',
		'checked' => $mix_max_order
	);
	quicker_checkbox_field($args);

	$block_min_max_order = $mix_max_order == 'yes' ? '' : 'd-none';
	$args = array(
		'label'=>esc_html__("Minimum Order Amount","quicker"),
		'condition_class' => 'mix_max_order '. $block_min_max_order,
		'id' => 'min_order_amount',
		'field_type' => 'number',
		'disable' => $disable , 
		'value' => $min_order_amount
 	);
	quicker_number_input_field($args);

	$args = array('label'=>esc_html__("Maximum Order Amount","quicker"),
	'condition_class' => 'mix_max_order '. $block_min_max_order,
	'id' => 'max_order_amount',
	'field_type' => 'number',
	'disable' => $disable , 
	'value' => $max_order_amount );

	quicker_number_input_field($args);


