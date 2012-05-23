<?php 

add_action( 'init', 'register_cpt_work' );

function register_cpt_work() {

    $labels = array( 
        'name' => _x( 'Work', 'work' ),
        'singular_name' => _x( 'Work', 'work' ),
        'add_new' => _x( 'Add New', 'work' ),
        'add_new_item' => _x( 'Add New Work', 'work' ),
        'edit_item' => _x( 'Edit Work', 'work' ),
        'new_item' => _x( 'New Work', 'work' ),
        'view_item' => _x( 'View Work', 'work' ),
        'search_items' => _x( 'Search Work', 'work' ),
        'not_found' => _x( 'No work found', 'work' ),
        'not_found_in_trash' => _x( 'No work found in Trash', 'work' ),
        'parent_item_colon' => _x( 'Parent Work:', 'work' ),
        'menu_name' => _x( 'Work', 'work' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'My work',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'comments', 'post-formats' ),
        'taxonomies' => array( 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'work', $args );
}

add_action( 'init', 'register_cpt_code' );

function register_cpt_code() {

    $labels = array( 
        'name' => _x( 'Code', 'code' ),
        'singular_name' => _x( 'Code', 'code' ),
        'add_new' => _x( 'Add New', 'code' ),
        'add_new_item' => _x( 'Add New Code', 'code' ),
        'edit_item' => _x( 'Edit Code', 'code' ),
        'new_item' => _x( 'New Code', 'code' ),
        'view_item' => _x( 'View Code', 'code' ),
        'search_items' => _x( 'Search Code', 'code' ),
        'not_found' => _x( 'No code found', 'code' ),
        'not_found_in_trash' => _x( 'No code found in Trash', 'code' ),
        'parent_item_colon' => _x( 'Parent Code:', 'code' ),
        'menu_name' => _x( 'Code', 'code' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'My code',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'comments', 'post-formats' ),
        'taxonomies' => array( 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'code', $args );
}

?>