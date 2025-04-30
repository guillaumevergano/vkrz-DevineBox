<?php
global $id_top;
$id_top           = get_the_ID();
$background_choice    = get_field('background_choice_concours', $id_top);
$background_color_1   = get_field('color_1_concours', $id_top);
$type                 = get_post_type($id_top);
$background_style = '';
if ($background_choice == 'image') {
  $background_type  = "cover";
  $background_image = get_field('image_de_background_concours', $id_top);
  $background_style = 'background: url(' . wp_get_attachment_image_url($background_image, 'large') . ') no-repeat;';
} 
elseif ($background_choice == 'gradient') {
  $background_type  = "gradient";
  $background_style = 'background: linear-gradient(to bottom, ' . $background_color_1 . ', ' . get_field('color_2_concours', $id_top) . ');';
}
else{
  $background_type  = "color";
  $background_style = 'background-color: ' . esc_attr($background_color_1) .  ';';
}
$illu             = get_the_post_thumbnail_url($id_top, 'large');
if (!$illu && get_field('visuel_externe_top_firebase', $id_top)){
  $illu = get_field('visuel_externe_top_firebase', $id_top);
}
$color_text_1   = get_field('couleur_du_texte_concours_1', $id_top);
$color_text_2   = get_field('couleur_du_texte_concours_2', $id_top);
$color_bg_cta = get_field('couleur_du_cta_concours', $id_top);
$color_text_cta = get_field('couleur_du_texte_du_cta_concours', $id_top);
$intitule_cta = get_field('intitule_du_cta_t_sponso', $id_top);
if($intitule_cta == ''){
  $intitule_cta = 'Participer';
}
$color_type = get_field('couleur_du_type_concours', $id_top);
$color_type = get_field('couleur_du_type_concours', $id_top);
if($type == 'concours'){
  $link_cta = get_field('lien_du_cta_concours', $id_top);
  $img_lot = wp_get_attachment_image_url(get_field('lot_a_gagner_concours', $id_top), 'large');
}
else{
  $link_cta = get_the_permalink($id_top);
  $img_lot = wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large');
}
?>
<div class="min-tournoi-content">
  <div class="card t-min-sponso t-min-sponso-<?= $id_top; ?>" style="<?= $background_style; ?>">
    <div class="min-tournoi-content">

      <div class="cov-illu-sponso" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>

      <div class="agagner-min">
        <div class="d-cadeau-min" style="background-image: url(<?= $img_lot; ?>)"></div>
        <div class="agagner-equal-height">
          <h4 style="color: <?= $color_text_1; ?> !important">
            <?= the_field('titre_de_la_sponso_t_sponso', $id_top); ?>
          </h4>
        </div>
      </div>
      <div class="cta-min-sponso text-center mb-3">
        <a href="<?= $link_cta; ?>" class="animate__jello cta-sponso-home animate__animated animate__delay-1s btn-wording btn-cta-participer" style="background-color: <?= $color_bg_cta; ?>; color: <?= $color_text_cta; ?>">
          <?= $intitule_cta; ?>
        </a>
      </div>
      <div class="datefinsponso text-center mb-3" style="color: <?= $color_bg_cta; ?>">
        <small class="text-muted" style="color: <?= $color_text_2; ?> !important">Prochain tirage au sort <span class="va va-chance va-lg"></span></small>
        <div>
          <?php if(get_field("fin_de_la_sponso_t_sponso_decalage", $id_top)) : ?>
            <?= the_field('fin_de_la_sponso_t_sponso_decalage', $id_top); ?>
          <?php elseif(get_field("top_permanent_topsponso", $id_top)): ?>
            <small class="top-permanent-checking-date">⏳</small>
          <?php else: ?>
            <?= the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>