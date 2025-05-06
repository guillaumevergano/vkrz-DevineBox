<?php 
global $id_top;
?>
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
  <div class="container-xxl d-flex">
    <ul class="menu-inner">
      <?php
      $cat_t = get_terms(array(
        'taxonomy'      => 'categorie',
        'orderby'       => 'count',
        'order'         => 'DESC',
        'hide_empty'    => true,
      ));
      foreach ($cat_t as $cat) : ?>
        <li class="menu-item">
          <a href="<?php echo get_category_link($cat->term_id); ?>" class="menu-link">
            <div class="iconmenu">
              <span>
                <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
              </span>
            </div>
            <div><?php echo $cat->name; ?></div>
          </a>
        </li>
      <?php endforeach; ?>
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