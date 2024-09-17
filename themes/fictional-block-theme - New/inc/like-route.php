<?php

add_action('rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes() {
  register_rest_route('university/v1', 'manageLike', array(
    'methods' => 'POST',
    'callback' => 'createLike'
  ));

  register_rest_route('university/v1', 'manageLike', array(
    'methods' => 'DELETE',
    'callback' => 'deleteLike'
  ));
}

function createLike($data) {
  if(is_user_logged_in()) {
    $professor = sanitize_text_field($data['professorId']);

    $anyLikes = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => 'like',
      'meta_query' => array(array(
          'key' => 'like_professor_id',
          'compare' => '=',
          'value' => $professor
      )
      )
  ));

    if($anyLikes->found_posts == 0 AND get_post_type($professor) == 'professor') {
      //create new post
      return wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => 'New Like',
        'meta_input' => array(
          'like_professor_id' => $professor
        )
      )
      );
      
    } else {
      die("Only logged in users can like a post.");
    }
    
  } else{
    die("You must be logged in to do that!");
  }
 
}

function deleteLike($data) {
  $likeID = sanitize_text_field($data['like']);
  if (get_current_user_id() == get_post_field('post_author', $likeID) AND get_post_type($likeID) == 'like') {
    wp_delete_post($likeID, true);
    return 'Like is deleted!';
  } else {
    die("You do not have permission to do that");
  }
}