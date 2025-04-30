<?php get_header(); ?>
<div class="my-3 front-page">
  <section class="creator-block">
    <div class="container-xxl">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-7">
          <div class="tournament-heading-top animate__fadeInDown animate__animated">
            <h1 class="t-titre-tournoi top-title-question-home">
              <a href="<?php bloginfo('url'); ?>/derniers-tops">
                <em><span class="va va-vulcan-salute va-lg"></span> Que la force soit avec nous</em>
                pour devenir le site le plus Kool de la galaxie <span class="ms-2 va va-satellite va-lg"></span>
              </a>
            </h1>
          </div>
        </div>
        <div class="col-md-5">
          <div class="prez-vkrz">
            <?php if(weglot_get_current_language() == 'fr'): ?>
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/dyTBhglv3QU?si=0BIJs7H3htbvZEGy&autoplay=1&mute=1&start=20" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <?php elseif(weglot_get_current_language() == 'br'): ?>
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/IotC7DWiYAA?si=7i8vymlMioyAVMz3&autoplay=1&mute=1&start=20" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <?php else: ?>
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/UQvxxEV_jLw?si=zfsHtNXn07rWZvkP&autoplay=1&mute=1&start=20" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 col-12 order-2 order-sm-1">
          <?php
          $tops_sponso                  = new WP_Query(array(
            'post_type'                 => 'tournoi',
            'orderby'                   => 'date',
            'order'                     => 'DESC',
            'posts_per_page'            => -1,
            'ignore_sticky_posts'       => true,
            'update_post_meta_cache'    => false,
            'no_found_rows'             => true,
            'tax_query'                 => array(
              'relation' => 'AND',
              array(
                'taxonomy' => 'type',
                'field'    => 'slug',
                'terms'    => array('sponso'),
                'operator' => 'IN'
              ),
              array(
                'taxonomy' => 'type',
                'field'    => 'slug',
                'terms'    => array('private'),
                'operator' => 'NOT IN'
              ),
            ),
          ));
          if ($tops_sponso->have_posts()) : ?>
            <div class="titre-img">
              <h3 class="titre-section text-left titre-section-emojibig-2">
                <a href="<?php bloginfo('url'); ?>/toplist-sponso">
                  <span class="va va-finger-down va-lg"></span> À gagner
                </a>
              </h3>
              <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/gift.svg" class="img-fluid img-gift animate__fadeInDown animate__animated animate__delay-1s" alt="">
            </div>
            <div class="animate__flipInY animate__animated">
              <div class="slick-carousel">
                <?php while ($tops_sponso->have_posts()) : $tops_sponso->the_post();
                    global $id_top;
                    $id_top = get_the_ID();
                    get_template_part('partials/toplist/min-sponso');
                endwhile;
                wp_reset_query(); ?>
              </div>
              <div class="slick-nav">
                <div class="vk-prev vk-nav">
                  <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/left-arrow.png" class="img-fluid" alt="">
                </div>
                <div class="slick-nav-dots"></div>
                <div class="vk-next vk-nav">
                  <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/right-arrow.png" class="img-fluid" alt="">
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
        <div class="col-md-9 col-12 order-1 order-sm-2">
          <div class="list-vedette-tops">
            <?php if(!isMobile()): ?>
              <div class="d-none d-sm-block">
                <div class="row">
                  <div class="col-md-4 text-center animate__fadeInUp animate__animated">
                    <h3 class="titre-section text-center titre-section-emojibig">
                      <a href="https://vainkeurz.com/rubrique/star-wars/">
                        <span class="va va-soucoupe va-lg"></span> Star Wars
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
                    <div class="slick-carousel-cat6">
                      <?php while ($tops_vedette_cat->have_posts()) : $tops_vedette_cat->the_post();
                        global $top_info;
                        $top_info = get_top_infos(get_the_ID(), 'slim');
                        get_template_part('partials/toplist/min-toplist');
                      endwhile; ?>
                    </div>
                    <div class="slick-nav">
                      <div class="vk-prev-cat6 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/left-arrow.png" class="img-fluid" alt="">
                      </div>
                      <div class="slick-nav-dots-cat6"></div>
                      <div class="vk-next-cat6 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/right-arrow.png" class="img-fluid" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 text-center animate__fadeInUp animate__animated animate__delay-1s">
                    <h3 class="titre-section text-center titre-section-emojibig">
                      <a href="<?php bloginfo('url'); ?>/cat/manga">
                        <span class="va va-dragon va-lg"></span> Manga/Animés
                      </a>
                    </h3>
                    <?php
                    $tops_vedette_cat_ids = get_field('manga_tops_vedette', 'option');
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
                    <div class="slick-carousel-cat1">
                      <?php while ($tops_vedette_cat->have_posts()) : $tops_vedette_cat->the_post();
                        global $top_info;
                        $top_info = get_top_infos(get_the_ID(), 'slim');
                        get_template_part('partials/toplist/min-toplist');
                      endwhile; ?>
                    </div>
                    <div class="slick-nav">
                      <div class="vk-prev-cat1 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/left-arrow.png" class="img-fluid" alt="">
                      </div>
                      <div class="slick-nav-dots-cat1"></div>
                      <div class="vk-next-cat1 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/right-arrow.png" class="img-fluid" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 text-center animate__fadeInUp animate__animated animate__delay-2s">
                    <h3 class="titre-section text-center titre-section-emojibig">
                      <a href="<?php bloginfo('url'); ?>/cat/jeux-video">
                        <span class="va va-jv va-lg"></span> Jeux vidéo
                      </a>
                    </h3>
                    <?php
                    $tops_vedette_cat_ids = get_field('jv_tops_vedette', 'option');
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
                    <div class="slick-carousel-cat2">
                      <?php while ($tops_vedette_cat->have_posts()) : $tops_vedette_cat->the_post();
                        global $top_info;
                        $top_info = get_top_infos(get_the_ID(), 'slim');
                        get_template_part('partials/toplist/min-toplist');
                      endwhile; ?>
                    </div>
                    <div class="slick-nav">
                      <div class="vk-prev-cat2 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/left-arrow.png" class="img-fluid" alt="">
                      </div>
                      <div class="slick-nav-dots-cat2"></div>
                      <div class="vk-next-cat2 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/right-arrow.png" class="img-fluid" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 text-center animate__fadeInUp animate__animated animate__delay-3s">
                    <h3 class="titre-section text-center titre-section-emojibig">
                      <a href="<?php bloginfo('url'); ?>/cat/musique">
                        <span class="va va-music va-lg"></span> Musique
                      </a>
                    </h3>
                    <?php
                    $tops_vedette_cat_ids = get_field('musique_tops_vedette', 'option');
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
                    <div class="slick-carousel-cat3">
                      <?php while ($tops_vedette_cat->have_posts()) : $tops_vedette_cat->the_post();
                        global $top_info;
                        $top_info = get_top_infos(get_the_ID(), 'slim');
                        get_template_part('partials/toplist/min-toplist');
                      endwhile; ?>
                    </div>
                    <div class="slick-nav">
                      <div class="vk-prev-cat3 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/left-arrow.png" class="img-fluid" alt="">
                      </div>
                      <div class="slick-nav-dots-cat3"></div>
                      <div class="vk-next-cat3 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/right-arrow.png" class="img-fluid" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 text-center animate__fadeInUp animate__animated animate__delay-4s">
                    <h3 class="titre-section text-center titre-section-emojibig">
                      <a href="<?php bloginfo('url'); ?>/cat/food">
                        <span class="va va-food va-lg"></span> Food
                      </a>
                    </h3>
                    <?php
                    $tops_vedette_cat_ids = get_field('food_tops_vedette', 'option');
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
                    <div class="slick-carousel-cat4">
                      <?php while ($tops_vedette_cat->have_posts()) : $tops_vedette_cat->the_post();
                        global $top_info;
                        $top_info = get_top_infos(get_the_ID(), 'slim');
                        get_template_part('partials/toplist/min-toplist');
                      endwhile; ?>
                    </div>
                    <div class="slick-nav">
                      <div class="vk-prev-cat4 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/left-arrow.png" class="img-fluid" alt="">
                      </div>
                      <div class="slick-nav-dots-cat4"></div>
                      <div class="vk-next-cat4 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/right-arrow.png" class="img-fluid" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 text-center animate__fadeInUp animate__animated animate__delay-5s">
                    <h3 class="titre-section text-center titre-section-emojibig">
                      <a href="<?php bloginfo('url'); ?>/cat/autres">
                        <span class="va va-cheese3 va-lg"></span> Insolite
                      </a>
                    </h3>
                    <?php
                    $tops_vedette_cat_ids = get_field('wtf_tops_vedette', 'option');
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
                    <div class="slick-carousel-cat5">
                      <?php while ($tops_vedette_cat->have_posts()) : $tops_vedette_cat->the_post();
                        global $top_info;
                        $top_info = get_top_infos(get_the_ID(), 'slim');
                        get_template_part('partials/toplist/min-toplist');
                      endwhile; ?>
                    </div>
                    <div class="slick-nav">
                      <div class="vk-prev-cat5 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/left-arrow.png" class="img-fluid" alt="">
                      </div>
                      <div class="slick-nav-dots-cat5"></div>
                      <div class="vk-next-cat5 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/right-arrow.png" class="img-fluid" alt="">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <div class="d-block d-sm-none">
                <div class="row">
                  <div class="col-md-4 text-center d-block d-sm-none animate__fadeInUp animate__animated">
                    <h3 class="titre-section text-center titre-section-emojibig">
                      <a href="<?php bloginfo('url'); ?>/derniers-tops">
                        <span class="va va-star va-lg"></span> TopList en vedette
                      </a>
                    </h3>
                    <?php
                    $tops_vedette_cat_ids = get_field('mobile_tops_vedette', 'option');
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
                    <div class="slick-carousel-cat7">
                      <?php while ($tops_vedette_cat->have_posts()) : $tops_vedette_cat->the_post();
                        global $top_info;
                        $top_info = get_top_infos(get_the_ID(), 'slim');
                        get_template_part('partials/toplist/min-toplist');
                      endwhile; ?>
                    </div>
                    <div class="slick-nav">
                      <div class="vk-prev-cat7 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/left-arrow.png" class="img-fluid" alt="">
                      </div>
                      <div class="slick-nav-dots-cat7"></div>
                      <div class="vk-next-cat7 vk-nav">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/right-arrow.png" class="img-fluid" alt="">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="commu-block">
    <div class="container-xxl">
      <h2 class="absolute-word">
        Commu
      </h2>
      <div class="row gy-5">
        <div class="col-md-9">
          <div class="rvedette-home">
            <div class="bloc">
              <section class="list-vedette">
                <div class="text-center">
                  <h3 class="titre-section mt-0">
                    <a href="<?php bloginfo('url'); ?>/derniers-tops">
                      <span class="va va-barber va-lg"></span> Populaire en ce moment
                    </a>
                  </h3>
                </div>
                <div id="rendervedettetops" class="row">
                </div>
              </section>
            </div>
          </div>
        </div>
        <?php if(!isMobile()): ?>
          <div class="col-md-3">
            <?php get_template_part('partials/widget/toplist-monde'); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <section class="news-block bg-trapezoid bg-trapezoid-c5">
    <div class="container-xxl">
      <p class="absolute-word">
        Twitch
      </p>
      <div class="row">
        <?php if(!isMobile()): ?>
          <div class="col-md-3 d-none d-sm-block">
            <div class="bloc">
              <h3 class="titre-section mt-0">
                <a href="<?php bloginfo('url'); ?>/replay#shorts">
                  Dernier short <i class="va va-micro va-z-20"></i>
                </a>
              </h3>
              <div class="content-box d-flex align-items-center">
                <div style="position:relative; width:100%; height:0px; padding-bottom:177.778%"><iframe allow="fullscreen;autoplay" allowfullscreen height="100%" src="https://streamable.com/e/3ug33t?autoplay=1&muted=1" width="100%" style="border:none; width:100%; height:100%; position:absolute; left:0px; top:0px; overflow:hidden;"></iframe></div>
              </div>
            </div>
          </div>
        <?php endif; ?>
        <div class="col-md-4">
          <div class="d-flex justify-content-center">
            <h3 class="titre-section mt-0">
              <a href="https://www.twitch.tv/Vainkeurz" target="_blank">
                <span class="va va-rondviolet va-lg me-1"></span> Programme Twitch
              </a>
            </h3>
          </div>
          <div class="row">
            <div class="col-md-12">
              <a href="https://www.twitch.tv/vainkeurz" target="_blank">
                <?php echo wp_get_attachment_image(get_field('planning_home', 586994), 'large', '', array('class' => 'img-fluid')); ?>
              </a>
            </div>
            <div class="col-md-12 mt-4">
              <div class="twitch-embed">
                <iframe src="https://player.twitch.tv/?channel=vainkeurz&parent=vainkeurz.com" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 mt-5 mt-sm-0">
          <div class="extension">
            <div class="content-extension">
              <div class="row align-items-center">
                <div class="col-12">
                  <a href="https://prez-vainkeurz.com/toplist-live-twitch" target="_blank">
                    <div class="p-3 pb-0">
                      <div>
                        <h5 class="t-violet">Tu fais des lives sur Twitch ?</h5>
                        <p>
                          Clique ici pour découvrir nos <span class="va va-keycap-digit-three va-md"></span> mode de jeu pour faire des TopList avec tes viewers.
                          <br>
                          Tes viewers s'amusent à <span class="t-rose">deviner tes choix en votant 1 ou 2 dans chaque duel</span> avec le mode Battle Royale et le mode Championnant.
                          <br><br>
                          <span class="text-muted">
                            Il n'y a rien à installer et tout est gratuit.
                          </span>
                        </p>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-12">
                <div class="demoextension p-3">
                  <video autoplay loop muted poster="<?php bloginfo('template_directory'); ?>/assets/video/poster-demo.png">
                    <source src="<?php bloginfo('template_directory'); ?>/assets/video/demo.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la balise video.
                  </video>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="list-categories">
    <div class="container-xxl">
      <?php get_template_part('partials/widget/list-cat'); ?>
    </div>
  </section>
</div>
<script>
  fetchDataFuncHelper(`${SITE_BASE_URL}wp-json/v1/getpopulartops/8/${uuid_user}`)
  .then(results => {
    if (results) {
      const divToFillWithTops = document.querySelector('#rendervedettetops');
      processTops(results[0].list_tops, divToFillWithTops, "col-sm-4 col-md-3 col-6");

      console.log('results[0].top_id_most_popular', results[0].top_id_most_popular);
      if (results.length > 0 && results[0].top_id_most_popular) {
        displayTopListMondialeVedette(results[0].top_id_most_popular);
      }
    } else {
      console.log('Pas de résultats ou format de réponse inattendu.');
    }
  })
  .catch(error => {
    console.error('Erreur lors de la récupération des données:', error);
  });
</script>
<?php get_footer(); ?>