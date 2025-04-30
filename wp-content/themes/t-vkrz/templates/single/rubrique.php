<?php
/*
  Template Name: Recherche
*/
get_header();
?>
<div class="my-3 rechercher-page-tops-show d-none">
  <div class="container-xxl mt-2">
    <div class="row">
      <div class="col">
        <div class="filtres-bloc">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-8 offset-md-1">
              <div class="intro-archive">
                <?php get_template_part('partials/loader/loader-simple'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-xxl">
    <section class="row match-height mt-4 grid-to-filtre render-tops" id="rendersearchedtops">
      <div class="col-md-3 col-sm-4 col-6 me-50">
        <div class="card loading-card">
          <div class="card-1">
          </div>
          <div class="card-2 p-3">
            <div class="row">
              <div class="col-4">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-8">
                <div class="inner-card">
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-6">
                <div class="inner-card">
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-2">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-10">
                <div class="inner-card">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-6 me-50">
        <div class="card loading-card">
          <div class="card-1">
          </div>
          <div class="card-2 p-3">
            <div class="row">
              <div class="col-4">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-8">
                <div class="inner-card">
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-6">
                <div class="inner-card">
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-2">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-10">
                <div class="inner-card">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-6 me-50">
        <div class="card loading-card">
          <div class="card-1">
          </div>
          <div class="card-2 p-3">
            <div class="row">
              <div class="col-4">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-8">
                <div class="inner-card">
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-6">
                <div class="inner-card">
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-2">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-10">
                <div class="inner-card">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-4 col-6 me-50">
        <div class="card loading-card">
          <div class="card-1">
          </div>
          <div class="card-2 p-3">
            <div class="row">
              <div class="col-4">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-8">
                <div class="inner-card">
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-6">
                <div class="inner-card">
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-2">
                <div class="inner-card">
                </div>
              </div>
              <div class="col-10">
                <div class="inner-card">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<div class="my-3 rechercher-page-members-show d-none">
  <div class="container-xxl mt-2">
    <div class="row">
      <div class="col">
        <div class="filtres-bloc">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-4">
              <div class="intro-archive">
                <?php get_template_part('partials/loader/loader-simple'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  let termInATopToSearch = "<?php the_title(); ?>";

  function removeDashes(str) {
    return str.replace(/-/g, ' ');
  }
  termInATopToSearch = removeDashes(termInATopToSearch);

  if (termInATopToSearch) {
    const topsSearchWrapper = document.querySelector(".rechercher-page-tops-show"),
      introTopsSearchWrapper = topsSearchWrapper.querySelector(".intro-archive");
    topsSearchWrapper.classList.remove("d-none");

    fetchDataFuncHelper(`${SITE_BASE_URL}wp-json/v1/getalltopsfromsearch/${encodeURIComponent(termInATopToSearch)}`)
      .then(results => {
        const divToFillWithTops = document.querySelector('#rendersearchedtops');
        if (results[0].nb_result === 0) { // DEAL INTRO
          divToFillWithTops.classList.add("d-none");
          introTopsSearchWrapper.innerHTML = `
            <h1>
              Aucune TopList trouvée malheureusement
            </h1>
          `;
          return;
        } else {
          introTopsSearchWrapper.innerHTML = `
            <h1>
              ${termInATopToSearch} <span class="infonbtops">${results[0].nb_result} TopList</span>
            </h1>
          `;
        }
        const tops = results[0].list_tops;
        processTops(tops, divToFillWithTops, "col-md-3 col-sm-4 col-6");
      });
  }
</script>

<?php get_footer(); ?>