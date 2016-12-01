<?php
/*
Plugin Name: YITH WooCommerce Points and Rewards
Description: YITH WooCommerce Popup lets you easily manage and customize all the popups of your site
Version: 1.0.5
Author: YTHEMES
Author URI: http://yithemes.com/
Text Domain: yith-woocommerce-points-and-rewards
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*
 * @package YITH WooCommerce Points and Rewards
 * @since   1.0.0
 * @author  YTHEMES
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( ! defined( 'YITH_YWPAR_DIR' ) ) {
    define( 'YITH_YWPAR_DIR', plugin_dir_path( __FILE__ ) );
}

// This version can't be activate if premium version is active  ________________________________________
if ( defined( 'YITH_YWPAR_PREMIUM' ) ) {
    function yith_ywpar_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Points and Rewards while you are using the premium one.', 'yith-woocommerce-points-and-rewards' ); ?></p>
        </div>
        <?php
    }

    add_action( 'admin_notices', 'yith_ywpar_install_free_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;
}

/* Plugin Framework Version Check */
if( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YITH_YWPAR_DIR . 'plugin-fw/init.php' ) ) {
    require_once( YITH_YWPAR_DIR . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( YITH_YWPAR_DIR  );

// Registration hook  ________________________________________
if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( !function_exists( 'yith_ywpar_install_woocommerce_admin_notice' ) ) {
    function yith_ywpar_install_woocommerce_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'YITH WooCommerce Points and Rewards is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-points-and-rewards' ); ?></p>
        </div>
        <?php
    }
}

// Define constants ________________________________________
if ( defined( 'YITH_YWPAR_VERSION' ) ) {
    return;
}else{
    define( 'YITH_YWPAR_VERSION', '1.0.5' );
}

if ( ! defined( 'YITH_YWPAR_FREE_INIT' ) ) {
    define( 'YITH_YWPAR_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_YWPAR_INIT' ) ) {
    define( 'YITH_YWPAR_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_YWPAR_FILE' ) ) {
    define( 'YITH_YWPAR_FILE', __FILE__ );
}



if ( ! defined( 'YITH_YWPAR_URL' ) ) {
    define( 'YITH_YWPAR_URL', plugins_url( '/', __FILE__ ) );
}

if ( ! defined( 'YITH_YWPAR_ASSETS_URL' ) ) {
    define( 'YITH_YWPAR_ASSETS_URL', YITH_YWPAR_URL . 'assets' );
}

if ( ! defined( 'YITH_YWPAR_TEMPLATE_PATH' ) ) {
    define( 'YITH_YWPAR_TEMPLATE_PATH', YITH_YWPAR_DIR . 'templates' );
}

if ( ! defined( 'YITH_YWPAR_INC' ) ) {
    define( 'YITH_YWPAR_INC', YITH_YWPAR_DIR . '/includes/' );
}

if ( ! defined( 'YITH_YWPAR_SUFFIX' ) ) {
    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    define( 'YITH_YWPAR_SUFFIX', $suffix );
}
if ( ! function_exists( 'yith_ywpar_install' ) ) {
    function yith_ywpar_install() {

        if ( !function_exists( 'WC' ) ) {
            add_action( 'admin_notices', 'yith_ywpar_install_woocommerce_admin_notice' );
        } else {
            do_action( 'yith_ywpar_init' );
        }

        // check for update table
        if( function_exists( 'yith_ywpar_update_db_check' ) ) {
            yith_ywpar_update_db_check();
        }
    }

    add_action( 'plugins_loaded', 'yith_ywpar_install', 11 );
}


function yith_ywpar_constructor() {

    // Woocommerce installation check _________________________
    if ( !function_exists( 'WC' ) ) {
        function yith_ywpar_install_woocommerce_admin_notice() {
            ?>
            <div class="error">
                <p><?php _e( 'YITH WooCommerce Points and Rewards is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-points-and-rewards' ); ?></p>
            </div>
            <?php
        }

        add_action( 'admin_notices', 'yith_ywpar_install_woocommerce_admin_notice' );
        return;
    }

    // Load ywpar text domain ___________________________________
    load_plugin_textdomain( 'yith-woocommerce-points-and-rewards', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    if( ! class_exists( 'WP_List_Table' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    require_once( YITH_YWPAR_INC . 'functions.yith-wc-points-rewards.php' );
    require_once( YITH_YWPAR_INC . 'class.yith-wc-points-rewards-admin.php' );
    require_once( YITH_YWPAR_INC . 'class.yith-wc-points-rewards-frontend.php' );


    require_once( YITH_YWPAR_INC . 'class.yith-wc-points-rewards.php' );
    require_once( YITH_YWPAR_INC . 'class.yith-wc-points-rewards-earning.php' );
    require_once( YITH_YWPAR_INC . 'admin/yith-wc-points-rewards-customers-view.php' );

    if ( is_admin() ) {
        YITH_WC_Points_Rewards_Admin();
    }
    YITH_WC_Points_Rewards();


}
add_action( 'yith_ywpar_init', 'yith_ywpar_constructor' );