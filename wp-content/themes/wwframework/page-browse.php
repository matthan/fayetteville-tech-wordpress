<?php get_header(); ?>

<?php
$masthead_image = get_field( 'search_masthead_image', 'option' );
$masthead = array(
    'masthead_size' => 'small',
    'masthead_image' => array(
        'url' => $masthead_image['sizes']['full-size'],
        'alt' => 'Search Results',
    ),
    'heading' => 'Browse',
    'content' =>  $content,
);
include locate_template('template-parts/masthead.php');
?>

<main role="main" class="page-content browse-content">

    <div class="container">
        <?php get_template_part('template-parts/search-form', 'main'); ?>
    </div>

    <div class="container">

        <?php
            $args = array(
                'posts_per_page' => -1,
                'orderby'     => 'title',
                'post_type'   => array( 'page' ),
                'post_parent' => 0,
                'order'       => 'ASC',
                //'post__in'  => array(),
                'post__not_in' => array( 21376, 22, 20332, 38, 188, 21163, 20362, 21159, 2083 ), //exclude specific pages
            );
            $page_list = new WP_Query($args);
        ?>

        <?php if($page_list->have_posts()) : ?>
            <div class="row-flex browse-list">
                <?php while($page_list->have_posts()) : ?>
                    <?php $page_list->the_post(); ?>
                    <div class="col col-33">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>
