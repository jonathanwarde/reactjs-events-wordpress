<?php

function getTestimonials(){
	
	return get_posts(
		array(
			'numberposts'	=> -1,
			'post_type'		=> 'testimonial'
			)
	);	
	
}

?>