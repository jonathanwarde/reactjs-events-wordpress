<?php
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }
    acf_add_local_field_group( array(
        'key' => 'group_64f6e0c4c5c80',
        'title' => 'Diary app',
        'fields' => array(
            array(
                'key' => 'field_64f6e0c52db16',
                'label' => 'Oscar API base URL',
                'name' => 'oscar_api_base_url',
                'aria-label' => '',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'https://oscardemo01.savoysystems.co.uk/TopSecretDemo.dll/TSelectItems.waSelectItemsPrompt.TcsWebMenuItem_1284.TcsWebTab_1285.' => 'dev',
                    'https://tickets.thetopsecretcomedyclub.co.uk/TheTopSecretComedyClub.dll/TSelectItems.waSelectItemsPrompt.TcsWebMenuItem_1284.TcsWebTab_1819.' => 'prod',
                ),
                'default_value' => false,
                'return_format' => 'value',
                'multiple' => 0,
                'allow_null' => 0,
                'ui' => 0,
                'ajax' => 0,
                'placeholder' => '',
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
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ) );
} );

