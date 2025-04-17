<?php

function wrapper($template){
  	
	$GLOBALS["inner"] = $template;
	
	return get_template_directory() . "/" . "wrapper.php";
	
}

add_filter( 'template_include', 'wrapper', 99);

?>