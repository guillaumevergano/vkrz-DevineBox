<?php
$type_top     = "";
global $id_top;
$id_top = get_the_ID();
switch (get_post_type()) {
  case "tournoi":
    get_template_part("templates/single/t");
    break;

  case "post":
    get_template_part("templates/single/post");
    break;

  case "room":
    get_template_part("templates/single/room");
    break;

  case "toplist-mondiale":
    get_template_part("templates/single/mondial");
    break;
  
  case "rubrique":
    get_template_part("templates/single/rubrique");
    break;
}
