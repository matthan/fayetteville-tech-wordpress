<?php get_header(); ?>


<div itemscope itemtype="http://schema.org/BlogPosting">

<?php
// Set masthead fields into consolidated $masthead array and include template
if( get_field('alternate_masthead_image') ) {
    $masthead_image = get_field('alternate_masthead_image');
} else {
    $thumbnail_url = get_the_post_thumbnail_url();
    $thumbnail_alt = get_post_meta(get_post_thumbnail_id() , '_wp_attachment_image_alt', true);
    if($thumbnail_url) {
        $masthead_image = array('url' => $thumbnail_url, 'alt' => $thumbnail_alt);
    } else {
        $masthead_image = null;
    }
}

$masthead = array(
    'masthead_type' => 'standard',
    'masthead_size' => 'medium',
    'masthead_image' => $masthead_image,
    'heading' => get_the_title(),
    'content' => null,
);
include locate_template('template-parts/masthead.php');
?>

<?php ww_breadcrumbs(); ?>

<main id="main" role="main" aria-label="main content" class="page-content" tabindex="-1">

    <div class="container">
        <div class="flex-wrap">
            <main>
                <div class="main-metas hide-tablet-up">
                    <div class="main-meta-item">
                        <h3>Publish Date</h3>
                        <div class="main-meta-data" itemprop="datePublished" content="<?php echo date('c', get_the_time('U')); ?>">
                            <?php the_time('F j, Y'); ?>
                        </div>
                    </div>
                </div>
                <div itemprop="articleBody mainEntityOfPage"><?php the_content(); ?></div>
            </main>
            <aside class="sidebar">
                <?php get_template_part('template-parts/metas', 'author'); ?>
                <?php get_template_part('template-parts/metas', 'sidebar'); ?>
            </aside>
        </div>
    </div>

    <?php get_template_part('template-parts/panels/blog_feed_teaser'); ?>

</main>

</div> <?php // End Schema.org ?>

<?php get_footer(); ?>
