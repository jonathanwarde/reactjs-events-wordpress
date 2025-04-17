<?php
/**
 * @return void
 */
function register_comedian_meta_box() {
    add_meta_box('comedian_meta_box', 'Comedians', 'comedian_meta_box_callback', 'event');
}
add_action('add_meta_boxes', 'register_comedian_meta_box');

function comedian_meta_box_callback($post) {
    wp_nonce_field('comedian_meta_box', 'comedian_meta_box_nonce');

    for($i=1; $i<=5; $i++) {
        $performer_id = get_post_meta($post->ID, "_performer_id_$i", true);
        $performer_position = get_post_meta($post->ID, "_performer_position_$i", true);

        echo "<p><label for='performer_id_$i'>Comedian $i ID</label>";
        echo "<input type='text' id='performer_id_$i' name='performer_id_$i' value='" . esc_attr($performer_id) . "' size='25' /></p>";

        echo "<p><label for='performer_position_$i'>Comedian $i Position</label>";
        echo "<input type='number' id='performer_position_$i' name='performer_position_$i' value='" . esc_attr($performer_position) . "' min='1' max='5' /></p>";
    }
}

function save_comedian_meta_box_data($post_id) {
    if(!isset($_POST['comedian_meta_box_nonce'])) {
        return;
    }

    if(!wp_verify_nonce($_POST['comedian_meta_box_nonce'], 'comedian_meta_box')) {
        return;
    }

    for($i=1; $i<=5; $i++) {
        if(isset($_POST["performer_id_$i"])) {
            update_post_meta($post_id, "_performer_id_$i", sanitize_text_field($_POST["performer_id_$i"]));
        }

        if(isset($_POST["performer_position_$i"])) {
            update_post_meta($post_id, "_performer_position_$i", sanitize_text_field($_POST["performer_position_$i"]));
        }
    }
}
add_action('save_post', 'save_comedian_meta_box_data');
