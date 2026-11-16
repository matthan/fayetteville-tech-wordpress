<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<div class="page-content">
    <div class="flex-wrap">

        <?php while ( have_posts() ) :  the_post(); ?>
            <main id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Event content -->
                <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                <div class="tribe-events-single-event-description tribe-events-content entry-content description" itemprop="description mainEntityOfPage">
                    <?php the_content(); ?>
                </div>
            </main>
            <aside class="sidebar">
                <!-- Event meta -->
                <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
                <?php tribe_get_template_part( 'modules/meta' ); ?>
                <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

                <?php get_template_part('template-parts/metas', 'sidebar'); ?>
            </aside>
        <?php endwhile; ?>
    </div>
</div>