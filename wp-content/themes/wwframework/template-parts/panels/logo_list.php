<div aria-label="<?php the_sub_field('heading'); ?>" class="panel panel-logo-list">
	<div class="container">
        <?php if(get_sub_field('heading')) : ?>
            <div class="row-flex">
                <div class="col-100">
                    <h4 class="alt"><?php echo highlightText( get_sub_field('heading') ); ?></h4>
                </div>
            </div>
        <?php endif; ?>
        <?php if ( have_rows( 'logos' ) ) : ?>
            <div class="row-flex logo-list">
                <?php while ( have_rows( 'logos' ) ) : the_row(); ?>
                    <div class="col col-25">
                        <?php $logo = get_sub_field( 'logo' ); ?>
                        <?php if ( $logo ) { ?>
                            <?php if( get_sub_field('link_type') != 'nolink' && get_sub_field('link_type') != '' ) : ?>
                                <?php if (get_sub_field('link_type') == 'anchor') : ?>
                                    <a class="anchor-link" href="<?php echo get_sub_field('anchor_link'); ?>">
                                <?php else : ?>
                                    <a href="<?php echo ( get_sub_field('link_type') == 'internal' || get_sub_field('link_type') == null ? get_sub_field('page_link') : get_sub_field('external_url') ); ?>">
                                <?php endif; ?>
                            <?php endif; ?>
                                    <img class="logo" src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" />
                            <?php if( get_sub_field('link_type') != 'nolink' && get_sub_field('link_type') != '' ) : ?>
                                </a>
                            <?php endif; ?>
                        <?php } ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
	</div>
</div>