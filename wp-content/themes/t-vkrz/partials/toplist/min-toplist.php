<?php global $top_info; ?>
<div class="min-tournoi card">
  <div class="min-tournoi-content">
    <div class="cov-illu-container">
      <div class="cov-illu" style="background: url(<?php echo $top_info['top_img']; ?>) center center no-repeat"></div>
    </div>
  </div>
  <div class="card-body eh">
    <div class="content-badge-info-top" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="<?php echo $top_info['top_number']; ?> contenders à classer">
      <div class="content-badge-into-top-inside">
          <span class="rounded-fill badge-number-contenders">
            <?php echo $top_info['top_number']; ?> <span class="va va-versus va-lg ms-1"></span>
          <span class="rounded-fill badge-number-contenders ms-1">
            <?php echo $top_info['top_cat_icon']; ?>
          </span>
        </span>
      </div>
    </div>
    <div class="min-tournoi-title">
      <h4 class="titre-top-min"><?php echo $top_info['top_title']; ?></h4>
      <h3 class="card-title eh2"><?php echo $top_info['top_question']; ?></h3>
    </div>
  </div>
  <a href="<?php echo $top_info['top_url']; ?>" class="stretched-link"></a>
</div>