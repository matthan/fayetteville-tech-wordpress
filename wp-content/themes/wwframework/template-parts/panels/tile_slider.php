<div aria-label="Carousel of callout tiles with links" class="panel panel-tile-slider">
    <ul class="tiles tiles-slider">
        <?php while (have_rows( 'slider_tiles' )): the_row(); ?>
            <?php
            $tile_config['element'] = 'li';
            include locate_template('template-parts/tile.php');
            ?>
        <?php endwhile; ?>
    </ul>
    <div class="pager-arrows"></div>
</div>