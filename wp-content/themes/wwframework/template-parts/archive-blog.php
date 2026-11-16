<main role="main" class="page-content archive archive-blog">
    <?php if (have_posts()): ?>
        <div class="feed-wrap feed-wrap-blog">
            <div class="container">
                <div class="feed">
                    <?php while (have_posts()): the_post(); ?>
                        <?php get_template_part('template-parts/teaser', 'blog'); ?>
                    <?php endwhile; ?>
                </div>

                <?php ww_pagination(); ?>
            </div>
        </div>
    <?php endif; ?>
</main>