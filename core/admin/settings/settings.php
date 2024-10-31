<?php

namespace Quicker\Core\Admin\Settings;

defined( 'ABSPATH' ) || exit;

use Quicker\Utils\Singleton;
use \Quicker\Utils\Helper as Helper;
/**
 * Class Menu
 */
class Settings{

    use Singleton;

    /**
     * Initialize
     */
    public function init() {
      $callback = ['quicker_save_settings','insert_checkout_fields'];
      if ( ! empty( $callback ) ) {
        foreach ( $callback as $key => $value ) {
          add_action( 'wp_ajax_' . $value, [$this, $value] );
          add_action( 'wp_ajax_nopriv_' . $value, [$this, $value] );
        }
      }
	}

	public function insert_checkout_fields() {
		check_ajax_referer( 'quicker', sanitize_key($_POST['nonce']), false ); 
		$params    	  = !empty( $_POST['params'] ) ? map_deep( $_POST['params'], 'sanitize_text_field' ) : array();
		$this->insert_fields( $params );
		wp_send_json_success(
			array( 
			'message' 	=> esc_html__('Checkout fields Save Successfully...','quicker'),
			'data' 		=> array(),
		));

		wp_die();
	}

    /**
     * Save settings
     */
    public function quicker_save_settings() {
		check_ajax_referer( 'quicker', sanitize_key($_POST['nonce']), false ); 
		$post_arr 		= filter_input_array( INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS );
		$params    	  	= !empty( $post_arr['params'] ) ? $post_arr['params'] : array();
		$settings_key 	= Helper::get_settings_key();

		foreach ($settings_key as $key => $value) {
			if ( $key !== 'extra_fees' ) {
				$settings_key[$key] = !empty( $params[$key] ) ? $params[$key] : "";
			}else{
				$extra_fees = array();
				foreach ( $params['repeat_fields[extra_fees'] as $key => $value) {
					if (!empty($value['label']) && !empty($value['fees']) ) {
						$extra_fees[$key]['label']= $value['label'];
						$extra_fees[$key]['fees'] = $value['fees'];
					}
				}
				$settings_key['extra_fees'] = $extra_fees;
			}
		}

		update_option( 'quicker_settings' , $settings_key );
		
		wp_send_json_success(
			array( 
			'message' => esc_html__('Settings Save Successfully...','quicker'),
			'data' => Helper::get_settings(),
		));

		wp_die();
    }
	


	/**
	 * insert checkout fields
	 *
	 * @param [type] $params
	 * @return void
	 */
    public function insert_fields( $params ) {
		$single_field = !empty( $params['field_label'] ) ? $params['field_label'] : '';
		$field_type = !empty( $params['field_type'] ) ? $params['field_type'] : '';
		$ID = !empty( $params['ID'] ) ? $params['ID'] : '';

		if ( $ID == "" ) {
			$id = wp_insert_post(array(
				'post_title'=> $single_field, 
				'post_type'=>'quicker_ch_fields', 
				'post_content'=>$field_type,
				'post_status' => 'publish'
			));
		}else{
		  $post_update = array(
			  'ID'         => $ID,
			  'post_title' => $single_field 
			);
		  
			wp_update_post( $post_update );
			$id = $ID;
		}

		if (!empty( $id ) ) {
		  foreach (Helper::checkout_fields_defaults_key() as $key_name) {
			$meta_value = $key_name == 'field_name' && $params[$key_name] == '' ? 'extra_field_'.$id : $params[$key_name];
			update_post_meta( $id, $key_name, $meta_value );
		  }
		}

	}

}
