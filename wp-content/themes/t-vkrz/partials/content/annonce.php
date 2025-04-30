<div class="col-sm-6 col-lg-4">
  <div class="card p-2 h-100 shadow-none border">
    <div class="rounded-2 text-center mb-3">

    </div>
    <div class="card-body p-3 pt-2">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <?php
        $support = get_field('support_annonce');
        switch ($support[0]) {
          case 'Discord':
            $label = 'secondary';
            break;
          case 'Twitch':
            $label = 'primary';
            break;
          case 'Twitter':
            $label = 'info';
            break;
          case 'Instagram':
            $label = 'warning';
            break;
          case 'Reddit':
            $label = 'success';
            break;
          case 'Site web':
            $label = 'primary';
            break;
          case 'Youtube':
            $label = 'danger';
            break;
          case 'TikTok':
            $label = 'dark';
            break;
          default:
            $label = 'dark';
            break;
        }
        ?>
        <span class="badge bg-label-<?php echo $label; ?> text-uppercase">
          <?php the_field('support_annonce'); ?>
        </span>
      </div>
      <h2 class="h5 t-rose text-uppercase">
        <?php the_title(); ?>
      </h2>
      <div class="mt-2">
        <?php the_content(); ?>
      </div>
      <?php
      if (!get_field('pourvue_annonce')) : ?>
        <p class="d-flex align-items-center text-muted">
          <?php the_field('minimum_annonce'); ?>
        </p>
        <p class="d-flex align-items-center text-muted">
          <?php the_field('remuneration_annonce'); ?>
        </p>
        <div class="d-flex flex-column flex-md-row gap-2 text-nowrap">
          <?php if (get_field('postuler_label_annonce')) : ?>
            <a class="app-academy-md-50 btn btn-label-info d-flex align-items-center" href="<?php the_field('postuler_lien_annonce'); ?>">
              <span class="me-2"><?php the_field('postuler_label_annonce'); ?></span> <i class="ti ti-chevron-right scaleX-n1-rtl ti-sm"></i>
            </a>
          <?php else : ?>
            <a class="app-academy-md-50 btn btn-label-primary d-flex align-items-center" href="https://discord.gg/E9H9e8NYp7" target="_blank">
              <span class="me-2">Postuler sur notre Discord</span> <i class="ti ti-chevron-right scaleX-n1-rtl ti-sm"></i>
            </a>
          <?php endif; ?>
        </div>
      <?php else : ?>
        <div class="d-flex flex-column flex-md-row gap-2 text-nowrap">
          <div class="app-academy-md-50 btn btn-label-dark d-flex align-items-center">
            <span class="me-2">
              <?php the_field('pourvue_annonce'); ?>
            </span>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>