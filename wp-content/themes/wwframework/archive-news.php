<?php
get_header();

$global_options = get_fields('options');
$masthead = $global_options['news_masthead'];
include locate_template('template-parts/masthead.php');
?>

<?php ww_breadcrumbs(); ?>

<main id="main" role="main" aria-label="main content" class="archive-page" tabindex="-1">
    <?php get_template_part('template-parts/archive', 'news'); ?>
</main>

<?php get_footer(); ?>
