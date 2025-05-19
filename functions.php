<?php

add_action('admin_head', function() {
    //if(!current_user_can('manage_options')){
        remove_action( 'admin_notices', 'update_nag',      3  );
        remove_action( 'admin_notices', 'maintenance_nag', 10 );
    //}
});

require_once get_template_directory() . '/functions/scripts.php';
require_once get_template_directory() . '/functions/addMenu.php';
require_once get_template_directory() . '/functions/cleanUp.php';
require_once get_template_directory() . '/functions/comedianFields.php';
require_once get_template_directory() . '/functions/getComediansForEvent.php';
require_once get_template_directory() . '/functions/editEventRedirect.php';
require_once get_template_directory() . '/functions/eventsFields.php';
require_once get_template_directory() . '/functions/getComedians.php';
require_once get_template_directory() . '/functions/getEvents.php';
require_once get_template_directory() . '/functions/getTestimonials.php';
require_once get_template_directory() . '/functions/includeArgs.php';
require_once get_template_directory() . '/functions/logo.php';
require_once get_template_directory() . '/functions/optionsPage.php';
require_once get_template_directory() . '/functions/pageFields.php';

require_once get_template_directory() . '/functions/postThumbnails.php';
require_once get_template_directory() . '/functions/randomImage.php';
require_once get_template_directory() . '/functions/removeComments.php';
require_once get_template_directory() . '/functions/removePosts.php';
require_once get_template_directory() . '/functions/optionsPage.php';
require_once get_template_directory() . '/functions/pageFields.php';

require_once get_template_directory() . '/functions/secretComedian.php';
require_once get_template_directory() . '/functions/titleFormatter.php';
//require_once get_template_directory() . '/functions/themeWrapper.php';
require_once get_template_directory() . '/functions/trim.php';
require_once get_template_directory() . '/functions/themeVars.php';
require_once get_template_directory() . '/functions/load-more-posts.php';
require_once get_template_directory() . '/functions/comediansAjax.php';
require_once get_template_directory() . '/functions/optimisations/transients.php';
require_once get_template_directory() . '/functions/eventsByDateAjax.php';

require_once get_template_directory() . '/functions/gtm.php';

require_once get_template_directory() . '/functions/contact-forms/non-disclosure-agreement.php';
require_once get_template_directory() . '/functions/acf/diary-app.php';
require_once get_template_directory() . '/functions/acf/sold-out.php';
require_once get_template_directory() . '/functions/acf/tickets-remaining.php';
require_once get_template_directory() . '/functions/acf/comedian-upcoming-events.php';
require_once get_template_directory() . '/functions/acf/tickets-remaining.php';
require_once get_template_directory() . '/functions/acf/venue.php';
require_once get_template_directory() . '/functions/acf/bucket-shows.php';
require_once get_template_directory() . '/functions/acf/front-page-fields.php';
require_once get_template_directory() . '/functions/acf/front-page-cta-blocks.php';
require_once get_template_directory() . '/functions/acf/front-page-testimonials.php';
require_once get_template_directory() . '/functions/acf/footer-fields.php';

/*foreach(glob(get_template_directory().'/functions/*.php') as $file) {

     include_once $file;
}*/

/*add_filter('allowed_block_types', 'my_allowed_block_types', 10, 2);
function my_allowed_block_types($allowed_blocks, $post) {
  if( is_front_page() ) {
     return array();
    }
}*/

function categories_to_posts(){

	$categories = get_categories();

	foreach($categories as $comedian){

		$existing = get_page_by_title($comedian->name, OBJECT, 'comedian');

		$args = array(
			"post_title" => $comedian->name,
			"post_type" => "comedian",
			"post_content" => $comedian->description,
			"post_status" => "publish"
			);

		if(!isset($existing)){

			// Create comedian

			wp_insert_post($args);

		} else {

			$args["ID"] = $existing->ID;

			wp_update_post($args);

		}

	}

}

add_theme_support('post-thumbnails');


if (isset($_GET['activated']) && is_admin()){
	$new_page_title = 'Diary';
	$page_check = get_page_by_title($new_page_title);
	$new_page = array(
		'post_type' => 'page',
		'post_title' => $new_page_title,
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}


if (isset($_GET['activated']) && is_admin()){
	$new_page_title = 'Diary Ajax';
	$page_check = get_page_by_title($new_page_title);
	$new_page = array(
		'post_type' => 'page',
		'post_title' => $new_page_title,
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}


if (isset($_GET['activated']) && is_admin()){
	$new_page_title = 'Confirmation For Next Week';
	$page_check = get_page_by_title($new_page_title);
	$new_page = array(
		'post_type' => 'page',
		'post_title' => $new_page_title,
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

require_once get_template_directory() . '/functions/posttypes.php';
require_once get_template_directory() . '/functions/comedians/secret-acts.php';
require_once get_template_directory() . '/functions/comedians/comediansAZ.php';
require_once get_template_directory() . '/functions/comedians/upcoming-events/set-upcoming-events.php';
require_once get_template_directory() . '/functions/comedians/upcoming-events/get-upcoming-events.php';

require_once get_template_directory() . '/functions/search/ajax-search.php';
require_once get_template_directory() . '/functions/search/comedians-hidden-from-search.php';
// New Diary related functions (2023)
require_once get_template_directory() . '/functions/diary-functions/diary-endpoints.php';
require_once get_template_directory() . '/functions/diary-functions/getcomedians.php';
require_once get_template_directory() . '/functions/diary-functions/create-event.php';
require_once get_template_directory() . '/functions/diary-functions/delete-event.php';
require_once get_template_directory() . '/functions/diary-functions/email-performer.php';
require_once get_template_directory() . '/functions/diary-functions/tickets-remaining.php';
//require_once get_template_directory() . '/functions/optimisations/queries.php';

// New theme related functions (2023) to beused with the new theme after new diary app launch
require_once get_template_directory() . '/functions/rendering-events/render-event.php';
require_once get_template_directory() . '/functions/diary-functions/amend-comedians-array-before-saving-to-event.php';
require_once get_template_directory() . '/functions/eventsByDateAjaxV2.php'; // does not query wp_diary table
require_once get_template_directory() . '/functions/rendering-events/venue.php';



