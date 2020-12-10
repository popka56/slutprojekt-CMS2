<?php

if (function_exists('acf_add_local_field_group')) :

  acf_add_local_field_group(array(
    'key' => 'group_5fc0bba4721ec',
    'title' => 'Frakt priser',
    'fields' => array(
      array(
        'key' => 'field_5fc0bbb976a83',
        'label' => 'Viktklass 1',
        'name' => 'viktklass_1',
        'type' => 'number',
        'instructions' => 'Skriv in pris för viktklass 0-3 KG',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => '',
        'max' => '',
        'step' => '',
      ),
      array(
        'key' => 'field_5fc0bc0876a84',
        'label' => 'Viktklass 2',
        'name' => 'viktklass_2',
        'type' => 'number',
        'instructions' => 'Skriv in pris för viktklass 4-8KG',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => '',
        'max' => '',
        'step' => '',
      ),
      array(
        'key' => 'field_5fc0bc3a76a85',
        'label' => 'Viktklass 3',
        'name' => 'viktklass_3',
        'type' => 'number',
        'instructions' => 'Skriv in pris för viktklass 8+KG',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => '',
        'max' => '',
        'step' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'frakt-general-settings',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));

endif;
