<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

get_header();

$global_options = get_fields('options');

// Set masthead fields into consolidated $masthead array and include template
if (has_post_thumbnail()) {
    $masthead_image = array(
        'url' => get_the_post_thumbnail_url(),
        'alt' => get_post_meta(get_post_thumbnail_id() , '_wp_attachment_image_alt', true),
    );
}
else {
    $masthead_image = $global_options['event_masthead']['masthead_image'];
}

if( is_single() ) {
    $thumbnail_url = get_the_post_thumbnail_url();
    $masthead = array(
        'masthead_type' => 'standard',
        'masthead_size' => 'small',
        'masthead_image' => $masthead_image,
        'heading' => get_the_title(),
        'content' => null,
    );
} else {
    $masthead = $global_options['event_masthead'];
}
include locate_template('template-parts/masthead.php');
?>

<?php ww_breadcrumbs(); ?>

	<div class="events-container">
		<div class="container">
            <?php tribe_get_view(); ?>
		</div>
	</div>

<?php get_footer(); ?>
