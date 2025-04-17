<?php
function jw_events_by_date()
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

    $table_name = $wpdb->prefix . "diary";
    $events = $wpdb->get_results ( "SELECT * FROM `{$table_name}` WHERE `date` = '{$event_date}' AND `status` = 'publish'  ORDER BY `time` LIMIT 50" );

    if ($events) {

        foreach ($events as $e){
            $id = $e->id;
            $event_id = $e->event_id;
            $title = $e->title;
            $_title = $title = '' ? 'TBC' : $title;
            // is event sold out?
            $soldOutStr = strtolower($_title);
            if(strpos($soldOutStr, 'sold out') !== FALSE) {
                $btnText = 'sold out';
                $btnStyle = "style='pointer-events: none;background-color: #8f2f2a;'";
            } else {
                $btnText = 'book';
                $btnStyle = '';
            }
            $time = $e->time;
            $_time = date("g:iA", strtotime($time));
            $doors = $e->doors;
            $_doors = date("g:iA", strtotime($doors));
            $price = $e->price;
            if($price == 'FREE'){
                $cur = '';
            } else {
                $cur = '£';
            }
            $concession = $e->concession;
            if($concession == 'FREE'){
                $currency = '';
            } else {
                $currency = '£';
            }
            $ticket = $e->ticket;
            $link = get_post_permalink($event_id);




            // comedians playing
            $comediansOpen = $e->opener;
            $comediansMiddle = $e->middle;
            $comediansClose = $e->closer;
            $comediansOpenArr = json_decode($comediansOpen);
            $comediansMiddleArr = json_decode($comediansMiddle);
            $comediansCloseArr = json_decode($comediansClose);
            $comedianIDs = [];

            //TODO: if there is 1x 'celebrity' -> add 'celebreity guest' comedian post = 15163
            // if there are 2x 'celebrities' -> add 'additional celebrity' comedian post = 16554
            // if there are 3x 'celebrities' -> add 'additional celebrity' comedian post = 17648
            // if there are 4x 'celebrities' -> add 'additional celebrity' comedian post = 17649

            // push all secret comics to array
            // count array
            // if array.length = 1, push 1561 to end of comedianIDs
            // if array.length = 2, push 16554 .... etc...

            foreach ($comediansOpenArr as $com) {
                if(isset($com->open)) {
                    if($com->open === "celebrity"){
                        // add 'secret celebrity guest!' -> 15163
                        $comedianIDs[] = 15163;
                    } else {
                        $comedianIDs[] = (int) $com->comedian_id;
                    }
                } else {
                    $comedianIDs[] = (int) $com->comedian_id;
                }
            }
            foreach ($comediansMiddleArr as $com) {
                if(isset($com->open)) {
                    if($com->open === "celebrity"){
                        // add 'secret celebrity guest!' -> 15163
                        $comedianIDs[] = 15163;

                    } else {
                        $comedianIDs[] = (int) $com->comedian_id;
                    }
                } else {
                    $comedianIDs[] = (int) $com->comedian_id;
                }
            }
            foreach ($comediansCloseArr as $com) {
                if(isset($com->open)) {
                    if($com->open === "celebrity"){
                        // add 'secret celebrity guest!' -> 15163
                        $comedianIDs[] = 15163;
                    } else {
                        $comedianIDs[] = (int) $com->comedian_id;
                    }
                } else {
                    $comedianIDs[] = (int) $com->comedian_id;
                }
            }

            echo "<li class='event--item' data-event-comedians='".json_encode($comedianIDs)."'>";
            echo "<div class='event--details'>";
            echo '<h3 class="h2">'.$_title.'</h3>';
            echo '<div class="event--time">';
            echo '<span>Starts: '.$_time.'</span><span>Doors: '.$_doors.'</span>';
            echo '</div>';
            echo '<div class="event--price">';
            echo '<span class="h2">'.$cur.$price.'</span>';
            if($price != 'FREE') {
                echo '<span>Concessions: <span class="h2">' . $currency . $concession . '</span>';
            }
             echo '</span>';
            echo '</div>';
            echo '<ul class="comedians__list block-list"></ul>';
            echo '</div>';
            echo '<div class="event--ctas">';
            echo '<a href="'.$link.'" class="btn -alt">more</a>';
            if($eventIsPast){
                echo '<p>this event is finished</p>';
            } else {
                echo '<a class="btn btn--icon" href="'.$ticket.'" '.$btnStyle.'>'.$btnText.'</a>';
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
add_action('wp_ajax_jw_events_by_date', 'jw_events_by_date');
add_action('wp_ajax_nopriv_jw_events_by_date', 'jw_events_by_date');


/*
 * For each event (stored in wp_diary table), there is a column with 'comedians'. We need to make seperate calls to get each comedian post
 * */
function jw_get_comedian()
{
    $comedianID = $_POST['comedian_id'];
    $mcID = $_POST['mc_id'];
    $comedianIsMC = $comedianID === $mcID ? ' (mc)' : '';

    $arr = array(
        'post_type' => 'comedian',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post__in' => array( $comedianID ),
    );

    $comediansPosts = new WP_Query( $arr );

    if($comediansPosts->have_posts()):
        while($comediansPosts->have_posts()) : $comediansPosts->the_post();

            $ID = get_the_ID();
            $title = get_the_title();
            $object = get_post($ID);
            $name = $object->post_name;

            if($name == 'top-secret-acts-tba' || $name == 'acts-yet-to-be-confirmed' || $name == 'special-celebrity-guest'){
                $secret = '-secret';
            } else {
                $secret = '';
            }
            echo "<li class='img-text events-list__comedian " . $secret . "'>";
            echo "<a href=" . get_permalink($ID) . " class='event-comedian cover-link'></a>";
            if ($name == 'top-secret-acts-tba'):
                get_template_part('parts/content', 'topsecret-acts');
            elseif ($name == 'acts-yet-to-be-confirmed'):
                get_template_part('parts/content', 'topsecret-actstobe');
            elseif ($name == 'special-celebrity-guest' || $name == 'second-celebrity-guest'|| $name == 'third-celebrity-guest'|| $name == 'fourth-celebrity-guest' ):
                get_template_part('parts/content', 'topsecret-celebrity');
            else:
                echo "<div class='img-wrap'>";
            ?>
                    <picture>
                        <source media="(max-width: 799px)" data-srcset="<?php echo get_the_post_thumbnail_url( $ID, 'medium') ?>" />
                        <source media="(min-width: 800px)" data-srcset="<?php echo get_the_post_thumbnail_url( $ID, 'medium_large') ?>" />
                        <img src="<?php echo get_the_post_thumbnail_url( $ID, 'medium') ?>" alt="<?php echo $title; ?>" class="lazyload"/>
                    </picture>
            <?php
            echo "</div>";
            endif;
            echo "    <p>" . $title . $comedianIsMC . "</p>";
            echo "    </li>";

        endwhile;
    endif;

    exit;
}
add_action('wp_ajax_jw_get_comedian', 'jw_get_comedian');
add_action('wp_ajax_nopriv_jw_get_comedian', 'jw_get_comedian');
