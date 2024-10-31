<?php

	defined( 'ABSPATH' ) || exit;

	$args = array('label'=>esc_html__("Enable Custom Price in Checkout","quicker"),
	'id' => 'custom_price',
	'checked' => $custom_price , 'disable' => $disable  );
	quicker_checkbox_field($args);

	$d_none_custom_price = ( $custom_price == 'no' ) ? 'd-none' : '';
	$d_none_cod_charge = ( $cod_charge == 'no' ) ? 'd-none' : '';

	$args = array('label'=>esc_html__("Custom Price Label in Checkout","quicker"),
	'condition_class' => $d_none_custom_price.' custom_price',
	'id' => 'custom_price_label',
	'value' => $custom_price_label , 'disable' => $disable  );
	quicker_number_input_field($args);


	$args = array('label'=>esc_html__("Price Field Type","quicker"),'id' => 'price_field_type',
	'condition_class' => $d_none_custom_price.' custom_price',
	'options'=>array( 'select'=>esc_html__("Select","quicker"),'radio'=>esc_html__("Radio","quicker") ) ,
	'selected' => $price_field_type, 'disable' => $disable  );
	
	quicker_select_field($args);

	if (file_exists(\Quicker::core_dir()."admin/settings/tab-content/add-fees.php")) {
		include \Quicker::core_dir()."admin/settings/tab-content/add-fees.php";
	}

	$args = array('label'=>esc_html__("Add Cash On Delivery Charge","quicker"),
	'condition_class' => 'cod_charge',
	'id' => 'cod_charge',
	'checked' => $cod_charge , 'disable' => $disable  );
	quicker_checkbox_field($args);

	?>
	<div class="cod_charge <?php echo esc_attr($d_none_cod_charge);?>">
			<?php
				$args = array('label'=>esc_html__("Label","quicker"),
				'id' => 'cod_charge_label',
				'value' => $cod_charge_label , 'disable' => $disable  );
				quicker_number_input_field($args);

				$args = array('label'=>esc_html__("Charge","quicker"),
				'id' => 'cod_charge_amount',
				'field_type' => 'number',
				'value' => $cod_charge_amount , 'disable' => $disable  );
				quicker_number_input_field($args);
			?>
		<div class="form-label mt_2"><?php esc_html_e("Add Delivery Charge Rules","quicker"); ?></div>	
			<?php
				$args = array('label'=>esc_html__("Minimum Cart Total","quicker"),
				'id' => 'cod_min_cart',
				'field_type' => 'number',
				'value' => $cod_min_cart , 'disable' => $disable  );
				quicker_number_input_field($args);

				$args = array('label'=>esc_html__("Charge","quicker"),
				'id' => 'cod_min_cart_charge',
				'field_type' => 'number',
				'value' => $cod_min_cart_charge , 'disable' => $disable  );
				quicker_number_input_field($args);
			?>
	</div>
