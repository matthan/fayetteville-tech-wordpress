<?php
global $USER_IDS;

if (!isset($author_id)) { // Allows you to define author id in higher-level context ahead of pulling template
    $author_id = get_the_author_meta('id');
}

$is_person = true;

if (isset($author_id) && $author_id == $USER_IDS['fayettevilletech']) {
    $is_person = false;
    $itemtype = 'http://schema.org/Organization';
}
else {
    $itemtype = 'http://schema.org/Person';
}

$a_data = ww_get_author_metas($author_id);
?>
<div class="author-meta" itemprop="author" itemscope itemtype="<?php echo $itemtype; ?>">
    <div class="flex-wrap">

        <img src="<?php echo $a_data['profile_picture']['url']; ?>" alt="<?php echo $a_data['profile_picture']['alt']; ?>" class="avatar">
        <div class="author-details">
            <div class="author" itemprop="name"><?php echo $a_data['formatted_name']; ?></div>
            <?php if ($a_data['job_title']): ?>
                <div class="job-title"<?php if ($is_person): ?> itemprop="jobTitle"<?php endif; ?>><?php echo $a_data['job_title']; ?></div>
            <?php endif; ?>
            <?php if ($a_data['facebook'] || $a_data['twitter'] || $a_data['linkedin']): ?>
                <ul class="social">
                    <?php if ($a_data['facebook']): ?>
                        <li>
                            <a href="<?php echo $a_data['facebook']; ?>" title="<?php echo 'Facebook'; ?>">
                                <i class="icon-facebook" aria-hidden="true"></i>
                                <span class="sr-text">Facebook</span>
                            </a>
                        </li>
                    <?php endif; if ($a_data['twitter']): ?>
                        <li>
                            <a href="https://twitter.com/<?php echo $a_data['twitter']; ?>" title="<?php echo 'Twitter'; ?>">
                                <i class="icon-twitter" aria-hidden="true"></i>
                                <span class="sr-text">Twitter</span>
                            </a>
                        </li>
                    <?php endif; if ($a_data['linkedin']): ?>
                        <li>
                            <a href="<?php echo $a_data['linkedin']; ?>" title="<?php echo 'LinkedIn'; ?>">
                                <i class="icon-linkedin" aria-hidden="true"></i>
                                <span class="sr-text">LinkedIn</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>