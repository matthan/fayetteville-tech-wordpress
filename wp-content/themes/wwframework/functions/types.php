<?php

// Updates to default 'post' type
function ww_alter_default_post_type() {
    $post_object = get_post_type_object('post');

    $post_object->has_archive = true;
    $post_object->rewrite = (object) array(
        'slug' => 'blog',
        'with_front' => true,
    );

    // Label changes
    $args_labels = get_object_vars($post_object->labels);
    $args_labels = str_replace('Posts', 'Blogs', $args_labels);
    $args_labels = str_replace('posts', 'blog', $args_labels);
    $args_labels = str_replace('Post', 'Blog', $args_labels);
    $args_labels = str_replace('post', 'blog', $args_labels);
    $post_object->labels = (object) $args_labels;

    register_post_type('post', $post_object);
}
add_action('init', 'ww_alter_default_post_type');

// Custom post types/taxonomies
class posttypes
{
    function __construct()
    {
        add_action('init',array($this,'create_post_types'),9);
        add_action('init',array($this,'create_taxonomies'),9);
    }

    function create_post_types()
    {
        $newslabels = array(
            'name' => 'News',
            'singular_name' => 'News Item',
            'add_new' => 'Add New',
            'all_items' => 'All News',
            'add_new_item' => 'Add New News Item',
            'edit_item' => 'Edit News Item',
            'new_item' => 'New News Item',
            'view_item' => 'View News Item',
            'search_items' => 'Search News',
            'not_found' => 'No News found',
            'not_found_in_trash' => 'No News found in trash',
            'parent_item_colon' => 'Parent News Item:',
            'menu_name' => 'News'
        );
        $newsargs = array(
            'labels' => $newslabels,
            'description' => "",
            'public' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-megaphone',
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'hierarchical' => true,
            'has_archive' => true,
            'rewrite' => array('with_front' => false),
            'query_var' => true,
            'can_export' => true,
            'supports' => array(
                'title',
                'editor',
                //'excerpt',
                //'author',
                'thumbnail',
                //'comments',
                //'trackbacks',
                //'custom-fields',
                'revisions',
                //'page-attributes',
                //'post-formats',
            ),
        );
        register_post_type('news', $newsargs);

        // $selabels = array(
//             'name' => 'Sport Event',
//             'singular_name' => 'Sport Event',
//             'add_new' => 'Add New',
//             'all_items' => 'All Sport Events',
//             'add_new_item' => 'Add New Sport Event',
//             'edit_item' => 'Edit Sport Event',
//             'new_item' => 'New Sport Event',
//             'view_item' => 'View Sport Event',
//             'search_items' => 'Search Sport Events',
//             'not_found' =>  'No Sport Events found',
//             'not_found_in_trash' => 'No Sport Events found in trash',
//             'parent_item_colon' => 'Parent Sport Event:',
//             'menu_name' => 'Sport Events'
//         );
//         $seargs = array(
//             'labels' => $selabels,
//             'description' => "",
//             'public' => false,
//             'exclude_from_search' => true,
//             'publicly_queryable' => false,
//             'show_ui' => true,
//             'show_in_nav_menus' => true,
//             'show_in_menu' => true,
//             'show_in_admin_bar' => true,
//             'menu_position' => 5,
//             'menu_icon' => 'dashicons-tickets-alt',
//             'capability_type' => 'post',
//             'map_meta_cap' => true,
//             'hierarchical' => false,
//             'supports' => array('revisions'),
//             'has_archive' => false,
//             'rewrite' => false,
//             'query_var' => true,
//             'can_export' => true,
//         );
//         register_post_type('sport-events',$seargs);
    }

    function create_taxonomies()
    {
        $sportlabels = array(
            'name' => 'Sport',
            'singular_name' => 'Sport',
            'search_items' => 'Search Sports',
            'all_items' => 'All Sports',
            'parent_item' => 'Parent Sport',
            'parent_item_colon' => 'Parent Sport:',
            'edit_item' => 'Edit Sport',
            'update_item' => 'Update Sport',
            'add_new_item' => 'Add New Sport',
            'new_item_name' => 'New Sport',
            'menu_name' => 'Sports'
        );
        $sportargs = array(
            'hierarchical' => true,
            'labels' => $sportlabels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'sport', 'with_front' => false)
        );
        register_taxonomy('sport', array('news','sport-events'), $sportargs);

        register_taxonomy_for_object_type('category', 'news');
    }
}

$newposttypes = new posttypes();