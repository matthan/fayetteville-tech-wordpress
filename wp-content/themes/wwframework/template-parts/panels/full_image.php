<?php $image = get_sub_field( 'image' ); ?>

<div aria-label="Full sized image" class="panel panel-full-image">
	<div class="container-full">
        <?php if ( $image ) { ?>
            <img src="<?php echo $image['sizes']['full-size']; ?>" alt="<?php echo $image['alt']; ?>" />
        <?php } ?>
	</div>
</div>