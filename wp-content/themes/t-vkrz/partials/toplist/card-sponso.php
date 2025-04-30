<?php
$id_top               = $args['lot'];
$template             = $args['template'];
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
$background_puce = get_field('background_puce', $id_top) ?? '#0C0B28';
$pictogramme_puce = get_field('pictogramme_puce', $id_top) ?? 'toplist';
switch($pictogramme_puce){
  case 'toplist':
    $pictogramme_puce_img = get_template_directory_uri() . '/assets/images/icon/toplist-icon.svg';
    break;
  case 'discord':
    $pictogramme_puce_img = get_template_directory_uri() . '/assets/images/icon/discord-icon.svg';
    break;
  case 'insta':
    $pictogramme_puce_img = get_template_directory_uri() . '/assets/images/icon/instagram-icon.svg';
    break;
  case 'youtube':
    $pictogramme_puce_img = get_template_directory_uri() . '/assets/images/icon/youtube-icon.svg';
    break;
}
?>
<?php if($template == 'min'): ?>
  <div id="tls-<?= $id_top; ?>" class="card card-sponso t-sponso cover t-min-sponso template-min-tls tls-<?= $background_type; ?>" style="<?= $background_style; ?>">
    <div class="agagner agagner-equal-height">
      <div class="lot-sponso-img" style="background-image: url(<?= $img_lot; ?>);"></div>
      <div class="lot-sponso-logo">
        <img src="<?= wp_get_attachment_image_url(get_field('logo_de_la_sponso_t_sponso', $id_top), "full"); ?>" alt="">
      </div>
      <h6 class="agagner-text mt-2 mb-2" style="color: <?php echo $color_text_1; ?>!important;">
        À gagner <span class="va va-finger-down va-lg"></span>
      </h6>
      <div class="caption-card-t-sponso">
        <?php if($type == 'concours'): ?>
          <h4 style="color: <?= $color_text_2; ?>!important;"><?= the_field('intitule_du_lot_concours', $id_top); ?></h4>
        <?php else: ?>
          <h4 style="color: <?= $color_text_2; ?>!important;"><?= the_field('titre_de_la_sponso_t_sponso', $id_top); ?></h4>
        <?php endif; ?>
      </div>
      <div class="todotop">
        <a href="<?= $link_cta; ?>" 
        class="animate__jello cta-sponso-home animate__animated animate__delay-1s btn-wording bubbly-button btn-cta-participer mt-2" 
        style="background-color: <?= $color_bg_cta; ?>!important;
        color: <?= $color_text_cta; ?>!important;">
          <?= $intitule_cta; ?>
        </a>
        <div class="text-center card-footer-t-sponso mt-2">
          <small class="datefinsponso" style="color: <?= $color_text_1; ?> !important;">
            Tirage au sort 
            <?php if($type == 'tournoi'): ?>
              <?php if(get_field("fin_de_la_sponso_t_sponso_decalage", $id_top)) : ?>
                <?= the_field('fin_de_la_sponso_t_sponso_decalage', $id_top); ?>
              <?php elseif(get_field("top_permanent_topsponso", $id_top)): ?>
                <span class="top-permanent-checking-date">⏳</span>
              <?php else: ?>
                <?= the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
              <?php endif; ?>
            <?php else: ?>
              <?= the_field('date_du_tirage_au_sort', $id_top); ?>
            <?php endif; ?>
          </small>
        </div>
      </div>
      <div class="puce-content" style="background-color: <?= $background_puce; ?>!important; left: 0;">
        <img src="<?= $pictogramme_puce_img; ?>" alt="" class="img-fluid">
      </div>
    </div>
  </div>
<?php else: ?>
  <div id="tls-<?= $id_top; ?>" class="card card-sponso t-sponso cover t-min-sponso template-max-tls tls-<?= $background_type; ?>" style="<?= $background_style; ?>">
    <div class="agagner row agagner-equal-height">
      <div class="col-md-8">
        <div class="lot-sponso-img lot-sponso-first d-block d-sm-none" style="background-image: url(<?= $img_lot; ?>);"></div>
        <div class="lot-sponso-logo">
          <img src="<?= wp_get_attachment_image_url(get_field('logo_de_la_sponso_t_sponso', $id_top), "full"); ?>" alt="">
        </div>
        <h6 class="agagner-text mt-2 mb-2" style="color: <?= $color_text_1; ?>!important;">
          À gagner <span class="va va-finger-down va-lg"></span>
        </h6>
        <div class="caption-card-t-sponso">
          <?php if($type == 'concours'): ?>
            <h4 style="color: <?= $color_text_2; ?>!important;"><?= the_field('intitule_du_lot_concours', $id_top); ?></h4>
          <?php else: ?>
            <h4 style="color: <?= $color_text_2; ?>!important;"><?= the_field('titre_de_la_sponso_t_sponso', $id_top); ?></h4>
          <?php endif; ?>
        </div>
        <div class="todotop">
          <a href="<?= $link_cta; ?>" 
          class="animate__jello cta-sponso-home animate__animated animate__delay-1s btn-wording bubbly-button btn-cta-participer mt-2" 
          style="background-color: <?= $color_bg_cta; ?>!important;
          color: <?= $color_text_cta; ?>!important;">
            <?= $intitule_cta; ?>
          </a>
          <div class="text-center card-footer-t-sponso mt-2">
            <small class="datefinsponso" style="color: <?= $color_text_1; ?> !important;">
              Tirage au sort 
              <?php if($type == 'tournoi'): ?>
                <?php if(get_field("fin_de_la_sponso_t_sponso_decalage", $id_top)) : ?>
                  <?= the_field('fin_de_la_sponso_t_sponso_decalage', $id_top); ?>
                <?php elseif(get_field("top_permanent_topsponso", $id_top)): ?>
                  <span class="top-permanent-checking-date">⏳</span>
                <?php else: ?>
                  <?= the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
                <?php endif; ?>
              <?php else: ?>
                <?= the_field('date_du_tirage_au_sort', $id_top); ?>
              <?php endif; ?>
            </small>
          </div>
        </div>
      </div>
      <div class="col-md-4 d-none d-md-block">
        <div class="lot-sponso-img" style="background-image: url(<?= $img_lot; ?>);"></div>
      </div>
      <div class="puce-content" style="background-color: <?= $background_puce; ?>!important; left: 12px;">
        <img src="<?= $pictogramme_puce_img; ?>" alt="" class="img-fluid">
      </div>
    </div>
  </div>
<?php endif; ?>