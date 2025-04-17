<?php
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key' => 'group_8739390hdidbko',
        'title' => 'Bucket show message',
        'fields' => array(
            array(
                'key' => 'field_kuhfdkjbsii3788',
                'label' => 'Bucket show message',
                'name' => 'bucket_show_message',
                'aria-label' => '',
                'type' => 'text',
                'readonly' => 0,
                'instructions' => 'Message for £1, £3 and FREE shows',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '300',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'label_placement' => 'top',
        'instruction_placement' => 'top',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ) );
} );
