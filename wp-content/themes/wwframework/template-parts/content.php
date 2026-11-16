<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">
    <header class="entry-header">
        <?php if (has_post_thumbnail()) : ?>
            <div class="entry-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>

        <?php if (is_single()) : ?>
            <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
        <?php else : ?>
            <h2 class="entry-title" itemprop="name">
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h2>
        <?php endif; // is_single() ?>

        <div class="entry-meta">
            <?php ww_post_meta(); ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <?php if (!is_singular()) : ?>
        <div class="entry-content" itemprop="articleBody">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content" itemprop="articleBody">
            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen')); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'twentythirteen') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <?php if (is_singular()) : ?>
        <footer class="entry-footer">
            <?php ww_post_footer(); ?>
            <?php if (comments_open() && is_single()) : ?>
                <?php comments_template(); ?>
            <?php endif; // comments_open() ?>
            <?php if (is_single() && get_the_author_meta('description') && is_multi_author()) : ?>
                <?php get_template_part('template-parts/author', 'bio'); ?>
            <?php endif; ?>
        </footer><!-- .entry-meta -->
    <?php endif; ?>
</article><!-- #post -->
