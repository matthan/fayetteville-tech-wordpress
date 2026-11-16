<?php get_header(); ?>

<?php
// Pull masthead fields into consolidated $masthead array and include template
// Generate masthead content details
ob_start();
?>
<?php echo $wp_query->found_posts; ?> results found for: <strong><?php the_search_query(); ?></strong>
<?php if ($wp_query->found_posts): ?>
    <br>
    Page <?php echo get_query_var('paged') ?: 1; ?> of <?php echo $wp_query->max_num_pages; ?>
<?php endif; ?>
<?php
$content = ob_get_clean();

$masthead_image = get_field( 'search_masthead_image', 'option' );
$masthead = array(
    'masthead_size' => 'small',
    'masthead_image' => array(
        'url' => $masthead_image['sizes']['full-size'],
        'alt' => 'Search Results',
    ),
    'heading' => 'Search Results',
    'content' =>  $content,
);
include locate_template('template-parts/masthead.php');
?>

<main id="main" role="main" aria-label="main content" class="page-content page-serp" tabindex="-1">
    <div class="container">
        <?php get_template_part('template-parts/search-form', 'main'); ?>
    </div>

    <div class="search-results">
        <div class="container">
	 		<?php if (have_posts()): ?>
	            <div class="results">
	 			   <?php while (have_posts()): the_post(); ?>
	 				   <?php get_template_part('template-parts/search-result', get_post_type()); ?>
	 			   <?php endwhile; ?>
	 			   <?php ww_pagination(); ?>
	 		   </div>
	 	   <?php else: ?>
            <div class="no-results">
			   <?php if ( function_exists( 'relevanssi_didyoumean' ) ) { ?>
			       <?php relevanssi_didyoumean( get_search_query(), '<p>Did you mean: ', '</p>', 5 ); ?>
				<?php } else { ?>
					None results found!
				<?php } ?>
            </div>
	 	   <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
