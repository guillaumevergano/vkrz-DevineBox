<?php
$templatepath = get_template_directory();
if (is_admin()) {
  include($templatepath . '/function/admin.php');
} elseif (!defined('XMLRPC_REQUEST') && !defined('DOING_CRON')) {
  include($templatepath . '/function/front.php');
}
include($templatepath . '/function/all.php');
include($templatepath . '/function/meca.php');
include($templatepath . '/function/cron.php');
include($templatepath . '/function/packs.php');
include($templatepath . '/function/notifications.php');
include($templatepath . '/function/tuya.php');

@ini_set('upload_max_size', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300');

add_filter('show_admin_bar', '__return_false');

add_theme_support('post-thumbnails');






