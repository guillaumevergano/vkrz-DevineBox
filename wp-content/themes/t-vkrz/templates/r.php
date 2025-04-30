<?php
global $banner_url;
global $id_top;
global $is_molotov;
$url_vkrz = get_bloginfo('url');
$banner_url_base = get_bloginfo('url') . "/wp-content/uploads/banner/";
get_header();
$top_infos = get_top_infos($id_top);
$type_top  = $top_infos['top_type'];
$is_twitch = $top_infos['is_twitch'];
if($top_infos['top_d_titre']){
  echo "<style>.name-contender {display: none;}</style>";
}
if($type_top != "sponso") {
  $order_block_1 = "";
  $order_block_2 = "";
  $show_btn      = "d-none";
}
else{
  $order_block_1 = "order-2 order-sm-1";
  $order_block_2 = "order-1 order-sm-2";
  $show_btn      = "d-block";
}
$fichier_css_toplist = get_field('fichier_css_toplist', $id_top) ?? '';
?>
<script>var type_top = "<?= $type_top; ?>";</script>
<div class="page-template-r">
  <!-- TopList -->
  <div class="toplistbloc container-xxl m-auto">
    <div class="classement">
      <div class="text-center row justify-content-center">
        <div class="col-md-7 left-toplist-part <?= $order_block_1; ?>">
          <div class="tournament-heading-top mb-2">
            <div class="t-titre-tournoi top-title-question">
              <h2>
                TopList <div class="weglot-div-span"><?php echo $top_infos['top_title']; ?></div>
              </h2>
              <h1>
                <?php echo $top_infos['top_question']; ?>
              </h1>
            </div>
          </div>
          <div class="list-classement">
            <div class="row align-items-end justify-content-center">
              <div class="row align-items-end justify-content-center render-ranking-js">
                <!-- User Toplist -->
              </div>
              <!-- Twitch Game Ranking -->
              <?php if (!isMobile()) : ?>
                <div class="popup-overlay d-none" id="twitch-games-ranking"></div>
              <?php endif; ?>
              <!-- /Twitch Game Ranking -->
            </div>
            <?php if($type_top == "sponso"): ?>
              <div class="d-block d-sm-none mt-4">
                <div class="my-1 float-end recommence_toplist currentuuid">
                  <a href="#" class="btn-wording confirm_delete" data-urltop="" data-toplistid="" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0">
                    <span class="va va-recommencer va-lg me-2"></span> Recommencer
                  </a>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php if(!$is_twitch) : ?>
          <div class="col-md-5 share-toplist-part <?= $order_block_2; ?> mb-4 mb-sm-0">
            <?php if($type_top == "sponso") : ?> 
              <?php $top_sponso_data = get_the_sponso_info(['id_top' => $id_top]); ?>
              <script> var top_sponso_data = <?= json_encode($top_sponso_data); ?>; </script>
              <div class="card animate__delay-2s animate__animated animate__rotateInDownRight share-toplist-sponso">

                <div class="card-body owner-toplist currentuuid participated-success">
                  <div class="deco-ranking-tls"></div>

                  <h3 class="info-win-gift">Félicitations <strong id="pseudo-participant"></strong>,<br>
                    <span class="t-rose">tu as validé ta participation</span> au tirage au sort
                  </h3>

                  <div class="separate mb-3"></div>

                  <h3 class="double-chances">
                    Tu peux <strong>doubler tes chances</strong><br>
                    d'être tiré au sort en partageant ta TopList :
                  </h3>

                  <div class="rs">
                    <div class="d-flex align-items-center">
                      <ul>
                        <li>
                          <a href="#" class="share-toplist-url copy-button raise-chance-tirage-btn" data-textafter="Copié ✅" data-link="" data-trigger-type="link">
                            <span>
                              <i class="fa fa-link"></i>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo $banner_url; ?>" class="share_toplistlink_img raise-chance-tirage-btn" download target="_blank" data-trigger-type="visuel">
                            <span>
                              <i class="fa fa-download"></i>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a class="share_toplistlink_twitter raise-chance-tirage-btn" href="" target="_blank" title="Tweet" data-trigger-type="x-twitter">
                            <span>
                              <i class="fa-brands fa-x-twitter"></i>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a class="share_toplistlink_fb raise-chance-tirage-btn" href="" title="Partager sur Facebook" target="_blank" data-trigger-type="facebook">
                            <span>
                              <i class="fab fa-facebook-f"></i>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a class="share_toplistlink_whatsapp raise-chance-tirage-btn" href="" ddata-action="share/whatsapp/share" data-trigger-type="whatsapp">
                            <span>
                              <i class="fab fa-whatsapp"></i>
                            </span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <div class="demo-visuel-toplist-sponso" style="background-image: url(<?php echo $banner_url; ?>);">
                    <img src="<?php echo $banner_url; ?>" alt="" class="img-fluid demo-visuel-toplist-img">
                  </div>
                </div>

                <div class="owner-toplist go-login-to-participate d-none">
                  <div class="card-body">
                    <p>Pour <strong class="t-rose">valider ta participation</strong> au tirage au sort, il faut que tu sois connecté à ton compte VAINKEURZ</p>

                    <div class="btns">
                      <a href="<?= get_permalink(get_page_by_path('inscription')); ?>" class="btn-rose btn-go-signup">Créer mon compte (gratuit)</a>

                      <strong>J'ai deja un compte, <a href="<?= get_permalink(get_page_by_path('connexion')); ?>" class="btn-go-login">Me connecter</a></strong>
                    </div>

                    <div class="separate my-3"></div>

                    <span>En rejoignant VAINKEURZ, tu obtiens le statut de VAINKEURZ et un cadeau de bienvenue 🎁</span>
                  </div>
                </div>

                <div class="card-body visitor-toplist not_currentuuid">
                  <div class="d-flex flex-md-row justify-content-md-start align-items-md-start justify-content-center align-items-center flex-column pt-3">
                    <img src="<?= $top_sponso_data["cadeau"] ?>" width="200px" alt="TopList Sponso Cadeau Image" class="img-fluid">
                    <div class="d-flex flex-column justify-content-start align-items-start ms-4 gap-4">
                      <p class="text-left">Pour participer au tirage au sort<br> fais ton propre classement <span class="va va-gift va-lg"></span> </p>
                      <a href="<?= $top_infos["top_url"] ?>" class="topurl btn-wording-rose btn-wording bubbly-button mt-3">
                        Faire mon classement
                      </a>
                    </div>
                  </div>
                </div>

              </div>
              <div class="d-none d-sm-block">
                <div class="my-1 float-end recommence_toplist currentuuid">
                  <a href="#" class="btn-wording confirm_delete" data-urltop="" data-toplistid="" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0">
                    <span class="va va-recommencer va-lg  me-2"></span> Recommencer
                  </a>
                </div>
              </div>
              <div class="fixelinktls animate__delay-3s animate__animated animate__fadeInUp">
                <a href="<?php bloginfo('url'); ?>/lot-a-gagner">
                  Participer aux autres concours <span class="va va-lg va-gift"></span> 
                </a>
              </div>
            <?php else: ?>
              <div class="animate__delay-5s animate__animated animate__rotateInDownRight">
                <div class="d-none d-sm-block">
                  <div class="card partage-toplist-block">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-8">
                          <h5> Partage ta TopList <span class="va va-rocket va-lg"></span> </h5>
                          <ul class="reseau-share">
                            <li>
                              <a href="#" class="share-tl-tw btn-wording" target="_blank" title="Tweet" style="background:#000000;">
                                <i class="social-media fa-brands fa-x-twitter"></i>
                              </a>
                            </li>
                            <li>
                              <a href="#" data-action="share/whatsapp/share" class="share-tl-wa btn-wording" style="background:#55E863;">
                                <i class="social-media fab fa-whatsapp"></i>
                              </a>
                            </li>
                            <li>
                              <a href="#" title="Partager sur Facebook" target="_blank" class="share-tl-fb btn-wording" style="background:#0B66FE;">
                                <i class="social-media fab fa-facebook-f"></i>
                              </a>
                            </li>
                          </ul>
                          <a href="#" class="sharelinkbtn btn-wording btn-wording-share">
                            <input type="text" value="" class="input_to_share">
                            <span class="va va-link va-lg"></span>
                            <div class="currentuuid">Copier le lien de ta TopList</div>
                          </a>
                          <a href="<?php echo $banner_url; ?>" download target="_blank" class="btn-wording-share btn-wording btn-download-banner-img mt-2">
                            <span class="va va-folder-in va-lg"></span> Télécharger le visuel
                          </a>
                        </div>
                        <div class="col-md-4">
                            <div class="d-none d-sm-block">
                              <div class="demo-visuel-toplist" style="background-image: url(<?php echo $banner_url; ?>);">
                                <img src="<?php echo $banner_url; ?>" alt="" class="img-fluid demo-visuel-toplist-img">
                              </div>
                            </div>
                            <div class="d-block d-sm-none">
                              <div class="demo-visuel-toplist-mobile">
                                <img src="<?php echo $banner_url; ?>" alt="" class="img-fluid">
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="is_devine">
                    <div class="devine">
                      <div class="content-devine">
                        <div class="p-4 text-center">
                          <div class="intro-alerte">
                            <h5 class="mt-2 mb-4 titrage-h5">
                              Qui te connaît le mieux ?
                            </h5>
                            <p>
                              Tes amis te connaissent-ils assez pour deviner tes choix ?
                              <br>
                              Partage et découvre lequel aura le meilleur score.
                            </p>
                          </div>
                          <div class="btn-group mt-3 w-100 justify-content-center">
                            <a href="" class="btn-wording bubbly-button btn-devine-modal" data-bs-toggle="modal" data-bs-target="#defi-modal" spellcheck="false">
                              Lance le défi à tes potes
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card mt-3 animate__delay-5s animate__animated animate__fadeInDown">
                  <div class="card-body p-10">
                    <div class="btn-actions-toplist">
                      <a href="#" class="btn-wording toplistmondialurl" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Générée à partir de tous les votes">
                        <span class="va va-globe va-lg"></span> Classement mondial
                      </a>
                      <div class="not_currentuuid">
                        <a href="#" class="topurl btn-wording-rose btn-wording bubbly-button justify-content-center">
                          <span class="fare-voir-toplist">Faire</span> ma TopList
                        </a>
                      </div>
                      <div class="currentuuid">
                        <a href="#" class="btn-wording confirm_delete" data-urltop="" data-toplistid="" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0">
                          <span class="va va-recommencer va-lg"></span> Recommencer
                        </a>
                      </div>
                    </div>
                    <div class="btn-actions-toplist">
                      <a class="btn-wording showsharetop">
                        <span class="va va-megaphone va-lg"></span> Partage le lien de la TopList
                      </a>
                      <div class="sharetop">
                        <ul class="reseau-share">
                          <li>
                            <a href="#" class="share-tw btn-wording" target="_blank" title="Tweet" style="background:#000000;">
                              <i class="social-media fa-brands fa-x-twitter"></i>
                            </a>
                          </li>
                          <li>
                            <a href="#" data-action="share/whatsapp/share" class="share-wa btn-wording" style="background:#55E863;">
                              <i class="social-media fab fa-whatsapp"></i>
                            </a>
                          </li>
                          <li>
                            <a href="#" title="Partager sur Facebook" target="_blank" class="share-fb btn-wording" style="background:#0B66FE;">
                              <i class="social-media fab fa-facebook-f"></i>
                            </a>
                          </li>
                          <li>
                            <a 
                            href="#" 
                            data-link="" 
                            data-textafter="Copié ✅" 
                            class="btn-wording copy-button copy-topurl"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Copier le lien de la TopList"
                            style="font-size:0.8rem;">
                              <span class="va va-link va-md m-0 va-2x"></span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="btn-actions-toplist-similar">
                      <a href="#" class="btn-wording gocatbtn">
                        <span class="va va-lg caticon"></span> Faire d'autres TopList similaires
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <div class="row align-items-center justify-content-center">
            <div class="col-md-4">
              <div class="my-1 float-end recommence_toplist currentuuid">
                <a href="#" class="btn-wording confirm_delete" data-urltop="" data-toplistid="" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0">
                  <span class="va va-recommencer va-lg  me-2"></span> Recommencer
                </a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <!-- /TopList -->

  <!-- Partage TopList -->
  <?php if($type_top != "sponso"): ?>
    <div class="partage-toplist animate__animated animate__slideInUp animate__delay-5s">
      <div class="d-block d-sm-none">
        <div class="is_devine">
          <div class="btn-defi">
            <a href="" class="btn-wording bubbly-button btn-devine-modal" data-bs-toggle="modal" data-bs-target="#defi-modal" spellcheck="false">
              Défie tes potes de deviner tes choix !
            </a>
            <a href="" class="btn-wording gocatbtn">
              Lance d'autres TopList similaires
            </a>
          </div>
        </div>
        <div class="fixedbar-content">
          <div class="reseau-btn-share">
            <h5>Partage ta TopList</h5>
            <a href="#" class="share-tl-tw btn-wording" target="_blank" title="Tweet" style="background:#000000;">
              <i class="social-media fa-brands fa-x-twitter"></i>
            </a>
            <a href="#" data-action="share/whatsapp/share" class="share-tl-wa btn-wording" style="background:#55E863;">
              <i class="social-media fab fa-whatsapp"></i>
            </a>
            <a href="#" title="Partager sur Facebook" target="_blank" class="share-tl-fb btn-wording" style="background:#0B66FE;">
              <i class="social-media fab fa-facebook-f"></i>
            </a>
          </div>
          <div class="partage-btn">
            <a href="#" class="sharelinkbtn btn-wording btn-wording-share">
              <input type="text" value="" class="input_to_share">
              <span class="va va-link va-lg va-2x"></span>
              <div class="currentuuid">Copier le lien</div>
            </a>
            <a href="<?php echo $banner_url; ?>" download target="_blank" class="btn-wording btn-download-banner-img btn-wording-share">
              <span class="va va-folder-in va-lg"></span> Télécharger le visuel
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <!-- /Partage TopList -->

  <!-- Modal Defi -->
  <div class="modal fade" id="defi-modal" tabindex="-1" aria-labelledby="defi-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center">
        <div class="modal-body">
          <h5 class="titrage-h5 mb-4 mt-3">Défie tes potes de deviner tes choix !</h5>
          <p>
            Partage le lien à tes amis et guette celui qui aura le meilleur score !
          </p>
          <div class="modal-content-devine row align-items-center justify-content-center">
            <div class="reseau-share-devine col-md-6 content-devine">
              <ul class="reseau-share">
                <li>
                  <a href="#" class="devine-tw btn-wording" target="_blank" title="Tweet" style="background:#000000;">
                    <i class="social-media fa-brands fa-x-twitter"></i>
                  </a>
                </li>
                <li>
                  <a href="#" data-action="share/whatsapp/share" class="devine-wa btn-wording" style="background:#55E863;">
                    <i class="social-media fab fa-whatsapp"></i>
                  </a>
                </li>
                <li>
                  <a href="#" title="Partager sur Facebook" target="_blank" class="devine-fb btn-wording" style="background:#0B66FE;">
                    <i class="social-media fab fa-facebook-f"></i>
                  </a>
                </li>
              </ul>
              <ul class="email-link-share mt-2">
                <li>
                  <a href="" id="emailLink" title="Envoyer par email" target="_blank" class="devine-mail btn-wording">
                    <i class="va-envelop-coeur va-lg va"></i> Envoyer par email
                  </a>
                </li>
                <li>
                  <a 
                  href="#" 
                  data-link="" 
                  data-textafter="Copié ✅" 
                  class="btn-wording copy-button copy-topurl-devine"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Copier le lien pour faire deviner">
                    <span class="va va-link va-lg va-2x"></span> Copier le lien
                  </a>
                </li>
              </ul>
            </div>
            <div class="list-score-devine col-md-6 content-devine">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/vkrz/score-demo.png" alt="">
            </div>
          </div>
        </div>
        <div class="modal-footer text-center">
          <button type="button" class="btn-fermer" data-bs-dismiss="modal">X Refermer</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /Modal Defi -->

  <!-- Overlay -->
  <?php get_template_part('partials/loader/loader-toplist'); ?>
  <?php get_template_part('partials/loader/recommencer'); ?>
  <!-- /Overlay -->
</div>

<script>
  const TIRAGE_VAINKEUR_URL_NEW = "https://tirage.vainkeurz.com/";

  document.addEventListener("DOMContentLoaded", function () {
    let topListURL      = window.location.href;
    let urlParts        = topListURL.split("/");
    let is_toplist_type_youtube_videos_var;
    let twitchGameVar   = localStorage.getItem('twitchGameMode') && localStorage.getItem('resumeTwitchGame');
    const topList_id    = urlParts[urlParts.length - 2];
    const vainkeurData  = JSON.parse(localStorage.getItem("vainkeur_data"));
    const bannerUrlBase = "<?= $banner_url_base ?>";
    let podiumNameContenders = [];
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
    uuid_user = getParamURL('uuid_user') ?? uuid_user;
    if (topList_id === null || topList_id === undefined || topList_id === "" || topList_id === "undefined") {
      window.location.href = '/';
    } 
    else {
      SQL_getTopList(topList_id)
        .then(async (data) => {
          if (data && data.toplist_exists) {
            setTimeout(async () => {
              if(!data.toplist_info.banner) {
                  try {
                    const response = await fetch(`${API_BASE_URL}toplist-list/generatebanner-image/${topList_id}`, {
                      method: "GET",
                      headers: {"Content-Type": "application/json", },
                    });
                    if (!response.ok) {
                      throw new Error("Network response was not ok");
                    }
                    const data = await response.json();
                    if(data && data.success) {
                      const bannerUrl = `${bannerUrlBase}${data.imageSlug}`;
                      if(document.querySelector('.demo-visuel-toplist') && document.querySelector('.demo-visuel-toplist-img') && document.querySelector('.btn-download-banner-img')) {
                        const demoVisuelToplistElements = document.querySelectorAll('.demo-visuel-toplist');
                        const demoVisuelToplistImgElements = document.querySelectorAll('.demo-visuel-toplist-img');
                        const btnDownloadBannerImgElements = document.querySelectorAll('.btn-download-banner-img');
                        demoVisuelToplistElements.forEach(element => { element.style.backgroundImage = `url('${bannerUrl}')`; });
                        demoVisuelToplistImgElements.forEach(element => { element.setAttribute('src', bannerUrl); });
                        btnDownloadBannerImgElements.forEach(element => { element.setAttribute('href', bannerUrl); });
                      }
                    }
                  } catch (error) {
                    console.error("There was a problem with the fetch operation:", error);
                  }
              } else {
                const bannerUrl = `${bannerUrlBase}${data.toplist_info.banner}`;
                if(document.querySelector('.demo-visuel-toplist') && document.querySelector('.demo-visuel-toplist-img') && document.querySelector('.btn-download-banner-img')) {
                  const demoVisuelToplistElements = document.querySelectorAll('.demo-visuel-toplist');
                  const demoVisuelToplistImgElements = document.querySelectorAll('.demo-visuel-toplist-img');
                  const btnDownloadBannerImgElements = document.querySelectorAll('.btn-download-banner-img');
                  demoVisuelToplistElements.forEach(element => { element.style.backgroundImage = `url('${bannerUrl}')`; });
                  demoVisuelToplistImgElements.forEach(element => { element.setAttribute('src', bannerUrl); });
                  btnDownloadBannerImgElements.forEach(element => { element.setAttribute('href', bannerUrl); });
                }
              }
            }, 1500);

            const uuid_user_of_tl = data.toplist_info.uuid_user,
                  id_top_rank     = data.toplist_info.id_top_rank,
                  rankingJSON     = data.toplist_info.ranking,
                  type_rank       = data.toplist_info.type_rank,
                  isCurrentUser   = uuid_user_of_tl === uuid_user;

            // CHECK IF DEVINE IS POSSIBLE
            if(type_top != "sponso") {
              checkIfDevinePossible(topList_id);
            }

            const currentUUIDElements    = document.querySelectorAll('.currentuuid');
            const notCurrentUUIDElements = document.querySelectorAll('.not_currentuuid');
            
            currentUUIDElements.forEach(element => { element.style.display = isCurrentUser ? 'block' : 'none'; });
            notCurrentUUIDElements.forEach(element => { element.style.display = isCurrentUser ? 'none' : 'block'; });

            get_top_info(id_top_rank, "complet")
              .then(async data => {
                if (data) {
                  const {
                    top_url, top_cat, top_cat_icon, top_cat_url, top_title, top_question, top_precision, top_number, top_type, top_img, top_cover, top_d_titre, top_d_rounded, top_d_cover, top_date, creator_infos, toplist_mondiale, is_toplist_type_youtube_videos, participation_inscription_fin
                  } = data;
                  is_toplist_type_youtube_videos_var = is_toplist_type_youtube_videos;

                  if(type_top == "sponso") {
                    const participatedSuccessDIV  = document.querySelector('.participated-success');
                    const goLoginToParticipateDIV = document.querySelector('.go-login-to-participate');
                    const userInfos = JSON.parse(localStorage.getItem("user_info"));
                    if(userInfos && userInfos.pseudo_user !== "Lama2Lombre") participatedSuccessDIV.querySelector('#pseudo-participant').textContent = userInfos.pseudo_user;
                    if(userInfos.pseudo_user == "Lama2Lombre" && participation_inscription_fin) {
                      const goLoginToParticipateBtn  = document.querySelector('.btn-go-login');
                      goLoginToParticipateBtn.href   = `${goLoginToParticipateBtn.href}?redirectparam=${window.location.href}&tl_sponso=true`;
                      const goSignupToParticipateBtn = document.querySelector('.btn-go-signup');
                      goSignupToParticipateBtn.href  =  `${goSignupToParticipateBtn.href}?redirectparam=${window.location.href}&tl_sponso=true`;

                      participatedSuccessDIV.style.display = 'none';
                      goLoginToParticipateDIV.classList.remove('d-none');
                      if(goLoginToParticipateDIV.querySelector('.card-body'))
                        goLoginToParticipateDIV.querySelector('.card-body').style.display = 'block';
                      document.querySelector('.visitor-toplist').style.display = 'none';
                    } else if (userInfos.pseudo_user != "Lama2Lombre" && participation_inscription_fin && isCurrentUser) {
                      try {
                        const response = await fetch(`${API_BASE_URL}participation-list/new`, {
                          method: "POST",
                          headers: { "Content-Type": "application/json" },
                          body: JSON.stringify({
                            id_top_p: id_top_rank,
                            uuid_vainkeur: uuid_user,
                            email_p: userInfos.email_user,
                            phone_p: null,
                          }),
                        });
                        const data = await response.json();
                        if (data.status === "Nouvelle participation ajoutée") checkTrophy(vainkeurData.id, 17);
                        participatedSuccessDIV.querySelector('#pseudo-participant').textContent = userInfos.pseudo_user;
                        participatedSuccessDIV.style.display = 'block';
                      } catch (error) {
                        console.error("An error occurred while trying to add a new participation :", error);
                        return;
                      }
                    } 

                    // RAISE CHANCE TIRAGE BUTTONS
                    const raiseTirageBtns = document.querySelectorAll('.raise-chance-tirage-btn');
                    raiseTirageBtns.forEach(btn => {
                      btn.addEventListener('click',  async function(e) {
                        const triggerType = this.getAttribute('data-trigger-type');
                        fetch(`${API_BASE_URL}participation-list/check`, {
                              method: 'POST',
                              headers: { 'Content-Type': 'application/json' },
                              body: JSON.stringify({
                                uuid_vainkeur: uuid_user,
                                id_top_p: id_top_rank
                              })
                            })
                            .then((response) => response.json())
                            .then((participationData) => {
                              if(participationData.participation_exist === "yes") {
                                fetch(`${API_BASE_URL}participation-list/increment-chance`, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                      uuid_vainkeur: uuid_user,
                                      id_top_p: id_top_rank,
                                      trigger_type: triggerType
                                    })
                                  })
                                  .then((response) => response.json())
                                  .then((data) => { 
                                    // console.log(data)
                                  });
                              }
                            });
                      })
                    });
                  }
                
                  // CHECK TROPHIES
                  if (vainkeurData && isCurrentUser) {
                    checkTrophy(vainkeurData.id, 15); // FIRST TOP TROPHEE 
                    if (+top_number < 100 && +top_number >= 50) checkTrophy(vainkeurData.id, 5); // BIG TOP TROPHEE
                    if (+top_number >= 100) checkTrophy(vainkeurData.id, 4); // BIG BIG TOP TROPHEE
                    let now  = new Date(); let hour = now.getHours();
                    if (hour >= 23 || hour < 5) checkTrophy(vainkeurData.id, 14); // NOCTURNE TROPHEE 
                  } 

                  // RENDER TOPLIST
                  const rankingSorted = sortRanking(rankingJSON, type_rank);
                  const renderRankingContainer = document.querySelector('.render-ranking-js');
                  const animations = ["animate__bounceInDown", "animate__tada", "animate__jello", "animate__heartBeat", "animate__fadeInDown", "animate__flip", "animate__rotateIn"];
                  const getRandomAnimation = () => animations[Math.floor(Math.random() * animations.length)];
                  const randomAnimationClass = getRandomAnimation();
                  await new Promise(resolve => setTimeout(resolve, 500));
                  document.getElementById("waiter-toplist").style.display = "none";
                  for (let i = 0; i < rankingSorted.length; i++) {
                    let c = rankingSorted[i];
                    let classContender;
                    switch (i) {
                      case 0:
                        classContender = "col-8 col-offset-2 col-md-5";
                        break;
                      case 1:
                        classContender = "col-6 col-md-4";
                        break;
                      case 2:
                        classContender = "col-6 col-md-3";
                        break;
                      default:
                        classContender = "col-5 col-offset-1 col-sm-4 col-sm-offset-0 col-md-3";
                        break;
                    }
                    const response = await fetch(`${SITE_BASE_URL}wp-json/v1/getcontenderinfo/${c.id_wp}`);
                    const data = await response.json();
                    const medalOrRank = getMedalOrRank(i);
                    podiumNameContenders.push(data.title);
                    const individualContenderHtml = `
                      <div class="${classContender}">
                        <div class="${randomAnimationClass} animate__animated contenders_min ${top_d_rounded ? 'rounded' : ''} mb-3">
                          <div class="illu">
                            ${(is_toplist_type_youtube_videos_var && data.embed) ? 
                              data.embed :
                              `<img src="${data.thumbnail}" alt="" class="img-fluid">`
                            }
                          </div>
                          <div class="name eh2">
                            <h3 class="mt-2 eh3">
                              ${medalOrRank}
                              <span class="name-contender">${data.title}</span>
                            </h3>
                          </div>
                        </div>
                      </div>
                    `;
                    renderRankingContainer.insertAdjacentHTML('beforeend', individualContenderHtml);
                    await new Promise(resolve => setTimeout(resolve, 350));

                  }

                  document.querySelectorAll('.topurl').forEach(btn => btn.href = top_url);
                  const fareVoirElement = document.querySelector('.fare-voir-toplist');
                  if (fareVoirElement) 
                      fareVoirElement.textContent = isTopDone(id_top_rank) ? "Voir" : "Faire";
                  
                  const toplistBlocElement = document.querySelector('.ba-cover-r');
                  if (toplistBlocElement) 
                      toplistBlocElement.style.backgroundImage = `url('${top_cover}')`;

                  const toplistMondialUrlElement = document.querySelector('.toplistmondialurl');
                  if (toplist_mondiale) {
                      if (toplistMondialUrlElement) {
                          toplistMondialUrlElement.href = toplist_mondiale;
                      }
                  } else {
                      if (toplistMondialUrlElement) {
                          toplistMondialUrlElement.classList.add('d-none');
                      }
                  }

                  const confirmDeleteButtons = document.querySelectorAll('.confirm_delete');
                  if (confirmDeleteButtons.length > 0) {
                      confirmDeleteButtons.forEach(button => {
                          button.dataset.urltop = top_url;
                          button.dataset.toplistid = topList_id;
                      });
                  }

                  if (getParamURL('iframe') == "true") {
                      let urlPartage = topListURL;
                      let updatedURL = removeURLParameters(urlPartage, ["iframe", "uuid_user"]);
                      topListURL = updatedURL;
                  }

                  topListURL = topListURL.replace(/#/g, '');
                  
                  if(typeof top_sponso_data !== 'undefined') {
                    let contendersToShowStr = "";
                    if(top_sponso_data.tweet_contenders_show) {
                      contendersToShowStr = `: #${podiumNameContenders[0].split(' ').join('')} #${podiumNameContenders[1].split(' ').join('')} #${podiumNameContenders[2].split(' ').join('')}`;
                    }

                    const wordingDebut = top_sponso_data?.tweet_wording_debut || 'Voici mon TOP3';
                    const topMarqueTag = top_sponso_data?.tweet_marque_tag ? `@${top_sponso_data.tweet_marque_tag}` : '';
                    const gainChamps1 = top_sponso_data?.gain_champs_1 || '';
                    const tweetUtm = top_sponso_data?.tweet_utm  ? `${top_sponso_data.tweet_utm}tweet` : '';
                    const tweetHashtag = top_sponso_data?.tweet_hashtag ? `#${top_sponso_data.tweet_hashtag}` : '';
                    const tweetText = `${wordingDebut} ${topMarqueTag} ${contendersToShowStr}\nToi aussi fais ton classement pour tenter de gagner ${gainChamps1} ${topListURL + '?utm_campaign=' + tweetUtm} ${tweetHashtag} #VKRZ_TLS`;

                    const shareToplistLinkTwitter = document.querySelector('.share_toplistlink_twitter');
                    if (shareToplistLinkTwitter) {
                        shareToplistLinkTwitter.href = `https://twitter.com/intent/tweet?text=${encodeURIComponent(tweetText)}`;
                    }
                  } else {
                    const shareToplistLinkTwitter = document.querySelector('.share_toplistlink_twitter');
                    if (shareToplistLinkTwitter) {
                      shareToplistLinkTwitter.href = `https://twitter.com/intent/tweet?text=Voici ma TopList ${top_title}&via=VAINKEURZ&hashtags=VKRZ&url=${topListURL}`;
                    }
                  }

                  const shareTlTw = document.querySelector('.share-tl-tw');
                  if (shareTlTw) {
                      shareTlTw.href = `https://twitter.com/intent/tweet?text=Voici ma TopList ${top_title}&via=VAINKEURZ&hashtags=VKRZ&url=${topListURL}`;
                  }

                  const shareTlWa = document.querySelector('.share-tl-wa');
                  if (shareTlWa) {
                      shareTlWa.href = `whatsapp://send?text=${topListURL}`;
                  }

                  const shareTlFb = document.querySelector('.share-tl-fb');
                  if (shareTlFb) {
                      shareTlFb.href = `https://www.facebook.com/sharer/sharer.php?u=${topListURL}`;
                  }

                  const inputToShare = document.querySelector('.input_to_share');
                  if (inputToShare) {
                      inputToShare.value = topListURL;
                  }

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

                  const shareToplistUrl = document.querySelector('.share-toplist-url');
                  if (shareToplistUrl) {
                      shareToplistUrl.dataset.link = topListURL;
                  }

                  const shareToplistLinkFb = document.querySelector('.share_toplistlink_fb');
                  if (shareToplistLinkFb) {
                      shareToplistLinkFb.href = `https://www.facebook.com/sharer/sharer.php?u=${topListURL}`;
                  }

                  const shareToplistLinkWhatsapp = document.querySelector('.share_toplistlink_whatsapp');
                  if (shareToplistLinkWhatsapp) {
                      shareToplistLinkWhatsapp.href = `whatsapp://send?text=${topListURL}`;
                  }

                  var devine_url = SITE_BASE_URL + "devine/" + topList_id;

                  const devineTw = document.querySelector('.devine-tw');
                  if (devineTw) {
                      devineTw.href = `https://twitter.com/intent/tweet?url=${devine_url}&text=Essayez de deviner mes choix dans la TopList : ${top_title}&hashtags=VAINKEURZ`;
                  }

                  const devineWa = document.querySelector('.devine-wa');
                  if (devineWa) {
                      devineWa.href = `whatsapp://send?text=${devine_url}`;
                  }

                  const devineFb = document.querySelector('.devine-fb');
                  if (devineFb) {
                      devineFb.href = `https://www.facebook.com/sharer/sharer.php?u=${devine_url}`;
                  }

                  const copyTopUrlDevine = document.querySelector('.copy-topurl-devine');
                  if (copyTopUrlDevine) {
                      copyTopUrlDevine.dataset.link = devine_url;
                  }

                  const emailLink = document.getElementById('emailLink');
                  if (emailLink) {
                      var sujet = "Défi : tu dois deviner ma TopList sans te tromper";
                      var body = "Salut,\n\nJe viens de finir ma TopList " + top_title + "\n\nJe te défis de deviner chacun des choix que j'ai pu faire en cliquant ici: " + devine_url + "\n\nHâte de découvrir ton score.";
                      var encodedBody = encodeURIComponent(body);
                      var mailtoLink = "mailto:?subject=" + encodeURIComponent(sujet) + "&body=" + encodedBody;
                      emailLink.href = mailtoLink;
                  }

                  const catBtn = document.querySelector('.gocatbtn');
                  if (catBtn) {
                    catBtn.href = top_cat_url;
                    catBtn.querySelector('.caticon').innerHTML = top_cat_icon;
                  }
              }
          });
          }
          // TWITCH
          if(localStorage.getItem("twitchGameMode"))
            if (vainkeurData) checkTrophy(vainkeurData.id, 18);

          if (document.querySelector('#twitch-games-ranking') && localStorage.getItem('resumeTwitchGame')) {
            const twitchGamesRankingContainer = document.querySelector('#twitch-games-ranking'),
                  idRanking = topList_id;

            const predictionWinnerTemplate = function(winner, participantsNumber) {
              let wording = "", subHeader = "";
              if(winner !== null) {
                if (+participantsNumber === 2) {
                  wording = `Le gagnant est `;
                } else {
                  wording = `A gagné contre ${+participantsNumber - 1} autres participants`;
                }
              } else {
                wording = `Plusieurs viewers sont à égalité`;
              }

              let returnDiv = "";
              if(winner !== null) {
                returnDiv = `
                  <div class="twitchGamesWinnerContainer">
                    <span class="twitchGamesWinnerName confetti">${winner}</span>
                  </div>
                `;
                if(document.querySelector('#twitch-games-ranking'))
                  document.querySelector('#twitch-games-ranking').classList.add('prediction-mode-winner');
              } else {
                const user_infos = JSON.parse(localStorage.getItem("user_info"));

                returnDiv = `

                  <p>Nous proposons que la chance détermine le<br> viewer qui remportera cette TopList <span class="va va-chance va-lg"></span></p>

                  <span class="avatar-info-bubble go-to-tirage-vkrz cursor-pointer d-inline-block my-3">
                    <a href="${TIRAGE_VAINKEUR_URL_NEW}?streamChannel=${user_infos.twitch_user}" class="btn waves-effect go-to-tirage-vkrz-btn btn-lg waves-effect waves-light bubbly-button" target="_blank">
                      Lancer un tirage au sort 
                    </a>
                  </span>
                `;
              }
                            
              return `
                <div class="popup participate-popup scale-up-center popup-twitch-games-ranking">
                  <button class="close-popup only-x" id="close-popup">&times;</button>

                  <div class="popup-header">
                    <h3>
                      ${wording}
                    </h3>
                  </div>

                  <div class="popup-body">
                    ${returnDiv}
                  </div>
                </div>
              `;
              
            }
            const tablePointsTemplate = function(tbody, participantsNumber, idTwitchGame) {
              tbody = tbody.replaceAll('text-success', '')
              tbody = tbody.replaceAll('↑', '')

              let tbodyDOM = document.createElement('tbody');
              tbodyDOM.innerHTML = tbody;

              // REFACTOR POSITIONS WITH NUMBERS…
              let rank = 1;
              const rows = tbodyDOM.querySelectorAll('tr');
              rows.forEach((row, index) => {
                let position = Number(row.querySelector('td:last-of-type').dataset.order);

                if (index > 0 && position < Number(rows[index - 1].querySelector('td:last-of-type').dataset.order)) {
                  rank = index + 1;
                }

                row.querySelector('td:first-of-type').innerHTML = rank;
              })

              // REFACTOR POSITIONS WITH EMOJIS…
              let positionStr                = "",
                  manyWinnersInFirstPlaceVar = 0,
                  manyWinnersArr             = [];
              tbodyDOM.querySelectorAll('tr').forEach((row, index) => {
                row.querySelector('td:first-of-type').classList.add('text-left');
                row.querySelector('td:last-of-type').classList.add('text-left');
                row.querySelector('td:nth-of-type(2)').classList.add('text-left');

                let position = row.querySelector('td:first-of-type').innerHTML;
                switch (position) {
                  case "1":
                    positionStr = '<span class="ico va va-medal-1 va-lg"></span>';
                    manyWinnersInFirstPlaceVar++;
                    manyWinnersArr.push(row.querySelector('td:nth-of-type(2)').innerHTML);
                    break;
                  case "2":
                    positionStr = '<span class="ico va va-medal-2 va-lg"></span>';
                    break;
                  case "3":
                    positionStr = '<span class="ico va va-medal-3 va-lg"></span>';
                    break;
                  default:
                    positionStr = index + 1;
                }
                row.querySelector('td:first-of-type').innerHTML = positionStr;
              })

              // IN CASE OF EQUALITY
              const user_infos = JSON.parse(localStorage.getItem("user_info"));
              let wording      = "", subHeader = "",
                  winnerDiv    = "";

              if (manyWinnersInFirstPlaceVar > 1) { // MANY WINNERS
                wording = `Plusieurs viewers sont à égalité`;
                subHeader = "Nous proposons que la chance détermine le</br> viewer qui remportera cette TopList <span class='va va-chance va-lg'></span>";

                fetch(`${API_BASE_URL}twitch/update-participants-game`, {
                  method: 'POST',
                  body: JSON.stringify({
                    id: idTwitchGame,
                    rest_participants: manyWinnersArr
                  }),
                  headers: { 'Content-Type': 'application/json' }
                })
                .then(response => response.json()) 
                .then(data => {
                  if(data.status === "success") {
                    document.querySelector('.twitch-games-popup .go-to-tirage-vkrz').classList.add('d-block');
                  }
                })
              } else { // ONE WINNER
                if (+participantsNumber === 2) {
                  wording = `Le gagnant est `;
                } else {
                  wording = `${+participantsNumber} participants mais un seul gagnant :`;
                }
                winnerDiv = `
                  <div style="height: 130px;"></div>
                  <div class="twitchGamesWinnerContainer mb-3" style="top:24%!important;">
                    <span class="twitchGamesWinnerName confetti">${manyWinnersArr[0]}</span>
                  </div>
                `;

                fetch(`${API_BASE_URL}twitch/winner-game`, {
                  method: 'POST',
                  body: JSON.stringify({
                    id_twitch_game: idTwitchGame,
                    winner: manyWinnersArr[0],
                    stream_channel: user_infos.twitch_user
                  }),
                  headers: {
                    'Content-Type': 'application/json',
                  }
                })
                  .then(response => response.json())
                  .then(data => {
                    // console.log(data);
                  })
                  .catch((error) => console.error("Error updating winner:", error));
              }

              return `      
                <div class="popup participate-popup scale-up-center twitch-games-popup">
                  <button class="close-popup only-x" id="close-popup">&times;</button>

                  <div class="popup-header">
                    <h3>
                      ${wording}
                    </h3>
                  </div>

                  <p>${subHeader}</p>

                  <span class="avatar-info-bubble go-to-tirage-vkrz cursor-pointer my-3">
                    <a href="${TIRAGE_VAINKEUR_URL_NEW}?streamChannel=${user_infos.twitch_user}" class="btn waves-effect go-to-tirage-vkrz-btn btn-lg waves-effect waves-light bubbly-button" target="_blank">
                      Lancer un tirage au sort
                    </a>
                  </span>

                  <div class="popup-body w-100">
                    ${winnerDiv}

                    <table class="table table-points" style="margin-top: auto;">
                      <thead>
                        <tr>
                          <th class="text-left">
                            <span class="text-muted">
                              Position
                            </span>
                          </th>

                          <th class="text-left">
                            <span class="text-muted">
                              Vainkeur
                            </span>
                          </th>

                          <th class="text-left">
                            <span class="text-muted">
                              Points
                            </span>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        ${tbodyDOM.innerHTML}
                      </tbody>
                    </table>
                  </div> 
                </div>
              `;
            }
            
            if (localStorage.getItem('resumeTwitchGame')) {
              let resumeTwitchGame = localStorage.getItem('resumeTwitchGame');
                  resumeTwitchGame = JSON.parse(resumeTwitchGame);

              if (resumeTwitchGame.idRanking == idRanking) {
                if (resumeTwitchGame.mode === "votePoints") {
                  fetch(`${API_BASE_URL}twitch/get-game-by-id`, {
                    method: 'POST',
                    body: JSON.stringify({ id_twitch_game: resumeTwitchGame.id_twitch_game, }),
                    headers: { 'Content-Type': 'application/json' }
                  })
                    .then(response => response.json()) 
                    .then(data => {
                      if(data.exists) {
                        twitchGamesRankingContainer.innerHTML = tablePointsTemplate(data.extra_field_for_points_game, data.number_participants, resumeTwitchGame.id_twitch_game);
                        twitchGamesRankingContainer.classList.remove('d-none');
                        if (data.number_participants >= 5) {
                          var table = $('.table-points').dataTable();
                          table.fnDestroy();

                          table.dataTable({
                              lengthMenu: [4],
                              paging: true,
                              searching: true,
                              language: {
                                search: "_INPUT_",
                                searchPlaceholder: `Rechercher parmi les ${data.number_participants} participants...`,
                                processing: "Traitement en cours...",
                                info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                                infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                infoPostFix: "",
                                loadingRecords: "Chargement en cours...",
                                zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
                                emptyTable: "Aucun résultat trouvé 😩",
                                paginate: {
                                  first: "Premier",
                                  previous: "Pr&eacute;c&eacute;dent",
                                  next: "Suivant",
                                  last: "Dernier",
                                },
                              },
                              initComplete: function() {
                                  $('#DataTables_Table_0_filter').parent().removeClass('col-md-6').addClass('col-md-12');
                                  $('#DataTables_Table_0_filter label').addClass('w-100');
                                  $('#DataTables_Table_0_length').parent().hide();
                              }
                          });
                        } else {
                          if(document.querySelector('.twitchGamesWinnerContainer')) 
                            document.querySelector('.twitchGamesWinnerContainer').style.top = "35%";
                        }
                      }
                    })
                } else if (resumeTwitchGame.mode === "votePrediction") {
                  twitchGamesRankingContainer.innerHTML = predictionWinnerTemplate(resumeTwitchGame.winner, resumeTwitchGame.participantsNumber)
                  twitchGamesRankingContainer.classList.remove('d-none');
                }
              }
              localStorage.removeItem('resumeTwitchGame');
              localStorage.removeItem('twitchGameMode');
              setTimeout(() => {
                $(".twitchGamesWinnerContainer").addClass('show');
                confetti();
                function rnd(m, n) { m = parseInt(m); n = parseInt(n); return Math.floor(Math.random() * (n - m + 1)) + m; }
                function confetti() {
                  $.each($(".twitchGamesWinnerName.confetti"), function() {
                    var confetticount = ($(this).width() / 50) * 10;
                    for (var i = 0; i <= confetticount; i++) {
                      $(this).append('<span class="particle c' + rnd(1, 4) + '" style="top:' + rnd(10, 50) + '%; left:' + rnd(0, 100) + '%;width:' + rnd(2, 12) + 'px; height:' + rnd(2, 14) + 'px;animation-delay: ' + (rnd(0, 30) / 10) + 's;"></span>');
                    }
                  });
                }
                function adjustFontSizeForPseudo() {
                  const pseudoElement = document.querySelector('.twitchGamesWinnerName');
                  if (!pseudoElement) return;
                  const maxLength = 13; 
                  const defaultFontSize = 70;
                  const pseudoLength = pseudoElement.textContent.trim().length;
                  let fontSize = defaultFontSize;
                  if (pseudoLength > maxLength) {
                    const scaleFactor = 2;
                    const charactersOver = pseudoLength - maxLength;
                    fontSize -= charactersOver * scaleFactor;
                  }
                  const minFontSize = 20;
                  fontSize = Math.max(fontSize, minFontSize);
                  pseudoElement.style.fontSize = `${fontSize}px`;
                }
                adjustFontSizeForPseudo();
                const popUp      = document.querySelector('.popup-overlay');
                const closePopUp = document.querySelector('.close-popup') || document.querySelector('#close-popup');
                if (closePopUp) {
                  closePopUp.addEventListener('click', () => popUp.classList.add('d-none'));
                }
              }, 1000)
            }
          }
        })
    }
    
  });
</script>
<?php get_footer(); ?>