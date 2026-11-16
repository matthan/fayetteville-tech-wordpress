<?php
get_header();

$global_options = get_fields('options');
$masthead = $global_options['sports_news_masthead'];
include locate_template('template-parts/masthead.php');
?>

<?php ww_breadcrumbs(); ?>

<main id="main" role="main" aria-label="main content" class="archive-page">
    <?php get_template_part('template-parts/archive', 'sports-news'); ?>
</main>

<?php get_footer(); ?>