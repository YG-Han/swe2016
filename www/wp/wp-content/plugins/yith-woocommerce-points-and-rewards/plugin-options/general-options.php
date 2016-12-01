<?php

$settings = array(

    'general' => array(

        'header'    => array(

            array(
                'name' => __( 'General Settings', 'yith-woocommerce-points-and-rewards' ),
                'type' => 'title'
            ),

            array( 'type' => 'close' )
        ),


        'settings' => array(

            array( 'type' => 'open' ),

            array(
                'id'      => 'enabled',
                'name'    => __( 'Enable Points and Rewards', 'yith-woocommerce-points-and-rewards' ),
                'desc'    => '',
                'type'    => 'on-off',
                'std'     => 'yes'
            ),

            array(
                'id'      => 'earn_points_conversion_rate',
                'name'    => __( 'Conversion Rate for Points earned', 'yith-woocommerce-points-and-rewards' ),
                'desc'    => '',
                'type'    => 'options-conversion'
            ),


            array( 'type' => 'close' ),
        )
    )
);

return apply_filters( 'yith_ywpar_panel_settings_options', $settings );