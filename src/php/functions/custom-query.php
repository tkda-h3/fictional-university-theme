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
	if ($data['post_type'] == 'note') {
		$note_exist = !$postarr['ID'];
		// updateの場合のみ
		if (count_user_posts(get_current_blog_id(), 'note') >= 5 and $note_exist) {
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




function my_eventt_query($query)
{
	if (!is_admin() and $query->is_date()) {
		$query_object  = get_queried_object();
		$the_post_type = $query_object->name;
		if ('event' === $the_post_type) {
			if ($query->is_year()) {
				$year = get_query_var('year');
				$from = date($year . '-01-01');
				$to   = date($year . '-12-31');
			} elseif ($query->is_month()) {
				$year  = get_query_var('year');
				$month = get_query_var('year') . '-' . get_query_var('monthnum');
				$from  = date('Y-m-d', strtotime('first day of ' . $month));
				$to    = date('Y-m-d', strtotime('last day of ' . $month));
			} elseif ($query->is_day()) {
				$year  = get_query_var('year');
				$month = get_query_var('monthnum');

				$day   = get_query_var('day');
				$from  = date($year . '-' . $month . '-' . $day);
				$to    = date($year . '-' . $month . '-' . $day);
			}
			$meta_query = array(
				array(
					'key'     => 'event_date',
					'value'   => array($from, $to),
					'compare' => 'BETWEEN',
					'type'    => 'DATE',
				),
			);
			$query->set('meta_key', 'event_date');
			$query->set('orderby', 'meta_value');
			$query->set('year', '');
			$query->set('monthnum', '');
			$query->set('day', '');
			$query->set('meta_query', $meta_query);
		}
	}
}
add_action('pre_get_posts', 'my_eventt_query');
