<?php
/**
 * The default front page template
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

<div class="header-social-links" aria-label="Social Media Links">
    <ul class="social">
        <?php if( get_field('facebook_url', 'option') ) : ?>
            <li class="facebook">
                <a href="<?php the_field('facebook_url', 'option'); ?>" title="Find us on Facebook" aria-label="Find us on Facebook"><span class="icon-facebook" aria-hidden="true"></span></a>
            </li>
        <?php endif; ?>
        <?php if( get_field('instagram_url', 'option') ) : ?>
            <li class="instagram">
                <a href="<?php the_field('instagram_url', 'option'); ?>" title="Find us on Instagram" aria-label="Find us on Instagram"><span class="icon-instagram" aria-hidden="true"></span></a>
            </li>
        <?php endif; ?>
        <?php if( get_field('twitter_url', 'option') ) : ?>
            <li class="twitter">
                <a href="<?php the_field('twitter_url', 'option'); ?>" title="Find us on Twitter" aria-label="Find us on Twitter"><span class="icon-twitter" aria-hidden="true"></span></a>
            </li>
        <?php endif; ?>
        <?php if( get_field('youtube_url', 'option') ) : ?>
            <li class="youtube">
                <a href="<?php the_field('youtube_url', 'option'); ?>" title="Find us on Youtube" aria-label="Find us on Youtube"><span class="icon-youtube" aria-hidden="true"></span></a>
            </li>
        <?php endif; ?>
        <?php if( get_field('linkedin_url', 'option') ) : ?>
            <li class="linkedin">
                <a href="<?php the_field('linkedin_url', 'option'); ?>" title="Find us on Linkedin" aria-label="Find us on Linkedin"><span class="icon-linkedin" aria-hidden="true"></span></a>
            </li>
        <?php endif; ?>
    </ul>
</div>

<main id="main" role="main" aria-label="main content" class="page-content" tabindex="-1">

    <?php
    if ( have_rows( 'panels' ) ) :
        while ( have_rows( 'panels' ) ) : the_row();
            get_template_part( 'template-parts/panels/' . get_row_layout() );
        endwhile;
    endif;
    ?>

</main>

<?php get_footer(); ?>
