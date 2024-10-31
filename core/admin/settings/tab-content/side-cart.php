<?php

use Quicker\Utils\Helper;

defined( 'ABSPATH' ) || exit;

$args = array('label'=>esc_html__("Enable Side Cart/Mini-Cart","quicker"),
'id' => 'enable_mini_cart','checked' => $enable_mini_cart,
'disable' => $disable  );
quicker_checkbox_field($args);

$args = array('label'=>esc_html__("Display Coupon Form in Mini-Cart","quicker"),
'condition_class'=> Helper::instance()->d_none_class( $enable_mini_cart ).' enable_mini_cart',
'id' => 'show_coupon_form','checked' => $show_coupon_form,
'disable' => $disable  );
quicker_checkbox_field($args);

$args = array('label'=>esc_html__("Side Cart Template","quicker"),
'condition_class'=> Helper::instance()->d_none_class( $enable_mini_cart ).' enable_mini_cart',
'id' => 'side_cart_style','selected' => $side_cart_style,
'options' => Helper::get_templates(),
'disable' => $disable  );
quicker_select_field($args);

$args = array('label'=>esc_html__("Side Order Bump Template","quicker"),
'condition_class'=> Helper::instance()->d_none_class( $enable_mini_cart ).' enable_mini_cart',
'id' => 'cart_order_bump_style','selected' => $cart_order_bump_style,
'options' => Helper::get_templates(2),
'disable' => $disable  );
quicker_select_field($args);

$args = array('label'=>esc_html__("Up-Sells Products","quicker"),'id' => 'up_sell_products',
'condition_class' => Helper::instance()->d_none_class( $enable_mini_cart ).' select2-multiple enable_mini_cart',
'selected' => $up_sell_products,
'options'=> Helper::get_products() , 'select_type'=> 'multiple' , 'disable' => $disable  );
quicker_select_field($args);

$args = array('label'=>esc_html__("Cross Products","quicker"),'id' => 'cross_sell_products',
'condition_class' =>Helper::instance()->d_none_class( $enable_mini_cart ).' select2-multiple enable_mini_cart',
'selected' => $cross_sell_products,
'options'=> Helper::get_products() , 'select_type'=> 'multiple' , 'disable' => $disable  );
quicker_select_field($args);