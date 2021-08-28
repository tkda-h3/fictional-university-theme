<?php

function professor_like_routes()
{
  register_rest_route('univ/v1', 'manageLike', array(
    'methods' => 'POST',
    'callback' => 'create_like',
  ));

  register_rest_route('univ/v1', 'manageLike', array(
    'methods' => 'DELETE',
    'callback' => 'delete_like',
  ));
}

function create_like($data)
{
  if (is_user_logged_in()) { // roleに基づいて判定
    $professor_id = sanitize_text_field($data['professorId']);

    $exist_query = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => 'like',
      'meta_query' => array(
        array(
          'key' => 'liked_professor_id',
          'compare' => '=',
          'value' => $professor_id,
        )
      ),
    ));
    if ($exist_query->found_posts == 0 and get_post_type($professor_id) == 'professor') {
      return wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => 'professor: ' . $professor_id,
        'meta_input' => array(
          'liked_professor_id' => $professor_id
        ),
      ));
    } else {
      die("いいね済み or 不正な Professor");
    }
  } else {
    die("Only logged in uers can create a like.");
  }
}

function delete_like($data)
{
  if (is_user_logged_in()) { // roleに基づいて判定
    $professor_id = sanitize_text_field($data['professorId']);
    $exist_query = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => 'like',
      'meta_query' => array(
        array(
          'key' => 'liked_professor_id',
          'compare' => '=',
          'value' => $professor_id,
        )
      ),
    ));

    if($exist_query->have_posts()){
      while($exist_query->have_posts()){
        $exist_query->the_post();
        wp_delete_post(get_the_ID(), true);
      }
      wp_reset_postdata();
      return 'Your like deleted.';
    } else {
      die("Invalid professor id.");
    }

  } else {
    die("Only logged in users can delete a like.");
  }
}

add_action('rest_api_init', 'professor_like_routes');
