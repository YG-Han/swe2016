<?php

if ( !defined( 'ABSPATH' ) || !defined( 'YITH_YWPAR_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Implements features of YITH WooCommerce Points and Rewards Frontend
 *
 * @class   YITH_WC_Points_Rewards_Frontend
 * @package YITH WooCommerce Points and Rewards
 * @since   1.0.0
 * @author  Yithemes
 */
if ( !class_exists( 'YITH_WC_Points_Rewards_Frontend' ) ) {

    class YITH_WC_Points_Rewards_Frontend {

        /**
         * Single instance of the class
         *
         * @var \YITH_WC_Points_Rewards_Frontend
         */
        protected static $instance;



        /**
         * Returns single instance of the class
         *
         * @return \YITH_WC_Points_Rewards_Frontend
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
            add_action( 'woocommerce_before_my_account', array( $this, 'my_account_points' ) );
        }

        /**
         * Add points section to my-account page
         *
         * @since   1.0.0
         * @author  Emanuela Castorina
         * @return  void
         */
        public function my_account_points(){
            wc_get_template( 'myaccount/my-points-view.php');
        }


    }


}

/**
 * Unique access to instance of YITH_WC_Points_Rewards_Frontend class
 *
 * @return \YITH_WC_Points_Rewards_Frontend
 */
function YITH_WC_Points_Rewards_Frontend() {
    return YITH_WC_Points_Rewards_Frontend::get_instance();
}

