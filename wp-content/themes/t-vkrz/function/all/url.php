<?php
// Ajoute une nouvelle règle de réécriture
function custom_rewrite_rule()
{
  add_rewrite_rule('^v/toplist/([^/]+)/?$', 'index.php?v_user_2=$matches[1]', 'top');
  add_rewrite_rule('^v/([^/]+)/?$', 'index.php?v_user=$matches[1]', 'top'); // This rule should be last
  add_rewrite_rule('^toplist/[^/]*/([^/]*)/?', 'index.php?toplist_id=$matches[1]', 'top');
  add_rewrite_rule('^devine/([^/]*)/?', 'index.php?toplist_devine_id=$matches[1]', 'top');
  add_rewrite_rule('^contender/([^/]*)/?', 'index.php?contender_slug=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_rule', 10, 0);

// Ajoute les nouveaux paramètres d'URL à la liste des paramètres de requête reconnus par WordPress
function custom_query_vars($vars)
{
  $vars[] = 'v_user';
  $vars[] = 'v_user_2';
  $vars[] = 'toplist_id';
  $vars[] = 'toplist_devine_id';
  $vars[] = 'contender_slug';
  return $vars;
}
add_filter('query_vars', 'custom_query_vars', 10, 1);

// Redirige vers un template spécifique lorsque l'URL correspond à une des règles de réécriture
function custom_template_include($template)
{
  global $wp_query;
  if (isset($wp_query->query_vars['v_user'])) {
    return get_template_directory() . '/1-membre/account-public.php';
  }
  if (isset($wp_query->query_vars['v_user_2'])) {
    return get_template_directory() . '/1-membre/listing-toplist.php';
  }
  if (isset($wp_query->query_vars['toplist_id'])) {
    return get_template_directory() . '/templates/r.php';
  }
  if (isset($wp_query->query_vars['toplist_devine_id'])) {
    return get_template_directory() . '/templates/single/devine.php';
  }
  if (isset($wp_query->query_vars['contender_slug'])) {
    return get_template_directory() . '/templates/single/contender.php';
  }
  return $template;
}
add_filter('template_include', 'custom_template_include');