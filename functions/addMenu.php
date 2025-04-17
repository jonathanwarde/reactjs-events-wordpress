<?php

function register_menu() {
  register_nav_menu('main-menu',__( 'Main menu' ));
}
add_action( 'init', 'register_menu' )
	
?>