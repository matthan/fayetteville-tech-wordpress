<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue microformats
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

?>

<div class="row-flex teaser teaser-event">
	<div class="sr-text">
        <?php // Schema.org data
        $timezone = new DateTimeZone(get_option('gmt_offset'));

        $start_datetime = new DateTime(get_field('_EventStartDate'), $timezone);
        $end_datetime = new DateTime(get_field('_EventEndDate'), $timezone);

        $start_date_content = $start_datetime->format('c');
        $end_date_content = $end_datetime->format('c');

        // If one day event, change $end_date_label
        if ($start_datetime->format('F j') == $end_datetime->format('F j')) {
            $end_date_label =  $end_datetime->format('g:ia');
        }

        ?>
        <meta itemprop="startDate" content="<?php echo $start_date_content; ?>">
        <meta itemprop="startDate" content="<?php echo $start_date_content; ?>">
        <meta itemprop="endDate" content="<?php echo $end_date_content; ?>">
        <?php

        // Get Location Information
        if (tribe_has_venue($post->ID)): ?>
            <?php
            $venue_id = tribe_get_venue_id();
            $venue_title = get_the_title($venue_id);
            $venue_metas = get_post_meta($venue_id);
            ?>
                <span itemscope itemtype="http://schema.org/Place" itemprop="location">
                    <span itemprop="name" content="<?php echo $venue_title; ?>"><?php echo $venue_title; ?></span>
                    <span itemscope itemtype="http://schema.org/PostalAddress" itemprop="address">
                        <span itemprop="streetAddress"><?php echo $venue_metas['_VenueAddress'][0]; ?></span>
                        <span itemprop="addressLocality"><?php echo $venue_metas['_VenueCity'][0]; ?></span>
                        <span itemprop="addressRegion"><?php echo $venue_metas['_VenueState'][0]; ?></span>
                        <span itemprop="postalCode"><?php echo $venue_metas['_VenueZip'][0]; ?></span>
                    </span>
                </span>
        <?php endif; ?>
    </div>


    <div class="teaser-date">
		<!-- Event Meta -->
		<?php do_action( 'tribe_events_before_the_meta' ) ?>
		<div class="tribe-events-event-meta vcard">
			<div class="author <?php echo esc_attr( $has_venue_address ); ?>">
		
				<!-- Schedule & Recurrence Details -->
				<div class="updated published time-details">
					<?php echo tribe_events_event_schedule_details() ?>
				</div>
		
			</div>
		</div><!-- .tribe-events-event-meta -->
		<?php do_action( 'tribe_events_after_the_meta' ) ?>
	</div>
	<div class="teaser-title">
		<!-- Event Title -->
		<?php do_action( 'tribe_events_before_the_event_title' ) ?>
		<h2 class="tribe-events-list-event-title entry-title summary">
			<a class="url" itemprop="url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title() ?>">
				<span itemprop="name"><?php the_title() ?></span>
			</a>
		</h2>
		<?php do_action( 'tribe_events_after_the_event_title' ) ?>
		<?php
		do_action( 'tribe_events_after_the_content' );
		?>
	</div>
</div>


<!-- Event Image -->
<?php //echo tribe_event_featured_image( null, 'medium' ) ?>


