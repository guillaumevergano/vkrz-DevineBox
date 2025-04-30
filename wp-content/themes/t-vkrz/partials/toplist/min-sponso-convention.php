<?php
global $id_top;
$id_top           = get_the_ID();
$illu             = get_the_post_thumbnail_url($id_top, 'large');
if (!$illu && get_field('visuel_externe_top_firebase', $id_top))
  $illu = get_field('visuel_externe_top_firebase', $id_top);
$get_top_type     = get_the_terms($id_top, 'type');
?>
<div class="card t-sponso cover t-min-sponso" data-color="<?php the_field('couleur_de_la_sponso_t_sponso', $id_top); ?>">
  <div class="applat-top-sponso cover" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
  <div class="min-tournoi-content">
    <div class="agagner eh">
      <div class="d-cadeau row">
        <div class="col-5">
          <img src="<?= wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large', false); ?>" alt="">
        </div>
        <div class="col-7">
          <span class="titrewin">
            À gagner <span class="va va-gift va-lg"></span>
          </span>
          <h5>
            <?= the_field('titre_de_la_sponso_t_sponso', $id_top); ?>
          </h5>
        </div>
      </div>
    </div>
    <div class="todotop">
      <a href="<?= get_the_permalink($id_top); ?>" class="animate__jello cta-sponso-home animate__animated animate__delay-1s btn-wording bubbly-button btn-cta-participer">
        Clique ici pour tenter de gagner
      </a>
      <div class="separate my-3"></div>
      <div class="text-center mb-3">
        <small class="datefinsponso text-muted">
          Tirage au sort à 17h sur notre stand
          <span class="va va-chance va-lg"></span>
        </small>
      </div>
    </div>
  </div>
</div>