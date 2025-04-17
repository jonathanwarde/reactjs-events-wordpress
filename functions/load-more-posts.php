<?php

add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
add_action('wp_ajax_load_more_posts', 'load_more_posts');

function load_more_posts() {
    global $post;

    $next_page = $_POST['current_page'] + 1;
    if(isset($_POST['category'])){
        $category = sanitize_text_field($_POST['category']);
    } else {
        $category = '';
    }

    if( $category != 'null' && $category != 'all' && $category != '' ) {
        $args = array(
            'post_type' => 'comedian',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'paged' => $next_page,
            'order' => 'DESC',
            'orderby' => 'date',
            'tax_query' => array(
                array(
                    'taxonomy' => 'azfilter',
                    'field' => 'slug',
                    'terms' => array ("'.$category.'")
                )
            )
        );

    } else {
        $args = array(
            'post_type' => 'comedian',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'paged' => $next_page,
            'order' => 'DESC',
            'orderby' => 'date'
        );
    }

    $query = new WP_Query( $args );

    if($query->have_posts()):

        ob_start();

        while($query->have_posts()) : $query->the_post();

            $title = get_the_title();
            $firstLetter = substr($title, 0, 1);
            $image = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory_uri() . '/assets/images/fallbacks/fb-'. rand(1,6) .'.jpeg';
            $_image = '<img data-src="' . esc_url($image) . '" class="lazyload">';
            $url = get_post_permalink( $post->ID );?>

            <li class='img-text' data-letter='<?php echo $firstLetter ?>'>
            <a href='<?php echo get_permalink($post->ID) ;?>"' class='cover-link'></a>
            <picture>
                <source media="(max-width: 799px)" data-srcset="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium_large') ?>" />
                <source media="(min-width: 800px)" data-srcset="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium_large') ?>" />
                <img src="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium') ?>" alt="<?php echo $post->name ?>" class="lazyload"/>
            </picture>
            <p class='js-name'><?php echo $title ?></p>
            </li>

        <?php

        endwhile;

        wp_send_json_success(ob_get_clean());

    else:

        wp_send_json_error('<h4 style="padding: 30px">Either something went wrong or we are all out of comedians...</h4>');
        //echo "<h4>Either something went wrong or we are all out of comedians...</h4>";

    endif;

}
