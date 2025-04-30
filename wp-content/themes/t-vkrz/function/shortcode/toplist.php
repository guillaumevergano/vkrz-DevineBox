<div class="listing-all-toplist-founded">
  <div class="toplist-amis-page toplist-list">
    <div class="toplist-amis row" data-masonry='{"percentPosition": true }'>
      <?php for ($i = 1; $i <= $limit; $i++) :  ?>
        <div class="<?= $col ?> init-loading-card-container">
          <div class="loading-card">
            <div class="inner-card"></div>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
  <div class="sentinel"></div>
<script>
  function preloadImage(url) {
    return new Promise((resolve, reject) => {
      const img = new Image();
      img.onload = resolve;
      img.onerror = reject;
      img.src = url;
    });
  }

  function containsUndefined(string) {
      return string.includes('undefined');
  }

  let cardsLoadingOnlyOnce = false,
      isLoading            = false,
      offset               = 0,
      topsIds              = [];
  const limit     = <?= $limit ?>,
        sentinel  = document.getElementById('sentinel'),
        container = document.querySelector('.toplist-amis');

  const isInfiniteScroll = <?= $isInfiniteScroll ? 1 : 0 ?>;
  const uuidUserFilter   = '<?= $uuidUserFilter ?>';
  let userProfile        = '<?= $userProfile ?>' || false;
  let idTopFilter        = '<?= $idTopFilter ?>' || false;
  userProfile            = Boolean(userProfile);

  async function loadInitialContent() {
    const existingSentinel = container.querySelector('.sentinel');

    if (existingSentinel) {
      observer.unobserve(existingSentinel);
      existingSentinel.classList.remove('sentinel');
    }

    isLoading = true;

    const loadingCards = container.querySelectorAll('.loading-card-container');
    loadingCards.forEach(card => card.classList.remove('d-none'));

    try {
      var urlObject;
      const baseURL = `${API_BASE_URL}toplist-list/`;

      if (userProfile && !idTopFilter) {
        // If userProfile is true and idTopFilter is not set
        urlObject = new URL(`${baseURL}get-all-from-user/${uuidUserFilter}/${limit}/${offset}`);
      } else if (!userProfile && !idTopFilter) {
        // If userProfile is false and idTopFilter is not set
        urlObject = new URL(`${baseURL}get-last-toplist/${limit}/${offset}`);
      } else if (!userProfile && idTopFilter) {
        // If userProfile is false and idTopFilter is set
        urlObject = new URL(`${baseURL}get-last-toplist-of-top/${limit}/${offset}/${idTopFilter}/${uuid_user}`);
      }
      if (uuidUserFilter) {
        urlObject.searchParams.set("uuid_user_filter", uuidUserFilter);
      }
      var mainURL = urlObject.toString();
      const results = await fetchDataFuncHelper(mainURL);
      offset += limit;

      let htmlStrings = [];
      if (results.toplist_list.length > 0) {
        for (const item of results.toplist_list) {
          try {
            const rankingSorted = sortRanking(item.ranking, item.type_rank);
            let contenders = '',
              vainkeurBlock = '',
              nb_contenders = 0;

            // Extract contender information
            for (let i = 0; i < rankingSorted.length; i++) {
              const ranking = rankingSorted[i];
              nb_contenders++;
              let contenderName, contenderCover;
              if(document.getElementById(`contender_id_wp_${ranking.id_wp}`)) { // WE'RE IN TOP MONDIAL
                contenderName  = document.querySelector(`#contender_id_wp_${ranking.id_wp} h3 b`).textContent;
                contenderCover = document.querySelector(`#contender_id_wp_${ranking.id_wp} .illu img`).src;
              } else if(!ranking.c_name || !ranking.cover) { // UNE ANCIENNE TOPLIST
                const responseContender      = await fetch(`https://vainkeurz.com/wp-json/v1/getcontenderinfo/${ranking.id_wp}`);
                const dataContender          = await responseContender.json();
                contenderName  = dataContender.title;
                contenderCover = dataContender.thumbnail;
              } else {
                contenderName  = ranking.c_name;
                contenderCover = ranking.cover;
              }

              contenders += `
                <div class="item-avatar-ranking item-avatar-ranking- keep-square" data-position="${i + 1}">
                    <div class="item-contender-visuel">
                        <img src="${contenderCover}" class="img-cover" alt="${contenderName}">
                    </div>
                    <h6 class="contender-name">${contenderName}</h6>
                </div>`
              ;
            };

            const dataVainkeur = await getUserData(item.uuid_user);
            const topInfo      = await getTopInfo(item.id_top_rank);

            if (dataVainkeur && topInfo && !containsUndefined(contenders)) {
              const creatorLink = `${SITE_BASE_URL}v/${dataVainkeur.infos_user.pseudo_slug_user}`;
              const creatorName = dataVainkeur.infos_user.pseudo_user;

              vainkeurBlock += `
                <a href="${creatorLink}" class="card-toplist-amis-header">
                    <div class="avatar">
                        <span class="avatar-picture" style="background-image: url(${dataVainkeur.infos_user.avatar_user || "https://vainkeurz.com/wp-content/uploads/2024/11/avatar-rose.png"});"></span>
                    </div>
                    <span class="pseudovainkeurzslim">
                        ${creatorName} ${getVainkeurEmoji(dataVainkeur.infos_user.role_user, dataVainkeur.data_user.level_vkrz.level_name)}
                    </span>
                </a>`
              ;

              const LinksTopList = SITE_BASE_URL + "toplist/" + createSlug(topInfo.top_title) + "/" + item.id;
              var jugementTxt = '';
              var perfectScrollbarClass = nb_contenders > 12 ? 'perfectScrollbar' : '';
              const htmlString = `
                <div class="kl-masonry-item <?= $col ?>" data-topcategorie="${topInfo.top_cat[0]?.slug}" 
                data-id-toplist="${item.id}" data-link-toplist="${LinksTopList}" data-name-toplist="${topInfo.top_title || ''} – ${topInfo.top_question || ''}">
                  <div class="toplist-amis-item">
                    <div class="card-toplist-amis h-100">
                      ${vainkeurBlock}
                      <div class="card-toplist-amis-body">
                        <div class="cover-toplist-slim" style="background-image: url(${topInfo.top_cover || ''});"></div>
                          <div class="ranking-toplist-slim">
                            <div class="min-tournoi-title">
                              <h4 class="titre-top-min titre-toplist-mondiale">${topInfo.top_title || ''}</h4>
                              <h3 class="card-title question-toplist-mondiale">${topInfo.top_question || ''}</h3>
                            </div>
                            <div class="list-avatar-ranking ${perfectScrollbarClass}">
                              ${contenders}
                            </div>
                            <div class="card-toplist-amis-footer px-2">
                              <a href="${topInfo.top_url}" class="btn btn-voir-toplist-complete w-100">
                                Faire ma TopList <span class="va va-versus va-z-15 mx-1"></span>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>`
              ;

              if (!topsIds.includes(item.id_top_rank)) {
                topsIds.push(item.id_top_rank);
                htmlStrings.push(htmlString);
              } else if(idTopFilter || !Boolean(idTopFilter)) {
                htmlStrings.push(htmlString);
              }
            }
          } catch (err) {
            console.error('Error getting user data or toplist info:', err);
          }
        }

        // Preload all images
        const allImages = htmlStrings.flatMap(str => {
          const matches = str.match(/<img src="(.*?)" class="img-cover" alt="">/);
          return matches ? [matches[1]] : [];
        });
        await Promise.all(allImages.map(img => preloadImage(img)));

        if (!cardsLoadingOnlyOnce) {
          const initLoadingCards = container.querySelectorAll('.init-loading-card-container');
          initLoadingCards.forEach(card => card.remove());
          cardsLoadingOnlyOnce = true;
        }

        // Insert the toplists into the DOM
        htmlStrings.forEach((htmlString, index) => {
          container.insertAdjacentHTML('beforeend', htmlString);

          if (htmlStrings.length - 1 === index) {
            const loadingCards = container.querySelectorAll('.loading-card-container');
            loadingCards.forEach(card => card.remove());
            for (let wow = 0; wow < 3; wow++) {
              container.insertAdjacentHTML('beforeend', `
                <div class="kl-masonry-item col-md-4 col-12 col-sm-6 d-none loading-card-container" style="margin: 1rem 0"; width: 100%; float: left; height: 200px;>
                  <div class="loading-card">
                    <div class="inner-card">
                    </div>
                  </div>
                </div>
              `);
            }
          }
        });

        const msnry = new Masonry(container, {
          itemSelector: '.kl-masonry-item', // Adjust this if needed
          percentPosition: true
        });
        imagesLoaded(container, function() {
          const msnry = new Masonry(container, {
            itemSelector: '.kl-masonry-item',
            percentPosition: true
          });
        });

        const allItems    = container.querySelectorAll('.toplist-amis-item');
        const newSentinel = allItems[allItems.length - 1];
        newSentinel.classList.add('sentinel');

        // Start observing the new sentinel
        observer.observe(newSentinel);
      } else if (offset - limit === 0) {
        container.removeAttribute('style');
        container.innerHTML = `
          <div class="card text-center">
            <h5 class="m-0 p-2">
              Aucune TopList pour le moment :(
            </h5>
          </div>`
        ;
      } else {
        const loadingCards = container.querySelectorAll('.loading-card-container');
        loadingCards.forEach(card => card.remove());
      }
      isLoading = false;
    } catch (error) {
      console.error('Error in observer:', error);

      const loadingCards = container.querySelectorAll('.loading-card-container');
      loadingCards.forEach(card => card.remove());
      isLoading = false;
    }
  }

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(async (entry) => {
      if (entry.isIntersecting && !isLoading && isInfiniteScroll) {
        await loadInitialContent();
      }
    });
  }, {
    root: null,
    threshold: 0.1
  });

  document.addEventListener('DOMContentLoaded', loadInitialContent);

  function enableInfiniteScroll() {
    const sentinel = document.querySelector('.sentinel');
    if (sentinel) {
      observer.observe(sentinel);
    } else {
      console.error('Sentinel element not found');
    }
  }
</script>
</div>