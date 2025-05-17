<?php
$bucketShowMessageAndMarkup = file_get_contents(get_template_directory().'/parts/bucket-message.php');
function bucket_show_message($price){
    $free = is_null($price) || $price == 'FREE' || $price == 0 || $price == '';
    if($free || $price == '1' || $price == '3') {
        $bucketShowMessageAndMarkup = file_get_contents(get_template_directory() . '/parts/bucket-message.php');
        if($bucketShowMessageAndMarkup !== false) {
            return $bucketShowMessageAndMarkup;
        }
    }
    return false;
}

function jw_events_by_date_v2()
{
    global $wpdb;

    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : null;

    // Determine if the requested date is in the past
    $today        = new DateTime('');
    $chosenDate   = $date ? new DateTime($date) : $today;
    $eventIsPast  = ($today->format("Y-m-d") > $chosenDate->format("Y-m-d"));

    // Use the provided date or default to today
    $event_date = $date ?: $today->format("Y-m-d");

    $events_query_args = array(
        'post_type'      => 'event',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'start_date',
                'value'   => $event_date,
                'compare' => '=',
                'type'    => 'DATE'
            ),
            'time_clause' => array(
                'key'     => 'start_time',
                'compare' => 'EXISTS',
            ),
        ),
        'orderby' => array(
            'time_clause' => 'ASC',
        ),
    );

    $events_query   = new WP_Query($events_query_args);
    $events         = $events_query->posts;
    $response_events = [];

    if ($events) {
        // Enrich events
        foreach ($events as $e) {
            $e->is_sold_out = noTicketsLeft($e->ID);
            $e->is_kingsway = (get_field('venue', $e->ID) === 'kingsway') ? 1 : 0;
            $e->venue = getVenuePin($e->ID);
        }

        // Sort by time, then kingsway
        usort($events, function($a, $b) {
            $timeA = get_field('start_time', $a->ID);
            $timeB = get_field('start_time', $b->ID);
            $cmp   = strcmp($timeA, $timeB);
            if ($cmp !== 0) {
                return $cmp;
            }
            return $b->is_kingsway - $a->is_kingsway;
        });

        // Build JSON-friendly array
        foreach ($events as $e) {
            $event_id   = $e->ID;
            $time       = get_field('start_time', $event_id);
            $doors      = get_field('doors_time', $event_id);
            $price      = get_field('event_price', $event_id);
            $concession = get_field('event_concessions_price', $event_id);

            // Normalize price
            if (is_null($price) || $price === 'FREE' || $price == 0 || $price === '') {
                $price    = 'FREE';
                $currency = '';
            } else {
                $currency = '£';
            }

            // Normalize concession
            if ($concession === 'FREE' || is_null($concession)) {
                $concession      = 'FREE';
                $conc_currency   = '';
            } else {
                $conc_currency = '£';
            }

            // Comedian IDs
            $comedianIDs = [];
            foreach ((array) get_field('comedians', $event_id) as $comedian) {
                $comedianIDs[] = is_object($comedian) ? $comedian->ID : $comedian;
            }

            $response_events[] = [
                'id'                   => $event_id,
                'title'                => $e->post_title ?: 'TBC',
                'start_time'           => date('g:ia', strtotime($time)),
                'doors_time'           => date('g:ia', strtotime($doors)),
                'price'                => $price,
                'currency'             => $currency,
                'concession'           => $concession,
                'concession_currency'  => $conc_currency,
                'is_sold_out'          => (bool) $e->is_sold_out,
                'is_kingsway'          => (bool) $e->is_kingsway,
                'ticket_url'           => get_field('book_now_url', $event_id),
                'permalink'            => get_permalink($event_id),
                'venue'                => get_field('venue', $event_id),
                'comedians'            => $comedianIDs,
                'nda_restricted'       => (bool) get_field('non_disclosure_agreement', $event_id),
                'last_few_tickets'     => (bool) lastFewTickets($event_id),
            ];
        }
    }

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode([
        'date_requested' => $event_date,
        'is_past'        => $eventIsPast,
        'events'         => $response_events,
    ], JSON_PRETTY_PRINT);
    exit;
}
add_action('wp_ajax_jw_events_by_date_v2', 'jw_events_by_date_v2');
add_action('wp_ajax_nopriv_jw_events_by_date_v2', 'jw_events_by_date_v2');