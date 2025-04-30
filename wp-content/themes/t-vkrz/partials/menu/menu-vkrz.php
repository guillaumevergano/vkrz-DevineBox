<?php 
global $id_top;
?>
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
  <div class="container-xxl d-flex">
    <ul class="menu-inner">
      <!-- Catégories de Tops -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <div class="iconmenu">
            <span class="va va-trophy va-lg"></span>
          </div>
          <div>Catégories</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="<?php echo bloginfo('url'); ?>/nouvelles-toplist" class="menu-link">
              <span class="iconmenu">
                <span class="va va-boiteaulettre va-lg"></span>
              </span>
              <div>
                Dernières sorties
              </div>
            </a>
          </li>
          <?php
          $cat_t = get_terms(array(
            'taxonomy'      => 'categorie',
            'orderby'       => 'count',
            'order'         => 'DESC',
            'hide_empty'    => false
          ));
          foreach ($cat_t as $cat) : ?>
            <li class="menu-item">
              <a href="<?php echo get_category_link($cat->term_id); ?>" class="menu-link">
                <span class="iconmenu">
                  <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                </span>
                <div>
                  <?php echo $cat->name; ?>
                </div>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </li>
      <!-- Des lots à gagner -->
      <li class="menu-item">
        <a href="<?php echo bloginfo('url'); ?>/lot-a-gagner" class="menu-link">
          <div class="iconmenu">
            <span class="va va-wrapped-gift va-lg"></span>
          </div>
          <div>Lots à gagner</div>
        </a>
      </li>
      <!-- Streameur -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <div class="iconmenu">
            <span class="va va-twitch-logo va-lg"></span>
          </div>
          <div>Twitch</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="https://vainkeurz.com/ambassadeur/" class="menu-link">
              <div class="iconmenu">
                <span class="va va-vulcan-salute va-lg"></span>
              </div>
              <div>Ambassadeur Twitch</div>
            </a>
          </li>
        </ul>
      </li>
      <!-- VAINKEURZ -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <div class="iconmenu">
            <span class="va va-lama va-lg"></span>
          </div>
          <div>VAINKEURZ</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="<?php echo bloginfo('url'); ?>/a-propos" class="menu-link">
              <span class="iconmenu">
                <span class="va va-monocle va-lg"></span>
              </span>
              <div>
                A propos
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php echo bloginfo('url'); ?>/blog" class="menu-link">
              <span class="iconmenu">
                <span class="va va-sun va-lg"></span>
              </span>
              <div>
                Blog
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php echo bloginfo('url'); ?>/evolution" class="menu-link">
              <span class="iconmenu">
                <span class="va va-rocket va-lg"></span>
              </span>
              <div>
                Les niveaux
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php echo bloginfo('url'); ?>/trophees" class="menu-link">
              <span class="iconmenu">
                <span class="va va-sports-medal va-lg"></span>
              </span>
              <div>
                Les trophées
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php echo bloginfo('url'); ?>/annonces" class="menu-link">
              <span class="iconmenu">
                <span class="va va-finger-you va-lg"></span>
              </span>
              <div>
                On recrute
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php echo bloginfo('url'); ?>/monitor" class="menu-link">
              <span class="iconmenu">
                <span class="va va-satellite va-lg"></span>
              </span>
              <div>
                Stats en temps réel
              </div>
            </a>
          </li>
        </ul>
      </li>
      <!-- Commu -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <div class="iconmenu">
            <span class="va va-coeurviolet va-lg"></span>
          </div>
          <div>Commu</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="<?php echo bloginfo('url'); ?>/vos-toplist" class="menu-link">
              <div class="iconmenu">
                <span class="va va-trophy va-lg"></span>
              </div>
              <div>Vos TopList</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php the_permalink(284948); ?>" class="menu-link">
              <div class="iconmenu">
                <span class="va va-cowboy va-lg"></span>
              </div>
              <div>Best créateurs</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="<?php echo bloginfo('url'); ?>/recompenses" class="menu-link">
          <div class="iconmenu">
            <span class="va va-gem va-lg"></span>
          </div>
          <div>Récompenses</div>
        </a>
      </li>
    </ul>
  </div>
  <div class="d-block d-sm-none">
    <div class="btn-group rezo-menu" role="group">
      <a href="https://discord.gg/E9H9e8NYp7" class="btn btn-outline-primary waves-effect">
        <i class="fab fa-discord"></i>
      </a>
      <a href="https://www.instagram.com/wearevainkeurz/" class="btn btn-outline-primary waves-effect">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="https://twitch.com/vainkeurz" class="btn btn-outline-primary waves-effect">
        <i class="fab fa-twitch"></i>
      </a>
      <a href="https://twitter.com/Vainkeurz" class="btn btn-outline-primary waves-effect">
        <i class="fa-brands fa-x-twitter"></i>
      </a>
      <a href="https://www.tiktok.com/@vainkeurz" class="btn btn-outline-primary waves-effect">
        <i class="fab fa-tiktok"></i>
      </a>
      <a href="https://www.youtube.com/@VAINKEURZ" class="btn btn-outline-primary waves-effect">
        <i class="fab fa-youtube"></i>
      </a>
    </div>
  </div>
</aside>