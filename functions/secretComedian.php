<?php
function add_and_sort_comedians_and_celebrities($post, $wpdb) {
    $transient_key = 'sorted_comedians_' . $post->ID;
    $sorted_comedians = get_transient($transient_key);


    echo '<pre>';

    var_dump($post);

    echo '</pre>';

    // If the cached data exists, return it
    if ($sorted_comedians !== false) {
        //todo: remove this to use transient
        //return $sorted_comedians;
    }

    $sorted_comedians = [];
    $sorted_celebrities = [];
    $celebrity_index = 0;

    foreach ($post->comedians as $comedian) {
        if (isSecretCelebrity($comedian->ID, $post->ID, $wpdb)) {
            $sorted_celebrities[] = get_secret_celebrity_default_post($celebrity_index++);
        } else {
            $sorted_comedians[] = $comedian;
        }
    }

    $sorted_comedians = array_merge($sorted_celebrities, $sorted_comedians);

    // Store the result in cache for an hour
    set_transient($transient_key, $sorted_comedians, HOUR_IN_SECONDS);

    return $sorted_comedians;
}


function isSecretCelebrity($comedian_id, $event_id, $wpdb) {
    $table_name = $wpdb->prefix . "diary";
    $event = $wpdb->get_results("SELECT * FROM `{$table_name}` WHERE `event_id` = '{$event_id}' LIMIT 1");

    // Error handling for the database call
    if (!$event) {
        // Handle error here
        return false;
    }

    $event = $event[0];
    $acts = array_merge(
        json_decode($event->opener, true),
        json_decode($event->middle, true),
        json_decode($event->closer, true)
    );

    foreach ($acts as $comedian) {
        if (strval($comedian['comedian_id']) === strval($comedian_id) && isset($comedian['open']) && $comedian['open'] === 'celebrity') {
            return true;
        }
    }

    return false;
}

function get_secret_celebrity_default_post($celebrity_index) {
    $celebrities = ['special-celebrity-guest', 'second-celebrity-guest', 'third-celebrity-guest', 'fourth-celebrity-guest'];
    $the_slug = isset($celebrities[$celebrity_index]) ? $celebrities[$celebrity_index] : 'special-celebrity-guest';

    $args = array(
        'name'        => $the_slug,
        'post_type'   => 'comedian',
        'post_status' => 'publish',
        'numberposts' => 1
    );

    $my_posts = get_posts($args);
    return $my_posts ? $my_posts[0] : false;
}
