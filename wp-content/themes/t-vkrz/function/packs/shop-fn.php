<?php
function get_the_produit_info($data) {
  $id_produit    = $data['id_produit'];
  $result        = array(
    "title"       => get_the_title($id_produit),
    "thumbnail"   => get_the_post_thumbnail_url($id_produit),
    "type"        => get_field('type_produit', $id_produit),
    "description"        => get_field('description_produit', $id_produit),
    "titre-sous-categorie"        => get_field('titre-sous-categorie', $id_produit),
    "prix_keurz"        => get_field('prix_keurz', $id_produit),
    "jeu"        => get_field('localisation_produit', $id_produit),
    "stock"        => get_field('stock_produit', $id_produit),
    "poids"        => get_field('poids_produit', $id_produit),
    "categorie-produit"  => wp_get_post_terms($id_produit, 'sous_categories', array('fields' => 'names')),
  );
  return $result;
}

//update commande
function update_produit_endpoint(WP_REST_Request $request) {
  $id = (int) $request->get_param('id_produit');

  // Vérifier si l'ID est valide
  if (!$id) {
      return new WP_REST_Response(['error' => 'ID invalide'], 400);
  }

  // Vérifier si le produit existe
  $post = get_post($id);
  if (!$post || $post->post_type !== 'produit') {
      return new WP_REST_Response(['error' => 'Produit introuvable'], 404);
  }

  // Récupérer les nouvelles données depuis la requête
  $params = $request->get_json_params();
  
  // Mise à jour des champs personnalisés
  if (isset($params['type'])) {
      update_field('type_produit', sanitize_text_field($params['type']), $id);
  }
  if (isset($params['poids'])) {
      update_field('poids_produit', sanitize_text_field($params['poids']), $id);
  }
  if (isset($params['statut'])) {
      update_post_meta($id, 'statut', sanitize_text_field($params['statut']));
  }
  if (isset($params['jeu'])) {
      update_field('localisation_produit', sanitize_text_field($params['jeu']), $id);
  }
  if (isset($params['stock'])) {
      update_field('stock', sanitize_text_field($params['stock']), $id);
  }

  return new WP_REST_Response(['message' => 'Produit mis à jour avec succès'], 200);
}

function get_all_produits() {
  $args = array(
    'post_type' => 'produit',
  );
  $produits = new WP_Query($args);
  $result = array(); // Initialize the result array
  while($produits->have_posts()) {
    $produits->the_post();
    $produit_id = get_the_ID();
    $result[] = array(
      "id"          => $produit_id,
      "title" => html_entity_decode(get_the_title($produit_id), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
      "thumbnail"   => get_the_post_thumbnail_url($produit_id),
      "type"        => get_field('type_produit', $produit_id),
      "price"       => get_field('price_produit', $produit_id),
      "description" => get_field('description_produit', $produit_id),
      "titre-sous-categorie" => get_field('titre-sous-categorie', $id_produit),
      "prix_keurz" => get_field('prix_keurz', $produit_id),
      "stock" => get_field('stock_produit', $produit_id),
      "poids" => get_field('poids_produit', $produit_id),
      "jeu" => get_field('localisation_produit', $produit_id),
      "link"        => get_permalink($produit_id)
    );
  }
  wp_reset_postdata(); // Reset WordPress post data
  return $result;
}

//Delete endpoint for the products
function delete_produit_endpoint( WP_REST_Request $request ) {
  $id = $request->get_param('id');

  if (!$id || !is_numeric($id)) {
      return new WP_REST_Response(['error' => 'ID invalide'], 400);
  }

  // Vérifie que l'utilisateur a les permissions nécessaires
  if (!current_user_can('delete_posts')) {
      return new WP_REST_Response(['error' => 'Permission refusée'], 403);
  }

  // Vérifie si le produit existe
  $post = get_post($id);
  if (!$post || $post->post_type !== 'produit') {
      return new WP_REST_Response(['error' => 'Produit introuvable'], 404);
  }

  // Supprime le produit
  $deleted = wp_delete_post($id, true); // true pour suppression définitive

  if ($deleted) {
      return new WP_REST_Response(['message' => 'Produit supprimé avec succès'], 200);
  } else {
      return new WP_REST_Response(['error' => 'Erreur lors de la suppression'], 500);
  }
}

function get_lot($data) {
  $id_top        = intval($data['id_top']);
  $imagedulot    = get_field('cadeau_t_sponso', $id_top);
  $imagedulotsrc = wp_get_attachment_image_url($imagedulot, 'full');
  $topPermanent  = get_field('top_permanent_topsponso', $id_top);
  if(isset($imagedulotsrc)) {
    $thereIsData = true;
  }
  if(!$topPermanent) {
    $topPermanent = false;
  }

  return [$thereIsData, $imagedulotsrc, $topPermanent];
}

function get_all_products_info() {
  $args = array(
      'post_type'      => 'product', 
      'posts_per_page' => -1 // Récupérer tous les produits
  );

  $query = new WP_Query($args);
  $results = [];

  if ($query->have_posts()) {
      while ($query->have_posts()) {
          $query->the_post();
          $product_id = get_the_ID();

          $results[] = array(
              "id"                    => $product_id,
              "title"                 => get_the_title($product_id),
              "thumbnail"             => get_the_post_thumbnail_url($product_id)
          );
      }
      wp_reset_postdata();
  }

  return $results;
}

function update_stock($data) {
  $id_produit = $data['id_produit'];
  $quantity = $data['quantity'];

  $current_stock = get_field('stock_produit', $id_produit);
  if($data['operation'] == 'add') {
    $new_stock = $current_stock + $quantity;
  } else {
    $new_stock = $current_stock - $quantity;
  }

  update_field('stock_produit', $new_stock, $id_produit);

  return new WP_REST_Response(['message' => 'Stock mis à jour avec succès'], 200);
}