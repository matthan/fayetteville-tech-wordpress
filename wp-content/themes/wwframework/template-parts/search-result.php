<?php
$post_type_object = get_post_type_object(get_post_type());

$include_post_type_meta_archive_link = false;
$has_thumbnail = has_post_thumbnail();
$date = false;

// Post Type archive link
if (in_array($post_type_object->name, array('post', 'news', 'tribe_events'))) {
    $include_post_type_meta_archive_link = true;
    $archive_label = str_replace(' Item', '', $post_type_object->labels->singular_name); // Alter label to account for News singular
}

// Set thumbnail attributes for schema.org
if ($has_thumbnail) {
    $thumbnail_attr = array(
        'itemprop' => 'thumbnailUrl',
        'content' => get_the_post_thumbnail_url($post,'thumbnail'),
    );
}

// Get Author info
if ($author_id = get_the_author_meta('id')) {
    $a_data = ww_get_author_metas($author_id);
}

// Set schama.org itemtype, datePublished / start and end dates for events, and venue location schema for Events
switch ($post_type_object->name) {
    case 'post': // blog
        $itemtype = 'http://schema.org/BlogPosting';
        $date = get_the_time('F j, Y');
        break;
    case 'page':
        $itemtype = 'http://schema.org/Article';
        break;
    case 'news':
        $itemtype = 'http://schema.org/NewsArticle';
        $date = get_the_time('F j, Y');
        break;
    case 'tribe_events':
        $itemtype = 'http://schema.org/Event';

        // Get Date Information
        $date = true; // Triggers date markup below
        $timezone = new DateTimeZone(get_option('gmt_offset'));

        $start_datetime = new DateTime(get_field('_EventStartDate'), $timezone);
        $end_datetime = new DateTime(get_field('_EventEndDate'), $timezone);

        $start_date_label = $start_datetime->format('F j, Y - g:ia');
        $start_date_content = $start_datetime->format('c');
        $end_date_label = $end_datetime->format('F j, Y - g:ia');
        $end_date_content = $end_datetime->format('c');

        // If one day event, change $end_date_label
        if ($start_datetime->format('F j') == $end_datetime->format('F j')) {
            $end_date_label =  $end_datetime->format('g:ia');
        }



        // Get Location Information
        if (tribe_has_venue()) {
            $venue_id = tribe_get_venue_id();
            $venue_title = get_the_title($venue_id);
            $venue_metas = get_post_meta($venue_id);

            $venue_url = "http://maps.google.com/?q=" . urlencode("{$venue_metas['_VenueVenue'][0]} {$venue_metas['_VenueCity'][0]} {$venue_metas['_VenueState'][0]} {$venue_metas['_VenueZip'][0]}");

            ob_start();
            ?>
                <span itemscope itemtype="http://schema.org/Place" itemprop="location">
                    <a href="<?php echo $venue_url; ?>" itemprop="name" content="<?php echo $venue_title; ?>"><?php echo $venue_title; ?></a>
                    <span class="sr-text" itemscope itemtype="http://schema.org/PostalAddress" itemprop="address">
                        <span itemprop="streetAddress"><?php echo $venue_metas['_VenueAddress'][0]; ?></span>
                        <span itemprop="addressLocality"><?php echo $venue_metas['_VenueCity'][0]; ?></span>
                        <span itemprop="addressRegion"><?php echo $venue_metas['_VenueState'][0]; ?></span>
                        <span itemprop="postalCode"><?php echo $venue_metas['_VenueZip'][0]; ?></span>
                    </span>
                </span>
            <?php
            $address_markup = ob_get_clean();
        }
        break;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('teaser teaser-search-result'); ?><?php if (isset($itemtype)): ?> itemscope itemtype="<?php echo $itemtype; ?><?php endif; ?>">
    <?php // Begin schema.org screen-reader items ?>
    <div class="sr-text">
        <?php if ($post_type_object->name != 'tribe_events') get_template_part('template-parts/schema', 'publisher'); // publisher applies in all Article types (exclude Event) ?>
        <div itemprop="url"><?php the_permalink(); ?></div>
        <?php if (isset($a_data)): ?>
            <div itemprop="author" itemscope itemtype="http://schema.org/person">
                <div itemprop="name"><?php echo $a_data['formatted_name']; ?></div>
                <?php if ($a_data['job_title']): ?>
                    <div itemprop="jobTitle"><?php echo $a_data['job_title']; ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php // End schema.org screen-reader items ?>

    <?php if (has_post_thumbnail()): ?>
        <div class="thumbnail">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail', $thumbnail_attr); ?></a>
            <meta class="sr-text" itemprop="image" content="<?php the_post_thumbnail_url(); ?>" />
        </div>
    <?php endif; ?>

    <div class="result-main">
        <header>
            <?php if ($include_post_type_meta_archive_link): ?>
                <a class="h6 post-type-archive" title="<?php echo $archive_label; ?> Archive" href="<?php echo get_post_type_archive_link($post_type_object->name); ?>"><?php echo $archive_label; ?></a>
            <?php endif; ?>
            <h2 class="h3 title" itemprop="name headline">
                <a class="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <?php if ($date): ?>
                <?php if ($post_type_object->name == 'tribe_events'): ?>
                    <div class="date">
                        <span itemprop="startDate" content="<?php echo $start_date_content; ?>"><?php echo $start_date_label; ?></span>
                        until
                        <span itemprop="endDate" content="<?php echo $end_date_content; ?>"><?php echo $end_date_label; ?></span><?php if (isset($address_markup)) echo ', ' . $address_markup; ?>
                    </div>
                <?php else: ?>
                    <div class="date" itemprop="datePublished" content="<?php echo date('c', get_the_time('U')); ?>">
                        <?php echo $date; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </header>

        <?php if ($excerpt = get_the_excerpt()): ?>
			<?php if( 'page' === get_post_type() ) : ?>
				<?php //the_field('heading'); ?>
			<?php else : ?>
            <div class="content" itemprop="<?php echo $post_type_object->name == 'tribe_events' ? 'description' : 'articleBody' ?>">
                <?php echo ww_string_limit_words($excerpt, 45); ?>
            </div>
			<?php endif; ?>
        <?php endif; ?>
    </div>
</article>
