<?php
function get_rubrique($slug_rubrique){
    $id_rubrique = 0;

    $rubrique_query = new WP_Query(array(
        'ignore_sticky_posts'   => true,
        'update_post_meta_cache' => false,
        'no_found_rows'         => true,
        'post_type'             => 'rubrique',
        'posts_per_page'        => 1,
        'name'                  => $slug_rubrique // 'name' is used for slug
    ));

    if ($rubrique_query->have_posts()) {
        $rubrique_query->the_post();
        $id_rubrique = get_the_ID();
    }

    // Reset Post Data
    wp_reset_postdata();

    return $id_rubrique;
}

function getCurrentUrl() {
    $protocol = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = 'https';
    } elseif (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) {
        $protocol = 'https';
    }

    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];

    return $protocol . '://' . $host . $uri;
}

function get_all_content(){

  $list_result        = array();
  $list_result_unique = array();

  $all_tops = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'tax_query'                 => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
    'meta_query' => array(
      array(
        'key'     => 'validation_top',
        'value'   => array('valide'),
        'compare' => 'IN',
      )
    )
  ));
  while ($all_tops->have_posts()) : $all_tops->the_post();
    array_push($list_result, html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'));
  endwhile;

  $all_contenders = new WP_Query(array(
    'post_type'                 => 'contender',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true
  ));
  while ($all_contenders->have_posts()) : $all_contenders->the_post();
    array_push($list_result, html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'));
  endwhile;

  $list_result_unique   = array_values(array_unique($list_result));
  return $list_result_unique;
}