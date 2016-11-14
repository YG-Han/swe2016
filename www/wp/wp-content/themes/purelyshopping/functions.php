<?php
/**
 * purelyShopping functions and definitions
 *
 * @package purelyShopping
 */


if ( ! function_exists( 'purelyshopping_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function purelyshopping_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on purelyShopping, use a find and replace
	 * to change 'purelyshopping' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'purelyshopping', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'purelyshopping' ),
		'pure-topmenu' => __( 'Top Menu Left', 'purelyshopping' ),
		'pure-topmenu2' => __( 'Top Menu Right', 'purelyshopping' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
	/**
	* Adding support for the post thumbnails
	*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 370, 253, true );


	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'purelyshopping_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	// Setting up max length on excerpt
	function custom_excerpt_length( $length ) {
	return 15;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

	
	/**
	* Set the content width based on the theme's design and stylesheet.
	*/
	if ( ! isset( $content_width ) ) {
	global $content_width;
	$content_width = 640; /* pixels */
}

}
endif; // purelyshopping_setup
add_action( 'after_setup_theme', 'purelyshopping_setup' );

add_action( 'after_setup_theme', 'purelyshopping_woocommerce_support' );

function purelyshopping_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function purelyshopping_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'purelyshopping' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	// Used in Top Header on Frontpage
	register_sidebar( array(
		'name'          => __( 'Top Menu Left', 'purelyshopping' ),
		'id'            => 'pure-topmenu',
		'description'   => '',
		'before_widget' => '<div class="%1$s topmenu %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Used in Top Header on Frontpage
	register_sidebar( array(
		'name'          => __( 'Top Menu Right', 'purelyshopping' ),
		'id'            => 'pure-topmenu2',
		'description'   => '',
		'before_widget' => '<div class="%1$s topmenu2 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Used for custom plugin widget on frontpage (slideshows etc)
	register_sidebar( array(
		'name'          => __( 'Custom Content', 'purelyshopping' ),
		'id'            => 'custom-box',
		'description'   => '',
		'before_widget' => '<div class="custom-box">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	// Used in Top Header on Frontpage
	register_sidebar( array(
		'name'          => __( 'Products Widget before content', 'purelyshopping' ),
		'id'            => 'front-box',
		'description'   => '',
		'before_widget' => '<div class="%1$s feat-prods %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
	// Used in Top Header on Frontpage
	register_sidebar( array(
		'name'          => __( 'Products Widget after content', 'purelyshopping' ),
		'id'            => 'front-box-after',
		'description'   => '',
		'before_widget' => '<div class="%1$s feat-prods-after %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
}
add_action( 'widgets_init', 'purelyshopping_widgets_init' );
/**
 * Register roboto and Fauna Google fonts.
 */
function purelyshopping_fonts_url() {
    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by the Google fonts, translate this to 'off'. Do not translate
    * into your own language.
    */
		
    $font_one = _x( 'on', 'Font One: on or off', 'purelyshopping' );
	$font_two = _x( 'on', 'Font Two: on or off', 'purelyshopping' );

    if ( 'off' !== $font_one || 'off' !== $font_two ) {
        $font_families = array();
 
        if ( 'off' !== $font_one ) {
            $font_families[] = 'Pacifico:400,700,400italic';
        }
		
		if ( 'off' !== $font_two ) {
            $font_families[] = 'Raleway:400,700,400italic';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
     return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function purelyshopping_scripts() {
	// Load main stylesheet
	wp_enqueue_style( 'purelyshopping-style', get_stylesheet_uri() );
	// Load slicknav css
	wp_enqueue_style( 'purelyshopping-slicknav-css', get_template_directory_uri() . '/css/slicknav.css' );
	// Load Google Fonts
	wp_enqueue_style( 'purelyshopping-fonts', purelyshopping_fonts_url(), array(), null );
	// Load custom css defining responsivity, grids etc.
	wp_enqueue_style( 'purelyshopping-customcss', get_template_directory_uri() . '/css/custom.css' );
	
	// Load jQuery using WordPress
	wp_enqueue_script( 'jquery' );
	// Load tinynav library
	wp_enqueue_script( 'purelyshopping-navigation', get_template_directory_uri() . '/js/jquery.slicknav.js', array(), '20150202', true );
	// Execute script and set div selector class
	wp_enqueue_script( 'purelyshopping-loadnavigation', get_template_directory_uri() . '/js/slicknav_load.js', array(), '20150202', true );
	
	wp_enqueue_script( 'purelyshopping-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'purelyshopping_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/purelyshopping_custom.php';