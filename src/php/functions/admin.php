<?php 

// subscriber ログイン後リダイレクト
function redirect_subscriber()
{
	$current_user = wp_get_current_user();
	if (count($current_user->roles) == 1 and $current_user->roles[0] == 'subscriber') {
		wp_redirect(site_url('/'));
		exit;
	}
}
add_action('admin_init', 'redirect_subscriber');

// subscriber adminバーを見せない
function subscriber_no_admin_bar()
{
	$current_user = wp_get_current_user();
	if (count($current_user->roles) == 1 and $current_user->roles[0] == 'subscriber') {
		show_admin_bar(false);
	}
}
add_action('wp_loaded', 'subscriber_no_admin_bar');

// customize login screen
function our_header_url()
{
	return esc_url(site_url('/'));
}
add_filter('login_headerurl', 'our_header_url');

add_action('login_enqueue_scripts', function () {
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('university_main_styles', get_template_directory_uri() . '/style.css', NULL, microtime());
});

add_filter('login_headertitle', function () {
	return get_bloginfo('name');
});

?>