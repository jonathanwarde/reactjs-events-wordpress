<?php


// Join for searching metadata
function AIOThemes_joinPOSTMETA_to_WPQuery($join) {
    global $wp_query, $wpdb;


    $s = 'INNER JOIN ' . $wpdb->prefix;
    $r = 'STRAIGHT_JOIN ' . $wpdb->prefix;
    $join['join'] = str_replace( $s, $r, $join['join'] );

    return $join;

}

add_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WP');
