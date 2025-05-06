<?php
global $uuid_user;
global $id_top;
global $top_infos;
global $weglot_lang;
$uuid_user = give_uuid();
$env       = env();
$weglot_lang = "fr";
?>
<!DOCTYPE html>
<html lang="fr" class="dark-style dark-layout layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="horizontal-menu-template">
<head>
  <?php if (env() != "local") : ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-X229K192JX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-X229K192JX');
    </script>
    <!-- Hotjar Tracking Code for https://vainkeurz.com/ -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1825930,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
  <?php endif; ?>
  <!--[if lt IE 9]>
  <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php get_template_part('partials/favicon'); ?>
  <?php get_template_part('partials/meta'); ?>
  <meta name="msapplication-TileImage" content="<?php bloginfo('template_directory'); ?>/assets/favicon/ms-icon-144x144.png">
  <meta name="msapplication-TileColor" content="#4D1470">
  <meta name="theme-color" content="#4D1470">
  <meta property="fb:app_id" content="458083104324596">
  <meta property="og:site_name" content="VAINKEURZ" />
  <meta property="og:locale" content="fr_FR" />
  <meta property="og:type" content="article" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@VAINKEURZ">
  <meta name="twitter:creator" content="@VAINKEURZ">
  <meta name="twitter:domain" content="vainkeurz.com">
  
  <?php if (is_page(array(669114, 667210, 482612, 26626, 256697, 256700, 284944, 292414))) : ?>
    <meta name='robots' content='noindex, nofollow' />
  <?php endif; ?>

  <script>
    const env = "<?php echo $env; ?>";
    let isTopSponsoWhiteLabel = false;
  </script>

  <?php wp_head(); ?>

  <!-- IF CSS SPECIAL Exist -->
  <?php if(get_field('fichier_css_toplist', $id_top) && (get_post_type() == 'tournoi' || get_query_var('toplist_id')) && !is_archive() ) : ?>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/special/<?php the_field('fichier_css_toplist', $id_top); ?>?v=<?php echo time(); ?>">
    <script> isTopSponsoWhiteLabel = true; </script>
  <?php endif; ?>

  <?php if(isset($_GET['dontshowmenu']) && $_GET['dontshowmenu'] == 'true'): ?>
    <style>
      .layout-navbar, #toplistmondial-liste, .do-toplist-from-toplist-mondial {
        display: none;
      }
      .name{
        height: auto !important;
      }
    </style>
  <?php endif; ?>

</head>
<?php
$class_body = "";
$is_twitch = false;
if(isset($top_infos)){
  $is_twitch  = $top_infos['is_twitch'];
  if($is_twitch){
    $class_body = "twitch-top";
  }
}
if(get_query_var('toplist_devine_id')){
  $class_body = "single single-tournoi single-devine";
}
?>
<body <?php body_class($class_body); ?> id="<?php echo (get_query_var('toplist_id')) ? 'toplist-single' : ''; ?>">
  <?php if(get_post_type() == "tournoi" || get_query_var('toplist_devine_id') || get_query_var('toplist_id')): ?>
    <div class="ba-cover-r"></div>
  <?php endif; ?>

  <script>
    let uuid_user = "<?php echo $uuid_user; ?>";
    get_user_data_infos(uuid_user);
    get_user_inventaire(uuid_user);
  </script>

  <!-- Layout wrapper -->
  <div id="global-page" class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">

      <noscript>
        <div class="no-js-message">
          <p>Ton navigateur ne prend pas en charge JavaScript ou celui-ci est désactivé.<br> STP active JavaScript ou utilise un autre navigateur pour profiter de VAINKEURZ.</p>
        </div>
      </noscript>

      <!-- Navbar -->
      <?php if(get_post_type() == "tournoi"): ?>
        <div id="show-navbar-barre">
          <div class="d-none d-sm-block">
            <div class="container-fluid">
              <div class="content-show-navbar-barre row">
                <div class="col-md-6">
                  <div class="slim-left">
                    <a href="<?php bloginfo('url'); ?>" class="app-brand-link gap-2">
                      <span class="logo-simple">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.webp" alt="VAINKEURZ logo" class="img-fluid">
                      </span>
                    </a>
                    <a href="javascript:location.reload()" class="btn-annule-devine">
                      <span class="va va-disquette va-lg"></span> Quitter
                    </a>
                    <span class="toplistexists">
                      <a href="#" class="btn-annule-devine confirm_delete currentuuid" data-urltop="" data-toplistid="" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0">
                        <span class="va va-recommencer va-lg"></span> Recommencer
                      </a>
                    </span>
                    <span class="btn-annule-devine go-to-tirage-vkrz d-none cursor-pointer">
                      <a href="#" class="go-to-tirage-vkrz-btn" target="_blank">
                        <span class="va va-de va-lg"></span> Continuer en Tirage
                      </a>
                    </span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="right-slim">
                    <div class="niveau-slim">
                      <div class="progress-wrapper progressionniveau">
                        <div class="decompte-txt">
                          Encore <span class="decompte_vote"><span class="nb_decompte_level_vkrz" rel="api"></span></span> <span class="ico text-center va va-mush va-z-15"></span> pour passer <span class="user_next_level_icon" rel="api"></span></div>
                          <div class="progress progress-bar-primary w-100" style="height: 6px; margin-top: 5px;">
                            <div class="next-level-bar progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>    
          </div>
          <div class="d-block d-sm-none">
            <div class="container-fluid">
              <div class="content-show-navbar-barre row">
                <div class="col-3">
                  <div class="slim-left">
                    <a href="<?php bloginfo('url'); ?>" class="app-brand-link gap-2">
                      <span class="logo-simple">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.webp" alt="VAINKEURZ logo" class="img-fluid">
                      </span>
                    </a>
                  </div>
                </div>
                <div class="col-9">
                  <div class="row">
                    <div class="col-12 d-none d-md-block">
                      <div class="niveau-slim">
                        <div class="progress-wrapper progressionniveau">
                          <div class="decompte-txt">
                            Reste <span class="decompte_vote"><span class="nb_decompte_level_vkrz" rel="api"></span></span> <span class="ico text-center va va-mush va-z-15"></span> pour <span class="user_next_level_icon" rel="api"></span></div>
                            <div class="progress progress-bar-primary w-100" style="height: 6px; margin-top: 5px;">
                              <div class="next-level-bar progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row">
                        <div class="col-5">
                          <a href="javascript:location.reload()" class="btn-annule-devine">
                            <span class="va va-disquette va-lg"></span> Quitter
                          </a>
                        </div>
                        <div class="col-7">
                          <span class="toplistexists">
                            <a href="#" class="btn-annule-devine confirm_delete currentuuid" data-urltop="" data-toplistid="" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de cette TopList seront remis à 0">
                              <span class="va va-recommencer va-lg"></span> Recommencer
                            </a>
                          </span>
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
      <?php if(get_query_var('toplist_devine_id')): ?>
        <div id="show-navbar-barre">
          <div class="container-fluid">
            <div class="content-show-navbar-barre row">
              <div class="col-md-6 col-4">
                <div class="slim-left">
                  <a href="<?php bloginfo('url'); ?>" class="app-brand-link gap-2 d-none d-sm-block">
                    <span class="logo-simple">
                      <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.webp" alt="VAINKEURZ logo" class="img-fluid">
                    </span>
                  </a>
                  <a href="javascript:location.reload()" class="btn-annule-devine">
                    <span class="va va-eye-crossed va-lg"></span> Abandonner
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="container-xxl">
          <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="<?php bloginfo('url'); ?>" class="app-brand-link gap-2">
              <span class="logo">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.webp" alt="VAINKEURZ logo" class="img-fluid">
              </span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
              <i class="ti ti-x ti-sm align-middle"></i>
            </a>
          </div>
          <?php get_template_part('partials/menu/menu-user'); ?>
        </div>
      </nav>
      <!-- / Navbar -->

    <!-- Layout container -->
    <div class="layout-page">
      <div class="content-wrapper">
        <!-- Menu -->
        <?php get_template_part('partials/menu/menu-vkrz'); ?>
        <!-- / Menu -->

        <!-- Content -->
        <div id="content-page-gv" class="container-fluid">