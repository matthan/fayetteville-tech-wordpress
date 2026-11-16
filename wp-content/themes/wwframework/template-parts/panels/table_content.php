<div aria-label="<?php the_sub_field('heading'); ?>" class="panel panel-table-content <?php the_sub_field( 'layout' ); ?>">
	<div class="container">
        <div class="row-flex">
            <div class="col-100">
                <?php if(get_sub_field('heading')) : ?><h4 class="alt"><?php the_sub_field( 'heading' ); ?></h4><?php endif; ?>
                <?php the_sub_field( 'content' ); ?>
            </div>
        </div>
	</div>
</div>