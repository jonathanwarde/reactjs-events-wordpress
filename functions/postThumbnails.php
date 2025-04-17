<?php

set_post_thumbnail_size(600, 338, true);

add_filter( 'post_thumbnail_html', 'my_post_thumbnail_html' );

function my_post_thumbnail_html( $html ) {

	// if (empty($html )){

	// $html = '<img src="' . randomImage(640,360,false) . '" />';

	// }

	return $html;
}

add_image_size( 'banner', 1000, 340, true);

update_option( 'thumbnail_size_h', 84 );
update_option( 'thumbnail_crop', 1 );


/*
[0]=>
  string(9) "thumbnail"
[1]=>
  string(6) "medium"
[2]=>
  string(12) "medium_large"
[3]=>
  string(5) "large"
[4]=>
  string(14) "post-thumbnail"
[5]=>
  string(6) "banner"
*/
?>
