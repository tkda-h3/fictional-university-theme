<?php
// css, js読み込み
function university_files()
{
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('university_main_styles', get_template_directory_uri() . '/style.css', NULL, microtime());

	wp_enqueue_script('google-map', "//maps.googleapis.com/maps/api/js?key=" . GOOGLE_MAP_API_KEY, NULL, '1.0', true); // wp-config.php に変数を定義
	wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts.js'), NULL, '1.0', true); // 最後に読み込みたいので最終行に記述

	wp_localize_script('main-university-js', 'universityData', array(
		'root_url' => get_site_url(),
	));
}

add_action('wp_enqueue_scripts', 'university_files');

// メニュー追加
function university_features()
{
	register_nav_menu('headerMenuLocation', 'Header Menu Location');
	register_nav_menu('footerLocationOne', 'Footer Location One');
	register_nav_menu('footerLocationTwo', 'Footer Location Two');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	// wp-cliで以下のコマンドで再生成可能
	// $ wp media regenerate
	add_image_size('professor-landscape', 400, 260, true);
	add_image_size('professor-portrait', 480, 650, true);
	add_image_size('page-banner', 1500, 350, true);
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
		'menu_position' => 5,
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
		'menu_position' => 5,
		'show_in_rest'  => true,
	));
}

add_action('init', 'my_post_types');


// メインクエリの書き換え
function my_pre_get_posts($query)
{
	if (!is_admin() and is_post_type_archive('campus') and $query->is_main_query()) {
		$query->set('posts_per_page', -1);
	}

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


/* $args array{
* title?: string,
* subtitle?: string,
* background-image?: string, // 背景画像のurl
*/
function page_banner($args = array())
{
	if (!$args['title']) {
		$args['title'] = get_the_title();
	}

	if (!$args['subtitle']) {
		$args['subtitle'] = get_field('page_banner_subtitle');
	}

	if (!$args['background-image']) {
		if (get_field('page_banner_background_image') and !(is_archive() or is_home())) {
			$args['background-image'] = get_field('page_banner_background_image')['sizes']['page-banner'];
		} else {
			$args['background-image'] = get_theme_file_uri('/img/ocean.jpg');
		}
	}
?>
	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?php echo $args['background-image']; ?>);">
		</div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
			<div class="page-banner__intro">
				<p><?php echo $args['subtitle']; ?></p>
			</div>
		</div>
	</div>

<?php
}

// acf google map api
function my_acf_google_map_api($api)
{
	$api['key'] = GOOGLE_MAP_API_KEY;

	return $api;
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
