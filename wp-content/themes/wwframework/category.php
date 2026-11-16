<?php
get_header();

$global_options = get_fields('options');
$masthead = $global_options['blog_masthead'];
$queried_object = get_queried_object();
$term_id = $queried_object->term_id;

$masthead = array_merge($masthead, array(
    'heading' => single_term_title('Blog Category - ', false),
    'content' => wp_strip_all_tags(term_description($term_id), true),
));
include locate_template('template-parts/masthead.php');
?>

<?php ww_breadcrumbs(); ?>

<main id="main" role="main" aria-label="main content" class="archive-page" tabindex="-1">
    <?php get_template_part('template-parts/archive', 'blog'); ?>
</main>

<?php get_footer(); ?>
