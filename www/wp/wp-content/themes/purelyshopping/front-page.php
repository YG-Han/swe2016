<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package purelyShopping
 */

get_header(); ?>
	
			<?php if ( is_active_sidebar( 'custom-box' ) ) : ?>
			<div class="custom-box">
				<div id="custom-box" class="col grid_12_of_12" role="complementary">
				<?php dynamic_sidebar( 'custom-box' ); ?>
				</div>
			</div>	
			<?php endif; ?>
	
	<div class="featured-product-box">
			<?php if ( is_active_sidebar( 'front-box' ) ) : ?>
				<div id="front-box" class=" col grid_12_of_12" role="complementary">
				<?php dynamic_sidebar( 'front-box' ); ?>
				</div>
			<?php endif; ?>
	</div>
	
	<div class="featured-product-box-after">
			<?php if ( is_active_sidebar( 'front-box-after' ) ) : ?>
				<div id="front-box-after" class="col grid_12_of_12" role="complementary">
				<?php dynamic_sidebar( 'front-box-after' ); ?>
				</div>
			<?php endif; ?>
	</div>
<?php get_footer(); ?>
