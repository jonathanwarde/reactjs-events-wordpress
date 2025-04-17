<?php

function getComedians($count,$page,$search=null){

  $args = array(
  'posts_per_page'   => $count,
  'offset' => $count * $page,
  'orderby'          => 'title',
  'order'            => 'DESC',
  'post_type'        => 'comedian',
  'post_status'      => 'publish',
  'suppress_filters' => true
  );

  if($search){

      $args["s"] = $search;

  }

  $comedians = get_posts($args);

  // Filter out entries where search is not in title

  if($search){

      foreach ($comedians as $key => $comedian){

          if(strpos(strtolower($comedian->post_title), strtolower($search)) === false){

              unset($comedians[$key]);

          }

      }

  }

return $comedians;

}

// TODO: transient for this.
function getFeaturedComedians(){

	$featured = get_posts(array(
	'numberposts'	=> -1,
	'post_type'		=> 'comedian',
	'meta_key'		=> 'featured_comedian',
	'meta_value'	=> true
));

return $featured;

}

?>
