<?php


function tickets_remaining($request)
{
    $data_array = json_decode($request->get_body());

    // Check if the provided array is not empty
    if (!empty($data_array)) {
        $response_data = array();

        foreach ($data_array as $data_object) {
            $post_id = $data_object->partners_publication_id;
            update_field('tickets_remaining', $data_object->tickets_remaining, $post_id);

            // Add each updated item to the response
            $response_data[] = array(
                'id' => $post_id,
                'link' => get_permalink($post_id),
                'tickets-remaining' => get_field('tickets_remaining', $post_id)
            );
        }

        return new WP_REST_Response($response_data, 200);
    } else {
        return new WP_Error('empty post data. Could not update tickets remaining', 'Invalid data_array provided.', array('status' => 400));
    }
}


function lastFewTickets($id)
{
    $ticketsRemaining = get_field('tickets_remaining', $id);
    $ticketsRemaining = intval($ticketsRemaining);

    if ($ticketsRemaining > 0 && $ticketsRemaining < 20) {
        return true;
    } else {
        return false;
    }
}

function noTicketsLeft($id)
{
    $ticketsRemaining = get_field('tickets_remaining', $id);
    $ticketsRemaining = intval($ticketsRemaining);

    if ($ticketsRemaining === 0) {
        return true;
    } else {
        return false;
    }
}
