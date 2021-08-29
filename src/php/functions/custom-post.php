<?php 

// mu-plugins/ 以下においたほうが良い
// custom post type
function my_post_types()
{
	// event post type
	register_post_type('event', array(
		'labels' => array(
			'name'          => 'イベント',
			'add_new_item' => 'Add New Event',
			'edit_item' => 'Edit Event',
			'all_items' => 'All Events',
			'singular_name' => 'Event',
		),
		'rewrite' => array('slug' => 'events'),
		'supports' => array('title', 'editor', 'excerpt', 'custom-fields'),
		'menu_icon' => 'dashicons-calendar-alt',
		'public'        => true,
		'has_archive'   => true,
		'menu_position' => 5,
		'show_in_rest'  => true,
		'capability_type' => 'event', // permissionの名前を定義
		'map_meta_cap' => true,
	));

	// program post type
	register_post_type('program', array(
		'labels' => array(
			'name'          => 'プログラム',
			'add_new_item' => 'Add New Program',
			'edit_item' => 'Edit Program',
			'all_items' => 'All Programs',
			'singular_name' => 'Program',
		),
		'rewrite' => array('slug' => 'programs'),
		'supports' => array('title', 'editor', 'excerpt', 'custom-fields'),
		'menu_icon' => 'dashicons-awards',
		'public'        => true,
		'has_archive'   => true,
		'show_in_rest'  => true,
	));

	// professor post type
	register_post_type('professor', array(
		'labels' => array(
			'name'          => '教授',
			'add_new_item' => 'Add New professor',
			'edit_item' => 'Edit professor',
			'all_items' => 'All Professors',
			'singular_name' => 'professor',
		),
		'supports' => array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail'),
		'menu_icon' => 'dashicons-welcome-learn-more',
		'public'        => true,
		'show_in_rest'  => true,
	));

	// campus post type
	register_post_type('campus', array(
		'labels' => array(
			'name'          => 'キャンパス',
			'add_new_item' => 'Add New Campus',
			'edit_item' => 'Edit Campus',
			'all_items' => 'All Campuses',
			'singular_name' => 'campus',
		),
		'rewrite' => array('slug' => 'campuses'),
		'supports' => array('title', 'editor', 'excerpt', 'custom-fields'),
		'menu_icon' => 'dashicons-location-alt',
		'public'        => true,
		'has_archive'   => true,
		'show_in_rest'  => true,
		'capability_type' => 'campus',
		'map_meta_cap' => true,
	));

	// Note post type
	register_post_type('note', array(
		'labels' => array(
			'name'          => 'ノート',
			'add_new_item' => 'Add New Note',
			'edit_item' => 'Edit Note',
			'all_items' => 'All Notes',
			'singular_name' => 'note',
		),
		'supports' => array('title', 'editor'),
		'menu_icon' => 'dashicons-welcome-write-blog',
		'public'        => false,
		'show_ui' => true,
		'show_in_rest'  => true,
		'capability_type' => 'note',
		'map_meta_cap' => true,
	));

	// Like post type
	register_post_type('like', array(
		'labels' => array(
			'name'          => '教授いいね',
			'add_new_item' => 'Add New Like',
			'edit_item' => 'Edit Like',
			'all_items' => 'All Likes',
			'singular_name' => 'like',
		),
		'supports' => array('title', 'author'),
		'menu_icon' => 'dashicons-heart',
		'public'        => false,
		'show_ui' => true,
	));
}
add_action('init', 'my_post_types');

?>