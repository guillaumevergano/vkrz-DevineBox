<div class="d-sm-none d-block">
  <a href="<?php bloginfo('url'); ?>" class="app-brand-mobile">
    <span class="logo">
      <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.webp" alt="VAINKEURZ logo" class="img-fluid">
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
</div>