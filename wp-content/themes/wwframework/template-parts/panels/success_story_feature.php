<div aria-label="<?php the_sub_field('heading'); ?>" class="panel panel-success-story-feature style-<?php the_sub_field('story_style'); ?>">
    <header>
        <div class="container">
            <div class="row-flex">
                <?php if(get_sub_field('heading')) : ?>
                    <div class="col-50">
                        <h2><?php the_sub_field('header'); ?></h2>
                    </div>
                <?php endif; ?>
                <div class="col-50">
                    <div class="content"><?php the_sub_field('content'); ?></div>
                </div>
            </div>
        </div>
    </header>
    <div class="stories-wrap">
        <ul class="stories">
            <?php while (have_rows( 'stories' )): the_row(); ?>
                <li class="story">
                    <?php $image = get_sub_field('image'); ?>
                    <div class="story-image-wrap">
                        <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>">
                    </div>
                    <div class="story-content-wrap">
                        <div class="flex-wrap">
                            <?php if(get_sub_field('label')) : ?><h4 class="h6 label-underlined"><?php the_sub_field('label'); ?></h4><?php endif; ?>
                            <?php if(get_sub_field('heading')) : ?><h3><?php the_sub_field('header'); ?></h3><?php endif; ?>
                            <div class="story-content"><?php the_sub_field('content'); ?></div>
                            <a class="btn btn-default" role="button" aria-label="Read More" href="<?php the_sub_field('page'); ?>">Read More <i class="icon-arrow-right"></i></a>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
        <ul class="thumbnails">
            <?php $i = 0; while (have_rows( 'stories' )): the_row(); ?>
                <li class="thumbnail<?php if ($i == 0): ?> active<?php endif; ?>" data-slick-slide="<?php echo $i; ?>">
                    <?php $image = get_sub_field('image'); ?>
                    <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?> - Thumbnail">
                </li>
                <?php $i++; ?>
            <?php endwhile; ?>
        </ul>
        <div class="pager-dots"></div>
        <div class="pager-arrows"></div>
    </div>
</div>
