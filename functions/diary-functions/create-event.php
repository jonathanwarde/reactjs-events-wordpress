<?php


function create_event($request) {

    // TODO: map 'slot' to 'position' in the database

    // Display MC on Kingsway events
    $isKingsWayEvent = false;


    $data_object = json_decode($request->get_body());

    // Check if the provided object is not empty
    if (!empty($data_object)) {
        $post_id = 0;
        $post_data = array(
            'post_title'    => !empty($data_object->title) ? $data_object->title : 'TBA',
            'post_content'  => !empty($data_object->public_blurb) ? $data_object->public_blurb : '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'event',
        );

        // If partners_publication_id exists, then it's an update operation
        if (is_null($data_object->partners_publication_id)) {
            $post_id = wp_insert_post($post_data);
        }
        // Otherwise, it's a create operation
        else {

            $post_id = $data_object->partners_publication_id;
            $post_data['ID'] = $post_id;
            wp_update_post($post_data);
        }

        // Check if the post operation was successful and update advanced custom fields
        if (!is_wp_error($post_id)) {
            if (!empty($data_object->start_time)) {
                update_field('start_time', $data_object->start_time, $post_id);
            }
            if (!empty($data_object->end_time)) {
                update_field('end_time', $data_object->end_time, $post_id);
            }

            if ( isset($data_object->sold_out) && true === $data_object->sold_out ) {
                update_field('sold_out', true, $post_id);
            } else {
                update_field('sold_out', false, $post_id);
            }

            // VENUE of event: auditorium_id
            // e2e79bb6-5dd6-4033-a050-f405b6a83871 = 107a Drury Lane in Diary, same on site
            // 5380c95c-6113-4302-9e42-2db552fec142 = 23 Kingsway, same on site
            // fdccb5b9-8263-40b1-9669-532d57d2451a = Drury Lane (Ground), 170a Drury Lane on site
            // 7680c95c-6113-4302-9e42-2db552fec142 = Drury Lane (Basement), 170a Drury Lane on site

            if ( isset($data_object->auditorium_id) && $data_object->auditorium_id == '5380c95c-6113-4302-9e42-2db552fec142' ) {
                $isKingsWayEvent = true;
                update_field('venue', 'kingsway', $post_id);
            } else if ( isset($data_object->auditorium_id) && $data_object->auditorium_id == '7680c95c-6113-4302-9e42-2db552fec142') {
                update_field('venue', 'drurylanebasement', $post_id);
            } else if ( isset($data_object->auditorium_id) && $data_object->auditorium_id == 'fdccb5b9-8263-40b1-9669-532d57d2451a') {
                update_field('venue', 'drurylaneground', $post_id);
            } else {
                update_field('venue', 'drurylane', $post_id);
            }

            //TODO:
            // 1. transform 'mc,open,middle,close' to 1,2,3,4
            // 2. sort order of performers by 1,2,3,4
            $order = ['mc' => 0, 'open' => 1, 'middle' => 2, 'close' => 3];
            $performer_ids = array();

            if (!empty($data_object->acts)) {
                $availableSecretActs = 0;

                // Initialize slots in the performer_ids array to ensure order
                foreach($order as $slotOrder) {
                    $performer_ids[$slotOrder] = array();
                }

                foreach ($data_object->acts as $act) {
                    if (!empty($act->partners_performer_id)) {
                        $slot = $act->slot;

                        if($slot == 'mc') {
                            //TODO: update ACF field 'event_mc' with the performer_id
                            update_field('event_mc', $act->partners_performer_id, $post_id);
                        }

                        if(isset($act->secret) && $act->secret === true) {
                            $availableSecretActs++;

                            //error_log('secret: count '.$availableSecretActs .' comedian id: '.$act->partners_performer_id);

                            $secretAct = getSecretCelebrityProfile($availableSecretActs);
                            //error_log('SECRET: id of ' . $availableSecretActs . ' is set for ' . $data_object->title . ' on ' . $data_object->start_time );
                            //error_log('SECRET: ACT of ' . $availableSecretActs . ' is set for ' . $data_object->title . ' on ' . $data_object->start_time );

                            // Append secret act to the slot
                            $performer_ids[$order[$slot]][] = (int) $secretAct;
                        } else {
                            //error_log('SLOT? ' . $act->slot);

                            /*if($act->slot != 'mc' && false === $isKingsWayEvent) {
                                // Append the performer to the slot
                                $performer_ids[$order[$slot]][] = (int) $act->partners_performer_id;
                            } else if (true === $isKingsWayEvent) {
                                // display mc on kingsway events only
                                $performer_ids[$order[$slot]][] = (int) $act->partners_performer_id;
                            }*/

                            if ($slot != 'mc' || $isKingsWayEvent) {
                                // Append the performer to the slot if it's not 'mc' or if it's a Kingsway event
                                $performer_ids[$order[$slot]][] = (int) $act->partners_performer_id;
                            }

                        }
                    }
                }
            }


            $flattened_performer_ids = [];
            foreach ($performer_ids as $ids) {
                foreach ($ids as $id) {
                    // this is refactored display of 'upcoming events' on each comedian page
                    addUpcomingEventsToComedian($id, $post_id);
                    $flattened_performer_ids[] = $id;
                }
            }
            ksort($flattened_performer_ids);
            // If the $performer_ids array is not empty, then update the 'performers' custom field
            if (!empty($flattened_performer_ids)) {
                // TODO: we will be replacing the ACF field 'comedians' with custom meta fields so we can easily access a position value (open, middle, close)
                // attached to each comedian id. This will allow us to easily sort the comedians in the correct order on the front end.
                // 40698, 40704
                //update_field('comedians', array(40698, 40704), $post_id);
                update_field('comedians', $flattened_performer_ids, $post_id);
                // TODO: PRETTY sure we can remove this?
                //update_comedians_meta($post_id, $performer_ids);
            } else {
                error_log('No performers found for event: ' . $post_id);
            }

            // TODO: event_price
            // TODO what format will the dates be?
            if (isset($data_object->price) || $data_object->price === 0) {
                $event_price = $data_object->price;
                update_field('event_price', $event_price, $post_id);
            }
            if (!empty($data_object->concession_price)) {
                update_field('event_concessions_price', $data_object->concession_price, $post_id);
            }
            // Build out booking link for Oscar
            // TODO: 1. Get BASE url from wp_config
            //Dev: https://oscardemo01.savoysystems.co.uk/TopSecretDemo.dll/TSelectItems.waSelectItemsPrompt.TcsWebMenuItem_1284.TcsWebTab_1285.
            //Prod: https://tickets.thetopsecretcomedyclub.co.uk/TheTopSecretComedyClub.dll/TSelectItems.waSelectItemsPrompt.TcsWebMenuItem_1284.TcsWebTab_1819.
            // Plus: TcsPerformance_<performance_id>.TcsSection_<section_id>

            if (!empty($data_object->oscar_performance_id) && !empty($data_object->oscar_section_id)) {

                $oscar_base_url = get_field('oscar_api_base_url', 'option');
                $link = $oscar_base_url . 'TcsPerformance_' . $data_object->oscar_performance_id . '.TcsSection_' . $data_object->oscar_section_id;

                update_field('book_now_url', $link, $post_id);
            }
            if (!empty($data_object->date)) {
                update_field('start_date', $data_object->date, $post_id);
            }
            // TODO: are we using end_date or is the same as start_date?
            if (!empty($data_object->date)) {
                update_field('end_date', $data_object->date, $post_id);
            }
            if (!empty($data_object->doors_time)) {
                update_field('doors_time', $data_object->doors_time, $post_id);
            }
        }

        // If the 'act' object exists in the data_object and it's an array, then process it
        if (!empty($data_object->act) && is_array($data_object->act)) {
            $performer_ids = array();

            foreach ($data_object->act as $act) {
                if (!empty($act->partners_performer_id)) {
                    $performer_ids[] = $act->partners_performer_id;
                }
            }

            // If the $performer_ids array is not empty, then update the 'comedians' custom field
            if (!empty($performer_ids)) {
                update_field('comedians', $performer_ids, $post_id);
            }
        }

        return new WP_REST_Response(array(
            'id' => $post_id,
            'link' => get_permalink($post_id),
            'sold-out' => get_field('sold_out', $post_id)

        ), 200);
    }
    else {
        return new WP_Error('empty post data!', 'Invalid data_object provided.', array('status' => 400));
    }
}


//TODO: process 'comedians' attached to event...

function update_comedians_meta($event_id, $comedians) {
    if (!is_array($comedians)) {
        error_log("update_comedians_meta called with event_id: $event_id has FAILED");
        return new WP_Error('invalid_array', 'Comedians parameter must be an array');
    }
    error_log(print_r($comedians, true));


    foreach ($comedians as $index => $comedian) {
        if (is_array($comedian) && isset($comedian['performer_id']) && isset($comedian['position'])) {
            $index += 1;

            // Update the performer_id and position meta fields
            $act = update_post_meta($event_id, "_performer_id_$index", sanitize_text_field($comedian['performer_id']));
            $actPosition = update_post_meta($event_id, "_performer_position_$index", sanitize_text_field($comedian['position']));

            error_log("update_comedians_meta called with event_id: $event_id is SUCCESS");
        } else {
            error_log("update_comedians_meta called with event_id: $event_id has FAILED");
            return new WP_Error('invalid_comedian_data', 'Each comedian must be an array with performer_id and position');
        }

        error_log("update_post_meta ID returned: " . $act);
        error_log("update_post_meta POSITION returned: " . $actPosition);
    }

    return true;
}

function getSecretCelebrityProfile($count) {

    $comedianSecretProfiles = array(
        1 =>  15163, // 'secret celebrity guest'
        2 =>  16554, // 'second celebrirty guest'
        3 =>  17648, // third celebrity guest
        4 =>  17649 // forth celebrity guest
    );

    if(array_key_exists($count, $comedianSecretProfiles)){
        error_log('getSecretCelebrityProfile: count: '.$count.' id: '.$comedianSecretProfiles[$count]);
        return $comedianSecretProfiles[$count];
    } else {
        error_log('getSecretCelebrityProfile: array key not found');
    }

}

