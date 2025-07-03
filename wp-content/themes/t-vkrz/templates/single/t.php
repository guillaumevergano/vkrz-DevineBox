<?php
global $uuid_user;
global $UTM;
global $id_top;
global $top_infos;
global $top_title_question;
global $type_top;
global $term_rassemblement;
global $emoji_rassemblement;
get_header();
$url_top            = get_the_permalink($id_top);
$type_top           = $top_infos['top_type'];
$ttq_wEmoji         = createSlug($top_title_question);
$slug_top           = sanitize_title($ttq_wEmoji);
$is_twitch          = $top_infos['is_twitch'];
$top_number         = $top_infos['top_number'];
$hidemobile         = "";
$equal              = "";
if ($type_top == "sponso") {
  $hidemobile       = "d-none d-sm-block";
  $type_top_class   = "top_is_sponso";
  $hide_if_sponso   = "d-none";
}
$etat_top             = get_field('validation_top', $id_top);
$term_rassemblement   = get_field('nom_du_rassemblement_t', $id_top);
$emoji_rassemblement  = get_field('emoji_du_rassemblement_t', $id_top);
if(!$term_rassemblement){ $term_rassemblement = "Rassemblement des contenders"; }
if(!$emoji_rassemblement){ $emoji_rassemblement = "wheel"; }
if($top_infos['top_d_titre']){ echo "<style>.title-contender {display: none;}</style>"; }
$fichier_css_toplist = get_field('fichier_css_toplist', $id_top) ?? '';
$activer_style_boite_toplist = get_field('activer_style_bo', $id_top) ?? false;
if(!$fichier_css_toplist && $activer_style_boite_toplist) : 
  $couleur_1 = get_field('color_1_concours', $id_top);
  $couleur_2 = get_field('color_2_concours', $id_top);
  $couleur_3 = get_field('couleur_du_type_concours', $id_top);
  $couleur_4 = get_field('couleur_du_cta_concours', $id_top);
  $couleur_5 = get_field('background_puce', $id_top);
  $couleur_text_1 = get_field('couleur_du_texte_concours_1', $id_top);
  $couleur_text_2 = get_field('couleur_du_texte_concours_2', $id_top);
  $background_choice = get_field('background_choice_concours', $id_top);
  if($background_choice == "image"){
    $background_image = wp_get_attachment_image_url(get_field('background_image_concours', $id_top), 'full');
  }
?>
<style>
  <?php if($background_choice == "uni"): ?>
    .ba-cover-r:after {
      background-color: <?= $couleur_1; ?> !important;
      opacity: 1 !important;
    }
  <?php elseif($background_choice == "image"): ?>
    .ba-cover-r:after {
      background-image: url(<?= $background_image; ?>) !important;
      opacity: 1 !important;
    }
  <?php elseif($background_choice == "gradient"): ?>
    .ba-cover-r:after {
      background: linear-gradient(to bottom, <?= $couleur_1; ?> 0%, <?= $couleur_2; ?> 100%) !important;
      opacity: 1 !important;
    }
  <?php endif; ?>
  .bg-navbar-theme {
    background-color: <?= $couleur_1; ?> !important;
  }
  .card-developer-meetup, .card-presentation-top-right {
    background: <?= $couleur_2; ?> !important;
    box-shadow: none !important;
  }
  .bg-menu-theme.menu-horizontal {
    background-color: <?= $couleur_2; ?> !important;
  }
  .top-question {
    color: <?= $couleur_text_1; ?>;
    text-shadow: none;
  }
  .bubbly-button {
    background-color: <?= $couleur_4; ?> !important;
  }
  .agagner .titrewin {
    background: <?= $couleur_4; ?>;
    color: <?= $couleur_4; ?>;
  }
  input[type=email], .t-sponso-email-beginning input[type=tel] {
    border: 2px solid <?= $couleur_4; ?> !important;
  }
  
  input[type=email]::placeholder, 
  .t-sponso-email-beginning input[type=tel]::placeholder {
    color: <?= $couleur_4; ?> !important
  }
  .t-sponso-email-beginning .accept-topsponso-terms a {
    color: <?= $couleur_4; ?>;
  }
  .t-sponso-email-beginning .accept-topsponso-terms .form-check-input {
    border: 2px solid <?= $couleur_4; ?> !important;
  }
</style>
<?php endif;
$participation_inscription_fin = get_field('participation_inscription_fin_t_sponso', $id_top);
?>
<script>
  const id_top            = <?= $id_top; ?>;
  const isMobile          = "<?= isMobile() ?>";
  const participation_inscription_fin_var = "<?= $participation_inscription_fin; ?>";
  let slugTop             = "<?= $slug_top; ?>";
  let is_beginned         = false;
  let id_topList          = "";
  let topInfo             = {};
  let initContenders      = null, topListData, contendersInJson;
  let automaticTwitchGift = false;
  let automaticTwitchGiftTop1, automaticTwitchGiftTop3, automaticTwitchGiftTopComplet = false;
  let contendersLoaded = false;
  let is_toplist_type_youtube_videos_var;
</script>

<div class="tournoi-content ba-cover-r <?= $type_top_class ?? ""; ?> bloc-top-<?php echo $type_top; ?>">
<?php
// Vérifiez la condition pour appliquer le style
if (strpos(home_url($_SERVER['REQUEST_URI']), '/t/') !== false && get_field('fichier_css_toplist', $id_top) == null) {
    $backgroundColor = get_field('color_1_concours', $id_top);
    if ($backgroundColor) {
        echo '<style>
            .ba-cover-r::after {
                background-color: ' . esc_attr($backgroundColor) . ' !important;
            }
        </style>';
    }
}
?>
  <!-- TOP PAS LANCÉ -->
  <div class="top_not_started z9" data-color="<?php the_field('couleur_de_la_sponso_t_sponso', $id_top); ?>">
    <div class="content-intro container-xxl mt-4">
      <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6 order-2 order-sm-0">
          <div class="presentationtop">
            <div class="card animate__animated animate__flipInX card-developer-meetup card-top-presentation m-0">
              <div class="meetup-img-wrapper rounded-top text-left <?php echo $hidemobile; ?>"></div>
              <div class="card-body presentationtop <?php echo $hidemobile; ?>">
                <div class="meetup-header">
                  <div class="py-5">
                    <h1 class="top-question animate__animated animate__flash">
                      <?php get_template_part('partials/loader/loader-mini'); ?>
                    </h1>
                    <div class="top-precision"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card animate__animated animate__backInUp card-presentation-top-right">
            <div class="card-body rules-content">
              <div class="btn-cta-starttop">
                <div class="contenders-btn-block">
                  <div class="check-btn-block animate__animated" data-bs-toggle="modal" data-bs-target="#modalcontenders">
                    <div class="info-check">
                      Check les <span class="nb_contenders me-1 ms-1 nb_contenders_check_btn">-</span> contenders
                    </div>
                    <small class="text-muted">Tu pourras supprimer ceux que tu ne veux pas classer</small>
                  </div>
                  <div class="separate mt-3 mb-3"></div>
                </div>
                <div class="listingchoice">
                  <div id="choosenumbertop">
                    <div class="form-check choicetop1-bloc is_classik">
                      <div class="info-check">
                        Top 1
                      </div>
                      <small class="text-muted indication-nb-votes-top1 is_classik" data-weglot-translate="true">
                        <?php echo get_indication_nbvotes($top_number)["top1"]; ?>
                      </small>
                      <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="TopList avec un lot &agrave; gagner<br>pour le viewer qui devinera le mieux" class='va va-gift va-lg va-twitch-gift-game va-twitch-gift-game-typetop va-twitch-gift-game-typetop-1 d-none'></span>
                    </div>
                    <div class="form-check choicetop3-bloc is_classik">
                      <div class="info-check">
                        Top 3
                      </div>
                      <small class="text-muted indication-nb-votes-top3 is_classik" data-weglot-translate="true">
                        <?php echo get_indication_nbvotes($top_number)["top3"]; ?>
                      </small>
                      <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="TopList avec un lot &agrave; gagner<br>pour le viewer qui devinera le mieux" class='va va-gift va-lg va-twitch-gift-game va-twitch-gift-game-typetop va-twitch-gift-game-typetop-3 d-none'></span>
                    </div>
                    <div class="form-check choicetopcomplet-bloc is_classik mb-sm-3 mb-2">
                      <div class="info-check">
                        Complet
                      </div>
                      <small class="text-muted indication-nb-votes-complet is_classik" data-weglot-translate="true">
                        <?php echo get_indication_nbvotes($top_number)["topcomplet"]; ?>
                      </small>
                      <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="TopList avec un lot &agrave; gagner<br>pour le viewer qui devinera le mieux" class='va va-gift va-lg va-twitch-gift-game va-twitch-gift-game-typetop va-twitch-gift-game-typetop-complet d-none'></span>
                    </div>
                  </div>
                </div>
                <div class="choosecta">
                  <div class="cta-begin cta-top1">
                    <a href="#" id="begin_top1" data-type_top="top1" class="laucher_t btn-wording-rose btn-wording bubbly-button animate__jackInTheBox animate__animated">
                      <i class="fab fa-twitch twitch-icon-tbegin"></i>&nbsp;
                      <span class="cta-wording">Lancer mon Top 1</span>
                    </a>
                  </div>
                  <div class="cta-begin cta-top3">
                    <a href="#" id="begin_top3" data-type_top="top3" class="laucher_t btn-wording-rose btn-wording bubbly-button animate__jackInTheBox animate__animated">
                      <i class="fab fa-twitch twitch-icon-tbegin"></i>&nbsp;
                      <span class="cta-wording">Lancer mon Top 3</span>
                    </a>
                  </div>
                  <?php if($type_top == "sponso"): ?>
                    <?php if(!$participation_inscription_fin) : ?>
                      <div class="t-sponso-email-beginning">
                        <div>
                          <input type="email" placeholder="Ton email" name="t-sponso-email-input" id="t-sponso-email-input">
                          <input type="tel" class="d-none" placeholder="" name="t-sponso-tel-input" id="t-sponso-tel-input">
                        </div>
                          
                        <div class="form-check-inline accept-topsponso-terms">
                            <input class="form-check-input" type="checkbox" id="acceptTopSponsoTerms" value="acceptTerms">
                            <?php 
                            if(get_field('lien_vers_reglement_toplist', $id_top)){
                              $cgu_t_sponso = get_field('lien_vers_reglement_toplist', $id_top);
                            } else {
                              $cgu_t_sponso = "https://vainkeurz.com/ml/";
                            }
                            ?>
                            <label class="form-check-label" for="acceptTopSponsoTerms">J'accepte les <a href="<?= $cgu_t_sponso; ?>" target="_blank">CGU</a> </label>
                        </div>

                        <p class="t-sponso-email-alert d-none mt-3">
                          <i class="fa fa-exclamation-triangle me-1" aria-hidden="true"></i>
                          <span></span>
                        </p>
                      </div>
                    <?php endif; ?>

                    <div class="cta-begin cta-complet">
                      <a href="#" data-type_top="top3" class="laucher_t btn-wording-rose btn-wording bubbly-button animate__jackInTheBox animate__animated launcher_t_sponso">
                        <i class="fab fa-twitch twitch-icon-tbegin"></i>&nbsp;
                        <span class="cta-wording">Lancer ma TopList <br> pour tenter ma chance</span>
                      </a>
                    </div>
                  <?php else: ?>
                    <div class="cta-begin cta-complet">
                      <a href="#" id="begin_topcomplet" data-type_top="complet" class="laucher_t btn-wording-rose btn-wording bubbly-button animate__jackInTheBox animate__animated animate__delay-1s">
                        <i class="fab fa-twitch twitch-icon-tbegin"></i>&nbsp;
                        <span class="cta-wording">Lancer ma TopList</span>
                      </a>
                    </div>
                  <?php endif; ?>
                  <div class="cta-begin cta-finish">
                    <a href="#" id="begin_termine" class="laucher_finish_t btn-wording-rose btn-wording bubbly-button animate__jackInTheBox animate__animated">
                      <i class="fab fa-twitch twitch-icon-tbegin"></i>&nbsp;
                      <span class="cta-wording">Continuer ma TopList</span>
                    </a>
                    <div class="mt-2 text-center box-recommencer recommencer-presentation-top ">
                      <a href="#" class="btn-wording confirm_delete w-100" data-urltop="" data-toplistid="" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0">
                        <span class="va va-recommencer va-lg"></span> Recommencer
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- // TOP PAS LANCÉ -->

  <!-- TOP LANCÉ -->
  <div class="top_started z9 t-normal-container">
    <div class="tournoi-content-final">
      <div class="row">
        <div class="col-md-12">
          <div class="container">
            <div class="tournament-heading-top">
              <div class="logo-sponso-marqueblanche"></div>
              <div class="t-titre-tournoi top-title-question"></div>
            </div>
            <div class="row">
              <div class="col">
                <div class="display_battle">
                  <div class="row align-items-center justify-content-center contenders-containers battle-marqueblanche">
                    <div class="col-sm-5 col-12">
                      <div class="bloc-contenders link-contender_1 contender_1 cover_contenders link-contender">
                        <div class="contenders_min contender_zone animate__animated" data-idwinner="" data-idlooser="" id="c_1">
                          <div class="illu">
                            <img id="cover_contender_1" src="" alt="" class="img-fluid contender-1-votes-twitch">
                          </div>
                          <h2 id="name_contender_1" class="title-contender"></h2>
                          <p class="voicevote_contender_1 d-none">🎤</p>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="versus-container d-flex flex-column">

                        <div class="xp-notification-container d-flex align-items-center">
                          <div class="xp-notification">
                            <span class="char">+</span>
                            <span class="char">1</span>
                            <span class="char ms-1">X</span>
                            <span class="char">P</span>
                            <span class="char ms-2">
                              <span class="va-mush va va-lg"></span>
                            </span>
                          </div>
                        </div>

                        <h4 class="text-center versus">
                          <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/versus.png" alt="" class="img-fluid">
                        </h4>

                      </div>
                    </div>

                    <div class="col-sm-5 col-12">
                      <div class="bloc-contenders link-contender_2 contender_2 cover_contenders link-contender">
                        <div class="contenders_min contender_zone animate__animated" data-idwinner="" data-idlooser="" id="c_2">
                          <div class="illu">
                            <img id="cover_contender_2" src="" alt="" class="img-fluid contender-2-votes-twitch">
                          </div>
                          <h2 id="name_contender_2" class="title-contender"></h2>
                          <p class="voicevote_contender_2 d-none">🎤</p>
                        </div>
                      </div>
                    </div>

                    <div class="devine-votes-steps">
                      <div class="d-flex">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/wrapped-gift_1f381.png" alt="Manga Image">

                        <div>
                          <p class="subtitle-devine-vote">Devine 10 fois le choix de ton duo pour gagner</p>
                          <h4 class="title-devine-vote">Une récompense</h4>

                          <div class="outer-progress-bar">
                            <div class="inner-progress-bar"></div>
                            <div class="text-progress-bar"><span class="steps-progress-bar">0</span> sur 10</div>
                          </div>
                        </div>
                      </div>
                      <div class="perdu-btn-block">
                        <a href="#" class="btn-slim perdu-btn">
                          <span class="cta-wording">C'est perdu</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- // TOP LANCÉ -->
</div>

<div class="stepbarcontent">
  <div class="stepbar">
    <div class="stepbar-content">
      <span class="stepbar-number"></span>
    </div>
  </div>
</div>

<!-- CONTENDERS MODAL -->
<div class="modal animate__animated animate__swing" id="modalcontenders" tabindex="-1" aria-labelledby="swinganimationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="list-contenders">
          <div class="d-flex align-items-center justify-content-center mt-1 mb-3 flex-column">
            <div class="d-flex align-items-center justify-content-center">
              <h3 class="text-center">Les <span class="nb_contenders"></span> contenders</h3>
              <div class="versus-contenders">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/versus.png" class="img-fluid" alt="">
              </div>
            </div>
            <br>
            <p class="alert-two-contenders d-none">N'hésite pas de laisser au min deux contenders pour faire ton vote <span class="va va-cheese1 va-lg"></span> </p>
          </div>
          <div class="row align-items-center justify-content-center list-contenders-items">
            <div class="text-center">
              <?php get_template_part('partials/loader/loader-mini'); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex align-items-center justify-content-center">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Refermer</button>
        <button type="button" class="btn btn-dark btn-reset-contenders d-none">Remettre Tout</button>
      </div>
    </div>
  </div>
</div>
<!-- // CONTENDERS MODAL -->

<!-- Offcanvas -->
<?php get_template_part('partials/loader/recommencer'); ?>
<?php get_template_part('partials/loader/perdu'); ?>
<?php get_template_part('partials/loader/loader-top'); ?>
<?php get_template_part('partials/loader/loader-top-step1'); ?>
<?php get_template_part('partials/loader/loader-toplist-initial'); ?>
<!-- /Offcanvas -->

<div class="modal fade" id="modalClassementMondial" tabindex="-1" aria-labelledby="modalClassementMondialLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center justify-content-center p-3">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Refermer le classement mondial</button>
      </div>
      <div class="modal-body p-0">
        <iframe id="classementMondialIframe" src="" width="100%" style="height: 98vh; border: none;"></iframe>
      </div>
    </div>
  </div>
</div>

<script>

  document.addEventListener('DOMContentLoaded', (event) => {

    if(wp_user_logged_in == "true") {
      console.log("wp_user_logged_in is true");
      document.querySelector('.perdu-btn').addEventListener('click', (event) => {
        event.preventDefault();
        
        const waiterPerdu = document.querySelector('.waiter-perdu');
        waiterPerdu.style.display = 'block';
        
        fetch(SITE_BASE_URL + "wp-content/themes/t-vkrz/function/tuya/make_fail.php", {
          method: "POST",
        })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            console.log("✅ Réponse Tuya :", data);
          } else {
            console.error("❌ Erreur Tuya :", data.msg || data.code);
          }
        })
        .catch((err) => {
          console.error("❌ Erreur réseau :", err);
        });
      });
      document.querySelector('.continuer-btn').addEventListener('click', (event) => {
        event.preventDefault();
        
        const waiterPerdu = document.querySelector('.waiter-perdu');
        waiterPerdu.style.display = 'none';
        
        fetch(SITE_BASE_URL + "wp-content/themes/t-vkrz/function/tuya/make_initial.php", {
          method: "POST",
        })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            console.log("✅ Réponse Tuya :", data);
          } else {
            console.error("❌ Erreur Tuya :", data.msg || data.code);
          }
        })
        .catch((err) => {
          console.error("❌ Erreur réseau :", err);
        });
      });
    }

    if(Boolean(isMobile)) {
      localStorage.removeItem('resumeTwitchGame');
      localStorage.removeItem('twitchGameMode');
    }
    SQL_checkTopList(id_top, uuid_user)
      .then(result => {
        const topList_id = result.toplistId;
        if (topList_id != 0) {
          if (result.isDone == true) {
            window.location.href = SITE_BASE_URL + "toplist/<?php echo $slug_top; ?>/" + topList_id + "/";
          } else {
            var elementtoplistexists = document.querySelectorAll(".toplistexists");
            elementtoplistexists.forEach(function (element) { element.style.display = "block"; });
            id_topList = topList_id;
            document.querySelectorAll('.confirm_delete').forEach(btn => btn.setAttribute('data-toplistid', topList_id));
            document.querySelectorAll(".laucher_finish_t").forEach(btn => btn.setAttribute('data-toplistid', topList_id))
            is_beginned = true;
          }
        }
        get_top_info(id_top, 'complet')
          .then(async data => {
            if (data) {
              topInfo = data;
              const {
                top_id,
                top_url,
                top_cat,
                top_cat_icon,
                top_title,
                top_question,
                top_precision,
                top_number,
                top_type,
                top_img,
                top_cover,
                top_d_titre,
                top_d_rounded,
                top_d_cover,
                top_date,
                top_status,
                is_toplist_type_youtube_videos,
                toplist_mondiale,
                creator_infos,
              } = data;
              is_toplist_type_youtube_videos_var = is_toplist_type_youtube_videos;

              function updateVoteIndicationsAndDisplay(top_number, isStarted = false) {
                let topTitleElements         = document.querySelectorAll('.top-title');
                let topBlocElements          = document.querySelectorAll('.title-win');
                let topQuestionElements      = document.querySelectorAll('.top-question');
                let topTitreQuestionElements = document.querySelectorAll('.top-title-question');
                let topPrecisionElements     = document.querySelectorAll('.top-precision');
                
                topTitleElements.forEach(element => { element.innerHTML = `TopList <div class="weglot-div-span">${top_title}</div>`; });
                topBlocElements.forEach(element => { element.style.display = "block"; });
                topTitreQuestionElements.forEach(element => { element.innerHTML = `<h2>TopList <div class="weglot-div-span">${top_title}</div></h2><h1>${top_question}</h1>`; });
                topQuestionElements.forEach(element => { element.innerHTML = top_question; });
                topPrecisionElements.forEach(element => { element.innerHTML = top_precision; });

                if(!is_beginned){
                  updateNBcontenders(top_number);
                  let getRankingContenders = JSON.parse(sessionStorage.getItem(`contenders_${id_top}`));
                  if(getRankingContenders){ sessionStorage.removeItem(`contenders_${id_top}`); }
                }
              }

              let classikElements  = document.querySelectorAll('.is_classik');
              let sponsoElements   = document.querySelectorAll('.is_sponso');
              document.querySelectorAll('.confirm_delete').forEach(btn => btn.dataset.urltop = top_url)
              document.querySelector('body').style.backgroundImage = `url('${transformFirebaseStorageUrl(top_cover, 2500)}')`;
              document.querySelector('.meetup-img-wrapper').style.backgroundImage = `url('${transformFirebaseStorageUrl(top_img, 700)}')`;
              let laucher_btn = document.querySelectorAll('.laucher_t');
              laucher_btn.forEach(function(element) { element.dataset.uuid_creator = creator_infos.data_user.uuid_user; });

              

              if (is_beginned == true) {
                
                if(document.querySelector('.cta-finish')) {
                  document.querySelector('.cta-finish').dataset.toplistid = id_topList;
                  document.querySelector('.cta-finish').classList.add('d-block');
                }
                if(document.querySelector('#choosenumbertop'))
                  document.querySelector('#choosenumbertop').style.display   = "none";
                if(document.querySelector('.cta-complet'))
                  document.querySelector('.cta-complet').style.display       = "none";
                if(document.querySelector('.tobeginchoosesize'))
                  document.querySelector('.tobeginchoosesize').style.display = "none";
                topListData      = await SQL_getTopList(id_topList);
                contendersInJson = JSON.parse(topListData.toplist_info.ranking).map(c => c.id_wp.toString());
                  if(document.querySelector('.contender_item_'))
                  document.querySelectorAll('[class*="contender_item_"]').forEach(element => {
                    let contenderId = element.className.split('_').pop();
                    if (!contendersInJson.includes(contenderId)) 
                      element.remove();
                  });
                document.querySelectorAll(".nb_contenders").forEach(element => {
                  element.innerHTML = contendersInJson.length;
                });
                if(document.querySelector('.small_contenders'))
                  document.querySelector('.small_contenders').innerHTML = "Tes choix de";
                updateVoteIndicationsAndDisplay(contendersInJson.length, true)
              } 
              else {
                if(document.querySelector('.contenders-btn-block'))
                  document.querySelector('.contenders-btn-block').classList.add('d-block');
                  if(document.querySelector('.contenders-btn-block .check-btn-block'))
                  document.querySelector('.contenders-btn-block .check-btn-block').classList.add('animate__flipInY');
                updateVoteIndicationsAndDisplay(top_number);
              }
              if (top_type == "sponso") {
                classikElements.forEach(function(element) { element.style.display = "none"; });
                sponsoElements.forEach(function(element)  { element.style.display = "block"; });
              }
              if (top_status != "valide") {
                if(document.querySelector('.card-cta'))
                  document.querySelector('.card-cta').style.display = "none";
                if(document.querySelector('.twitch-possible'))
                  document.querySelector('.twitch-possible').style.display = "none";
              }
              document.querySelector('#waiter-top-step1').classList.add('d-none');
            }
          });
      })
      .catch(error => {
        console.error('Error in fetchData:', error);
      });

    if(document.querySelector('.wording-tirage')) {
      document.querySelector('.wording-tirage').textContent = "Prochain tirage au sort";
    }

    if(isTopSponsoWhiteLabel && isTopSponsoWhiteLabel == true) { // LIKE FIGMA DESIGN TREATMENT
      if(document.querySelector('.lot-offert-par'))
        document.querySelector('.lot-offert-par').classList.add('d-none');

      if(document.querySelector('.d-cadeau')) {
        const cadeauContainer = document.querySelector('.d-cadeau');
        const cadeauTextPart  = cadeauContainer.querySelector('.col-7');
        const cadeauImgPart   = cadeauContainer.querySelector('.col-5');

        cadeauImgPart.classList.add('d-none');
        cadeauTextPart.className = "col";
      }

      document.querySelector('.card-top-presentation').classList.remove('eh1');
      document.querySelector('.card-presentation-top-right').classList.remove('eh1');
    }

    // Select all '.form-check' elements
    var formChecks = document.querySelectorAll(".form-check");

    // Function to hide all cta elements
    function hideAllCtaElements() {
      document.querySelectorAll(".cta-begin").forEach(function (cta) {
        cta.style.display = "none";
      });
    }

    // Function to remove 'choice-mode-top-actif' from all form-checks
    function removeActiveClassFromAllFormChecks() {
      formChecks.forEach(function (fc) {
        fc.classList.remove("choice-mode-top-actif");
      });
    }

    // Add a click event listener to each form-check element
    formChecks.forEach(function (formCheck) {
      formCheck.addEventListener("click", function () {
        // Hide all cta elements initially
        hideAllCtaElements();

        // Remove 'choice-mode-top-actif' class from all form-checks
        removeActiveClassFromAllFormChecks();

        // Add 'choice-mode-top-actif' class to the clicked form-check
        formCheck.classList.add("choice-mode-top-actif");

        // Check which form-check was clicked and show the corresponding cta element
        if (formCheck.classList.contains("choicetop1-bloc")) {
          document.querySelector(".cta-top1").style.display = "block";
        } else if (formCheck.classList.contains("choicetop3-bloc")) {
          document.querySelector(".cta-top3").style.display = "block";
        } else if (formCheck.classList.contains("choicetopcomplet-bloc")) {
          document.querySelector(".cta-complet").style.display = "block";
        }
      });
    });

    var startButton = document.querySelector(".btnstarttwitch");

    // Find the element that needs to be shown or hidden
    var contentButtons = document.querySelector(
      ".modes-jeu-twitch__content-btns"
    );

    if(startButton){
      startButton.addEventListener("click", function () {
        if (
          contentButtons.style.display === "none" ||
          contentButtons.style.display === ""
        ) {
          contentButtons.style.display = "block";
          startButton.style.display = "none"; // Hide the start button
        } else {
          contentButtons.style.display = "none";
          startButton.style.display = "block"; // Show the start button
        }
      });
    }

    var choicetopcomplet = document.querySelector(".choicetopcomplet-bloc");
    if(choicetopcomplet){
      choicetopcomplet.classList.add("choice-mode-top-actif");
    }
    var ctaComplet = document.querySelector(".cta-complet");
    if(ctaComplet){
      ctaComplet.style.display = "block";
    }

    document.getElementById("modalcontenders").addEventListener("shown.bs.modal", function () {
      if (!contendersLoaded) {
        loadContenders(id_top);
        contendersLoaded = true;
      }
    });

    // Select the .card-top-presentation element
    var cardTopPresentation = document.querySelector('.card-top-presentation');

    // Get the height of the .card-top-presentation element
    var cardTopHeight = cardTopPresentation.offsetHeight + 50; // This includes padding and border

    // Select the .list-contenders element
    var listContenders = document.querySelector('.list-contenders-hidden');

    // Apply the height to the .list-contenders element
    if (listContenders) {
      listContenders.style.height = cardTopHeight + 'px';
    }
    // Get the element with the 'min-tournoi' class
    var minTournoi = document.querySelector('.top_not_started');

    // Extract the data-color value
    var color = minTournoi.getAttribute('data-color');

    // Apply color to H5
    var h5 = minTournoi.querySelector('.agagner h5');
    if (h5) {
      h5.style.color = color;
    }

    // Apply background color to .titrewin
    var titrewin = minTournoi.querySelector('.titrewin');
    if (titrewin) {
      titrewin.style.backgroundColor = color;
    }
    var ctamain = minTournoi.querySelector('.btn-cta-participer');
    if (ctamain) {
      ctamain.style.backgroundColor = color;
    }

    // Apply box-shadow to img
    var img = minTournoi.querySelector('img');
    if (img) {
      img.style.boxShadow = `0 0 10px ${color}`;
    }

    const textes = ["Activation de l'algo ELO", "Génération du premier VERSUS"];
    let indexTexte = 0;

    setInterval(() => {
      // Sélectionner tous les éléments avec la classe 'ma-classe'
      const elements = document.querySelectorAll('.text-lancement-toplist');

      // Mettre à jour le texte de chaque élément
      elements.forEach(element => {
        element.textContent = textes[indexTexte];
      });

      // Mettre à jour l'index pour le prochain texte
      indexTexte = (indexTexte + 1) % textes.length;
    }, 1500); // 2000 millisecondes = 2 secondes
    
    const textes_1 = ["Calcul du nombres de votes", "Rassemblement des contenders"];
    let indexTexte_1 = 0;
    setInterval(() => {
      // Sélectionner tous les éléments avec la classe 'ma-classe'
      const elements = document.querySelectorAll('.text-lancement-top-step1');

      // Mettre à jour le texte de chaque élément
      elements.forEach(element => {
        element.textContent = textes_1[indexTexte_1];
      });

      // Mettre à jour l'index pour le prochain texte
      indexTexte = (indexTexte + 1) % textes.length;
    }, 1500); // 2000 millisecondes = 2 secondes

    // Handle iframe src update when modal is shown
    const modalClassementMondial = document.getElementById('modalClassementMondial');
    if (modalClassementMondial) {
      modalClassementMondial.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const iframe = document.getElementById('classementMondialIframe');
        const topListMondialUrl = topInfo?.toplist_mondiale + "?dontshowmenu=true" || '';
        iframe.src = topListMondialUrl;
      });
      
      // Clear iframe src when modal is hidden to prevent continued audio/video playback
      modalClassementMondial.addEventListener('hidden.bs.modal', function (event) {
        const iframe = document.getElementById('classementMondialIframe');
        iframe.src = '';
      });
    }
    var showShareTopButtons = document.querySelectorAll('.showsharetop');
    showShareTopButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            this.style.display = 'none';
            var shareTopElements = document.querySelectorAll('.sharetop');
            shareTopElements.forEach(function(element) {
                element.style.display = 'block';
            });
        });
    });
  });
</script>
<?php get_footer(); ?>