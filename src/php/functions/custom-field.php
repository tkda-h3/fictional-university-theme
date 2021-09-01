<?php 
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




?>