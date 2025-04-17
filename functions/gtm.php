<?php
function gtagmanager() { ?>
    <!-- Global site tag (gtag.js) - Google Ads: 1002104841 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-1002104841"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-1002104841');
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9YZZZ2B727"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-9YZZZ2B727');
    </script>
<?php }
//add_action('wp_head', 'gtagmanager');

function gtm() { ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WCL38ZWJ');</script>
    <!-- End Google Tag Manager -->
    <?php }
add_action('wp_head', 'gtm');

function gtagmanagereventtracking() { ?>
    <script>
        window.addEventListener('load', function() {
            document.addEventListener('click', function(e) {
                if (e.target.closest('a[href*="/events-listing"]')) {
                    gtag('event', 'conversion', {
                        'send_to': 'AW-1002104841/TiFwCNfeuAMQidDr3QM'
                    });
                    gtag('event', 'book_tickets_button')
                }
            })
        });
    </script>
<?php }
add_action('wp_footer', 'gtagmanagereventtracking');
