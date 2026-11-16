<?php $bgcolor = get_sub_field( 'background_color' ); ?>

<div class="panel panel-basic-content bg-<?php echo $bgcolor; ?>">
	<div class="container container-<?php the_sub_field( 'content_width' ); ?>">
        <div class="row-flex">
            <div class="col-100">
                <?php the_sub_field( 'content' ); ?>
            </div>
        </div>
	</div>
</div>