<?php 

// Customize WP REST API
function my_rest_api()
{
	register_rest_field('post', 'authorName', array(
		'get_callback' => function () {
			return get_the_author();
		},
	));

	register_rest_field('note', 'userNoteCount', array(
		'get_callback' => function () {
			return count_user_posts(get_current_user_id(), 'note');
		},
	));
}
add_action('rest_api_init', 'my_rest_api');

?>