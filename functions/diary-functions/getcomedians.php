<?php

/**
 * Grab laperformerData post title by an author!
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the laperformerData,
 * or null if none.
 */
function get_comedians( $data ) {
    /**
     * External Diary app needs:
     * event_id: str
     * name: str
     * public_link: str
     * admin_link: str
     * public_blurb: str
     *
     *
     */

    $transient_key = 'get_comedians_data';

    // Try to get the data from the transient
    $cached_data = get_transient( $transient_key );

    if ( false !== $cached_data ) {
        // Transient exists, return the cached data
        return $cached_data;
    }

    $posts = get_posts( array(
        'post_type' => 'comedian',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    ) );

    $data = array();

    //TODO: get public_link

    foreach($posts as $key => $performer) {
        // Get acf fields
        $acfFields = get_fields($performer->ID);

        $performerData = [];

        if( !empty($performer->ID)) {
            $performerData['performer_id'] = strval($performer->ID);
        }
        if( $performer->post_name != '') {
            $performerData['name'] = $performer->post_title;
        }
        if( $performer->guid != '') {
            $performer_link = get_permalink($performer->ID);
            $performerData['public_link'] = $performer_link;
        }
        if( $performer->guid != '') {
            $performerData['admin_link'] = $performer->guid;
        }
        if( $performer->post_content != '') {
            $performerData['public_blurb'] = $performer->post_content;
        }
        if ( isset( $acfFields['event_email'] ) && $acfFields['event_email'] != '' ) {
            $performerData['event_email'] = $acfFields['event_email'];
        }
        if ( isset( $acfFields['agent_email'] ) && $acfFields['agent_email'] != '' ) {
            $performerData['agent_email'] = $acfFields['agent_email'];
        }

        $data[] = $performerData;

    }

    // var_dump($data);

    if ( empty( $posts ) ) {
        return new WP_Error( 'no_author', 'Invalid params', array( 'status' => 404 ) );
    }

    set_transient( $transient_key, $data, 2 * HOUR_IN_SECONDS );

    //return $posts[0]->post_title;
    return $data;
}
