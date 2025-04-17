<?php

function fixDates(){

  $args = array(
	'posts_per_page'   => -1,
	'post_type'        => 'event',
	'post_status'      => 'publish',
	'suppress_filters' => true,
	'meta_key' => 'start_date',
    'orderby' => 'meta_value',
    'order' => 'ASC'
	);

	$events = get_posts($args);

    foreach ($events as $event){

      $start_date = new DateTime(get_field("start_date", $event->ID, false, false));
      $end_date = new DateTime(get_field("end_date", $event->ID, false, false));

      $start_time = strtotime(get_field("start_time", $event->ID, false, false));
      $end_time = strtotime(get_field("end_time", $event->ID, false, false));

      $start_hours = date('H', $start_time);
      $start_minutes = date('i', $start_time);

      $end_hours = date('H', $end_time);
      $end_minutes = date('i', $end_time);

      $start_date = date_time_set($start_date,$start_hours,$start_minutes);
      $end_date = date_time_set($end_date,$end_hours,$end_minutes);

      $start_date = date_format($start_date,"d/m/Y H:i:s");
      $end_date = date_format($end_date,"d/m/Y H:i:s");

      if($start_date && $end_date){

//        update_field("start_date", $start_date, $event->ID);
//        update_field("end_date", $end_date, $event->ID);

      }


    }

}

function getFutureEvents() {
	// Check if we have a cached version of events
	$allEvents = get_transient('all_events');

	if (!$allEvents) {
		$allEvents = getEvents(new Datetime('today'));

		// Save the data into a transient that expires in 1 hour
		set_transient('all_events', $allEvents, HOUR_IN_SECONDS);
	}

	$allEventsJSON = array();

	foreach ($allEvents as $event) {
		$allEventsJSON[] = array(
			"title" => $event->post_title . " - " . get_field("start_time", $event->ID),
			"start" => date_format($event->start_date, "Y-m-d"),
			"url" => get_permalink($event->ID),
			"time" => get_field("start_time", $event->ID)
		);
	}

	// Localize the script with new data
	wp_localize_script('myscript', 'allEvents', $allEventsJSON);
}


function getEvents($start = null, $end = null, $limit=-1, $comedian = null, $status = 'publish'){

	// Get posts

	$args = array(
		'posts_per_page'   => $limit,
		'post_type'        => 'event',
		'post_status'      => $status,
		'suppress_filters' => true,
		'meta_key' => 'start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	);

	$events = get_posts($args);

	// Add extra fields and filter if necessary

	foreach ($events as $key => &$event){

      $id = $event->ID;

      $event->start_date = new Datetime(get_field("start_date", $event->ID,false,false));

	  if(!is_null(get_field("end_date", $event->ID))){
		  $event->end_date = new Datetime(get_field("end_date", $event->ID,false,false));
	  } else {
		  $event->end_date = $event->start_date;
	  }

		if(!$event->start_date){

			unset($events[$key]);

			continue;

		}

		$event->pretty_date = date_format($event->start_date, "M j");
		$event->month = date_format($event->start_date, "M");
		$event->day = date_format($event->start_date, "d");
		$event->dayofweek = date_format($event->start_date, "D");


		$event->comedians = get_field("comedians", $id);

		if(!$event->comedians){

			$event->comedians = array();

			$categories = wp_get_post_categories($event->ID,array("fields"=>"names"));

			foreach ($categories as $oldComedian){

				$newComedian = get_page_by_title($oldComedian, OBJECT, 'comedian');

				if(isset($newComedian)){

					$event->comedians[] = $newComedian;

				}

			}

		}

		if($event->start_date < $start || ($end && $event->start_date > $end)){

      unset($events[$key]);
      continue;

		}

		if($comedian){

      $valid = false;

			foreach ($event->comedians as $item){

				if($item->post_title === $comedian){

					$valid = true;

				}

			}

			if($valid === false){

				unset($events[$key]);

			}

		}

	}

    usort($events, function ($a,$b){

      if($a->start_date > $b->start_date){

        return 1;

      } elseif ($a->start_date < $b->start_date){

        return -1;

      } else {

        $a->start_time = preg_replace("/[^0-9]/", "", get_field("start_time",$a->ID));
        $b->start_time = preg_replace("/[^0-9]/", "", get_field("start_time",$b->ID));

        if($a->start_time > $b->start_time){

          return 1;

        } elseif ($a->start_time < $b->start_time){

          return -1;

        } else {

          return 0;

        }

      }

    });

    return $events;

}

/*
 * TODO: Jon - can we cache this in a transient?
 * */
function getEventsWeek(){

	$eventsTransient = get_transient('jw_events_week');

	if(!empty($eventsTransient)){
		return $eventsTransient;
	} else {
		$events = getEvents(new Datetime('today'), new Datetime('today + 7 days'));
		set_transient('jw_events_week', $events, HOUR_IN_SECONDS);
		return $events;
	}

	//return getEvents(new Datetime('today'), new Datetime('today + 7 days'));

}

function getEventsToday(){

	$eventsTransient = get_transient('jw_events_today');

	if(!empty($eventsTransient)){
		return $eventsTransient;
	} else {
		$events = getEvents(new Datetime('today'), new Datetime('today'));
		set_transient('jw_events_today', $events, HOUR_IN_SECONDS);
		return $events;
	}

	//return getEvents(new Datetime('today'), new Datetime('today + 7 days'));

}

function getEventsDay($day){

  $day->setTime(0, 0);

  $next = clone $day;

  return getEvents($day,$next);

}

function getPriceString($id){

		// Get prices

	$standardPrice = get_field("event_price", $id);
	$concessionsPrice = get_field("event_concessions_price", $id);

	if(isset($standardPrice)){

		$pricesOutput = "<span class='event-prices'><span>Price: ";


		if(is_numeric($standardPrice)){

			$pricesOutput .= "<em>£";

		}

		$pricesOutput .= $standardPrice . '</em></span>';

		if(isset($concessionsPrice) && $concessionsPrice !== $standardPrice){

			$pricesOutput .= "<span>Concesssion: ";

			if(is_numeric($concessionsPrice)){

			$pricesOutput .= "<em>£";
		}

		$pricesOutput .= $concessionsPrice . '</em></span>';

		}

		$pricesOutput .= "</span>";
		return $pricesOutput;
	}

	}

?>
