<?php
$banner_title = get_field("banner_title","options");
$banner_subtitle = get_field("banner_subtitle","options");
$front_blocks = get_field("front_blocks", "options");
get_header();
?>

<section class="flex justify-center items-center flex-col text-center relative bg-black h-[calc(100vh-200px)] ">
    <div class="z-[1] text-white">
        <h1>Comedy's worst kept secret</h1>
        <h2 id="whatson">The UK's highest rated comedy club</h2>
        <p>Top quality comedy nights every day of the week.</p>
    </div>
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/audience.jpg" class="absolute object-cover top-0 h-full z-[0]">
</section>
<section>
    <section>
    <div id="react-root"></div>
        <!--?php get_template_part('parts/content', 'whatsonnew'); ?-->
    </section>
    <?php get_template_part('parts/content', 'swiper-comedians'); ?>
    <ul>
        <?php get_template_part('parts/content', 'cta-blocks'); ?>
    </ul>
    <section>
        <p>We work tirelessly to book the best most varied stand-up comedy lineups. We have created the most intimate, atmospheric and exciting comedy club by developing and improving the space for the precise purpose of hosting stand-up comedy.</p>
        <p>Come and discover why we are the most loved Comedy Club in London, by audiences and comedians.</p>
        <p>We are supported by some of the U.K.’s best and most successful stand-up comedians. Household names regularly drop in, to soak up the atmosphere and work on new material or practice sets for T.V. or Tours. Alongside our dangerously inexpensive bar, all this adds up to explain why we have the highest-rated comedy club in the U.K. on Trip Advisor and on Google Reviews, please take a look at what 100’s of people who have visited the Club and have experienced shows have to say on TripAdvisor or Google+.</p>
        <p>We want to entertain and surprise you in the right way, not rip you off! That’s why we keep our prices as low as we possibly can and our quality equally as high. </p><p>Please book early as more and more of our shows are selling out.</p><p>We would like everyone to come and experience what we put together every day of the year. (minus Christmas eve/Christmas day/boxing day). We Look forward to seeing you soon and enjoying our stand-up comedy together with us.</p>
    </section>

<?php get_footer()?>