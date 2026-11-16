<div aria-label="Gridded callout tiles with links" class="panel panel-grid-tiles">
    <div class="container">
        <div class="tiles-wrap <?php the_sub_field('box_size'); ?>">
            <?php if (get_sub_field('include_box_outline')): ?>
                <div class="box-outline direction-<?php the_sub_field('box_outline_direction'); ?>"></div>
            <?php endif; ?>
            <ul class="tiles tiles-grid">
                <?php while (have_rows( 'grid_tiles' )): the_row(); ?>
                    <?php
                    $tile_config['element'] = 'li';
                    include locate_template('template-parts/tile.php');
                    ?>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>