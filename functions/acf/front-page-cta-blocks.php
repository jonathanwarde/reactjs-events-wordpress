<?php
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // Add the CTA Blocks field group for the Options page
    acf_add_local_field_group(array(
        'key' => 'group_cta_blocks',
        'title' => 'CTA Blocks',
        'fields' => array(
            // Repeater Field for CTA Blocks
            array(
                'key' => 'field_cta_blocks',
                'label' => 'CTA Blocks',
                'name' => 'cta_blocks',
                'type' => 'repeater',
                'instructions' => 'Add up to 3 CTA blocks.',
                'min' => 1,
                'max' => 3, // Maximum of 3 items
                'layout' => 'row',
                'button_label' => 'Add CTA Block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_cta_title',
                        'label' => 'Title',
                        'name' => 'cta_title',
                        'type' => 'text',
                        'instructions' => 'Enter the title for the CTA block.',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_cta_description',
                        'label' => 'Description',
                        'name' => 'cta_description',
                        'type' => 'text',
                        'instructions' => 'Enter the description for the CTA block.',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_cta_link',
                        'label' => 'Link',
                        'name' => 'cta_link',
                        'type' => 'page_link',
                        'instructions' => 'Select the page to link to.',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_cta_image',
                        'label' => 'Image',
                        'name' => 'cta_image',
                        'type' => 'image',
                        'instructions' => 'Upload an image for the CTA block.',
                        'required' => 1,
                        'return_format' => 'url', // Return image URL
                        'preview_size' => 'thumbnail',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options', // Use your options page slug here
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            'editor',
        ),
        'active' => true,
        'description' => '',
        'show_in_rest' => 1,
    ));
});