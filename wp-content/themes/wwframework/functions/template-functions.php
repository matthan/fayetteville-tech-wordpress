<?php

//Excerpt Word Length
function ww_string_limit_words($string, $word_limit)
{
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit)
        array_pop($words);
    return implode(' ', $words) . ' ...';
}

function ww_post_meta()
{

    if ('post' == get_post_type())
        ww_entry_date();

    // Post author
    if ('post' == get_post_type()) {
        printf(' <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
            esc_url(get_author_posts_url(get_the_author_meta('ID'))),
            esc_attr(sprintf(__('View all posts by %s', 'twentythirteen'), get_the_author())),
            get_the_author()
        );
    }
}

function ww_post_footer()
{
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list(__(', ', 'twentythirteen'));
    if ($categories_list) {
        echo '<span class="categories-links">' . $categories_list . '</span>';
    }

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list('', __(', ', 'twentythirteen'));
    if ($tag_list) {
        echo '<span class="tags-links">' . $tag_list . '</span>';
    }
}

function ww_entry_date($echo = true)
{
    $format_prefix = '%2$s';

    $date = sprintf('<span class="date" itemprop="datePublished" content="%5$s"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
        esc_url(get_permalink()),
        esc_attr(sprintf(__('Permalink to %s', 'twentythirteen'), the_title_attribute('echo=0'))),
        esc_attr(get_the_date('c')),
        esc_html(sprintf($format_prefix, get_post_format_string(get_post_format()), get_the_date())),
        get_the_date('Y-m-d')
    );

    if ($echo)
        echo $date;

    return $date;
}

function ww_pagination($args = array(), $query = '')
{
    global $wp_rewrite, $wp_query;


    if ($query) {

        $wp_query = $query;

    } // End IF Statement

    /* If there's not more than one page, return nothing. */
    if (1 >= $wp_query->max_num_pages)
        return;

    /* Get the current page. */
    $current = (get_query_var('paged') ? absint(get_query_var('paged')) : 1);

    /* Get the max number of pages. */
    $max_num_pages = intval($wp_query->max_num_pages);

    /* Set up some default arguments for the paginate_links() function. */
    $defaults = array(
        'base' => add_query_arg('paged', '%#%'),
        'format' => '',
        'total' => $max_num_pages,
        'current' => $current,
        'prev_next' => true,
        'prev_text' => __('<i class="icon-arrow-left"></i><span class="sr-text">Previous</span>', 'wwthemes'), // Translate in WordPress. This is the default.
        'next_text' => __('<span class="sr-text">Next</span><i class="icon-arrow-right"></i>', 'wwthemes'), // Translate in WordPress. This is the default.
        'show_all' => false,
        'end_size' => 1,
        'mid_size' => 1,
        'add_fragment' => '',
        'type' => 'plain',
        'before' => '<div class="pagination ww-pagination">', // Begin ww_pagination() arguments.
        'after' => '</div>',
        'echo' => true,
        'use_search_permastruct' => true
    );

    /* Allow themes/plugins to filter the default arguments. */
    $defaults = apply_filters('ww_pagination_args_defaults', $defaults);

    /* Add the $base argument to the array if the user is using permalinks. */
    if ($wp_rewrite->using_permalinks() && !is_search())
        $defaults['base'] = user_trailingslashit(trailingslashit(get_pagenum_link()) . 'page/%#%');

    /* Force search links to use raw permastruct for more accurate multi-word searching. */
    if (is_search())
        $defaults['use_search_permastruct'] = false;

    /* If we're on a search results page, we need to change this up a bit. */
    if (is_search()) {
        /* If we're in BuddyPress, or the user has selected to do so, use the default "unpretty" URL structure. */
        if (class_exists('BP_Core_User') || $defaults['use_search_permastruct'] == false) {
            $search_query = get_query_var('s');
            $paged = get_query_var('paged');
            $base = add_query_arg('s', urlencode($search_query));
            $base = add_query_arg('paged', '%#%');
            $defaults['base'] = $base;
        } else {
            $search_permastruct = $wp_rewrite->get_search_permastruct();
            if (!empty($search_permastruct)) {
                $base = get_search_link();
                $base = add_query_arg('paged', '%#%', $base);
                $defaults['base'] = $base;
            }
        }
    }

    /* Merge the arguments input with the defaults. */
    $args = wp_parse_args($args, $defaults);

    /* Allow developers to overwrite the arguments with a filter. */
    $args = apply_filters('ww_pagination_args', $args);

    /* Don't allow the user to set this to an array. */
    if ('array' == $args['type'])
        $args['type'] = 'plain';

    /* Make sure raw querystrings are displayed at the end of the URL, if using pretty permalinks. */
    $pattern = '/\?(.*?)\//i';

    preg_match($pattern, $args['base'], $raw_querystring);

    if ($wp_rewrite->using_permalinks() && $raw_querystring) {
        $raw_querystring[0] = str_replace('', '', $raw_querystring[0]);
        @$args['base'] = str_replace($raw_querystring[0], '', $args['base']);
        @$args['base'] .= substr($raw_querystring[0], 0, -1);
    }

    /* Get the paginated links. */
    $page_links = paginate_links($args);

    /* Remove 'page/1' from the entire output since it's not needed. */
    $page_links = str_replace(array('&#038;paged=1\'', '/page/1\''), '\'', $page_links);

    /* Wrap the paginated links with the $before and $after elements. */
    $page_links = $args['before'] . $page_links . $args['after'];

    /* Allow devs to completely overwrite the output. */
    $page_links = apply_filters('ww_pagination', $page_links);


    /* Return the paginated links for use in themes. */
    if ($args['echo'])
        echo $page_links;
    else
        return $page_links;
}

function ww_breadcrumbs($args = array())
{
    global $wp_query, $wp_rewrite;

    /* Create an empty variable for the breadcrumb. */
    $breadcrumb = '';

    /* Create an empty array for the trail. */
    $trail = array();
    $path = '';

    /* Set up the default arguments for the breadcrumb. */
    $defaults = array(
        'separator' => '<span>⌃</span><span>⌃</span>',
        'before' => '',
        'after' => false,
        'front_page' => true,
        'show_home' => 'Home',
        'echo' => true,
        'show_posts_page' => true
    );

    /* Allow singular post views to have a taxonomy's terms prefixing the trail. */
    if (is_singular())
        $defaults["singular_{$wp_query->post->post_type}_taxonomy"] = false;


    /* Parse the arguments and extract them for easy variable naming. */
    extract(wp_parse_args($args, $defaults));

    /* If $show_home is set and we're not on the front page of the site, link to the home page. */
    if (!is_front_page() && $show_home)
        $trail[] = '<a href="' . esc_url(home_url()) . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home" class="trail-begin">' . esc_html($show_home) . '</a>';

    /* If viewing the front page of the site. */
    if (is_front_page()) {
        if (!$front_page)
            $trail = false;
        elseif ($show_home)
            $trail['trail_end'] = "{$show_home}";
    } /* If viewing the "home"/posts page. */
    elseif (is_home()) {
        $home_page = get_page($wp_query->get_queried_object_id());
        $trail = array_merge($trail, ww_breadcrumbs_get_parents($home_page->post_parent, ''));
        $trail['trail_end'] = get_the_title($home_page->ID);
    } /* If viewing a singular post (page, attachment, etc.). */
    elseif (is_singular()) {

        /* Get singular post variables needed. */
        $post = $wp_query->get_queried_object();
        $post_id = absint($wp_query->get_queried_object_id());
        $post_type = $post->post_type;
        $parent = $post->post_parent;

        /* If a custom post type, check if there are any pages in its hierarchy based on the slug. */
        if ('page' !== $post_type && 'post' !== $post_type) {

            $post_type_object = get_post_type_object($post_type);

            /* If $front has been set, add it to the $path. */
            if ('post' == $post_type || 'attachment' == $post_type || ($post_type_object->rewrite['with_front'] && $wp_rewrite->front))
                $path .= trailingslashit($wp_rewrite->front);

            /* If there's a slug, add it to the $path. */
            if (!empty($post_type_object->rewrite['slug']))
                $path .= $post_type_object->rewrite['slug'];

            /* If there's a path, check for parents. */
            if (!empty($path) && '/' != $path)
                $trail = array_merge($trail, ww_breadcrumbs_get_parents('', $path));

            /* If there's an archive page, add it to the trail. */
            if (!empty($post_type_object->has_archive) && function_exists('get_post_type_archive_link'))
                $trail[] = '<a href="' . get_post_type_archive_link($post_type) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . $post_type_object->labels->name . '</a>';
        }

        /* If the post type path returns nothing and there is a parent, get its parents. */
        if (empty($path) && 0 !== $parent || 'attachment' == $post_type)
            $trail = array_merge($trail, ww_breadcrumbs_get_parents($parent, ''));

        /* Toggle the display of the posts page on single blog posts. */
        if ('post' == $post_type && $show_posts_page == true && 'page' == get_option('show_on_front')) {
            $posts_page = get_option('page_for_posts');
            if ($posts_page != '' && is_numeric($posts_page)) {
                $trail = array_merge($trail, ww_breadcrumbs_get_parents($posts_page, ''));
            }
        }

        /* Display terms for specific post type taxonomy if requested. */
        if (isset($args["singular_{$post_type}_taxonomy"]) && $terms = get_the_term_list($post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', ''))
            $trail[] = $terms;

        /* End with the post title. */
        $post_title = get_the_title($post_id); // Force the post_id to make sure we get the correct page title.
        if (!empty($post_title))
            $trail['trail_end'] = $post_title;
    } /* If we're viewing any type of archive. */
    elseif (is_archive()) {

        /* If viewing a taxonomy term archive. */
        if (is_tax() || is_category() || is_tag()) {
            /* Get some taxonomy and term variables. */
            $term = $wp_query->get_queried_object();
            $taxonomy = get_taxonomy($term->taxonomy);

            /* Get the path to the term archive. Use this to determine if a page is present with it. */
            if (is_category()) {
                $path = get_option('category_base');
                $post_type = get_post_type_object($taxonomy->object_type[0]);
                $term_name = $post_type->labels->singular_name . ' ' . $taxonomy->labels->singular_name . ' - ' . $term->name;
            }
            elseif (is_tag()) {
                $path = get_option('tag_base');
                $term_name = $term->name;
            }
            else {
                if ($taxonomy->rewrite['with_front'] && $wp_rewrite->front)
                    $path = trailingslashit($wp_rewrite->front);
                $path .= $taxonomy->rewrite['slug'];

                $term_name = $term->name;
            }

            /* Get parent pages by path if they exist. */
            if ($path)
                $trail = array_merge($trail, ww_breadcrumbs_get_parents('', $path));

            /* If the taxonomy is hierarchical, list its parent terms. */
            if (is_taxonomy_hierarchical($term->taxonomy) && $term->parent)
                $trail = array_merge($trail, ww_breadcrumbs_get_term_parents($term->parent, $term->taxonomy));

            /* Add the term name to the trail end. */

            $trail['trail_end'] = $term_name;
        } /* If viewing a post type archive. */
        elseif (function_exists('is_post_type_archive') && is_post_type_archive()) {

            /* Get the post type object. */
            $post_type_object = get_post_type_object(get_query_var('post_type'));

            /* If $front has been set, add it to the $path. */
            if ($post_type_object->rewrite['with_front'] && $wp_rewrite->front)
                $path .= trailingslashit($wp_rewrite->front);

            /* If there's a slug, add it to the $path. */
            if (!empty($post_type_object->rewrite['archive']))
                $path .= $post_type_object->rewrite['archive'];

            /* If there's a path, check for parents. */
            if (!empty($path) && '/' != $path)
                $trail = array_merge($trail, ww_breadcrumbs_get_parents('', $path));

            /* Add the post type [plural] name to the trail end. */
            $trail['trail_end'] = $post_type_object->labels->name;
        } /* If viewing an author archive. */
        elseif (is_author()) {

            /* If $front has been set, add it to $path. */
            if (!empty($wp_rewrite->front))
                $path .= trailingslashit($wp_rewrite->front);

            /* If an $author_base exists, add it to $path. */
            if (!empty($wp_rewrite->author_base))
                $path .= $wp_rewrite->author_base;

            /* If $path exists, check for parent pages. */
            if (!empty($path))
                $trail = array_merge($trail, ww_breadcrumbs_get_parents('', $path));

            /* Add the author's display name to the trail end. */
            $trail['trail_end'] = get_the_author_meta('display_name', get_query_var('author'));
        } /* If viewing a time-based archive. */
        elseif (is_time()) {

            if (get_query_var('minute') && get_query_var('hour'))
                $trail['trail_end'] = get_the_time('g:i a');

            elseif (get_query_var('minute'))
                $trail['trail_end'] = sprintf('Minute %1$s', get_the_time('i'));

            elseif (get_query_var('hour'))
                $trail['trail_end'] = get_the_time('g a');
        } /* If viewing a date-based archive. */
        elseif (is_date()) {

            /* If $front has been set, check for parent pages. */
            if ($wp_rewrite->front)
                $trail = array_merge($trail, ww_breadcrumbs_get_parents('', $wp_rewrite->front));

            if (is_day()) {
                $trail[] = '<a href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . '</a>';
                $trail[] = '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('F') . '">' . get_the_time('F') . '</a>';
                $trail['trail_end'] = get_the_time('j');
            } elseif (get_query_var('w')) {
                $trail[] = '<a href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . '</a>';
                $trail['trail_end'] = sprintf('Week %1$s', get_the_time('W'));
            } elseif (is_month()) {
                $trail[] = '<a href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . '</a>';
                $trail['trail_end'] = get_the_time('F');
            } elseif (is_year()) {
                $trail['trail_end'] = get_the_time('Y');
            }
        }
    } /* If viewing search results. */
    elseif (is_search())
        $trail['trail_end'] = sprintf('Search results for &quot;%1$s&quot;', esc_attr(get_search_query()));

    /* If viewing a 404 error page. */
    elseif (is_404())
        $trail['trail_end'] = '404 Not Found';

    /* Connect the breadcrumb trail if there are items in the trail. */
    if (is_array($trail)) {

        /* Open the breadcrumb trail containers. */
        $breadcrumb = '<nav class="breadcrumb breadcrumbs ww-breadcrumbs" aria-label="Breadcrumb"><div class="breadcrumb-trail">';

        /* If $before was set, wrap it in a container. */
        if (!empty($before))
            $breadcrumb .= '<span class="trail-before">' . wp_kses_post($before) . '</span> ';

        /* Wrap the $trail['trail_end'] value in a container. */
        if (!empty($trail['trail_end']))
            $trail['trail_end'] = '<span class="trail-end">' . wp_kses_post($trail['trail_end']) . '</span>';

        /* Format the separator. */
        if (!empty($separator))
            $separator = '<span class="sep">' . wp_kses_post($separator) . '</span>';

        /* Join the individual trail items into a single string. */
        $breadcrumb .= join(" {$separator} ", $trail);

        /* If $after was set, wrap it in a container. */
        if (!empty($after))
            $breadcrumb .= ' <span class="trail-after">' . wp_kses_post($after) . '</span>';

        /* Close the breadcrumb trail containers. */
        $breadcrumb .= '</div></nav>';
    }


    /* Output the breadcrumb. */
    if ($echo)
        echo $breadcrumb;
    else
        return $breadcrumb;
} // End ww_breadcrumbs()

function ww_breadcrumbs_get_parents($post_id = '', $path = '')
{
    /* Set up an empty trail array. */
    $trail = array();

    /* If neither a post ID nor path set, return an empty array. */
    if (empty($post_id) && empty($path))
        return $trail;

    /* If the post ID is empty, use the path to get the ID. */
    if (empty($post_id)) {

        /* Get parent post by the path. */
        $parent_page = get_page_by_path($path);

        /* ********************************************************************
        Modification: The above line won't get the parent page if
        the post type slug or parent page path is not the full path as required
        by get_page_by_path. By using get_page_with_title, the full parent
        trail can be obtained. This may still be buggy for page names that use
        characters or long concatenated names.
        Author: Byron Rode
        Date: 06 June 2011
        ******************************************************************* */

        if (empty($parent_page))
            // search on page name (single word)
            $parent_page = get_page_by_title($path);

        if (empty($parent_page))
            // search on page title (multiple words)
            $parent_page = get_page_by_title(str_replace(array('-', '_'), ' ', $path));

        /* End Modification */

        /* If a parent post is found, set the $post_id variable to it. */
        if (!empty($parent_page))
            $post_id = $parent_page->ID;
    }

    /* If a post ID and path is set, search for a post by the given path. */
    if ($post_id == 0 && !empty($path)) {

        /* Separate post names into separate paths by '/'. */
        $path = trim($path, '/');
        preg_match_all("/\/.*?\z/", $path, $matches);

        /* If matches are found for the path. */
        if (isset($matches)) {

            /* Reverse the array of matches to search for posts in the proper order. */
            $matches = array_reverse($matches);

            /* Loop through each of the path matches. */
            foreach ($matches as $match) {

                /* If a match is found. */
                if (isset($match[0])) {

                    /* Get the parent post by the given path. */
                    $path = str_replace($match[0], '', $path);
                    $parent_page = get_page_by_path(trim($path, '/'));

                    /* If a parent post is found, set the $post_id and break out of the loop. */
                    if (!empty($parent_page) && $parent_page->ID > 0) {
                        $post_id = $parent_page->ID;
                        break;
                    }
                }
            }
        }
    }

    /* While there's a post ID, add the post link to the $parents array. */
    while ($post_id) {
        /* Get the post by ID. */
        $page = get_page($post_id);

        /* Add the formatted post link to the array of parents. */
        $parents[] = '<a href="' . get_permalink($post_id) . '" title="' . esc_attr(get_the_title($post_id)) . '">' . esc_html(get_the_title($post_id)) . '</a>';

        /* Set the parent post's parent to the post ID. */
        $post_id = $page->post_parent;
    }

    /* If we have parent posts, reverse the array to put them in the proper order for the trail. */
    if (isset($parents))
        $trail = array_reverse($parents);

    /* Return the trail of parent posts. */
    return $trail;
} // End ww_breadcrumbs_get_parents()

function ww_breadcrumbs_get_term_parents($parent_id = '', $taxonomy = '')
{
    /* Set up some default arrays. */
    $trail = array();
    $parents = array();

    /* If no term parent ID or taxonomy is given, return an empty array. */
    if (empty($parent_id) || empty($taxonomy))
        return $trail;

    /* While there is a parent ID, add the parent term link to the $parents array. */
    while ($parent_id) {

        /* Get the parent term. */
        $parent = get_term($parent_id, $taxonomy);

        /* Add the formatted term link to the array of parent terms. */
        $parents[] = '<a href="' . get_term_link($parent, $taxonomy) . '" title="' . esc_attr($parent->name) . '">' . $parent->name . '</a>';

        /* Set the parent term's parent as the parent ID. */
        $parent_id = $parent->parent;
    }

    /* If we have parent terms, reverse the array to put them in the proper order for the trail. */
    if (!empty($parents))
        $trail = array_reverse($parents);

    /* Return the trail of parent terms. */
    return $trail;
} // End ww_breadcrumbs_get_term_parents()

//Modify TinyMCE Editor
function ww_simple_visual_editor($initArray)
{
    $initOverrides = array(
        // 'style_formats'                 => json_encode($style_formats),
        'block_formats' => 'Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Paragraph=p',
        'toolbar1' => 'bold italic strikethrough bullist numlist blockquote hr alignleft aligncenter alignright link unlink code | wp_adv dfw',
        'toolbar2' => 'formatselect underline indent outdent undo redo | pastetext removeformat charmap',
        'paste_text_use_dialog' => 'false',
        'paste_auto_cleanup_on_paste' => 'true',
        'paste_remove_styles' => 'true',
        'paste_as_text' => 'true',
        'paste_text_sticky' => 'true',
    );

    return array_merge($initArray, $initOverrides);
}
add_filter('tiny_mce_before_init', 'ww_simple_visual_editor');

// Generate a Random String Function
function generateRandomString($length = 5) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function highlightText($heading) {
    $pattern = '/(.*)\*(.*)\*(.*)/';
    $replacement = '$1<span class="highlight">$2</span>$3';
    while (preg_match($pattern, $heading)) {
        $heading = preg_replace($pattern, $replacement, $heading);
    }
    $boldpattern = '/(.*)\^(.*)\^(.*)/';
    $boldreplacement = '$1<div class="h4">$2</div>$3';
    while (preg_match($boldpattern, $heading)) {
        $heading = preg_replace($boldpattern, $boldreplacement, $heading);
    }
    return $heading;
}

function ultraFont($content) {
    $pattern = '/(.*)\|(.*)\|(.*)/';
    $replacement = '$1<span class="ultra">$2</span>$3';
    while (preg_match($pattern, $content)) {
        $content = preg_replace($pattern, $replacement, $content);
    }
    return $content;
}

function ww_get_author_metas($author_id) {
    if (!is_numeric($author_id)) return null;

    if ($user = get_user_by('id', $author_id)) { // Only proceed if ID points to valid user
        $acf_user_key = 'user_ ' . $author_id;

        if ($profile_picture_override = get_field('profile_picture_override', $acf_user_key)) {// get_the_author_meta('profile_picture_override', $author_id)) {
            $profile_picture = array(
                'url' => $profile_picture_override['sizes']['thumbnail'], // TODO: do we need an extra small thumbnail image size? 200px is large...
                'alt' => $profile_picture_override['alt'],
            );
        }
        else {
            $profile_picture = array(
                'url' => get_avatar_url($author_id, array('size' => '64')), // TODO: Add default URL reference arg if neither profile override nor gravatar exists - https://developer.wordpress.org/reference/functions/get_avatar_url/
                'alt' => 'User: ' . $user->data->user_login,
            );
        }

        $a_data = array(
            'username' => $user->data->user_login,
            'profile_picture' => $profile_picture,
            'job_title' => get_field('job_title', $acf_user_key),
            'first_name' => get_the_author_meta('first_name', $author_id),
            'last_name' => get_the_author_meta('last_name', $author_id),
            'facebook' => get_the_author_meta('facebook', $author_id),
            'twitter' => get_the_author_meta('twitter', $author_id),
            'linkedin' => get_field('linkedin_profile_url', $acf_user_key),
        );

        // Formatted name
        if ($a_data['first_name'] || $a_data['last_name']) {
            $a_name_parts = array();
            if ($a_data['first_name']) $a_name_parts[] = $a_data['first_name'];
            if ($a_data['last_name']) $a_name_parts[] = $a_data['last_name'];
            $a_data['formatted_name'] = implode(' ', $a_name_parts);
        }
        else {
            $a_data['formatted_name'] = $a_data['username']; // Fallback is username
        }

        return $a_data;
    }

    return null;
}

/* remove canonical link from events archives */
function wpseo_canonical_exclude( $canonical ) {
    global $post;
    if (is_archive() && tribe_is_event()) {
        $canonical = false;
    }
    return $canonical;
}
add_filter( 'wpseo_canonical', 'wpseo_canonical_exclude' );

/* remove prev / next link from events archives */
function wpseo_rel_prev_next_home_exclude( $link ) {
    if (is_archive() && tribe_is_event()) {
        return false;
    }
}
add_filter( 'wpseo_next_rel_link', 'wpseo_rel_prev_next_home_exclude' );
add_filter( 'wpseo_prev_rel_link', 'wpseo_rel_prev_next_home_exclude' );

/* change event schedule format */
function change_schedule_formatting( array $format ) {
    $format['datetime_separator'] = '</span><br /><span class="date-time">'; // This replaces the @ symbol
    return $format;
}
add_filter('tribe_events_event_schedule_details_formatting', 'change_schedule_formatting');

/* remove Events page search filter */
function remove_search_from_bar( $filters ) {
    if ( isset( $filters['tribe-bar-search'] ) ) {
        unset( $filters['tribe-bar-search'] );
    }
    return $filters;
}
add_filter( 'tribe-events-bar-filters',  'remove_search_from_bar', 1000, 1 );

/* custom event date format */
add_filter('tribe_events_event_schedule_details', 'custom_tribe_events_event_schedule_details');
function custom_tribe_events_event_schedule_details() {
    if ( is_null( $event ) ) {
        global $post;
        $event = $post;
    }

    if ( is_numeric( $event ) )
        $event = get_post( $event );

    $schedule = '<span class="date-start dtstart">';
    $format = '';
    $date_without_year_format = tribe_get_date_format();
    $date_with_year_format = tribe_get_date_format( true );
    $time_format = get_option( 'time_format' );
    $just_day = 'j';
    $just_month = 'M';
    $datetime_separator = tribe_get_option('dateTimeSeparator', ' @ ');
    $time_range_separator = tribe_get_option('timeRangeSeparator', ' - ');
    $microformatStartFormat = tribe_get_start_date( $event, false, 'Y-m-dTh:i' );
    $microformatEndFormat = tribe_get_end_date( $event, false, 'Y-m-dTh:i' );

    $settings = array(
        'show_end_time' => false,
        'time' => false,
    );

    $settings = wp_parse_args( apply_filters('tribe_events_event_schedule_details_formatting', $settings), $settings );
    if ( ! $settings['time'] ) $settings['show_end_time'] = false;
    extract($settings);

    $format = $date_with_year_format;

    // if it starts and ends in the current year then there is no need to display the year
    if ( tribe_get_start_date( $event, false, 'Y' ) === date( 'Y' ) && tribe_get_end_date( $event, false, 'Y' ) === date( 'Y' ) ) {
        $format = $date_without_year_format;
    }

    if ( tribe_event_is_multiday( $event ) ) { // multi-date event

        $format2ndday = $format;

        //If it's all day and the end date is in the same month and year, just show the day.
        if ( tribe_event_is_all_day( $event ) && tribe_get_end_date( $event, false, 'm' ) === tribe_get_start_date( $event, false, 'm' ) && tribe_get_end_date( $event, false, 'Y' ) === date( 'Y' ) ) {
            //$format2ndday = 'j';

            $schedule .= '<span class="the-day">';
            $schedule .= tribe_get_start_date( $event, true, $just_day );
            $schedule .= $time_range_separator;
            $schedule .= tribe_get_end_date( $event, true, $just_day );
            $schedule .= '</span>';
            $schedule .= '<span class="the-month">';
            $schedule .= tribe_get_start_date( $event, true, $just_month );
            $schedule .= '</span>';
        } else {

            $schedule .= '<span class="the-month">';
            $schedule .= tribe_get_start_date( $event, true, $just_day );
            $schedule .= ' ';
            $schedule .= tribe_get_start_date( $event, true, $just_month );
            $schedule .= $time_range_separator;
            $schedule .= '</span>';
            $schedule .= '<span class="the-month">';
            $schedule .= tribe_get_end_date( $event, true, $just_day );
            $schedule .= ' ';
            $schedule .= tribe_get_end_date( $event, true, $just_month );
            $schedule .= '</span>';

        }

        //if ( tribe_event_is_all_day( $event ) ) {
            //$schedule .= tribe_get_start_date( $event, true, $format );
            //$schedule .= '<span class="value-title" title="'. $microformatStartFormat .'"></span>';
            //$schedule .= '</span>'.$time_range_separator;
            //$schedule .= '<span class="date-end dtend">';
            //$schedule .= tribe_get_end_date( $event, true, $format2ndday );
            //$schedule .= '<span class="value-title" title="'. $microformatEndFormat .'"></span>';
        //} else {
            //$schedule .= tribe_get_start_date( $event, false, $date_without_year_format );
            //$schedule .= '<span class="value-title" title="'. $microformatStartFormat .'"></span>';
            //$schedule .= '</span>'.$time_range_separator;
            //$schedule .= '<span class="date-end dtend">';
            //$schedule .= tribe_get_end_date( $event, true, 'j, Y' );
            //$schedule .= '<span class="value-title" title="'. $microformatEndFormat .'"></span>';
        //}



    //} elseif ( tribe_event_is_all_day( $event ) ) { // all day event
        //$schedule .=  tribe_get_start_date( $event, true, $format );
        //$schedule .= '<span class="value-title" title="'. $microformatStartFormat .'"></span>';
    } else { // single day event
        //if ( tribe_get_start_date( $event, false, 'g:i A' ) === tribe_get_end_date( $event, false, 'g:i A' ) ) { // Same start/end time
            //$schedule .= tribe_get_start_date( $event, false, $format ) . ( $time ? $datetime_separator . tribe_get_start_date( $event, false, $time_format ) : '' );
            //$schedule .= '<span class="value-title" title="'. $microformatStartFormat .'"></span>';
        //} else { // defined start/end time

            $schedule .= '<span class="the-day">';
            $schedule .= tribe_get_start_date( $event, true, $just_day );
            $schedule .= '</span>';
            $schedule .= '<span class="the-month">';
            $schedule .= tribe_get_start_date( $event, true, $just_month );
            $schedule .= '</span>';

            //$schedule .= '<span class="value-title" title="'. $microformatStartFormat .'"></span>';
            //$schedule .= '</span>' . ( $show_end_time ? $time_range_separator : '' );
            //$schedule .= '<span class="end-time dtend">';
            //$schedule .= ( $show_end_time ? tribe_get_end_date( $event, false, $time_format ) : '' ) . '<span class="value-title" title="'. $microformatEndFormat .'"></span>';
        //}
    }

    $schedule .= '</span>';

    $schedule = $before . $schedule . $after;

    return apply_filters( 'custom_tribe_events_event_schedule_details', $schedule );
}

/* Prevents uploads from non-admins */
function ww_only_upload_for_admin( $file ) {
	if ( current_user_can('upload_files_for_real') || current_user_can('administrator') ) {
		//Can upload files
	} else {
        $file['error'] = 'You can\'t upload images without admin privileges!';
    }
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'ww_only_upload_for_admin' );

// add_filter( 'posts_orderby', 'order_search_by_posttype', 10, 1 );
// function order_search_by_posttype( $orderby ){
//     if( ! is_admin() && is_search() ) :
//         global $wpdb;
//         $orderby =
//             "
//             CASE WHEN {$wpdb->prefix}posts.post_type = 'page' THEN '1'
//                  WHEN {$wpdb->prefix}posts.post_type = 'post' THEN '2'
//                  WHEN {$wpdb->prefix}posts.post_type = 'news' THEN '3'
//                  WHEN {$wpdb->prefix}posts.post_type = 'tribe_events' THEN '4'
//             ELSE {$wpdb->prefix}posts.post_type END ASC,
//             {$wpdb->prefix}posts.post_title ASC";
//     endif;
//     return $orderby;
// }

// add_filter( 'solr_index_custom_fields', function() {
//      return px_get_acf_field_names();
// });

//Unhides default custom fields when ACF is active
//add_filter('acf/settings/remove_wp_meta_box', '__return_false');

// function order_search_by_posttype( $orderby ){
//     if( ! is_admin() && is_search() ) :
//         global $wpdb;
//         $orderby =
//             "
//             CASE WHEN {$wpdb->prefix}posts.post_type = 'page' THEN '1'
//                  WHEN {$wpdb->prefix}posts.post_type = 'post' THEN '2'
//                  WHEN {$wpdb->prefix}posts.post_type = 'news' THEN '3'
//                  WHEN {$wpdb->prefix}posts.post_type = 'tribe_events' THEN '4'
//             ELSE {$wpdb->prefix}posts.post_type END ASC,
//             {$wpdb->prefix}posts.post_title ASC";
//     endif;
//     return $orderby;
// }
// add_filter( 'posts_orderby', 'order_search_by_posttype', 10, 1 );

// Exclude past events from search
function mySearchFilter($query) {
    if ($query->is_search) {
        $past_events = tribe_get_events( array(
          'posts_per_page' => -1,
          'end_date' => new DateTime()
        ) );
        $exclude_events = [];
        foreach ( $past_events as $past_event ) {
            $exclude_events[] = $past_event->ID;
        }
        $query->set('post__not_in', $exclude_events);
    }
    return $query;
}
add_filter('pre_get_posts','mySearchFilter');

add_filter('relevanssi_hits_filter', 'separate_result_types');
function separate_result_types($hits) {
    $types = array();
    $types['page'] = array();
    $types['post'] = array();
    $types['news'] = array();
    $types['tribe_events'] = array();
 
    // Split the post types in array $types
    if (!empty($hits)) {
        foreach ($hits[0] as $hit) {
            if (!is_array($types[$hit->post_type])) $types[$hit->post_type] = array();                        
            array_push($types[$hit->post_type], $hit);
        }
    }
 
    // Merge back to $hits in the desired order
    $hits[0] = array_merge($types['page'], $types['tribe_events'], $types['post'], $types['news'] );
    return $hits;
}

add_filter( 'gform_enable_password_field', '__return_true' );