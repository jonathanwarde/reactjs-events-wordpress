<?php
    function dm_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    }
    add_action( 'wp_enqueue_scripts', 'dm_remove_wp_block_library_css' );
