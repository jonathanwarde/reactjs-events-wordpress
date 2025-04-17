<?php

function getUpcomingEvents($eventIds)
{
    if (!is_array($eventIds)) {
        return false;
    }

    if(is_array($eventIds) && empty($eventIds)) {
        return false;
    }
    // Get today's date in Ymd format
    $today = date('Ymd');

    $args = array(
        'post_type' => 'event',
        'posts_per_page' => 20,
        'post_status' => 'publish',
        'orderby' => 'meta_value', // Order by a custom field
        'meta_key' => 'start_date', // Specify which custom field to use for ordering
        'order' => 'ASC', // Order from earliest to latest
        'post__in' => $eventIds,
        'meta_query' => array(
            array(
                'key' => 'start_date',
                'value' => $today,
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    );

    $events = new WP_Query($args);

    return $events;
}



function getUpComingEventIdsWithComedian() {
    global $wpdb;

    $current_post_id = get_the_ID();
    if (!$current_post_id) {
        return []; // Early return if no current post ID
    }

    $today = date('Y-m-d'); // Get today's date in 'YYYY-MM-DD' format

    $query = $wpdb->prepare("
        SELECT post_meta.meta_value, p.ID
        FROM {$wpdb->posts} p
        INNER JOIN {$wpdb->postmeta} post_meta ON p.ID = post_meta.post_id
        INNER JOIN {$wpdb->postmeta} post_meta2 ON p.ID = post_meta2.post_id
        WHERE p.post_type = 'event'
        AND p.post_status = 'publish'
        AND post_meta.meta_key = 'comedians'
        AND post_meta2.meta_key = 'start_date'
        AND STR_TO_DATE(post_meta2.meta_value, '%%Y-%%m-%%d') >= %s
    ", $today);

    $results = $wpdb->get_results($query);
    $eventIds = [];

    foreach ($results as $result) {
        // Unserialize the meta_value
        $comedians = maybe_unserialize($result->meta_value);

        // Check if the unserialized array contains the current post ID
        if (is_array($comedians) && in_array($current_post_id, array_map('intval', $comedians))) {
            $eventIds[] = (int) $result->ID; // Add the event ID
        }
    }

    return $eventIds;
}


