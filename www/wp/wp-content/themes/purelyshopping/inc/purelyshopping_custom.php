<?php
function purelyshopping_upsell_page() {
	add_theme_page( __('More Themes', 'purelyshopping'), __('More Themes', 'purelyshopping'), 'administrator', 'purelythemes', 'purelyshopping_upsell_view' );
}
add_action( 'admin_menu', 'purelyshopping_upsell_page', 20 );

function purelyshopping_upsell_view() {
	// Define Variables
	$directory_uri = get_template_directory_uri();
	?>
<div class="wrap">
		<h2><?php _e('More themes by the author', 'purelyshopping'); ?></h2>
		<p><?php _e('Thanks for downloading one of our themes, we really appreciate it!', 'purelyshopping'); ?></p> 
		<hr />
	<div class="theme-browser">
		<div class="themes">
			<div class="theme">
				<div class="theme-screenshot">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" target="_blank"><img src="<?php echo $directory_uri; ?>/inc/img/sylvia.jpg" alt=""></a>
				</div>
				<h3 class="theme-name"><?php _e('Sylvia', 'purelyshopping'); ?></h3>
				<div class="theme-actions">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" class="button button-primary" target="_blank"><?php _e('Read More', 'purelyshopping'); ?></a>
				</div>
			</div>	
			<div class="theme">
				<div class="theme-screenshot">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" target="_blank"><img src="<?php echo $directory_uri; ?>/inc/img/skylar.jpg" alt=""></a>
				</div>
				<h3 class="theme-name"><?php _e('Skylar', 'purelyshopping'); ?></h3>
				<div class="theme-actions">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" class="button button-primary" target="_blank"><?php _e('See Demo', 'purelyshopping'); ?></a>
				</div>
			</div>	
			<div class="theme">
				<div class="theme-screenshot">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" target="_blank"><img src="<?php echo $directory_uri; ?>/inc/img/emporium.jpg" alt=""></a>
				</div>
				<h3 class="theme-name"><?php _e('Emporium', 'purelyshopping'); ?></h3>
				<div class="theme-actions">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" class="button button-primary" target="_blank"><?php _e('See Demo', 'purelyshopping'); ?></a>
				</div>
			</div>	
			<div class="theme">
				<div class="theme-screenshot">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" target="_blank"><img src="<?php echo $directory_uri; ?>/inc/img/stella.jpg" alt=""></a>
				</div>
				<h3 class="theme-name"><?php _e('stella', 'purelyshopping'); ?></h3>
				<div class="theme-actions"><a class="button button-primary" target="_blank" href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>"><?php _e('See Demo', 'purelyshopping'); ?></a></div>
			</div>	
			<div class="theme">
				<div class="theme-screenshot">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" target="_blank"><img src="<?php echo $directory_uri; ?>/inc/img/shopping.jpg" alt=""></a>
				</div>
				<h3 class="theme-name"><?php _e('purelyshopping', 'purelyshopping'); ?></h3>
				<div class="theme-actions">
					<a class="button button-primary" target="_blank" href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>"><?php _e('See Demo', 'purelyshopping'); ?></a>
				</div>
			</div>	
			<div class="theme">
				<div class="theme-screenshot">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" target="_blank"><img src="<?php echo $directory_uri; ?>/inc/img/blue.jpg" alt=""></a>
				</div>
				<h3 class="theme-name"><?php _e('PurelyBlue', 'purelyshopping'); ?></h3>
				<div class="theme-actions">
					<a class="button button-primary" target="_blank" href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>"><?php _e('See Demo', 'purelyshopping'); ?></a>
				</div>
			</div>	
			<div class="theme">
				<div class="theme-screenshot">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" target="_blank"><img src="<?php echo $directory_uri; ?>/inc/img/glider.jpg" alt=""></a>
				</div>
				<h3 class="theme-name"><?php _e('purelyshopping', 'purelyshopping'); ?></h3>
				<div class="theme-actions">
					<a class="button button-primary" target="_blank" href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>"><?php _e('See Demo', 'purelyshopping'); ?></a>
				</div>
			</div>	
			<div class="theme">
				<div class="theme-screenshot">
					<a href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>" target="_blank"><img src="<?php echo $directory_uri; ?>/inc/img/selma.jpg" alt=""></a>
				</div>
				<h3 class="theme-name"><?php _e('Selma', 'purelyshopping'); ?></h3>
				<div class="theme-actions">
					<a class="button button-primary" target="_blank" href="<?php echo esc_url( __('http://www.purelythemes.com', 'purelyshopping'));?>"><?php _e('See Demo', 'purelyshopping'); ?></a>
				</div>
			</div>	
		</div>
	</div>	
</div>
	<?php // Close purelyshopping_upsell_view()
} 
	?>