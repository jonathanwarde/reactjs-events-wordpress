<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_58be47a881db4',
	'title' => 'Events',
	'fields' => array (
		array (
			'key' => 'field_58be47b8161a6',
			'label' => 'comedians',
			'name' => 'comedians',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'comedian',
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 1,
			'return_format' => 'object',
			'ui' => 1,
		),
		array (
			'key' => 'field_58be481c161a8',
			'label' => 'start date',
			'name' => 'start_date',
			'type' => 'date_time_picker',
			'instructions' => '',
			'required' => '',
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd/m/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
	array (
			'key' => 'field_58be481c161a9',
			'label' => 'end date',
			'name' => 'end_date',
			'type' => 'date_time_picker',
			'instructions' => '',
			'required' => '',
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd/m/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
	array (
			'key' => 'field_58be481c161a166',
			'label' => 'Event price',
			'name' => 'event_price',
			'type' => 'text',
			'instructions' => '',
			'required' => '',
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			)
		),
	array (
			'key' => 'field_58be481c161a161',
			'label' => 'Concessions Price',
			'name' => 'event_concessions_price',
			'type' => 'text',
			'instructions' => '',
			'required' => '',
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			)
		),
      array (
			'key' => 'field_58be48521c16ba331a161',
			'label' => 'Doors time',
			'name' => 'doors_time',
			'type' => 'text',
			'instructions' => '',
			'required' => '',
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			)
		),
      array (
			'key' => 'field_58besgsggg2611481c161a161',
			'label' => 'Start time',
			'name' => 'start_time',
			'type' => 'text',
			'instructions' => '',
			'required' => '',
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			)
		),
	array (
			'key' => 'field_58be481c161a169',
			'label' => 'Tickets url',
			'name' => 'book_now_url',
			'type' => 'url',
			'instructions' => '',
			'required' => '',
			'conditional_logic' => '',
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			)
		)
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'event',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

?>