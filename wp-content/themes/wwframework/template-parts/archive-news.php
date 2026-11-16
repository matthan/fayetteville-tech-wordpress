<main role="main" class="page-content archive archive-news">
    <?php if (have_posts()): ?>
        <div class="feed-wrap feed-wrap-news">
            <div class="container">
                <div class="feed">
                    <?php while (have_posts()): the_post(); ?>
                        <?php get_template_part('template-parts/teaser', 'news'); ?>
                    <?php endwhile; ?>
                </div>

                <?php ww_pagination(); ?>
            </div>
        </div>
    <?php endif; ?>
</main>