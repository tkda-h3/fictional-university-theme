<?php 
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


// note post を強制的に非公開
// insert以外に、updateでも呼ばれるhook
add_filter('wp_insert_post_data', function ($data, $postarr) {
	if($data['post_type'] == 'note'){
		$note_exist = !$postarr['ID'];
		// updateの場合のみ
		if(count_user_posts(get_current_blog_id(), 'note') >= 5 and $note_exist){
			die("You have reached max limit.");
		}

		$data['post_title'] = sanitize_textarea_field($data['post_title']);
		$data['post_content'] = sanitize_textarea_field($data['post_content']);
	}

	if ($data['post_type'] == 'note' and $data['post_status'] != 'trash') {
		$data['post_status'] = 'private';
	}
	return $data;
}, 10, 2);


?>