<?php $bgcolor = get_sub_field( 'background_color' ); ?>

<div aria-label="Section heading" class="panel panel-heading bg-<?php echo $bgcolor; ?>">
	<div class="container">
        <div class="row-flex">
            <div class="col-100">
                <?php if(get_sub_field('heading')) : ?><h2><?php echo highlightText(get_sub_field('heading')); ?></h2><?php endif; ?>
                <?php the_sub_field( 'content' ); ?>
            </div>
        </div>
	</div>
</div>