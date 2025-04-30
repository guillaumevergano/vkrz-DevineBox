<?php
global $term_rassemblement;
global $emoji_rassemblement;
?>
<div class="waiter" id="waiter-top-step1">
  <div class="loader d-flex align-items-center">
    <div class="sk-wave sk-primary">
      <div class="sk-wave-rect"></div>
      <div class="sk-wave-rect"></div>
      <div class="sk-wave-rect"></div>
      <div class="sk-wave-rect"></div>
      <div class="sk-wave-rect"></div>
    </div>
    <h4 class="mt-4">
      <span class="text-lancement-top-step1"><?= $term_rassemblement; ?></span>
    </h4>
    <div class="mt-4">
      <span class="va va-<?= $emoji_rassemblement; ?> va-5x"></span>
    </div>
  </div>
</div>
