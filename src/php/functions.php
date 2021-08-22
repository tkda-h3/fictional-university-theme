<?php

// css, js読み込み
function university_files()
{
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('university_main_styles', get_template_directory_uri() . '/style.css', NULL, microtime());

	wp_enqueue_script(
		'main-university-js',
		get_theme_file_uri('/js/scripts-bundled.js'),
		NULL,
		'1.0',
		true
	);
}

add_action('wp_enqueue_scripts', 'university_files');

// メニュー追加
function university_features()
{
	register_nav_menu('headerMenuLocation', 'Header Menu Location');
	register_nav_menu('footerLocationOne', 'Footer Location One');
	register_nav_menu('footerLocationTwo', 'Footer Location Two');
	add_theme_support('title-tag');
}

add_action('after_setup_theme', 'university_features');


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
		'menu_position' => 5,
		'show_in_rest'  => true,
	));
}

add_action('init', 'my_post_types');


// メインクエリの書き換え
function my_pre_get_posts($query)
{
	if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
		$query->set('posts_per_page', -1); // all
	}

	if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', array(
			array(
				'key' => 'event_date',
				'compare' => '>=',
				'value' => date('Ymd'),
				'type' => 'numeric'
			)
		));
	}

	if (is_admin() || !$query->is_main_query()) {
		return;
	}
}

add_action('pre_get_posts', 'my_pre_get_posts');
