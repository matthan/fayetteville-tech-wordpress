<?php
/**
 * List View Nav Template
 * This file loads the list view navigation.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/nav.php
 *
 * @package TribeEventsCalendar
 *
 */
global $wp_query;

$events_label_plural = tribe_get_event_label_plural();

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<h3 class="tribe-events-visuallyhidden"><?php echo esc_html( sprintf( __( '%s List Navigation', 'the-events-calendar' ), $events_label_plural ) ); ?></h3>
<ul class="tribe-events-sub-nav">
	<!-- Left Navigation -->

	<!-- Month / Year Headers -->
		<div class="tribe-month-wrapper">
			<?php if ( tribe_has_previous_event() ) : ?>
				<span class="<?php echo esc_attr( tribe_left_navigation_classes() ); ?>">
					<a href="<?php echo esc_url( tribe_get_listview_prev_link() ); ?>" rel="prev"><?php printf( __( '« Previous Events', 'the-events-calendar' ), $events_label_plural ); ?></a>
				</span><!-- .tribe-events-nav-left -->
			<?php endif; ?>
			
			<?php //tribe_events_list_the_date_headers(); ?>
	
			<?php if ( tribe_has_next_event() ) : ?>
				<span class="<?php echo esc_attr( tribe_right_navigation_classes() ); ?>">
					<a href="<?php echo esc_url( tribe_get_listview_next_link() ); ?>" rel="next"><?php printf( __( 'Next Events »', 'the-events-calendar' ), $events_label_plural ); ?></a>
				</span><!-- .tribe-events-nav-right -->
			<?php endif; ?>
		</div>
		
</ul>