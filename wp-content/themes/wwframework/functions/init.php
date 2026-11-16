<?php

/* Remove SEO Boxes from Edit Screen */
add_filter('wpseo_use_page_analysis', '__return_false');

/* Add Image Sizes */
if (function_exists('add_image_size')) {
    // add_image_size('masthead',2000);
    add_image_size('full-size',1400);
    add_image_size('half-size',800);
    add_image_size('full-container',940);
    add_image_size('half-container',470);
    add_image_size('medium-crop',400, 290, true);
}

/* Theme Support */
add_theme_support('post-thumbnails'); // allows Featured images

/* Menu & Widget Sidebar */
function ww_init()
{
    register_nav_menus(array(
        'looking' => 'I\'m Looking For Menu',
        'admissions' => 'Admission Information Menu',
        'military' => 'Military & Veterans Menu',
        'student' => 'Student Resources Menu',
        'faculty' => 'Faculty & Staff Resources Menu',
        'highschool' => 'High School Connections Menu',
        'guest' => 'Guest & Visitor Menu',
        //'footer' => 'Footer Menu',
        'resources' => 'Footer Resources',
        'campus-maps' => 'Footer Campus Maps',
        'other' => 'Footer Other'
    ));

	register_sidebar(array(
       'name' => 'Instagram - Fayetteville Tech',
       'id' => 'instagram',
       'before_widget' => '<div id="%1$s" class="widget %2$s">',
       'after_widget' => '</div>',
       'before_title' => '<h3>',
       'after_title' => '</h3>'
   ));

    register_sidebar(array(
        'name' => 'Instagram - FTCC Athletics',
        'id' => 'instagram_ftccathletics',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}
add_action('init', 'ww_init');

/* Option Pages */
if (function_exists('acf_add_options_page')) {
    // Global options
    $parent = acf_add_options_page(array(
        'page_title' 	=> 'Theme General Settings',
        'menu_title' 	=> 'Theme Settings',
        'redirect' 		=> false
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Header / Footer Settings',
        'menu_title' 	=> 'Header / Footer',
        'parent_slug' 	=> $parent['menu_slug'],
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Social Media Settings',
        'menu_title' 	=> 'Social Media',
        'parent_slug' 	=> $parent['menu_slug'],
    ));

    // Archive pages
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Archive Page Settings',
        'menu_title' 	=> 'Archive Pages',
        'parent_slug' 	=> 'edit.php?post_type=page',
    ));
}

function custom_menu_page_removing() {
    remove_menu_page( $menu_slug );
}
add_action( 'admin_menu', 'custom_menu_page_removing' );

/* Add Scripts */
function ww_scripts()
{
    // Add Bower-based libraries first
     wp_register_script('slick', get_template_directory_uri() . '/libs/bower_libs/slick-carousel/slick/slick.min.js', array('jquery'), '1.8.0', true);
     wp_enqueue_script('slick');
    wp_register_script('fancybox', get_template_directory_uri() . '/libs/bower_libs/fancybox/dist/jquery.fancybox.js', array('jquery'), '3.1.25', true);
    wp_enqueue_script('fancybox');
    // wp_register_script('gsap-js', get_template_directory_uri() . '/libs/bower_libs/gsap/src/minified/TweenMax.min.js', array('jquery'), '1.10.2', true);
    // wp_enqueue_script('gsap-js');
    // wp_register_script('scrollmagic', get_template_directory_uri() . '/libs/bower_libs/scrollmagic/scrollmagic/minified/ScrollMagic.min.js', array('jquery','gsap-js'), '2.0.5', true);
    // wp_enqueue_script('scrollmagic');
    // wp_register_script('scrollmagic-animate', get_template_directory_uri() . '/libs/bower_libs/scrollmagic/scrollmagic/minified/plugins/animation.gsap.min.js', array('jquery','gsap-js','scrollmagic'), '2.0.5', true);
    // wp_enqueue_script('scrollmagic-animate');
    // wp_register_script('scrollmagic-debug', get_template_directory_uri() . '/libs/bower_libs/scrollmagic/scrollmagic/minified/plugins/debug.addIndicators.min.js', array('jquery','gsap-js','scrollmagic'), '2.0.5', true);
    // wp_enqueue_script('scrollmagic-debug');
    wp_register_script('js-cookie', get_template_directory_uri() . '/libs/bower_libs/js-cookie/src/js.cookie.js', array('jquery'), '2.1.4', true);
    wp_enqueue_script('js-cookie');

    // Finally, add theme-specific custom JS files
    wp_register_script('ww-functions', get_template_directory_uri() . '/js/ww-functions.js', array('jquery'), null, true);
    wp_enqueue_script('ww-functions');
}
add_action('wp_enqueue_scripts', 'ww_scripts');

/* Add Stylesheets */
function ww_styles()
{
    // Add Bower-based libraries first
    wp_register_style('slick',get_template_directory_uri() . '/libs/bower_libs/slick-carousel/slick/slick.css', false, '1.8.0', 'screen');
    wp_enqueue_style('slick');
    wp_register_style('fancybox',get_template_directory_uri() . '/libs/bower_libs/fancybox/dist/jquery.fancybox.css', false, '3.1.25', 'screen');
    wp_enqueue_style('fancybox');

    // Now, add theme-specific CSS files
    wp_register_style('ww-styles', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('ww-styles');
}
add_action('wp_enqueue_scripts', 'ww_styles');

/* Google Fonts */
function ww_load_fonts() {
    wp_register_style('googleOpenSansFont', 'https://fonts.googleapis.com/css?family=Ultra');
    wp_enqueue_style('googleOpenSansFont');
}
add_action('wp_enqueue_scripts', 'ww_load_fonts');

/* TinyMCE Editor Style Overrides */
function ww_editor_styles()
{
    add_editor_style(get_template_directory_uri() . '/css/editor.css');
}
add_action('after_setup_theme', 'ww_editor_styles');

/* Administration Theme Style Overrides */
function ww_admin_styles()
{
    //add_editor_style(get_template_directory_uri() . '/css/admin.css');
}
add_action('admin_head', 'ww_admin_styles');

/* Custom Admin Menu Order */
function ww_custom_menu_order() {
    return array( 'index.php', 'separator1', 'edit.php?post_type=page', 'edit.php' );
}
add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'ww_custom_menu_order' );

/* Mime types */
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/* Hide admin menu items from the admin menu */
function remove_admin_menu_items()
{
    $admins = array('walkwest'); //provide a list of usernames who can edit custom field definitions here
    $current_user = wp_get_current_user(); //get the current user
    /* match and remove if needed */
    if (!in_array($current_user->user_login, $admins)) {
        remove_menu_page('edit.php?post_type=acf');
        //remove_menu_page('tools.php');
    }
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_admin_menu_items', 999);

/* Move Yoast to Bottom */
function yoasttobottom() {
    return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

// Automatically set the image Title, Alt-Text, Caption & Description upon upload
// https://brutalbusiness.com/automatically-set-the-wordpress-image-title-alt-text-other-meta/
function ww_assign_image_alt_upon_upload($post_id) {
    if (wp_attachment_is_image($post_id)) {
        $image_title = get_post($post_id)->post_title;

        // Sanitize the title: remove hyphens, underscores & extra spaces:
        $image_title = preg_replace('%\s*[-_\s]+\s*%', ' ', $image_title);

        // Sanitize the title: capitalize first letter of every word (other letters lower case):
        $image_title = ucwords(strtolower($image_title));

        // Create an array with the image meta (Title, Caption, Description) to be updated
        $image_meta = array(
            'ID' => $post_id,		        // Specify the image (ID) to be updated
            'post_title' => $image_title,   // Set image Title to sanitized title
            //'post_excerpt' => $image_title, // Set image Caption (Excerpt) to sanitized title
            'post_content' => $image_title, // Set image Description (Content) to sanitized title
        );

        // Set the image Alt-Text
        update_post_meta($post_id, '_wp_attachment_image_alt', $image_title);

        // Set the image meta (e.g. Title, Excerpt, Content)
        wp_update_post($image_meta);
    }
}
add_action('add_attachment', 'ww_assign_image_alt_upon_upload');
