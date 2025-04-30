<?php
function publish_top_to_discord($post_id)
{

  global $post;

  $post = get_post($post_id);

  if ($post && ($post->post_type != 'tournoi' || $post->post_status == 'publish')) {
    return;
  }

  $post_taxonomies = array();
  foreach (get_the_terms($post_id, 'type') as $tax) {
    array_push($post_taxonomies, $tax->name);
  }

  if (in_array("Private", $post_taxonomies)) {
    return;
  }

  $id_top = $post_id;
  $top_datas = get_top_infos($id_top, "complet");

  if ($top_datas['top_type'] != "sponso") {
    return;
  }

  $cat_name = $top_datas['top_cat_name'];
  $cat_icon = "";
  switch ($cat_name) {
    case 'Sport':
      $cat_icon = " 🏓 ";
      break;
    case 'Musique':
      $cat_icon = " 💿 ";
      break;
    case 'Jeux vidéo':
      $cat_icon = " 🕹️ ";
      break;
    case 'Food':
      $cat_icon = " 🥨 ";
      break;
    case 'Écran':
      $cat_icon = " 📺 ";
      break;
    case 'Comics':
      $cat_icon = " 🕸️ ";
      break;
    case 'Manga':
      $cat_icon = " 🐲 ";
      break;
    case 'Autres':
      $cat_icon = " 🤷‍♂️ ";
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
    'username'   => "NOTEURZ 🤖",
    'avatar_url' => 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
    'embeds'     => [$embed],
  ];

  $webhook = "top-valide-sponso";
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
  $response = curl_exec($ch);
  curl_close($ch);
}
add_action('publish_tournoi', 'publish_top_to_discord');