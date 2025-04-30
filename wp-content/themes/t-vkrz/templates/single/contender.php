<?php 
global $contender_id;
get_header();
$list_contender = array();
$nb_top_actif = 0;
$list_categorie = array();
$list_title_top = array();
$contenders = new WP_Query(array(
  'ignore_sticky_posts'	    => true,
  'update_post_meta_cache'  => false,
  'no_found_rows'		        => true,
  'post_type'			          => 'contender',
  'orderby'				          => 'date',
  'order'				            => 'DESC',
  'posts_per_page'		      => -1,
  's' => get_the_title($contender_id)
));
while ($contenders->have_posts()) : $contenders->the_post();
  $id_contender = get_the_ID(); 
  $id_top = get_field('id_tournoi_c', $id_contender);
  if(is_top_ok($id_top)){
    $nb_top_actif++;
    $top_cat = get_the_terms($id_top, 'categorie');
    if ($top_cat) {
      foreach ($top_cat as $cat) {
        array_push($list_categorie, $cat);
      }
    }
    array_push($list_title_top, get_the_title($id_top));
  }
  $list_contender[] = $id_contender;
endwhile; wp_reset_query(); 
$list_categorie = array_unique($list_categorie, SORT_REGULAR);
$list_title_top = array_unique($list_title_top, SORT_REGULAR);
?>
<div class="col-12 mt-4">
  <div class="container-xl">
    <div class="card0">
      <div class="card-body0">
        <div class="row">
          <div class="col-md-12">
            <div class="list-top-contender">
              <section class="row match-heigh">
                <div class="col-md-8">
                  <div class="contender-presentation">
                    <h1>
                      <?php echo get_the_title($contender_id); ?>
                    </h1>
                    <p>
                      Le contender <strong><?php echo get_the_title($contender_id); ?></strong> est présent dans <?php echo $nb_top_actif; ?> TopList actives.
                    </p>
                    <p>
                      Les catégories où l'on retrouve <strong><?php echo get_the_title($contender_id); ?></strong> sont :
                      <br>
                      <?php foreach ($list_categorie as $cat) : 
                        $top_cat_icon = get_field('icone_cat', 'term_' . $cat->term_id);
                        $top_cat_url  = get_term_link($cat->term_id);
                        $top_cat_name = $cat->name;
                        $top_cat_id   = $cat->term_id;
                      ?>
                        <a href="<?php echo $top_cat_url; ?>" class="badge bg-label-main mb-1">
                          <?php echo $top_cat_icon; ?> <?php echo $cat->name; ?>
                        </a>
                      <?php endforeach; ?>
                    </p>
                    <p>
                      Voici la liste des TopList où l'on peut voter pour <strong><?php echo get_the_title($contender_id); ?></strong> :
                      <br>
                      <?php foreach ($list_title_top as $title_top) : ?>
                        <span class="badge bg-label-main mb-1">
                          <?php echo $title_top; ?>
                        </span>
                      <?php endforeach; ?>
                    </p>
                    <p class="description-contender">
                    </p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="stats-contender-globales">
                    <h2 class="titre-section titre-section-emojibig-3 mt-0">
                      Statistiques globales de <?php echo get_the_title($contender_id); ?>
                    </h2>
                    <div class="row">
                      <div class="col-6">
                        <div class="card text-center">
                          <div class="card-body card-stats">
                            <div class="itemstat">
                              <div class="valuestat">
                                <span class="nb_eloglobal_vkrz" rel="api">
                                  0
                                </span>
                                <small class="text-muted mb-0">ELO global</small>
                              </div>
                              <div>
                                <span class="badge bg-label-success eloglobalplus d-none">
                                  <span class="nb_eloglobal_percent_top_vkrz" rel="api"></span>
                                </span>
                                <span class="badge bg-label-danger eloglobalmoins d-none">
                                  <span class="nb_eloglobal_percent_top_vkrz" rel="api"></span>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="card text-center">
                          <div class="card-body card-stats">
                            <div class="itemstat">
                              <div>
                                <span class="iconstats va-versus va va-lg"></span>
                              </div>
                              <div class="valuestat">
                                <span class="nb_duels_vkrz" rel="api">
                                  0
                                </span>
                                <small class="text-muted mb-0">Duels</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="card text-center">
                          <div class="card-body card-stats">
                            <div class="itemstat">
                              <div>
                                <span class="iconstats va-check va va-lg"></span>
                              </div>
                              <div class="valuestat">
                                <span class="nb_victoire_vkrz" rel="api">
                                  0
                                </span>
                                <small class="text-muted mb-0">Victoires</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="card text-center">
                          <div class="card-body card-stats">
                            <div class="itemstat">
                              <div>
                                <span class="iconstats va-cross va va-lg"></span>
                              </div>
                              <div class="valuestat">
                                <span class="nb_defaite_vkrz" rel="api">
                                  0
                                </span>
                                <small class="text-muted mb-0">Défaites</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section class="row match-heigh">
                <div class="col-12 my-3">
                  <div class="text-center">
                    <h2 class="titre-section titre-section-emojibig-3 mt-0">
                      Liste de toutes TopList avec le contender : <?php echo get_the_title($contender_id); ?>
                    </h2>
                  </div>
                </div>
                <?php
                while ($contenders->have_posts()) : $contenders->the_post(); $id_contender = get_the_ID(); $id_top = get_field('id_tournoi_c', $id_contender); ?>
                
                  <?php if(is_top_ok($id_top)): ?>
                    <div class="col-md-4 contender-item-stats" data-top="<?php echo $id_top; ?>" data-contender="<?php echo $id_contender; ?>">
                      <div class="contender-item-stats-content mb-5">
                        <div class="card pt-0 pb-0">
                          <div class="card-body pt-0 pb-2">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="illu-contender">
                                  <?php
                                    $fields = get_fields($id_contender);
                                    if ($fields) {
                                      $thumbnail = '';
                                      if (isset($fields['visuel_instagram_contender']) && $fields['visuel_instagram_contender']) {
                                          $thumbnail = $fields['visuel_instagram_contender'];
                                      } elseif (isset($fields['visuel_firebase_contender']) && $fields['visuel_firebase_contender']) {
                                          $thumbnail = $fields['visuel_firebase_contender'];
                                      } else {
                                          $thumbnail = get_the_post_thumbnail_url($id_contender);
                                      }

                                      if (env() == "local" && $thumbnail) {
                                          $thumbnail = str_replace("http://localhost:8888/vkrz-wp/", "https://vainkeurz.com/", $thumbnail);
                                      }
                                    }
                                    ?>
                                    <div class="cover-illu-contender" style="background-image: url(<?php echo $thumbnail; ?>);"></div>
                                </div>
                                <h3 class="eh1">
                                  TopList <div class="weglot-div-span"><?php echo get_the_title($id_top); ?></div>
                                </h3>
                                <h2>
                                  <?php the_field('question_t', $id_top); ?>
                                </h2>
                                <div class="eh2">
                                  <?php the_field('precision_t', $id_top); ?>
                                </div>
                                <div class="separate"></div>
                                <div class="stats-contender-top mt-3">
                                  <div class="row">
                                    <div class="col-4 text-left">
                                      <div class="d-flex gap-2 align-items-center mb-2">
                                        <span class="nb_victoire_top_vkrz" rel="api"></span>
                                        <p class="mb-0">victoires</p>
                                      </div>
                                      <h5 class="mb-0 text-muted text-left">
                                        <span class="nb_percentvictoire_top_vkrz" rel="api"></span>%
                                      </h5>
                                      <small class="text-muted text-left">
                                        <span class="nb_victoire_top_vkrz" rel="api"></span>
                                      </small>
                                    </div>
                                    <div class="col-4">
                                      <div class="divider divider-vertical">
                                        <div class="divider-text">
                                          <span class="va-versus va va-lg"></span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-4 text-end">
                                      <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                        <span class="nb_defaite_top_vkrz" rel="api"></span>
                                        <p class="mb-0">défaites</p>
                                      </div>
                                      <h5 class="mb-0 text-muted text-nowrap ms-lg-n3 ms-xl-0">
                                        <span class="nb_percentdefaite_top_vkrz" rel="api"></span>%
                                      </h5>
                                    </div>
                                  </div>
                                  <div class="d-none showeloptn">
                                    <div class="mt-3 d-flex justify-content-center align-items-baseline">
                                      <h4 class="card-title mb-1 text-left d-flex align-items-baseline me-1">
                                        <span class="nb_elo_top_vkrz" rel="api"></span>
                                        <small class="d-block ms-1 text-muted">ELO</small>
                                      </h4>
                                      <span class="badge bg-label-success eloplus d-none">
                                        <span class="nb_elo_percent_top_vkrz" rel="api"></span>
                                      </span>
                                      <span class="badge bg-label-danger elomoins d-none">
                                        <span class="nb_elo_percent_top_vkrz" rel="api"></span>
                                      </span>
                                    </div>
                                  </div>
                                  <div class="separate my-3"></div>
                                  <div class="cta-preview-contender">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <a href="<?php the_permalink($id_top); ?>" class="btn-wording-slim btn-wording-rose btn-wording bubbly-button justify-content-center">
                                          Ma TopList
                                        </a>
                                      </div>
                                      <div class="col-md-6">
                                        <?php
                                          $id_toplistmondiale   = get_field('id_tm_t', $id_top);
                                          $url_toplist_mondiale = get_permalink($id_toplistmondiale);
                                        ?>
                                        <a href="<?php echo $url_toplist_mondiale; ?>" class="btn-wording toplistmondialurl btn-wording-slim" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Générée à partir de tous vos votes">
                                          TopList mondiale
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
                  <?php endif; ?>
                
                <?php endwhile; wp_reset_query(); ?>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var contenderIds = <?php echo json_encode($list_contender); ?>;
    let valeurInitiale = 1200;
    var endpoint = `${API_BASE_URL}contender/stats`;
    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ contender_ids: contenderIds })
    })
    .then(response => response.json())
    .then(data => {
      animateValue(document.querySelector('.nb_duels_vkrz'), 0, data.global_stats.nb_duel, 1000);
      animateValue(document.querySelector('.nb_victoire_vkrz'), 0, data.global_stats.nb_victory, 1000);
      animateValue(document.querySelector('.nb_defaite_vkrz'), 0, data.global_stats.nb_defeat, 1000);

      document.querySelectorAll('.contender-item-stats').forEach(item => {
            var idTop = item.getAttribute('data-top');

            // Find the stats for this idTop
            var stats = data.individual_stats.find(stat => stat.id_top == idTop);
            if (stats) {
                let percent_victory = Math.ceil(stats.percent_victory);
                let percent_defeat = 100 - percent_victory;
                animateValue(item.querySelector('.nb_victoire_top_vkrz'), 0, stats.nb_victory, 1000);
                animateValue(item.querySelector('.nb_percentdefaite_top_vkrz'), 0, percent_defeat, 1000);
                animateValue(item.querySelector('.nb_percentvictoire_top_vkrz'), 0, percent_victory, 1000);
                animateValue(item.querySelector('.nb_defaite_top_vkrz'), 0, stats.nb_defeat, 1000);
            }
        });
    })
    .catch(error => console.error('Error:', error));

    var endpointELOGlobal = `${API_BASE_URL}get-global-elo`;
    fetch(endpointELOGlobal, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ contender_ids: contenderIds })
    })
    .then(response => response.json())
    .then(data => {
      const globalElo = Math.ceil(data.global_elo);
      let progressionELOGlobal = ((globalElo - valeurInitiale) / valeurInitiale) * 100;

      if(globalElo != 1200){
        if(progressionELOGlobal >= 0) {
          document.querySelector('.eloglobalplus').classList.remove('d-none');
          document.querySelector('.eloglobalmoins').classList.add('d-none');
        } else {
          document.querySelector('.eloglobalplus').classList.add('d-none');
          document.querySelector('.eloglobalmoins').classList.remove('d-none');
        }
        const eloProgressionElements = document.querySelectorAll('.nb_eloglobal_percent_top_vkrz');
        eloProgressionElements.forEach(eloProgressionElem => {
          eloProgressionElem.textContent = progressionELOGlobal.toFixed(2) + '%';
        });
      }
      animateValue(document.querySelector('.nb_eloglobal_vkrz'), 0, globalElo, 1000);
    })
    .catch(error => console.error('Error fetching global ELO:', error));


    var endpointELO = `${API_BASE_URL}contender/elo`;
    function updateContenderElo(contenderId, contenderElem) {
        fetch(`${endpointELO}/${contenderId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data) {
                var eloData = data;
                var eloElem = contenderElem.querySelector('.nb_elo_top_vkrz');
                
                let valeurInitiale = 1200;
                let valeurActuelle = eloData.elo_c; // Remplacez ceci par la valeur actuelle
                let progressionELO = ((valeurActuelle - valeurInitiale) / valeurInitiale) * 100;

                if(valeurActuelle != 1200){
                  if(progressionELO >= 0) {
                    contenderElem.querySelector('.eloplus').classList.remove('d-none');
                    contenderElem.querySelector('.elomoins').classList.add('d-none');
                  } else {
                    contenderElem.querySelector('.eloplus').classList.add('d-none');
                    contenderElem.querySelector('.elomoins').classList.remove('d-none');
                  }
                  const eloProgressionElements = contenderElem.querySelectorAll('.nb_elo_percent_top_vkrz');
                  eloProgressionElements.forEach(eloProgressionElem => {
                    eloProgressionElem.textContent = progressionELO.toFixed(2) + '%';
                  });
                }
                if (eloElem) {
                    eloElem.textContent = eloData.elo_c;
                }
                var showEloOption = contenderElem.querySelector('.showeloptn');
                if (showEloOption) {
                    showEloOption.classList.remove('d-none');
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Loop through each contender element and make an AJAX call
    var contenderElems = document.querySelectorAll('.contender-item-stats');
    contenderElems.forEach(elem => {
        var contenderId = elem.getAttribute('data-contender');
        updateContenderElo(contenderId, elem);
    });
});
</script>

<?php get_footer(); ?>