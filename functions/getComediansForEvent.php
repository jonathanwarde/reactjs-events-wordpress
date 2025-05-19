<?php
/*
 * For each event (stored in wp_diary table), there is a column with 'comedians'. We need to make seperate calls to get each comedian post
 * */
function jw_get_comedian_for_event()
{
    $comedianID = $_POST['comedian_id'];
    $mcID = $_POST['mc_id'];
    $comedianIsMC = $comedianID === $mcID ? ' (mc)' : '';
    $response_comedians = [];

   // $allComedians = get_transient('all_comedians');
   $allComedians = false;

	if (!$allComedians) {
        $arr = array(
            'post_type' => 'comedian',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'post__in' => array( $comedianID ),
        );
    
        $comediansPostsQuery = new WP_Query( $arr );
        $allComedians = $comediansPostsQuery->posts;

		set_transient('all_comedians', $allComedians, HOUR_IN_SECONDS);
	}

    foreach($allComedians as $comedian) {
        $ID = $comedian->ID;
        $name = $comedian->post_title;
    
        $secret_comedian_titles = [
            'top-secret-acts-tba',
            'acts-yet-to-be-confirmed',
            'special-celebrity-guest'
        ];
        $secret = in_array($name, $secret_comedian_titles);
    
        $link = get_permalink($ID);
        $imageMedium = get_the_post_thumbnail_url($ID, 'medium');
        $imageMediumLarge = get_the_post_thumbnail_url($ID, 'medium_large');
    

        $response_comedian[] = [
            'id'                   => $ID,
            'title'                => $name,
            'secret'               => $secret,
            'link'                 => $link,
            'image_medium'         => $imageMedium,
            'image_medium_large'   => $imageMediumLarge,
            'mc'                   => $comedianIsMC
        ];
    }
    header('Content-Type: application/json');
    echo json_encode([
        'comedian_for_event'         => $response_comedian,
    ], JSON_PRETTY_PRINT);

    exit;
}
add_action('wp_ajax_jw_get_comedian_for_event', 'jw_get_comedian_for_event');
add_action('wp_ajax_nopriv_jw_get_comedian_for_event', 'jw_get_comedian_for_event');