<?php
/**
 *  DIARY APP needs to send EVENT ID, and PERFORMER ID,
 * using those, send an email to performer. Email body needs event details and 1x link to confirm, 1x link to cancel
 * @param $request
 * @return WP_Error|WP_REST_Response
 */
function email_performer($request) {
    // Dont send emails to actual performers when testing
    $TESTING = true;
    $TEST_EMAIL = 'jonwarde@gmail.com';
    $TEST_EMAIL_CC = 'duncanevanmacleod@gmail.com';
    //$CUR_DOMAIN = $_SERVER['HTTP_HOST'];
    $CUR_DOMAIN = 'https://thetopsecretcomedyclub.co.uk/';

    $data_object = json_decode($request->get_body());

    if (!empty($data_object) &&
        !empty($data_object->partners_performer_id) &&
        !empty($data_object->partners_publication_id)
    ) {
        error_log('email_performer: data_object: '. print_r($data_object, true));
        $id = $data_object->partners_publication_id;
        $performer_id = $data_object->partners_performer_id;

        // we expect the ID to be a string (ie. "123")
        if(!is_string($id) || !is_string($performer_id)) {
            return new WP_Error('no_post', 'Unexpected type. Expected id to be a string', array('status' => 404));
        }
        $postId = get_post($id); // does post with this id exist?

        if(empty($postId)) {
            return new WP_Error('no_post', 'No published event with this ID found..', array('status' => 404));
        } else {
            if(true === $TESTING) {
                $performer_email = $TEST_EMAIL;
                $agent_email = $TEST_EMAIL_CC;
            } else {
                $performer_email = get_field('comedian_email', $performer_id);
                $agent_email = get_field('agent_email', $performer_id);
            }

            $cancelOrConfirmLink = $CUR_DOMAIN. '/booking-confirmation-or-cancellation/?event_id='. $id .'&performer_id='. $performer_id;

            $subject = esc_html('Confirmation for tonights spot');
            $eventTime = get_field('start_time', $id);
            $allowed_html = array(
                'a' => array(
                    'href' => array(),
                ),
            );
            $bodyEmail = wp_kses('Hi There, This is your confirmation for this evening\'s spot. DO NOT REPLY TO THIS EMAIL!! please <a href="'.$cancelOrConfirmLink.'&confirm=true">CLICK HERE TO CONFIRM</a> or <a href="'.$cancelOrConfirmLink.'&cancel=true">CLICK HERE TO CANCEL</a> your spot, the approximate time of your spot will be '. $eventTime .'  please get there 15 mins before cos we run early sometimes, thanks so much see you this eve... (or not... just cancel also by clicking the link and cancelling)', $allowed_html);

            // send email to performer
            $emailSent = sendEmail($performer_email, $subject, $bodyEmail, $agent_email);

            if($emailSent){
                error_log('email_performer: email sent to performer: '. $performer_email);
                return new WP_REST_Response('Performer has been emailed', 200);
            } else {
                error_log('email_performer: email failed to send to performer: '. $performer_email);
                return new WP_Error('no_post', 'Email failed to send', array('status' => 404));
            }

        }
    } else {
        return new WP_Error('no_post', 'Invalid or missing partners_publication_id and/or partners_performer_id', array('status' => 404));
    }
}

/**
 * with WP SMTP plugin installed, this will send ALL EMAILS via SMTP, and so will hijack the wp_mail function
 * @return void
 */
function sendEmail( $recipient, $subject, $emailbody, $ccAddress ) {
    $to = $recipient;
    $subject = $subject;
    $body = $emailbody;
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Cc: '. $ccAddress
    );

    return wp_mail( $to, $subject, $body, $headers );
}

function sendConfirmationOrCancellationNoticeToDiaryApp($event_id, $performer_id, $confirm = null, $cancel = null) {

    $data = array(
        'act_id' => $event_id,
        'performer_id' => $performer_id
    );

    if(!is_null($confirm) && is_null($cancel)){
        if(isset($data['act_id'])){
            $actId = $data['act_id'];
            $url = 'http://tfmc.sytes.net/api/acts/'.$actId.'/confirm';
        }
    } elseif(!is_null($cancel) && is_null($confirm)){
        if(isset($data['act_id'])){
            $actId = $data['act_id'];
            $url = 'http://tfmc.sytes.net/api/acts/'.$actId.'/cancel';
        }
    } else {
        return false;
    }

    $options = array(
        'method' => 'POST',
        //'body' => json_encode($data),
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    );

    $response = wp_remote_post($url, $options);
    $response_code = wp_remote_retrieve_response_code($response);
    $response_message = wp_remote_retrieve_response_message($response);

    if ($response_code != 200) {
        echo 'Error: ' . $response_message;
        debug_log('EMAIL CONFIRMATION ERROR: ' . $response_message);
    } else {
        echo 'Success: ' . $response_message;
        debug_log('EMAIL CONFIRMATION SUCCESS: ' . $response_message);
    }

}
