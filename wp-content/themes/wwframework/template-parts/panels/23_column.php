<?php $bgcolor = get_sub_field( 'background_color' ); ?>

<div aria-label="Columned content" class="panel panel-two-three-column bg-<?php echo $bgcolor; ?>">
	<div class="container">
        <div class="row-flex">
            <?php $layout = get_sub_field( 'layouts' ); ?>
            <?php $col = ( $layout == '3col' ) ? '33' : '50';?>
            <div class="col-<?php echo $col; ?>">
                <?php the_sub_field( 'column_1_content' ); ?>
            </div>
            <div class="col-<?php echo $col; ?>">
                <?php the_sub_field( 'column_2_content' ); ?>
            </div>
            <?php if( $layout == '3col' ) : ?>
                <div class="col-33">
                    <?php the_sub_field( 'column_3_content' ); ?>
                </div>
            <?php endif; ?>
        </div>



        <?php $side_image = get_sub_field( 'side_image' ); ?>
        <?php if ( $side_image ) { ?>
            <img src="<?php echo $side_image['url']; ?>" alt="<?php echo $side_image['alt']; ?>" />
        <?php } ?>
        <?php the_sub_field( 'youtube_video_link' ); ?>

	</div>
</div>