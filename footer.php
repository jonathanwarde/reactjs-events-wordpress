<?php
if(true) {
    include_once('parts/cta-link-to-available-events.php');
} else {
    include_once('parts/cta-book.php');
}
?>
</main>
   
<?php
// Get the Testimonials from the Options page
$testimonials = get_field('testimonials', 'option');

if ($testimonials): ?>
    <section class="swiper testimonials-slider bg-gray-800 text-center overflow-hidden">
        <ul class="swiper-wrapper p-0" style="padding:0">
            <?php foreach ($testimonials as $testimonial): ?>
                <li class="swiper-slide">
                    <div class="testimonials__item h-[60vh] max-h-[500px]">
                        <div class="testimonials-slider__img-wrap relative overflow-hidden w-full h-full inline-flex">
                            <img src="<?php echo esc_url($testimonial['testimonial_image']); ?>" loading="lazy" class="w-full h-full object-cover object-top transition-all duration-300 ease-in-out transform scale-125" />
                        </div>
                        <blockquote class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full z-10 max-w-full mx-auto">
                            <p class="font-regular-light mb-4 p-0 text-2xl sm:text-4xl text-white"><?php echo esc_html($testimonial['testimonial_quote']); ?></p>
                            <cite class="font-heading text-white text-2xl text-white bg-primary transform rotate-[-3deg] inline-flex py-1 px-2">
                                <?php echo esc_html($testimonial['testimonial_citation']); ?>
                            </cite>
                        </blockquote>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>


    <footer class="bg-primary">
      <section class="footer gap-4 grid grid-cols-1 m-auto max-w-7xl md:gap-10 md:grid-cols-3 px-4 py-6 sm:px-8 sm:py-16">
        <div>
            <h2 class="font-heading pb-8 text-2xl">Quick links</h2>
            <?php
            $footer_links = get_field('footer_links', 'option');
            $company_address = get_field('company_address', 'option');
            if ($footer_links):
              echo '<ul class="footer-links">';
              foreach ($footer_links as $link):
                  $post_id = $link['footer_link_page'];
                  $post = get_post($post_id); 
                  ?>
                  <li><a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html($post->post_title); ?></a></li>
                  <?php
              endforeach;
              echo '</ul>';
          endif;?>

        </div>
        <div>
            <h2 class="font-heading pb-8 text-2xl">Contact</h2>
          <?php if($company_address):?>
          <address>
          <?php $formatted_address = nl2br(esc_html($company_address));
          echo '<div class="company-address">' . $formatted_address . '</div>';
          ?>
          </address>
            <?php endif; ?>
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
      <div class="bg-[var(--background-color)]">
        <div class="footer gap-4 grid grid-cols-1 m-auto max-w-7xl md:gap-10 md:grid-cols-3 px-4 py-6 sm:px-8 sm:py-16">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/topsecretlogo.svg" class="w-full max-w-[200px] m-auto" loading="lazy" />
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/tripadvisor2022.png" class="w-full max-w-[100px] m-auto" loading="lazy">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/google-reviews.png" loading="lazy" class="w-full max-w-[200px] m-auto">
        </div>
          </div>
    </footer>
    <div id="datafetch"></div>
    </div><!--end site-wap__inner-->
    </div><!--end site-wap__outer-->
    <?php include_once('images/svg/icon-sprite.svg');

     wp_footer();
    ?>

        <script>
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
