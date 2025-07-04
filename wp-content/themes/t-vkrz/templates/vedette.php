<?php
/*
Template Name: Vedette
*/
?>
<?php get_header(); ?>
<div class="my-3 front-page">
  <div class="container-xxl mt-2">
    <div class="intro-archive">
      <h1>
        Bienvenue sur la Devine Box
      </h1>
      <h2>
        Toutes les TopList les plus populaires
      </h2>
    </div>
  </div>
  <section class="creator-block">
    <div class="container-xxl">
      <div class="row">
        <div class="col-md-9">
           <section class="row match-height mt-4" id="rendervedettetops">
              <div class="col-md-4 col-6 me-50">
                <div class="card loading-card">
                  <div class="card-1">
                  </div>
                  <div class="card-2 p-3">
                    <div class="row">
                      <div class="col-4">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-6">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-2">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-10">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6 me-50">
                <div class="card loading-card">
                  <div class="card-1">
                  </div>
                  <div class="card-2 p-3">
                    <div class="row">
                      <div class="col-4">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-6">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-2">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-10">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6 me-50">
                <div class="card loading-card">
                  <div class="card-1">
                  </div>
                  <div class="card-2 p-3">
                    <div class="row">
                      <div class="col-4">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-8">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-6">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-2">
                        <div class="inner-card">
                        </div>
                      </div>
                      <div class="col-10">
                        <div class="inner-card">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
        </div>
        <div class="col-md-3">
          <div class="text-center animate__fadeInUp animate__animated animate__delay-2s">
            <h3 class="titre-section text-center titre-section-emojibig mt-3">
              <a href="<?php bloginfo('url'); ?>/cat/food">
                <span class="va va-crown va-lg"></span> Record à battre
              </a>
            </h3>
            <?php
            $tops_vedette_cat_ids = get_field('special_tops_vedette', 'option');
            $tops_vedette_cat = new WP_Query(array(
              'ignore_sticky_posts'      => true,
              'update_post_meta_cache'   => false,
              'no_found_rows'            => true,
              'post_type'                => 'tournoi',
              'posts_per_page'           => -1,
              'post__in'                 => $tops_vedette_cat_ids,
              'orderby'                  => 'post__in'
            ));
            ?>
            <?php while ($tops_vedette_cat->have_posts()) : $tops_vedette_cat->the_post(); ?>
              <div class="min-tournoi card mb-4">
                <div class="min-tournoi-content">
                  <div class="cov-illu-container">
                    <div class="cov-illu" style="background: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>) center center no-repeat"></div>
                  </div>
                </div>
                <div class="card-body eh">
                  <div class="min-tournoi-title">
                    <h4 class="titre-top-min"><?php the_title(); ?></h4>
                    <h3 class="card-title eh2"><?php the_field('question_t'); ?></h3>
                  </div>
                </div>
                <a href="<?php the_permalink(); ?>" class="stretched-link"></a>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="pb-5"></div>
</div>
<script>
fetchDataFuncHelper(`${SITE_BASE_URL}wp-json/v1/getalltopsfromvedetteconvention/`)
  .then(results => {
    const divToFillWithTops = document.querySelector('#rendervedettetops');
    const topList = results;
    processTops(topList, divToFillWithTops, "col-md-4 col-6");
  });
</script>
<?php get_footer(); ?>