<!doctype html>
<html lang="en" id="header">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="#e94840" />
    <?php wp_head(); ?>
    <link rel="preload" href="<?php echo get_template_directory_uri() ?>/assets/fonts/SpecialElite-Regular.ttf" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri() ?>/assets/fonts/Quicksand-Regular.ttf" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri() ?>/assets/fonts/Quicksand-Bold.ttf" as="font" type="font/ttf" crossorigin>
   
    <title><?php wp_title() ?></title>
</head>
<body <?php body_class('topsecret, bg-[var(--background-color)] flex flex-col m-0 min-w-[320px] h-full min-h-screen font-regular text-secondary'); ?>>
<?php
    $displayBanner = get_field("display_banner", "option");
    if(true === $displayBanner) {
        get_template_part('parts/content', 'importantbanner');
    }
?>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCL38ZWJ"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div>
<div id="toggle-menu" class="hidden font-bold text-red-100 text-right text-3xl bg-gray-800 fixed top-0 left-0 h-screen w-screen flex flex-col items-center justify-center ">
    <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
    <div class="hidden md:block">
        <div><div style="width:163px"></div><span>4.5/5 Trip Advisor</span></div>
        <div><div style="width:169px"></div><span>4.9 Google</span></div>
    </div>
    </div>
    <div>
        <?php get_header(); ?>

<header class="fixed w-full flex justify-between items-center h-24 p-3 z-50 before:content-[''] before:absolute before:top-0 before:left-0 before:w-full before:h-[9vh] before:bg-gradient-to-b before:from-[#010101] before:to-[hsla(0,0%,100%,0)] before:z-[-1]">
	<?php global $post; ?>
    <?php get_template_part('parts/header', 'logo'); ?>
    
    <div class="flex h-full items-start pt-2 pr-2">
        <div class="flex">
            <label for="toggle-darkmode" class="flex pl-3.5 pr-3.5 text-sm items-center">
                <input type="checkbox" id="toggle-darkmode" class="sr-only">
                <div class="inline-block bg-red-500 rounded-full w-12 h-5 relative align-middle transition-colors duration-200 after:content-[''] before:content-[''] before:block before:bg-gradient-to-b before:from-white before:to-gray-200 before:rounded-full before:shadow-[0_0_0_1px_rgba(0,_0,_0,_0.25)] before:w-4 before:h-4 before:absolute before:top-0.5 before:left-0.75 before:transition-all before:duration-200"></div>
                <span class="ml-1 relative px-4 text-white font-heading">Lighten up</span>
            </label>
            <a href="/find-us/" class="hidden sm:flex text-white font-heading text-sm">
                <span class="bg-[#e94840] w-[23px] h-[22px] flex justify-center items-center leading-[0.6] relative rounded-full font-heading">?</span>
                <span class="px-4">Find us</span></a>
        </div>

        <button id="toggle-menu-button" class="z-50 relative">
            <span class="sr-only">Toggle Menu</span>
            <div id="open" class="h-7 flex flex-col items-end justify-between">
                <span class="block h-0.5 w-8 bg-red-900 rounded-full"></span>
                <span class="block h-0.5 w-6 bg-red-900 rounded-full"></span>
                <span class="block h-0.5 w-8 bg-red-900 rounded-full"></span>
            </div>
            <div  id="close" class="hidden h-7 flex flex-col items-end justify-between">
                <span class="block h-0.5 w-8 bg-red-100 rounded-full origin-left transform rotate-45 translate-y-0.5"></span>
                <span class="block h-0.5 w-8 bg-red-100 rounded-full origin-left transform -rotate-45 -translate-y-0.5"></span>
            </div>
        </button>
    </div>
</header>
<main class="flex flex-col w-full flex-grow">
