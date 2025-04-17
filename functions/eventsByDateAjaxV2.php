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

    $date = $_POST['date'];

    $_today = new DateTime('');
    $_today->format("Y-m-d");

    if(isset($date)){
        //$event_date = '2023-04-07'; // SET AS QUERY
        $event_date = $date; // SET AS QUERY
    } else {
        //$event_date = date('Y/m/d h:i:s a', time()); // SET AS QUERY
        $event_date = $_today;
    }

    $today = new DateTime('');
    $chosenDate = new DateTime($date);
    if($today->format("Y-m-d") > $chosenDate->format("Y-m-d")) {
        $eventIsPast = true;
    } else {
        $eventIsPast = false;
    }

     $events_query_args = array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'start_date',
                'value' => $event_date,
                'compare' => '=',
                'type' => 'DATE'
            ),
            'time_clause' => array(
                'key' => 'start_time',
                'compare' => 'EXISTS',
            ),
        ),
         'orderby' => array(
             'time_clause' => 'ASC',
         ),
    );

    $events_query = new WP_Query($events_query_args);
    $events = $events_query->posts;

    if ($events) {
        // Add 'is_sold_out' to each event and create a new array to hold them
        $sorted_events = array();

        foreach ($events as $e) {
            $event_id = $e->ID;
            $soldOut = noTicketsLeft($event_id);

            // Add a new property to the event object to indicate if it's sold out
            $e->is_sold_out = $soldOut;

            $venue = get_field('venue', $event_id);
            $e->is_kingsway = ($venue === 'kingsway') ? 1 : 0;

            // Add the event to the sorted_events array
            $sorted_events[] = $e;
        }

        usort($sorted_events, function($a, $b) {
            // Sort by 'is_sold_out' first (non-sold-out events first)
            /*if ($a->is_sold_out !== $b->is_sold_out) {
                return $a->is_sold_out - $b->is_sold_out;
            }*/

            // First, sort by 'start_time'
            $timeComparison = strcmp(get_field('start_time', $a->ID), get_field('start_time', $b->ID));
            if ($timeComparison !== 0) {
                return $timeComparison;
            }

            // If both events have the same 'is_sold_out' status, sort by 'is_kingsway' (Kingsway events first)
            return $b->is_kingsway - $a->is_kingsway;
        });


        // Now loop through the sorted events
        foreach ($sorted_events as $e) {
            $event_id = $e->ID;
            $title = $e->post_title;
            $_title = $title = '' ? 'TBC' : $title;

            $soldOut = $e->is_sold_out;

            if (true === $soldOut) {
                $btnText = 'sold out';
                $btnStyle = "style='pointer-events: none;background-color: #8f2f2a;'";
            } else {
                $btnText = 'book';
                $btnStyle = '';
            }

            $time = get_field('start_time', $event_id);
            $_time = date("g:iA", strtotime($time));
            $doors = get_field('doors_time', $event_id);
            $_doors = date("g:iA", strtotime($doors));

            $price = get_field('event_price', $event_id);
            $bucketShowMessage = bucket_show_message($price);

            if (is_null($price) || $price == 'FREE' || $price == 0 || $price == '') {
                $cur = '';
                $price = 'FREE';
            } else {
                $cur = '£';
            }

            $concession = get_field('event_concessions_price', $event_id);
            if ($concession == 'FREE') {
                $currency = '';
            } else {
                $currency = '£';
            }

            if ($concession && $concession != 'FREE') {
                $concession = ''.$concession;
            } elseif (is_null($concession)) {
                $concession = 'FREE';
                $currency = '';
            } else {
                $concession = '';
            }

            $ticket = get_field('book_now_url', $event_id);
            $link = get_post_permalink($event_id);

            $restrictBooking = get_field('non_disclosure_agreement', $event_id);
            $lastFewTickets = lastFewTickets($event_id);
            $labelText = '';

            $comedianIDs = [];
            $comedians = get_field('comedians', $event_id);

            foreach ($comedians as $comedian) {
                if (isset($comedian->ID)) {
                    $comedianIDs[] = $comedian->ID;
                } else {
                    $comedianIDs[] = $comedian;
                }
            }

            $order = array(15163, 16554, 17648, 17649);
            $orderMap = array_flip($order);

            $venue = getVenuePin($event_id);
            $mc = get_field('event_mc', $event_id) ? 'data-event-mc="'.get_field('event_mc', $event_id).'"' : '';

            echo "<li class='event--item' data-event-comedians='".json_encode($comedianIDs)."' ".$mc.">";
            if ($soldOut === true) {
                echo '<div class="sold-out">sold out</div>';
            } elseif (1 == $lastFewTickets) {
                $ticketsLeft = get_field('tickets_remaining', $event_id);
                $labelText = 'only ' . $ticketsLeft . ' tickets left';
                echo '<div class="sold-out">'.$labelText.'</div>';
            }
            echo "<div class='event--details'>";
            echo '<h3 class="h2">'.$_title.$venue.'</h3>';
            echo '<div class="event--time">';
            echo '<span>Starts: '.$_time.'</span><span>Doors: '.$_doors.'</span>';
            echo '</div>';
            echo '<div class="event--price">';
            echo '<span class="h2">'.$cur.$price.'</span>';
            if ($price != 'FREE' && $price != $concession) {
                echo '<span>Concessions: <span class="h2">' . $currency . $concession . '</span>';
            }
            echo '</span>';
            echo '</div>';
            echo '<ul class="comedians__list block-list"></ul>';
            // Bucket list message on £1, £3 and FREE shows
            echo $bucketShowMessage . '<!--HEY '. gettype($price).' price '.$price.'-->';
            echo '</div>';
            echo '<div class="event--ctas">';
            echo '<a href="'.$link.'" class="btn -alt">more</a>';
            if ($eventIsPast) {
                echo '<p>this event is finished</p>';
            } else {
                if ($restrictBooking) {
                    echo '<button class="btn btn--icon js-nda-modal-trigger" data-book="'.$ticket.'">booking restricted</button>';
                } else {
                    echo '<a class="btn btn--icon" href="'.$ticket.'" '.$btnStyle.'>'.$btnText.'</a>';
                }
            }
            echo '</div>';
            echo '</li>';
        }
    } else {
        echo '<p class="h3">No events found for '.$date. '. Try again later, or <a href="/contact-us/" style="text-decoration: underline">contact us here</a></p>';
    }


    //echo $response;
    exit;
}
add_action('wp_ajax_jw_events_by_date_v2', 'jw_events_by_date_v2');
add_action('wp_ajax_nopriv_jw_events_by_date_v2', 'jw_events_by_date_v2');

