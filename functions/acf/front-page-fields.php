<?php
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // Add the field group
    acf_add_local_field_group(array(
        'key' => 'group_front_page',
        'title' => 'Front Page Content',
        'fields' => array(
            // Strapline Field
            array(
                'key' => 'field_strapline',
                'label' => 'Strapline',
                'name' => 'frontpage_strapline',
                'type' => 'text',
                'instructions' => 'Enter the main strapline for the front page.',
                'default_value' => 'Comedy\'s worst kept secret', // Default value
                'required' => 0,
            ),
            array(
                'key' => 'field_subline',
                'label' => 'Subline',
                'name' => 'frontpage_subline',
                'type' => 'text',
                'instructions' => 'Enter the main subline for the front page.',
                'default_value' => 'The UK\'s highest rated comedy club', // Default value
                'required' => 0,
            ),
            // Strap Subline Field
            array(
                'key' => 'field_strap_subline',
                'label' => 'Strapline Subline',
                'name' => 'strap_subline',
                'type' => 'text',
                'instructions' => 'Enter the strapline subtext for the front page.',
                'default_value' => 'Top quality comedy nights every day of the week.', // Default value
                'required' => 0,
            ),
            // Content Column One (WYSIWYG Editor)
            array(
                'key' => 'field_content_col_one',
                'label' => 'Content Column One',
                'name' => 'content_col_one',
                'type' => 'wysiwyg',
                'instructions' => 'Enter the content for the first column.',
                'default_value' => '<p>We work tirelessly to book the best most varied stand-up comedy lineups. We have created the most intimate, atmospheric and exciting comedy club by developing and improving the space for the precise purpose of hosting stand-up comedy.</p>
                                    <p>Come and discover why we are the most loved Comedy Club in London, by audiences and comedians.</p>
                                    <p>We are supported by some of the U.K.’s best and most successful stand-up comedians. Household names regularly drop in, to soak up the atmosphere and work on new material or practice sets for T.V. or Tours. Alongside our dangerously inexpensive bar, all this adds up to explain why we have the highest-rated comedy club in the U.K. on Trip Advisor and on Google Reviews, please take a look at what 100’s of people who have visited the Club and have experienced shows have to say on TripAdvisor or Google+.</p>',
                'new_lines' => 'wpautop', // Automatically add paragraphs
                'required' => 0,
            ),
            // Content Column Two (WYSIWYG Editor)
            array(
                'key' => 'field_content_col_two',
                'label' => 'Content Column Two',
                'name' => 'content_col_two',
                'type' => 'wysiwyg',
                'instructions' => 'Enter the content for the second column.',
                'default_value' => '<p>We want to entertain and surprise you in the right way, not rip you off! That’s why we keep our prices as low as we possibly can and our quality equally as high. </p>
                                    <p>Please book early as more and more of our shows are selling out.</p>
                                    <p>We would like everyone to come and experience what we put together every day of the year. (minus Christmas eve/Christmas day/boxing day). We Look forward to seeing you soon and enjoying our stand-up comedy together with us.</p>',
                'new_lines' => 'wpautop', // Automatically add paragraphs
                'required' => 0,
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
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            'editor', // Hide the default content editor
        ),
        'active' => true,
        'description' => '',
        'show_in_rest' => 1,
    ));
});

add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_6808d807a390c',
	'title' => 'testing',
	'fields' => array(
		array(
			'key' => 'field_6808d80755944',
			'label' => 'testing',
			'name' => 'testing',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
	),
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );

