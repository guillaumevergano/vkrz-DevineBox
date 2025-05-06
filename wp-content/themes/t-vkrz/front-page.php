<?php get_header(); ?>
<div class="my-3 front-page">
  <div class="container-xxl mt-2">
    <div class="intro-archive">
      <h1>
        Bienvenue sur la Devine Box
      </h1>
      <h2>
        Est-ce que tu connais bien ton duo ?
      </h2>
    </div>
  </div>
  <section class="creator-block">
    <div class="container-xxl">
      <div class="row">
        <div class="col-md-12">
          <div class="list-vedette-tops">
            <?php if(!isMobile()): ?>
              <div class="d-none d-sm-block">
                <div class="row">
                  <div class="col-md-3 text-center animate__fadeInUp animate__animated animate__delay-1s">
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
                  <div class="col-md-3 text-center animate__fadeInUp animate__animated animate__delay-2s">
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
                  <div class="col-md-3 text-center animate__fadeInUp animate__animated animate__delay-3s">
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
                  <div class="col-md-3 text-center animate__fadeInUp animate__animated animate__delay-4s">
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
                </div>
              </div>
            <?php else: ?>
              <div class="d-block d-sm-none">
                <div class="row">
                  <div class="col-md-3 text-center d-block d-sm-none animate__fadeInUp animate__animated">
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
  <div class="pb-5"></div>
</div>
<?php get_footer(); ?>