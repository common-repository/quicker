<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pao     = isset( $pao ) ? $pao : [];
$counter = isset( $counter ) ? $counter : 0;

$pao_type         = ! empty( $pao['type'] ) ? $pao['type'] : 'checkbox';
$pao_title        = ! empty( $pao['title'] ) ? $pao['title'] : '';
$pao_title_format = ! empty( $pao['title_format'] ) ? $pao['title_format'] : 'label';
$pao_place_holder = ! empty( $pao['place_holder'] ) ? $pao['place_holder'] : '';
$pao_desc_enable  = ! empty( $pao['desc_enable'] ) ? $pao['desc_enable'] : '';
$pao_desc         = ! empty( $pao['desc'] ) ? $pao['desc'] : '';
$pao_char_limit_enable = ! empty( $pao['char_limit'] ) ? $pao['char_limit'] : '';
$pao_char_min     = ! empty( $pao['char_min'] ) ? $pao['char_min'] : 0;
$pao_char_max     = ! empty( $pao['char_max'] ) ? $pao['char_max'] : 0;
$pao_required     = ! empty( $pao['required'] ) ? $pao['required'] : '';

if ( !isset( $pao['options'] ) ) {
	$pao['options']      = array(
			array(
					'label'      => '',
					'price_type' => 'flat_fee',
					'price'      => '',
			)
		);
}
?>

<div class="quicker-pao-fields">
	<div class="quicker-pao-header mb-1">
		<div class="quicker-pao-header-section1">
			<span class="quicker-pao-sort-handle dashicons dashicons-menu"></span>
			<h3 class="quicker-pao-name"><?php echo esc_html( $pao_title ); ?></h3>
		</div>
		<div class="quicker-pao-header-section2">
			<button type="button" class="quicker-pao-remove button"> <i class="dashicons dashicons-no-alt"></i></button>
			<input type="hidden" name="quicker_pao_position[<?php echo esc_attr( $counter ); ?>]" class="quicker_pao_position" value="<?php echo esc_attr( $counter ); ?>" />
		</div>
	</div>

	<div class="quicker_pao_wrap quicker_pao_wrap_0 <?php echo ( isset( $addon_section ) && empty( $product_paos ) ) ? '' : 'hide_block'; ?>">
			<div class="quicker-item">
				<div class="input-label">
					<label for="quicker_pao_type_<?php echo esc_attr( $counter ); ?>"><?php esc_html_e( 'Type', "wpcafe-pro" ); ?></label>
					<div class="wpc-desc"><?php esc_html_e( 'Set product addons input type', "wpcafe-pro" ); ?></div>
				</div>
				<div class="input-meta">
						<?php
								$pao_types = [
										'checkbox' => esc_html__( 'Checkbox', 'wpcafe-pro' ),
										'radio'    => esc_html__( 'Radio', 'wpcafe-pro' ),
										'dropdown' => esc_html__( 'Dropdown', 'wpcafe-pro' ), 
										'text'     => esc_html__( 'Long Text', 'wpcafe-pro' ), 
								];
						?>
						<select id="quicker_pao_type_<?php echo esc_attr( $counter ); ?>" class="quicker-input quicker_pao_type quicker_pao_type_<?php echo esc_attr( $counter ); ?>" name="quicker_pao_type[<?php echo esc_attr( $counter ); ?>]">
								<?php
								foreach ( $pao_types as $key => $value ) {
								?>
										<option <?php selected( $key, $pao_type ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
								<?php
								}
								?>
						</select>
				</div>
			</div>

			<div class="quicker-item">
					<div class="input-label">
						<label for="quicker_pao_title_<?php echo esc_attr( $counter ); ?>"><?php esc_html_e( 'Title', 'wpcafe-pro'  ); ?></label>
						<div class="wpc-desc"><?php esc_html_e( 'Add product addons title text', "wpcafe-pro" ); ?></div>
					</div>
					<div class="input-meta">
						<input type="text" value="<?php echo esc_attr( $pao_title ) ?>" class="quicker-input quicker_pao_title quicker_pao_title_<?php echo esc_attr( $counter ); ?>" id="quicker_pao_title_<?php echo esc_attr( $counter ); ?>"
						name="quicker_pao_title[<?php echo esc_attr( $counter ); ?>]" placeholder="<?php echo esc_html__( "Title", "wpcafe-pro" ); ?>" />
					</div>
			</div>

			<div class="quicker-item">
					<div class="input-label">
						<label for="quicker_pao_title_format_<?php echo esc_attr( $counter ); ?>"><?php esc_html_e( 'Title Format', "wpcafe-pro" ); ?></label>
						<div class="wpc-desc"><?php esc_html_e( 'Define title text format', "wpcafe-pro" ); ?></div>
					</div>
					<div class="input-meta">
							<?php
								$pao_title_formats = [ 
									'label'   => esc_html__( 'Label','wpcafe-pro' ), 
									'heading' => esc_html__( 'Heading', 'wpcafe-pro' ),
									'hide'    => esc_html__( 'Hide', 'wpcafe-pro' ),
								];
							?>
							<select id="quicker_pao_title_format_<?php echo esc_attr( $counter ); ?>" class="quicker-input quicker_pao_title_format quicker_pao_title_format_<?php echo esc_attr( $counter ); ?>" name="quicker_pao_title_format[<?php echo esc_attr( $counter ); ?>]">
								<?php
								foreach ( $pao_title_formats as $key => $value ) {
								?>
										<option <?php selected( $key, $pao_title_format ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
								<?php
								}
								?>
							</select>
					</div>
			</div>

			<div class="quicker-item wpc-addons-place-holder" style="display: <?php echo ( $pao_type == 'text' ) ? 'block' : 'none'; ?>;">
					<div class="input-label">
						<label for="quicker_pao_place_holder_<?php echo esc_attr( $counter ); ?>"><?php esc_html_e( 'Placeholder text', 'wpcafe-pro'  ); ?></label>
						<div class="wpc-desc"><?php esc_html_e( 'Display reservation form only in the selected page', "wpcafe-pro" ); ?></div>
					</div>
					<div class="input-meta">
						<input type="text" value="<?php echo esc_attr( $pao_place_holder ) ?>" class="quicker-input quicker_pao_place_holder quicker_pao_place_holder_<?php echo esc_attr( $counter ); ?>" id="quicker_pao_place_holder_<?php echo esc_attr( $counter ); ?>"
						name="quicker_pao_place_holder[<?php echo esc_attr( $counter ); ?>]" placeholder="" />
					</div>
			</div>

			<div class="quicker-item">
					<div class="input-label">
						<label for="quicker_pao_required_<?php echo esc_attr( $counter ); ?>"> <?php esc_html_e( 'Required', 'wpcafe-pro' ); ?></label>
						<div class="wpc-desc"><?php esc_html_e( 'Is this product addons required?', "wpcafe-pro" ); ?></div>
					</div>
					<div class="input-meta">
						<input type="checkbox" class="quicker_pao_required wpcafe-admin-control-input quicker_pao_required_<?php echo esc_attr( $counter ); ?>" id="quicker_pao_required_<?php echo esc_attr( $counter ); ?>"
							name="quicker_pao_required[<?php echo esc_attr( $counter ); ?>]" <?php checked( $pao_required, 1, true ); ?> />
						<label for="quicker_pao_required_<?php echo esc_attr( $counter ); ?>" class="wpcafe_switch_button_label"></label>
					</div>
			</div>

			<div class="quicker-item quicker_pao_desc_enable-wrapper">
					<div class="input-label">
							<label for="quicker_pao_desc_enable_<?php echo esc_attr( $counter ); ?>"> <?php esc_html_e( 'Description', 'wpcafe-pro' ); ?></label>
							<div class="wpc-desc"><?php esc_html_e( 'Add product addons description', "wpcafe-pro" ); ?></div>
					</div>
					<div class="input-meta">
							<input type="checkbox" class="wpcafe-admin-control-input quicker_pao_desc_enable quicker_pao_desc_enable_<?php echo esc_attr( $counter ); ?>" id="quicker_pao_desc_enable_<?php echo esc_attr( $counter ); ?>"
									name="quicker_pao_desc_enable[<?php echo esc_attr( $counter ); ?>]" <?php checked( $pao_desc_enable, 1, true ); ?> />
							<label for="quicker_pao_desc_enable_<?php echo esc_attr( $counter ); ?>" class="wpcafe_switch_button_label"></label>

							<?php 
									$show_hide_desc_box = ! empty( $pao_desc_enable ) ? 'display: block;' : 'display: none;';
							?>

							<div class="wpc-add-desc">
									<textarea cols="20" rows="3" id="quicker_pao_desc_<?php echo esc_attr( $counter ); ?>" style="<?php echo esc_attr( $show_hide_desc_box ); ?>"
											class="quicker_pao_desc quicker-input wpc-msg-box quicker_pao_desc_<?php echo esc_attr( $counter ); ?>" 
											name="quicker_pao_desc[<?php echo esc_attr( $counter ); ?>]"><?php echo esc_textarea( $pao_desc ); ?></textarea>
							</div>
					</div>
			</div>

			<div class="quicker-item wpc-addon-char-limit-main" style="display: <?php echo ( $pao_type == 'text' ) ? 'block' : 'none'; ?>;">
					<div class="input-label">
							<label for="quicker_pao_char_limit_enable_<?php echo esc_attr( $counter ); ?>"> <?php esc_html_e( 'Character limitation', 'wpcafe-pro' ); ?></label>
					</div>
					<div class="input-meta">
							<input type="checkbox" class="wpcafe-admin-control-input quicker_pao_char_limit_enable quicker_pao_char_limit_enable_<?php echo esc_attr( $counter ); ?>" id="quicker_pao_char_limit_enable_<?php echo esc_attr( $counter ); ?>"
									name="quicker_pao_char_limit_enable[<?php echo esc_attr( $counter ); ?>]" <?php checked( $pao_char_limit_enable, 1, true ); ?> />
							<label for="quicker_pao_char_limit_enable_<?php echo esc_attr( $counter ); ?>" class="wpcafe_switch_button_label"></label>

							<div class="wpc-addon-char-limit-wrap mt-25">
									<div class="addon-char-length"> 
											<b for="quicker_pao_char_min_<?php echo esc_attr( $counter ); ?>"><?php esc_html_e( 'Min length', 'wpcafe-pro'  ); ?></b>
											<input type="number" min="0" pattern="\d+" value="<?php echo esc_attr( $pao_char_min) ?>" class="quicker-input quicker_pao_char_min quicker_pao_char_min_<?php echo esc_attr( $counter ); ?>" id="quicker_pao_char_min_<?php echo esc_attr( $counter ); ?>"
																	name="quicker_pao_char_min[<?php echo esc_attr( $counter ); ?>]" placeholder="<?php echo esc_html__( "Minimum length", "wpcafe-pro" ); ?>" />
									</div>
									<div class="addon-char-length"> 
											<b for="quicker_pao_char_max_<?php echo esc_attr( $counter ); ?>"><?php esc_html_e( 'Max length', 'wpcafe-pro'  ); ?></b>
											<input type="number" min="0" pattern="\d+" value="<?php echo esc_attr( $pao_char_max) ?>" class="quicker-input quicker_pao_char_max quicker_pao_char_max_<?php echo esc_attr( $counter ); ?>" id="quicker_pao_char_max_<?php echo esc_attr( $counter ); ?>"
																	name="quicker_pao_char_max[<?php echo esc_attr( $counter ); ?>]" placeholder="<?php echo esc_html__( "Maximum length", "wpcafe-pro" ); ?>" />
									</div>
							</div>
					</div>
			</div>

			<div class="quicker-pao-option-main-wrapper">
					<div class="quicker-pao-option-header quicker-pao-option-wrapper">
							<div></div>
							<div class="quicker-pao-option-title  quicker-pao-option-item <?php echo ( $pao_type != 'text' ) ? 'show_block' : 'hide_block'; ?>">
								<?php esc_html_e( 'Options', 'wpcafe-pro' ); ?>
							</div>
							<div class="quicker-pao-option-price-type quicker-pao-option-item">
								<?php esc_html_e( 'Type', 'wpcafe-pro' ); ?>
							</div>
							<div class="quicker-pao-option-price-label quicker-pao-option-item">
								<?php esc_html_e( 'Price', 'wpcafe-pro' ); ?>
							</div>
							<div></div>
					</div>

					<div class="quicker-pao-option-wrap">
							<?php
							if ( ! empty( $pao['options'] ) ) {
									foreach ( $pao['options'] as $option_index => $option ) {
											$option_label      = ! empty( $option['label'] ) ? $option['label'] : '';
											$option_price_type = ! empty( $option['price_type'] ) ? $option['price_type'] : 'flat_fee';
											$option_price      = ! empty( $option['price'] ) ? $option['price'] : '';

											include( dirname( __FILE__ ) . '/price-option.php' );
									}
							}
							?>
					</div>

					<div class="quicker-pao-option-footer <?php echo ( $pao_type != 'text' ) ? 'show_block' : 'hide_block'; ?>">
							<button type="button" class="quicker_pao_add_option button" data-current_counter_index="<?php echo esc_attr( $counter ); ?>" data-next_option_index="<?php echo esc_attr( $option_index+1 ); ?>"><?php esc_html_e( 'Add Option', 'wpcafe-pro' ); ?></button>
					</div>
			</div>
	</div>
</div>
