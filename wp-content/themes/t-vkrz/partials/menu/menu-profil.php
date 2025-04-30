<nav class="navbar navbar-example navbar-expand-lg card">
  <div class="container-fluid">
    <a class="navbar-brand" href="javascript:void(0)">Menu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-menuuser">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar-ex-menuuser">
      <div class="navbar-nav me-auto">
        <?php if (!is_page(218587)) : ?>
        
          <a class="nav-item nav-link <?php if (is_page(get_page_by_path('mon-compte'))) : echo 'active'; endif; ?>" href="<?php bloginfo('url'); ?>/mon-compte">
            Mon récap
          </a>
          <a class="nav-item nav-link <?php if (is_page('mon-compte/commandes')) : echo 'active'; endif; ?>" href="<?php bloginfo('url'); ?>/mon-compte/commandes">
            Commandes
          </a>
          <a class="nav-item nav-link <?php if (is_page(305107)) : echo 'active'; endif; ?>" href="<?php the_permalink(305107); ?>">
            KEURZ
          </a>
          <a class="nav-item nav-link isconnected <?php if (is_page('mon-compte/notifications')) : echo 'btn btn-primary';
            endif; ?>" href="<?php bloginfo('url'); ?>/mon-compte/notifications">
            Notifs
          </a>
          <a class="nav-item nav-link isconnected <?php if (is_page('mon-compte/parrainage')) : echo 'active';
            endif; ?>" href="<?php bloginfo('url'); ?>/mon-compte/parrainage">
            Parrainage
          </a>
          <a class="nav-item nav-link isconnected <?php if (is_page('mon-compte/liste-des-defis')) : echo 'active';
            endif; ?>" href="<?php bloginfo('url'); ?>/mon-compte/liste-des-defis">
            Liste des défis
          </a>
        <?php else : ?>
          <a class="nav-item nav-link <?php if (is_author()) : echo 'active'; endif; ?>" href="<?php echo get_author_posts_url($vainkeur_id); ?>">
            Son récap
          </a>
          <a class="nav-item nav-link <?php if (is_page(218587)) : echo 'active'; endif; ?>" href="<?php the_permalink(218587); ?>?creator_id=<?php echo $id_membre; ?>">
            Créateur
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>