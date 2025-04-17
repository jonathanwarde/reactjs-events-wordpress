<?php

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_scripts', 'print_emoji_styles');


function add_defer_attribute($tag, $handle) {
    // add script handles to the array below
    $scripts_to_defer = array('topsecret3-JS');

    foreach($scripts_to_defer as $defer_script) {
        if ($defer_script === $handle) {
            return str_replace(' src', ' defer src', $tag);
        }
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);

// add async and defer attributes to enqueued scripts
function shapeSpace_script_loader_tag($tag, $handle, $src) {

    if ($handle === 'topsecret3-JS') {
        if (false === stripos($tag, 'defer')) {
            $tag = str_replace('<script ', '<script defer ', $tag);
        }
    }
    return $tag;
}
add_filter('script_loader_tag', 'shapeSpace_script_loader_tag', 10, 3);




