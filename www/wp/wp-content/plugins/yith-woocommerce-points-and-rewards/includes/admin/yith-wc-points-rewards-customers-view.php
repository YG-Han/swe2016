<?php

/**
 * YITH WooCommerce Points and Rewards Customers List Table
 *
 * @package YITH WooCommerce Points and Rewards
 * @since   1.0.0
 * @author  Yithemes
 */


class YITH_WC_Points_Rewards_Customers_List_Table extends WP_List_Table {



    public function __construct( $args = array() ) {
        parent::__construct( array() );
    }

    function get_columns() {
        $columns = array(
            'user_id'   => __( 'ID', 'yith-woocommerce-points-and-rewards' ),
            'user_info' => __( 'User', 'yith-woocommerce-points-and-rewards' ),
            'points'    => __( 'Subtotal', 'yith-woocommerce-points-and-rewards' ),
            'action'    => __( 'Action', 'yith-woocommerce-points-and-rewards' ),
        );
        return $columns;
    }

    function prepare_items() {

        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $users_per_page = 25;

        $paged = ( isset( $_GET['paged'] ) ) ? $_GET['paged'] : '';

        if ( empty( $paged ) || ! is_numeric( $paged ) || $paged <= 0 ) {
            $paged = 1;
        }


        $args = array(
//            'meta_key'     => '_ywpar_user_total_points',
//            'meta_value'   => '0',
//            'meta_compare' => '>',
            'number' => $users_per_page,
            'offset' => ( $paged-1 ) * $users_per_page,
        );

        if ( $this->is_site_users )
            $args['blog_id'] = $this->site_id;

        if ( isset( $_REQUEST['orderby'] ) ){
            if(  $_REQUEST['orderby'] == 'meta_value' ){
                $args['meta_key'] = '_ywpar_user_total_points';
            }
            $args['orderby'] = $_REQUEST['orderby'];
        }

        if ( isset( $_REQUEST['order'] ) ){
            $args['order'] = $_REQUEST['order'];
        }

        $wp_user_search = new WP_User_Query( $args );

        $this->items = $wp_user_search->get_results();
        $this->set_pagination_args( array(
            'total_items' => $wp_user_search->get_total(),
            'per_page' => $users_per_page,
        ) );

    }

    function column_default( $item, $column_name ) {

        switch( $column_name ) {
            case 'user_id':
                return $item->ID;
                break;
            case 'user_info':
                $email = '<a href="mailto:'.$item->user_email.'">'.$item->user_email.'</a>';
                return $item->display_name.'<br>'.$email;
                break;
            case 'points':
                $points = get_user_meta( $item->ID, '_ywpar_user_total_points', true);
                return $points;
                break;
            default:
                return ''; //Show the whole array for troubleshooting purposes
        }
    }


    function get_sortable_columns() {
        $sortable_columns = array(
            'user_id'   => array( 'ID', false ),
            'user_info' => array( 'display_name', false ),
            'points'    => array( 'meta_value', false ),
        );
        return $sortable_columns;
    }



    function column_action( $item ) {
        $button = '<a href="' . add_query_arg( array( 'action'  => 'update',
                                                      'user_id' => $item->ID
            ) ) . '" class="ywpar_update_points button action">' . __( 'Update Points', 'yith-woocommerce-points-and-rewards' ) . '</a>';
        return $button;
    }

}
