<?php

function create_posttype() {

    register_post_type( 'testimonial',
        array(
            'labels' => array(
                'name' => __( 'Testimonials' ),
                'singular_name' => __( 'Testimonial' )
            ),
            'public' => true,
            'rewrite' => array('slug' => 'testimonials'),
        )
    );

    register_post_type( 'comedian',
        array(
            'labels' => array(
                'name' => __( 'Comedians' ),
                'singular_name' => __( 'Comedian' )
            ),
            'public' => true,
            'rewrite' => array('slug' => 'comedians'),
        )
    );

    add_post_type_support( 'comedian', 'thumbnail' );

    register_post_type( 'event',
        array(
            'labels' => array(
                'name' => __( 'Events' ),
                'singular_name' => __( 'Event' )
            ),
            'taxonomies'  => array( 'category' ),
            'public' => true,
            'rewrite' => array('slug' => 'events-listings'),
        )
    );
}

add_action( 'init', 'create_posttype' );



function jw_register_comedian_taxonomy() {
    $labels = array(
        'name'              => _x( 'Comedian filter', 'A-Z filter' ),
        'singular_name'     => _x( 'Comedian filter', 'A-Z filter' ),
        'search_items'      => __( 'Search Comedian filters' ),
        'all_items'         => __( 'All Comedian filters' ),
        'parent_item'       => __( 'Parent Comedian filters' ),
        'parent_item_colon' => __( 'Parent Comedian filter:' ),
        'edit_item'         => __( 'Edit Comedian filter' ),
        'update_item'       => __( 'Update Comedian filter' ),
        'add_new_item'      => __( 'Add New Comedian filter' ),
        'new_item_name'     => __( 'New Comedian filter' ),
        'menu_name'         => __( 'A-Z filter' ),
    );
    $args   = array(
        'hierarchical'      => true, // make it hierarchical (like categories)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'comedian-filter' ],
    );
    register_taxonomy( 'azfilter', [ 'comedian' ], $args );
}
add_action( 'init', 'jw_register_comedian_taxonomy' );
