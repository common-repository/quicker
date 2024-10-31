<?php 

	defined( 'ABSPATH' ) || exit;

	include_once \Quicker::base_dir().'input-fields.php'; 

	$disable 		= class_exists('QuickerPro') ? false : true;
	$settings 		= Quicker\Utils\Helper::get_settings();

	extract($settings);

	$tabs = array(
		'settings' 			=> esc_html__( 'General Settings', 'quicker' ),
		'checkout-fees' 	=> esc_html__( 'Checkout Fees', 'quicker' ),
		'side-cart' 		=> esc_html__( 'Cart', 'quicker' )
	);
	$tab_content = array('settings','checkout-fees','side-cart');
?>
<div class="wrap">
	<form id="quicker_settings">
		<div class="content-header">
			<div class="title-wrap">
				<?php esc_html_e('Settings','quicker');?>
			</div>
		</div>
		<div class="settings_message d-none"></div>
		<div class="content-wrapper">
		<div class="settings_tab">
			<ul class="settings_tab_pan">
				<?php foreach ($tabs as $key => $value) { ?>
					<li data-item="<?php echo esc_js( $key );?>"><?php echo esc_html($value) ?></li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<?php foreach ($tab_content as $key => $value) { 
					$active = $value == "settings" ? "active" : "";
				?>
				<div id="<?php echo esc_attr( $value )?>" class="<?php echo esc_attr( $active )?>">
					<?php include_once \Quicker::core_dir()."admin/settings/tab-content/".$value.".php"; ?>
				</div>
				<?php } ?>	
			</div>
		</div>
		<button class="button button-primary admin-button"><?php esc_html_e( 'Save Changes', 'quicker' );?></button>
		</div>
	</form>
</div>