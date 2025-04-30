<?php
function env(){
    $local_env = [
        'localhost',
        'localhost:8888'
    ];

    if (in_array( $_SERVER['SERVER_NAME'], $local_env)) {
        return "local";
    }
    return "prod";
}

function get_site_link()
{

  if (env() == "local") {
    $api_link = "http://localhost:8888/vkrz-wp";
  } 
  else {
    $api_link = "https://vainkeurz.com";
  }

  return $api_link;
}

function get_base_api_url(){
  if(env() == "prod"){
      return 'https://api.vainkeurz.com/vkrz';
  }else{
      return 'http://localhost:8000/vkrz';
  }
}