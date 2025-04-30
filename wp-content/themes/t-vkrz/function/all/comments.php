<?php
function comment_redirect($location)
{
  var_dump($_POST['my_redirect_to']);
  if (isset($_POST['my_redirect_to']))
    $location = $_POST['my_redirect_to'];

  return $location;
}
add_filter('comment_post_redirect', 'comment_redirect');

function save_comment_meta($comment_id)
{
  var_dump('comment id : ' . $comment_id);
  var_dump('comment email_from_api : ' . $_POST['email_from_api']);
  if (isset($_POST['email_from_api']) && !empty($_POST['email_from_api'])) {
    $email_from_api = sanitize_email($_POST['email_from_api']);
    add_comment_meta($comment_id, 'email_from_api', $email_from_api, true);
  }
  if (isset($_POST['uuid_from_api']) && !empty($_POST['uuid_from_api'])) {
    $uuid_from_api = $_POST['uuid_from_api'];
    add_comment_meta($comment_id, 'uuid_from_api', $uuid_from_api, true);
  }
}
add_action('comment_post', 'save_comment_meta');