<?php
if(true) {
    include_once('parts/cta-link-to-available-events.php');
} else {
    include_once('parts/cta-book.php');
}
?>
</main>
   
<section class="swiper testimonials-slider bg-gray-800 text-center overflow-hidden">
  <ul class="swiper-wrapper p-0" style="padding:0">
    <li class="swiper-slide">
      <div class="testimonials__item h-[60vh] max-h-[500px] ">
        <div class="testimonials-slider__img-wrap relative overflow-hidden  w-full h-full inline-flex">
          <!-- Image with gradient overlay -->
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/jw-home.jpg" loading="lazy" class="w-full h-full object-cover object-top transition-all duration-300 ease-in-out transform scale-125 " />
        </div>
        <!-- Blockquote with centered text -->
        <blockquote class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full z-10 max-w-full mx-auto">
          <p class="font-regular-light mb-4 p-0 text-2xl sm:text-4xl text-white">Top Secret is one of London’s best comedy clubs, it won’t be secret for long!</p>
          <cite class="font-heading text-white text-2xl text-white bg-primary transform rotate-[-3deg] inline-flex py-1 px-2">Jack Whitehall</cite>
        </blockquote>
      </div>
    </li>

    <li class="swiper-slide">
      <div class="testimonials__item h-[60vh] max-h-[500px] ">
        <div class="testimonials-slider__img-wrap relative overflow-hidden  w-full h-full inline-flex">
          <!-- Image with gradient overlay -->
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/tn.jpg" loading="lazy" class="w-full h-full object-cover object-top transition-all duration-300 ease-in-out transform scale-125 " />
        </div>
        <!-- Blockquote with centered text -->
        <blockquote class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full z-10 max-w-full mx-auto">
          <p class="font-regular-light mb-4 p-0 text-2xl sm:text-4xl text-white">Dude I had a blast. Favourite room in London.</p>
          <cite class="font-heading text-white text-2xl bg-primary transform rotate-[-3deg] inline-flex py-1 px-2">Trevor Noah</cite>
        </blockquote>
      </div>
    </li>

    <li class="swiper-slide">
      <div class="testimonials__item h-[60vh] max-h-[500px] ">
        <div class="testimonials-slider__img-wrap relative overflow-hidden  w-full h-full inline-flex">
          <!-- Image with gradient overlay -->
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sw-pic.jpg" loading="lazy" class="w-full h-full object-cover object-top transition-all duration-300 ease-in-out transform scale-125 " />
        </div>
        <!-- Blockquote with centered text -->
        <blockquote class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full z-10 max-w-full mx-auto">
          <p class="font-regular-light mb-4 p-0 text-2xl sm:text-4xl text-white">Without a doubt my favourite London Club. It's my home.</p>
          <cite class="font-heading text-white text-2xl bg-primary transform rotate-[-3deg] inline-flex py-1 px-2">Seann Walsh</cite>
        </blockquote>
      </div>
    </li>
  </ul>
</section>

    <footer class="bg-primary">
      <section class="footer gap-4 grid grid-cols-1 m-auto max-w-7xl md:gap-10 md:grid-cols-3 px-4 py-6 sm:px-8 sm:py-16">
        <div>
            <h2 class="font-heading pb-8 text-2xl">Quick links</h2>
            <ul>
                <li><a href="/about">About</a></li>
                <li><a href="/terms-conditions">T's&C's</a></li>
                <li><a href="/privacy-policy/">Privacy Policy</a></li>
                <li><a href="/top-secret-membership/">Members</a></li>
                <li><a href="/faqs">FAQs</a></li>
            </ul>

        </div>
        <div>
            <h2 class="font-heading pb-8 text-2xl">Contact</h2>
          <p>
            <b>The Top Secret Comedy Club</b>
            <br /> 170 Drury Lane
            <br /> London,
            <br /> WC2B 5PD
            <br />
          </p>

          <br />
          <a href="/privacy-policy">Privacy Policy</a>

        </div>
        <div>
        <h2 class="font-heading pb-8 text-2xl">Keep in touch</h2>

          <!-- Begin Mailchimp Signup Form -->
          <style type="text/css">
            #mc_embed_signup{clear:left; font-size:14px; }
          </style>
          <div id="mc_embed_signup">
          <form action="https://thetopsecretcomedyclub.us4.list-manage.com/subscribe/post?u=92a5250ef923a5fa1b1c2f53b&amp;id=620acfbee5" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" novalidate>
              <div id="mc_embed_signup_scroll">
            <label for="mce-EMAIL">Subscribe to our mailing list</label>
            <input type="email" value="" name="EMAIL" id="mce-EMAIL" placeholder="email address" required>
              <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
              <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_92a5250ef923a5fa1b1c2f53b_620acfbee5" tabindex="-1" value=""></div>
              <div><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"></div>
              </div>
          </form>
          </div>
          <!--End mc_embed_signup-->

          <div class="flex gap-4 my-4">

            <a href="https://www.facebook.com/topsecretcomedy" class="w-12"><img src="<?=get_template_directory_uri()?>/images/facebook.svg" loading="lazy" /></a>
            <a href="https://www.instagram.com/topsecretcomedy/?hl=en" class="w-12"><img src="<?=get_template_directory_uri()?>/images/instagram.svg" loading="lazy"/></a>
            <a href="https://plus.google.com/+ThetopsecretcomedyclubUk" class="w-12"><img src="<?=get_template_directory_uri()?>/images/googleplus.svg" loading="lazy" /></a>
            <a href="https://twitter.com/topsecretcomedy" class="w-12"><img src="<?=get_template_directory_uri()?>/images/twitter.svg" loading="lazy" /></a>

          </div>

        </div>

      </section>
        <div class="footer gap-4 grid grid-cols-1 m-auto max-w-7xl md:gap-10 md:grid-cols-3 px-4 py-6 sm:px-8 sm:py-16">
            <img src="https://thetopsecretcomedyclub.co.uk/web/wp-content/uploads/2020/09/TSCC-LOGO-V2-e1599317839851.png" loading="lazy" />
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/tripadvisor2022.png" style="width: 56px; margin: 0 60px">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/google-reviews.png" loading="lazy">
        </div>
    </footer>
    <div id="datafetch"></div>
    </div><!--end site-wap__inner-->
    </div><!--end site-wap__outer-->
    <?php include_once('images/svg/icon-sprite.svg');

     wp_footer();
    ?>

        <script>
            function tabs() {
                console.log("TABS footer script run...");

                const tabsContainer = Array.from(
                    document.querySelectorAll(".tabs-container")
                );

                if (!tabsContainer) {
                    return;
                }

                tabsContainer.forEach((tabContainer) => {
                    const tabsTab = Array.from(tabContainer.querySelectorAll(".tabs-tab"));

                    const contentAreas = Array.from(
                        tabContainer.querySelectorAll(".tabs-content")
                    );


                    tabsTab.forEach((tab) => {
                        tab.addEventListener("click", (e) => {
                            e.cancelBubble = true;

                            tabsTab.forEach((tab) => {
                                tab.classList.remove("-current");
                            });

                            tab.classList.add("-current");

                            const dataTab = tab.getAttribute("data-tab");

                            console.log('TAB', dataTab);

                            const tabTarget = tabContainer.querySelector(
                                '.tabs-content[data-tab="' + dataTab + '"]'
                            );
                            contentAreas.forEach((contentArea) => {
                                contentArea.classList.remove("-show");
                            });
                            tabTarget.classList.add("-show");

                            if(window.fullCal) {
                                console.log('calendar added')
                                window.fullCal.render();
                            }

                        });
                    });
                });
            }
            window.addEventListener('DOMContentLoaded', () => {
                tabs();
            })


            function closeSearch() {
                const resultContainer = document.querySelector('.search_result');
                if(resultContainer) {
                    resultContainer.classList.remove('-open-results');
                }
            }
        </script>
    <?php include_once('parts/bucket-message.php');?>
    </body>
    </html>
