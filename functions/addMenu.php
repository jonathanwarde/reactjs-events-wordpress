<?php

function register_menu() {
  register_nav_menu('main-menu',__( 'Main menu' ));
}
add_action( 'init', 'register_menu' );

function add_custom_class_to_menu_links($attributes, $item, $args) {
  if ($args->theme_location == 'main-menu') {
      $attributes['class'] = 'menu-item'; 
  }
  return $attributes;
}
add_filter('nav_menu_link_attributes', 'add_custom_class_to_menu_links', 10, 3);

