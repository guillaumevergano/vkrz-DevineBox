<?php
add_filter('wp_get_attachment_url', 'change_image_domain', 10, 2);
function change_image_domain($url){
  $site_url = get_site_url();
  if (strpos($site_url, 'localhost') !== false) {
    $parts = parse_url($url);
    $base_dir = '/wp-content/uploads/';
    $pos = strpos($parts['path'], $base_dir);
    if ($pos !== false) {
      $new_path = substr($parts['path'], $pos);
      $new_url = 'https://vainkeurz.com' . $new_path;
      return $new_url;
    }
  }
  return $url;
}