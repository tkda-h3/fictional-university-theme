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
		'nonce' => wp_create_nonce('wp_rest'), // WP REST API用のシークレット文字列
	)); // var universityData = {key: value} でhtmlにベタ書きされるので、他のjsファイルから参照できる
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

?>