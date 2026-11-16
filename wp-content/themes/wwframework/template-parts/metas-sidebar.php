<div class="sidebar-metas">
    <?php get_template_part('template-parts/schema', 'publisher'); ?>
    <?php if (is_singular('post')): ?>
        <div class="sidebar-meta-item">
            <h2 class="h3">Publish Date</h2>
            <div class="sidebar-meta-data" itemprop="datePublished" content="<?php echo get_post_time('c'); ?>"><?php  the_time('F j, Y'); ?></div>
        </div>
    <?php endif; ?>
    <?php
    $categories = get_the_category();
    $category_links = array();

    foreach ($categories as $category) {
        $category_links[] = '<a href="' . get_category_link($category) . '">' . $category->name . '</a>';
    }

    if ($category_links):
        ?>
        <div class="sidebar-meta-item">
            <h2 class="h3">Categories</h2>
            <div class="sidebar-meta-data"><?php echo implode(', ', $category_links); ?></div>
        </div>
    <?php endif; ?>
    <div class="sidebar-meta-item">
        <h2 class="h3">Share</h2>
        <ul class="sidebar-meta-data share-icons">
            <li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" data-ga-click-category="Facebook" class="ga-share-click facebook" title="<?php echo 'Facebook'; ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="icon icon-facebook"></i></a></li>
            <li><a href="https://twitter.com/share?url=<?php the_permalink(); ?>" data-ga-click-category="Twitter" class="ga-share-click twitter" title="<?php echo 'Twitter'; ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="icon icon-twitter"></i></a></li>
            <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>" data-ga-click-category="LinkedIn" class="ga-share-click linkedin" title="<?php echo 'LinkedIn'; ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="icon icon-linkedin"></i></a></li>
            <li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" data-ga-click-category="Google+" class="ga-share-click google-plug" title="<?php echo 'Google+'; ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="icon icon-google-plus"></i></a></li>
        </ul>
    </div>
</div>