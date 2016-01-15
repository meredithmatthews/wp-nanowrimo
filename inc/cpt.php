<?php

// Register custom post type

 add_action( 'init', 'wp_nanowrimo_post_init' );
 
function wp_nanowrimo_post_init() {
	$labels = array(
		'name'               => _x( 'NaNoWriMo Entries', 'post type general name', 'wp-nanowrimo' ),
		'singular_name'      => _x( 'NaNoWriMo Entry', 'post type singular name', 'wp-nanowrimo' ),
		'menu_name'          => _x( 'NaNoWriMo Entries', 'admin menu', 'wp-nanowrimo' ),
		'name_admin_bar'     => _x( 'NaNoWriMo Entry', 'add new on admin bar', 'wp-nanowrimo' ),
		'add_new'            => _x( 'Add New', 'entry', 'wp-nanowrimo' ),
		'add_new_item'       => __( 'Add New NaNoWriMo Entry', 'wp-nanowrimo' ),
		'new_item'           => __( 'New NaNoWriMo Entry', 'wp-nanowrimo' ),
		'edit_item'          => __( 'Edit NaNoWriMo Entry', 'wp-nanowrimo' ),
		'view_item'          => __( 'View NaNoWriMo Entry', 'wp-nanowrimo' ),
		'all_items'          => __( 'All NaNoWriMo Entries', 'wp-nanowrimo' ),
		'search_items'       => __( 'Search NaNoWriMo Entries', 'wp-nanowrimo' ),
		'parent_item_colon'  => __( 'Parent NaNoWriMo Entries:', 'wp-nanowrimo' ),
		'not_found'          => __( 'No NaNoWriMo entries found.', 'wp-nanowrimo' ),
		'not_found_in_trash' => __( 'No NaNoWriMo entries found in Trash.', 'wp-nanowrimo' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'wp-nanowrimo' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'entry' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'show_in_rest'       => true,
        'rest_controller_class' => 'WP_REST_Posts_Controller',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type( 'entry', $args );
}

// modify archive page title

add_filter( 'get_the_archive_title', function ( $title ) {

    if( is_post_type_archive( 'entry' ) ) {
        $title = sprintf( __( 'Archives: %s' ), get_option('nano_novel_title') );
    }
    return $title;
});

?>