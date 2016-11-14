<?php
/*
Template Name: Fullwidth
*/
?>

<div id="pageheader" class="titleclass">
	<div class="container">
		<?php get_template_part('templates/page', 'header'); ?>
	</div><!--container-->
</div><!--titleclass-->
	
<div id="content" class="container">
   	<div class="row">
     	<div class="main <?php echo esc_attr(kadence_main_class()); ?>" role="main">
				<div class="entry-content" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">
					<?php get_template_part('templates/content', 'page'); ?>
				</div>
				<?php 
                /**
                * @hooked virtue_page_comments - 20
                */
                do_action('kadence_page_footer');
                ?>
		</div><!-- /.main -->