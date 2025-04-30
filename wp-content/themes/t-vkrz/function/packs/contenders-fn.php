<?php
function update_count_contenders($id_top) {
  global $wpdb;
  $contender_count = new WP_Query(
    array(
      'post_type'              => 'contender',
      'posts_per_page'         => '-1',
      'fields'                 => 'ids',
      'post_status'            => 'publish',
      'ignore_sticky_posts'    => true,
      'update_post_meta_cache' => false,
      'no_found_rows'          => false,
      'meta_query'     => array(
        array(
          'key'     => 'id_tournoi_c',
          'value'   => $id_top,
          'compare' => '=',
        )
      )
    )
  );

  $count = $contender_count->post_count;
  $table_name = $wpdb->prefix . 'postmeta';
  $result = $wpdb->update(
      $table_name,
      array('meta_value' => $count), // new value
      array(
          'post_id' => $id_top,
          'meta_key' => 'count_contenders_t'
      )
  );
  update_field('count_contenders_t', $count, $id_top);

  if (false === $result) { } // Handle error; update failed 
}

function get_contender_elo($id_contender) {
    $elo_c = false;
    if ($elo_c === false) {
        $url      = get_base_api_url() . "/contender/elo/{$id_contender}";
        $response = wp_remote_get($url);
        $body     = wp_remote_retrieve_body($response);
        $data     = json_decode($body, true);
        
        if (isset($data['elo_c'])) {
            $elo_c = $data['elo_c'];
            set_transient("elo_{$id_contender}", $elo_c, 0.2 * HOUR_IN_SECONDS);
        } else {
            $elo_c = 1200;
        }
    }

    return $elo_c;
}

function get_contender($data) {
  $id_contender = intval($data['id_contender']);
  $type         = "complet";
  $type         = $data['type'];
  
  $post = get_post($id_contender);
  if ($post && $post->post_type == 'contender') {
    setup_postdata($post);
    $fields = get_fields($post->ID);
    
    $thumbnail = '';
    if (!empty($fields['visuel_firebase_contender'])) {
        $thumbnail = $fields['visuel_firebase_contender'];
    } elseif (!empty($fields['visuel_instagram_contender'])) {
        $thumbnail = $fields['visuel_instagram_contender'];
    } else {
        $thumbnail = get_the_post_thumbnail_url($post->ID);
    }
    $embed = '';
    if (!empty($fields['embed_contender'])) {
        $embed = $fields['embed_contender'];
    }

    if (env() == "local") {
      $thumbnail = str_replace("http://localhost:8888/vkrz-wp/", "https://vainkeurz.com/", $thumbnail);
    }

    // Use the null coalescing operator for 'info_supplementaire_contender' as well
    $info_sup = $fields['info_supplementaire_contender'] ?? '';

    if($type == "simple"){
      $elo_c = null;
    }
    else{
      $elo_c = get_contender_elo($id_contender);
    }

    return array(
      'title'     => get_the_title($post->ID),
      'thumbnail' => $thumbnail,
      'embed'     => $embed,
      'info_sup'  => $info_sup,
      'elo'       => $elo_c,
      'id_wp'     => $id_contender
    );

    wp_reset_postdata();  // Cleanup after setup_postdata
  } else {
    return 'Aucun contender trouvé';
  }
}

function add_contender_from_api_create_top() {
  $url_visual                = $_POST['contenderURL'];
  $name                      = $_POST['contenderName'];
  $id_top                    = $_POST['idTop'];
  $top_contenders_dimensions = $_POST['topContendersDimensions'] ?? null;
  $embed_contender           = $_POST['embedContender'] ?? null; // Only for YouTube

  if ($url_visual) {
    $new_contender = array(
      'post_type'   => 'contender',
      'post_title'  => $name,
      'post_status' => 'publish',
    );

    // Insert new contender
    $id_new_contender = wp_insert_post($new_contender);

    if (get_post($id_new_contender)) {
      // Check if this is a YouTube-based TopList
      $is_youtube_toplist = !empty($embed_contender);

      if ($is_youtube_toplist) {
        // Update fields for YouTube contenders
        update_field('visuel_instagram_contender', $url_visual, $id_new_contender); // Thumbnail URL
        update_field('embed_contender', $embed_contender, $id_new_contender); // Embed iframe

        // Mark the TopList as YouTube-based in ACF
        update_field('is_toplist_type_youtube_videos', true, $id_top);
      } else {
        // Update fields for normal contenders
        update_field('visuel_firebase_contender', $url_visual, $id_new_contender);
        update_field('top_contenders_dimensions', $top_contenders_dimensions, $id_top);
      }

      // Process additional logic
      update_field('id_tournoi_c', $id_top, $id_new_contender);
      send_contender_tosql($id_new_contender, $id_top, $name);
      update_count_contenders($id_top);

      return $id_new_contender;
    }
  }
}

function update_contender($data) {
  $idContender    = $data['id_contender'];
  $nameContender  = $data['name_contender'];
  $urlContender   = isset($data['url_contender']) ? $data['url_contender'] : null;
  $embedContender = isset($data['embedContender']) ? $data['embedContender'] : null;

  // Get associated TopList ID
  $id_top = get_field('id_tournoi_c', $idContender);
  if ($id_top) {
    // Mark the TopList as "creation" status for re-validation
    update_field('validation_top', 'creation', $id_top);
    generate_json_data();
  }

  // Update the contender's post title
  $post = array(
    'ID' => $idContender,
    'post_title' => html_entity_decode($nameContender),
  );
  wp_update_post($post);

  // Handle normal contender updates
  if (get_post_type($idContender) === 'contender') {
    // If it's a normal contender with a thumbnail, remove old thumbnail if URL is provided
    if (has_post_thumbnail($idContender) && !empty($urlContender)) {
      delete_post_thumbnail($idContender);
    }

    if (!empty($urlContender)) {
      update_field('visuel_firebase_contender', $urlContender, $idContender);
    }
  }

  // Handle YouTube contender-specific updates
  if (!empty($embedContender)) {
    // Save embedContender field for YouTube videos
    update_field('embed_contender', $embedContender, $idContender);

    // Update the thumbnail field with the YouTube video thumbnail
    if (!empty($urlContender)) {
      update_field('visuel_instagram_contender', $urlContender, $idContender);
    }
  }

  // Update the total contenders count for the associated TopList
  update_count_contenders($id_top);

  return $idContender;
}

function update_contender_name( WP_REST_Request $request ) {
  $id_contender   = $request['id_contender'];
  $name_contender = $request['name_contender'];

  $id_top         = get_field('id_tournoi_c', $id_contender);

  $update_result = wp_update_post(array(
      'ID'         => $id_contender,
      'post_title' => sanitize_text_field($name_contender),
  ), true);

  if (is_wp_error($update_result)) {
      return new WP_Error( 'update_failed', 'Failed to update contender name', array( 'status' => 500 ) );
  }
  
  return new WP_REST_Response( array( 'message' => 'Contender name updated successfully' ), 200 );
}

function delete_contender($data) {
  $id_contender = $data['id_contender'];
  $id_top       = get_field('id_tournoi_c', $id_contender);
  wp_delete_post($id_contender, true);

  if(get_post($id_contender)) {
    return array(
      'success' => false,
      'message' => 'Une erreur est survenue lors de la suppression du contender'
    );
  }
  else {
    update_count_contenders($id_top);
    return array(
      'success' => true,
      'message' => 'Le contender a bien été supprimé'
    );
  }
}

function get_contender_seo($contender_slug) {
  $id_contender = 0;

  $contender_query = new WP_Query(array(
      'ignore_sticky_posts'   => true,
      'update_post_meta_cache' => false,
      'no_found_rows'         => true,
      'post_type'             => 'contender',
      'posts_per_page'        => 1,
      'name'                  => $contender_slug
  ));

  if ($contender_query->have_posts()) {
      $contender_query->the_post();
      $id_contender = get_the_ID();
  }

  wp_reset_postdata();
  return $id_contender;
}

function send_contender_tosql($id_contender, $id_top, $name) {
  $contender = array(
    'id_contender' => $id_contender,
    "elo"          => 1200,
    'id_top'       => $id_top,
    'name'         => $name
  );
  $endpoint = get_base_api_url() . "/contender/import";
  $response = wp_remote_post($endpoint, array(
    'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
    'body'    => http_build_query($contender),
  ));
}