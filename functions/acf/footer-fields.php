<?php
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // Add the Footer Content field group for the Options page
    acf_add_local_field_group(array(
        'key' => 'group_footer_content',
        'title' => 'Footer Content',
        'fields' => array(
            // Footer Links (Repeater with Select for Pages/Posts)
            array(
                'key' => 'field_footer_links',
                'label' => 'Footer Links',
                'name' => 'footer_links',
                'type' => 'repeater',
                'instructions' => 'Add links for the footer.',
                'min' => 1,
                'max' => 0, // No max number of items
                'layout' => 'row',
                'button_label' => 'Add Footer Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_footer_link_page',
                        'label' => 'Select Page/Post',
                        'name' => 'footer_link_page',
                        'type' => 'post_object',
                        'instructions' => 'Select a page or post for this footer link.',
                        'required' => 1,
                        'post_type' => array('post', 'page'), // Only show Pages and Posts
                        'allow_null' => 0, // Make sure a selection is required
                        'return_format' => 'id', // Return the Post ID
                    ),
                ),
            ),
            // Company Address Field (Textarea with line breaks converted to <br>)
            array(
                'key' => 'field_company_address',
                'label' => 'Company Address',
                'name' => 'company_address',
                'type' => 'textarea',
                'instructions' => 'Enter the company address. Line breaks will automatically be converted to <br> tags.',
                'required' => 0,
                'rows' => 4, // Set the rows for the textarea
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
