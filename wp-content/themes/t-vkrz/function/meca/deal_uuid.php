<?php
function give_uuid(){
  $uuid = "";
  $arr_cookie_options = array(
    'expires' => time() + 60 * 60 * 24 * 365,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => false,
    'samesite' => 'Lax'
  );

  if (isset($_COOKIE["user-connected-uuid"]) && $_COOKIE["user-connected-uuid"] != "") {
    $uuid = $_COOKIE["user-connected-uuid"];
    setcookie("wordpress_vainkeurz_uuid_cookie", $uuid, $arr_cookie_options);
  } 
  elseif (isset($_COOKIE["wordpress_vainkeurz_uuid_cookie"]) && $_COOKIE["wordpress_vainkeurz_uuid_cookie"] != "") {
    $uuid = $_COOKIE["wordpress_vainkeurz_uuid_cookie"];
  } 
  else {
    $uuid = uniqidReal();
    setcookie("wordpress_vainkeurz_uuid_cookie", $uuid, $arr_cookie_options);
  }
  
  return $uuid;
}

function uniqidReal($lenght = 13) {
  if (function_exists("random_bytes")) {
      $bytes = random_bytes(ceil($lenght / 2));
  } elseif (function_exists("openssl_random_pseudo_bytes")) {
      $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
  } else {
      throw new Exception("no cryptographically secure random function available");
  }
  $uniqkey = substr(bin2hex($bytes), 0, $lenght);
  if($uniqkey == ""){
      $uniqkey = time();
  }
  return $uniqkey;
}

