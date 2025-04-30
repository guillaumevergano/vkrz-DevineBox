
  </div>
  <!--/ Content -->

  <?php get_template_part('partials/rechercher'); ?>

  <!-- Overlay -->
  <div class="layout-overlay layout-menu-toggle"></div>
  <!-- /Overlay -->
  <!-- Drag Target Area To SlideIn Menu On Small Screens -->
  <div class="drag-target"></div>
  <!--/ Layout wrapper -->

  <!-- Footer -->
  <footer class="content-footer footer bg-footer-theme">
    <div class="container">
      <div class="container-fluid container-p-x pb-1">
        <div class="row mb-sm-3 mb-0">
          <div class="col-12 col-md-4 mb-md-0">
            <div class="blockquote-wrapper">
              <div class="blockquote">
                <h6>
                  <span class="va-satellite va va-lg"></span> On bosse fort pour que la NASA nous déclare site le plus kool de la galaxie
                </h6>
                <h6>
                  <span class="va-satellite va va-lg"></span> On bosse fort pour que la NASA nous déclare site le plus kool de la galaxie
                </h6>
                <h5 class="name-author">
                  Guillaume - Alias Vergy
                </h5>
              </div>
            </div>
          </div>
          <div class="col-12 offset-md-1 col-md-7">
            <div class="row mt-5 mt-sm-0">
              <div class="col-6">
                <ul class="list-unstyled m-0">
                  <li class="mb-2">
                    <a href="https://vainkeurz.com/live-twitch" target="_blank">
                      TopList sur <span class="badge bg-label-twitch text-capitalize px-2">Twitch</span>
                    </a>
                  </li>
                  <li class="my-2">
                    <a href="<?php bloginfo('url'); ?>/creation">
                      Créer une TopList
                    </a>
                  </li>
                  <li class="my-2">
                    <a href="<?php bloginfo('url'); ?>/monitor">
                      Stats en temps réel <span class="va va-satellite va-lg"></span>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-6 m-0">
                <ul class="list-unstyled">
                  <li class="mb-2">
                    <a href="<?php bloginfo('url'); ?>/a-propos">L'histoire <div class="va va-victory-hand va-md"></div> VAINKEURZ</a>
                  </li>
                  <li class="my-2">
                    <a href="<?php bloginfo('url'); ?>/annonces">L'ékipe <span class="badge bg-label-primary text-capitalize px-2">on recrute</span></a>
                  </li>
                  <li class="my-2">
                    <a href="<?php bloginfo('url'); ?>/newsletter">
                      Ne rien rater <span class="badge bg-label-primary text-capitalize px-2">Newsletter</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-container pb-1 text-center">
        <div class="separate mt-3 mb-3"></div>
        <div class="share-menu">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-3">
              <div id="weglot_here"></div>
            </div>
            <div class="col-9">
              <ul class="share-links list-unstyled m-0 list-inline">
                <li class="list-inline-item">
                  <a href="https://www.youtube.com/@VAINKEURZ" target="_blank">
                    <i class="fab fa-youtube"></i> Youtube
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://twitter.com/Vainkeurz" target="_blank">
                    <i class="fa-brands fa-x-twitter fab"></i> Twitter
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://twitch.tv/Vainkeurz" target="_blank">
                    <i class="fab fa-twitch"></i> Twitch
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://discord.gg/E9H9e8NYp7" target="_blank">
                    <i class="fab fa-discord"></i> Discord
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://www.instagram.com/wearevainkeurz/" target="_blank">
                    <i class="fab fa-instagram"></i> Instagram
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="https://www.tiktok.com/@vainkeurz" target="_blank">
                    <i class="fab fa-tiktok"></i> TikTok
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="separate mt-3 mb-3"></div>
        <div class="copyright">
          <span class="me-1">
            ©<?php echo date('Y') + 100; ?> VAINKEURZ - Développé quelque part entre Paris <span class="va va-md va-france"></span> et Neptune <span class="va va-md va-neptune"></span>
          </span>
          <a href="<?php bloginfo('url'); ?>/ml">Mentions légales - CGU - </a>
          <a href="mailto:weare@vainkeurz.com"><b>Email : </b>weare@vainkeurz.com</a>
        </div>
      </div>
    </div>
  </footer>
  <!-- / Footer -->

  <?php wp_footer(); ?>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const menu = document.getElementById('layout-menu');
    const hoverSound = new Audio('<?php bloginfo('template_url'); ?>/assets/audios/laser.mp3');
    hoverSound.preload = 'auto';
    hoverSound.volume = 1.0;
    hoverSound.loop = true; // Optionnel : faire boucler le son si besoin

    let soundUnlocked = false;

    function unlockSound() {
      soundUnlocked = true;
      document.removeEventListener('click', unlockSound);
      document.removeEventListener('keydown', unlockSound);
      document.removeEventListener('scroll', unlockSound);
    }

    document.addEventListener('click', unlockSound);
    document.addEventListener('keydown', unlockSound);
    document.addEventListener('scroll', unlockSound);

    menu.addEventListener('mouseenter', () => {
      if (soundUnlocked) {
        hoverSound.currentTime = 0;
        hoverSound.play().catch((error) => {
          console.error('Erreur lors de la lecture du son :', error);
        });
      }
    });

    menu.addEventListener('mouseleave', () => {
      hoverSound.pause();
      hoverSound.currentTime = 0; // Remettre au début pour la prochaine fois
    });
  });
  </script>
  <script type="text/javascript">
    if (!window.location.href.includes('localhost') && getParamURL('iframe') != "true") {
      let checkUserIsConnected = localStorage.getItem('userConnected');
      const userData = localStorage.getItem("user_info");
      const userInfos = JSON.parse(userData);
      window.$crisp = [];
      window.CRISP_WEBSITE_ID = "ec6a3187-bf39-4eb5-a90d-dda00a2995c8";
      (function() {
        d = document;
        s = d.createElement("script");
        s.src = "https://client.crisp.chat/l.js";
        s.async = 1;
        d.getElementsByTagName("head")[0].appendChild(s);
      })();
      if(userInfos){
        $crisp.push(["set", "user:email", [`${userInfos.email_user}`]]);
        $crisp.push(["set", "user:nickname", [`${userInfos.pseudo_user}`]]);
        $crisp.push(["set", "user:avatar", [`${userInfos.avatar_user}`]]);
      }
      $crisp.push(["safe", true]);
    }
    setTimeout(() => { document.querySelector('#menu-user-ul').style.opacity = '1'; }, 500);
  </script>
  <script>function loadScript(a){var b=document.getElementsByTagName("head")[0],c=document.createElement("script");c.type="text/javascript",c.src="https://tracker.metricool.com/resources/be.js",c.onreadystatechange=a,c.onload=a,b.appendChild(c)}loadScript(function(){beTracker.t({hash:"d11bc9fec5d077e4df8a69825a2a3fb3"})});</script>
  </body>
</html>
