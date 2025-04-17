<?php
/*
add_action( 'wpcf7_mail_sent', function( $contact_form ) {
    $submission = WPCF7_Submission::get_instance();

    if ( $submission ) {
        $data = $submission->get_posted_data();
        if (isset($data['booking-url'])) {
            $redirect_url = $data['booking-url'];
            echo '<script>document.addEventListener("DOMContentLoaded", function(){ window.location.replace("'. $redirect_url .'"); });</script>';
            exit;
        }
    }
});*/

function redirect_to_oscar_booking_page( $fields, $entry, $form_data, $entry_id ) {
    // If this is not the specific form we want, return early.
    if (absint($form_data['id']) !== 41537) { // Replace 123 with your form ID
        return;
    }

    // Use JavaScript to redirect
    echo '<script type="text/javascript">';
    // get the booking link url as previously saved in window.sessionStorage
    echo 'var url = window.sessionStorage.getItem("oscarBookingLink");';
    echo 'window.location.href=url;'; // Corrected line
    echo '</script>';
}

//add_action( 'wpforms_process_complete', 'redirect_to_oscar_booking_page', 10, 4 );



