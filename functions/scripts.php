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




function enqueue_vite_assets() {
    $assets_dir = get_template_directory() . '/dist/assets/';
    $assets_uri = get_template_directory_uri() . '/dist/assets/';
    $js_files  = glob( $assets_dir . 'reactevents-*.js' );
    $css_files = glob( $assets_dir . 'main-*.css' );
    if ( ! empty( $js_files ) ) {
        $js_file = basename( $js_files[0] );
        wp_enqueue_script(
            'reactevents',
            $assets_uri . $js_file,
            [],   
            null, 
            true  
        );
    }
    if ( ! empty( $css_files ) ) {
        $css_file = basename( $css_files[0] );
        wp_enqueue_style(
            'topsecret-main',
            $assets_uri . $css_file,
            [],   
            null  
        );
    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_vite_assets' );