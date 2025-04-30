<?php
function load_css_js()
{
  //////// CSS ////////
  wp_enqueue_style('combined-styles', get_template_directory_uri() . '/assets/css/core.min.css', array(), null);
  wp_enqueue_style('font', 'https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&?family=Libre%20Franklin:400?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), null);
  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/vainkeurz/main.css', array(), filemtime(get_template_directory() . '/assets/css/vainkeurz/main.css'));
  //////// SCRIPTS ////////

  if(!is_page(get_page_by_path('ambassadeur')) && !is_page(get_page_by_path('road-to-million'))){
    // Firebase
    wp_enqueue_script('firebase', get_template_directory_uri() . '/assets/js/membre/firebase.min.js', array(), null, true); 
    wp_enqueue_script('auth', get_template_directory_uri() . '/assets/js/membre/auth.js', array(), filemtime(get_template_directory() . '/assets/js/membre/auth.js'), true);

    // Core
    wp_enqueue_script('apijs', get_template_directory_uri() . '/assets/js/membre/api.js', array(), filemtime(get_template_directory() . '/assets/js/membre/api.js'), false);
    wp_enqueue_script('actionjs', get_template_directory_uri() . '/assets/js/membre/action.js', array(), filemtime(get_template_directory() . '/assets/js/membre/action.js'), false);
    wp_enqueue_script('all', get_template_directory_uri() . '/assets/js/all.min.js', array(), null, true);
    wp_enqueue_script('mainjs', get_template_directory_uri() . '/assets/js/vainkeurz/main.js', array(), filemtime(get_template_directory() . '/assets/js/vainkeurz/main.js'), true);
  }

  // Vote + Twitch
  if (is_single() && get_post_type() == 'tournoi') {
    wp_enqueue_script('contenders-ajax', get_template_directory_uri() . '/assets/js/vainkeurz/contenders-ajax.js', array(), filemtime(get_template_directory() . '/assets/js/vainkeurz/contenders-ajax.js'), true);
    wp_enqueue_script('tmi.min', get_template_directory_uri() . '/assets/js/twitch/tmi.min.js', array(), null, true);
    wp_enqueue_script('twitch_votes', get_template_directory_uri() . '/assets/js/twitch/twitch_votes.js', array(), filemtime(get_template_directory() . ''), true);
  }

  // TopList
  if (get_post_type() == "classement") {
    wp_enqueue_script('similar', get_template_directory_uri() . '/function/ajax/similar.js', array(), filemtime(get_template_directory() . '/function/ajax/similar.js'), true);
  }   

  // Création & Edition
  if (is_page(593779) || is_page(593775)) {
    wp_enqueue_script('create-top', get_template_directory_uri() . '/assets/js/vainkeurz/create-top.js', array(), filemtime(get_template_directory() . '/assets/js/vainkeurz/create-top.js'), true);
  }

}
add_action('wp_enqueue_scripts', 'load_css_js');

function load_weglot_before_scripts() {
    wp_enqueue_script('weglot', 'https://cdn.weglot.com/weglot.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'load_weglot_before_scripts', 5);

function pass_weglot_lang_to_js() {
    $lang = weglot_get_current_language();
    wp_localize_script('create-top', 'WeglotData', array('lang' => $lang));
    wp_localize_script('auth', 'WeglotData', array('lang' => $lang));
}
add_action('wp_enqueue_scripts', 'pass_weglot_lang_to_js');