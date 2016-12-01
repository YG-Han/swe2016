<?php

if ( !defined( 'ABSPATH' ) || !defined( 'YITH_YWPAR_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Implements features of YITH WooCommerce Points and Rewards
 *
 * @class   YYITH_WC_Points_Rewards
 * @package YITH WooCommerce Points and Rewards
 * @since   1.0.0
 * @author  Yithemes
 */
if ( !class_exists( 'YITH_WC_Points_Rewards' ) ) {

    class YITH_WC_Points_Rewards {

        /**
         * Single instance of the class
         *
         * @var \YITH_WC_Points_Rewards
         */
        protected static $instance;

        public $plugin_options = 'yit_ywpar_options';


        /**
         * Returns single instance of the class
         *
         * @return \YITH_WC_Points_Rewards
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

            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

            if( ! $this->is_enabled() ){
                return false;
            }

            YITH_WC_Points_Rewards_Earning();
            YITH_WC_Points_Rewards_Frontend();

            /* general actions */
            add_filter( 'woocommerce_locate_core_template', array( $this, 'filter_woocommerce_template' ), 10, 3 );
            add_filter( 'woocommerce_locate_template', array( $this, 'filter_woocommerce_template' ), 10, 3 );
        }



        /**
         * Load YIT Plugin Framework
         *
         * @since  1.0.0
         * @return void
         * @author Emanuela Castorina
         */
        public function is_enabled(){

            $enabled = $this->get_option('enabled');

            if( $enabled == 'yes'){
                return true;
            }

            return false;
        }


        /**
         * Load YIT Plugin Framework
         *
         * @since  1.0.0
         * @return void
         * @author Emanuela Castorina
         */
        public function plugin_fw_loader() {
            if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if( ! empty( $plugin_fw_data ) ){
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file );
                }
            }
        }


        public function register_log( $user_id, $action, $order_id, $amount ) {
            global $wpdb;
            $date       = date( "Y-m-d H:i:s" );
            $table_name = $wpdb->prefix . 'yith_ywpar_points_log';

            $wpdb->insert( $table_name, array(
                'user_id'      => $user_id,
                'action'       => $action,
                'order_id'     => $order_id,
                'amount'       => $amount,
                'date_earning' => $date
            ) );
        }

        /**
         * Get options from db
         *
         * @access public
         * @since 1.0.0
         * @author  Emanuela Castorina
         * @param $option string
         * @return mixed
         */
        public function get_option( $option ) {
            // get all options
            $options = get_option( $this->plugin_options );

            if( isset( $options[ $option ] ) ) {
                return $options[ $option ];
            }

            return false;
        }

        /**
         * Locate default templates of woocommerce in plugin, if exists
         *
         * @param $core_file     string
         * @param $template      string
         * @param $template_base string
         *
         * @return string
         * @since  1.0.0
         */
        public function filter_woocommerce_template( $core_file, $template, $template_base ) {
            $located = yith_ywpar_locate_template( $template );

            if ( $located ) {
                return $located;
            }
            else {
                return $core_file;
            }
        }

    }


}

/**
 * Unique access to instance of YITH_WC_Points_Rewards class
 *
 * @return \YITH_WC_Points_Rewards
 */
function YITH_WC_Points_Rewards() {
    return YITH_WC_Points_Rewards::get_instance();
}

