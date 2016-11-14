  <?php if(kadence_display_sidebar()) {
        $slide_sidebar = 848;
      } else {
        $slide_sidebar = 1140;
      }
      global $post, $virtue;
      $headcontent = get_post_meta( $post->ID, '_kad_blog_head', true );
      $height      = get_post_meta( $post->ID, '_kad_posthead_height', true );
      $swidth      = get_post_meta( $post->ID, '_kad_posthead_width', true );
      if(empty($headcontent) || $headcontent == 'default') {
          if(!empty($virtue['post_head_default'])) {
              $headcontent = $virtue['post_head_default'];
          } else {
              $headcontent = 'none';
          }
      }
      if (!empty($height)) {
        $slideheight = $height; 
      } else {
        $slideheight = 400;
      }
      if (!empty($swidth)) {
        $slidewidth = $swidth; 
      } else {
        $slidewidth = $slide_sidebar;
      } 

    /**
    * 
    */
    do_action( 'kadence_single_post_begin' ); 
    ?>
<div id="content" class="container">
    <div class="row single-article" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="main <?php echo esc_attr( kadence_main_class() ); ?>" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>>
            <?php
             do_action( 'kadence_single_post_before' ); 

            if ($headcontent == 'flex') { ?>
                <section class="postfeat">
                    <div class="flexslider kad-light-wp-gallery loading kt-flexslider" style="max-width:<?php echo esc_attr($slidewidth);?>px;" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                        <ul class="slides">
                        <?php 
                        $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                        if(!empty($image_gallery)) {
                            $attachments = array_filter( explode( ',', $image_gallery ) );
                            if ($attachments) {
                                foreach ($attachments as $attachment) {
                                $attachment_src = wp_get_attachment_image_src($attachment , 'full');
                                $caption = get_post($attachment)->post_excerpt;
                                $image = aq_resize($attachment_src[0], $slidewidth, $slideheight, true, false, false, $attachment);
                                if(empty($image[0])) { $image = array($attachment_src[0], $attachment_src[1], $attachment_src[2]); }

                                    echo '<li>';
                                        echo '<a href="'.esc_url($attachment_src[0]).'" data-rel="lightbox" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';
                                            echo '<img src="'.esc_url($image[0]).'" width="'.esc_attr($image[1]).'" height="'.esc_attr($image[2]).'" alt="'.esc_attr($caption).'" '.kt_get_srcset_output($image[1], $image[2], $attachment_src[0], $attachment).' itemprop="contentUrl"/>';
                                                echo '<meta itemprop="url" content="'.esc_url($image[0]).'">';
                                                echo '<meta itemprop="width" content="'.esc_attr($image[1]).'">';
                                                echo '<meta itemprop="height" content="'.esc_attr($image[2]).'">';
                                        echo '</a>';
                                    echo '</li>';
                                }
                            }
                        }
                        ?>                            
                        </ul>
                    </div> <!--Flex Slides-->
                </section>
            <?php } else if ($headcontent == 'video') { ?>
                <section class="postfeat">
                    <div class="videofit">
                        <?php echo do_shortcode( get_post_meta( $post->ID, '_kad_post_video', true ) ); ?>
                    </div>
                    <?php if (has_post_thumbnail( $post->ID ) ) { 
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                        <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                        <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                    </div>
                    <?php } ?>
                </section>
            <?php } else if ($headcontent == 'image') {
                    if (has_post_thumbnail( $post->ID ) ) {        
                        $image_id = get_post_thumbnail_id();
                        $image_src = wp_get_attachment_image_src( $image_id, 'full' );
                        $image = aq_resize( $image_src[0], $slidewidth, $slideheight, true, false, false, $image_id); //resize & crop the image
                        if(empty($image[0])) { $image = array($image_src[0], $image_src[1], $image_src[2]); }
                        ?>
                            <div class="imghoverclass postfeat post-single-img" itemscope itemtype="https://schema.org/ImageObject">
                                <a href="<?php echo esc_url($image_src[0]); ?>" data-rel="lightbox" class="lightboxhover">
                                    <img src="<?php echo esc_url($image[0]); ?>"  width="<?php echo esc_attr($image[1]); ?>" height="<?php echo esc_attr($image[2]); ?>" <?php echo kt_get_srcset_output($image[1], $image[2], $image[0], $image_id);?> itemprop="contentUrl" alt="<?php the_title(); ?>" />
                                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                                </a>
                            </div>
                        <?php
                    } 
            }  ?>

                <?php
                  /**
                  * @hooked virtue_single_post_meta_date - 20
                  */
                  do_action( 'kadence_single_post_before_header' );
                  ?>
                <header>
                    <?php 
                    /**
                    * @hooked virtue_post_header_title - 20
                    * @hooked virtue_post_header_meta - 30
                    */
                    do_action( 'kadence_single_post_header' );
                    ?>
                </header>

                <div class="entry-content" itemprop="description articleBody">
                    <?php
                    do_action( 'kadence_single_post_content_before' );
                        
                        the_content(); 
                      
                    do_action( 'kadence_single_post_content_after' );
                    ?>
                </div>

                <footer class="single-footer">
                <?php 
                  /**
                  * @hooked virtue_post_footer_pagination - 10
                  * @hooked virtue_post_footer_tags - 20
                  * @hooked virtue_post_footer_meta - 30
                  * @hooked virtue_post_nav - 40
                  */
                  do_action( 'kadence_single_post_footer' );
                  ?>
                </footer>
            </article>
            <?php
            /**
            * @hooked virtue_post_authorbox - 20
            * @hooked virtue_post_bottom_carousel - 30
            * @hooked virtue_post_comments - 40
            */
            do_action( 'kadence_single_post_after' );
            
            endwhile; ?>
        </div>
        <?php 
        do_action( 'kadence_single_post_end' ); 
