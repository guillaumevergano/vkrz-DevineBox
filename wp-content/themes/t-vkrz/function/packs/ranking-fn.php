<?php
function get_ranking_for_banner(WP_REST_Request $request)
{
  $list_id_contender  = explode(',', $request->get_param('list_id_contender'));
  $id_top             = $request->get_param('id_top_rank');
  $top_title          = get_the_title($id_top);
  $top_question       = get_field('question_t', $id_top);
  $thumbnail = '';

  $top_cat   = get_the_terms($id_top, 'categorie');
  if ($top_cat) { foreach ($top_cat as $cat) { 
    $top_cat_id   = $cat->term_id;
    $top_cat_name = $cat->name;  
  } }
  $top_cover = wp_get_attachment_image_src(get_field('cover_t', $id_top), 'large');
  if ($top_cover) {
    $top_cover = $top_cover[0];
  } else {
    $id_visual_cat = get_field('visuel_par_defaut_cat', 'term_' . $top_cat_id);
    $top_cover     = wp_get_attachment_image_src($id_visual_cat, 'large');
    $top_cover     = $top_cover[0];
  }
  if (env() == "local") {
    $top_cover = str_replace("http://localhost:8888/vkrz-wp/", "https://vainkeurz.com/", $top_cover);
  }
  switch ($top_cat_name) {
    case 'Sport':
      $cat_icon = "🏓";
      break; 
    case 'Musique':
      $cat_icon = "💿";
      break;
    case 'Jeux vidéo':
      $cat_icon = "🕹️";
      break;
    case 'Food':
      $cat_icon = "🥨";
      break;
    case 'Écran':
      $cat_icon = "📺";
      break;
    case 'Comics':
      $cat_icon = "🕸️";
      break;
    case 'Manga':
      $cat_icon = "🐲";
      break;
    case 'Autres':
      $cat_icon = "⚔️";
      break;

    default: 
      $cat_icon = "⚔️";
  }

  $info_contenders = [];

  $the_query = new WP_Query(array(
    'ignore_sticky_posts'     => true,
    'update_post_meta_cache'  => false,
    'no_found_rows'           => true,
    'post__in'                => $list_id_contender,
    'orderby'                 => 'post__in',
    'post_type'               => 'contender',
  ));

  if ($the_query->have_posts()) {
    $i=1; while ($the_query->have_posts()) : $the_query->the_post();
      if (get_field('visuel_instagram_contender')) {
        $thumbnail = get_field('visuel_instagram_contender');
      } else if (get_field('visuel_firebase_contender')) {
        $thumbnail = process_firebase_img_url(get_field('visuel_firebase_contender'), '');
      } else {
        $thumbnail = get_the_post_thumbnail_url();
        if (env() == "local") {
          $thumbnail = str_replace("http://localhost:8888/vkrz-wp/", "https://vainkeurz.com/", $thumbnail);
        }
      }

      array_push($info_contenders, array(
        'num'         => $i,
        'title'       => get_the_title(),
        'thumbnail'   => $thumbnail,
      ));
    $i++; endwhile;
    return array(
      "top_title"          => $top_title,
      "top_question"       => $top_question,
      'top_background'     => $top_cover,
      'top_category_emoji' => $cat_icon,
      "list_contenders"    => $info_contenders,
    );
  } else {
    return 'Aucun contender trouvé';
  }
}

function get_ranking_of_top($data) {
    
    if (is_array($data)) {
        $id_top = $data['id_top'];
        $orderby = $data['orderby'] ?? 'elo';
    } elseif (is_object($data) && method_exists($data, 'get_param')) {
        $id_top = $data->get_param('id_top');
        $orderby = $data->get_param('orderby') ?? 'elo';
    } elseif (is_string($data)) {
        $id_top = $data;
        $orderby = 'elo';
    } else {
        throw new InvalidArgumentException('Invalid data format provided to get_ranking_of_top.');
    }

    $list_contenders  = array();

    $contenders = new WP_Query(
        array(
            'post_type'      => 'contender',
            'posts_per_page' => -1,
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => true,
            'orderby'                => $orderby,
            'order'                  => 'ASC',
            'meta_query'     => array(
                array(
                    'key'     => 'id_tournoi_c',
                    'value'   => $id_top,
                    'compare' => '=',
                )
            )
        )
    );

    $i = 0;
    while ($contenders->have_posts()) : $contenders->the_post();

        $cover = "";
        if (get_the_post_thumbnail_url(get_the_ID(), 'full')) {
            $cover = get_the_post_thumbnail_url(get_the_ID(), 'full');
        } elseif (get_field('visuel_instagram_contender', get_the_ID())) {
            $cover = get_field('visuel_instagram_contender', get_the_ID());
        } else {
            $cover = process_firebase_img_url(get_field('visuel_firebase_contender', get_the_ID()), '');
        }
        $embed = "";
        if (get_field('embed_contender', get_the_ID())) {
          $embed = get_field('embed_contender', get_the_ID());
        } 

        $id_wp = get_the_ID();

        // Fetch ELO from SlimPHP API
        $elo_c = get_contender_elo($id_wp);

        $list_contenders[] = array(
            "id"                => $i,
            "id_wp"             => $id_wp,
            "elo"               => $elo_c,
            "c_name"            => get_the_title(),
            "cover"             => $cover,
            "embed"             => $embed,
            "more_to"           => array(),
            "less_to"           => array(),
            "place"             => 0,
            "ratio"             => 0,
        );

        $i++;
    endwhile;

    // Sort contenders by ELO
    if ($orderby != 'title') {
        usort($list_contenders, function ($a, $b) {
            return $b['elo'] <=> $a['elo'];
        });
    }

    $ranking = array(
        'id_top'    => $id_top,
        'ranking'   => $list_contenders,
    );

    return $ranking;
}