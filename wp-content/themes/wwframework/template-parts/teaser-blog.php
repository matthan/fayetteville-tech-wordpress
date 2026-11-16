<a class="teaser teaser-blog" href="<?php the_permalink(); ?>" title="<?php echo wp_strip_all_tags(get_the_title()); ?>" itemscope itemtype="http://schema.org/BlogPosting">
    <div class="sr-text">
        <div itemscope itemtype="https://schema.org/Organization" itemprop="publisher">
            <div itemprop="name"><?php echo esc_attr(get_bloginfo('name', 'display')); ?></div>
            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                <img src="<?php bloginfo('template_directory'); ?>/images/fayettevilletech_logo.png" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" itemprop="url" />
            </div>
        </div>
        <div itemprop="datePublished" content="<?php echo date('c', get_the_time('U')); ?>">
            <?php the_time('F j, Y'); ?>
        </div>
    </div>

    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <?php the_post_thumbnail('medium-crop', array('class' => 'teaser-image', 'itemprop' => 'image url')); ?>
    </div>
    <div class="teaser-content-wrap">
        <div class="teaser-header">
            <h3 class="teaser-title h5" itemprop="headline"><?php the_title(); ?></h3>
            <div class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person">By <span itemprop="name"><?php $a_data = ww_get_author_metas(get_the_author_meta('id')); echo $a_data['formatted_name']; ?></span></div>
        </div>
        <div class="teaser-body" itemprop="description"><?php echo ww_string_limit_words(get_the_excerpt(), 25); ?></div>
    </div>
</a>