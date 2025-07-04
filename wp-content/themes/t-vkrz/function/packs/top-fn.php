<?php
function add_top_from_api() {
  $topTitle       = $_POST['topTitle'];
  $topType        = $_POST['topType'];
  $creatorRole    = $_POST['creatorRole'];
  $topCategory    = $_POST['topCategory'];
  $topQuestion    = $_POST['topQuestion'];
  $topDescription = $_POST['topDescription'];
  $topBanner      = $_POST['topBanner'];
  $topAuthor      = $_POST['topAuthor'];

  if($topType == "public"){
    $topType = 549;
  } else {
    $topType = 546;
  }
  
  $new_post = array(
    'post_title'  => $topTitle,
    'post_status' => 'publish',
    'post_type'   => 'tournoi',
  );
  $post_id = wp_insert_post($new_post);

  wp_set_object_terms($post_id, intval($topCategory), 'categorie');
  wp_set_object_terms($post_id, intval($topType), 'type');

  update_field('question_t', $topQuestion, $post_id);
  update_field('precision_t', $topDescription, $post_id);
  update_field('visuel_externe_top_firebase', $topBanner, $post_id);
  update_field('uuid_creator_t', $topAuthor, $post_id);
  update_field('validation_top', 'creation', $post_id);

  if(isset($_FILES['top-background']) && $_FILES['top-background']['error'] == 0) {
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      require_once(ABSPATH . 'wp-admin/includes/file.php');
      require_once(ABSPATH . 'wp-admin/includes/media.php');

      $attachment_id = media_handle_upload('top-background', 0);
      
      if(is_wp_error($attachment_id)) {
        error_log(print_r($attachment_id, true));
      } else {
          error_log(print_r($attachment_id, true));
          update_field('cover_t', $attachment_id, $post_id);
      }
  }

  return [$post_id, get_permalink($post_id)];
}

function update_top() {
  $id_top         = $_POST['id_top'];
  $topTitle       = $_POST['topTitle'];
  $topCategory    = $_POST['topCategory'];
  $topQuestion    = $_POST['topQuestion'];
  $topDescription = $_POST['topDescription'];
  $topBanner      = $_POST['topBanner'];

  wp_set_object_terms( $id_top, intval( $topCategory ), 'categorie' );

  $post = array(
    'ID' => $id_top,
    'post_title' => $topTitle
  );
  wp_update_post($post);

  update_field('question_t', $topQuestion, $id_top);
  update_field('precision_t', $topDescription, $id_top);
  update_field('validation_top', 'creation', $id_top);

  if (!empty($topBanner)) {
    delete_post_thumbnail($id_top);
    update_field('visuel_externe_top_firebase', $topBanner, $id_top);
  }
  else {
    update_field('visuel_externe_top_firebase', '', $id_top);
  }

  if (isset($_FILES['top-background']) && $_FILES['top-background']['error'] == 0) {
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    $attachment_id = media_handle_upload('top-background', 0);
    
    if(!is_wp_error($attachment_id)) {
      error_log(print_r($attachment_id, true));
      update_field('cover_t', $attachment_id, $id_top);
    }
  } else if (isset($_POST['top-background']) && $_POST['top-background'] === "false") { 
    error_log("add background false");
    update_field('cover_t', 0, $id_top);
  } 
  return $id_top;
}

function get_the_top_info($data) {
  $id_top        = $data['id_top'];
  $type          = $data['type'];
  if(get_post($id_top)) {
    $result        = get_top_infos($id_top, $type);
  } else {
    $result = array("error" => "Top not found");
  }
  return $result;
}

function get_tops_tendance($data) {

  $tendance     = strval(str_replace('-', ' ', $data['tendance']));
  $list_tops    = array();
  $result       = array();

  // SEARCH BY TITLE…
  $tops_to_find = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'tax_query'                 => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      )
    ),
    's'                         => $tendance,
  ));
  while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
    array_push($list_tops, get_the_ID());
  endwhile;

  // SEARCH BY QUESTION_T…
  $tops_to_find = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'tax_query'                 => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
    'meta_query'   => array(
      array(
        'key'       => 'question_t',
        'value'     => $tendance,
        'compare'   => 'LIKE',
      ),
    ),
  ));
  while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
    array_push($list_tops, get_the_ID());
  endwhile;

  $sujet_id = 0;
  $sujet_t = get_terms(array(
    'taxonomy'      => 'concept',
    'orderby'       => 'name',
    'order'         => 'ASC',
    'hide_empty'    => true,
  ));
  foreach ($sujet_t as $sujet) :
    if ($tendance == mb_strtolower($sujet->name)) {
      $sujet_id = $sujet->term_id;
    }
  endforeach;
  $tops_to_find = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'tax_query'                 => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'concept',
        'field'    => 'term_id',
        'terms'    => $sujet_id,
      ),
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
  ));
  while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
    array_push($list_tops, get_the_ID());
  endwhile;

  $contenders_to_find = new WP_Query(array(
    'post_type'                 => 'contender',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    's'                         => $tendance
  ));
  while ($contenders_to_find->have_posts()) : $contenders_to_find->the_post();
    array_push($list_tops, get_field('id_tournoi_c'));
  endwhile;

  $list_tops_unique   = array_unique($list_tops);

  // INSERT INTO BDD
  global $wpdb;
  $table_name = 'boteurz_top';

  foreach ($list_tops_unique as $id_top) {

    $list_type    = array();
    $get_top_type = get_the_terms($id_top, 'type');
    if ($get_top_type) {
      foreach ($get_top_type as $type_top) {
        array_push($list_type, $type_top->slug);
      }
    }
    if (!in_array('private', $list_type) && !in_array('onboarding', $list_type) && get_post_status($id_top) == "publish") {

      $list_tops_already_tweet = $wpdb->get_results("SELECT * FROM $table_name WHERE id_top='$id_top' AND date_search > now() - interval 24 hour");

      if (!$list_tops_already_tweet) {
        $top_info = get_top_infos($id_top, 'slim');
        $url_top  = $top_info['top_url'] . "?utm_campaign=boteurz";
        if ($url_top) {
          array_push($result, array(
            "id_top"        => $id_top,
            "tweet"         => "#" . $tendance . " - " . $top_info['top_question'] . " 👉 " . $url_top,
          ));
        }
        $wpdb->insert($table_name, array('id_top' => $id_top, 'tendance' => $tendance));
      }
    }
  }
  return $result;
}

function get_the_top_auth($data) {
  $id_top        = $data['id_top'];
  if (get_field('uuid_creator_t', $id_top)) {
    $uuid_creator   = get_field('uuid_creator_t', $id_top);
  } else {
    $creator_id     = get_post_field("post_author", $id_top);;
    $uuid_creator   = get_field('uuiduser_user', 'user_' . $creator_id);
    update_field('uuid_creator_t', $uuid_creator, $id_top);
  }
  return $uuid_creator;
}

function get_top_meta($data) {
  $id_top             = $data['id_top'];
  $title_top          = get_the_title($id_top);
  $question_top       = get_field('question_t', $id_top);
  $top_title_question = $title_top . "-" . $question_top;
  $ttq_wEmoji         = createSlug($top_title_question);
  $slug_top           = sanitize_title($ttq_wEmoji);
  return array(
    'title'     => $title_top,
    'question'  => $question_top,
    'slug'      => $slug_top
  );
}
function get_all_sponso_info($data) {
  $list_sponso = array();

  $sponso_tops = new WP_Query(array(
      'post_type'              => 'tournoi',
      'posts_per_page'         => -1,
      'ignore_sticky_posts'    => true,
      'update_post_meta_cache' => false,
      'no_found_rows'          => true,
      'tax_query'              => array(
          array(
              'taxonomy' => 'type',
              'field'    => 'slug',
              'terms'    => 'sponso'
          ),
      ),
  ));

  if ($sponso_tops->have_posts()) {
      while ($sponso_tops->have_posts()) : $sponso_tops->the_post();
          $id_top = get_the_ID();
          $gain_champs_1 = get_field('gain_champs_1_t_sponso', $id_top);
          if (!empty($gain_champs_1)) {
              $list_sponso[] = array(
                  'id_top'            => $id_top, // Ajout de l'ID du top
                  'logo_de_la_sponso' => wp_get_attachment_image_url(get_field('logo_de_la_sponso_t_sponso', $id_top), 'large'),
                  'cadeau'            => wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large'),
                  'gain_champs_1'     => $gain_champs_1,
                  'gain_champs_2'     => get_field('gain_champs_2_t_sponso', $id_top)
              );
          }
      endwhile;
  }

  return $list_sponso;
}


function get_the_sponso_info($data) {
  $id_top = $data['id_top'];
  $result = array();

  $list_type_top = array();
  $get_top_type = get_the_terms($id_top, 'type');
  if ($get_top_type) {
    foreach ($get_top_type as $type_top) {
      array_push($list_type_top, $type_top->slug);
    }
  }

  $date_fin_de_la_sponso = get_field('date_fin_de_la_sponso_t_sponso', $id_top);
  $date_fin_de_la_sponso = DateTime::createFromFormat('d/m/Y', $date_fin_de_la_sponso);

  $date_du_jour = new DateTime();
  $date_du_jour->setTime(0, 0); // to compare only dates, not time

  $fin_de_la_sponso_t_sponso = get_field('fin_de_la_sponso_t_sponso', $id_top);
  if(get_field("top_permanent_topsponso", $id_top)) {
    if(get_field("fin_de_la_sponso_t_sponso_decalage", $id_top)) {
      $fin_de_la_sponso_t_sponso = get_field('fin_de_la_sponso_t_sponso_decalage', $id_top);
    }
  }

  if (in_array('sponso', $list_type_top)) {
    if ($date_du_jour <= $date_fin_de_la_sponso || get_field('top_permanent_topsponso', $id_top)) {
      $result = array(
        'logo_de_la_sponso' => wp_get_attachment_image_url(get_field('logo_de_la_sponso_t_sponso', $id_top), 'large'),
        'description' => get_field('description_t_sponso', $id_top),
        'cadeau' => wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large'),
        'fin_de_la_sponso' => $fin_de_la_sponso_t_sponso,
        'is_top_permanent' => get_field('top_permanent_topsponso', $id_top),
        'tweet_wording_debut' => get_field('tweet_wording_debut_t_sponso', $id_top),
        'tweet_marque_tag' => get_field('tweet_marque_tag_t_sponso', $id_top),
        'tweet_contenders_show' => get_field('tweet_contenders_show_t_sponso', $id_top),
        'tweet_hashtag' => get_field('tweet_hashtag_t_sponso', $id_top),
        'tweet_utm' => get_field('tweet_utm_t_sponso', $id_top),
        'gain_champs_1' => get_field('gain_champs_1_t_sponso', $id_top),
        'gain_champs_2' => get_field('gain_champs_2_t_sponso', $id_top),
        'message_de_confirmation' => get_field('message_de_confirmation_t_sponso', $id_top),
        'message_email' => get_field('message_email_t_sponso', $id_top),
        'is_sponso_active' => true,
      );
    } else {
      $result = array(
        'logo_de_la_sponso' => wp_get_attachment_image_url(get_field('logo_de_la_sponso_t_sponso', $id_top), 'large'),
        'description' => get_field('description_t_sponso', $id_top),
        'cadeau' => wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large'),
        'fin_de_la_sponso' => $fin_de_la_sponso_t_sponso,
        'is_top_permanent' => get_field('top_permanent_topsponso', $id_top),
        'tweet_wording_debut' => get_field('tweet_wording_debut_t_sponso', $id_top),
        'tweet_marque_tag' => get_field('tweet_marque_tag_t_sponso', $id_top),
        'tweet_contenders_show' => get_field('tweet_contenders_show_t_sponso', $id_top),
        'tweet_hashtag' => get_field('tweet_hashtag_t_sponso', $id_top),
        'tweet_utm' => get_field('tweet_utm_t_sponso', $id_top),
        'gain_champs_1' => get_field('gain_champs_1_t_sponso', $id_top),
        'gain_champs_2' => get_field('gain_champs_2_t_sponso', $id_top),
        'message_de_confirmation' => get_field('message_de_confirmation_t_sponso', $id_top),
        'message_email' => get_field('message_email_t_sponso', $id_top),
        'is_sponso_active' => false,
      );
    }
  } else {
    $result = 'Ce top n\'est pas sponsorisé';
  }

  return $result;
}

function get_all_similar_top($data) {

  $id_top     = $data['id_top'];
  $id_cat     = $data['id_cat'];
  $uuid_user  = $data['uuid_user'];
  $limit      = intval($data['limit']);
  $count_similar  = 0;
  $count_next     = 0;

  $list_tops_ids      = array();
  $list_tops          = array();
  $result             = array();
  $list_souscat       = array();
  $tops_in_large_cat  = array();
  $done_tops          = array();
  
  $top_souscat   = get_the_terms($id_top, 'sous-cat');
  if (!empty($top_souscat)) {
    foreach ($top_souscat as $souscat) {
      array_push($list_souscat, $souscat->slug);
    }
  }

  $url = get_base_api_url() . '/inventaire/get';
  $response = wp_remote_post($url, array(
    'body' => json_encode(array(
      'uuid_user' => $uuid_user
    )),
    'headers' => array(
      'Content-Type' => 'application/json'
    )
  ));

  if (is_wp_error($response)) {
    $error_message = $response->get_error_message();
    return "Something went wrong: $error_message";
  } else {
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);
    if (json_last_error() === JSON_ERROR_NONE) {
      if (isset($data->list_top_done)) {
        $done_tops = $data->list_top_done;
      } else {
        $done_tops = array();
      }
    }
  }

  $tops_in_close_cat     = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'tournoi',
    'orderby'                => 'rand',
    'order'                  => 'ASC',
    'posts_per_page'         => $limit,
    'post__not_in'           => $done_tops,
    'meta_query' => array(
      array(
        'key'     => 'validation_top',
        'value'   => array('valide'),
        'compare' => 'IN',
      )
    ),
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'categorie',
        'field'    => 'term_id',
        'terms'    => array($id_cat)
      ),
      array(
        'taxonomy' => 'concept',
        'field' => 'slug',
        'terms' => $list_souscat
      ),
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel'),
        'operator' => 'NOT IN'
      ),
    ),
  ));
  $count_similar = $tops_in_close_cat->post_count;
  $count_next    = $limit - $count_similar;
  if ($count_next < 0) {
    $count_next = 0;
  }
  if ($tops_in_close_cat->have_posts()) {
    while ($tops_in_close_cat->have_posts()) : $tops_in_close_cat->the_post();
      array_push($list_tops_ids, get_the_ID());
      $info_top = get_top_infos(get_the_ID(), 'slim');
      array_push($list_tops, $info_top);
    endwhile;
  }

  $array_total_tops = array_merge($done_tops, $list_tops_ids);

  if ($count_next > 0) {
    $tops_in_large_cat     = new WP_Query(array(
      'ignore_sticky_posts'    => true,
      'update_post_meta_cache' => false,
      'no_found_rows'          => true,
      'post_type'              => 'tournoi',
      'orderby'                => 'rand',
      'order'                  => 'ASC',
      'posts_per_page'         => $count_next,
      'post__not_in'           => $array_total_tops,
      'meta_query' => array(
        array(
          'key'     => 'validation_top',
          'value'   => array('valide'),
          'compare' => 'IN',
        )
      ),
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'categorie',
          'field'    => 'term_id',
          'terms'    => array($id_cat)
        ),
        array(
          'taxonomy' => 'type',
          'field'    => 'slug',
          'terms'    => array('private', 'whitelabel'),
          'operator' => 'NOT IN'
        ),
      ),
    ));
    if ($tops_in_large_cat->have_posts()) {
      while ($tops_in_large_cat->have_posts()) : $tops_in_large_cat->the_post();
        $info_top = get_top_infos(get_the_ID());
        array_push($list_tops, $info_top);
      endwhile;
    }
  }
  
  $cat        = get_term($id_cat, 'categorie');
  $cat_name   = $cat->name . " ";
  $cat_icon   = get_field('icone_cat', 'term_' . $cat->term_id);
  $cat_url    = get_term_link($cat->term_id, 'categorie');
  $cat_slogan = $cat->description;

  array_push($result, array(
    'limit' => $limit,
    'count_similar' => $count_similar,
    'count_next' => $count_next,
    'cat_info' => array(
      'cat_id'     => $cat->term_id,
      'cat_name'   => $cat_name,
      'cat_icon'   => $cat_icon,
      'cat_url'    => $cat_url,
      'cat_slogan' => $cat_slogan
    ),
    'list_tops' => $list_tops
  ));

  return $result;
}

function get_all_cat_top($data) {

  $id_cat = $data['id_cat'];
  $limit  = $data['limit'];

  $list_tops      = array();
  $result         = array();
  $list_terms     = array();
  $term_counts    = array();

  $cat        = get_term($id_cat, 'categorie');
  $cat_name   = $cat->name . " ";
  $cat_icon   = get_field('icone_cat', 'term_' . $cat->term_id);
  $cat_url    = get_term_link($cat->term_id, 'categorie');
  $cat_slogan = $cat->description;
  
  $tops_in_cat     = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'tournoi',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => $limit,
    'meta_query' => array(
      array(
        'key'     => 'validation_top',
        'value'   => array('valide'),
        'compare' => 'IN',
      )
    ),
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'categorie',
        'field'    => 'term_id',
        'terms'    => array($id_cat)
      ),
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel'),
        'operator' => 'NOT IN'
      ),
    ),
  ));
  if ($tops_in_cat->have_posts()) {
    
    while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post();
      $info_top         = get_top_infos(get_the_ID(), 'slim', $cat_name, $cat_icon, $cat_url);
      array_push($list_tops, $info_top);
      array_push($list_terms, get_the_title());
    endwhile;

    foreach ($list_terms as $term) {
      if (isset($term_counts[$term])) {
        $term_counts[$term]++;
      } else {
        $term_counts[$term] = 1;
      }
    }
    arsort($term_counts);

    $list_terms_sorted = [];
    foreach ($term_counts as $term => $count) {
      $list_terms_sorted[] = [
        'term_name'       => $term,
        'term_slug'       => sanitize_title($term),
        'term_repetition' => $count,
      ];
    }

  }

  $cat_count  = $tops_in_cat->post_count;

  array_push($result, array(
    'cat_info' => array(
      'cat_id'     => $cat->term_id,
      'cat_name'   => $cat_name,
      'cat_icon'   => $cat_icon,
      'cat_count'  => $cat_count,
      'cat_url'    => $cat_url,
      'cat_slogan' => $cat_slogan
    ),
    'list_terms'   => $list_terms_sorted,
    'list_tops'    => $list_tops
  ));

  return $result;
}

function get_all_cat_top_popular($data) {

  $id_cat = $data['id_cat'];
  $limit  = $data['limit'];

  $list_tops      = array();
  $result         = array();
  $list_terms     = array();
  $term_counts    = array();

  $cat        = get_term($id_cat, 'categorie');
  $cat_name   = $cat->name . " ";
  $cat_icon   = get_field('icone_cat', 'term_' . $cat->term_id);
  $cat_url    = get_term_link($cat->term_id, 'categorie');
  $cat_slogan = $cat->description;

  // Détecter l'environnement (local ou prod)
  $base_url = ($_SERVER['SERVER_NAME'] === 'localhost') 
      ? "http://localhost:8000/vkrz/" 
      : "https://api.vainkeurz.com/vkrz/";

  // Récupérer les données depuis l'URL appropriée
  $resume_data = json_decode(file_get_contents($base_url . 'resume-data'), true);
  $resume_map  = array_column($resume_data, 'nb_tops_resume', 'id_top_resume'); // Associe id_top_resume à nb_tops_resume

  $tops_in_cat = new WP_Query(array(
      'ignore_sticky_posts'    => true,
      'update_post_meta_cache' => false,
      'no_found_rows'          => true,
      'post_type'              => 'tournoi',
      'orderby'                => 'date',
      'order'                  => 'DESC',
      'posts_per_page'         => $limit,
      'meta_query' => array(
          array(
              'key'     => 'validation_top',
              'value'   => array('valide'),
              'compare' => 'IN',
          )
      ),
      'tax_query' => array(
          'relation' => 'AND',
          array(
              'taxonomy' => 'categorie',
              'field'    => 'term_id',
              'terms'    => array($id_cat)
          ),
          array(
              'taxonomy' => 'type',
              'field'    => 'slug',
              'terms'    => array('private', 'whitelabel', 'sponso'),
              'operator' => 'NOT IN'
          ),
      ),
  ));

  if ($tops_in_cat->have_posts()) {
      while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post();
          $info_top = get_top_infos(get_the_ID(), 'slim', $cat_name, $cat_icon, $cat_url);

          // Ajouter le nombre de tops résumé (si disponible)
          $info_top['nb_tops_resume'] = $resume_map[$info_top['top_id']] ?? 0;

          array_push($list_tops, $info_top);
          array_push($list_terms, get_the_title());
      endwhile;

      foreach ($list_terms as $term) {
          if (isset($term_counts[$term])) {
              $term_counts[$term]++;
          } else {
              $term_counts[$term] = 1;
          }
      }
      arsort($term_counts);

      $list_terms_sorted = [];
      foreach ($term_counts as $term => $count) {
          $list_terms_sorted[] = [
              'term_name'       => $term,
              'term_slug'       => sanitize_title($term),
              'term_repetition' => $count,
          ];
      }
  }

  // Trier list_tops par nb_tops_resume (décroissant)
  usort($list_tops, function ($a, $b) {
      return $b['nb_tops_resume'] <=> $a['nb_tops_resume'];
  });

  $cat_count = $tops_in_cat->post_count;

  array_push($result, array(
      'cat_info' => array(
          'cat_id'     => $cat->term_id,
          'cat_name'   => $cat_name,
          'cat_icon'   => $cat_icon,
          'cat_count'  => $cat_count,
          'cat_url'    => $cat_url,
          'cat_slogan' => $cat_slogan
      ),
      'list_terms'   => $list_terms_sorted,
      'list_tops'    => $list_tops
  ));

  return $result;
}

function get_all_cat_top_id($data) {
  $id_cat       = $data['id_cat'];
  $limit        = $data['limit'];
  $list_tops    = array();

  // 1. Récupérer les tops via WP_Query
  $tops_in_cat = new WP_Query(array(
      'ignore_sticky_posts'    => true,
      'update_post_meta_cache' => false,
      'no_found_rows'          => true,
      'post_type'              => 'tournoi',
      'orderby'                => 'date',
      'order'                  => 'DESC',
      'posts_per_page'         => $limit,
      'meta_query' => array(
          array(
              'key'     => 'validation_top',
              'value'   => array('valide'),
              'compare' => 'IN',
          )
      ),
      'tax_query' => array(
          'relation' => 'AND',
          array(
              'taxonomy' => 'categorie',
              'field'    => 'term_id',
              'terms'    => array($id_cat)
          ),
          array(
              'taxonomy' => 'type',
              'field'    => 'slug',
              'terms'    => array('private', 'whitelabel'),
              'operator' => 'NOT IN'
          ),
      ),
  ));

  if ($tops_in_cat->have_posts()) {
      while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post();
          $list_tops[] = get_the_ID();
      endwhile;
  }

  return $list_tops;
}

function get_last_tops($data) {
    $limit = $data['limit'];
    $id_cat = isset($data['id_cat']) ? $data['id_cat'] : null;
    $list_tops = array();
    $result = array();

    // Prepare the query arguments
    $query_args = array(
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'post_type'              => 'tournoi',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'posts_per_page'         => $limit,
        'meta_query' => array(
            array(
                'key'     => 'validation_top',
                'value'   => array('valide'),
                'compare' => 'IN',
            )
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field'    => 'slug',
                'terms'    => array('private', 'whitelabel'),
                'operator' => 'NOT IN'
            ),
        ),
    );

    // Add custom taxonomy filter if id_cat is provided
    if (!is_null($id_cat)) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $id_cat
        );
    }

    $tops_in_cat = new WP_Query($query_args);

    if ($tops_in_cat->have_posts()) {
        while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post();
          $info_top = get_top_infos(get_the_ID(), 'slim');
          array_push($list_tops, $info_top);
        endwhile;
    }

    array_push($result, array(
        'list_tops' => $list_tops
    ));

    return $result;
}

function get_all_search_top($data) {
    $recherche = urldecode(strval($data['recherche']));
    $list_result = array();
    $list_tops = array();
    $result = array();

    // Query for matching title or content
    $tops_to_find_1 = new WP_Query(array(
        'post_type' => 'tournoi',
        'posts_per_page' => -1,
        'ignore_sticky_posts' => true,
        'update_post_meta_cache' => false,
        'no_found_rows' => true,
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => array('private', 'whitelabel', 'onboarding'),
                'operator' => 'NOT IN'
            ),
        ),
        'meta_query' => array(
            array(
                'key' => 'validation_top',
                'value' => array('valide'),
                'compare' => 'IN',
            )
        ),
        's' => $recherche,
    ));

    while ($tops_to_find_1->have_posts()) : $tops_to_find_1->the_post();
        $list_result[] = get_the_ID();
    endwhile;

    // Query for matching meta fields
    $tops_to_find_2 = new WP_Query(array(
        'post_type' => 'tournoi',
        'posts_per_page' => -1,
        'ignore_sticky_posts' => true,
        'update_post_meta_cache' => false,
        'no_found_rows' => true,
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => array('private', 'whitelabel', 'onboarding'),
                'operator' => 'NOT IN'
            ),
        ),
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'relation' => 'OR',
                array(
                    'key' => 'question_t',
                    'value' => $recherche,
                    'compare' => 'LIKE',
                ),
                array(
                    'key' => 'precision_t',
                    'value' => $recherche,
                    'compare' => 'LIKE',
                ),
            ),
            array(
                'key' => 'validation_top',
                'value' => array('valide'),
                'compare' => 'IN',
            )
        ),
    ));

    while ($tops_to_find_2->have_posts()) : $tops_to_find_2->the_post();
        $list_result[] = get_the_ID();
    endwhile;

    // Query for contenders
    $contenders_to_find = new WP_Query(array(
        'post_type' => 'contender',
        'posts_per_page' => -1,
        'ignore_sticky_posts' => true,
        'update_post_meta_cache' => false,
        'no_found_rows' => true,
        's' => $recherche
    ));

    function is_top_valide($top_id) {
      $validation_top_value = get_field('validation_top', $top_id);
      if ($validation_top_value === 'valide') {
          return true;
      }
      return false;
    }

    while ($contenders_to_find->have_posts()) : $contenders_to_find->the_post();
        $top_id = get_field('id_tournoi_c', get_the_ID());
        if (is_top_valide($top_id) && !in_array($top_id, $list_result)) {
            $list_result[] = $top_id;
        }
    endwhile;

    $list_result_unique = array_unique($list_result);

    foreach ($list_result_unique as $id_top) {
        $info_top = get_top_infos($id_top, 'slim');
        if ($info_top["top_question"]) {
            $list_tops[] = $info_top;
        }
    }

    $result[] = array(
        'source' => 'Tops for ' . $recherche,
        'nb_result' => count($list_tops),
        'list_tops' => $list_tops
    );

    return $result;
}

function get_popular_top($data) {
  $limit          = $data['limit'];
  $uuid_user      = $data['uuid_user'];
  $list_tops      = array();
  $result         = array();
  $done_tops      = array();
  $list_popular_top = array();

  $url = get_base_api_url() . '/inventaire/get';
  $response = wp_remote_post($url, array(
    'body' => json_encode(array(
      'uuid_user' => $uuid_user
    )),
    'headers' => array(
      'Content-Type' => 'application/json'
    )
  ));
  if (is_wp_error($response)) {
    $error_message = $response->get_error_message();
    return "Something went wrong: $error_message";
  } else {
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);
    if (json_last_error() === JSON_ERROR_NONE) {
      if (isset($data->list_top_done)) {
        $done_tops = $data->list_top_done;
      } else {
        $done_tops = array();
      }
    }
  }

  $api_url = get_base_api_url() . '/popular-tops/10/20';
  $response = wp_remote_get($api_url);
  $popular_top_ids = [];
  if (!is_wp_error($response) && ($response['response']['code'] ?? 0) == 200) {
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
      $i=0; foreach ($data as $item) {
        if (isset($item['id_top_rank'])) {
          $popular_top_ids[] = $item['id_top_rank'];
          if($i==0){
            $top_id_most_popular = $item['id_top_rank'];
          }
        }
        $i++;
      }
    }
  }

  $list_popular_top = array_diff($popular_top_ids, $done_tops);

  $tops_popular     = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'tournoi',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => $limit,
    'post__in'               => $list_popular_top,
    'tax_query' => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
  ));
  if ($tops_popular->have_posts()) {

    while ($tops_popular->have_posts()) : $tops_popular->the_post();
      $info_top         = get_top_infos(get_the_ID(), 'slim');
      array_push($list_tops, $info_top);
    endwhile;
  }

  array_push($result, array(
    'top_id_most_popular' => $top_id_most_popular,
    'nb_result' => $tops_popular->post_count,
    'list_tops' => $list_tops
  ));

  return $result;
}

function get_vedette_top($data) {
  $limit          = $data['limit'];
  $id_cat         = $data['id_cat'];
  $list_tops      = array();
  $result         = array();
  if($data['id_cat'] == 56) {
    $acf_vedette_name = 'comics_tops_vedette';
  }
  elseif($data['id_cat'] == 6) {
    $acf_vedette_name = 'wtf_tops_vedette';
  }
  elseif($data['id_cat'] == 5) {
    $acf_vedette_name = 'ecran_tops_vedette';
  }
  elseif($data['id_cat'] == 10) {
    $acf_vedette_name = 'food_tops_vedette';
  }
  elseif($data['id_cat'] == 7) {
    $acf_vedette_name = 'jv_tops_vedette';
  }
  elseif($data['id_cat'] == 3) {
    $acf_vedette_name = 'manga_tops_vedette';
  }
  elseif($data['id_cat'] == 2) {
    $acf_vedette_name = 'musique_tops_vedette';
  }
  elseif($data['id_cat'] == 4) {  
    $acf_vedette_name = 'sport_tops_vedette';
  }
  $tops_vedette_cat_ids = get_field($acf_vedette_name, 'option');
  $tops_vedette     = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'tournoi',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => $limit,
    'post__in'               => $tops_vedette_cat_ids,
    'tax_query' => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
  ));
  if ($tops_vedette->have_posts()) {

    while ($tops_vedette->have_posts()) : $tops_vedette->the_post();
      $info_top         = get_top_infos(get_the_ID(), 'slim');
      array_push($list_tops, $info_top);
    endwhile;
  }
  
  return $list_tops;
}

function get_tops_of_a_creator($data) {
  $list_creator_tops        = array();
  $uuid_creator             = $data['uuid'];
  $total_votes_generated    = 0;
  $total_toplist_generated  = 0;
  $total_keurz_generated    = 0;
  $total_contenders         = 0;
  $nb_tops_published        = 0;

  $all_tops = new WP_Query(
    array(
      'post_type'      => 'tournoi',
      'posts_per_page' => -1,
      'post_status'    => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
      'orderby'        => 'date',
      'order'          => 'DESC',
      'meta_query' => array(
        array(
          'key'     => 'uuid_creator_t',
          'value'   => $uuid_creator,
          'compare' => '=',
        )
      )
    )
  );
  if ($all_tops->have_posts()) {

    while ($all_tops->have_posts()) : $all_tops->the_post();
      $nb_votes                 = 0;
      $nb_toplist               = 0;
      $id_top        = get_the_ID();
      $top_url       = get_the_permalink($id_top);
      $top_title     = get_the_title($id_top);
      $top_question  = get_field('question_t', $id_top);
      $top_number    = get_field('count_contenders_t', $id_top);
      $top_state     = get_field('validation_top', $id_top);
      if (get_field('visuel_externe_top_firebase', $id_top)) {
        $top_img_min   = get_field('visuel_externe_top_firebase', $id_top);
      } else {
        $top_img_min   = get_the_post_thumbnail_url($id_top, 'medium');
      }

      $id_toplistmondiale   = get_field('id_tm_t', $id_top);
      $url_toplist_mondiale = get_permalink($id_toplistmondiale);

      $top_cat       = get_the_terms($id_top, 'categorie');
      if ($top_cat) {
        foreach ($top_cat as $cat) {
          $top_cat_icon = get_field('icone_cat', 'term_' . $cat->term_id);
          $top_cat_url  = get_term_link($cat->term_id);
          $top_cat_name = $cat->name;
        }
      }

      $type_top         = array();
      $get_top_type     = get_the_terms($id_top, 'type');
      if ($get_top_type) {
        foreach ($get_top_type as $type_top) {
          $type_top = $type_top->slug;
        }
      }

      $nb_comments = get_comments_number($id_top);

      $url = get_base_api_url() . "/top/get";
      $response = wp_remote_post($url, array(
        'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
        'body' => array(
          'id_top' => $id_top,
        ),
      ));

      if($top_state == "valide"){
        $nb_tops_published++;
      }

      if (is_wp_error($response)) {
        $nb_votes = 'Error: ' . $response->get_error_message();
      } else {
        $body         = wp_remote_retrieve_body($response);
        $data         = json_decode($body);
        if($data->id != 0){
          $nb_votes                 = $data->nb_votes_resume;
          $nb_toplist               = $data->nb_tops_resume;
          $total_votes_generated    += $nb_votes;
          $total_toplist_generated  += $nb_toplist;
        }
        if($top_number){
          $total_contenders         += $top_number;
        }
      }
      array_push($list_creator_tops, array(
        'top_id'        => $id_top,
        'top_url'       => $top_url,
        'top_cat'       => $top_cat,
        'top_cat_name'  => $top_cat_name,
        'top_cat_url'   => $top_cat_url,
        'top_cat_icon'  => $top_cat_icon,
        'top_title'     => $top_title,
        'top_question'  => $top_question,
        'top_number'    => $top_number,
        'top_type'      => $type_top,
        'top_img_min'   => $top_img_min,
        'top_date'      => get_the_date('d/m/Y', $id_top),
        'top_state'     => $top_state,
        'url_tm'        => $url_toplist_mondiale,
        'nb_votes'      => $nb_votes,
        'nb_toplist'    => $nb_toplist,
        'nb_comments'   => $nb_comments
      ));
    endwhile;
    wp_reset_query();
  }

  $total_keurz_generated = round($total_votes_generated * 0.3) + $total_toplist_generated * 5 + $nb_tops_published * 1000;
  return array(
    'nb_creator_tops'           => $all_tops->post_count,
    'nb_tops_published'         => $nb_tops_published,
    'total_votes_generated'     => $total_votes_generated,
    'total_toplist_generated'   => $total_toplist_generated,
    'total_keurz_generated'     => $total_keurz_generated,
    'total_contenders'          => $total_contenders,
    'list_creator_tops'         => $list_creator_tops,
  );
}

function get_valide_tops_of_a_creator($data) {
  $list_creator_tops        = array();
  $uuid_creator             = $data['uuid'];
  $total_votes_generated    = 0;
  $total_toplist_generated  = 0;
  $total_keurz_generated    = 0;
  $total_contenders         = 0;
  $nb_tops_published        = 0;

  $all_tops = new WP_Query(
    array(
      'post_type'      => 'tournoi',
      'posts_per_page' => -1,
      'post_status'    => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
      'orderby'        => 'date',
      'order'          => 'DESC',
      'meta_query' => array(
        array(
          'key'     => 'uuid_creator_t',
          'value'   => $uuid_creator,
          'compare' => '=',
        )
      )
    )
  );
  if ($all_tops->have_posts()) {

    while ($all_tops->have_posts()) : $all_tops->the_post();
      $id_top        = get_the_ID();

      $top_state = get_field('validation_top', $id_top);
      if ($top_state != "valide") {
        continue;
      }
      $type_top         = array();
      $get_top_type     = get_the_terms($id_top, 'type');
      if ($get_top_type) {
        foreach ($get_top_type as $type_top) {
          $type_top = $type_top->slug;
        }
      }
      if($type_top == "private") {
        continue;
      }

      $nb_votes      = 0;
      $nb_toplist    = 0;
      $top_url       = get_the_permalink($id_top);
      $top_title     = get_the_title($id_top);
      $top_question  = get_field('question_t', $id_top);
      $top_number    = get_field('count_contenders_t', $id_top);
      if (get_field('visuel_externe_top_firebase', $id_top)) {
        $top_img_min   = get_field('visuel_externe_top_firebase', $id_top);
      } else {
        $top_img_min   = get_the_post_thumbnail_url($id_top, 'medium');
      }

      $id_toplistmondiale   = get_field('id_tm_t', $id_top);
      $url_toplist_mondiale = get_permalink($id_toplistmondiale);

      $top_cat       = get_the_terms($id_top, 'categorie');
      if ($top_cat) {
        foreach ($top_cat as $cat) {
          $top_cat_icon = get_field('icone_cat', 'term_' . $cat->term_id);
          $top_cat_url  = get_term_link($cat->term_id);
          $top_cat_name = $cat->name;
        }
      }

      $nb_comments = get_comments_number($id_top);

      $url = get_base_api_url() . "/top/get";
      $response = wp_remote_post($url, array(
        'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
        'body' => array(
          'id_top' => $id_top,
        ),
      ));

      if($top_state == "valide"){
        $nb_tops_published++;
      }

      if (is_wp_error($response)) {
        $nb_votes = 'Error: ' . $response->get_error_message();
      } else {
        $body         = wp_remote_retrieve_body($response);
        $data         = json_decode($body);
        if($data->id != 0){
          $nb_votes                 = $data->nb_votes_resume;
          $nb_toplist               = $data->nb_tops_resume;
          $total_votes_generated    += $nb_votes;
          $total_toplist_generated  += $nb_toplist;
        }
        if($top_number){
          $total_contenders         += $top_number;
        }
      }
      array_push($list_creator_tops, array(
        'top_id'        => $id_top,
        'top_url'       => $top_url,
        'top_cat'       => $top_cat,
        'top_cat_name'  => $top_cat_name,
        'top_cat_url'   => $top_cat_url,
        'top_cat_icon'  => $top_cat_icon,
        'top_title'     => $top_title,
        'top_question'  => $top_question,
        'top_number'    => $top_number,
        'top_type'      => $type_top,
        'top_img_min'   => $top_img_min,
        'top_date'      => get_the_date('d/m/Y', $id_top),
        'top_state'     => $top_state,
        'url_tm'        => $url_toplist_mondiale,
        'nb_votes'      => $nb_votes,
        'nb_toplist'    => $nb_toplist,
        'nb_comments'   => $nb_comments
      ));


    endwhile;
    wp_reset_query();
  }

  $total_keurz_generated = round($total_votes_generated * 0.3) + $total_toplist_generated * 5 + $nb_tops_published * 1000;
  return array(
    'nb_creator_tops'           => $all_tops->post_count,
    'nb_tops_published'         => $nb_tops_published,
    'total_votes_generated'     => $total_votes_generated,
    'total_toplist_generated'   => $total_toplist_generated,
    'total_keurz_generated'     => $total_keurz_generated,
    'total_contenders'          => $total_contenders,
    'list_creator_tops'         => $list_creator_tops,
  );
}

function get_tops_id_of_a_creator($data) {
  $list_creator_tops_ids     = array();
  $uuid_creator              = $data['uuid'];

  $all_tops = new WP_Query(
    array(
      'post_type'      => 'tournoi',
      'posts_per_page' => -1,
      'post_status'    => 'any',
      'orderby'        => 'date',
      'order'          => 'DESC',
      'meta_query' => array(
        'relation' => 'AND',
        array(
          'key'     => 'uuid_creator_t',
          'value'   => $uuid_creator,
          'compare' => '=',
        )
      )
    )
  );
  if ($all_tops->have_posts()) {

    while ($all_tops->have_posts()) : $all_tops->the_post();

      $id_top = get_the_ID();
      array_push($list_creator_tops_ids, $id_top);

    endwhile;
    wp_reset_query();
  }

  return $list_creator_tops_ids;
}

function get_creator_of_a_top($data) {
  $id_top = $data['id_top'];

  $creator_id   = get_post_field('post_author', $id_top);
  $creator_uuid = get_field('uuiduser_user', 'user_'.$creator_id);

  return array(
    'creator_id_wp' => $creator_id,
    'creator_uuid'  => $creator_uuid
  );
}

function process_firebase_img_url($original_url, $width) {
  if (is_string($original_url) && strpos($original_url, "https://firebasestorage.googleapis.com") === 0) {
      if (preg_match('/\/o\/([^?]+)\?alt=media&token=([^&]+)/', $original_url, $matches) && count($matches) === 3) {
          $filename = $matches[1];
          $token = $matches[2];
          $transformed_url = "https://api.vainkeurz.com/vkrz/firestoreimage?file=" . urlencode($filename) . "&_ecl=864000&token=" . urlencode($token) . "&width=" . $width;
          return $transformed_url;
      }
  }
  return $original_url;
}

function get_top_infos($id_top, $type = "complet", $cat_name = null, $cat_icon = null, $cat_url = null) {
  $top_datas     = array();
  $creator_infos = array();
  $top_cat       = "";
  $top_cat_name  = "";
  $top_cat_url   = "";
  $top_cat_icon  = "";
  $top_url       = "";
  $top_cat       = "";
  $top_cat_name  = "";
  $top_cat_url   = "";
  $top_cat_icon  = "";
  $top_title     = "";
  $top_question  = "";
  $top_precision = "";
  $top_number    = "";
  $type_top      = "";
  $status_top    = "";
  $top_img       = "";
  $top_img_min   = "";
  $top_cover     = "";
  $top_cover_acf = "";
  $display_titre = "";
  $rounded       = "";
  $c_in_cover    = "";
  $id_toplist_mondiale = "";
  $top_datas     = "";
  $uuid_creator  = "";
  $creator_infos = "";
  $was_sponso    = false;
  $is_sponso     = false;
  $is_twitch     = false;
  $is_active_sponso = false;
  $type_top_array = array();
  
  $top_url       = get_the_permalink($id_top);
  $top_title     = get_the_title($id_top);
  $top_question  = get_field('question_t', $id_top);
  $top_number     = get_field('count_contenders_t', $id_top);
  if (get_field('visuel_externe_top_firebase', $id_top)) {
    $top_img       = process_firebase_img_url(get_field('visuel_externe_top_firebase', $id_top), '');
    $top_img_min   = process_firebase_img_url(get_field('visuel_externe_top_firebase', $id_top), '');
  } else {
    $top_img       = get_the_post_thumbnail_url($id_top, 'large');
    $top_img_min   = get_the_post_thumbnail_url($id_top, 'medium');
  }

  if ($cat_name) {
    $top_cat_name = $cat_name;
    $top_cat_icon = $cat_icon;
    $top_cat_url  = $cat_url;
  } else {
    $top_cat       = get_the_terms($id_top, 'categorie');
    if ($top_cat) {
      foreach ($top_cat as $cat) {
        $top_cat_icon = get_field('icone_cat', 'term_' . $cat->term_id);
        $top_cat_url  = get_term_link($cat->term_id);
        $top_cat_name = $cat->name;
        $top_cat_id   = $cat->term_id;
      }
    }
  }

  $type_top         = "";
  $get_top_type     = get_the_terms($id_top, 'type');
  if ($get_top_type) {
    foreach ($get_top_type as $type_top) {
      $type_top_array[] = $type_top->slug;
      $type_top = $type_top->slug;
    }
  }
  if(in_array('sponso', $type_top_array)) {
    $is_sponso = true;
    if(in_array('private', $type_top_array)) {
      $is_active_sponso = false;
    }
    else{
      $is_active_sponso = true;
    }
  }
  if(in_array('twitch', $type_top_array)) {
    $is_twitch = true;
    $type_top = "classik";
  }

  $status_top         = "";
  $status_top         = get_field('validation_top', $id_top);

  if($type == "complet"){

    $display_titre        = get_field('ne_pas_afficher_les_titres_t', $id_top);
    $rounded              = get_field('c_rounded_t', $id_top);
    $c_in_cover           = get_field('visuel_cover_t', $id_top);
    $top_precision        = get_field('precision_t', $id_top);
    $top_cover            = wp_get_attachment_image_src(get_field('cover_t', $id_top), 'large');
    if ($top_cover) {
      $top_cover = $top_cover[0];
    } else {
      $id_visual_cat = get_field('visuel_par_defaut_cat', 'term_' . $top_cat_id);
      $top_cover     = wp_get_attachment_image_src($id_visual_cat, 'large');
      $top_cover     = $top_cover[0];
    }

    if (get_field('uuid_creator_t', $id_top)) {
      $uuid_creator   = get_field('uuid_creator_t', $id_top);
    }

    $endpoint = get_base_api_url() . '/user-list/get?uuid_user=' . $uuid_creator;
    $creator_infos  = file_get_contents($endpoint);

    $endpoint_top_data = get_base_api_url() . '/top/get';
    $data = array(
      'id_top' => $id_top
    );
    $options = array(
      'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($data)
      )
    );
    $context        = stream_context_create($options);
    $top_datas      = file_get_contents($endpoint_top_data, false, $context);
    if ($top_datas === false) {
      error_log("Échec de la requête.");
    }
  }

  $top_state                      = get_field('validation_top', $id_top);
  $id_toplistmondiale             = get_field('id_tm_t', $id_top);
  $url_toplist_mondiale           = get_permalink($id_toplistmondiale);
  $is_toplist_type_youtube_videos = get_field('is_toplist_type_youtube_videos', $id_top);
  $participation_inscription_fin  = get_field('participation_inscription_fin_t_sponso', $id_top);

  $result = array(
    'top_id'        => $id_top,
    'top_url'       => $top_url,
    'top_cat'       => $top_cat,
    'top_cat_name'  => $top_cat_name,
    'top_cat_url'   => $top_cat_url,
    'top_cat_icon'  => $top_cat_icon,
    'top_title'     => $top_title,
    'top_slug'      => sanitize_title($top_title),
    'top_question'  => $top_question,
    'top_precision' => $top_precision,
    'top_number'    => $top_number,
    'top_type'      => $type_top,
    'is_sponso'     => $is_sponso,
    'is_active_sponso' => $is_active_sponso,
    'is_twitch'     => $is_twitch,
    'is_toplist_type_youtube_videos' => $is_toplist_type_youtube_videos,
    'participation_inscription_fin'  => $participation_inscription_fin,
    'top_status'    => $status_top,
    'top_state'     => $top_state,
    'top_img'       => $top_img,
    'top_img_min'   => $top_img_min,
    'top_cover'     => $top_cover,
    'top_d_titre'   => $display_titre,
    'top_d_rounded' => $rounded,
    'top_d_cover'   => $c_in_cover,
    'top_date'      => get_the_date('d/m/Y', $id_top),
    'toplist_mondiale' => $url_toplist_mondiale,
    'top_datas'     => json_decode($top_datas),
    'uuid_creator'  => $uuid_creator,
    'creator_infos' => json_decode($creator_infos)
  );

  return $result;
}

function get_exclude_top() {
  $tops = new WP_Query(array(
    'post_type'              => 'tournoi',
    'posts_per_page'         => -1,
    'fields'                 => 'ids',
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'tax_query' => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('onboarding', 'whitelabel', 'private')
      ),
    ),
    'meta_query' => array(
      array(
        'key'     => 'validation_top',
        'value'   => array('valide'),
        'compare' => 'IN',
      )
    )
  ));

  return $tops->posts;
}

function get_state($state, $type_top) {

  $state_infos = array();

  if ($state == "done") {
    $state_infos['label'] = 'Terminé';
    $state_infos['bg'] = 'bg-success';
    $state_infos['wording'] = 'Voir ma Toplist';
  } elseif ($state == "begin") {
    $state_infos['label'] = 'En cours';
    $state_infos['bg'] = 'bg-warning';
    $state_infos['wording'] = 'Continuer ma TopList';
  } else {
    if ($type_top == "sponso") {
      $state_infos['label'] = 'À faire';
      $state_infos['bg'] = 'bg-primary';
      $state_infos['wording'] = 'Participer';
    } else {
      $state_infos['label'] = 'À faire';
      $state_infos['bg'] = 'bg-primary';
      $state_infos['wording'] = 'Faire ma TopList';
    }
  }

  return $state_infos;
}

function is_top_ok($id_top) {
  $top_state = get_field('validation_top', $id_top);
  $type_prevent = array('private', 'whitelabel', 'onboarding');
  $top_type  = get_the_terms($id_top, 'type');

  if($top_state == "valide" && !in_array($top_type[0]->slug, $type_prevent)){
    return true;
  } else {
    return false;
  }
}

function get_top_edition($data) {
  $id_top = $data['id_top'];

  $top_cat       = "";
  $top_url       = "";
  $top_cat       = "";
  $top_title     = "";
  $top_question  = "";
  $top_precision = "";
  $top_number    = "";
  $top_img       = "";
  $top_cat_id    = "";
  $is_toplist_type_youtube_videos = get_field('is_toplist_type_youtube_videos', $id_top);
  
  $top_url       = get_the_permalink($id_top);
  $top_title     = get_the_title($id_top);
  $top_question  = get_field('question_t', $id_top);
  $top_precision = get_field('precision_t', $id_top);
  $top_number    = get_field('count_contenders_t', $id_top);
  if (get_field('visuel_externe_top_firebase', $id_top)) {
    $top_img     = get_field('visuel_externe_top_firebase', $id_top);
  } else {
    $top_img     = get_the_post_thumbnail_url($id_top, 'large');
  }
  $top_cat       = get_the_terms($id_top, 'categorie');
  if ($top_cat) {
    foreach ($top_cat as $cat) {
      $top_cat_id = $cat->term_id;
    }
  }

  $type_top         = "";
  $get_top_type     = get_the_terms($id_top, 'type');
  if ($get_top_type) {
    foreach ($get_top_type as $type_top) {
      $type_top = $type_top->slug;
    }
  }

  $list_contenders  = array();

  $contenders = new WP_Query(
    array(
      'post_type'              => 'contender',
      'posts_per_page'         => -1,
      'ignore_sticky_posts'    => true,
      'update_post_meta_cache' => false,
      'orderby'                => 'title',
      'order'                  => 'ASC',  
      'no_found_rows'          => true,
      'meta_query' => array(
        array(
          'key'     => 'id_tournoi_c',
          'value'   => $id_top,
          'compare' => '=',
        ),
      ),
    )
  );
  while ($contenders->have_posts()) : $contenders->the_post();
    $cover = "";
    if (get_the_post_thumbnail_url(get_the_ID(), 'full')) {
      $cover = get_the_post_thumbnail_url(get_the_ID(), 'full');
    } elseif (get_field('visuel_instagram_contender', get_the_ID())) {
      $cover = get_field('visuel_instagram_contender', get_the_ID());
    } else {
      $cover = process_firebase_img_url(get_field('visuel_firebase_contender', get_the_ID()), '');
    }

    $id_wp = get_the_ID();

    $list_contenders[] = array(
      "id_wp"             => $id_wp,
      "c_name"            => get_the_title(),
      "cover"             => $cover,
      "embed"             => get_field('embed_contender', $id_wp),
    );
  endwhile;
  update_field('count_contenders_t', $contenders->post_count, $id_top);
  $contenders->reset_postdata();

  $top_cover_id  = get_field('cover_t', $id_top);
  $top_cover_url = wp_get_attachment_url($top_cover_id);

  $top_contenders_dimensions = false;
  if(get_field('top_contenders_dimensions', $id_top)) {
    $top_contenders_dimensions = get_field('top_contenders_dimensions', $id_top);
  }

  $result = array(
    'top_id'                         => $id_top,
    'top_url'                        => $top_url,
    'top_cat'                        => $top_cat,
    'top_cat_id'                     => $top_cat_id,
    'top_title'                      => $top_title,
    'top_slug'                       => sanitize_title($top_title),
    'top_question'                   => $top_question,
    'top_precision'                  => $top_precision,
    'top_number'                     => $top_number,
    'top_type'                       => $type_top,
    'top_img'                        => $top_img,
    'top_cover'                      => $top_cover_url,
    'list_contenders'                => $list_contenders,
    'top_contenders_dimensions'      => $top_contenders_dimensions,
    'is_toplist_type_youtube_videos' => $is_toplist_type_youtube_videos
  );

  return $result;
}

function get_category_icon($categoryName) {
  switch ($categoryName) {
      case 'Sport':
          return " 🏓 ";
      case 'Musique':
          return " 💿 ";
      case 'Jeux vidéo':
          return " 🕹️ ";
      case 'Food':
          return " 🥨 ";
      case 'Écran':
          return " 📺 ";
      case 'Comics':
          return " 🕸️ ";
      case 'Manga':
          return " 🐲 ";
      case 'Autres':
          return " ⚔️ ";
      default: 
          return " : ";
  }
}

function push_top_notification_email($id_top, $uuid_receiver, $uuid_sender, $notification_text, $notification_type) {
  if($uuid_receiver == $uuid_sender) return;

  $site_url = "";
  $api_url  = "";
  if (env() == "prod") {
    $site_url = "https://vainkeurz.com";
    $api_url  = "https://api.vainkeurz.com/vkrz";
  } elseif (env() == "proto") {
    $site_url = "https://proto.vainkeurz.com";
    $api_url  = "https://apislim.vainkeurz.com/vkrz";
  } else {
    $site_url = "http://localhost:8888/vkrz-wp";
    $api_url  = "http://localhost:8000/vkrz";
  }

  $top_datas   = get_top_infos($id_top, "complet");

  $endpoint = "$api_url/notification-list/create";
  $postData = array(
    'uuid_receiver'     => $uuid_receiver,
    'uuid_sender'       => $uuid_sender,
    'notification_text' => $notification_text,
    'notification_url'  => $top_datas['top_url'],
    'notification_type' => $notification_type,
    'toplist_name'      => 'TopList ' . $top_datas['top_number'] . get_category_icon($top_datas['top_cat_name']) . $top_datas['top_title'] . ' – ' . $top_datas['top_question']
  );
  $ch = curl_init($endpoint);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded',));
  $response = curl_exec($ch);
  curl_close($ch);
}

function delete_top($data) {
  $id_top           = $data['id_top'];
  $uuid_sender      = $data['uuid_user'];
  $uuid_receiver    = get_field('uuid_creator_t', $id_top);
  wp_delete_post($id_top);

  $contender_in_top = new WP_Query(array(
    'ignore_sticky_posts'	    => true,
    'update_post_meta_cache'  => false,
    'no_found_rows'		        => true,
    'post_type'			          => 'contender',
    'posts_per_page'		      => -1,
    'meta_query' => array(
      array(
        'key'     => 'id_tournoi_c',
        'value'   => $id_top,
        'compare' => '=',
    ),
  ),
  ));
  while ($contender_in_top->have_posts()) : $contender_in_top->the_post();
  
    $id_contender = get_the_ID();
    wp_delete_post($id_contender);
  
  endwhile; wp_reset_query();

  if(get_post($id_top)){
    return array(
      'success' => false,
      'message' => 'Une erreur est survenue lors de la suppression du Top'
    );
  }
  else {
    wp_schedule_single_event(time(), 'my_generate_json_data_hook');

    push_top_notification_email($id_top, $uuid_receiver, $uuid_sender, "", "CREA_TOP_SUPPRIME");

    return array(
      'success' => true,
      'message' => 'Le Top est les contenders ont bien été supprimés'
    );
  }
}

function valide_top($data) {
  $id_top           = $data['id_top'];
  $uuid_sender      = $data['uuid_user'];
  $uuid_receiver    = get_field('uuid_creator_t', $id_top);
  $discord_notified = get_field('discord_notified', $id_top);

  if (get_post($id_top)) { 
    update_field('validation_top', 'valide', $id_top); 
    wp_schedule_single_event(time(), 'my_generate_json_data_hook');

    if(!$discord_notified) {
      // PROCESS SEND TO DISCORD
      $top_datas   = get_top_infos($id_top, "complet");
      $cat_icon    = "";
      $cat_channel = "";
      $cat_tag_role = "";
      switch ($top_datas['top_cat_name']) {
        case 'Sport':
          $cat_icon = " 🏓 ";
          $cat_channel = "sport";
          $cat_tag_role = "<@&1163127673434951797>"; // SERVER ROLE ID
          break; 
        case 'Musique':
          $cat_icon = " 💿 ";
          $cat_channel = "musique";
          $cat_tag_role = "<@&1163127610428104775>";
          break;
        case 'Jeux vidéo':
          $cat_icon = " 🕹️ ";
          $cat_channel = "jv";
          $cat_tag_role = "<@&1163127501212614729>";
          break;
        case 'Food':
          $cat_icon = " 🥨 ";
          $cat_channel = "food";
          $cat_tag_role = "<@&1172887098932604979>";
          break;
        case 'Écran':
          $cat_icon = " 📺 ";
          $cat_channel = "ecran";
          $cat_tag_role = "<@&1163127572129910905>";
          break;
        case 'Comics':
          $cat_icon = " 🕸️ ";
          $cat_channel = "comics";
          $cat_tag_role = "<@&1163127641897971862>";
          break;
        case 'Manga':
          $cat_icon = " 🐲 ";
          $cat_channel = "manga";
          $cat_tag_role = "<@&1163127446778957924>";
          break;
        case 'Autres':
          $cat_icon = " ⚔️ ";
          $cat_channel = "autres";
          $cat_tag_role = "<@&1163127711691177994>";
          break;
    
        default: 
          $cat_icon = " : ";
      }

      $site_url = "";
      $api_url  = "";
      if (env() == "prod") {
        $site_url = "https://vainkeurz.com";
        $api_url  = "https://api.vainkeurz.com/vkrz";
      } elseif (env() == "proto") {
        $site_url = "https://proto.vainkeurz.com";
        $api_url  = "https://apislim.vainkeurz.com/vkrz";
      } else {
        $site_url = "http://localhost:8888/vkrz-wp";
        $api_url  = "http://localhost:8000/vkrz";
      }

      $embed = [
        'title'        => 'TOPLIST ' . $top_datas['top_number'] . $cat_icon . $top_datas['top_title'],
        'color'        => 0xB237F3,
        'description'  => $top_datas['top_question'],
        'timestamp'    => date(DATE_ATOM),
        'author'       => [
            'url'      => $site_url . '/v/' . $top_datas['creator_infos']->infos_user->pseudo_slug_user,
            'icon_url' => !empty($top_datas['creator_infos']->infos_user->avatar_user) ? 
                          $top_datas['creator_infos']->infos_user->avatar_user : 
                          'https://vainkeurz.com/wp-content/uploads/2023/09/avatar-rose.webp',
            'name'     => $top_datas['creator_infos']->infos_user->pseudo_user,
        ],
        'url'          => $top_datas['top_url'],
        'image'        => ['url' => $top_datas['top_img']],
      ];
      $messageToSend = [
          'content'    => "$cat_tag_role",
          'username'   => "NOTEURZ 🤖",
          'avatar_url' => 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
          'embeds'     => [$embed],
      ];

      $webhook = "top-valide-$cat_channel";

      $endpoint = "$api_url/send-message-discord";
      $postData = array(
          'webhook'     => $webhook,
          'messageData' => $messageToSend
      );
      $ch = curl_init($endpoint);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded',));

      $post_taxonomies = array();
      foreach (get_the_terms($id_top, 'type') as $tax) {
        array_push($post_taxonomies, $tax->name);
      }
      if (!in_array("Private", $post_taxonomies)) {
        $response = curl_exec($ch);
        update_field('discord_notified', true, $id_top);
        curl_close($ch);
      } else {
        $curlSendPrivateIdTopList = curl_init();
        $id_top = (int)$id_top;
        $dataSendPrivateIdTopList = json_encode(['id_top' => $id_top], JSON_NUMERIC_CHECK);
        curl_setopt_array($curlSendPrivateIdTopList, array(
            CURLOPT_URL => "$api_url/add-private-toplist-id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $dataSendPrivateIdTopList,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $responseSendPrivateIdTopList = curl_exec($curlSendPrivateIdTopList);
        curl_close($curlSendPrivateIdTopList);
      }

      push_top_notification_email($id_top, $uuid_receiver, $uuid_sender, "", "CREA_TOP_VALIDE");

      // CHANGE USER ROLE TO 2 CREATOR IF IT'S FIRST TOPLIST VALIDE PUBLISHED
      $endpoint = "$api_url/user-list/upgrade-role-to-2";
      $postData = array( 'uuid_user' => $uuid_receiver );
      $ch = curl_init($endpoint);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded',));
      $response = curl_exec($ch);
      curl_close($ch);
    }

    return array(
      'success' => true,
      'message' => 'Le Top est maintenant actif'
    );
  }
  else{
    return array(
      'success' => false,
      'message' => 'Une erreur est survenue lors de la validation du Top'
    );
  }
}

function refuse_top($data) {
  $id_top           = $data['id_top'];
  $uuid_sender      = $data['uuid_user'];
  $uuid_receiver    = get_field('uuid_creator_t', $id_top);

  if(get_post($id_top)){
    update_field('validation_top', 'refuse', $id_top); 
    wp_schedule_single_event(time(), 'my_generate_json_data_hook');

    push_top_notification_email($id_top, $uuid_receiver, $uuid_sender, "", "CREA_TOP_REFUSE");

    return array(
      'success' => true,
      'message' => 'Le Top est bien refusé'
    );
  }
  else{
    return array(
      'success' => false,
      'message' => 'Une erreur est survenue lors du refus du Top'
    );
  }
}

function archive_top($data) {
  $id_top           = $data['id_top'];
  $uuid_sender      = $data['uuid_user'];
  $uuid_receiver    = get_field('uuid_creator_t', $id_top);
  update_field('validation_top', 'archive', $id_top); 

  if(get_post($id_top)){
    wp_schedule_single_event(time(), 'my_generate_json_data_hook');

    push_top_notification_email($id_top, $uuid_receiver, $uuid_sender, "", "CREA_TOP_ARCHIVE");
    
    return array(
      'success' => true,
      'message' => 'Le Top est bien archivé'
    );
  }
  else{
    return array(
      'success' => false,
      'message' => 'Une erreur est survenue lors de l\'archivage du Top'
    );
  }
}

function validation_top($data) {
  $id_top           = $data['id_top'];
  $uuid_sender      = $data['uuid_user'];
  $uuid_receiver    = get_field('uuid_creator_t', $id_top);
  $current_value    = get_field('validation_top', $id_top);

  if(get_post($id_top) && $current_value != "validation"){
    update_field('validation_top', 'validation', $id_top); 
    wp_schedule_single_event(time(), 'my_generate_json_data_hook');

    // PROCESS SEND TO DISCORD
    $top_datas = get_top_infos($id_top, "complet");
    $cat_icon  = get_category_icon($top_datas['top_cat_name']);

    $site_url = "";
    $api_url = "";
    if (env() == "prod") {
      $site_url = "https://vainkeurz.com";
      $api_url  = "https://api.vainkeurz.com/vkrz";
    } elseif (env() == "proto") {
      $site_url = "https://proto.vainkeurz.com";
      $api_url  = "https://apislim.vainkeurz.com/vkrz";
    } else {
      $site_url = "http://localhost:8888/vkrz-wp";
      $api_url  = "http://localhost:8000/vkrz";
    }

    $embed = [
      'title'        => 'TOPLIST ' . $top_datas['top_number'] . $cat_icon . $top_datas['top_title'],
      'color'        => 0xB237F3,
      'description'  => $top_datas['top_question'],
      'timestamp'    => date(DATE_ATOM),
      'author'       => [
          'url'      => $site_url . '/v/' . $top_datas['creator_infos']->infos_user->pseudo_slug_user,
          'icon_url' => !empty($top_datas['creator_infos']->infos_user->avatar_user) ? 
                        $top_datas['creator_infos']->infos_user->avatar_user : 
                        'https://vainkeurz.com/wp-content/uploads/2023/09/avatar-rose.webp',
          'name'     => $top_datas['creator_infos']->infos_user->pseudo_user,
      ],
      'url'          => $top_datas['top_url'],
      'image'        => ['url' => $top_datas['top_img']],
    ];
    $messageToSend = [
        'content'    => 'Peux-tu valider cette TopList <@!601436674211446786> stp :)', // ID IS FOR Mamapilote
        'username'   => "NOTEURZ 🤖",
        'avatar_url' => 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
        'embeds'     => [$embed],
    ];

    $endpoint = "$api_url/send-message-discord";
    $postData = array(
        'webhook'     => 'top-validation',
        'messageData' => $messageToSend
    );
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded',
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    return array(
      'success'          => true,
      'message'          => 'Le Top est maintenant en validation',
      'top_datas'        => $top_datas,
      'cURL RESPONSE : ' => $response
    );
  }
  else{
    return array(
      'success' => false,
      'message' => 'Une erreur est survenue lors de la demande de validation du Top'
    );
  }
}

function get_creator_info($uuid_creator) {
    $endpoint = get_base_api_url() . "/user-list/getpublicbyuuid/" . $uuid_creator;
    $creator_infos = file_get_contents($endpoint);
    if ($creator_infos === false) {
        // Handle the error appropriately
        return null;
    }
    return json_decode($creator_infos, true); // Returning as an associative array
}

function get_top_details($id_top) {
    $top_details = [
        'top_id'        => $id_top,
        'top_url'       => get_the_permalink($id_top),
        'top_title'     => get_the_title($id_top),
        'top_question'  => get_field('question_t', $id_top),
        'top_number'    => get_field('count_contenders_t', $id_top),
        'top_status'    => get_post_status($id_top),
        'top_state'     => get_field('validation_top', $id_top),
        'top_date'      => get_the_date('d/m/Y', $id_top),
    ];

    // Handling the category and image
    $top_cat = get_the_terms($id_top, 'categorie');
    if ($top_cat && !empty($top_cat)) {
        $cat = end($top_cat); // Assuming you need the last category
        $top_details['top_cat_name'] = $cat->name;
        $top_details['top_cat_icon'] = get_field('icone_cat', 'term_' . $cat->term_id);
    }

    // Handling the type of top
    $get_top_type = get_the_terms($id_top, 'type');
    if ($get_top_type && !empty($get_top_type)) {
        $type = end($get_top_type); // Assuming you need the last type
        $top_details['top_type'] = $type->slug;
    }

    // Handling the image
    $top_details['top_img_min'] = get_field('visuel_externe_top_firebase', $id_top) ?: get_the_post_thumbnail_url($id_top, 'medium');

    return $top_details;
}

function get_uuid_creator($id_top) {
    $uuid_creator = get_field('uuid_creator_t', $id_top);
    if (!$uuid_creator) {
        $creator_id = get_post_field("post_author", $id_top);
        $uuid_creator = get_field('uuiduser_user', 'user_' . $creator_id);
        update_field('uuid_creator_t', $uuid_creator, $id_top);
    }
    return $uuid_creator;
}

function get_all_top($data) {
    $state = $data['state'];
    $state_array = in_array($state, ['validation', 'valide', 'creation', 'refuse', 'archive']) ? [$state] : ['valide', 'validation', 'creation', 'refuse', 'archive'];

    $list_creator_tops = [];
    $creator_info_cache = [];

    $all_tops = new WP_Query([
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'post_type'              => 'tournoi',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'posts_per_page'         => -1,
        'post_status'            => 'any',
        'meta_query'             => [
            [
                'key'     => 'validation_top',
                'value'   => $state_array,
                'compare' => 'IN',
            ],
        ],
    ]);

    if ($all_tops->have_posts()) {
        while ($all_tops->have_posts()) {
            $all_tops->the_post();
            $id_top = get_the_ID();
            $top_details = [];
            $top_details = get_top_details($id_top);

            if($state != "valide"){
              $uuid_creator = get_uuid_creator($id_top);
              if (!isset($creator_info_cache[$uuid_creator])) {
                  $creator_info_cache[$uuid_creator] = get_creator_info($uuid_creator);
              }
              $top_details['creator_infos'] = $creator_info_cache[$uuid_creator];
            }
            array_push($list_creator_tops, $top_details);
        }
        wp_reset_query();
    }

    return [
        'state' => $state,
        'nb_creator_tops' => count($list_creator_tops),
        'list_creator_tops' => $list_creator_tops
    ];
}

function get_tops_data() {
  global $wpdb;

  // ACF values for the 'validation_top' field
  $acf_values   = array('valide', 'validation', 'creation', 'refuse', 'archive');
  $types        = array('sponso', 'classik', 'private');
  $data         = array();

  // Get counts based on ACF values
  foreach ($acf_values as $value) {
    $data["top_{$value}"] = (int) $wpdb->get_var($wpdb->prepare("
            SELECT COUNT(*)
            FROM $wpdb->posts
            LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id)
            WHERE $wpdb->posts.post_type = 'tournoi'
              AND $wpdb->postmeta.meta_key = 'validation_top'
              AND $wpdb->postmeta.meta_value = %s
        ", $value));
  }

  // Get counts based on custom taxonomy "type"
  foreach ($types as $type) {
    $data["top_{$type}"] = (int) $wpdb->get_var($wpdb->prepare("
            SELECT COUNT(*)
            FROM $wpdb->posts
            LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
            LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
            LEFT JOIN $wpdb->terms ON($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
            WHERE $wpdb->posts.post_type = 'tournoi'
              AND $wpdb->term_taxonomy.taxonomy = 'type'
              AND $wpdb->terms.slug = %s
        ", $type));
  }

  return $data;
}

function get_top_step($id_top) {
  $type_top         = "";
  $status_top       = "";
  $get_top_type     = get_the_terms($id_top, 'type');
  if ($get_top_type) {
    foreach ($get_top_type as $type_top) {
      $type_top = $type_top->slug;
    }
  }
  $status_top         = get_field('validation_top', $id_top);

  return array(
    'type_top'    => $type_top,
    'status_top'  => $status_top
  );
}

function clean_number_top() {
  $posts_per_page = 100;
  $paged = 1;

  while (true) {
    $all_tops = new WP_Query(array(
      'ignore_sticky_posts'    => true,
      'update_post_meta_cache' => false,
      'no_found_rows'          => true,
      'post_type'              => 'tournoi',
      'orderby'                => 'date',
      'order'                  => 'DESC',
      'posts_per_page'         => $posts_per_page,
      'paged'                  => $paged
    ));

    if (!$all_tops->have_posts()) {
      break;
    }

    while ($all_tops->have_posts()) : $all_tops->the_post();
      update_count_contenders(get_the_id());
    endwhile;

    $paged++;
  }
}

function get_contenders_ranking_from_wp($data){

  $top_id = $data['id_top'];
  $contenders_ranking = array();
  $contenders = new WP_Query(array(
    'post_type'         => 'contender',
    'posts_per_page'    => '-1',
    'meta_query'        => array(
      array(
        'key'     => 'id_tournoi_c',
        'value'   => $top_id,
        'compare' => '=',
      )
    )
  ));

  if ($contenders->have_posts()) {
    foreach ($contenders->posts as $contender) {
      $id_contender = $contender->ID;
      $elo_c        = get_contender_elo($id_contender);

      $cover = "";
      if (get_the_post_thumbnail_url($id_contender, 'medium')) {
        $cover = get_the_post_thumbnail_url($id_contender, 'medium');
      } elseif (get_field('visuel_instagram_contender', $id_contender)) {
        $cover = get_field('visuel_instagram_contender', $id_contender);
      } else {
        $cover = process_firebase_img_url(get_field('visuel_firebase_contender', $id_contender), '300x300');
      }

      $contenders_ranking[] = array(
        "id"            => $id_contender,
        "cover"         => $cover,
        "name"          => get_the_title($id_contender),
        "elo"           => $elo_c
      );
    }
  }

  // Sort contenders by ELO
  usort($contenders_ranking, function ($a, $b) {
    return $b['elo'] <=> $a['elo'];
  });

  return $contenders_ranking;
}

function get_tops_of_a_sub_cat($data) {
    $limit = $data['limit'];
    $id_cat = isset($data['id_cat']) ? $data['id_cat'] : null;
    $list_tops = array();

    // Prepare the query arguments
    $query_args = array(
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'post_type'              => 'tournoi',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'posts_per_page'         => $limit,
        'meta_query' => array(
            array(
                'key'     => 'validation_top',
                'value'   => array('valide'),
                'compare' => 'IN',
            )
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field'    => 'slug',
                'terms'    => array('private', 'whitelabel'),
                'operator' => 'NOT IN'
            ),
            array(
                'taxonomy' => 'sous-cat',
                'field'    => 'term_id',
                'terms'    => $id_cat
            )
        ),
    );

    $tops_in_cat = new WP_Query($query_args);

    if ($tops_in_cat->have_posts()) {
        while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post();
          $info_top = get_top_infos(get_the_ID(), 'slim');
          array_push($list_tops, $info_top);
        endwhile;
    }

    return $list_tops;
}

function get_all_tops_from_vedette() {

  $list_toplist_ids = get_field('liste_des_toplist_les_plus_jouees', get_page_by_path('convention'));
  $list_tops = array();
  $tops = new WP_Query(array(
    'post_type' => 'tournoi',
    'posts_per_page' => '-1',
    'post__in' => $list_toplist_ids,
  ));

  if ($tops->have_posts()) {
    while ($tops->have_posts()) : $tops->the_post();
      $info_top = get_top_infos(get_the_ID(), 'slim');
      array_push($list_tops, $info_top);
    endwhile;
  }

  return $list_tops;
}