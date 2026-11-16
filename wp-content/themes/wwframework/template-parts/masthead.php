<?php
$masthead['masthead_type'] = $masthead['masthead_type'] ?: 'standard'; // Set default if not set

switch ($masthead['masthead_type']) {
    case 'standard':
        $has_content = $masthead['content'] ? true : false;
        break;
    case 'image_heading':
        $has_content = false;
        $masthead['masthead_size'] = 'large'; // Force large for this view
        break;
}

// Normalize masthead_image->url to use full-size image size, no matter the context in which this template is called
if (isset($masthead['masthead_image']['url'])) {
    if ($image_id = attachment_url_to_postid($masthead['masthead_image']['url'])) {
        $attachment_src = wp_get_attachment_image_src($image_id, 'full-size');
        $masthead['masthead_image']['url'] = $attachment_src[0];
    }
}

?>
<div class="masthead masthead-type-<?php echo str_replace('_', '-', $masthead['masthead_type']); ?> masthead-size-<?php echo $masthead['masthead_size']; ?>">
    <?php if ($masthead['masthead_image']): ?>
        <div class="masthead-image" style="background-image: url('<?php echo $masthead['masthead_image']['url']; ?>');">
            <img src="<?php echo $masthead['masthead_image']['url']; ?>" alt="<?php echo $masthead['masthead_image']['alt']; ?>" class="sr-text" itemprop="image">
        </div>
        <div class="masthead-box">
            <div class="masthead-headings">
                <h1 class="masthead-heading" itemprop="headline"><?php if( $masthead['heading'] ) { echo highlightText($masthead['heading']); } else { the_title(); } ?></h1>
                <?php if ($has_content): ?>
                    <div class="masthead-subheading" itemprop="description"><?php echo highlightText($masthead['content']); ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="container">
            <h1 class="masthead-title" itemprop="headline"><?php the_title(); ?></h1>
        </div>
    <?php endif; ?>

</div>