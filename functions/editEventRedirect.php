<?php

//add_filter( 'get_edit_post_link', 'my_edit_post_link' );
function my_edit_post_link( $url ) {
    if (get_post_type() === "event") {
      return "/diary/";
    }

    return $url;
}
