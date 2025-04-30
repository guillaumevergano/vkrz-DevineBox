<?php
global $uuid_user;
global $top_infos;
global $id_top;
global $id_toplist;
$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$currentUrl = $scheme . "://" . $host . $uri;
get_header();
?>
<script>
  const id_top            = <?= $id_top; ?>;
  const id_topList        = <?= $id_toplist; ?>;
  let uuid_user_current   = "<?= $uuid_user; ?>";
  let topInfo             = {};
  let nb_duels = 0;
  let all_duels = {};

  function createUserCard(userInfo) {
    const { pseudo_user, avatar_user } = userInfo;
    const avatarUrl = (avatar_user && avatar_user !== 'null') 
      ? avatar_user
      : "https://vainkeurz.com/wp-content/uploads/2024/11/avatar-rose.png";
  
    return `
    <div class="user-card">
      <div class="user-avatar">
        <img src="${avatarUrl}" alt="${pseudo_user}" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <p style="color: white; margin: 0;">${pseudo_user}</p>
    </div>
    `;
  }

  get_devine_info(id_topList)
    .then(async data => {
      if (data) {
        const {
          user_devine_info,
          nb_duels,
          list_votes
        } = data;
        nb_duels_global = nb_duels;
        all_duels       = list_votes;
        uuid_devine_e   = user_devine_info.infos_user.uuid_user;
        uuid_devine_d   = uuid_user_current;
        code_parrain     = user_devine_info.infos_user.code_parrain_user;
        const currentUrl = "<?php echo $currentUrl; ?>";
        const signUpVKRZLink = "<?php echo bloginfo('url'); ?>/inscription?redirectparam=" + currentUrl;
        if(code_parrain){
          document.querySelector('.fill-parrain').setAttribute('href', `${signUpVKRZLink}&code_invitation=${code_parrain}`);
        }
        else{
          document.querySelector('.fill-parrain').setAttribute('href', `${signUpVKRZLink}`);
        }

        console.log('uuid_user_current', uuid_user_current);
        console.log('uuid_user_devine', user_devine_info.infos_user.uuid_user);
        if(user_devine_info.infos_user.uuid_user == uuid_user_current){
          document.querySelector(".top_not_started").style.display = "none";
          document.querySelector(".top_started").style.display = "none";
          document.querySelector(".top_finito").style.display = "block";
          document.querySelector(".resultats-devine").style.display = "block";
          document.querySelector(".score-user-devine").style.display = "none";
          document.querySelector(".footer-devine").style.display = "none";
          fetchAndDisplayDevineScores(id_topList);
        }
        else{
          checkDevineExists(uuid_devine_e, uuid_devine_d, id_topList);
        }

        let nameDevine = document.querySelectorAll('.name-devine');
        nameDevine.forEach(element => { element.innerHTML = `${user_devine_info.infos_user.pseudo_user}`; });
        let avatarDevine = document.querySelector('.avatar-devine');
        const defaultAvatar = "https://vainkeurz.com/wp-content/uploads/2024/11/avatar-rose.png";
        const avatarUrl = user_devine_info.infos_user.avatar_user;
        if(avatarUrl){
          avatarDevine.style.backgroundImage = `url(${avatarUrl})`;
        }
        else{
          avatarDevine.style.backgroundImage = `url(${defaultAvatar})`;
        }
        let nbduels = document.querySelectorAll('.nb-duel-devine');
        nbduels.forEach(element => { element.innerHTML = `${nb_duels}`; });

        const userCardHTML = createUserCard(user_devine_info.infos_user);
        document.querySelectorAll('.user-card-devine').forEach(element => { element.innerHTML = userCardHTML; });

        let scoreDevine = document.querySelectorAll('.score-devine-number');
        scoreDevine.forEach(element => {
          element.innerHTML = '';
          all_duels.forEach((duel, index) => {
            const li = document.createElement('li');
            li.className = 'scoreduel';
            li.id = `duel-${index}`;
            element.appendChild(li);
          });
        });
      }
    });    
  get_top_info(id_top)
    .then(async data => {
      if (data) {
        topInfo = data;
        const {
          top_url,
          top_cat,
          top_cat_icon,
          top_title,
          top_question,
          top_precision,
          top_number,
          top_img,
          top_cover,
          top_d_titre,
          top_d_cover,
        } = data;
        let title_toplist_devine = document.querySelectorAll('.top-title-devine');
        let question_toplist_devine = document.querySelectorAll('.top-question-devine');
        title_toplist_devine.forEach(element => { element.innerHTML = `${top_title} - ${top_question}`; });
        question_toplist_devine.forEach(element => { element.innerHTML = `${top_question}`; });
        let cover = document.querySelector('body');
        if(cover){
          cover.style.backgroundImage = `url('${top_cover}')`;
        }
        let cover_devine = document.querySelector('.meetup-img-wrapper');
        if(cover_devine){
          cover_devine.style.backgroundImage = `url('${top_img}')`;
        }
        let btnFooterDevine = document.querySelector('#btn-footer-devine');
        if(btnFooterDevine){
          btnFooterDevine.setAttribute('href', `${top_url}`);
        }
      }
    });
</script>
<div class="tournoi-content ba-cover-r">

  <!-- DEVINE FINI --> 
  <div class="top_finito z9" id="devine-page" style="display: none;">
    <div class="resultats-devine z9">
      <div class="content-intro mt-4">
        <div class="row justify-content-center">
          <div class="col-md-8 col-xl-6 order-2 order-sm-0" style="width: 1050px;">
            <div class="presentationtop presentationtop-whitelabel">
              <div class="card animate__animated animate__flipInX card-developer-meetup card-top-presentation card-devine-result" style="background: transparent !important;">
                <div class="card-body presentationtop">
                  <div class="meetup-header align-items-center justify-content-center animate__animated animate__bounceInDown">
                    <h1 class="top-question">
                      Qui connaît le mieux <span class="user-card-devine"></span> ?
                    </h1>
                    <h2 class="top-question-h2 mt-n3 mb-sm-5 mb-3"><span class="top-title-devine"></span></h2>
                    <div class="d-flex bloc-devine-result">
                      <div class="card animate__animated animate__flipInX card-developer-meetup card-top-presentation score-user-devine flex-grow-1">
                        <div class="card-body presentationtop" style="width: 100%">
                          <div class="meetup-header d-flex align-items-center justify-content-center animate__animated animate__bounceInDown">
                            <div class="pourcentage-progress-container mt-3">
                              <h1 class="h1-ton-score">
                                Ton Score: 
                              </h1>
                              <div class="rank-index-container">
                                <h3 class="pourcentagescore result-pourcentage"></h3>
                                <div class="progress-wrapper">
                                  <div class="progress-bar">
                                    <div class="progress-bar-inner">
                                      <div class="progress-fill animate__fadeInLeft animate__animated animate__delay-2s" id="progress"></div>
                                    </div>
                                  </div>
                                </div>
                                <p class="mb-0 animate__animated animate__fadeInUp animate__delay-2s">
                                  <em class="mb-O-em">Ta place dans le classement:</em> <span class="rank-devine index-rank" ></span>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card score-board flex-grow-1 animate__delay-2s animate__animated animate__bounceInDown">
                        <div class="table-responsive text-nowrap table-score-devine-container">
                          <table class="table table-score-devine-table" id="table-score-devine">
                            <thead class="table-score-devine-thead">
                              <tr style="border-bottom: 1px solid #7983BB;">
                                <th style="color: #7983BB; text-align: left;">Rank</th>
                                <th style="color: #7983BB; text-align: left;">Amis</th>
                                <th style="color: #7983BB; text-align: left;">Score</th>
                              </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                              <tr>
                                <td colspan="3">
                                  <?php get_template_part('partials/loader/loader-simple'); ?>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-devine animate__animated animate__fadeInUp animate__delay-2s" style=>
      <div class="footer-devine-content">
        <p>Tu veux savoir qui te connaît le mieux ? Fais tes propres choix et partage à tes amis : </p>
        <a href="#" class="btn-wording-rose btn-wording bubbly-button" id="btn-footer-devine">
          Faire ma TopList et défier mes potes
        </a>
      </div>
    </div>
</div>
  <!-- // DEVINE FINI -->

  <!-- DEVINE PAS LANCÉ -->
  <div class="top_not_started z9" style="display: none;">
    <div class="content-intro mt-4">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card animate__animated animate__flipInX card-developer-meetup">
            <div class="meetup-img-wrapper cover-devine"></div>
            <div class="card-body card-intro-devine pt-0">
              <div class="intro-devine">
                <div class="avatar-devine animate__animated animate__rollIn animate__delay-1s"></div>
                <h1 class="name-devine"></h1>
                <h2>
                  te lance un défi !
                </h2>
              </div>
              <div class="meetup-header">
                <div class="top-precision">
                  Tu dois deviner les choix que <span class="name-devine"></span> a fait pour la question :
                  <h3 class="top-title-devine"></h3> 
                </div>
                <div class="mt-3 animate__animated animate__fadeInUp animate__delay-2s">
                  <div class="lauch-devine isconnected">
                    <a href="#" class="cta-begin-devine btn-wording-rose btn-wording bubbly-button animate__jackInTheBox animate__animated">
                      Commencer le défi !
                    </a>
                  </div>
                  <div class="notconnected">
                    <a href="#" class="btn-wording-rose btn-wording bubbly-button animate__jackInTheBox animate__animated fill-parrain d-inline-flex">
                      Me connecter pour commencer le défi
                    </a>
                  </div>
                </div>
                <div class="mt-3 animate__animated animate__fadeInUp animate__delay-3s">
                  <small class="text-muted">Tu auras donc <span class="nb-duel-devine"></span> duels à deviner pour obtenir ton pourcentage de réussite !</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- // DEVINE PAS LANCÉ -->

  <!-- DEVINE LANCÉ -->
  <div class="top_started z9 t-normal-container" style="display: none;">
    <div class="tournoi-content-final">
      <div class="row">
        <div class="col-md-12">
          <div class="container">
            <div class="tournament-heading-top">
              <div class="t-titre-tournoi top-title-question">
                <h2>
                  Devine le choix de <span class="user-card-devine"></span> à la question
                </h2>
                <h1>
                  <span class="top-question-devine"></span>
                </h1>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="score-devine">
                  <ul class="score-devine-number"></ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="display_battle">
                  <div class="row align-items-center justify-content-center contenders-containers battle-marqueblanche">
                    <div class="col-sm-5 col-12">
                      <div class="bloc-contenders link-contender_1 contender_1 cover_contenders link-contender">
                        <div class="contenders_min contender_zone animate__animated" data-idcontender="" id="c_1">
                          <div class="illu">
                            <img id="cover_contender_1" src="" alt="" class="img-fluid contender-1-votes-twitch">
                          </div>
                          <h2 id="name_contender_1" class="title-contender"></h2>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="versus-container d-flex flex-column">
                        <h4 class="text-center versus">
                          <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/versus.png" alt="" class="img-fluid">
                        </h4>
                      </div>
                    </div>
                    <div class="col-sm-5 col-12">
                      <div class="bloc-contenders link-contender_2 contender_2 cover_contenders link-contender">
                        <div class="contenders_min contender_zone animate__animated" data-idcontender="" id="c_2">
                          <div class="illu">
                            <img id="cover_contender_2" src="" alt="" class="img-fluid contender-2-votes-twitch">
                          </div>
                          <h2 id="name_contender_2" class="title-contender"></h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- DEVINE LANCÉ -->
</div>

<!-- Offcanvas -->
<?php get_template_part('partials/loader/loader-devine'); ?>
<?php get_template_part('partials/loader/loader-score-devine'); ?>
<!-- /Offcanvas -->

<div class="goodchoice"></div>
<div class="badchoice"></div>
<div class="text-right emojis-devine">
  <span class="va va-check va-lg va-goodchoice"></span>
  <span class="va va-cross va-lg va-badchoice"></span>
</div>

<script>
let goodchoice = 0;
let badchoice = 0;
let step = 0;

// ✅ Ensure DataTables is only initialized when there is real data
document.addEventListener("DOMContentLoaded", function () {
	fetchAndDisplayDevineScores(id_topList); // Call the function with actual data
});

document.addEventListener('DOMContentLoaded', (event) => {
    const waiterTop = document.querySelector("#waiter-devine");
    const ctaDevine = document.querySelectorAll(".cta-begin-devine");
    ctaDevine.forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        document.querySelector("#global-page").classList.add("focus-top");
        waiterTop.style.display = "block";
        waiterTop.classList.add("fade-in");

        newDevine = await SQL_createDevineTopList({
          uuid_devine_e: uuid_devine_e,
          uuid_devine_d: uuid_devine_d,
          id_toplist_devine: id_topList,
          nb_duels: nb_duels_global,
          score_devine: 0
        });

        document.querySelector(".progress-fill").style.width = "0%";

        display_choice_devine(step, all_duels, uuid_devine_d, id_topList);

        setTimeout(() => {
          lauchTop();
          waiterTop.style.display = "none";
          waiterTop.classList.remove("fade-in", "fade-out");
        }, 500);
      });
    });

    // Ajout de l'écouteur pour le bouton d'annulation
    const btnAnnuleDevine = document.querySelector('.btn-annule-devine');
    if (btnAnnuleDevine) {
        btnAnnuleDevine.addEventListener('click', async () => {            
            // Masquer les éléments
            document.querySelector(".top_not_started").style.display = "none";
            document.querySelector(".top_started").style.display = "none";
            btnAnnuleDevine.style.display = "none";
            
            // Afficher les résultats
            document.querySelector(".top_finito").style.display = "block";
            document.querySelector(".resultats-devine").style.display = "block";

            // Sauvegarder le score dans la base de données
            const pourcentagescore = Math.round((goodchoice / all_duels.length) * 100);
            if (pourcentagescore) {
              await updateDevineScore(uuid_devine_d, id_topList, pourcentagescore);
            }
            
            // Afficher le tableau des scores
            await fetchAndDisplayDevineScores(id_topList);
        });
    }

});

async function display_choice_devine(step, all_duels, uuid_devine_d, id_topList) {

    document.getElementById("c_1").classList.remove("animate__flipInX");
    document.getElementById("c_2").classList.remove("animate__flipInX");

    const current_duel = all_duels[step];
    const winnerInfo = await getContenderInfo(current_duel.id_winner_contender, "simple");
    const loserInfo = await getContenderInfo(current_duel.id_looser_contender, "simple");

    if (!winnerInfo || !loserInfo) {
        console.error("Failed to fetch contender info");
        return;
    }

    // Dynamically assign winner and loser to contenders (to mix up positions and not always have the winner on the left/right)
    let [firstContenderInfo, secondContenderInfo] = Math.random() < 0.5 ? [winnerInfo, loserInfo] : [loserInfo, winnerInfo];

    // Update the contenders' display
    document.getElementById("name_contender_1").textContent = firstContenderInfo.title;
    document.getElementById("cover_contender_1").src = firstContenderInfo.thumbnail;
    document.getElementById("c_1").setAttribute("data-idcontender", firstContenderInfo.id_wp);
    document.getElementById("c_1").setAttribute("data-is-winner", firstContenderInfo === winnerInfo ? "true" : "false");

    document.getElementById("name_contender_2").textContent = secondContenderInfo.title;
    document.getElementById("cover_contender_2").src = secondContenderInfo.thumbnail;
    document.getElementById("c_2").setAttribute("data-idcontender", secondContenderInfo.id_wp);
    document.getElementById("c_2").setAttribute("data-is-winner", secondContenderInfo === winnerInfo ? "true" : "false");

    document.getElementById("c_1").classList.add("animate__flipInX");
    document.getElementById("c_2").classList.add("animate__flipInX");

    // Ensure to call setupContenderClickHandlers to update event listeners with correct winner info
    setupContenderClickHandlers(uuid_devine_d, id_topList);
}

function handleContenderClick(isWinner, uuid_devine_d, id_topList) {
    const winSound = new Audio(SITE_BASE_URL+'/wp-content/themes/t-vkrz/assets/audios/win.mp3');
    const loseSound = new Audio(SITE_BASE_URL+'/wp-content/themes/t-vkrz/assets/audios/fail.mp3');

    currentDuel = document.querySelector(`#duel-${step}`);

    if (isWinner) {
      goodchoice += 1;
      currentDuel.style.backgroundColor = '#28a745';
      winSound.play(); // Play the win sound
      
      setTimeout(() => {
        document.querySelector(".goodchoice").style.opacity = "1";
        setTimeout(() => {
          document.querySelector(".goodchoice").style.opacity = "0";
        }, 2000);
      }, 0);
      const goodChoiceSpan = document.querySelector(".va-goodchoice");
      goodChoiceSpan.style.transition = "transform 1s";
      goodChoiceSpan.style.transform = "translateY(2vh)";
      setTimeout(() => {
        goodChoiceSpan.style.transform = "translateY(-120vh)";
        setTimeout(() => {
          goodChoiceSpan.style.transform = "translateY(2vh)";
          goodChoiceSpan.style.transition = "none";
        }, 2000);
      }, 0);
    } else {
      badchoice += 1;
      currentDuel.style.backgroundColor = '#dc3545';
      loseSound.play(); // Play the lose sound
      setTimeout(() => {
        document.querySelector(".badchoice").style.opacity = "1";
        setTimeout(() => {
          document.querySelector(".badchoice").style.opacity = "0";
        }, 1000);
      }, 0);
      const badChoiceSpan = document.querySelector(".va-badchoice");
      badChoiceSpan.style.transition = "transform 1s";
      badChoiceSpan.style.transform = "translateY(2vh)";
      setTimeout(() => {
        badChoiceSpan.style.transform = "translateY(-120vh)";
        setTimeout(() => {
          badChoiceSpan.style.transform = "translateY(2vh)";
          badChoiceSpan.style.transition = "none";
        }, 1000);
      }, 0);
    }

    // Sauvegarder le score dans la base de données
    const pourcentagescore = Math.round((goodchoice / all_duels.length) * 100);
    if (pourcentagescore) {
      updateDevineScore(uuid_devine_d, id_topList, pourcentagescore);
    }
    if(step >= all_duels.length-1) {
      setTimeout(() => {
          document.querySelector(".top_started").style.display = "none";
          document.querySelector(".top_finito").style.display = "block";
          document.querySelector(".resultats-devine").style.display = "block";
          document.querySelector(".btn-annule-devine").style.display = "none";
          fetchAndDisplayDevineScores(id_topList);
          displayScoreDevine(pourcentagescore);
          displayRankDevine(id_topList, uuid_devine_d, uuid_devine_e);
          setDevineDone(id_topList, uuid_devine_d);
      }, 1000);
      return;
    }

    step += 1;
    display_choice_devine(step, all_duels, uuid_devine_d, id_topList);
}

function setupContenderClickHandlers(uuid_devine_d, id_topList) {
    document.querySelectorAll(".contenders_min").forEach((element) => {
        element.removeEventListener("click", element.clickHandler); // Remove previous handler
        element.clickHandler = function() {
            const isWinner = this.getAttribute('data-is-winner') === "true";
            handleContenderClick(isWinner, uuid_devine_d, id_topList);
        };
        element.addEventListener("click", element.clickHandler);
    });
}

async function updateDevineScore(uuid_devine_d, id_topList, score) {
	const data = {
		uuid_devine_d: uuid_devine_d,
		id_topList: id_topList,
		score: score,
	};
  const endpoint = `${API_BASE_URL}devine/save`;

	try {
		const response = await fetch(endpoint, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify(data),
		});

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		}

		const result = await response.json();
		console.log("Update Devine Score Result:", result);

		// Perform any follow-up actions based on the result
		if (result.status === "Score updated successfully") {
			console.log("Score updated successfully.");
			// Update UI or notify the user as needed
		} else {
			console.log("Failed to update score:", result.message);
			// Handle failure case
		}
	} catch (error) {
		console.error("Failed to update devine score:", error);
	}
}

</script>
<?php get_footer(); ?>