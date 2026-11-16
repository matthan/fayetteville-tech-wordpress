<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title>
        <?php wp_title('|', true, 'right'); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-55WZK94');</script>
	<!-- End Google Tag Manager -->
	
    <?php wp_head(); ?>
	
	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window,document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	 fbq('init', '228715694237098'); 
	fbq('track', 'PageView');
	</script>
	<noscript>
	 <img height="1" width="1" 
	src="https://www.facebook.com/tr?id=228715694237098&ev=PageView
	&noscript=1"/>
	</noscript>
	<!-- End Facebook Pixel Code -->
</head>

<body <?php body_class(); ?>>
	
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-55WZK94"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Swifttype Site Search -->
<script type="text/javascript">
    (function(w,d,t,u,n,s,e){w['SwiftypeObject']=n;w[n]=w[n]||function(){
            (w[n].q=w[n].q||[]).push(arguments);};s=d.createElement(t);
        e=d.getElementsByTagName(t)[0];s.async=1;s.src=u;e.parentNode.insertBefore(s,e);
    })(window,document,'script','//s.swiftypecdn.com/install/v2/st.js','_st');

    _st('install','BekDnM3FsdpQp1e1sheC','2.0.0');
</script>

<div id="wrapper">

    <a href="#main" class="sr-only sr-only-focusable">Skip to main content</a>

    <span id="top" aria-hidden="true"></span>

    <header id="header" class="nav-down" aria-label="header">

        <a class="home-link" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
            <img class="primary-logo" src="<?php bloginfo('template_directory'); ?>/images/fayettevilletech_logo_full.png" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" /></a>
        </a>

        <div class="header-slogan"><?php the_field( 'slogan', 'option' ); ?></div>

        <div class="navigation">

            <!-- Header Navigation -->
            <nav class="header-nav" role="navigation" aria-label="navigation dropdowns">
                <div id="mobile-menu-header" class="mobile-menu-header">
                    <span id="close-mobile-menu" class="icon-close close-mobile-menu"><span class="sr-text">Close Mobile Menu</span></span>
                </div>
                <ul id="primary-nav" class="primary-nav">
                    <li>
                        <button class="dropdown-text" id="im-looking-for" aria-owns="menu-im-looking-for" aria-controls="menu-im-looking-for" aria-haspopup="true" aria-expanded="false">I'm Looking for</button>
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'looking',
                                'depth' => 1,
                                'container' => '',
                                'menu_class' => 'nav navbar-subnav',
                                'items_wrap' => '<ul id="%1$s" class="%2$s" role="group" aria-labelledby="im-looking-for" aria-expanded="false">%3$s</ul>',
                            ));
                        ?>
                    </li>
                    <?php
                    // SMART NAVS
                    // No use in checking cookie at PHP level, Pantheon will cache the PHP - print all in markup, toggle w/JS
                    global $SMART_NAVS;
                    foreach ($SMART_NAVS as $nav => $nav_details):
                        $smart_nav_label = str_replace('_', '-', $nav);
                        $dropdown_id = str_replace('menu-', '', $nav_details['id']);
                    ?>
                        <li data-smart-nav="<?php echo $smart_nav_label; ?>" style="display: none;">
                            <button class="dropdown-text" id="<?php echo $dropdown_id; ?>" aria-owns="<?php echo $nav_details['id']; ?>" aria-controls="<?php echo $nav_details['id']; ?>" aria-haspopup="true" aria-expanded="false"><?php echo $nav_details['label']; ?></button>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => $nav,
                                'depth' => 1,
                                'container' => '',
                                'menu_class' => 'nav navbar-subnav',
                                'items_wrap' => '<ul id="%1$s" class="%2$s" role="group" aria-labelledby="' . $dropdown_id . '" aria-expanded="false">%3$s</ul>',
                            ));
                            ?>
                        </li>
                    <?php endforeach; ?>
                    <li><a href="<?php global $POST_IDS; echo get_permalink($POST_IDS['browse']); ?>">Browse</a></li>
                    <li class="icon-item"><a href="/campus-life/academic-calendar" aria-label="Academic Calendar"><span class="icon icon-calendar-alt" title="Calendar"></span><span class="sr-text">Academic Calendar</span></a></li>
                    <li><button class="search-toggle hide-tablet-down">Search</button></li>
                </ul>
                <?php get_template_part('template-parts/search-form', 'nav'); ?>
            </nav>

            <div id="mobile-toggle" class="mobile-toggle navbar-header">
                <button type="button" id="open-mobile-menu" class="navbar-toggle" data-toggle="collapse"
                        data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bars"></span>
                </button>
            </div>

        </div>

    </header>