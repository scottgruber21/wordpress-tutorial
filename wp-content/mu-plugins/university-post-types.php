<?php
function university_post_types()
{
    //Campus Post Type
    register_post_type('campus', [
        'supports' => ['title', 'editor', 'excerpt'],
        'capability_type' => 'campus',
        'map_meta_cap' => true,
        'rewrite' => ['slug' => 'campuses'],
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'labels' => [
            'name' => 'Campuses',
            'add_new_item' => 'Add New Campus',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All Campuses',
            'singular_name' => 'Campus'
        ],
        'menu_icon' => 'dashicons-location-alt'
    ]);


    // Event post type
    register_post_type('event', [
        'supports' => ['title', 'editor', 'excerpt'],
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'rewrite' => ['slug' => 'events'],
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'labels' => [
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event',
        ],
        'menu_icon' => 'dashicons-calendar'
    ]);


    // Program post type
    register_post_type('program', [
        'show_in_rest' => true,
        'public' => true,
        'has_archive' => true,
        'supports' => ['title'],
        'rewrite' => ['slug' => 'programs'],
        'labels' => [
            'name' => 'Programs',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'singular_name' => 'Program'
        ],
        'menu_icon' => 'dashicons-awards'
    ]);

    register_post_type('professor', [
        'show_in_rest' => true,
        'public' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
        'labels' => [
            'name' => 'Professors',
            'add_new_item' => 'Add New Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor'
        ],
        'menu_icon' => 'dashicons-welcome-learn-more'
    ]);

    //Note Post Type
    register_post_type('note', [
        'capability_type' => 'note',
        'map_meta_cap' => true,
        'show_in_rest' => true,
        'public' => false,
        'show_ui' => true,
        'supports' => ['title', 'editor'],
        'show_in_rest' => true,
        'labels' => [
            'name' => 'Notes',
            'add_new_item' => 'Add New Note',
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note'
        ],
        'menu_icon' => 'dashicons-welcome-write-blog'
    ]);

    //Heart
    register_post_type('like', [
        'public' => false,
        'show_ui' => true,
        'supports' => ['title'],
        'show_in_rest' => true,
        'labels' => [
            'name' => 'Likes',
            'add_new_item' => 'Add New Like',
            'edit_item' => 'Edit Like',
            'all_items' => 'All Likes',
            'singular_name' => 'Like'
        ],
        'menu_icon' => 'dashicons-heart'
    ]);
}

add_action('init', 'university_post_types');
