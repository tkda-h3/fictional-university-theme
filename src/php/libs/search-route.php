<?php 

function my_register_search(){
  register_rest_route('univ/v1', 'search', array(
    'methods' => WP_REST_Server::READABLE, // GET
    'callback' => 'universitySearchResults',
  ));
}

function universitySearchResults() {
  $professors = new WP_Query(array(
    'post_type' => 'professor'
  ));

  $professorResults = array();
  while($professors->have_posts()) {
    $professors->the_post();
    array_push($professorResults, array(
      'title' => get_the_title(),
      'permalink' => get_the_permalink(),
    ));
  }
  return $professorResults;
}

add_action('rest_api_init', 'my_register_search');
