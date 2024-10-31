<?php

use Quicker\Utils\Helper;

defined( 'ABSPATH' ) || exit;

if ( !function_exists('pro_tag_markup') ) {
	function pro_tag_markup($disable,$class="") {
		$pro_only     = ! empty( $disable ) ? 'pro-fr' : '';
		$pro          = '';
		if ( $pro_only !== '' ) {
			$pro .= '<span class="' . esc_attr( $pro_only . ' ' . $class ) . '">' . esc_html__( 'Upgrade to Pro', 'create-members' ) . '</span>';

		}

		return $pro;
	}
}

if ( !function_exists('pro_link_markup') ) {
	function pro_link_markup($disable,$class="") {
		$pro_link_start = '';
		$pro_link_end   = '';
		if ( ! empty( $disable ) ) {
			$pro_link_start = '<a class="pro-link" target="_blank" href="' . esc_url( 'https://woooplugin.com/ultimate-membership/' ) . '">';
			$pro_link_end   = '</a>';
		}

		return array(
			'pro_link_start' => $pro_link_start,
			'pro_link_end' => $pro_link_end,
		);
	}
}

if ( !function_exists('quicker_checkbox_field') ) {

	function quicker_checkbox_field( $args ) {

		$condition_class = ! empty( $args['condition_class'] ) ? $args['condition_class'] : '';
		$disable         = ( ! empty( $args['disable'] ) && $args['disable'] == true ) ? 'disable' : '';
		$data_label      = ! empty( $args['data_label'] ) ? $args['data_label'] : '';
		$checkbox_label  = ! empty( $args['checkbox_label'] ) ? $args['checkbox_label'] : '';
		$checked         = ( ! empty( $args['checked'] ) && $args['checked'] == 'yes' ) ? 'checked' : '';
		extract( pro_link_markup( $disable ) );

		$html = '
			<div class="single-block ' . $condition_class . '">
				<div class="form-label">' . $args['label'] . '</div>
				' . $pro_link_start . '
				<div class="check-wrap">
					<label class="input-section custom-switcher ' . $disable . '">
					<input type="checkbox" class="switcher-ui-toggle" id="' . $args['id'] . '"
						name="' . $args['id'] . '" value="yes"  ' . esc_attr($checked) . '
						data-label="' . esc_attr($data_label) . '"
						/>
						<span class="slider round"></span>
					</label>
					<span class="ml-1">' . $checkbox_label . '</span>
				</div>
				' . pro_tag_markup( $disable ) . '
				' . $pro_link_end . '
			</div>
		';

		echo Helper::kses( $html );
	}
}

/**
 * Select option
 */
if ( !function_exists('quicker_select_field') ) {
	function quicker_select_field( $args ){
		$id           = !empty($args['id']) ? $args['id'] : '';
		$label        = !empty($args['label']) ? $args['label'] : '';
		$data_label   = !empty($args['data_label']) ? $args['data_label'] : '';
		$options_html = "";
		$disable      = !empty($args['disable']) && $args['disable'] == true ? 'disable' : '';
		$doc          = !empty($args['doc']) ? $args['doc'] : '';
		$select_type  = !empty($args['select_type']) ? $args['select_type'] : 'single';

		if ( "single" == $select_type ) {
			$selected  	  = !empty($args['selected']) ? $args['selected'] : '';
			if ( !empty( $args['options'] ) ) :
				foreach($args['options'] as $key => $item): 
					$selected_val   = $key == $selected ? 'selected' : '';
					$disabled       = $key == $disable ? 'disabled' : '';
					$options_html  .= '<option '.esc_attr($disabled).' value="'.esc_attr($key).'" '.esc_attr($selected_val).'>'.$item.'</option>';
				endforeach; 
				$selected_val   = 'data-selected='. esc_js($selected) .'';
			endif;
		}
		else{
			$selected  	  	= !empty($args['selected']) ? $args['selected'] : [];
			$selected_val   = 'data-selected='.wp_json_encode($selected).'';
			if ( !empty( $args['options'] ) ) :
				foreach($args['options'] as $key=>$item):
					$options_html .= '<option value="'.esc_attr($key).'" >'. esc_html($item) .'</option>';
				endforeach; 
			endif;
		}


		$condition_class = !empty($args['condition_class']) ? $args['condition_class'] : "";
		echo '
			<div class="single-block '.esc_attr($condition_class).'">
				<div class="form-label">'.esc_html($label).'</div>
				<div class="input-section">
					<select name="'.esc_attr($id).'" id="'.esc_attr($id).'" '. esc_attr($selected_val) .' data-option="'.esc_js($data_label).'" ' .'>'.
					\Quicker\Utils\Helper::instance()->kses( $options_html ).'</select>
					'.\Quicker\Utils\Helper::instance()->kses(pro_tag_markup($disable,'select-pro-tag')).'
				</div>
				'. \Quicker\Utils\Helper::instance()->kses( $doc )  .'
			</div>
		';
	}
}

/**
 * Number/Text/Hidden
 */
if ( !function_exists('quicker_number_input_field') ) {
	function quicker_number_input_field( $args ) {
		$id           = ! empty( $args['id'] ) ? $args['id'] : '';
		$wrapper_type = ! empty( $args['wrapper_type'] ) ? $args['wrapper_type'] : '';
		$wrapper_class = ! empty( $args['wrapper_class'] ) ? $args['wrapper_class'] : 'single-block';
		$label_class = ! empty( $args['label_class'] ) ? $args['label_class'] : 'form-label';
		$value        = ! empty( $args['value'] ) ? $args['value'] : '';
		$label        = ! empty( $args['label'] ) ? $args['label'] : '';
		$field_type   = ! empty( $args['field_type'] ) ? $args['field_type'] : 'text';
		$condition_class    = ! empty( $args['condition_class'] ) ? $args['condition_class'] : '';
		$disable            = ( ! empty( $args['disable'] ) && $args['disable'] == true  ) ? 'disable' : '';
		$extra_label        = ! empty( $args['extra_label'] ) ? $args['extra_label'] : '';
		$placeholder        = ! empty( $args['placeholder'] ) ? $args['placeholder'] : '';
		$data_label         = ! empty( $args['data_label'] ) ? $args['data_label'] : '';
		$extra_label_class  = ! empty( $args['extra_label_class'] ) ? $args['extra_label_class'] : '';
		$hidden_class       = $field_type == 'hidden' ? 'd-none' : '';
		extract( pro_link_markup( $disable ) );

		$html = '
		<div class="' . esc_attr($wrapper_class) . ' ' . esc_attr($condition_class) . ' ' . esc_attr($hidden_class) . '">
			<div class="' . $label_class . '">' . $label . '</div>
			' . $pro_link_start . '
			<div class="input-section">
				<div class="input-wrap ' . esc_attr($disable) . '">
					<input type="' . esc_attr($field_type) . '" name="' . esc_attr($id) . '" id="' . esc_attr($wrapper_type.$id) . '" value="' . $value . '"  
						data-option="' . esc_attr($data_label) . '" 
						placeholder="' . esc_attr($placeholder) . '"
					/>
					<div class="extra-label ' . $extra_label_class . '">' . $extra_label . '</div>
				</div>
			</div>
			' . pro_tag_markup( $disable ) . '
			' . $pro_link_end . '
		</div>
		';

		echo Helper::kses( $html );
	}
}

/**
 * Repeater field
 *
 * @param [type] $args
 * @return void
 */
if ( !function_exists('quicker_repeater_field') ) {
	function quicker_repeater_field( $type , $args ) {
		$id           = !empty($args['id']) ? $args['id'] : '';
		$name         = !empty($args['name']) ? $args['name'] : '';
		$label        = !empty($args['label']) ? $args['label'] : '';
		$repeat_field = !empty($args['repeat_field']) ? $args['repeat_field'] : array();
		$condition_class   	= !empty($args['condition_class']) ? $args['condition_class'] : '';
		$repeat_html  = "";
		
		foreach ($repeat_field as $key => $value) {
			$name_part    = $name."[".$key."]";
			$label_class  = !empty($value['label_class']) ? $value['label_class'] : '';
			$repeat_condition_class   	= !empty($value['condition_class']) ? $value['condition_class'] : '';
			$repeat_html .= '
			<div class="repeat-block '.$repeat_condition_class.'">
				<div class="repeat-label '.$label_class.'">'.$value['label'].'</div>
				<div class="repeat-input">'.quicker_repeat_input_field( $name_part , $value , $key ).'</div>
			</div>
			';
		}
		
		
		$html = '
		<div class="single-block '.$condition_class.'" id="'.$id.'">
			<div class="form-label">'.$label.'</div>
			<div id="repeater-'.$type.'" class="repeat-wrapper">
				<div class="createElement" id="createElement-'.$type.'"><span class="dashicons dashicons-plus"></span></div>
				<div class="repeat-section" id="structure-'.$type.'">
					'.$repeat_html.'
				</div>
				<div id="containerElement-'.$type.'"></div>
			</div>
		</div>
		';
		echo \Quicker\Utils\Helper::kses($html);
	}
}

if ( !function_exists('quicker_repeat_input_field') ) {
	function quicker_repeat_input_field( $name_part , $value , $index ) {
		$html = "";
		$name = $name_part."[".$value['id']."]";
		$condition_class = !empty( $value['condition_class'] ) ? $value['condition_class'] : '';

		switch ($value['field_type']) {
			case 'hidden':
			case 'number':
			case 'text':
				$extra_label_class = !empty( $value['extra_label_class'] ) ? $value['extra_label_class'] : '';
				$extra_label = !empty( $value['extra_label'] ) ? $value['extra_label'] : '';

				$html = '<input data-name="'.esc_js($value['id']).'" class="'.esc_attr($value['id'].'-'.$index).'" type="'.esc_attr($value['field_type']).'" name="'.esc_attr($name).'" />
				<span class="extra-label '.esc_attr($extra_label_class).'">'.esc_html($extra_label).'</span>';
				
				break;
			case 'select':
				$options_html = "";
				foreach ($value['options'] as $key => $item) {
					$options_html .= "<option value='".esc_attr($key)."'>".esc_html($item)."</option>";
				}
				$html = '<select data-name="'.esc_js($value['id']).'" class=" '.esc_attr($value['id']).'" name="'.esc_attr($name).'" data-id="'.esc_js($index).'">'.esc_html($options_html).'</select>';
				break;		
			default:
				break;
		}

		return $html;
	}
}