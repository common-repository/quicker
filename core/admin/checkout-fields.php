<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">
	<div class="all-checkout-fields">
	<?php
		if ( file_exists(\Quicker::base_dir()."input-fields.php")) {
			include_once \Quicker::base_dir()."input-fields.php"; 
		}

		/**
		 * Shows Rules
		 */

		$columns = array(
			'cb'        => '<input name="bulk-delete[]" type="checkbox" />',
			'field_label'=> esc_html__( 'Label', 'quicker' ),
			'field_name'  => esc_html__( 'Name', 'quicker' ),
			'field_placeholder'   => esc_html__( 'Placeholder', 'quicker' ),
			'field_required'   => esc_html__( 'Required', 'quicker' ),
			'field_enabled'   => esc_html__( 'Enabled', 'quicker' ),
			'actions'     	 => esc_html__( 'Actions', 'quicker' ),
		);

		$field_list = array(
			'singular_name' => esc_html__( 'All Checkout Field', 'quicker' ),
			'plural_name'   => esc_html__( 'All Discount Rules', 'quicker' ),
			'columns'       => $columns,
		);

		?>
		<div class="checkout-field-list">
			<?php
				$disabled = Quicker\Utils\Helper::instance()->is_pro_active() ? '' :'disabled';
				$pro_txt = Quicker\Utils\Helper::instance()->is_pro_active() ? '' : esc_html__('(Pro)','quicker');
			?>
			<div class="mt-2 content-header">
				<div class="title mr-1"><?php esc_html_e( 'Checkout Fields', 'quicker' );?></div>
				<button class="button add_checkout_field"
				<?php echo esc_attr( $disabled );?>
				>
					<?php esc_html_e('Add New Checkout Field','quicker').' '?>
					<?php echo esc_html( $pro_txt );?>
				</button>
			</div>
			<form method="POST">
				<?php
					$table = new \Quicker\Core\Admin\Table( $field_list );
					$table->preparing_items();
					$table->display();
				?>
			</form>
			<div id="checkout-field-modal" class="popup-modal">
				<div class="modal-content">
					<div class="checkout-form-update">
						<div class="modal-header">
							<div class="content-header">
								<div class="title"><?php esc_html_e("Add New Checkout Field","quicker"); ?></div>
							</div>
							<span class="modal-close">&times;</span>
						</div>
						<?php 
							$args = array(
								'label'=>'',
								'field_type' => 'hidden',
								'id' => 'action_type',
								'value' => '' ,
							);
							quicker_number_input_field($args);

							$args = array('label'=>esc_html__("Field Position:","quicker"),'id' => 'field_position',
							'options'=> Quicker\Utils\Helper::checkout_field_type() ,
							'selected' =>'before_checkout_billing_form');
							quicker_select_field($args);

							$args = array('label'=>esc_html__("Input Type:","quicker"),'id' => 'input_type',
							'options'=> array(
								'text'=>esc_html__('Text','quicker'),
								'number'=>esc_html__('Number','quicker'),
								'hidden'=>esc_html__('Hidden','quicker')
							), 'selected' =>'text' );
							
							quicker_select_field($args);

							$args = array(
								'label'=>'',
								'field_type' => 'hidden',
								'id' => 'ID',
								'value' => '' ,
							);
							quicker_number_input_field($args);
							
							$args = array(
								'label'=>'',
								'field_type' => 'hidden',
								'id' => 'field_type',
								'value' => '' ,
							);
							quicker_number_input_field($args);

							$args = array(
								'label'=>esc_html__("Label:","quicker"),
								'field_type' => 'text',
								'id' => 'field_label',
								'value' => 'Phone' ,
							);
							quicker_number_input_field($args);

							$args = array(
								'label'=>esc_html__("Name:","quicker"),
								'field_type' => 'text',
								'id' => 'field_name',
								'disable' => $disabled,
								'value' => '' ,
							);
							quicker_number_input_field($args);
						

							$args = array(
								'label'=>esc_html__("Placeholder:","quicker"),
								'field_type' => 'text',
								'id' => 'field_placeholder',
								'value' => '' ,
							);
							quicker_number_input_field($args);

							$args = array('label'=>esc_html__("Required:","quicker"),
							'id' => 'field_required',
							'checked' => 'yes' );
							quicker_checkbox_field($args);

							$args = array('label'=>esc_html__("Enabled:","quicker"),
							'id' => 'field_enabled',
							'checked' => 'yes' );
							quicker_checkbox_field($args);
						?>
						<button class="button button-primary update_checkout_field mt-3 <?php echo esc_attr(Quicker\Utils\Helper::instance()->is_pro_active());?>"><?php esc_html_e("Save Changes","quicker"); ?></button>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>