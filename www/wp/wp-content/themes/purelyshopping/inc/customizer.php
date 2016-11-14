<?php
/**
 * purelyShopping Theme Customizer
 *
 * @package purelyShopping
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function purelyshopping_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	$wp_customize->add_section( 'purelyshopping_general', array(
	'title' => __('PurelyShopping Settings', 'purelyshopping'),
	'priority' => 10,
	) );
	$wp_customize->add_setting( 'purelyshopping_show_topbar', array(
	'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control(	'purelyshopping_show_topbar', 	array(
		'label'    => __( 'Show topbar?', 'purelyshopping' ),
		'section'  => 'purelyshopping_general',
		'settings' => 'purelyshopping_show_topbar',
		'type'     => 'select',
		'choices'  => array('true'  => 'Enable Topbar', '0' => 'Disable Topbar')
	));	
	
	$wp_customize->add_setting( 'purelyshopping_navigation_link_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'purelyshopping_navigation_bg_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'purelyshopping_navigation_link_color', array(
		'label'       => __( 'Navigation Link Color', 'purelyshopping' ),
		'description' => __( 'Override default styling', 'purelyshopping' ),
		'section'     => 'colors',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'purelyshopping_navigation_bg_color', array(
		'label'       => __( 'Navigation BG Color', 'purelyshopping' ),
		'description' => __( 'Override default styling', 'purelyshopping' ),
		'section'     => 'colors',
	) ) );
}
add_action( 'customize_register', 'purelyshopping_customize_register' );



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function purelyshopping_customize_preview_js() {
	wp_enqueue_script( 'purelyshopping_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'purelyshopping_customize_preview_js' );


function purelyshopping_custom_css() {

	wp_enqueue_style(
		'custom-style',
		get_template_directory_uri() . '/css/custom.css'
	);
	if ( '' == get_theme_mod( 'purelyshopping_navigation_link_color' ) ) { $purelyshopping_navigation_link_color = '#003D5C'; } else { $purelyshopping_navigation_link_color = get_theme_mod('purelyshopping_navigation_link_color'); }
	if ( '' == get_theme_mod( 'purelyshopping_navigation_bg_color' ) ) { $purelyshopping_navigation_bg_color = '#FFF'; } else { $purelyshopping_navigation_bg_color = get_theme_mod('purelyshopping_navigation_bg_color'); }
	if ( '' == get_theme_mod( 'purelyshopping_show_topbar' ) ) { $purelyshopping_show_topbar = 'true'; } else { $purelyshopping_show_topbar = get_theme_mod('purelyshopping_show_topbar'); }
	
	if ($purelyshopping_navigation_link_color != '') { 
        $custom_css = "
				.main-navigation a {
                        color: {$purelyshopping_navigation_link_color};
                }
		"; }
	if ($purelyshopping_navigation_bg_color != '') {
		$custom_css .= "
				.header-menubar {
						background-color:{$purelyshopping_navigation_bg_color};
				}
		"; }

    wp_add_inline_style( 'custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'purelyshopping_custom_css' );
