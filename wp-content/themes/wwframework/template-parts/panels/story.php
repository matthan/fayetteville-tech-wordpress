<div aria-label="<?php the_sub_field('heading'); ?>" class="panel panel-story <?php the_sub_field( 'layout' ); ?>">
    <div class="h-box">
        <div class="h-image">
            <?php if(get_sub_field('heading')) : ?>
                <div class="heading">
                    <h3><?php the_sub_field( 'heading' ); ?></h3>
                </div>
            <?php endif; ?>
            <?php $horizontal_image = get_sub_field( 'horizontal_image' ); ?>
            <?php if ( $horizontal_image ) { ?>
                <div class="image blend-mode">
                    <img src="<?php echo $horizontal_image['sizes']['half-size']; ?>" alt="<?php echo $horizontal_image['alt']; ?>" />
                </div>
            <?php } ?>
        </div>
        <div class="content-box">
            <div class="content">
                <?php the_sub_field( 'content' ); ?>
            </div>
        </div>
    </div>
    <div class="v-box">
        <div class="v-image">
            <?php $vertical_image = get_sub_field( 'vertical_image' ); ?>
            <?php if ( $vertical_image ) { ?>
                <div class="image">
                    <img src="<?php echo $vertical_image['sizes']['half-size']; ?>" alt="<?php echo $vertical_image['alt']; ?>" />
                </div>
            <?php } ?>
        </div>
    </div>
</div>