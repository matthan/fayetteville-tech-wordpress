<?php $bgcolor = get_sub_field( 'background_color' ); ?>
<div aria-label="Page content with sidebar links" class="panel panel-basic-content-w-side bg-<?php echo $bgcolor; ?><?php if( get_sub_field('sidebar_content') || get_sub_field( 'sidebar_buttons' ) || get_sub_field( 'sidebar_links' ) ) : ?> w-sidebar<?php endif; ?>">
    <div class="container">
        <div class="row-flex">
            <div class="col-75">
                <?php the_sub_field( 'content' ); ?>
            </div>
            <div class="col-25 sidebar">
                <?php the_sub_field( 'sidebar_content' ); ?>

                <?php if ( have_rows( 'sidebar_buttons' ) ) : ?>
                    <div class="sidebar-buttons">
                        <?php while ( have_rows( 'sidebar_buttons' ) ) : the_row(); ?>
                            <?php $links = get_sub_field( 'links' ); ?>
                            <?php if (get_sub_field('link_type') == 'anchor') : ?>
                                <a class="btn btn-default anchor-link" role="button" aria-label="<?php the_sub_field( 'link_text' ); ?>" href="<?php echo get_sub_field('anchor_link'); ?>"><?php the_sub_field( 'link_text' ); ?></a>
                            <?php else : ?>
                                <a class="btn btn-default" role="button" aria-label="<?php the_sub_field( 'link_text' ); ?>" href="<?php echo ( get_sub_field('link_type') == 'internal' ? get_sub_field('page_link') : get_sub_field('external_url') ); ?>"><?php the_sub_field( 'link_text' ); ?></a>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php if ( have_rows( 'sidebar_links' ) ) : ?>
                    <div class="sidebar-links">
                        <?php while ( have_rows( 'sidebar_links' ) ) : the_row(); ?>
                            <?php $link = get_sub_field( 'link' ); ?>
                            <div class="sidebar-link">
                                <?php if (get_sub_field('link_type') == 'anchor') : ?>
                                    <a class="button anchor-link" href="<?php echo get_sub_field('anchor_link'); ?>"><?php the_sub_field( 'link_text' ); ?></a>
                                <?php else : ?>
                                    <a class="button" href="<?php echo ( get_sub_field('link_type') == 'internal' ? get_sub_field('page_link') : get_sub_field('external_url') ); ?>"><?php the_sub_field( 'link_text' ); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>