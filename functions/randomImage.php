<?php

function randomImage($width=100,$height=100,$print=true){
	
	$image = "//lorempixel.com/".$width."/".$height."/?" . rand(0,1024);
	
	if($print){
	
		print $image;
		
	}
		
	return $image;
}

?>