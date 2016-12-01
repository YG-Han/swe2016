<?php

if ( !defined( 'ABSPATH' ) || !defined( 'YITH_YWPAR_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Implements admin features of YITH WooCommerce Points and Rewards
 *
 * @class   YITH_WC_Points_Rewards_Admin
 * @package YITH WooCommerce Points and Rewards
 * @since   1.0.0
 * @author  Yithemes
 */
if ( !class_exists( 'YITH_WC_Points_Rewards_Admin' ) ) {

    class YITH_WC_Points_Rewards_Admin {

        /**
         * Single instance of the class
         *
         * @var \YITH_WC_Points_Rewards_Admin
         */

        protected static $instance;

        /**
         * @var $_panel Panel Object
         */
        protected $_panel;

        /**
         * @var $_premium string Premium tab template file name
         */
        protected $_premium = 'premium.php';

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing = 'http://yithemes.com/themes/plugins/yith-woocommerce-points-and-rewards/';

        /**
         * @var string Panel page
         */
        protected $_panel_page = 'yith_woocommerce_points_and_rewards';

        /**
         * @var string Doc Url
         */
        public $doc_url = 'https://yithemes.com/docs-plugins/yith-woocommerce-points-and-rewards/';

        public $plugin_options = 'yit_ywpar_options';

        /**
         * @var Wp List Table
         */
        public $cpt_obj;



        /**
         * Returns single instance of the class
         *
         * @return \YITH_WC_Points_Rewards_Admin
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

            $this->create_menu_items();

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YITH_YWPAR_DIR . '/' . basename( YITH_YWPAR_FILE ) ), array( $this, 'action_links' ) );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

            add_action( 'yit_panel_options-conversion', array( $this, 'admin_options_conversion' ), 10, 2 );
            
            //custom styles and javascripts
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ), 11);

        }


        /**
         * Enqueue styles and scripts
         *
         * @access public
         * @return void
         * @since 1.0.0
         */
        public function enqueue_styles_scripts() {
            wp_enqueue_style( 'yith_ywpar_backend', YITH_YWPAR_ASSETS_URL . '/css/backend.css', YITH_YWPAR_VERSION );
        }



        /**
         * Create Menu Items
         *
         * Print admin menu items
         *
         * @since  1.0
         * @author Emanuela Castorina
         */

        private function create_menu_items() {

            // Add a panel under YITH Plugins tab
            add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );
            add_action( 'yith_ywpar_premium_tab', array( $this, 'premium_tab' ) );
            add_action( 'yith_ywpar_customers', array( $this, 'customers_tab' ) );
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use      /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */

        public function register_panel() {

            if ( !empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs = array(
                'general' => __( 'Settings', 'yith-woocommerce-points-and-rewards' ),
                'customers' => __( 'Customer Points', 'yith-woocommerce-points-and-rewards' ),
            );

            if ( defined( 'YITH_YWPAR_FREE_INIT' ) ) {
                $admin_tabs['premium'] = __( 'Premium Version', 'yith-woocommerce-points-and-rewards' );
            }


            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Points and Rewards', 'yith-woocommerce-points-and-rewards' ),
                'menu_title'       => __( 'Points and Rewards', 'yith-woocommerce-points-and-rewards' ),
                'capability'       => 'manage_options',
                'parent'           => 'ywpar',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YITH_YWPAR_DIR . '/plugin-options'
            );

            /* === Fixed: not updated theme  === */
            if ( !class_exists( 'YIT_Plugin_Panel' ) ) {
                require_once( YITH_YWPAR_DIR.'/plugin-fw/lib/yit-plugin-panel.php' );
            }

            $this->_panel = new YIT_Plugin_Panel( $args );

            $this->save_default_options();

        }

        public function save_default_options(){
            $options = get_option( 'yit_ywpar_options' );
            if( $options === false ){
                add_option( 'yit_ywpar_options', $this->_panel->get_default_options() );
            }
        }



        /**
         * Template for admin section
         *
         * @since 1.0.0
         * @access public
         * @author Emanuela Castorina
         */
        public function admin_options_conversion( $option, $db_value ) {
            include( YITH_YWPAR_TEMPLATE_PATH . '/panel/types/options-conversion.php' );
        }


        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */

        public function premium_tab() {
            $premium_tab_template = YITH_YWPAR_TEMPLATE_PATH . '/admin/' . $this->_premium;
         
            if ( file_exists( $premium_tab_template ) ) {
                include_once( $premium_tab_template );
            }
        }

        /**
         * Customers Tab Template
         *
         * Load the customers tab template on admin page
         *
         * @return   void
         * @since    1.0
         * @author   Emanuela Castorina
         */

        public function customers_tab() {
            $points = 0;

            if( isset( $_REQUEST['action'] )){
                $user_id =  $_REQUEST['user_id'];
                $user_info = get_userdata($user_id);

                if ( $_REQUEST['action'] == 'save' && wp_verify_nonce( $_POST['ywpar_update_points'], 'update_points' ) ) {
                    update_user_meta( $user_id, '_ywpar_user_total_points', $_REQUEST['user_points'] );
                    YITH_WC_Points_Rewards()->register_log($user_id, 'admin_action', '', $_REQUEST['user_points'] );
                }

                $points = get_user_meta( $user_id, '_ywpar_user_total_points', true );
                $link = remove_query_arg(array('action', 'user_id'));

            }else{
                $this->cpt_obj = new YITH_WC_Points_Rewards_Customers_List_Table();
            }


            $customers_tab = YITH_YWPAR_TEMPLATE_PATH . '/admin/customers-tab.php';
            if ( file_exists( $customers_tab ) ) {
                include_once( $customers_tab );
            }
        }


        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed
         * @use      plugin_action_links_{$plugin_file_name}
         */

        public function action_links( $links ) {

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-woocommerce-points-and-rewards' ) . '</a>';
            if ( defined( 'YITH_YWPAR_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'yith-woocommerce-points-and-rewards' ) . '</a>';
            }

            return $links;
        }


        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use      plugin_row_meta
         */
        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {

            if ( defined( 'YITH_YWPAR_INIT' ) && YITH_YWPAR_INIT == $plugin_file ) {
                $plugin_meta[] = '<a href="' . $this->doc_url . '" target="_blank">' . __( 'Plugin Documentation', 'yith-woocommerce-points-and-rewards' ) . '</a>';
            }
            return $plugin_meta;
        }



        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri(){
            return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing.'?refer_id=1030585';
        }




    }
}

/**
 * Unique access to instance of YITH_WC_Points_Rewards_Admin class
 *
 * @return \YITH_WC_Points_Rewards_Admin
 */
function YITH_WC_Points_Rewards_Admin() {
    return YITH_WC_Points_Rewards_Admin::get_instance();
}
