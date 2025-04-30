<?php
if (isset($_GET['statut']) && $_GET['statut'] != "") {
  $statut = $_GET['statut'];
} else {
  $statut = "validation";
}
?>
<div id="menu-gestionnaire" class="row">
  <div class="col-md-2">
    <nav class="navbar navbar-filters navbar-expand-lg card">
      <div id="searchtable"></div>
    </nav>
  </div>
  <div class="col-md-6">
    <nav class="navbar navbar-filters navbar-expand-lg card">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-gestion">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-ex-gestion">
        <div class="navbar-nav">
          <a class="nav-item nav-link text-warning <?php echo ($statut == "" || $statut == "validation") ? 'active' : ''; ?>" href="<?php bloginfo('url'); ?>/gestion/listing-des-tops?statut=validation">
            A valider <span id="top_validation" class="badge bg-label-warning badge-center ms-1">0</span>
          </a>
          <a class="nav-item nav-link text-success <?php echo ($statut == "valide") ? 'active' : ''; ?>" href="<?php bloginfo('url'); ?>/gestion/listing-des-tops?statut=valide">
            Actifs <span id="top_valide" class="badge bg-label-success badge-center ms-1">0</span>
          </a>
          <a class="nav-item nav-link text-info <?php echo ($statut == "creation") ? 'active' : ''; ?>" href="<?php bloginfo('url'); ?>/gestion/listing-des-tops?statut=creation">
            Créa <span id="top_creation" class="badge bg-label-info badge-center ms-1">0</span>
          </a>
          <a class="nav-item nav-link text-danger <?php echo ($statut == "refuse") ? 'active' : ''; ?>" href="<?php bloginfo('url'); ?>/gestion/listing-des-tops?statut=refuse">
            Refus <span id="top_refuse" class="badge bg-label-danger badge-center ms-1">0</span>
          </a>
          <a class="nav-item nav-link text-secondary <?php echo ($statut == "archive") ? 'active' : ''; ?>" href="<?php bloginfo('url'); ?>/gestion/listing-des-tops?statut=archive">
            Archive <span id="top_archive" class="badge bg-label-secondary badge-center ms-1">0</span>
          </a>
        </div>
      </div>
    </nav>
  </div>
  <div class="col-md-4">
    <nav class="navbar navbar-filters navbar-expand-lg card">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-gestion2">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-ex-gestion2">
        <div id="customNavbarFilter" class="navbar-nav me-auto">
          <a class="nav-item nav-link text-primary" data-filter="classik" href="#">
            Classik <span id="top_classik_nb" class="badge bg-label-primary badge-center ms-1">0</span>
          </a>
          <a class="nav-item nav-link text-secondary" data-filter="prive" href="#">
            Privé <span id="top_private_nb" class="badge bg-label-secondary badge-center ms-1">0</span>
          </a>
          <a class="nav-item nav-link text-dark" data-filter="sponso" href="#">
            Sponso <span id="top_sponso_nb" class="badge bg-label-dark badge-center ms-1">0</span>
          </a>
        </div>
      </div>
    </nav>
  </div>
</div>