<?php
$id_top = get_field('id_du_top_tm');
get_header();
$contenders_ranking   = get_ranking_of_top($id_top, 'elo');
$top_infos            = get_top_infos($id_top);
$type_top             = $top_infos['top_type'];
$top_title_question   = $top_infos['top_title'] . "-" . $top_infos['top_question'];
$ttq_wEmoji           = createSlug($top_title_question);
$slug_top             = sanitize_title($ttq_wEmoji);
?>
<script>
  const id_top   = <?php echo $id_top; ?>;
  const slug_top = "<?php echo $slug_top; ?>";
  function fillNbVotes(id_top) {
    fetch(API_BASE_URL + 'top/get', {
        method: 'POST',
        body: JSON.stringify({ id_top: id_top }),
        headers: { 'Content-Type': 'application/json' }
      })
      .then(response => response.json())
      .then(data => {
        document.querySelector('.nb-votes-to-fill[rel="api"]').textContent = data.nb_votes_resume;
      })
      .catch((error) => {
        console.error('Error:', error);
      });
  }

  // Wait for DOM to be fully loaded
  document.addEventListener('DOMContentLoaded', function() {
    fillNbVotes(id_top);
    if(!isTopDone(id_top)){
      const alreadyDoneElement = document.querySelector('.already-done');
      if(alreadyDoneElement) {
        alreadyDoneElement.classList.add('d-block');
      }
    }
  });
</script>

<div id="toplistmondial" class="col-12 m-0 ba-cover-r pe-0 py-5">
  <div class="container-xxl zindex-2">
    <div class="row">
      <div class="col-md-12">
        <div class="intro-archive">
          <h2>
            <span class="t-violet">TopList Mondiale <div class="weglot-div-span"><?php echo $top_infos['top_title']; ?></div></span>
          </h2>
          <h1 class="d-block">
            <?php echo $top_infos['top_question']; ?>
          </h1>
          <div class="complementinfomondial">
            <p class="text-muted">
              Cette TopList mondiale est générée via l'algo ELO à partir de vos <span class="nb-votes-to-fill" rel="api"></span> votes <span class="va va-high-voltage va-md"></span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-xxl m-auto">
    <div class="row zindex-2 position-relative">
      <div class="col-md-8 offset-md-2">
        <!-- TopList -->
        <div class="list-classement">
          <div class="row align-items-end justify-content-center">
            <?php
            $i = 1;
            foreach ($contenders_ranking['ranking'] as $c) :
              if ($i == 1) {
                $classcontender = "col-12 col-md-5";
              } elseif ($i == 2) {
                $classcontender = "col-7 col-md-4";
              } elseif ($i == 3) {
                $classcontender = "col-5 col-md-3";
              } else {
                $classcontender = "col-md-2 col-4";
              }
              if ($i >= 4) {
                $d = 3;
              } else {
                $d = $i - 1;
              }
              $slug_contender = sanitize_title($c["c_name"]);
            ?>
              <div class="<?php echo $classcontender; ?>">
                <div id="contender_id_wp_<?= $c["id_wp"]; ?>" class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php echo ($top_infos['top_d_rounded']) ? 'rounded' : ''; ?> mb-3">
                  <a href="<?php bloginfo('url'); ?>/contender/<?php echo $slug_contender; ?>">
                    <div class="illu">
                      <?php
                      if (get_field('visuel_instagram_contender', $c["id_wp"])) {
                        $thumbnail = get_field('visuel_instagram_contender', $c["id_wp"]);
                      } else if (get_field('visuel_firebase_contender', $c["id_wp"])) {
                        $thumbnail = get_field('visuel_firebase_contender', $c["id_wp"]);
                      } else {
                        $thumbnail = get_the_post_thumbnail_url($c["id_wp"]);
                        if (env() == "local") {
                          $thumbnail = str_replace("http://localhost:8888/vkrz-wp/", "https://vainkeurz.com/", $thumbnail);
                        }
                      }
                      ?>
                      <img src="<?php echo $thumbnail; ?>" alt="" class="img-fluid">
                    </div>
                    <div class="name eh2">
                      <h3 class="mt-1">
                        <?php if ($i == 1) : ?>
                          <span class="ico no-translate">🥇</span>
                        <?php elseif ($i == 2) : ?>
                          <span class="ico no-translate">🥈</span>
                        <?php elseif ($i == 3) : ?>
                          <span class="ico no-translate">🥉</span>
                        <?php else : ?>
                          <span><?php echo $i; ?><br></span>
                        <?php endif; ?>
                        <?php if (!$top_infos['top_d_titre']) : ?>
                          <b class="no-translate">
                            <?php echo $c["c_name"]; ?>
                          </b>
                        <?php endif; ?>
                      </h3>
                      <div class="pointselo" data-points="<?php echo $c["elo"]; ?>">
                        <?php echo $c["elo"]; ?> pts
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            <?php $i++;
            endforeach; ?>
          </div>
        </div>
        <!-- TopList -->
      </div>
    </div>
  </div>
</div>

<!-- Liste des TopList -->
<section id="toplistmondial-liste" class="container-xxl col-sm-9 col mt-5 mb-3">
    <h2 class="t-titre-tournoi top-title-question-home">
      <div>
        Voici les TopList de <?php echo $top_infos['top_title']; ?>
      </div>
    </h2>
    
</section>
<!-- /Liste des TopList -->

<!-- Bottom Nav -->
<div class="do-toplist-from-toplist-mondial">
  <div class="already-done animate__animated animate__fadeInUp animate__delay-3s">
    <a href="<?php the_permalink($id_top); ?>" class="btn-wording-rose btn-wording bubbly-button">
      Fais ta TopList pour participer
    </a>
  </div>
</div>
<!-- /Bottom Nav -->

<?php get_footer(); ?>