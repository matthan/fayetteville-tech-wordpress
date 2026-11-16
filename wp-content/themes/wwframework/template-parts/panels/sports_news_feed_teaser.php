<div aria-label="Sports news feed" class="panel panel-news-events-feed-teaser">
    <div class="container">
        <div class="row-flex row-feeds">
            <div class="feed-wrap feed-wrap-sports-news">
                <?php $filter_by_category_terms = get_sub_field( 'sport_category' ); ?>
                <?php $catterm = $filter_by_category_terms->slug; ?>
                <div class="feed-header">
                    <h2><?php echo $filter_by_category_terms->name; ?> News</h2>
                    <a href="/athletics/news-events" class="view-all hide-phablet-down">View all <i class="icon-arrow-thin-right"></i></a>
                </div>
                <div class="feed">
                    <?php
                    $args = array(
                        'post_type' => 'news',
                        'posts_per_page' => 4,
                        'orderby' => 'most_recent',
                        'tax_query' => array (
                            'relation' => 'AND',
                        ),
                    );
                    if( $catterm ) {
                        array_push($args['tax_query'], array (
                                'taxonomy' => 'sport',
                                'terms' => $catterm,
                                'field' => 'slug',
                                'operator' => 'AND',
                            )
                        );
                    }
                    $n_query = new WP_Query($args);

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