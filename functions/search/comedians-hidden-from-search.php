<?php

function getComediansHiddenFromSearch(){

    $hiddenComediansTransient = get_transient('jw_hidden_comedians');

    if(!empty($hiddenComediansTransient)){
        return $hiddenComediansTransient;
    } else {
        $allComedians = array(
            'post_type' => 'comedian',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'hide_from_search',
                    'value' => '1',
                    'compare' => '='
                )
            )
        );

        $allComediansPosts = new WP_Query($allComedians);

        $ids = array();

        if($allComediansPosts->have_posts()):
            while($allComediansPosts->have_posts()) : $allComediansPosts->the_post();
            $ids[] = get_the_ID();
            endwhile;
        endif;
        //TODO: change to longer transient after testing
        set_transient('jw_hidden_comedians', $ids, MINUTE_IN_SECONDS);
        return $ids;
    }

}

function idsOfPostsToRemoveFromResults($query){

    $posts = $query->get_posts();
    $ids = array();
    foreach( $posts as $post ) {
        if($post->post_type == 'comedian'){
            $ids[$post->post_title] = $post->ID;
        }
    }
    $hiddenComedians = getComediansHiddenFromSearch();
    if(empty(array_intersect($hiddenComedians, $ids))){
        // search was not for a hidden comedian';
        return false;
    } else {
        return array_intersect($hiddenComedians, $ids);
    }
}

function getEventsThatContainHiddenComedian($comedianID) {
    $firstIdInArray = array_values($comedianID)[0];
    // laura smyth = 34871
    // brandon = 15133
    $comedianArgs = array(
        'post_type' => array('event'),
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'comedians',
                'value' => "$firstIdInArray",
                'compare' => 'LIKE',
            ),
        )
    );
    $query = new WP_Query( $comedianArgs );
    $posts = $query->get_posts();
    $ids = array();
    foreach( $posts as $post ) {
        $ids[$post->post_title] = $post->ID;
    }
    return $ids;
}
