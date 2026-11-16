<div aria-label="Most recent 3 blog post teasers" class="panel panel-blog-feed-teaser">
    <div class="container">
        <div class="feed-wrap feed-wrap-blog">
            <div class="feed-header">
                <h2>Our Latest Blogs</h2>
                <a href="<?php echo get_post_type_archive_link('post'); ?>" class="view-all hide-phablet-down">View all <i class="icon-arrow-thin-right"></i></a>
            </div>
            <div class="feed">
                <?php
                $b_query = new WP_Query(array(
                    'posts_per_page' => 3,
                ));

                while ($b_query->have_posts()) {
                    $b_query->the_post();
                    get_template_part('template-parts/teaser', 'blog');
                }

                wp_reset_postdata();
                ?>
            </div>
            <div class="feed-footer hide-tablet-up">
                <a href="<?php echo get_post_type_archive_link('post'); ?>" class="view-all">View all <i class="icon-arrow-thin-right"></i></a>
            </div>
        </div>
    </div>
</div>