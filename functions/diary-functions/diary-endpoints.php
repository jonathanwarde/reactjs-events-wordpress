<?php

// TODO: PROVIDE api with key (hashed). Any requests coming to here will need to use that key
// in meantime just allow all origin

/*
 * TODO: This breaks diary app
 * */
function initCors( $value ) {
    $origin_url = '*';
    header( 'Access-Control-Allow-Origin: ' . $origin_url );
    header( 'Access-Control-Allow-Methods: GET' );
    //header( 'Access-Control-Allow-Credentials: true' );
    return $value;
}

add_action( 'rest_api_init', function () {

    //remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
    //add_filter( 'rest_pre_serve_request', initCors);

    register_rest_route( 'diary/v1', '/performers/', array(
        'methods' => 'GET',
        'callback' => 'get_comedians',
        'args' => array(
            'id' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric( $param );
                }
            ),
        ),
    ) );

    register_rest_route( 'diary/v1', '/events/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'create_event',
        'permission_callback' => '__return_true',
    ) );

    register_rest_route( 'diary/v1', '/event/', array(
        'methods' => WP_REST_Server::ALLMETHODS,
        'callback' => 'update_event',
        'args' => array(
            'event_id' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric( $param );
                }
            ),
        ),
    ) );

    register_rest_route('diary/v1', '/events/', array(
        'methods' => 'DELETE',
        'callback' => 'delete_event',
        'permission_callback' => '__return_true',
    ));

    register_rest_route('diary/v1', '/confirmation/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'email_performer',
        'permission_callback' => '__return_true',
    ));

    register_rest_route( 'diary/v1', '/tickets-remaining/', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'tickets_remaining',
        'permission_callback' => '__return_true',
    ) );

} );


function update_event( $request ) {

    $event_id = $request->get_param( 'event_id' );
    $event_data = get_requested_event( $event_id );
    if ( empty( $event_data ) ) {
        return new WP_REST_Response( [
            'message' => 'Requested event was not found with "event_id" of ' . $event_id,
        ], 400 );
    }
    return new WP_REST_Response( $event_data, 200 );

}

function get_requested_event($event_id) {
    return get_post($event_id);
}
