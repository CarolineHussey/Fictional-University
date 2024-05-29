<?php 

function university_post_types() {
    //Event Post Types
    register_post_type('event', array(
        'capability_type' => 'event', //creates the capability_type
        'map_meta_cap' => true, //enables us to set capabilities & capability_type (enforces / requires permissions)
        'supports' => array('title', 'editor', 'excerpt'),
        'has_archive' => true,
        /*'rewrite' => array('slug' => 'events'),*/
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event',
            'add_new' => 'Add New Event'
        ),
        'menu_icon' => 'dashicons-calendar'
    ));

    //Program post types
    register_post_type('program', array(
        'capability_type' => 'program', //creates the capability_type
        'map_meta_cap' => true, //enables us to set capabilities & capability_type (enforces / requires permissions)
        'supports' => array('title'),
        'has_archive' => true,
        /*'rewrite' => array('slug' => 'programs'),*/
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Programs',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Program',
            'singular_name' => 'Program',
            'add_new' => 'Add New Program'
        ),
        'menu_icon' => 'dashicons-awards'
    ));

    //professor post types
    register_post_type('professor', array(
        'capability_type' => 'professor', //creates the capability_type
        'map_meta_cap' => true, //enables us to set capabilities & capability_type (enforces / requires permissions)
        'supports' => array('title', 'editor', 'thumbnail'),
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Professors',
            'add_new_item' => 'Add New Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor',
            'add_new' => 'Add New Professor'
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));

        //note post types
        register_post_type('note', array(
            'capability_type' => 'note', //creates the capability_type
            'map_meta_cap' => true, //enables us to set capabilities & capability_type (enforces / requires permissions)
            'supports' => array('title', 'editor'),
            'public' => false,
            'show_in_rest' => true,
            'show_ui' => true, //this is required to show item in wp ui / dashboard when public is set to false
            'labels' => array(
                'name' => 'Notes',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes',
                'singular_name' => 'Note',
                'add_new' => 'Add New Note'
            ),
            'menu_icon' => 'dashicons-welcome-write-blog'
        ));

        //like post types
        register_post_type('like', array(
            'supports' => array('title'),
            'public' => false,
            'show_ui' => true, //this is required to show item in wp ui / dashboard when public is set to false
            'labels' => array(
                'name' => 'Likes',
                'add_new_item' => 'Add New Like',
                'edit_item' => 'Edit Like',
                'all_items' => 'All Likes',
                'singular_name' => 'Like',
                'add_new' => 'Add New Like'
            ),
            'menu_icon' => 'dashicons-heart'
        ));

    //Campus post types
    register_post_type('campus', array(
        'capability_type' => 'campus', //creates the capability_type
        'map_meta_cap' => true, //enables us to set capabilities & capability_type (enforces / requires permissions)
        'supports' => array('title', 'editor', 'excerpt'),
        'has_archive' => true,
        /*'rewrite' => array('slug' => 'events'),*/
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Campuses',
            'add_new_item' => 'Add New Campus',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All Campuses',
            'singular_name' => 'Campus',
            'add_new' => 'Add New Campus'
        ),
        'menu_icon' => 'dashicons-location-alt'
    ));
}

    add_action('init', 'university_post_types');

?>