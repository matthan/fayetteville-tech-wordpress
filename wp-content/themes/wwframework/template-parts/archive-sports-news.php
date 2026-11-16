<main role="main" class="page-content archive archive-news">
    <?php
    $args = array(
        'post_type' => 'news',
        'paged' => $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => 'athletics',
            ),
        ),
    );
    ?>
    <?php $the_query = new WP_Query( $args ); ?>
    <?php if ( $the_query->have_posts() ) : ?>
        <div class="feed-wrap feed-wrap-news">
            <div class="container">
                <div class="feed">
                    <?php while ( $the_query->have_posts() ) : ?>
                        <?php $the_query->the_post(); ?>
                        <?php get_template_part('template-parts/teaser', 'news'); ?>
                    <?php endwhile; ?>
                </div>

                <?php //ww_pagination(); ?>

                <div class="pagination ww-pagination">
                    <?php
                    echo paginate_links( array(
                        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                        'total'        => $the_query->max_num_pages,
                        'current'      => max( 1, get_query_var( 'paged' ) ),
                        'format'       => '?paged=%#%',
                        'show_all'     => false,
                        'type'         => 'plain',
                        'end_size'     => 2,
                        'mid_size'     => 1,
                        'prev_next'    => true,
                        'prev_text'    => sprintf( '<i class="icon-arrow-left"></i> %1$s', __( '', 'text-domain' ) ),
                        'next_text'    => sprintf( '%1$s <i class="icon-arrow-right"></i>', __( '', 'text-domain' ) ),
                        'add_args'     => false,
                        'add_fragment' => '',
                    ) );
                    ?>
                </div>

            </div>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</main>