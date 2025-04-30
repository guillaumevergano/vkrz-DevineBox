<?php
function generate_toplist_mondiale($post_id){
  $tm = new WP_Query(array(
    'ignore_sticky_posts'	=> true,
    'update_post_meta_cache' => false,
    'no_found_rows'		  => true,
    'post_type'			  => 'toplist-mondiale',
    'orderby'				=> 'date',
    'order'				  => 'DESC',
    'posts_per_page'		 => 1,
    'meta_query' => array(
      array(
        'key'     => 'id_du_top_tm',
        'value'   => $post_id,
        'compare' => '=',
    ),
  ),
  ));
  if (!$tm->have_posts()) {
    $top_title     = get_the_title($post_id) . " " . get_field('question_t', $post_id);
    $new_tm_entry = array(
      'post_type'   => 'toplist-mondiale',
      'post_title'  => $top_title,
      'post_status' => 'publish',
    );
    if ($post_id) {
      $id_tm  = wp_insert_post($new_tm_entry);
      update_field('id_du_top_tm', $post_id, $id_tm);
    }
    if($id_tm){
      update_field('id_tm_t', $id_tm, $post_id);
    }
    if (!get_field('uuid_creator_t', $post_id)) {
      $creator_id     = get_post_field("post_author", $post_id);;
      $uuid_creator   = get_field('uuiduser_user', 'user_' . $creator_id);
      update_field('uuid_creator_t', $uuid_creator, $post_id);
    }
  }
}
add_action('publish_tournoi', 'generate_toplist_mondiale');

function get_toplist_mondiale($id_top){
  $toplismondiale = new WP_Query(array(
    'ignore_sticky_posts'	      => true,
    'update_post_meta_cache'    => false,
    'fields'                    => 'ids',
    'post_status'               => 'publish',
    'no_found_rows'		          => true,
    'post_type'			            => 'toplist-mondiale',
    'posts_per_page'		        => 1,
    'meta_query' => array(
      array(
        'key'     => 'id_du_top_tm',
        'value'   => $id_top,
        'compare' => '=',
      ),
    ),
  ));
  foreach ($toplismondiale->posts as $id_toplismondiale){
    return $id_toplismondiale;
  }
}