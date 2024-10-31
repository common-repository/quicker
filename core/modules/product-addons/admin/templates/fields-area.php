<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="quicker_pao_content" class="panel woocommerce_options_panel">
	<h2 class="content-header">
		<?php esc_html_e( 'Addon Fields', 'quicker' ); ?>
	</h2>
	<?php if( !class_exists('QuickerPro') ): ?>
		<span class="quicker-desc">
		<span><?php esc_html_e( 'Product Addons is Quicker Pro feature.', 'quicker' ); ?></span>
		<a href="<?php echo esc_url('https://woooplugin.com/quicker') ;?>" target="_blank">
			<?php ' ' .esc_html_e( 'Upgrade to Pro', 'quicker' ); ?></a>
		<span><?php ' ' .esc_html_e( 'to get the full feature', 'quicker' ); ?></span>
		</span>
	<?php endif; ?>

	<div class="quicker_pao_main_block">
		<?php
		$counter = 0;
		foreach ( $product_paos as $pao ) {
			include( dirname( __FILE__ ) . '/single-field.php' );
			$counter++;
		}

		// show default single field if no global addon is added yet
		if ( isset( $addon_section ) && empty( $product_paos ) ) {
			include( dirname( __FILE__ ) . '/single-field.php' );
			$counter = 1;
		}
		?>
	</div>

	<div class="quicker-pro-pao-actions">
		<button type="button" class="button button-primary quicker_pao_add_fields" data-next_pao_index="<?php echo esc_attr( $counter ); ?>"><?php esc_html_e( 'Add New Field', 'quicker' ); ?></button>
	</div>
</div>
