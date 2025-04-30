<?php
function vkrz_get_template(string $path, array $args = [])
{
  if (!empty($args) && is_array($args)) {
    extract($args);
  }
  ob_start();
  include($path);
  $var = ob_get_contents();
  ob_end_clean();
  return $var;
}

function vkrz_last_toplist_shortcode($args)
{
  $isInfiniteScroll = false;
  $limit = 4;
  if (isset($args['is-infinite-scroll'])) {
    $isInfiniteScroll = true;
  }
  if (isset($args['limit'])) {
    $limit = (int)$args['limit'];
  }
  $col = "col-md-4 col-12 col-sm-6";
  if (isset($args['col'])) {
    $col = $args['col'];
  }
  $uuidUserFilter = "";
  if (isset($args['uuid-user-filter'])) {
    $uuidUserFilter = $args['uuid-user-filter'];
  }
  return vkrz_get_template(get_template_directory() . '/function/shortcode/toplist.php', [
    'isInfiniteScroll' => $isInfiniteScroll,
    'limit'            => $limit,
    'col'              => $col,
    'uuidUserFilter'   => $uuidUserFilter,
    'idTopFilter'      => $args['id-top-filter'] ?? false,
    'userProfile'      => $args['user-profile'] ?? false,
  ]);
}
add_shortcode('vkrz_last_toplist', 'vkrz_last_toplist_shortcode');

function vkzr_fetch_toplist_data() {
  $current_cat_id = isset($_GET['current_cat_id']) ? $_GET['current_cat_id'] : 'default';
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $items_per_page = 8;

  if((env() == "prod")) {
    $url = "https://vainkeurz.com/json/cat/cat-$current_cat_id.json";
  }
  else {
    $url = "http://localhost:8888/vkrz-wp/json/cat/cat-$current_cat_id.json";
  }
  

  $json_data = file_get_contents($url);
  if ($json_data === false) {
      wp_send_json_error('Unable to fetch data from URL');
      wp_die();
  }

  $full_data = json_decode($json_data, true);

  if (json_last_error() !== JSON_ERROR_NONE) {
      wp_send_json_error('JSON decoding error: ' . json_last_error_msg());
      wp_die();
  }

  // Since your JSON structure is an array, you need to access the first element.
  if (isset($full_data[0]['list_tops']) && is_array($full_data[0]['list_tops'])) {
      $data = $full_data[0]['list_tops']; // This should be an array of tops
      $offset = ($page - 1) * $items_per_page;
      $paged_data = array_slice($data, $offset, $items_per_page);

      wp_send_json_success($paged_data);
  } else {
      wp_send_json_error('Invalid JSON structure');
      wp_die();
  }
}
add_action('wp_ajax_nopriv_vkzr_fetch_toplist', 'vkzr_fetch_toplist_data');
add_action('wp_ajax_vkzr_fetch_toplist', 'vkzr_fetch_toplist_data');

function vkzr_fetch_toplist_data_popular() {
  $current_cat_id = isset($_GET['current_cat_id']) ? $_GET['current_cat_id'] : 'default';
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $items_per_page = 8;

  if((env() == "prod")) {
    $url = "https://vainkeurz.com/json/cat-popular/cat-$current_cat_id.json";
  }
  else {
    $url = "http://localhost:8888/vkrz-wp/json/cat-popular/cat-$current_cat_id.json";
  }
  

  $json_data = file_get_contents($url);
  if ($json_data === false) {
      wp_send_json_error('Unable to fetch data from URL');
      wp_die();
  }

  $full_data = json_decode($json_data, true);

  if (json_last_error() !== JSON_ERROR_NONE) {
      wp_send_json_error('JSON decoding error: ' . json_last_error_msg());
      wp_die();
  }

  // Since your JSON structure is an array, you need to access the first element.
  if (isset($full_data[0]['list_tops']) && is_array($full_data[0]['list_tops'])) {
      $data = $full_data[0]['list_tops']; // This should be an array of tops
      $offset = ($page - 1) * $items_per_page;
      $paged_data = array_slice($data, $offset, $items_per_page);

      wp_send_json_success($paged_data);
  } else {
      wp_send_json_error('Invalid JSON structure');
      wp_die();
  }
}
add_action('wp_ajax_nopriv_vkzr_fetch_toplist_popular', 'vkzr_fetch_toplist_data_popular');
add_action('wp_ajax_vkzr_fetch_toplist_popular', 'vkzr_fetch_toplist_data_popular');

function vkzr_fetch_toplist_data_list_terms() {
  $current_cat_id = isset($_GET['current_cat_id']) ? $_GET['current_cat_id'] : 'default';


  if((env() == "prod")) {
    $url = "https://vainkeurz.com/json/cat-popular/cat-$current_cat_id.json";
  }
  else {
    $url = "http://localhost:8888/vkrz-wp/json/cat-popular/cat-$current_cat_id.json";
  }
  

  $json_data = file_get_contents($url);
  if ($json_data === false) {
      wp_send_json_error('Unable to fetch data from URL');
      wp_die();
  }

  $full_data = json_decode($json_data, true);

  if (json_last_error() !== JSON_ERROR_NONE) {
      wp_send_json_error('JSON decoding error: ' . json_last_error_msg());
      wp_die();
  }

  // Since your JSON structure is an array, you need to access the first element.
  if (isset($full_data[0]['list_terms']) && is_array($full_data[0]['list_terms'])) {
      $data = $full_data[0]['list_terms']; // This should be an array of tops


      wp_send_json_success($data);
  } else {
      wp_send_json_error('Invalid JSON structure');
      wp_die();
  }
}
add_action('wp_ajax_nopriv_vkzr_fetch_toplist_data_list_terms', 'vkzr_fetch_toplist_data_list_terms');
add_action('wp_ajax_vkzr_fetch_toplist_data_list_terms', 'vkzr_fetch_toplist_data_list_terms');

function vkzr_search_toplist_data() {
  $search_term = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
  $current_cat_id = isset($_GET['current_cat_id']) ? $_GET['current_cat_id'] : 'default';

  // Use the correct path to your JSON file
  $url = "https://vainkeurz.com/json/cat/cat-$current_cat_id.json"; // Adjust as needed
  $json_data = file_get_contents($url);
  if ($json_data === false) {
      wp_send_json_error('Unable to fetch data from URL');
      wp_die();
  }
  $full_data = json_decode($json_data, true);

  if (!empty($search_term) && isset($full_data[0]['list_tops']) && is_array($full_data[0]['list_tops'])) {
      $filtered_data = array_filter($full_data[0]['list_tops'], function ($entry) use ($search_term) {
          return stripos($entry['top_title'], $search_term) !== false || 
                 stripos($entry['top_question'], $search_term) !== false;
      });
      wp_send_json_success(array_values($filtered_data)); // Re-index the array and send it back
  } else {
      wp_send_json_error('Invalid JSON structure or no search term provided');
  }
  wp_die();
}
add_action('wp_ajax_nopriv_vkzr_search_toplist', 'vkzr_search_toplist_data');
add_action('wp_ajax_vkzr_search_toplist', 'vkzr_search_toplist_data');




function vkzr_search_toplist_data_function() {
  $search_term = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
  $current_cat_id = isset($_GET['current_cat_id']) ? sanitize_text_field($_GET['current_cat_id']) : 'default';
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $items_per_page = 8;
  
  if((env() == "prod")) {
    $url = "https://vainkeurz.com/json/cat-popular/cat-$current_cat_id.json";
  }
  else {
    $url = "http://localhost:8888/vkrz-wp/json/cat-popular/cat-$current_cat_id.json";
  }
  
  $json_data = file_get_contents($url);
  if ($json_data === false) {
      wp_send_json_error('Impossible de récupérer les données');
      wp_die();
  }

  $full_data = json_decode($json_data, true);
  if (json_last_error() !== JSON_ERROR_NONE) {
      wp_send_json_error('Erreur de décodage JSON');
      wp_die();
  }

  if (!empty($search_term) && isset($full_data[0]['list_tops']) && is_array($full_data[0]['list_tops'])) {
      $filtered_data = array_values(array_filter($full_data[0]['list_tops'], function ($entry) use ($search_term) {
          return stripos($entry['top_title'], $search_term) !== false || 
                 stripos($entry['top_question'], $search_term) !== false;
      }));

      $total_items = count($filtered_data);
      $offset = ($page - 1) * $items_per_page;
      $paged_data = array_slice($filtered_data, $offset, $items_per_page);

      wp_send_json_success($paged_data);
  } else {
      wp_send_json_error('Aucune donnée trouvée');
  }
  wp_die();
}
add_action('wp_ajax_nopriv_vkzr_search_toplist_data_function', 'vkzr_search_toplist_data_function');
add_action('wp_ajax_vkzr_search_toplist_data_function', 'vkzr_search_toplist_data_function');

add_action('acf/save_post', 'set_acf_image_as_featured_for_contender', 20);
function set_acf_image_as_featured_for_contender($post_id) {
    if (get_post_type($post_id) === 'contender') {
        $image_id = get_field('contender_thumbnail', $post_id, false);
        if ($image_id) {
            set_post_thumbnail($post_id, $image_id);
        }
    }
}