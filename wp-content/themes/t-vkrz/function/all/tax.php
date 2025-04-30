<?php
function tax_init() {

    # Catégorie Top
    register_taxonomy(
        'categorie',
        array('tournoi', 'rubrique'),
        array(
            'label'         => 'Catégories',
            'rewrite'       => array('slug' => 'cat'),
            'hierarchical'  => true,
            'show_in_rest'  => true,
        )
    );

    # Target Top
    register_taxonomy(
        'sous-cat',
        array('tournoi'),
        array(
            'label'         => 'Sous cat',
            'rewrite'       => array('slug' => 'sous-cat'),
            'hierarchical'  => false,
            'show_in_rest'  => true,
        )
    );

    # Type de Top
    register_taxonomy(
        'type',
        array('tournoi'),
        array(
            'label'         => 'Type',
            'rewrite'       => array('slug' => 'type'),
            'hierarchical'  => false,
            'show_in_rest'  => true,
            'rest_base'     => 'type_tax'
        )
    );

  register_taxonomy(
    'badges',
    array('vainkeur'),
    array(
      'label' => 'Trophées 🎖',
      'labels' => array(
        'name'              => 'Trophées 🎖',
        'singular_name'     => 'Trophée 🎖',
        'search_items'      => 'Chercher un Trophée',
        'all_items'         => 'Tous les Trophées',
        'edit_item'         => 'Modifier le Trophée',
        'update_item'       => 'Sauvegarder le Trophée',
        'add_new_item'      => 'Ajouter un Trophée',
        'new_item_name'     => 'Nouveau nom de Trophée',
        'menu_name'         => 'Trophées'
      ),
      'hierarchical'      => false,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array('slug' => 'badges')
    )
  );

    # Sous-catégories Produits
    register_taxonomy(
        'sous_categories',
        array('produit'),
        array(
            'label' => 'Sous-catégories',
            'labels' => array(
                'name'              => 'Sous-catégories',
                'singular_name'     => 'Sous-catégorie',
                'search_items'      => 'Rechercher une sous-catégorie',
                'all_items'         => 'Toutes les sous-catégories',
                'edit_item'         => 'Modifier la sous-catégorie',
                'update_item'       => 'Mettre à jour la sous-catégorie',
                'add_new_item'      => 'Ajouter une nouvelle sous-catégorie',
                'new_item_name'     => 'Nom de la nouvelle sous-catégorie',
                'menu_name'         => 'Sous-catégories'
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => 'sous-categories'),
        )
    );
    
}
add_action('init', 'tax_init');