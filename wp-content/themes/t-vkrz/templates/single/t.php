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
                  <div class="mt-3">
                    <?php if($type_top != "sponso"): ?>
                      <div class="title-win">
                        <h2>
                          <span class="top-title"></span>
                        </h2>
                      </div>
                    <?php endif; ?>
                    <h1 class="top-question animate__animated animate__flash">
                      <?php get_template_part('partials/loader/loader-mini'); ?>
                    </h1>
                    <div class="top-precision"></div>
                  </div>
                  <div class="separate separate-sponso mt-4 mb-2"></div>
                  <div class="info-top-footer">
                    <?php if($type_top != "sponso"): ?>
                      <div class="row meetings align-items-center">
                        <div class="col-md-6">
                          <div class="vainkeur-card"></div>
                        </div>
                        <div class="col-md-6">
                          <!-- Classement mondial + Share -->
                          <div id="share-and-check-toplist-mondial">
                            <div class="btn-actions-toplist">
                              <a href="#" class="btn-wording toplistmondialurl" data-bs-toggle="modal" data-bs-target="#modalClassementMondial">
                                <span class="va va-globe va-lg"></span> Découvre le classement mondial
                              </a>
                            </div>
                            <div class="btn-actions-toplist">
                              <a class="btn-wording showsharetop">
                                <span class="va va-megaphone va-lg"></span> Partage la TopList
                              </a>
                              <div class="sharetop w-100">
                                <ul class="reseau-share d-flex align-items-center justify-content-arround w-100">
                                  <li>
                                    <a href="" class="share-tw btn-wording" target="_blank" title="Tweet" style="background:#000000;">
                                      <i class="social-media fa-brands fa-x-twitter" aria-hidden="true"></i>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="" data-action="share/whatsapp/share" class="share-wa btn-wording" style="background:#55E863;">
                                      <i class="social-media fab fa-whatsapp" aria-hidden="true"></i>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="" title="Partager sur Facebook" target="_blank" class="share-fb btn-wording" style="background:#0B66FE;">
                                      <i class="social-media fab fa-facebook-f" aria-hidden="true"></i>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="#" data-link="<?= $url_top; ?>" data-textafter="✅" class="btn-wording copy-button copy-topurl" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Copier le lien de la TopList" style="font-size:0.8rem;">
                                      <span class="va va-link va-md m-0 va-2x"></span>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php else: ?>
                      <div class="infos-card-t d-flex align-items-center">
                        <div class="me-2">
                          <span class="ico va va-chance va-2x"></span>
                        </div>
                        <div class="info-numbers">
                          <small class="text-muted wording-tirage">... ⏳ ...</small>
                          <?php if(get_field("fin_de_la_sponso_t_sponso_decalage", $id_top)) : ?>
                            <h4>
                              <?= the_field('fin_de_la_sponso_t_sponso_decalage', $id_top); ?>
                            </h4>
                          <?php elseif(get_field("top_permanent_topsponso", $id_top)): ?>
                            <h4 class="top-permanent-checking-date">
                              ... ⏳ ...
                            </h4>
                          <?php else: ?>
                            <h4>
                            <?= the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
                            </h4>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card animate__animated animate__backInUp card-presentation-top-right">
            <div class="card-body rules-content">
              <?php if($type_top == "sponso"): ?>
                <div class="lot-whitelabel d-none">
                  <img src="<?= wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large', false); ?>" alt="">
                </div>
                <div class="agagner">
                  <div class="d-cadeau row">
                    <div class="col-7">
                      <span class="titrewin">
                        À gagner <span class="va va-finger-down va-lg"></span>
                      </span>
                      <h5>
                        <?= the_field('titre_de_la_sponso_t_sponso', $id_top); ?>
                      </h5>
                      <div class="text-rules">
                        <?php the_field('description_t_sponso', $id_top); ?>
                      </div>
                    </div>
                    <div class="col-5">
                      <img src="<?= wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large', false); ?>" alt="">
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              <div class="btn-cta-starttop">
                <?php if($etat_top == "valide"): ?>
                  <div class="<?php echo $hide_if_sponso; ?>">
                    <div class="twitch-possible d-none">
                      <div class="modes-jeu-twitch d-none d-sm-block">
                        <button class="btnstarttwitch" type="button">
                          Choix des modes Twitch
                          <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="TopList avec un lot &agrave; gagner<br>pour le viewer qui devinera le mieux" class='va va-gift va-lg va-twitch-gift-game d-none'></span>
                        </button>
                        <div class="modes-jeu-twitch__content-btns">
                          <button type="button" id="votePrediction" class="mb-2 btn btn-gradient-primary modeGameTwitchBtn">
                            <div>
                              <span class="va va-skull va-lg"></span> Battle Royale
                            </div>
                            <small class="text-muted">Le viewer qui devine tous tes choix triomphe</small>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="TopList avec un lot &agrave; gagner<br>pour le viewer qui devinera le mieux" class='va va-gift va-lg va-twitch-gift-game d-none'></span>
                          </button>
                          <button type="button" id="votePoints" class="btn btn-gradient-primary modeGameTwitchBtn mb-2">
                            <div>
                              <span class="va va-hundred va-lg"></span> Championnat
                            </div>
                            <small class="text-muted">Le viewer qui devine le plus sera le gagnant</small>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="TopList avec un lot &agrave; gagner<br>pour le viewer qui devinera le mieux" class='va va-gift va-lg va-twitch-gift-game d-none'></span>
                          </button>
                          <button type="button" id="voteParticipatif" class="btn btn-gradient-primary modeGameTwitchBtn">
                            <div><span class="va va-heart-hands va-lg"></span> Communauté</div>
                            <small class="text-muted">Tu vois la jauge des votes des viewers</small>
                          </button>
                        </div>
                        <div class="separate mt-3 mb-3"></div>
                      </div>
                    </div>
                    <div class="contenders-btn-block">
                      <div class="check-btn-block animate__animated" data-bs-toggle="modal" data-bs-target="#modalcontenders">
                        <div class="info-check">
                          Check les <span class="nb_contenders me-1 ms-1 nb_contenders_check_btn">-</span> contenders
                        </div>
                        <small class="text-muted">Tu pourras supprimer ceux que tu ne veux pas classer</small>
                      </div>
                      <div class="separate mt-3 mb-3"></div>
                    </div>
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
                              <label class="form-check-label" for="acceptTopSponsoTerms">J’accepte les <a href="<?= $cgu_t_sponso; ?>" target="_blank">CGU</a> </label>
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
                <?php elseif($etat_top == "validation"): ?>
                  <div class="badge bg-label-warning py-3 w-100 mb-2">
                    La TopList est en cours de validation
                  </div>
                  <small class="text-muted">
                    Quelqu'un de l'ékipe VAINKEURZ va l'examiner et te faire un retour
                  </small>
                <?php elseif($etat_top == "creation"): ?>
                  <div class="badge bg-label-info py-3 w-100 mb-2">
                    La TopList est toujours en création
                  </div>
                  <small class="text-muted">
                    Depuis le listing de tes TopList, tu peux demander sa validation pour qu'il soit publié !
                  </small>
                <?php elseif($etat_top == "refuse"): ?>
                  <div class="badge bg-label-danger py-3 w-100 mb-2">
                    La TopList a été refusée
                  </div>
                  <small class="text-muted">
                    Tu as du recevoir un message pour t'informer de la raison du refus. Tu peux aussi nous demander directement sur notre Discord !
                  </small>
                <?php elseif($etat_top == "archive"): ?>
                   <div class="badge bg-label-dark py-3 w-100 mb-2">
                    La TopList a été archivée
                  </div>
                <?php endif; ?>
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
              <?php if($type_top != "sponso"): ?>
                <div class="t-titre-tournoi top-title-question"></div>
              <?php else: ?>
                <div class="logo-sponso-marqueblanche"></div>
                <div class="t-titre-tournoi top-title-question"></div>
              <?php endif; ?>
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

                    <?php if (!isMobile()) : ?>
                      <div class="vote-byvoice-container d-none">
                        
                        <div id="meter">
                          <div id="level"></div>
                        </div>
                        <p><span id="volume">0</span></p>
                        <p><span id="maxVolume">0</span></p>
                        <div class="buttons">
                          <button class="" onclick="start('contender_1')">#1</button>
                          <button class="btn btn-label-danger" onclick="stop()">Stop</button>
                          <button class="btn btn-label-primary" onclick="reset()">Init</button>
                          <button class="" onclick="start('contender_2')">#2</button>
                        </div>

                        <div id="results"></div>

                        <script>
                          let audioContext;
                          let analyser;
                          let microphone;
                          let javascriptNode;
                          let maxVolume = 0;
                          let currentContender = null;
                          let contender1Volume = 0;
                          let contender2Volume = 0;

                          function start(contender) {
                            currentContender = contender;
                            navigator.mediaDevices.getUserMedia({ audio: true })
                              .then(function(stream) {
                                audioContext = new (window.AudioContext || window.webkitAudioContext)();
                                analyser = audioContext.createAnalyser();
                                microphone = audioContext.createMediaStreamSource(stream);
                                javascriptNode = audioContext.createScriptProcessor(2048, 1, 1);

                                analyser.smoothingTimeConstant = 0.8;
                                analyser.fftSize = 1024;

                                microphone.connect(analyser);
                                analyser.connect(javascriptNode);
                                javascriptNode.connect(audioContext.destination);

                                javascriptNode.onaudioprocess = function() {
                                  let array = new Uint8Array(analyser.frequencyBinCount);
                                  analyser.getByteTimeDomainData(array);

                                  let sum = 0;
                                  for (let i = 0; i < array.length; i++) {
                                    let value = (array[i] / 128) - 1;
                                    sum += value * value;
                                  }
                                  let rms = Math.sqrt(sum / array.length);

                                  // Normalize RMS to a 0-100 scale
                                  let volume = Math.min(Math.max(rms * 100, 0), 100);

                                  document.getElementById('volume').innerText = volume.toFixed(2);

                                  // Adjust the height of the level bar
                                  document.getElementById('level').style.height = volume + '%';

                                  // Change bar color based on volume
                                  if (volume > 70) {
                                    document.getElementById('level').style.backgroundColor = 'red';
                                  } else if (volume > 40) {
                                    document.getElementById('level').style.backgroundColor = 'yellow';
                                  } else {
                                    document.getElementById('level').style.backgroundColor = '#76ff03';
                                  }

                                  // Check if the current volume is the new maximum
                                  if (volume > maxVolume) {
                                    maxVolume = volume;
                                    document.getElementById('maxVolume').innerText = maxVolume.toFixed(2);
                                  }
                                }
                              })
                              .catch(function(err) {
                                console.error(err);
                                alert('Erreur d\'accès au microphone : ' + err.message);
                              });
                          }

                          function stop() {
                            if (microphone) {
                              microphone.disconnect();
                            }
                            if (analyser) {
                              analyser.disconnect();
                            }
                            if (javascriptNode) {
                              javascriptNode.disconnect();
                            }
                            if (audioContext) {
                              audioContext.close();
                            }
                          }

                          function reset() {
                            stop();
                            document.getElementById('volume').innerText = '0';
                            document.getElementById('level').style.height = '0%';
                            document.getElementById('level').style.backgroundColor = '#76ff03';
                            maxVolume = 0;
                            contender1Volume = 0;
                            contender2Volume = 0;
                            document.getElementById('maxVolume').innerText = '0';
                            document.querySelector('.voicevote_contender_1').innerText = '🎤';
                            document.querySelector('.voicevote_contender_2').innerText = '🎤';
                            document.querySelector('.link-contender_1').style.transform = "scale(1)";
                            document.querySelector('.link-contender_2').style.transform = "scale(1)";
                          }

                          if(document.querySelector('.link-contender')) {
                            document.querySelectorAll(".link-contender").forEach(el => {
                              el.addEventListener('click', function() {
                                reset();
                              });
                            })
                          }

                          function newSession(contender) {
                            stop();
                            if (maxVolume > 0) {
                              if (contender === 'contender_1') {
                                contender1Volume = maxVolume;
                                document.querySelector('.voicevote_contender_1').innerText = `Volume Max : ${maxVolume.toFixed(2)} dB`;
                              } else if (contender === 'contender_2') {
                                contender2Volume = maxVolume;
                                document.querySelector('.voicevote_contender_2').innerText = `Volume Max : ${maxVolume.toFixed(2)} dB`;
                              }

                              if (contender1Volume > contender2Volume) {
                                document.querySelector('.link-contender_1').style.transform = "scale(1.05)";
                                document.querySelector('.link-contender_2').style.transform = "scale(0.95)";
                                const contender1Element = document.querySelector('.voicevote_contender_1');
                                if (!contender1Element.innerHTML.includes('<span class="va-pouce-up va va-lg"></span>')) {
                                  contender1Element.innerHTML += ` <span class="va-pouce-up va va-lg"></span>`;
                                }
                                const contender2Element = document.querySelector('.voicevote_contender_2');
                                contender2Element.innerHTML = contender2Element.innerHTML.replace(` <span class="va-pouce-up va va-lg"></span>`, '');
                              } else if (contender2Volume > contender1Volume) {
                                document.querySelector('.link-contender_2').style.transform = "scale(1.05)";
                                document.querySelector('.link-contender_1').style.transform = "scale(0.95)";
                                const contender2Element = document.querySelector('.voicevote_contender_2');
                                if (!contender2Element.innerHTML.includes('<span class="va-pouce-up va va-lg"></span>')) {
                                  contender2Element.innerHTML += ` <span class="va-pouce-up va va-lg"></span>`;
                                }
                                const contender1Element = document.querySelector('.voicevote_contender_1');
                                contender1Element.innerHTML = contender1Element.innerHTML.replace(` <span class="va-pouce-up va va-lg"></span>`, '');
                              }
                            }
                            maxVolume = 0;
                            document.getElementById('volume').innerText = '0';
                            document.getElementById('maxVolume').innerText = '0';
                            document.getElementById('level').style.height = '0%';
                            document.getElementById('level').style.backgroundColor = '#76ff03';
                          }
                        </script>
                      </div>
                    <?php endif; ?>

                    <?php if (!isMobile()) : ?>
                      <div class="devine-votes-steps d-none">
                        <img src="https://vainkeurz.com/wp-content/uploads/2024/03/manga.png" alt="Manga Image">

                        <div>
                          <p class="subtitle-devine-vote">Devine 10 fois le choix de ton duo pour gagner</p>
                          <h4 class="title-devine-vote">Un abonnement à Mangas.io !</h4>

                          <div class="outer-progress-bar">
                            <div class="inner-progress-bar"></div>
                            <div class="text-progress-bar"><span class="steps-progress-bar">0</span> sur 10</div>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>

                  <?php if (!isMobile()) : ?>
                    <div class="d-none twitch-votes-container row align-items-center justify-content-center">
                      <div class="row">
                        <div class="col col-sm-4 w-100 d-flex justify-content-evenly align-items-center">
                          <div class="taper-container animate__animated animate__slideInDown">
                            <div class="votes-container">
                              <p>Tapez 1</p>
                              <div class="votes-stats taper-zone d-none" id="votes-stats-1">
                                <p class="votes-percent" id="votes-percent-1">0%</p>
                              </div>
                            </div>
                          </div>
                          <div class="votes-stats-container d-none">
                            <p class="votes-stats-p">
                              <strong class="votes-number">0</strong> <span class="votes-number-wording">Vote</span> du chat
                            </p>
                            <p>
                              <strong class="votes-number-total">0</strong> votes depuis le début
                            </p>
                          </div>
                          <div class="taper-container animate__animated animate__slideInUp">
                            <div class="votes-container">
                              <p>Tapez 2</p>
                              <div class="votes-stats taper-zone d-none" id="votes-stats-2">
                                <p class="votes-percent" id="votes-percent-2">0%</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 col-12"></div>
                      </div>
                    </div>
                    <div class="twitchGamesWinnerContainer">
                      <span class="twitchGamesWinnerName confetti"></span>
                      <div class="buttons">
                        <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0" href="#" class="confirm_deletee btn btn-sm btn-outline-dark waves-effect me-2"> Relancer</a>
                        <a href="#" class="btn btn-sm btn-outline-primary waves-effect" id="winner-continuer"> Continuer</a>
                      </div>
                    </div>
                    <audio id="winner-sound" style="display: none; width: 0 !important;">
                      <source src="<?php bloginfo('template_directory'); ?>/assets/audios/winner-sound.mp3" type="audio/mpeg" />
                    </audio>
                    <div class="twitch-overlay d-none">

                      <div class="twitch-gift-container d-none">
                        <div class="card card-twitch-gift">
                          <div class="card-header">
                            <h3>
                              Liste des Lots à gagner<br>
                              pour le meilleur viewer
                            </h3>

                            <span class="va-gift va va-z-85"></span>
                          </div>
                          <div class="card-body">
                            <table class="table table-twitch-gift">
                                <thead>
                                    <th>Lots à gagner</th>
                                    <th>Participants</th>
                                </thead>

                                <tbody>
                                </tbody>

                                <caption>
                                  <div class="d-flex">
                                    <span class="va-gem va va-z-40"></span>
                                    <p>
                                      Les KEURZ seront crédités sur le compte VAINKEURZ du gagnant et donne accès à des lots dont des cartes et goodies.
                                    </p>
                                  </div>
                                </caption>
                            </table>   
                          </div>
                        </div>
                      </div>

                      <div>
                        <h4>Lancement du jeu dans</h4>
                        <div id="countdown">
                          <div class="counter-for-twitch">
                            <div class="nums">
                              <?php
                              $environment = env();
                              $initial_in  = ($environment == "local") ? 12 : 59;
                              $initial_i   = ($environment == "local") ? 11 : 58;
                              ?>
                              <span class="in"><?= $initial_in; ?></span>
                              <?php for ($i = $initial_i; $i >= 0; $i--) : ?>
                                <span><?= $i; ?></span>
                              <?php endfor; ?>
                            </div>
                            <h4>Taper "TopList" dans le chat <br> pour participer!</h4>
                          </div>
                          <div class="final flex-column-reverse">
                            <button type="button" id="launchGameBtn" class="btn btn-lg waves-effect btn-outline-danger" spellcheck="true">
                              Lancer le jeu
                            </button>

                            <button type="button" id="reloadGameBtn" class="btn btn-lg waves-effect btn-outline-danger d-none" spellcheck="true">
                              Recharger la TopList
                            </button>
                          </div>
                        </div>
                        <span class="mode-alert"><i class="fas fa-info-circle"></i> Il faut au moins deux participants</span>
                        <div id="participants-overlay" class="mt-2 text-white d-none" data-content="Participants :"></div>
                      </div>

                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <?php if (!isMobile()) : ?>
                <div id="prediction-player" class="col-md-3 col-12 d-none">
                  <div class="card mb-2" id="participants">
                    <div class="card-header flex-column align-items-start">
                      <h4 class="card-title">
                        <i class="fab fa-twitch"></i> <strong class="prediction-participants-votey-nbr">0</strong> de <strong class="prediction-participants">0</strong> participants ont voté
                      </h4>
                      <h4 class="card-title elimines d-none"></h4>
                    </div>
                    <div class="card-body">
                    </div>
                  </div>
                </div>
                <div id="ranking-player" class="col-md-3 col-12 d-none">
                  <h4 class="card-title">
                    <i class="fab fa-twitch"></i> <strong class="points-participants-votey-nbr">0</strong> de <strong class="points-participants">0</strong> participants ont voté
                  </h4>
                  <table class="table table-points">
                    <thead>
                      <tr>
                        <th class="text-center">
                          <span class="text-muted">
                            Position
                          </span>
                        </th>

                        <th>
                          <span class="text-muted">
                            Vainkeur
                          </span>
                        </th>

                        <th class="text-center">
                          <span class="text-muted">
                            Points
                          </span>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>
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

              const shareTw = document.querySelector('.share-tw');
              if (shareTw) {
                  shareTw.href = `https://twitter.com/intent/tweet?url=${top_url}&text=Go faire la TopList ${top_title}&hashtags=VAINKEURZ`;
              }

              const shareWa = document.querySelector('.share-wa');
              if (shareWa) {
                  shareWa.href = `whatsapp://send?text=${top_url}`;
              }

              const shareFb = document.querySelector('.share-fb');
              if (shareFb) {
                  shareFb.href = `https://www.facebook.com/sharer/sharer.php?u=${top_url}`;
              }

              const copyTopUrl = document.querySelector('.copy-topurl');
              if (copyTopUrl) {
                  copyTopUrl.dataset.link = top_url;
              }

              if (is_beginned == true) {
                if(document.querySelector('.t-sponso-email-beginning')) {
                  document.querySelector('.t-sponso-email-beginning').classList.add('d-none');
                }
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

              pseudoSlug = creator_infos.infos_user.pseudo_slug_user;
              const creator_link = SITE_BASE_URL + "v/" + pseudoSlug;
              let creator_block = document.querySelectorAll('.vainkeur-card');
              let creator_html = `
                <a href="${creator_link}" class="btn btn-flat-primary waves-effect">
                  <span class="avatar">
                    <span class="avatar-picture" style="background-image: url(${creator_infos.infos_user.avatar_user});"></span>
                  </span>
                  <span class="championname">
                    <small class="text-muted">
                      Créée par
                    </small>
                    <div class="creatornametopmin">
                      <h4>
                        ${creator_infos.infos_user.pseudo_user}
                      </h4>
                      <span class="medailles">
                        ${creator_infos.data_user.level_vkrz ? `<span class="va va-z-20 va-level-icon va-${creator_infos.data_user.level_vkrz.level_name}"></span>` : ''}
                        <span class="va va-creator va-z-15" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Créateur de Tops"></span>
                      </span>
                    </div>
                  </span>
                </a>
              `;
              creator_block.forEach(function(element) { element.innerHTML = creator_html; });
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

    var modeButtons = document.querySelectorAll(".modeGameTwitchBtn");
    modeButtons.forEach(function (button) {
      button.addEventListener("click", function () {
        if (button.classList.contains("active-twitch-mode")) {
          button.classList.remove("active-twitch-mode");
        } else {
          modeButtons.forEach(function (btn) {
            btn.classList.remove("active-twitch-mode");
          });
          button.classList.add("active-twitch-mode");
        }
        var twitchIcons = document.querySelectorAll(".twitch-icon-tbegin");
        var isActiveModePresent =
          document.querySelector(".active-twitch-mode") !== null;
        twitchIcons.forEach(function (twitchIcon) {
          twitchIcon.style.display = isActiveModePresent ? "block" : "none";
        });
      });
    });

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