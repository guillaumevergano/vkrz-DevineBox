<?php
if (!wp_next_scheduled('launching_wp_cron')) {
  wp_schedule_event(time(), 'hourly', 'launching_wp_cron');
}
add_action('launching_wp_cron', 'generate_json_data');
add_action('my_generate_json_data_hook', 'generate_json_data');

function generate_json_data()
{
  $cat_ids_list = array(2, 3, 4, 5, 6, 7, 10, 56,);
  foreach ($cat_ids_list as $cat_id) {
    $logMessage = date('Y-m-d H:i:s') . ': Generate json for cat id : ' . $cat_id;
    error_log($logMessage);
    $json_url = get_site_link() . "/wp-json/v1/getcattops/" . $cat_id . "/2000/";
    $json = file_get_contents($json_url);
    file_put_contents(ABSPATH . 'json/cat/cat-' . $cat_id . '.json', $json);
  }
}

function generate_json_data_popular()
{
  $cat_ids_list = array(2, 3, 4, 5, 6, 7, 10, 56,);
  foreach ($cat_ids_list as $cat_id) {
    $logMessage = date('Y-m-d H:i:s') . ': Generate json for cat id : ' . $cat_id;
    error_log($logMessage);
    $json_url = get_site_link() . "/wp-json/v1/getcattopspopular/" . $cat_id . "/2000/";
    $json = file_get_contents($json_url);
    file_put_contents(ABSPATH . 'json/cat-popular/cat-' . $cat_id . '.json', $json);
  }
}

add_action('launching_wp_cron', 'generate_json_data_resume');
add_action('my_generate_json_data_hook', 'generate_json_data_resume');