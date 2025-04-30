<div class="waiter" id="waiter-recherche">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="text-center">
          <div class="search">
            <div class="text-center">
              <span class="va va-loupe va-3x mb-5"></span>
            </div>
            <form action="<?php the_permalink(435459); ?>" method="GET" class="searchform">
              <div class="search-group">
                <div class="select-search">
                  <select class="selectpicker typesearch" name="typesearch">
                    <option>TopList</option>
                    <option>Membres</option>
                  </select>
                </div>
                <div class="input-search">
                  <input name="member_to_search" type="text" class="searchmembres form-control typeahead-prefetch" autocomplete="off" placeholder="Rechercher des membres...">
                  <input name="term_to_search" type="text" class="searchtops form-control typeahead-prefetch" autocomplete="off" placeholder="Rechercher des TopList...">
                </div>
              </div>
              <div class="btn-loupe">
                <button class="submitbtn" type="submit">
                  <span class="va va-eyes va-md"></span>
                </button>
              </div>
            </form>
            <div class="fermerrecherche">
              <span>
                Refermer
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>