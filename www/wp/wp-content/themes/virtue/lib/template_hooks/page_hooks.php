<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
add_action( 'kadence_page_footer', 'virtue_page_comments', 20 );
function virtue_page_comments() {
    global $virtue;
    if(isset($virtue['page_comments']) && $virtue['page_comments'] == '1') {
        comments_template('/templates/comments.php');
    }
}