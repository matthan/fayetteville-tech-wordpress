<?php
/**
 * The default template for displaying pages.
 *
 * @package WordPress
 * @subpackage WW_Framework
 * @since WW_Framework 2.0
 */

global $options;
global $meta;
get_header(); ?>


<?php
// Pull masthead fields into consolidated $masthead array and include template
$masthead = array(
    'masthead_type' => get_field('masthead_type'),
    'masthead_size' => get_field('masthead_size'),
    'masthead_image' => get_field('masthead_image'),
    'heading' => get_field('heading'),
    'content' => get_field('content'),
);
include locate_template('template-parts/masthead.php');
?>

<?php ww_breadcrumbs(); ?>

<main id="main" role="main" aria-label="main content" class="page-content" tabindex="-1">

    <?php if( !post_password_required( $post )) :
        if ( have_rows( 'panels' ) ) :
            while ( have_rows( 'panels' ) ) : the_row();
                get_template_part( 'template-parts/panels/' . get_row_layout() );
            endwhile;
        endif;
    else: ?>
        <div class="panel">
            <div class="container">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
