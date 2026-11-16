<?php $image = get_sub_field( 'image' ); ?>
<?php if( get_sub_field('style') == 'narrow-grey' ) : ?><div class="grey-bg"><?php endif; ?>
<?php if( get_sub_field('style') == 'narrow' || get_sub_field('style') == 'narrow-grey' ) : ?><div class="container"><?php endif; ?>
<div aria-label="<?php the_sub_field('heading'); ?>" class="panel panel-media-content <?php the_sub_field( 'style' ); ?> <?php the_sub_field( 'layout' ); ?>"<?php if( get_sub_field('style') == 'dark' ) : ?> style="background-image: url(<?php echo $image['sizes']['full-size']; ?>)"<?php endif; ?>>
    <div class="image-side">
        <?php if( get_sub_field('style') != 'dark' ) : ?>
        <?php if( get_sub_field('label') ) : ?><span class="image-label"><?php the_sub_field( 'label' ); ?></span><?php endif; ?>
        <?php if( get_sub_field( 'video_url' ) ) : ?>
            <a data-fancybox="videobox"  href="<?php the_sub_field( 'video_url' ); ?>?autoplay=1">
        <?php endif; ?>
            <div class="image-box <?php the_sub_field( 'image_color' ); ?><?php if( get_sub_field( 'video_url' ) ) : ?> video-holder<?php endif; ?>">
                <?php if ( $image ) { ?>
                    <img class="<?php the_sub_field( 'image_color' ); ?>" src="<?php echo $image['sizes']['half-size']; ?>" alt="<?php echo $image['alt']; ?>" />
                <?php } ?>
            </div>
        <?php if( get_sub_field( 'video_url' ) ) : ?>
            </a>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="content-side">
        <div class="content-box">
            <?php if(get_sub_field('content_label')) : ?><h6 class="label-underlined"><?php the_sub_field( 'content_label' ); ?></h6><?php endif; ?>
            <?php if(get_sub_field('heading')) : ?><h3><?php echo highlightText(get_sub_field('heading')); ?></h3><?php endif; ?>
            <div class="content-body">
                <?php the_sub_field( 'content' ); ?>
            </div>
        </div>
    </div>
</div>
<?php if( get_sub_field('style') == 'narrow' || get_sub_field('style') == 'narrow-grey' ) : ?></div><?php endif; ?>
	<?php if( get_sub_field('style') == 'narrow-grey' ) : ?></div><?php endif; ?>