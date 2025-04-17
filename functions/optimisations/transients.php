<?php
function jw_remove_transient_on_publish( $new, $old, $post ) {
    if( 'publish' == $new )
        delete_transient( 'jw_events_week' );
}
add_action('transition_post_status', 'jw_remove_transient_on_publish', 10, 3 );
