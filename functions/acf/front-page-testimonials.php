<?php
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // Add the Testimonials field group for the Options page
    acf_add_local_field_group(array(
        'key' => 'group_testimonials',
        'title' => 'Testimonials',
        'fields' => array(
            // Repeater Field for Testimonials
            array(
                'key' => 'field_testimonials',
                'label' => 'Testimonials',
                'name' => 'testimonials',
                'type' => 'repeater',
                'instructions' => 'Add testimonials for the front page.',
                'min' => 1,
                'max' => 0, // No max number of items
                'layout' => 'row',
                'button_label' => 'Add Testimonial',
                'sub_fields' => array(
                    array(
                        'key' => 'field_testimonial_quote',
                        'label' => 'Testimonial Quote',
                        'name' => 'testimonial_quote',
                        'type' => 'text',
                        'instructions' => 'Enter the testimonial quote.',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_testimonial_citation',
                        'label' => 'Testimonial Citation',
                        'name' => 'testimonial_citation',
                        'type' => 'text',
                        'instructions' => 'Enter the citation for the testimonial (e.g., name, role, etc.).',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_testimonial_image',
                        'label' => 'Testimonial Image',
                        'name' => 'testimonial_image',
                        'type' => 'image',
                        'instructions' => 'Upload an image for the testimonial.',
                        'required' => 1,
                        'return_format' => 'url', // Return the image URL
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
