<?php if (is_single() && get_post_type() == "tournoi") :
  global $id_top;
  global $top_infos;
  global $top_title_question;
  $id_top             = get_the_ID();
  $top_infos          = get_top_infos($id_top);
  $top_title_question = $top_infos['top_title'] . " " . $top_infos['top_question'];
?>

  <title>
    TopList <?php echo $top_title_question; ?>
  </title>
  <meta name="description" content="<?php echo $top_title_question; ?>" />
  <link rel="canonical" href="<?php echo $top_infos['top_url']; ?>" />
  <meta property="og:image" content="<?php echo $top_infos['top_img']; ?>" />
  <meta property="og:title" content="TopList <?php echo $top_infos['top_title']; ?>" />
  <meta property="og:description" content="<?php echo $top_infos['top_question']; ?>" />
  <meta property="og:url" content="<?php echo $top_infos['top_url']; ?>" />
  <meta name="twitter:title" content="TopList <?php echo $top_infos['top_title']; ?>" />
  <meta name="twitter:description" content="<?php echo $top_infos['top_question']; ?>" />
  <meta name="twitter:image" content="<?php echo $top_infos['top_img']; ?>" />
  

<?php elseif (get_query_var('toplist_id')) :

  global $top_infos;
  global $id_top;
  global $id_toplist;
  global $banner_url;
  global $currentTopListUrl;
  $id_toplist    = get_query_var('toplist_id');
  $endpointmeta  = get_base_api_url() . "/toplist/getmeta/{$id_toplist}";
  $response      = wp_remote_get($endpointmeta);
  $banner_url    = "";
  if (!is_wp_error($response)) {
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    $id_top = $data["id_top_rank"];
    if(isset($data["banner"]) && $data["banner"] != ""){
      $banner_url  = get_bloginfo('url') . "/wp-content/uploads/banner/" . $data["banner"];
    }
  }
  $top_infos          = get_top_infos($id_top, 'simple"');
  $top_title_question = $top_infos['top_title'] . " " . $top_infos['top_question'];
  $currentTopListUrl  = get_bloginfo('url') . "/toplist/" . $top_infos['top_slug'] . "/" . $id_toplist;
?>
  <title>
    TopList <?php echo $top_title_question; ?>
  </title>
  <meta name="description" content="Guette ma TopList à propos de <?php echo $top_infos['top_title']; ?>" />
  <link rel="canonical" href="<?php echo $currentTopListUrl; ?>" />
  <meta property="og:title" content="TopList <?php echo $top_infos['top_title']; ?> <?php echo $top_infos['top_question']; ?>" />
  <meta property="og:description" content="Voici ma TopList, j'attends la tienne !" />
  <meta property="og:url" content="<?php echo $currentTopListUrl; ?>" />
  <meta property="og:image" content="<?php echo $banner_url; ?>" />
  <meta name="twitter:title" content="TopList <?php echo $top_infos['top_title']; ?> <?php echo $top_infos['top_question']; ?>" />
  <meta name="twitter:description" content="Voici ma TopList, j'attends la tienne !" />
  <meta name="twitter:image" content="<?php echo $banner_url; ?>" />

<?php elseif (get_query_var('toplist_devine_id')) :

  global $top_infos;
  global $id_top;
  global $id_toplist;
  $id_toplist    = get_query_var('toplist_devine_id');
  $endpointmeta  = get_base_api_url() . "/devine/getdata/{$id_toplist}";
  $response      = wp_remote_get($endpointmeta);
  if (!is_wp_error($response)) {
    $body         = wp_remote_retrieve_body($response);
    $data         = json_decode($body, true);
    $id_top       = $data["id_top"];
  }
  $top_infos          = get_top_infos($id_top, 'simple');
  $top_title_question = $top_infos['top_title'] . " " . $top_infos['top_question'];
?>
  <title>
    Devinez mes choix dans cette TopList <?php echo $top_title_question; ?>
  </title>
  <meta name="description" content="Devine chacun de mes choix" />
  <link rel="canonical" href="" />
  <meta property="og:title" content="Devine chacun de mes choix" />
  <meta property="og:description" content="<?php echo $top_infos['top_title']; ?>" />
  <meta property="og:url" content="" />
  <meta property="og:image" content="<?php echo $top_infos['top_img']; ?>" />
  <meta name="twitter:title" content="Devine chacun de mes choix" />
  <meta name="twitter:description" content="<?php echo $top_infos['top_title']; ?>" />
  <meta name="twitter:image" content="<?php echo $top_infos['top_img']; ?>" />

<?php elseif (is_single() && get_post_type() == "toplist-mondiale") :

  global $id_top;
  global $top_infos;
  global $top_title_question;
  $id_top = get_field('id_du_top_tm');
  $top_infos = get_top_infos($id_top);
  $top_title_question = $top_infos['top_title'] . " " . $top_infos['top_question'];
?>

  <title>
    TopList Mondiale <?php echo $top_title_question; ?>
  </title>
  <meta name="description" content="<?php echo $top_title_question; ?>" />
  <meta property="og:image" content="<?php echo $top_infos['top_img']; ?>" />
  <meta property="og:title" content="TopList mondiale <?php echo $top_infos['top_title']; ?>" />
  <meta property="og:description" content="<?php echo $top_infos['top_question']; ?>" />
  <meta property="og:url" content="<?php echo $top_infos['top_url']; ?>" />
  <meta name="twitter:title" content="TopList mondiale <?php echo $top_infos['top_title']; ?>" />
  <meta name="twitter:description" content="<?php echo $top_infos['top_question']; ?>" />
  <meta name="twitter:image" content="<?php echo $top_infos['top_img']; ?>" />

<?php elseif (is_archive()) :

  global $current_cat;
  global $cat_name;
  global $cat_id;
  $current_cat = get_queried_object();
  $cat_name    = $current_cat->name;
  $cat_id      = $current_cat->term_id;
?>
  <title>
    Toutes les TopList <?php echo $cat_name; ?> sur VAINKEURZ 🦙
  </title>
  <meta name="description" content="<?php echo $current_cat->description; ?>" />

<?php elseif (is_archive()) :

  global $current_cat;
  global $cat_name;
  global $cat_id;
  $current_cat = get_queried_object();
  $cat_name    = $current_cat->name;
  $cat_id      = $current_cat->term_id;
?>
  <title>
    Toutes les TopList <?php echo $cat_name; ?> sur VAINKEURZ 🦙
  </title>
  <meta name="description" content="<?php echo $current_cat->description; ?>" />

<?php elseif (get_query_var('v_user')) :
  $user_pseudo = get_query_var('v_user');
?>
  <title>
    Profil de <?php echo $user_pseudo; ?> sur VAINKEURZ 🦙
  </title>
  <meta name="description" content="Tous les Tops de <?php echo $user_pseudo; ?> et ses stats." />
  <meta property="og:title" content="Profil VAINKEURZ de <?php echo $user_pseudo; ?>" />
  <meta property="og:description" content="Tous les Tops de <?php echo $user_pseudo; ?> et ses stats." />
  <meta property="og:url" content="<?php echo get_author_posts_url($id_membre); ?>" />
  <meta name="twitter:title" content="Profil VAINKEURZ de <?php echo $user_pseudo; ?>" />
  <meta name="twitter:description" content="Tous les Tops de <?php echo $user_pseudo; ?> et ses stats." />

<?php elseif (get_query_var('v_user_2')) :
  $user_pseudo = get_query_var('v_user_2');
?>
  <title>
    Toutes les TopList de <?php echo $user_pseudo; ?> sur VAINKEURZ 🦙
  </title>
  <meta name="description" content="Toutes les TopList de <?php echo $user_pseudo; ?>" />
  <meta property="og:title" content="Toutes les TopList de <?php echo $user_pseudo; ?>" />
  <meta property="og:description" content="Toutes les TopList de <?php echo $user_pseudo; ?>" />
  <meta property="og:url" content="<?php echo get_author_posts_url($id_membre); ?>" />
  <meta name="twitter:title" content="Toutes les TopList de <?php echo $user_pseudo; ?>" />
  <meta name="twitter:description" content="Toutes les TopList de <?php echo $user_pseudo; ?>" />

<?php elseif (get_query_var('contender_slug')) :

  global $contender_id;
  $currentUrl = getCurrentUrl();
  $contender_slug    = get_query_var('contender_slug');
  if ($contender_slug) {
    $contender_id = get_contender_seo($contender_slug);
  }
  
?>
  <title>
    Les statistiques de <?php echo get_the_title($contender_id); ?> dans les TopList de VAINKEURZ 🦙
  </title>
  <meta name="description" content="Toutes les statistiques de <?php echo get_the_title($contender_id); ?> dans les TopList de sur VAINKEURZ 🦙" />
  <link rel="canonical" href="<?php echo $currentUrl; ?>" />
  <meta property="og:title" content="Toutes les statistiques de <?php echo get_the_title($contender_id); ?> dans les TopList de sur VAINKEURZ 🦙" />
  <meta property="og:description" content="Présentation de <?php echo get_the_title($contender_id); ?> et affichage des statistiques de ces duels sur VAINKEURZ. Liste des Tops auxquels <?php echo get_the_title($contender_id); ?> participe." />
  <meta property="og:url" content="<?php echo $currentUrl; ?>" />
  <meta property="og:image" content="<?php echo $contender_data['thumbnail']; ?>" />
  <meta name="twitter:title" content="Toutes les statistiques de <?php echo get_the_title($contender_id); ?> dans les TopList de sur VAINKEURZ 🦙" />
  <meta name="twitter:description" content="Présentation de <?php echo get_the_title($contender_id); ?> et affichage des statistiques de ces duels sur VAINKEURZ. Liste des Tops auxquels <?php echo get_the_title($contender_id); ?> participe." />
  <meta name="twitter:image" content="<?php echo $contender_data['thumbnail']; ?>" />

<?php elseif (is_page() || get_post_type() === "post") : ?>

  <title><?php echo (get_field('titre_seo')) ? the_field('titre_seo') : the_title(); ?></title>
  <meta name="description" content="<?php echo (get_field('description_seo')) ? the_field('description_seo') : the_title(); ?>" />

<?php else : ?>

  <title>
    TopList by VAINKEURZ 🦙💜
  </title>
  <meta name="description" content="Meilleur site de la galaxie d'après la NASA pour faire ses TopList." />
  <meta property="og:image" content="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/share/share_vkrz_banner.jpg" />
  <meta property="og:title" content="TopList by VAINKEURZ 🦙💜" />
  <meta property="og:description" content="Meilleur site de la galaxie d'après la NASA pour faire ses TopList." />
  <meta property="og:url" content="https://vainkeurz.com/" />
  <meta name="twitter:title" content="TopList by VAINKEURZ 🦙💜" />
  <meta name="twitter:description" content="Meilleur site de la galaxie d'après la NASA pour faire ses TopList." />
  <meta name="twitter:image" content="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/share/share_vkrz_banner.jpg" />

<?php endif; ?>