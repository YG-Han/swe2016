<?php

if ( !defined( 'ABSPATH' ) || !defined( 'YITH_YWPAR_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Implements features of YITH WooCommerce Points and Rewards
 *
 * @class   YYITH_WC_Points_Rewards_Earning
 * @package YITH WooCommerce Points and Rewards
 * @since   1.0.0
 * @author  Yithemes
 */
if ( !class_exists( 'YITH_WC_Points_Rewards_Earning' ) ) {

    class YITH_WC_Points_Rewards_Earning {

        /**
         * Single instance of the class
         *
         * @var \YITH_WC_Points_Rewards_Earning
         */
        protected static $instance;


        /**
         * Returns single instance of the class
         *
         * @return \YITH_WC_Points_Rewards_Earning
         * @since 1.0.0
         */
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor
         *
         * Initialize plugin and registers actions and filters to be used
         *
         * @since  1.0.0
         * @author Emanuela Castorina
         */
        public function __construct() {


            //add point when
            add_action( 'woocommerce_payment_complete', array( $this, 'add_points' ) );
            add_action( 'woocommerce_order_status_on-hold_to_completed', array( $this, 'add_points' ) );
            add_action( 'woocommerce_order_status_processing', array( $this, 'add_points' ) );
            add_action( 'woocommerce_order_status_failed_to_processing', array( $this, 'add_points' ) );
            add_action( 'woocommerce_order_status_failed_to_completed', array( $this, 'add_points' ) );

            //remove point when the order is refunded or cancelled
            add_action( 'woocommerce_order_status_refunded', array( $this, 'remove_points' ) );
            add_action( 'woocommerce_order_status_cancelled', array( $this, 'remove_points' ) );

        }

        public function add_points( $order_id ){

            $order = wc_get_order( $order_id );


            $is_set = get_post_meta( $order_id,'_ywpar_points_earned', true);

            //return if the points are just calculated
            if( $is_set != ''){
                return false;
            }
            $point_earned = $this->get_point_earned( $order );

            update_post_meta( $order_id,'_ywpar_points_earned', $point_earned);

            $user_id = $order->user_id;

            if( $user_id > 0){
                $current_point = get_user_meta( $user_id, '_ywpar_user_total_points', true );
                update_user_meta( $user_id, '_ywpar_user_total_points', $current_point + $point_earned );
                YITH_WC_Points_Rewards()->register_log( $user_id, 'order_completed', $order_id, $point_earned );
            }
        }


        public function remove_points( $order_id ){

            $point_earned = get_post_meta( $order_id,'_ywpar_points_earned', true);
            if( $point_earned == ''){
                return false;
            }

            $order = wc_get_order( $order_id );
            $user_id = $order->user_id;

            $points = $point_earned;

            //order total refunded
            if( $order->get_status() == 'refunded' ){
                $points = $point_earned - $this->get_point_earned( $order );
            }

            if( $user_id > 0){
                $current_point = get_user_meta( $user_id, '_ywpar_user_total_points', true );
                update_user_meta( $user_id, '_ywpar_user_total_points', $current_point - $points );
                YITH_WC_Points_Rewards()->register_log( $user_id, 'order_'.$order->get_status(), $order_id, -$points );
            }


        }

        public function get_point_earned( $order ){
            $points = 0;
            $conversion = YITH_WC_Points_Rewards()->get_option( 'earn_points_conversion_rate' );
            $total      = $order->get_total();
            if(  ( $conversion['money'] * $conversion['points'] ) != 0 ){
                $points     = $total / $conversion['money'] * $conversion['points'];
            }

            return floor( $points );
        }

    }


}

/**
 * Unique access to instance of YITH_WC_Points_Rewards_Earning class
 *
 * @return \YITH_WC_Points_Rewards_Earning
 */
function YITH_WC_Points_Rewards_Earning() {
    return YITH_WC_Points_Rewards_Earning::get_instance();
}

