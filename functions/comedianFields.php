<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_58c0274738f5e',
	'title' => 'Comedian',
	'fields' => array (
		array (
			'key' => 'field_58c02760d59f6',
			'label' => 'Featured comedian',
			'name' => 'featured_comedian',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Is this a featured comedian?',
			'default_value' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'comedian',
			),
		),
	),
	'menu_order' => -1,
	'position' => 'side',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

?>