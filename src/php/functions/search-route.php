<?php

function my_register_search()
{
  register_rest_route('univ/v1', 'search', array(
    'methods' => WP_REST_Server::READABLE, // GET
    'callback' => 'universitySearchResults',
  ));
}

function universitySearchResults($data)
{
  $main_query = new WP_Query(array(
    's' => sanitize_text_field($data['term']),
    'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
  ));

  $results = array(
    'generalInfo' => array(),
    'professors' => array(),
    'programs' => array(),
    'events' => array(),
    'campuses' => array(),
  );

  while ($main_query->have_posts()) {
    $main_query->the_post();

    if (get_post_type() == 'post') {
      array_push($results['generalInfo'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
        'authorName' => get_the_author(),
      ));
    }

    if (get_post_type() == 'page') {
      array_push($results['generalInfo'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
      ));
    }

    if (get_post_type() == 'program') {
      array_push($results['programs'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'id' => get_the_ID(),
      ));

      // 開講キャンパスを追加
      $related_campuses = get_field('related_campus');
      if($related_campuses){
        foreach($related_campuses as $campus) {
          array_push($results['campuses'], array(
            'title' => get_the_title($campus),
            'permalink' => get_the_permalink($campus),
          ));
        }
      }
    }

    if (get_post_type() == 'professor') {
      array_push($results['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'image' => get_the_post_thumbnail_url(0, 'professor-landscape')
      ));
    } 

    if (get_post_type() == 'event') {
      $description = null;
      if (has_excerpt()) {
        $description = get_the_excerpt();
      } else {
        $description = wp_trim_words(get_the_content(), 18);
      }

      array_push($results['events'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'month' => (new DateTime(get_field('event_date')))->format('M'),
        'day' => (new DateTime(get_field('event_date')))->format('d'),
        'description' => $description,
      ));
    }

    if (get_post_type() == 'campus') {
      array_push($results['campuses'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
      ));
    }
  }

  if ($results['programs']) {
    // 担当教授、関連イベントを検索
    $program_meta_query = array('relation' => 'OR');
    foreach($results['programs'] as $program) {
      array_push($program_meta_query, array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . $program['id'] . '"'
        ));
    }
    $program_related_query = new WP_Query(array(
      'post_type' => array('professor', 'event'),
      'meta_query' => $program_meta_query
    ));

    while($program_related_query->have_posts()) {
      $program_related_query->the_post();

      if (get_post_type() == 'professor') {
        array_push($results['professors'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'image' => get_the_post_thumbnail_url(0, 'professor-landscape')
        ));
      } 

      if (get_post_type() == 'event') {
        $description = null;
        if (has_excerpt()) {
          $description = get_the_excerpt();
        } else {
          $description = wp_trim_words(get_the_content(), 18);
        }
        array_push($results['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'month' => (new DateTime(get_field('event_date')))->format('M'),
          'day' => (new DateTime(get_field('event_date')))->format('d'),
          'description' => $description,
        ));
      }
    }

    // $main_query の結果との重複を排除
    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    $results['campuses'] = array_values(array_unique($results['campuses'], SORT_REGULAR));
  }

  return $results;
}

add_action('rest_api_init', 'my_register_search');
