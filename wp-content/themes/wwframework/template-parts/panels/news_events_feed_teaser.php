<div aria-label="Upcoming event feed and newest news feed" class="panel panel-news-events-feed-teaser">
    <div class="container">
        <div class="row-flex row-feeds">
            <div class="feed-wrap feed-wrap-events">
				<?php $newsterm = get_sub_field('news_category_filter'); ?>
				<?php $eventterm = get_sub_field('events_category_filter'); ?>
				<?php if( $eventterm ) : ?>
					<div class="h3 preheading"><?php echo $eventterm->name; ?></div>
				<?php endif; ?>
                <div class="feed-header">
                    <h2>Events</h2>
					<?php if( $eventterm->slug == 'athletics' ) : ?>
	                    <a href="/events/category/athletics/" class="view-all hide-phablet-down">View all <i class="icon-arrow-thin-right"></i></a>
					<?php else : ?>
	                    <a href="<?php echo get_post_type_archive_link('tribe_events'); ?>" class="view-all hide-phablet-down">View all <i class="icon-arrow-thin-right"></i></a>
					<?php endif ; ?>
                </div>
                <div class="feed">
                    <?php
                    $e_args = array(
                        'post_type' => 'tribe_events',
                        'posts_per_page' => 3,
                        'orderby' => 'most_recent',
						'tax_query' => array (
							'relation' => 'AND'
						)
                    );
					if ( $eventterm ) {
						array_push($e_args['tax_query'], array (
		                    	'taxonomy' => 'tribe_events_cat',
		                    	'field' => 'slug',
								'terms' => $eventterm->slug,
								'operator' => 'AND',
							)
		            	);
					} else {
                        array_push($e_args['tax_query'], array (
                                'taxonomy' => 'tribe_events_cat',
                                'terms' => 'athletics',
                                'field' => 'slug',
                                'operator' => 'NOT IN',
                            )
                        );
                 	}
                    $e_query = new WP_Query($e_args);

					if ( $e_query->have_posts() ) {
	                    while ($e_query->have_posts()) {
	                        $e_query->the_post();
	                        get_template_part('tribe-events/list/single-event');
	                    }
					} else { ?>
						<br />
						<h5>No Events at this time</h5>
					<?php }

                    wp_reset_postdata();
                    ?>
                </div>
                <div class="feed-footer hide-tablet-up">
                    <a href="<?php echo get_post_type_archive_link('tribe_events'); ?>" class="view-all">View all <i class="icon-arrow-thin-right"></i></a>
                </div>
            </div>
            <div class="feed-wrap feed-wrap-news">
				<?php if( $newsterm ) : ?>
					<div class="h3 preheading"><?php echo $newsterm->name; ?></div>
				<?php endif; ?>
                <div class="feed-header">
                    <h2>News</h2>
                    <a href="<?php echo get_post_type_archive_link('news'); ?>" class="view-all hide-phablet-down">View all <i class="icon-arrow-thin-right"></i></a>
                </div>
                <div class="feed">
                    <?php
                    $n_args = array(
                        'post_type' => 'news',
                        'posts_per_page' => 3,
                        'orderby' => 'most_recent',
						'tax_query' => array (
							'relation' => 'AND'
						)
                    );
					if ( $newsterm ) {
						array_push($n_args['tax_query'], array (
		                    	'taxonomy' => 'category',
		                    	'field' => 'slug',
								'terms' => $newsterm->slug,
								'operator' => 'AND',
							)
		            	);
					} else {
                        // array_push($n_args['tax_query'], array (
                        //         'taxonomy' => 'category',
                        //         'terms' => 'athletics',
                        //         'field' => 'slug',
                        //         'operator' => 'NOT IN',
                        //     )
                        // );
                 	}
                    $n_query = new WP_Query($n_args);

                    while ($n_query->have_posts()) {
                        $n_query->the_post();
                        get_template_part('template-parts/teaser', 'news');
                    }

                    wp_reset_postdata();
                    ?>
                </div>
                <div class="feed-footer hide-tablet-up">
                    <a href="<?php echo get_post_type_archive_link('news'); ?>" class="view-all">View all <i class="icon-arrow-thin-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>