<?php

function delete_event($request) {
    $data_object = json_decode($request->get_body());

    if (!empty($data_object) && !empty($data_object->partners_publication_id)) {
        $id = $data_object->partners_publication_id;
        // we expect the ID to be a string (ie. "123")
        if(!is_string($id)) {
            return new WP_Error('no_post', 'Unexpected type. Expected partners_publication_id to be a string', array('status' => 404));
        }
        $postId = get_post($id); // does post with this id exist?

        if(empty($postId)) {
            return new WP_Error('no_post', 'Invalid or missing partners_publication_id..', array('status' => 404));
        } else {
            wp_delete_post($id, true); // Set second parameter to false if you wish to send it to Trash
            return new WP_REST_Response('Event with an ID of '. $id . ' has been deleted', 200);
        }
    } else {
        return new WP_Error('no_post', 'Invalid partners_publication_id', array('status' => 404));
    }
}
