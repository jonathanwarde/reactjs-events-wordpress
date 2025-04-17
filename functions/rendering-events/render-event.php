<?php

function get_field_for_post($field, $post_id)
{
    return get_field($field, $post_id, false, false);
}

function render_comedian($id)
{
    //TODO: rather than making a query for each comedian, make one query for all comedians?
    $comedian = get_post($id);

    $secret = $comedian->post_name === 'top-secret-acts-tba' ? '-bg-black' : '';
    $permalink = get_permalink($comedian->ID);
    $title = $comedian->post_title;
    $image_src = get_the_post_thumbnail_url($comedian->ID, 'large');

    echo "<li class='img-text events-list__comedian {$secret}'>";

    echo "<a href='{$permalink}' class='event-comedian cover-link'></a>";
    if ($comedian->post_name === 'top-secret-acts-tba') {
        get_template_part('parts/content', 'topsecret-acts');
    } elseif ($comedian->post_name === 'acts-yet-to-be-confirmed') {
        get_template_part('parts/content', 'topsecret-actstobe');
   // } elseif ($comedian->post_name === 'special-celebrity-guest' || $comedian->post_name === 'second-celebrity-guest') {
    } elseif (str_contains($comedian->post_name, 'celebrity')) {
        get_template_part('parts/content', 'topsecret-celebrity');
    } else {
        echo "<div class='img-wrap'>";
        echo "<img data-src='{$image_src}' class='lazyload'>";
        echo "</div>";
    }
    echo "<p>{$title}</p>";
    echo "</li>";
}
$bucketShowMessageAndMarkup = file_get_contents(get_template_directory().'/parts/bucket-message.php');
function get_bucket_show_message($price){
    $free = is_null($price) || $price == 'FREE' || $price == 0 || $price == '';
    if($free || $price == '1' || $price == '3') {
        $bucketShowMessageAndMarkup = file_get_contents(get_template_directory() . '/parts/bucket-message.php');
        if($bucketShowMessageAndMarkup !== false) {
            return $bucketShowMessageAndMarkup;
        }
    }
    return false;
}
function render_event($post, $singleEventPage = false)
{
    $start_date = new DateTime(get_field_for_post("start_date", $post->ID));
    $doors_time = new DateTime(get_field_for_post("doors_time", $post->ID));

    //$start_time = get_field_for_post("start_time", $post->ID);
    $start_time = new DateTime(get_field_for_post("start_time", $post->ID));

    $book_url = get_field_for_post("book_now_url", $post->ID);
    $post_url = get_permalink($post->ID);
    $post_title = $post->post_title;
    $restrictBooking = get_field('non_disclosure_agreement', $post->ID);

    // is event sold out?
    $soldOut = noTicketsLeft($post->ID);
    $lastFewTickets = lastFewTickets($post->ID);
    $labelText = '';

    if(true === $soldOut) {
        $btnText = 'sold out';
        $btnStyle = "style='pointer-events: none;background-color: #8f2f2a;'";
    } elseif(1 == $lastFewTickets) {
        $ticketsLeft = get_field('tickets_remaining', $post->ID);
        $labelText = 'only ' . $ticketsLeft . ' tickets left';
        $btnText = 'book';
        $btnStyle = '';
    } else {
        $btnText = 'book';
        $btnStyle = '';
    }

    echo '<ul id="event-container" class="events-list width-md">';
    if(true === $singleEventPage) {
        echo "<li class='event--item'>";
        if($soldOut === true) {
            echo '<div class="sold-out">sold out</div>';
        }
        if($lastFewTickets == 1) {
            echo '<div class="sold-out">'.$labelText.'</div>';
        }
        echo '<div class="events-list__item-details">';
        $price = get_field('event_price', $post->ID);
        $concession_price = get_field('event_concessions_price', $post->ID);

        if($concession_price && $concession_price != 'FREE'){
            $concession_price = 'Concessions: £'.$concession_price;
        } elseif(is_null($concession_price)) {
            $concession_price = 'Concessions: FREE';
        } else {
            $concession_price = '';
        }

        if(is_null($price) || $price == 'FREE' || $price == 0 || $price == ''){
            $cur = '';
            $price = 'FREE';
        } else {
            $cur = '£';
        }

        if($concession_price == 'FREE'){
            $currency = '';
        } else {
            $currency = '£';
        }

        $venue = getVenuePin($post->ID);

        echo '<div class="event--time"><span class="h4">'.$start_date->format('F j').  ', '.$start_time->format('g:i a').$venue.'</span><span class="h4">Doors: '.$doors_time->format("g:i a").'</span></div>';

        echo '<div class="event--price"><span class="h2">'.$cur.$price.'</span><span><span class="h2">'.$concession_price.'</span></span></div>';
        echo '<div class="event--ctas">';
            if($restrictBooking):
                echo '<button class="btn js-nda-modal-trigger -single" data-book="'.$book_url.'">booking restricted</button>';
            else:
                echo '<a class="btn" href="'.$book_url.'" '.$btnStyle.'>'.$btnText.'</a>';
            endif;
        echo '</div>';

    } else {
        echo "<li class='events--item border-top'>";
        echo '<div class="events-list__item-details">';

        echo '<time class="events-list__weekday">'.$start_date->format("l").'<span class="events-list__time-day h1">'.$start_date->format("j").'</span><span class="events-list__month">'.$start_date->format("M").'</span></time>';
        echo '<span class="events-list__time">'.$start_time.'</span>';
        echo '<span class="events-list__time -doors"><em>doors</em>'.$doors_time->format("g:i a").'</span>';
        echo '<a href="'.$post_url.'" class="events-list__title">'.$post_title.'</a>';

            if($restrictBooking):
                echo '<button class="btn events-list__cta btn--icon js-nda-modal-trigger" data-book="'.$book_url.'">booking restricted</button>';
            else:
                echo '<a href="'.$book_url.'" class="btn events-list__cta btn--icon"><span>book</span><svg class="icon icon-arrow icon--dark"><use href="#icon-arrow" /></svg></a>';
            endif;

    }
    echo '</div>';

    echo '<ul class="comedians__list block-list">';

    $comedians = get_field("comedians", $post->ID);
    foreach ($comedians as $comedian) {
        render_comedian($comedian);
    }

    echo '</ul><div>';
    if(true === $singleEventPage) {
        $bucketShowMessage = get_bucket_show_message($price);
        $content = get_the_content($post->ID);
        // this fixes bug where users are adding non closing <b> tags to the content via app which breaks layout
        //$content = preg_replace('/<\/?b>/', '', $content);
        $content = preg_replace('/<br(\s+)?\/?>/i', '', $content);
        echo nl2br($content);
        echo $bucketShowMessage;
    }
    echo "</div></li>";
    echo "</ul>";
}

// Instead of using the global $post variable, we pass it as an argument to the function
function process_post($post, $singleEventPage = false)
{
    $post->start_date = new DateTime(get_field_for_post("start_date", $post->ID));
    $post->end_date = new DateTime(get_field_for_post("end_date", $post->ID));
    $post->comedians = get_field("comedians", $post->ID);

    // You may want to add error checking here to make sure the values are retrieved correctly

    render_event($post, $singleEventPage);
}
