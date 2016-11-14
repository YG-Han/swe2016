<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package purelyShopping
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'purelyshopping' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<?php if (get_theme_mod('purelyshopping_show_topbar') == 'true') { ?>
		<div class="top-menubar">
			<div class="container">
				<div class="col grid_6_of_12">
					<?php wp_nav_menu( array( 'theme_location' => 'pure-topmenu' ) ); ?>
				</div>
						
				<div class="col grid_6_of_12 textright">
					<?php wp_nav_menu( array( 'theme_location' => 'pure-topmenu2' ) ); ?>
				</div>
			</div>
		</div>	
		<?php } ?>
		<div class="header-menubar">
			<div class="container">
				<?php if ( get_header_image() ) : ?>
				<div class="site-branding col grid_5_of_12">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo('name'); ?>" class="header-image">
						<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php bloginfo('name'); ?>">
					</a>
				</div>
				<?php else: ?>
				<div class="site-branding col grid_5_of_12">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				</div><!-- .site-branding -->
				<?php endif; ?>
		
				<nav id="site-navigation" class="main-navigation col grid_7_of_12" role="navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php _e( 'Primary Menu', 'purelyshopping' ); ?></button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				</nav><!-- #site-navigation -->
				
								
			</div>
		</div>	
	</header><!-- #masthead -->

	<div id="content" class="site-content container">
	