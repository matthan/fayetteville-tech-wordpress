<div class="teaser teaser-news" itemscope itemtype="http://schema.org/NewsArticle">
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
        <?php
        // Author should always be Fayetteville Tech
        global $USER_IDS;
        $a_data = ww_get_author_metas($USER_IDS['fayettevilletech']);
        ?>
        <div itemprop="author" itemscope itemtype="http://schema.org/person">
            <div itemprop="name"><?php echo $a_data['formatted_name']; ?></div>
            <?php if ($a_data['job_title']): ?>
                <div class="job-title" itemprop="jobTitle"><?php echo $a_data['job_title']; ?></div>
            <?php endif; ?>
        </div>
        <?php
        // Image schema
        $global_options = get_fields('options');
        if (has_post_thumbnail()) {
            $image_url = get_the_post_thumbnail_url();
        }
        else {
            $image_url = $global_options['news_masthead']['masthead_image']['url'];
        }
        ?>
        <meta itemprop="image" content="<?php echo $image_url; ?>">
    </div>

    <div class="row-flex">
        <div class="teaser-date">
            <div class="vcard">
                <div class="author location">
                    <div class="updated published time-details">
                        <span class="date-start dtstart">
                            <span class="the-day"><?php the_time('j'); ?></span>
                            <span class="the-month"><?php the_time('M'); ?></span>
                            <?php if (get_the_time('Y') != date('Y')) : ?>
                                <span class="the-year"><?php the_time('Y'); ?></span>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="teaser-header">
            <h2 class="news-title entry-title summary">
                <a class="url" href="<?php echo esc_url(tribe_get_event_link()); ?>" title="<?php the_title_attribute(); ?>">
                    <span itemprop="headline"><?php the_title() ?></span>
                </a>
            </h2>
        </div>
    </div>

</div>

