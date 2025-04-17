<?php
function addUpcomingEventsToComedian($comedianId, $upcomingEvent) {
    $existingEventsString = get_field("comedian_upcoming_event_ids", $comedianId);
    $updatedEventsString = $existingEventsString;

    if (!empty($upcomingEvent)) {
        if (!empty($existingEventsString)) {
            $updatedEventsString .= ",";
        }
        $updatedEventsString .= $upcomingEvent;
    }
    update_field("comedian_upcoming_event_ids", $updatedEventsString, $comedianId);
}

