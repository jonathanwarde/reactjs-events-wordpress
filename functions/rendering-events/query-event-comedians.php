<?php
function query_comedians_by_event($event_id) {
    // Retrieve the IDs of the comedian posts from the event's post meta
    $comedian_ids = array();
    for($i=1; $i<=5; $i++) {
        $performer_id = get_post_meta($event_id, "_performer_id_$i", true);
        if($performer_id) {
            $comedian_ids[] = $performer_id;
        }
    }

    //TODO: usort comedian_ids array by position

    $comedians_posts = array();

    // Query the comedian posts
    $comedians_query = new WP_Query(array(
        'post_type' => 'comedian',
        'post__in' => $comedian_ids,
        'orderby' => 'post__in', // to preserve the order of the IDs in the $comedian_ids array
    ));

    if ($comedians_query->have_posts()) {
        while ($comedians_query->have_posts()) {
            $comedians_query->the_post();
            // Add the comedian post object to the array
            $comedians_posts[] = get_post();
        }
        wp_reset_postdata(); // reset the global post data after the loop
    }

    return $comedians_posts;
}

// usage
/*
 *
 *
 * $comedians = query_comedians_by_event(123); // replace 123 with your event ID
foreach($comedians as $comedian) {
    // You can output the comedian post data here
    echo $comedian->post_title;
}

 */
