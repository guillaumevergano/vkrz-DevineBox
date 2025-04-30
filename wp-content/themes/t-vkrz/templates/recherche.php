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
            <div class="col-md-4 offset-md-1">
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

  <div class="container-xxl">
    <div class="row">
      <div class="col">
        <div class="classement">
          <section id="profile-info">
            <div class="card">
              <div class="table-responsive">
                <table class="table table-vainkeurz-recherche d-none">
                  <thead>
                    <tr>
                      <th>
                        <span class="va va-lama va-lg"></span> <span class="text-muted">Vainkeur</span>
                      </th>
                      <th class="text-center shorted">
                        <span class="text-muted">XP <span class="va va-updown va-z-10"></span></span>
                      </th>
                      <th class="text-center shorted">
                        <span class="text-muted">Votes <span class="va va-updown va-z-10"></span></span>
                      </th>
                      <th class="text-center shorted">
                        <span class="text-muted">TopList <span class="va va-updown va-z-10"></span></span>
                      </th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // CHECK IF WE ARE SEARCHING FOR A MEMBER OR A SPECIFIK TOP
  let memberToSearch = getParamURL('member_to_search'),
    termInATopToSearch = getParamURL('term_to_search');

  function processFirstWordIfStringHasSpecialChar(inputString) {
    function asciiFold(inputString) {
      return inputString
          .normalize("NFD") // Normalize to decompose combined graphemes
          .replace(/[\u0300-\u036f]/g, "") // Remove diacritics
          .replace(/[\u2018\u2019\u201B\u2032\u0027\u0060]/g, "'"); // Replace special apostrophes with standard apostrophe
    }
    var specialCharRegex = /[^\w\s]|_/g;
    if (specialCharRegex.test(inputString)) {
      inputString = asciiFold(inputString);
      var words = inputString.split(' ');

      words[0] = words[0].normalize("NFD").replace(specialCharRegex, ' ').replace(/[\u0300-\u036f]/g, " ");

      return words[0];
    } else {
      return inputString;
    }
  }

  // memberToSearch     = processFirstWordIfStringHasSpecialChar(memberToSearch);
  termInATopToSearch = processFirstWordIfStringHasSpecialChar(termInATopToSearch);

  if(memberToSearch && termInATopToSearch) 
    memberToSearch = false;

  if (!memberToSearch && termInATopToSearch) { // TOPS PROCESS
    // console.log("SEARCHING FOR A TOP :", termInATopToSearch)

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
  } else if (memberToSearch && !termInATopToSearch) { // USERS PROCESS
    console.log("SEARCHING FOR A MEMBER :", memberToSearch)

    const membersSearchWrapper = document.querySelector(".rechercher-page-members-show"),
      introMembersSearchWrapper = membersSearchWrapper.querySelector(".intro-archive"),
      tableMembersSearch = membersSearchWrapper.querySelector(".table-vainkeurz-recherche"),
      bodyTableMembersSearch = tableMembersSearch.querySelector(".table-vainkeurz-recherche > tbody");
    membersSearchWrapper.classList.remove("d-none");

    let membersROWS = "";

    fetch(`${API_BASE_URL}user-list/search`, {
        method: "POST",
        headers: { "Content-Type": "application/json", },
        body: JSON.stringify({ "search_term": memberToSearch, }),
      })
      .then((response) => response.json())
      .then((data) => {

        if (data.count !== 0) {
          introMembersSearchWrapper.innerHTML = `
            <h2>
              Recherche pour
            </h2>
            <h1>
              ${memberToSearch}
            </h1>
          `;
          data.users_list.forEach((member, index) => {
            membersROWS += `
              <tr>
                <td>
                  <div class="vainkeur-card">
                    <a href="${SITE_BASE_URL}v/${member.infos_user.pseudo_slug_user}" class="btn btn-flat-primary waves-effect">
                      <span class="avatar">
                        <span class="avatar-picture" style="background-image: url(${member.infos_user.avatar_user});"></span>
                      </span>
                      <span class="championname scale08"> 
                        <div class="creatornametopmin">
                          <h4>
                            ${member.infos_user.pseudo_user}
                          </h4>
                          <br>
                          <span class="medailles">
                            ${getVainkeurEmoji(member.data_user.role_user, member.data_user.level_vkrz.level_name)}
                          </span>
                        </div>
                      </span>
                    </a>
                  </div>
                </td>

                <td class="text-center">
                  ${member.data_user.money_vkrz} <span class="ico va-mush va va-lg"></span>
                </td>

                <td class="text-center">
                  ${member.data_user.nb_votes_vkrz} <span class="ico va-high-voltage va va-lg"></span>
                </td>

                <td class="text-center">
                  ${member.data_user.nb_tops_vkrz} <span class="ico va va-trophy va-lg"></span>
                </td>
              </tr>
            `;

            if (index === (data.users_list.length - 1)) {
              tableMembersSearch.classList.remove("d-none");
              bodyTableMembersSearch.innerHTML = membersROWS;
            }
          })

        } else {
          introMembersSearchWrapper.innerHTML = `
            <h1>
              Aucun vainkeur trouvé
            </h1>
          `;
        }

      });
  } else if (!memberToSearch && !termInATopToSearch) {
    const BASE_RELPATH_RECHERCHE = '/vkrz-wp/';

    window.location = BASE_RELPATH_RECHERCHE;
  }
</script>

<?php get_footer(); ?>