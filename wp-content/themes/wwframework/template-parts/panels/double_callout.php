<div aria-label="Callout content" class="panel panel-double-callout">
	<div class="container">
        <div class="row-flex">
            <?php
                $rows = get_sub_field('callouts');
                $row_count = count($rows);
            ?>
            <?php if ( have_rows( 'callouts' ) ) : ?>
                <?php while ( have_rows( 'callouts' ) ) : the_row(); ?>
                    <div class="<?php echo ($row_count == 2 ? 'col-50' : 'col-33'); ?>">
                        <div class="callout">
                            <div class="icon">
                                <?php $icon = get_sub_field( 'icon' ); ?>
                                <?php
                                if ( !empty( $icon ) ):
                                    $url = $icon['url'] ;
                                    $ext = pathinfo( $url, PATHINFO_EXTENSION ); ?>
                                    <div class="icons"> <?php
                                        if ( $ext == 'svg' ):
                                            echo file_get_contents( $url ) ;
                                        // Non SVG Fallback
                                        else: ?>
                                            <img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>"> <?php
                                        endif; ?>
                                    </div>  <?php
                                endif;
                                ?>
                            </div>
                            <div class="content">
                                <?php if (get_sub_field('heading')) : ?><h3 class="alt"><?php echo highlightText(get_sub_field('heading')); ?></h3><?php endif; ?>
                                <?php if (get_sub_field('link_type') == 'anchor') : ?>
                                    <a class="btn btn-default anchor-link" role="button" aria-label="<?php the_sub_field( 'link_text' ); ?>" href="<?php echo get_sub_field('anchor_link'); ?>"><?php the_sub_field( 'link_text' ); ?> <i class="icon-arrow-right" aria-hidden="true"></i></a>
                                <?php else : ?>
                                    <a class="btn btn-default" role="button" aria-label="<?php the_sub_field( 'link_text' ); ?>" href="<?php echo ( get_sub_field('link_type') == 'internal' || get_sub_field('link_type') == null ? get_sub_field('page_link') : get_sub_field('external_url') ); ?>"><?php the_sub_field( 'link_text' ); ?> <i class="icon-arrow-right" aria-hidden="true"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
	</div>
</div>