<?php

/**
 * Enqueue CSS & JS
 */

function kadence_admin_scripts($hook) {

  wp_register_style('kad_adminstyles', get_template_directory_uri() . '/assets/css/kad_adminstyles.css', false, 267);
  wp_enqueue_style('kad_adminstyles');

	if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' && $hook != 'widgets.php') {
		return;
  }
  wp_register_script('kad_adminscripts', get_template_directory_uri() . '/assets/js/kad_adminscripts.js', false, null, false);
  wp_enqueue_script('kad_adminscripts');

}

add_action('admin_enqueue_scripts', 'kadence_admin_scripts');
