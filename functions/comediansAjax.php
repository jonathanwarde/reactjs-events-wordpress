<?php
function jw_filter_comedians()
{
    $catSlug = $_POST['category'];

    /*if( $catSlug != 'null' && $catSlug != 'all' ) {
        $args['tax_query'] = $catSlug;
    }*/

    $args = array(
        'post_type' => 'comedian',
        'posts_per_page' => get_option( 'posts_per_page' ),
        'post_status' => 'publish',
        'order' => 'ASC',
        'orderby' => 'title',
        'tax_query' => array(
            array(
                'taxonomy' => 'azfilter',
                'field' => 'slug',
                'terms' => array ("'.$catSlug.'")
            )
        )
    );

    $ajaxposts = new WP_Query( $args );

    $response = '';

    if ($ajaxposts->have_posts()) {
        while ($ajaxposts->have_posts()): $ajaxposts->the_post();
        $ID = get_the_ID();
        $title = get_the_title();
        $firstLetter = substr($title, 0, 1);
        ?>

        <li class='img-text' data-letter='<?php echo $firstLetter ?>'>
            <a href='<?php echo get_permalink($ID) ;?>"' class='cover-link'></a>
            <picture>
                <source media="(max-width: 799px)" data-srcset="<?php echo get_the_post_thumbnail_url( $ID, 'medium_large') ?>" />
                <source media="(min-width: 800px)" data-srcset="<?php echo get_the_post_thumbnail_url( $ID, 'medium_large') ?>" />
                <img src="<?php echo get_the_post_thumbnail_url( $ID, 'medium') ?>" alt="<?php echo $post->name ?>" class="lazyload"/>
            </picture>
            <p class='js-name'><?php echo $title ?></p>
        </li>
    <?php
        endwhile;
    } else {
        $response = '<li style="text-align: center;align-items: center;width: 100%;">Sorry, something went wrong</li>';
    }

    echo $response;
    exit;
}
add_action('wp_ajax_jw_filter_comedians', 'jw_filter_comedians');
add_action('wp_ajax_nopriv_jw_filter_comedians', 'jw_filter_comedians');
