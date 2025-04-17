<?php

function comediansAZ(){

    $comediansAZTransient = get_transient('jw_comedians_az');

    if(!empty($comediansAZTransient)){
        return $comediansAZTransient;
    } else {
        $allComedians = array(
            'post_type' => 'comedian',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'order' => 'ASC',
            'orderby' => 'title',
        );

        $allComediansPosts = new WP_Query( $allComedians );
        $letters = array();

        if($allComediansPosts ->have_posts()):
            while($allComediansPosts ->have_posts()) : $allComediansPosts->the_post();

                $firstLetter = substr(get_the_title(), 0, 1);
                $firstLetterUC = strtoupper($firstLetter);
                $letters[] = $firstLetterUC;

                $ID = get_the_ID();
                wp_set_object_terms($ID, array($firstLetterUC), 'azfilter');


            endwhile;
        endif;

        $uniqueLetters = array_unique($letters);
        set_transient('jw_comedians_az', $uniqueLetters, WEEK_IN_SECONDS);
        return $uniqueLetters;
    }

}


add_action( 'transition_post_status', function ( $new_status, $old_status, $post )
{

    if( 'publish' == $new_status && 'draft' == $old_status && $post->post_type == 'comedian' ) {
        global $post;
        $firstLetter = substr(get_the_title($post->ID), 0, 1);
        $firstLetterUC = strtoupper($firstLetter);
        wp_set_object_terms($post->ID, array($firstLetterUC), 'azfilter');

    }
}, 10, 3 );
