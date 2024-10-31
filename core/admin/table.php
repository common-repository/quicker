<?php

namespace Quicker\Core\Admin;

defined('ABSPATH') || exit;

if ( ! class_exists( 'WP_List_Table' )){
    require_once ABSPATH . 'wp-admin/inclueds/class-wp-list-table.php';
}

class Table extends \WP_List_Table{

    public $singular_name;
    public $plural_name;
    public $id = '';
    public $columns = [];
    
    /**
     * Show list
     */
    function __construct($all_data_of_table){

        $this->singular_name = $all_data_of_table['singular_name'];
        $this->plural_name   = $all_data_of_table['plural_name'];
        $this->columns       = $all_data_of_table['columns'];

        parent::__construct( [
            'singular' => $this->singular_name ,
            'plural'   => $this->plural_name ,
            'ajax'     => true
        ]);
    }
    
    /**
     * Get column header function
     */
    public function get_columns(){
        return $this->columns;
    }
    

    /**
     * Sortable column function
     */
    public function get_sortable_columns() {
		unset($this->columns['actions']);
		unset($this->columns['cb']);

        return $this->columns;
    }

    /**
     * Display all row function
     */
    protected function column_default( $item , $column_name ){
        switch( $column_name ) { 
            case "actions":
				return  '
                <span 
                class="update_checkout"
                data-id="'.esc_attr($item['ID']).'" 
                data-field_position="'.esc_attr($item['field_position']).'" 
                data-field_type="'.esc_attr($item['field_type']).'" 
                data-input_type="'.esc_attr($item['input_type']).'" 
                data-field_label="'.esc_attr($item['field_label']).'" 
                data-field_name="'.esc_attr($item['field_name']).'" 
                data-field_placeholder="'.esc_attr($item['field_placeholder']).'" 
                data-field_required="'.esc_attr($item['field_required']).'" 
                data-field_enabled="'.esc_attr($item['field_enabled']).'" 
                >
                    <span class="union-edit"></span>
                </span>
            ';
			case $column_name:
				return  $item[$column_name];
            default:
                isset( $item[$column_name] ) ? $item[$column_name] : '';
            break;
        }
    }

    /**
     * Get Bulk options
     */
    public function get_bulk_actions() {
        $actions = array();
        $actions['trash'] = esc_html__( 'Move to Trash','quicker' );

        return $actions;
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%1$s" />',
            $item['ID']
        );
    }

    /** 
     * Delete data
    */
    public function process_bulk_action() {
        $action = $this->current_action();
        if( 'trash'===$action ) {
            $delete_ids = esc_sql( $_POST['bulk-delete'] );
            foreach ( $delete_ids as $did ) {
                wp_delete_post ($did, true);
            }
            wp_redirect( esc_url( add_query_arg() ) );

            exit;
        }
    }

    /**
     * Main query and show function
     */
    public function preparing_items(){
        $per_page = 20;
        $column   = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [ $column , $hidden , $sortable ];
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1) * $per_page;
        $this->process_bulk_action();

        if ( isset( $_REQUEST['orderby']) && isset( $_REQUEST['order']) ) 
        {
            $args['orderby']    = sanitize_key($_REQUEST['orderby']);
            $args['order']      = sanitize_key($_REQUEST['order']);
        }

        $args['limit']  = $per_page;
        $args['offset'] = $offset;

        $get_data = \Quicker\Utils\Helper::get_checkout_fields( $args['limit'] );
        $this->set_pagination_args( [
            'total_items'   => count( (array) \Quicker\Utils\Helper::get_checkout_fields()),
            'per_page'      => $per_page,
        ] );

        
        $this->items =  $get_data;
    }

}
