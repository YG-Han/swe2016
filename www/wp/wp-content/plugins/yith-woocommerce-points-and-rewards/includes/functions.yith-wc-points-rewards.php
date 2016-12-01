<?php
if ( !defined( 'ABSPATH' ) || ! defined( 'YITH_YWPAR_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Implements helper functions for YITH WooCommerce Points and Rewards
 *
 * @package YITH WooCommerce Points and Rewards
 * @since   1.0.0
 * @author  Yithemes
 */

$yith_ywpar_db_version = '1.0.1';

if ( !function_exists( 'yith_ywpar_db_install' ) ) {
    /**
     * Install the table yith_ywpar_points_log
     *
     * @return void
     * @since 1.0.0
     */
    function yith_ywpar_db_install() {
        global $wpdb;
        global $yith_ywpar_db_version;

        $installed_ver = get_option( "yith_ywpar_db_version" );

        $table_name = $wpdb->prefix . 'yith_ywpar_points_log';

        $charset_collate = $wpdb->get_charset_collate();

        if( ! $installed_ver ){
            $sql = "CREATE TABLE $table_name (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `action` VARCHAR (255) NOT NULL,
            `order_id` int(11),
            `amount` int(11) NOT NULL,
            `date_earning` datetime NOT NULL,
            `cancelled` datetime,
            PRIMARY KEY (id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

            add_option( 'yith_ywpar_db_version', $yith_ywpar_db_version );
        }

        if ( $installed_ver == '1.0.0') {
            $sql = "SELECT COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='$table_name'";
            $cols = $wpdb->get_col($sql);

            if( is_array($cols) && !in_array('cancelled', $cols)){
                $sql = "ALTER TABLE $table_name ADD `cancelled` datetime";
                $wpdb->query( $sql);
            }
            update_option( 'yith_ywpar_db_version', $yith_ywpar_db_version );
        }
    }
}


if ( !function_exists( 'yith_ywpar_locate_template' ) ) {
    /**
     * Locate the templates and return the path of the file found
     *
     * @param string $path
     * @param array  $var
     *
     * @return void
     * @since 1.0.0
     */
    function yith_ywpar_locate_template( $path, $var = NULL ) {
        global $woocommerce;

        if ( function_exists( 'WC' ) ) {
            $woocommerce_base = WC()->template_path();
        }
        elseif ( defined( 'WC_TEMPLATE_PATH' ) ) {
            $woocommerce_base = WC_TEMPLATE_PATH;
        }
        else {
            $woocommerce_base = $woocommerce->plugin_path() . '/templates/';
        }

        $template_woocommerce_path = $woocommerce_base . $path;
        $template_path             = '/' . $path;
        $plugin_path               = YITH_YWPAR_DIR . 'templates/' . $path;

        $located = locate_template( array(
            $template_woocommerce_path, // Search in <theme>/woocommerce/
            $template_path,             // Search in <theme>/
            $plugin_path                // Search in <plugin>/templates/
        ) );

        if ( !$located && file_exists( $plugin_path ) ) {
            return apply_filters( 'yith_ywpar_locate_template', $plugin_path, $path );
        }

        return apply_filters( 'yith_ywpar_locate_template', $located, $path );
    }
}

