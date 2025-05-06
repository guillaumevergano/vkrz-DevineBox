<?php
function cpt_init() {

  // Tops
  $labels = array(
    'name' => 'TopList',
    'singular_name' => 'TopList',
    'add_new' => 'Ajouter une TopList',
    'add_new_item' => 'Ajouter un TopList',
    'edit_item' => 'Editer une TopList',
    'new_item' => 'Nouvelle TopList',
    'all_items' => 'Toutes les TopList',
    'view_item' => 'Voir la TopList',
    'search_items' => 'Chercher une TopList',
    'not_found' =>  'Aucune TopList trouvée',
    'not_found_in_trash' => 'Aucune TopList trouvée dans la corbeille',
    'menu_name' => 'TopList'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 't'),
    'map_meta_cap' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'menu_icon' => 'dashicons-editor-code',
    'show_in_rest' => true,
    'supports' => array('title', 'thumbnail', 'trash')
  );
  register_post_type('tournoi', $args);
  

  // TopList mondiale
  $labels = array(
    'name' => 'TopList mondiale',
    'singular_name' => 'TopList mondiale',
    'add_new' => 'Ajouter une TopList mondiale',
    'add_new_item' => 'Ajouter une TopList mondiale',
    'edit_item' => 'Editer une TopList mondiale',
    'new_item' => 'Nouvelle TopList mondiale',
    'all_items' => 'Toutes les TopList mondiales',
    'view_item' => 'Voir la TopList mondiale',
    'search_items' => 'Chercher une TopList mondiale',
    'not_found' =>  'Aucune TopList mondiale trouvée',
    'not_found_in_trash' => 'Aucune TopList mondiale trouvée dans la corbeille',
    'menu_name' => 'TopList mondiale'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'top-mondial'),
    'map_meta_cap' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'menu_icon' => 'dashicons-admin-site',
    'show_in_rest' => true,
    'supports' => array('title', 'editor')
  );
  register_post_type('toplist-mondiale', $args);
  
  
  // Rubrique
  $labels = array(
    'name' => 'Rubrique',
    'singular_name' => 'Rubrique',
    'add_new' => 'Ajouter une rubrique',
    'add_new_item' => 'Ajouter une rubrique',
    'edit_item' => 'Editer une rubrique',
    'new_item' => 'Nouvelle rubrique',
    'all_items' => 'Toutes les rubriques',
    'view_item' => 'Voir l\'rubrique',
    'search_items' => 'Chercher une rubrique',
    'not_found' =>  'Aucune rubrique trouvée',
    'not_found_in_trash' => 'Aucune rubrique trouvée dans la corbeille',
    'menu_name' => 'Rubriques'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'rubrique'),
    'map_meta_cap' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'menu_icon' => 'dashicons-image-filter',
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'thumbnail')
  );
  register_post_type('rubrique', $args);

  // Contenders
  $labels = array(
    'name' => 'Contender',
    'singular_name' => 'Contender',
    'add_new' => 'Ajouter un contender',
    'add_new_item' => 'Ajouter un contender',
    'edit_item' => 'Editer un contender',
    'new_item' => 'Nouveau contender',
    'all_items' => 'Tous les contenders',
    'view_item' => 'Voir contender',
    'search_items' => 'Chercher un contender',
    'not_found' =>  'Aucun contender trouvé',
    'not_found_in_trash' => 'Aucun contender trouvé dans la corbeille',
    'menu_name' => 'Contenders'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'c'),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'menu_icon' => 'dashicons-superhero',
    'show_in_rest' => false,
    'supports' => array('title', 'thumbnail')
  );
  register_post_type('contender', $args);
  
}
add_action( 'init', 'cpt_init' );



