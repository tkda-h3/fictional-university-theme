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

  $post_type_to_result_key = array(
    'post' => 'generalInfo',
    'page' => 'generalInfo',
    'professor' => 'professors',
    'program' => 'programs',
    'event' => 'events',
    'campus' => 'campuses',
  );

  while ($main_query->have_posts()) {
    $main_query->the_post();

    array_push(
      $results[$post_type_to_result_key[get_post_type()]],
      array( 
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
      ),
    );
  }
  return $results;
}

add_action('rest_api_init', 'my_register_search');
