<?php

$banner_title = get_field("banner_title","options");
$banner_subtitle = get_field("banner_subtitle","options");
$front_blocks = get_field("front_blocks", "options");

$strapline = get_field('frontpage_strapline', 'options') ?: 'Comedy\'s worst kept secret';
$strapline2 = get_field('frontpage_subline', 'options') ?: 'The UK\'s highest rated comedy club';
$strap_subline = get_field('strap_subline', 'options') ?: 'Top quality comedy nights every day of the week.';
$content_col_one = get_field('content_col_one', 'options') ?: '<p>We work tirelessly to book the best most varied stand-up comedy lineups...</p>'; // Default if empty
$content_col_two = get_field('content_col_two', 'options') ?: '<p>We want to entertain and surprise you in the right way...</p>'; // Default if empty

get_header();

?>

<section class="flex justify-center items-center flex-col text-center relative bg-black h-[calc(100vh-200px)] ">
    <div class="px-2 z-[1] text-white">
        <h1 class="font-heading text-2xl sm:text-5xl lg:text-6xl uppercase text-primary" id="anim-split-text-1"><?php echo esc_html($strapline); ?></h1>
        <h2 class="w-fit relative m-auto font-heading text-black" id="anim-split-text-2"><?php echo esc_html($strapline2); ?></h2>
        <p class="body-regular opacity-0 transition-opacity" id="anim-split-text-3"><?php echo esc_html($strap_subline); ?></p>
    </div>
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/audience.jpg" class="absolute object-cover top-0 h-full w-full z-[0]">
</section>
<section>
    <section>
    <div id="react-root"></div>
        <!--?php get_template_part('parts/content', 'whatsonnew'); ?-->
    </section>
    <?php get_template_part('parts/content', 'swiper-comedians'); ?>
    <?php get_template_part('parts/content', 'cta-blocks'); ?>
    <section class="bg-[var(--background-color)]  px-4 py-6 sm:px-8 sm:py-16 m-auto gap-x-4 grid grid-cols-1 m-auto max-w-7xl md:gap-x-15 md:grid-cols-2">
        <div class="flex flex-col space-y-4">
        <?php echo $content_col_one ?>
        </div>
        <div class="flex flex-col space-y-4">
        <?php echo $content_col_two ?>
        </div>
    </section>


<?php get_footer()?>