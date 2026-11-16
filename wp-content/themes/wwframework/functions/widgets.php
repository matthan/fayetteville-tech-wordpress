<?php

function ww_widgets_init()
{
    if (!is_blog_installed())
        return;

    //register_widget('widget');
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'ww_widgets_init', 10);

?>
