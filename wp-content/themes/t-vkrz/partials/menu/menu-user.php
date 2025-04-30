<div class="d-sm-none d-block">
  <a href="<?php bloginfo('url'); ?>" class="app-brand-mobile">
    <span class="logo">
      <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz-star-wars.png" alt="VAINKEURZ logo" class="img-fluid">
    </span>
  </a>
</div>

<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
  <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
    <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/menu.svg" class="img-fluid" alt="">
  </a>
</div>

<div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">

  <!-- Réseaux -->
  <div class="reseauxicons">
    <ul>
      <li class="menu-item d-none d-sm-block">
        <div class="rs-menu justify-content-center share-t" role="group">
          <a data-rs-name="discord" href="https://discord.gg/E9H9e8NYp7" class="btn rounded-pill btn-icon btn-outline-primary waves-effect" target="_blank">
            <i class="fab fa-discord"></i>
          </a>
          <a data-rs-name="instagram" href="https://www.instagram.com/wearevainkeurz/" class="btn rounded-pill btn-icon btn-outline-primary waves-effect" target="_blank" spellcheck="false">
            <i class="fab fa-instagram"></i>
          </a>
          <a data-rs-name="twitch" href="https://twitch.tv/Vainkeurz" target="_blank" class="btn rounded-pill btn-icon btn-outline-primary waves-effect">
            <i class="fab fa-twitch"></i>
          </a>
          <a data-rs-name="twitter" href="https://twitter.com/Vainkeurz" target="_blank" class="btn rounded-pill btn-icon btn-outline-primary waves-effect">
            <i class="fa-brands fa-x-twitter"></i>
          </a>
          <a data-rs-name="tiktok" href="https://www.tiktok.com/@vainkeurz" target="_blank" class="btn rounded-pill btn-icon btn-outline-primary waves-effect" spellcheck="false">
            <i class="fab fa-tiktok"></i>
          </a>
          <a data-rs-name="youtube" href="https://www.youtube.com/@VAINKEURZ" target="_blank" class="btn rounded-pill btn-icon btn-outline-primary waves-effect" spellcheck="false">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </li>
    </ul>
  </div>

  <div class="search d-none d-sm-block">
    <form action="<?php the_permalink(435459); ?>" method="GET" class="searchform">
      <div class="search-group">
        <div class="select-search">
          <select class="selectpicker typesearch" name="typesearch">
            <option>TopList</option>
            <option>Membres</option>
          </select>
        </div>
        <div class="input-search">
          <input name="member_to_search" type="text" minlength="3" class="searchmembres form-control typeahead-prefetch" autocomplete="off" placeholder="Rechercher des membres...">
          <input name="term_to_search" type="text" minlength="3" class="searchtops form-control typeahead-prefetch" autocomplete="off" placeholder="Rechercher des TopList...">
        </div>
        <div class="btn-loupe">
          <button class="submitbtn" type="submit">
            <span class="va va-loupe va-md decal-l-2"></span>
          </button>
        </div>
      </div>
    </form>
  </div>

  <div class="menu-user-div">
    <ul id="menu-user-ul" class="navbar-nav flex-row align-items-center ms-auto">

      <!-- Search mobile  -->
      <li class="nav-item me-2 me-xl-0 d-block d-sm-none">
        <a class="nav-link opensearch" href="#">
          <span class="va va-z-20 va va-loupe"></span>
        </a>
      </li>
      <!-- /Search mobile  -->
      <!-- Statisques  -->
      <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
        <a id="showstatsusers" class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
          <span class="user_level_icon isconnected" rel="api"></span>
          <span class="notconnected">
            <span class="va va-z-20 va-level-icon va-egg"></span>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end py-0">
          <div class="dropdown-shortcuts-list scrollable-container">
            <div class="row row-bordered overflow-visible g-0">
              <div class="dropdown-shortcuts-item col">
                <a class="stretched-link" href="<?php bloginfo('url'); ?>/mon-compte">
                  <div class="progress-wrapper progressionniveau isconnected">
                    <div class="decompte-txt">
                      Encore <span class="decompte_vote"><span class="nb_decompte_level_vkrz" rel="api"></span></span> <span class="ico text-center va va-mush va-z-15"></span> pour passer <span class="user_next_level_icon" rel="api"></span></div>
                    <div class="progress progress-bar-primary w-100" style="height: 6px; margin-top: 5px;">
                      <div class="next-level-bar progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="progress-wrapper progressionniveau notconnected">
                    <div class="decompte-txt">
                      Inscris-toi pour débloquer les niveaux
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
              <div class="dropdown-shortcuts-item col">
                <a href="<?php bloginfo('url'); ?>/mon-compte" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-mush va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <span class="xp_vkrz" rel="api">0</span>
                      <small class="text-muted mb-0">XP</small>
                    </div>
                  </div>
                </a>
              </div>
              <div class="dropdown-shortcuts-item col">
                <a href="<?php bloginfo('url'); ?>/mon-compte/keurz" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-gem va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <span class="money_dispo_vkrz" rel="api">0</span>
                      <small class="text-muted mb-0">KEURZ</small>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
              <div class="dropdown-shortcuts-item col">
                <a href="<?php bloginfo('url'); ?>/mon-compte" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-trophy va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <span class="nb_tops_vkrz" rel="api">0</span>
                      <small class="text-muted mb-0">TopList</small>
                    </div>
                  </div>
                </a>
              </div>
              <div class="dropdown-shortcuts-item col">
                <a href="<?php bloginfo('url'); ?>/mon-compte" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-high-voltage va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <span class="nb_votes_vkrz" rel="api">0</span>
                      <small class="text-muted mb-0">votes</small>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </li>
      <!-- /Statisques -->

      <!-- Notification  -->
      <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1 isconnected">
        <a class="menuuser-bell nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
          <span class="va va-z-20 va-bell"></span>
          <span class="badge bg-danger rounded-pill badge-notifications d-none notifications-nombre">-</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end py-0">
          <li class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
              <h5 class="text-body mb-0 me-auto">Notifications</h5>
              <div class="badge rounded-pill bg-label-primary">
                <span class="notifications-nombre">-</span>
                <span class="notifications-span"></span>
              </div>
            </div>
          </li>
          <li class="dropdown-notifications-list scrollable-container">
            <ul class="list-group list-group-flush">
              <li class="scrollable-container media-list notifications-container perfectScrollbar">
              </li>
            </ul>
          </li>
          <li class="dropdown-menu-footer border-top">
            <a href="<?php the_permalink(get_page_by_path('mon-compte/notifications')); ?>" class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
              Voir toutes les notifications
            </a>
          </li>
        </ul>
      </li>
      <!-- Notification -->

      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown me-xl-1 isconnected">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <div class="avatar-tofill avatarbox-s"></div>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/mon-compte">
            Mon compte
          </a>
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/mon-compte/liste-des-defis/">
            Mes défis Devine
          </a>
          <a class="dropdown-item is_gestionnaire" href="<?php bloginfo('url'); ?>/gestion/listing-des-tops">
            Gestionnaire global
          </a>
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/creation/listing-top">
            Mes TopList <span class="va va-casier va-lg"></span>
          </a>
          <a class="dropdown-item" href="<?php the_permalink(305107); ?>">
            Mes KEURZ <span class="va va-gem va-lg"></span>
          </a>
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/mon-compte/mon-recap/">
            Mon récap
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php the_permalink(27794); ?>">
            Paramètres
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" id="deconnection_cta">
            Déconnexion <span class="va va-waving-hand va-lg"></span>
          </a>
        </ul>
      </li>
      <!--/ User -->

      <!-- Create Top -->
      <li class="nav-item ms-2 d-none d-sm-block">
        <a class="nav-link btn btn-primary waves-effect waves-light btn-log" href="<?php the_permalink(get_page_by_path(('creation'))); ?>">
          Créer une TopList
        </a>
      </li>
      <!--/ Create Top -->

      <!-- Connexion / Inscription -->
      <li class="nav-item ms-1 cta-connexion d-none">
        <a class="nav-link btn btn-rose waves-effect waves-light btn-log" id="connection_cta" href="<?php bloginfo('url'); ?>/inscription">
          <span class="d-block d-sm-none">
            Mon compte
          </span>
          <span class="d-none d-sm-block">
            Connexion / Inscription
          </span>
        </a>
      </li>
      <!-- Connexion / Inscription -->
    </ul>
  </div>
</div>