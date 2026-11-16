<?php
if (is_home()) { // Means we're on the blog archive - otherwise, render default index code
    get_template_part('archive');
    exit();
}
?>

<?php get_header(); ?>

<main id="main" role="main" aria-label="main content" class="page-default" tabindex="-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12 main">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content', get_post_type()); ?>
                    <?php endwhile; ?>
                    <?php ww_pagination(); ?>
                <?php else : ?>
                    <?php get_template_part('template-parts/content', 'none'); ?>
                <?php endif; ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
