<?php

use Quicker\Utils\Helper;

$repeater_field = array( 
    array(
        'label'=>esc_html__('Label:','quicker'),
        'label_class' => 'extra-fees-label',
        'field_type' => 'text',
        'id' => 'label',
        'value' => '',
    ),
    array(
        'label'=>esc_html__('Charge:','quicker'),
        'label_class' => 'extra-fees',
        'field_type' => 'number',
        'id' => 'fees',
        'value' => '',
    ),
);

// Repeater field for extra fees
$args = array(
    'label' =>esc_html__('Add Fees:','quicker'),
    'id'    => 'extra_fees',
    'name'  => 'repeat_fields[extra_fees]',
    'condition_class' => Helper::instance()->d_none_class( $custom_price ) .' custom_price',
    'repeat_field' => $repeater_field
);

quicker_repeater_field( 'extra_fees' , $args );