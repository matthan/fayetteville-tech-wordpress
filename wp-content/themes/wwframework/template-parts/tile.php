<?php
$tile_config_default = array(
    'element' => 'div',
);

// Merge passed config options
$tile_config = (isset($tile_config)) ? array_merge($tile_config_default, $tile_config) : $tile_config_default;

$tile_data = array(
    'type' => get_sub_field('tile_type'),
    'style' => get_sub_field('tile_style'),
    'size' => get_sub_field('tile_size'),
    'bg_image' => get_sub_field('tile_bg_image'),
    'bg_style' => get_sub_field('background_style'),
    'label' => get_sub_field('tile_label'),
    'title' => get_sub_field('tile_title'),
    'subtext' => get_sub_field('tile_subtext'),
    'content' => get_sub_field('tile_content'),
    'link' => get_sub_field('link'),
    'links' => get_sub_field('tile_links'),
);

$has_subtext = false;
$has_link = false;
$has_links = false;
$has_bg_image = $tile_data['bg_image'] ? true : false;

// Set booleans that can't be easily checked for empty/not empty inline within template
switch ($tile_data['type']) {
    case 'teaser':
        $has_link = $tile_data['link'] ? true : false;
        break;
    case 'teaser_short':
        $has_subtext = $tile_data['subtext'] ? true : false;
        $has_link = $tile_data['link'] ? true : false;
        break;
    case 'links':
        $has_links = true;
        break;
}

$linky = get_sub_field( 'link' );
?>
<<?php echo $tile_config['element']; ?> class="tile type-<?php echo str_replace('_', '-', $tile_data['type']); ?> style-<?php echo $tile_data['style']; ?> size-<?php echo $tile_data['size']; ?><?php if ($has_bg_image): ?> has-bg-image<?php endif; ?>">
    <?php if ($has_bg_image): ?>
        <div class="tile-bg-image <?php echo $tile_data['bg_style']; ?>" style="background-image: url('<?php echo $tile_data['bg_image']['sizes']['medium']; ?>');">
            <span class="sr-text"><?php echo $tile_data['bg_image']['alt']; ?></span>
        </div>
    <?php endif; ?>
        <div class="tile-foreground">
            <?php if ($tile_data['type'] == 'teaser_short'): ?>
                <?php if ($has_link): ?>
                    <?php if ($linky['link_type'] == 'anchor') : ?>
                        <a class="tile-link-over anchor-link" href="<?php echo $linky['anchor_link']; ?>"></a>
                    <?php else : ?>
                        <a class="tile-link-over" href="<?php echo $linky['link_type'] == 'internal' ? $linky['page_link'] : $linky['external_url']; ?>"></a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <div class="tile-foreground-inner">
                <?php if ($tile_data['label']): ?>
                    <h3 class="h6"><?php echo $tile_data['label']; ?></h3>
                <?php endif; ?>
                <?php if ($tile_data['title'] || $has_subtext): ?>
                    <div class="title-wrap title-wrap-<?php echo ($tile_data['type'] == 'teaser') ? 'bottom' : 'center'; ?>">
                        <?php if ($tile_data['title']): ?>
                            <h2><?php echo ultraFont($tile_data['title']); ?></h2>
                        <?php endif; ?>
                        <?php if ($has_subtext): ?>
                            <p class="subtext"><?php echo $tile_data['subtext']; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ($has_links): ?>
                    <div class="tile-links-wrap">
                        <ul class="tile-links">
                            <?php if ( have_rows( 'tile_links' ) ) : ?>
                                <?php while ( have_rows( 'tile_links' ) ) : the_row(); ?>
                                    <li>
                                        <?php $linky = get_sub_field( 'linky' ); ?>
                                        <?php if ($linky['link_type'] == 'anchor') : ?>
                                            <a class="anchor-link" href="<?php echo $linky['anchor_link']; ?>"><?php echo $linky['link_text']; ?> <i class="icon-arrow-right"></i></a>
                                        <?php else : ?>
                                            <a href="<?php echo $linky['link_type'] == 'internal' ? $linky['page_link'] : $linky['external_url']; ?>"><?php echo $linky['link_text']; ?> <i class="icon-arrow-right"></i></a>
                                        <?php endif; ?>
                                    </li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if( $has_link && !$has_links ) : ?>
                    <span class="tile-link h6">Learn More</span>
                <?php endif; ?>
            </div>
        </div>
    <?php if ($tile_data['type'] == 'teaser'): ?>
        <div class="tile-background">
            <?php if ($has_link): ?>
                <?php if ($linky['link_type'] == 'anchor') : ?>
                    <a class="tile-link-over anchor-link" href="<?php echo $linky['anchor_link']; ?>"></a>
                <?php else : ?>
                    <a class="tile-link-over" href="<?php echo $linky['link_type'] == 'internal' ? $linky['page_link'] : $linky['external_url']; ?>"></a>
                <?php endif; ?>
            <?php endif; ?>
            <div class="tile-background-content-wrap">
                <?php if ($tile_data['title']): ?>
                    <?php if ($has_link): ?>
                        <?php if ($linky['link_type'] == 'anchor') : ?>
                            <h2><a class="anchor-link" href="<?php echo $linky['anchor_link']; ?>"><?php echo ultraFont($tile_data['title']); ?></a></h2>
                        <?php else : ?>
                            <h2><a href="<?php echo $linky['link_type'] == 'internal' ? $linky['page_link'] : $linky['external_url']; ?>"><?php echo ultraFont($tile_data['title']); ?></a></h2>
                        <?php endif; ?>
                    <?php else: ?>
                        <h2><?php echo ultraFont($tile_data['title']); ?></h2>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($tile_data['content']): ?>
                    <p class="content"><?php echo $tile_data['content']; ?></p>
                <?php endif; ?>
            </div>
            <?php if( $has_link && !$has_links ) : ?>
                <span class="tile-link h6">Learn More</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</<?php echo $tile_config['element']; ?>>
