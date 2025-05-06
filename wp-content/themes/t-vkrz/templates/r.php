<?php
global $banner_url;
global $id_top;
global $is_molotov;
$url_vkrz = get_bloginfo('url');
$banner_url_base = get_bloginfo('url') . "/wp-content/uploads/banner/";
get_header();
$top_infos = get_top_infos($id_top);
?>
<div class="page-template-r">
  <!-- TopList -->
  <div class="toplistbloc container-xxl m-auto">
    <div class="classement">
      <div class="text-center row justify-content-center">
        <div class="col-md-12 left-toplist-part">
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
            </div>
          </div>
        </div>
        <div class="row align-items-center justify-content-center">
          <div class="col-md-3">
            <div class="my-1 recommence_toplist currentuuid">
              <a href="#" class="btn-wording confirm_delete text-center" data-urltop="" data-toplistid="" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0">
                <span class="va va-recommencer va-lg  me-2"></span> Recommencer
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /TopList -->
  <!-- Overlay -->
  <?php get_template_part('partials/loader/loader-toplist'); ?>
  <?php get_template_part('partials/loader/recommencer'); ?>
  <!-- /Overlay -->
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    let topListURL      = window.location.href;
    let urlParts        = topListURL.split("/");
    let is_toplist_type_youtube_videos_var;
    const topList_id    = urlParts[urlParts.length - 2];
    const vainkeurData  = JSON.parse(localStorage.getItem("vainkeur_data"));
    let podiumNameContenders = [];
    uuid_user = getParamURL('uuid_user') ?? uuid_user;
    if (topList_id === null || topList_id === undefined || topList_id === "" || topList_id === "undefined") {
      window.location.href = '/';
    } 
    else {
      SQL_getTopList(topList_id)
        .then(async (data) => {
          if (data && data.toplist_exists) {
            const uuid_user_of_tl = data.toplist_info.uuid_user,
                  id_top_rank     = data.toplist_info.id_top_rank,
                  rankingJSON     = data.toplist_info.ranking,
                  type_rank       = data.toplist_info.type_rank,
                  isCurrentUser   = uuid_user_of_tl === uuid_user;

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
                  
                  const confirmDeleteButtons = document.querySelectorAll('.confirm_delete');
                  if (confirmDeleteButtons.length > 0) {
                      confirmDeleteButtons.forEach(button => {
                          button.dataset.urltop = top_url;
                          button.dataset.toplistid = topList_id;
                      });
                  }

                  topListURL = topListURL.replace(/#/g, '');
                  
                  const catBtn = document.querySelector('.gocatbtn');
                  if (catBtn) {
                    catBtn.href = top_cat_url;
                    catBtn.querySelector('.caticon').innerHTML = top_cat_icon;
                  }
                }
              });
          }
        });
    }
  });
</script>
<?php get_footer(); ?>