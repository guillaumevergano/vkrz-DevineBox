function preloadImage(url) {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = resolve;
    img.onerror = reject;
    img.src = url;
  });
}

function lauchTop() {
  const topNotStartedElements = document.querySelectorAll(".top_not_started");
  const topStartedElements = document.querySelectorAll(".top_started");
  topNotStartedElements.forEach((element) => {
    element.style.display = "none";
  });
  topStartedElements.forEach((element) => {
    element.style.display = "block";
  });
}

function getCategoryIcon(categoryName) {
  switch (categoryName) {
      case 'Sport':
          return " 🏓 ";
      case 'Musique':
          return " 💿 ";
      case 'Jeux vidéo':
          return " 🕹️ ";
      case 'Food':
          return " 🥨 ";
      case 'Écran':
          return " 📺 ";
      case 'Comics':
          return " 🕸️ ";
      case 'Manga':
          return " 🐲 ";
      case 'Autres':
          return " ⚔️ ";
      default: 
          return " : ";
  }
}

function getParamURL(paramName) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(paramName);
}

function removeURLParameters(url, parametersToRemove) {
  let urlObj = new URL(url);
  let params = new URLSearchParams(urlObj.search);
  parametersToRemove.forEach(param => {
      if (params.has(param)) {
          params.delete(param);
      }
  });
  urlObj.search = params.toString();
  return urlObj.toString();
}

function sortRanking(rankingJSON, type_rank) {
  rankingData = JSON.parse(rankingJSON);
  ranking     = rankingData.sort((a, b) => b.place - a.place);
  if (type_rank === "top3") {
    ranking = ranking.slice(0, 3);
  } else if (type_rank === "top1") {
    ranking = ranking.slice(0, 1);
  }
  return ranking;
}

function redirectTo(top_url) {
  window.location.replace(top_url);
}
  
function refresh_user_data(uuid_user) {
	clear_user_data();
	get_user_data_infos(uuid_user);
	get_user_inventaire(uuid_user);
}

function refresh_user_info(uuid_user) {
	clear_user_data();
	get_user_data_infos(uuid_user);
  display_user_data();
}

function clear_user_data() {
  localStorage.removeItem("vainkeur_data");
	localStorage.removeItem("user_info");
	localStorage.removeItem("inventaire_user");
	localStorage.removeItem("vainkeur_trophy");
}

function formatDate() {
	const now = new Date();
	const year = now.getFullYear();
	const month = String(now.getMonth() + 1).padStart(2, "0"); // JavaScript months are 0-based
	const day = String(now.getDate()).padStart(2, "0");
	const hours = String(now.getHours()).padStart(2, "0");
	const minutes = String(now.getMinutes()).padStart(2, "0");
	const seconds = String(now.getSeconds()).padStart(2, "0");

	return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}


function display_user_data_not_logged() {
	const vainkeurDataRaw = localStorage.getItem("vainkeur_data");
	let vainkeur_data   = JSON.parse(vainkeurDataRaw);

  if (
		!vainkeur_data ||
		(Array.isArray(vainkeur_data) && vainkeur_data.length === 0)
	) {
		vainkeur_data = {
			id: 9999999999999,
			uuid_user: uuid_user,
			date_register_vkrz: formatDate(),
			level_vkrz: {
				level_name: "egg",
				level_number: 0,
				level_score: 0,
				level_icon_emoji: "🥚",
				level_legend:
					"Maintenant que tu fais parti des Vainkeurs, il te faut 50  pour éclore et passer au niveau 1.",
				next_level_score: 50,
				next_level_name: "hatching-chick",
			},
			nb_votes_vkrz: 0,
			nb_tops_vkrz: 0,
			nb_jugements_vkrz: 0,
			xp_vkrz: 0,
			money_vkrz: 0,
			money_createur_vkrz: 0,
			money_parrainage_vkrz: 0,
			money_trophy_vkrz: 0,
			money_duplication_vkrz: 0,
			depense_vkrz: 0,
			money_dispo_vkrz: 0,
			nb_toplist_genere: 0,
			nb_votes_genere: 0,
			nb_top_cree: 0,
		};
	};

  console.log("uuid_user", uuid_user);
  console.log("vainkeur_data", vainkeur_data);

	const nb_votes_vkrz              = vainkeur_data.nb_votes_vkrz;
	const nb_tops_vkrz               = vainkeur_data.nb_tops_vkrz;
	const money_dispo_vkrz           = vainkeur_data.money_dispo_vkrz;
	const user_level                 = vainkeur_data.level_vkrz;
  const user_level_name            = user_level.level_name;
	const user_next_level_name       = user_level.next_level_name;
	const xp_vkrz                    = vainkeur_data.xp_vkrz;
	const user_next_level_score      = user_level.next_level_score;
	const user_need_xp_to_next_level = user_next_level_score - xp_vkrz;
	const percent_xp_to_next_level   = Math.round((xp_vkrz / user_next_level_score) * 100);

	$level_icon_txt      = `<span class="va va-z-20 va-level-icon va-${user_level_name}"></span>`;
	$next_level_icon_txt = `<span class="va va-z-20 va-level-icon va-${user_next_level_name}"></span>`;

	document.querySelectorAll(".user_level_icon").forEach(function (element) {
		element.innerHTML = $level_icon_txt;
	});
	document.querySelectorAll(".user_next_level_icon").forEach(function (element) {
			element.innerHTML = $next_level_icon_txt;
  });
	document.querySelectorAll(".nb_votes_vkrz").forEach(function (element) {
		element.innerHTML = nb_votes_vkrz;
	});
	document.querySelectorAll(".nb_tops_vkrz").forEach(function (element) {
		element.innerHTML = nb_tops_vkrz;
	});
	document.querySelectorAll(".xp_vkrz").forEach(function (element) {
		element.innerHTML = xp_vkrz;
	});
	document.querySelectorAll(".money_dispo_vkrz").forEach(function (element) {
		element.innerHTML = money_dispo_vkrz;
	});
	document.querySelectorAll(".nb_decompte_level_vkrz").forEach(function (element) {
			element.innerHTML = user_need_xp_to_next_level;
  });
	document.querySelectorAll(".next-level-bar").forEach(function (element) {
		element.style.width = percent_xp_to_next_level + "%";
	});
}

async function display_user_data(){
  const vainkeur_data              = JSON.parse(localStorage.getItem("vainkeur_data"));
  const user_infos                 = JSON.parse(localStorage.getItem("user_info"));

  const id_vainkeur                = vainkeur_data.id;
  const nb_votes_vkrz              = vainkeur_data.nb_votes_vkrz;
  const nb_tops_vkrz               = vainkeur_data.nb_tops_vkrz;
  const money_archive_vkrz         = vainkeur_data.money_archive_vkrz;
  const money_vkrz                 = vainkeur_data.money_vkrz;
  const money_createur_vkrz        = vainkeur_data.money_createur_vkrz;
  const money_parrainage_vkrz      = vainkeur_data.money_parrainage_vkrz;
  const money_dispo_vkrz           = vainkeur_data.money_dispo_vkrz;
  const user_level                 = vainkeur_data.level_vkrz;

  const user_level_name            = user_level.level_name;
  const user_next_level_name       = user_level.next_level_name;
  const xp_vkrz                    = vainkeur_data.xp_vkrz;
  const user_next_level_score      = user_level.next_level_score;
  const user_need_xp_to_next_level = user_next_level_score - xp_vkrz;
  const rawPercent                 = (xp_vkrz / user_next_level_score) * 100;
	const roundedPercent             = Math.round(rawPercent * 100) / 100;
	const percent_xp_to_next_level   = Math.min(roundedPercent, 100);

	if (user_need_xp_to_next_level < 0) {
		document.querySelectorAll(".decompte-txt").forEach(function (element) {
			element.innerHTML = "Termine une TopList pour valider ton niveau";
		});
	}

  const pseudo_user         = user_infos.pseudo_user;
  const user_role           = user_infos.role_user;

  if (user_role > 1) {
    document.querySelectorAll(".is_creator").forEach(function (element) {
			element.style.display = "block";
		});

    document.querySelectorAll(".not_creator").forEach(function (element) {
			element.style.display = "none";
		});
    if(document.getElementById('div_recap_creator'))
      document.getElementById('div_recap_creator').style.display = 'block';
	}
  if (user_role >= 5) {
    document.querySelectorAll(".is_gestionnaire").forEach(function (element) {
			element.style.display = "block";
		});

    document.querySelectorAll(".not_gestionnaire").forEach(function (element) {
			element.style.display = "none";
		});
	}
  if (user_role >= 10) {
    document.querySelectorAll(".is_admin").forEach(function (element) {
			element.style.display = "block";
		});

    document.querySelectorAll(".not_admin").forEach(function (element) {
			element.style.display = "none";
		});
	}
}


function display_user_data_public(data){
  const id_vainkeur                = data.data_user.id;
  const nb_votes_vkrz              = data.data_user.nb_votes_vkrz;
  const nb_tops_vkrz               = data.data_user.nb_tops_vkrz;
  const xp_vkrz                    = data.data_user.xp_vkrz;
  const user_level                 = data.data_user.level_vkrz;
  const user_level_name            = user_level.level_name;
  const user_next_level_name       = user_level.next_level_name;

  const pseudo_user         = data.infos_user.pseudo_user;
  const user_role           = data.infos_user.role_user;

  let avatar_user           = data.infos_user.avatar_user;
  let cover_user            = data.infos_user.cover_user;
  if (cover_user == null) {
    cover_user = SITE_BASE_URL + "wp-content/themes/t-vkrz/assets/images/vkrz/cover.jpg";
  }

  $level_icon_txt = `<span class="va va-z-20 va-level-icon va-${user_level_name}"></span>`;
  $next_level_icon_txt = `<span class="va va-z-20 va-level-icon va-${user_next_level_name}"></span>`;

  const vainkeur_link = SITE_BASE_URL + "v/" + data.infos_user.pseudo_slug_user;
  document.querySelectorAll(".vainkeur-link-tofill").forEach(function (element) {
    element.href = vainkeur_link;
  });

  if(avatar_user != null){
    document.querySelectorAll(".avatar-tofill-pub").forEach(function (element) {
      element.style.backgroundImage = "url('" + avatar_user + "')";
    });
  }

  if (data.infos_user.description_user != null){
    document.querySelectorAll(".description-tofill-pub").forEach(function (element) {
      element.innerHTML = data.infos_user.description_user;
    });
  }

  document.querySelectorAll(".cover-vainkeur-tofill-pub").forEach(function (element) {
    element.style.backgroundImage = `url('${cover_user}')`;
  });
  document.querySelectorAll(".vainkeur-pseudo-tofill-pub").forEach(function (element) {
    element.innerHTML = pseudo_user;
  });
  document.querySelectorAll(".user_level_icon-pub").forEach(function (element) {
		element.innerHTML = $level_icon_txt;
	});
  document.querySelectorAll(".user_next_level_icon-pub").forEach(function (element) { element.innerHTML = $next_level_icon_txt; });
  document.querySelectorAll(".nb_votes_vkrz-pub").forEach(function (element) {
		element.innerHTML = nb_votes_vkrz;
	});
  document.querySelectorAll(".nb_tops_vkrz-pub").forEach(function (element) {
		element.innerHTML = nb_tops_vkrz;
	});
  document.querySelectorAll(".xp_vkrz-pub").forEach(function (element) {
		element.innerHTML = xp_vkrz;
	});
  
  if(data.data_user.nb_top_cree) {
    document.querySelectorAll(".nb_tops_creator_tofill").forEach(function (element) { element.innerHTML = data.data_user.nb_top_cree; });
    if(document.querySelector('.nb_tops_creator_tofill_link'))
      document.querySelector('.nb_tops_creator_tofill_link').setAttribute('href', document.querySelector('.nb_tops_creator_tofill_link').getAttribute('href') + `?user=${data.infos_user.uuid_user}`)

    if(data.data_user.nb_top_cree == 1)
      if(document.querySelector('.nb_tops_creator_tofill + small'))
        document.querySelector('.nb_tops_creator_tofill + small').innerHTML = '1 TopList Créée'
  } else {
    if(data.data_user.nb_top_cree == 0)
      if(document.querySelector('.nb_tops_creator_tofill + small'))
        document.querySelector('.nb_tops_creator_tofill + small').innerHTML = 'TopList Créée'
    document.querySelector('.nb_tops_creator_tofill_link').classList.add('d-none')
  }

  const twitch_user       = data.infos_user.twitch_user;
  const youtube_user      = data.infos_user.youtube_user;
  const instagram_user    = data.infos_user.instagram_user;
  const tiktok_user       = data.infos_user.tiktok_user;
  const twitter_user      = data.infos_user.twitter_user;
  const snapchat_user     = data.infos_user.snapchat_user;
  const kick_user         = data.infos_user.kick_user;
  const uuid_user_infos   = data.infos_user.uuid_user;
  document.querySelector("#uuid-user-hidden").value = uuid_user_infos;
  document.querySelector("#pseudo-user-hidden").value = pseudo_user;

  
  if(twitch_user != "" && twitch_user !== null){
    document.querySelectorAll(".twitch-user-tofill").forEach(function (element) {
      element.href = "https://twitch.tv/" + twitch_user;
    });
    document.querySelectorAll(".have_twitch").forEach(function (element) {
			element.setAttribute("style", "display: flex !important;");
		});
  }
  if(twitter_user != "" && twitter_user !== null){
    document.querySelectorAll(".twitter-user-tofill").forEach(function (element) {
      element.href = "https://twitter.com/" + twitter_user;
    });
    document.querySelectorAll(".have_twitter").forEach(function (element) {
			element.setAttribute("style", "display: flex !important;");
		});
  }
  if(kick_user != "" && kick_user !== null){
    document.querySelectorAll(".kick-user-tofill").forEach(function (element) {
			element.href = "https://kick.com/" + kick_user;
		});
    document.querySelectorAll(".have_kick").forEach(function (element) {
			element.setAttribute("style", "display: flex !important;");
		});
  }
  if(youtube_user != "" && youtube_user !== null){
    document.querySelectorAll(".youtube-user-tofill").forEach(function (element) {
      element.href = "https://www.youtube.com/@" + youtube_user;
    });
    document.querySelectorAll(".have_youtube").forEach(function (element) {
			element.setAttribute("style", "display: flex !important;");
		});
  }
  if(instagram_user != "" && instagram_user !== null){
    document.querySelectorAll(".instagram-user-tofill").forEach(function (element) {
      element.href = "https://www.instagram.com/" + instagram_user;
    });
    document.querySelectorAll(".have_instagram").forEach(function (element) {
			element.setAttribute("style", "display: flex !important;");
		});
  }
  if(tiktok_user != "" && tiktok_user !== null){
    document.querySelectorAll(".tiktok-user-tofill").forEach(function (element) {
      element.href = "https://www.tiktok.com/@" + tiktok_user;
    });
    document.querySelectorAll(".have_tiktok").forEach(function (element) {
			element.setAttribute("style", "display: flex !important;");
		});
  }
  if(snapchat_user != "" && snapchat_user !== null){
    document.querySelectorAll(".snapchat-user-tofill").forEach(function (element) {
      element.href = "https://www.snapchat.com/add/" + snapchat_user;
    });
    document.querySelectorAll(".have_snapchat").forEach(function (element) {
			element.setAttribute("style", "display: flex !important;");
		});
  }

  if (
    twitch_user ||
    youtube_user ||
    instagram_user ||
    tiktok_user ||
    twitter_user ||
    snapchat_user ||
    kick_user
  ) {
    let rezo_block = document.getElementById("rezoblock");
    if (rezo_block) {
      setTimeout(function () {
        rezo_block.style.display = "block";
        rezo_block.classList.add("animate__rubberBand");
      }, 2000);
    }
    checkTrophy(id_vainkeur, 8);
  }

  if (document.querySelector("#public_trophy_list")) {
		displayTrophies(id_vainkeur);
	}
}

function fetchRecompenseData(uuid_vainkeur) {
	fetch(`${API_BASE_URL}recompense-list/getfromuser`, {
		method: "POST",
		headers: { "Content-Type": "application/json", },
		body: JSON.stringify({ uuid_vainkeur, }),
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.success) {
				populateRecompenseTable(data.recompense_list);
			}
		});
}

function populateRecompenseTable(trophies) {
  if(document.querySelector("#toprealisescountkeurz")) {
    var recompenseTable = document.querySelector("#toprealisescountkeurz");

    if (!recompenseTable) {
      console.warn("Element #toprealisescountkeurz not found");
      return;
    }

    trophies.forEach((recompense) => {
      let recompenseDate   = (recompense?.date)?.split(" ")[0];
      let dateParts        = recompenseDate.split("-");
      let dateFrenchFormat = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
      let wording = "";
      if(recompense.name === "roue") {
        wording = `<th><b >Roue :</b> <span class="text-info">${recompense.keurz}</span> <span class="text-muted text-lowercase"><span class="va-gem va va-1x"></span> le ${dateFrenchFormat}</span></th>`;
      } else if (recompense.name === "gain") {
        wording = `<th><b>Gain :</b> <span class="text-info">${recompense.keurz}</span> <span class="va-gem va va-1x"></span> le ${dateFrenchFormat} </th>`;
      }
      else{
        wording = `<th><b>Récompense :</b> <span class="text-info">${recompense.keurz}</span> <span class="va-gem va va-1x"></span> pour "${recompense.name}" le ${dateFrenchFormat} </th>`;
      }

      var rowHTML = `
        <tr>
          ${wording}
          <th></th>
          <th class="text-right">${recompense.keurz}</span> 
          <span class="va-gem va va-1x"></span>
          </th>
        </tr>
      `;
      recompenseTable.insertAdjacentHTML("afterend", rowHTML);
    });
  }
}

function fetchTrophyData(id_vainkeur) {
	fetch(API_BASE_URL + "trophy-list/getfromuser", {
		method: "POST",
		headers: { "Content-Type": "application/json", },
		body: JSON.stringify({ id_vainkeur: id_vainkeur, }),
	})
		.then((response) => response.json())
		.then((data) => {
      // console.log("trophylist", data);
			if (data.have_trophy) {
				populateTrophyTable(data.trophy_list);
			}
		});
}

function populateTrophyTable(trophies) {
  if(document.querySelector("#toprealisescountkeurz")) {
    var trophyTable = document.querySelector("#toprealisescountkeurz");

    if (!trophyTable) {
      console.warn("Element #toprealisescountkeurz not found");
      return; // Exit the function if the element is not found
    }

    trophies.forEach((trophy) => {
      var rowHTML = `
        <tr>
          <th>Trophée : <span class="va-${trophy.symbol} va-md va"></span> ${trophy.name}</th>
          <th></th>
          <th class="text-right">${trophy.reward}</span> <span class="va-gem va va-1x"></span></th>
        </tr>
      `;
      trophyTable.insertAdjacentHTML("afterend", rowHTML);
    });
  }
}

function findIdTopStateInObject(collectionUser, idTop) {
  for (const key in collectionUser) {
    if (collectionUser[key] && collectionUser[key].includes(idTop)) {
      switch (key) {
        case "list_top_pending":
          return "begin";
        case "list_top_done":
          return "done";
      }
    }
  }
  return "todo";
}

function getState(state, type_top) {
  const state_infos = {};

  if (state === "done") {
    state_infos["slug"] = "done";
    state_infos["label"] = "Terminé";
    state_infos["bg"] = "bg-success";
    state_infos["wording"] = "Voir ma Toplist";
  } else if (state === "begin") {
    state_infos["slug"] = "en-cours";
    state_infos["label"] = "En cours";
    state_infos["bg"] = "bg-warning";
    state_infos["wording"] = "Continuer ma TopList";
  } else {
    if (type_top === "sponso") {
      state_infos["slug"] = "todo";
      state_infos["label"] = "À faire";
      state_infos["bg"] = "bg-primary";
      state_infos["wording"] = "Participer";
    } else {
      state_infos["slug"] = "todo";
      state_infos["label"] = "À faire";
      state_infos["bg"] = "bg-primary";
      state_infos["wording"] = "Faire ma TopList";
    }
  }

  return state_infos;
}

function createSlug(string) {
    return string
        .toLowerCase()        // Convert to lower case
        .normalize('NFD')     // Normalize string (Unicode decompose)
        .replace(/[\u0300-\u036f]/g, '') // Remove accentuated characters
        .replace(/\s+/g, '-') // Replace spaces with -
        .replace(/[^\w\-]+/g, '') // Remove all non-word characters
        .replace(/\-\-+/g, '-') // Replace multiple - with single -
        .replace(/^-+/, '')   // Trim - from start of text
        .replace(/-+$/, '');  // Trim - from end of text
}

function hasNullAttribute(obj) {
	return Object.values(obj).some((value) => value === null);
}

async function processTops(tops, divToFillWithTops, grid) {

  const fragment = document.createDocumentFragment();

  tops.forEach(t => {
    const div = document.createElement('div');
    div.className = `${grid} grid-item`;
    div.dataset.idTop = t.top_id;

    div.innerHTML = `
      <div class="min-tournoi card h-100 d-flex flex-column">
        <div class="min-tournoi-content">
          <div class="cov-illu-container">
            <div class="cov-illu" style="background: url(${
							t.top_img_min
						}) center center no-repeat">
            </div>
          </div>
        </div>
        <div class="card-body d-flex flex-column flex-grow-1">
          <div class="pushtop d-flex flex-column h-100">
            <div class="min-tournoi-title flex-grow-1">
              <h4 class="titre-top-min eh3 line-clamp-2">
                ${t.top_title}
              </h4>
              <h3 class="card-title eh2 line-clamp-3">${t.top_question}</h3>
            </div>
            <div class="min-tournoi-footer">
              <a href="#" class="btn btn-little" data-bs-toggle="modal" data-bs-target="#modalcontenders-${
								t.top_id
							}">
                ${t.top_number} <span class="va va-versus va-md"></span>
              </a>
              <a href="#" class="btn btn-little" data-bs-toggle="modal" data-bs-target="#modalClassementMondial-${
								t.top_id
							}">
                Classement <span class="va va-globe va-md"></span>
              </a>
            </div>
          </div>
        </div>
        <a href="${t.top_url}" class="stretched-link"></a>
      </div>
      <div class="modal fade" id="modalClassementMondial-${
				t.top_id
			}" tabindex="-1" aria-labelledby="modalClassementMondialLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
          <div class="modal-content">
            <div class="modal-header d-flex align-items-center justify-content-center p-3">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Refermer le classement mondial</button>
            </div>
            <div class="modal-body p-0">
              <!-- Loader -->
              <div id="loader-classementMondial-${t.top_id}" class="text-center p-5">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Chargement du classement mondial en cours...</span>
                </div>
              </div>
              <!-- Placeholder for iframe -->
              <div id="iframeContainer-${t.top_id}" data-src="${
			t.toplist_mondiale
		}?dontshowmenu=true" style="display: none;"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- CONTENDERS MODAL -->
      <div class="modal animate__animated animate__swing" id="modalcontenders-${
				t.top_id
			}" tabindex="-1" aria-labelledby="swinganimationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header d-flex align-items-center justify-content-center p-3">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Refermer la liste des contenders</button>
            </div>
            
            <div class="modal-body">
              <div class="text-center">
                <!-- Loader -->
                <div id="loader-contenders-${t.top_id}" class="text-center p-5">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Présentation des contenders en cours...</span>
                  </div>
                </div>
              </div>
              <div class="list-contenders">
                <div class="row align-items-center justify-content-center list-contenders-items">
                  
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Refermer</button>
            </div>
          </div>
        </div>
      </div>
      <!-- // CONTENDERS MODAL -->
    `;

    fragment.appendChild(div);
  });

  divToFillWithTops.innerHTML = '';
  divToFillWithTops.appendChild(fragment);

  // Add event listeners for modal opening
  tops.forEach(t => {
    const modalContenders = document.querySelector(`#modalcontenders-${t.top_id}`);
    modalContenders.addEventListener('show.bs.modal', function () {
      // Show loader first
      const loader_contenders = document.getElementById(`loader-contenders-${t.top_id}`);
      const container = modalContenders.querySelector(".list-contenders-items");
      
      if (loader_contenders) loader_contenders.style.display = 'block';
      if (container) container.style.display = 'none';

      loadContendersIntoModal(t.top_id, container).then(() => {
        // Hide loader and show content when loading is complete
        if (loader_contenders) loader_contenders.style.display = 'none';
        if (container) container.style.display = 'flex';
      });
    });

    const modal = document.getElementById(`modalClassementMondial-${t.top_id}`);
    modal.addEventListener('show.bs.modal', function () {
      const container = document.getElementById(`iframeContainer-${t.top_id}`);
      const loader = document.getElementById(`loader-classementMondial-${t.top_id}`);
      
      if (!container.querySelector('iframe')) {
        const iframe = document.createElement('iframe');
        iframe.id = `classementMondialIframe-${t.top_id}`;
        iframe.src = container.dataset.src;
        iframe.width = '100%';
        iframe.style.height = '98vh';
        iframe.style.border = 'none';
        
        // Hide iframe until it's loaded
        iframe.style.display = 'none';
        
        // When iframe loads, show it and hide loader
        iframe.onload = function() {
          loader.style.display = 'none';
          container.style.display = 'block';
          iframe.style.display = 'block';
        };
        
        container.appendChild(iframe);
      } else {
        // If iframe already exists, just show container and hide loader
        loader.style.display = 'none';
        container.style.display = 'block';
      }
    });

    // When modal closes, show loader and hide iframe container for next time
    modal.addEventListener('hide.bs.modal', function () {
      const container = document.getElementById(`iframeContainer-${t.top_id}`);
      const loader = document.getElementById(`loader-classementMondial-${t.top_id}`);
      
      loader.style.display = 'block';
      container.style.display = 'none';
    });
  });

  // Initialize tooltips
  document.addEventListener("DOMContentLoaded", function () {
    var tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach(
      (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );
  });
}

async function processTopsComplet(tops, divToFillWithTops, grid) {
	const fragment = document.createDocumentFragment();

	tops.forEach((t) => {
		const div = document.createElement("div");
		div.className = `${grid} grid-item`;
		div.dataset.idTop = t.top_id;
		div.dataset.filterName = `${t.top_question} ${t.top_title}`;
		div.innerHTML = `
      <div class="min-tournoi card">
        <div class="min-tournoi-content">
          <div class="cov-illu-container">
            <div class="cov-illu" style="background: url(${t.top_img_min}) center center no-repeat">
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="content-badge-info-top" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-original-title="${t.top_number} contenders à classer">
            <div class="content-badge-into-top-inside">
                <span class="rounded-fill badge-number-contenders">
                ${t.top_number} <span class="va va-versus va-lg ms-1"></span>
                <span class="rounded-fill badge-number-contenders ms-1">
                  ${t.top_cat_icon}
                </span>
              </span>
            </div>
          </div>
          <div class="min-tournoi-title">
            <h4 class="titre-top-min">${t.top_title}</h4>
            <h3 class="card-title">${t.top_question}</h3>
            <div class="separate mt-4 mb-2"></div>
            <div class="vainkeur-card text-center">
              <a href="#" class="btn btn-flat-primary waves-effect">
                <span class="avatar">
                  <span class="avatar-picture" style="background-image: url(${t.creator_infos.infos_user.avatar_user});"></span>
                </span>
                <span class="championname">
                  <small class="text-muted">
                    Créée par
                  </small>
                  <div class="creatornametopmin">
                    <h4>
                      ${t.creator_infos.infos_user.pseudo_user}
                    </h4>
                  </div>
                </span>
              </a>
            </div>
          </div>
        </div>
        <a href="${t.top_url}" class="stretched-link"></a>
      </div>
    `;

		fragment.appendChild(div);
	});

	divToFillWithTops.innerHTML = "";
	divToFillWithTops.appendChild(fragment);

	// Initialize tooltips after content is added to the DOM
	var tooltipTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="tooltip"]')
	);
	tooltipTriggerList.forEach(
		(tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
	);

	// Ensure Weglot translates new content after DOM update
	setTimeout(() => {
		
	}, 100); // Add a slight delay to ensure content is ready
}

// Usage remains the same
async function giveTrophy(id_vainkeur, id_trophy) {
  let response = "";
  let vainkeur_data = JSON.parse(localStorage.getItem("vainkeur_data"));
  try {
    let res = await fetch(`${API_BASE_URL}trophy-list/check`, {
      method: "POST",
      body: JSON.stringify({
        id_vainkeur: id_vainkeur,
        id_trophy: id_trophy,
      }),
      headers: { "Content-Type": "application/json" }
    });
    if (!res.ok) {
      throw new Error("HTTP error " + res.status);
    }
    let data = await res.json();
    if (data.win_trophy === true) {
      response = "trophy-success";
      setTimeout(() => {
        if(vainkeur_data.id == id_vainkeur) {
          toastr.options = {
            closeButton: false,
            progressBar: true,
            preventDuplicates: true,
            newestOnTop: true,
            timeOut: 5000,
            extendedTimeOut: 1000,
          };
          toastr.options.onShown = function () { $(".toast").addClass("animate__animated animate__tada"); };
          var title   = "Félicitations, trophée obtenu";
          var message = `<span class="va va-${data.symbol} va-1x"></span> ${data.name} <small>(${data.reward}<span class="va va-gem va-1x"></span>)</small>`;
          toastr.success(message, title);
          refresh_user_data(uuid_user);
        } 
      }, 1000);
      if(vainkeur_data.id == id_vainkeur) {
        response = "current-user-trophy";
      } else {
        response = "trophy-success";
      }
    } else if (data.win_trophy === false) {
      response = "trophy-exists";
    }
    return response; 
  } catch (error) {
    console.log("Error:", error.message);
  }
}

async function checkTrophy(id_vainkeur, id_trophy) {
  try {
    if(getParamURL('iframe') == "true") return;
    let res = await fetch(`${API_BASE_URL}trophy-list`);
    if (!res.ok) 
        throw new Error(`HTTP error: ${res.status}`);  
    let data = await res.json();
    const trophyList = data.trophy_list;
    if (trophyList) {
      const existTrophy = trophyList.some((trophy) => trophy.id == id_trophy);
      if (existTrophy) {
        const resposeGiveTrophy = await giveTrophy(id_vainkeur, id_trophy);
        return resposeGiveTrophy;
      } else {
        return "Trophy doesn't exist";
      }
    }
  } catch (error) {
      console.log("Error:", error.message);
      return "error";
  }
}

async function displayTrophies(id_vainkeur) {
  let vainkeur_trophy;
  if (id_vainkeur) {
		const endpoint = API_BASE_URL + "trophy-list/getfromuser";
		try {
			const response = await fetch(endpoint, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify({ id_vainkeur: id_vainkeur }),
			});
			if (response.ok) {
				let data = await response.json();
				vainkeur_trophy = data.trophy_list;
			} else {
				console.error("Error:", response.status, response.statusText);
			}
		} catch (error) {
			console.error("Error:", error);
		}
	} else {
		vainkeur_trophy = JSON.parse(localStorage.getItem("vainkeur_trophy"));
	}
	let trophyDiv = document.getElementsByClassName("user_trophy_list")[0];
	if (vainkeur_trophy && vainkeur_trophy.length > 0) {
		let trophyHTML = "";
		for (let i = 0; i < vainkeur_trophy.length; i++) {
			let trophy = vainkeur_trophy[i];
			trophyHTML += `
        <div class="col-3 col-sm-4 col-lg-2 animate__animated trophy-hidden mb-3" id="trophy-${i}">
          <div class="text-center">
            <span class="user-level" 
              data-bs-toggle="tooltip" 
              data-bs-placement="top" 
              data-bs-original-title="${trophy.name} : ${trophy.description}"
              title="${trophy.name} : ${trophy.description}"
            >
              <span class="va-${trophy.symbol} va-4x va"></span>
            </span>
          </div>
        </div>
      `;
		}
		trophyDiv.innerHTML = trophyHTML;
    $(document).ready(function () { $("body").tooltip({ selector: "[data-bs-toggle=tooltip]", }); });
		for (let i = 0; i < vainkeur_trophy.length; i++) {
			setTimeout(function () {
				let trophyElement = document.getElementById(`trophy-${i}`);
				trophyElement.classList.add("animate__tada");
				trophyElement.classList.remove("trophy-hidden");
				trophyElement.classList.add("trophy-visible");
			}, i * 1000);
		}
	} else {
		trophyDiv.innerHTML =
			'<p class="text-muted">Aucun trophée pour le moment <span class="va va-spiral-eyes va-md"></span></p>';
	}
}

async function displayTrophiesRecap(id_vainkeur) {
  let vainkeur_trophy;
  if (id_vainkeur) {
		const endpoint = API_BASE_URL + "trophy-list/getfromuser";
		try {
			const response = await fetch(endpoint, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify({ id_vainkeur: id_vainkeur }),
			});
			if (response.ok) {
				let data = await response.json();
				vainkeur_trophy = data.trophy_list;
			} else {
				console.error("Error:", response.status, response.statusText);
			}
		} catch (error) {
			console.error("Error:", error);
		}
	} else {
		vainkeur_trophy = JSON.parse(localStorage.getItem("vainkeur_trophy"));
	}
	let trophyDiv = document.getElementsByClassName("user_trophy_list")[0];
	if (vainkeur_trophy && vainkeur_trophy.length > 0) {
		let trophyHTML = "";
		for (let i = 0; i < vainkeur_trophy.length; i++) {
			let trophy = vainkeur_trophy[i];
			trophyHTML += `
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card trophy-bloc basic-pricing text-center">
              <div class="card-body">
                  <div class="ico-master ico-badge">
                      <span class="va va-${trophy.symbol} va-1x"></span>
                    </div>
                  </div>
                  <h3 class="eh1">
                      ${trophy.name}
                  </h3>
                  <p class="card-text eh">
                      ${trophy.description}
                  </p>
              </div>
          </div>
      </div>
      `;
		}
		trophyDiv.innerHTML = trophyHTML;
	} else {
		trophyDiv.innerHTML =
			'<p class="text-muted">Aucun trophée pour le moment <span class="va va-spiral-eyes va-md"></span></p>';
	}
}

function getVainkeurEmoji(user_role, level_name) {
	let vainkeur_emoji_list = "";

	if (user_role == "3") {
		vainkeur_emoji_list +=
			'<span class="va va-vkrzteam va-z-15" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="TeamVKRZ"></span>';
	}
	if (user_role == "2" || user_role == "3") {
		vainkeur_emoji_list +=
			'<span class="va va-creator va-z-15" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Créateur de Tops"></span>';
	}
	vainkeur_emoji_list += `<span class="va va-${level_name} va-z-15"></span>`;

	return vainkeur_emoji_list;
}

function isTopDone(id_top) {
	const storageData = JSON.parse(localStorage.getItem("inventaire_user"));
	const alreadyDoneElement = document.querySelector(".already-done");

	if (
		storageData &&
		Array.isArray(storageData.list_top_done) &&
		storageData.list_top_done.includes(id_top)
	) {
		if (alreadyDoneElement) {
			alreadyDoneElement.style.display = "none";
		}
		return true;
	} else {
		if (alreadyDoneElement) {
			alreadyDoneElement.style.display = "block";
		}
		return false;
	}
}

async function getUserData(uuid_user) {
  const response = await fetch(`${API_BASE_URL}user-list/get?uuid_user=${encodeURIComponent(uuid_user)}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  if (!response.ok) {
    throw new Error('HTTP error ' + response.status);
  }
  
  return await response.json();
}

const calcResemblanceFuncHelperr = async function(myRanking, otherRanking, typeRanking, idTop = 0, isAUserTopList = false) {
  let numberContenders  = myRanking.length,
      pourcentSimilaire = [],
      ressemblances     = [],
      positionEcart,
      similaire,
      ecartRessemblance;

  let myTop1Ranking, globalRanking, whereIsMyTop1, whereIsMyTop1Place;

  if (typeRanking === "top3") {
    myRanking = myRanking.slice(0, 3);
    otherRanking = otherRanking.slice(0, 3);

    numberContenders = 3;

    myRanking.forEach((contender, index) => (contender.place = index));
    otherRanking.forEach((contender, index) => (contender.place = index));
  } else if (typeRanking === "top1") {

    if(!isAUserTopList) {
      myTop1Ranking = myRanking[0].id_wp;

      globalRanking = await fetch(`${SITE_BASE_URL}wp-json/v1/mondialranking/${idTop}`);
      globalRanking = await globalRanking.json();
  
      whereIsMyTop1      = globalRanking.find(contender => contender.id == myTop1Ranking);
      whereIsMyTop1Place = globalRanking.findIndex(contender => contender.id == myTop1Ranking);
    } else {
      myTop1Ranking = myRanking[0].id_wp;

      if(otherRanking.findIndex(contender => contender.id_wp == myTop1Ranking) === -1) {
        // S'IL LE TROUVE PAS ICI, TOP1/TOP3 donc c'est 0% ressemblance
        return "0%";
      } else {
        // COMPARE EN TOP COMPLET
        whereIsMyTop1      = otherRanking.find(contender => contender.id_wp == myTop1Ranking);
        whereIsMyTop1Place = otherRanking.findIndex(contender => contender.id_wp == myTop1Ranking);
      }

    }

  }

  for (let i = 0; i < numberContenders; i++) {
    let otherContenderPlace;
    if (
      otherRanking.find((contender) => contender.id_wp == myRanking[i].id_wp)
    ) {
      otherContenderPlace = otherRanking.find((contender) => contender.id_wp == myRanking[i].id_wp).place;
      positionEcart       = Math.abs(+myRanking[i].place - +otherContenderPlace);
      similaire           = 1 / numberContenders / (positionEcart + 1);
    } else {
      otherContenderPlace = 0;
      positionEcart       = Math.abs(+myRanking[i].place - +otherContenderPlace);
      similaire           = 0;
    }

    if (typeRanking === "top3") {
      ecartRessemblance = 1 / numberContenders / (numberContenders / 2 + 1);
      pourcentSimilaire.push(similaire);
    } else if (typeRanking === "top1") {

      if(!isAUserTopList) {
        ecartRessemblance = (1 - ((whereIsMyTop1Place) / (globalRanking.length - 1))) * 100;
      } else {
        // console.log('whereIsMyTop1Place', whereIsMyTop1Place);
        // console.log('otherRanking', otherRanking);
        // console.log('otherRanking.length', otherRanking.length);
        ecartRessemblance = (1 - ((whereIsMyTop1Place ) / (otherRanking.length - 1))) * 100;
        // console.log('Math.floor(ecartRessemblance', Math.floor(ecartRessemblance));
      }

      return Math.floor(ecartRessemblance) + "%";
    } else {
      ecartRessemblance =
        1 / numberContenders / (Math.floor(numberContenders / 2) + 1);

      if (similaire <= ecartRessemblance) {
        similaire = 0;
        pourcentSimilaire.push(similaire);
      } else {
        pourcentSimilaire.push(similaire);
      }
    }
  }

  ressemblances.push(
    Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100)
  );
  let result =
    Math.round(pourcentSimilaire.reduce((a, b) => a + b, 0) * 100) + "%";

  return result;
};

async function checkFollower(followBtn) {
  const body = JSON.stringify({
    guetteurID: +followBtn.dataset.userid,
    guettedID: +followBtn.dataset.relatedid
  });

  const response = await fetch(`${API_BASE_URL}guettage/check`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body
  });

  const data = await response.json();

  followBtn.classList.remove("d-none");
  followBtn.style.float = "right";

  let span = followBtn.querySelector(".wording");

  if (data.is_guetted) {
    followBtn.classList.add("unfollowBtn");
    followBtn.querySelector(".emoji").classList.replace("va-guetteur-close", "va-guetteur");
    if (span) span.textContent = "Guetté";
  }

  followBtn.addEventListener("click", () => {
    const isUnfollow = followBtn.classList.contains("unfollowBtn");

    followBtn.classList.toggle("unfollowBtn");
    followBtn.querySelector(".emoji").classList.toggle("va-guetteur", !isUnfollow);
    followBtn.querySelector(".emoji").classList.toggle("va-guetteur-close", isUnfollow);

    if (span) span.textContent = isUnfollow ? "Guetter" : "Guetté";

    const followersNbr = document.querySelector(".followers-nbr");
    if (followersNbr) {
      followersNbr.textContent = +followersNbr.textContent + (isUnfollow ? -1 : 1);
      document.querySelector(".followers-nbr-text").textContent = +followersNbr.textContent > 1 ? "Guetteurs" : "Guetteur";
    }

    const endpoint = isUnfollow ? 'delete' : 'new';
    fetch(`${API_BASE_URL}guettage/${endpoint}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body
    });
  });
}

function checkGuetterButton() {
  if (document.querySelector("#followBtn") || document.querySelector(".checking-follower")) {
    const followBtns = document.querySelectorAll("#followBtn");
    followBtns.forEach(checkFollower);
  }
}

function redirectIfNotConnected() {
  setTimeout(() => {
    firebase.auth().onAuthStateChanged((user) => {
      if(!user) 
      window.location.href = `${SITE_BASE_URL}connexion`;
    });
  }, 1000);
}

function checkRoleUser(requiredRole) {
	let userInfoString = localStorage.getItem("user_info");

	if (!userInfoString) {
		window.location.href = "/";
    return null;
  };

	let userInfo = JSON.parse(userInfoString);
	let roleUser = parseInt(userInfo.role_user, 10);

	if (typeof requiredRole !== "undefined" && roleUser < requiredRole || isNaN(roleUser)) {
		window.location.href = "/";
		return roleUser;
	}
	return roleUser;
}

function getRoleUser() {
	let userInfoString = localStorage.getItem("user_info");

	if (!userInfoString) return null;

	let userInfo = JSON.parse(userInfoString);
	let roleUser = parseInt(userInfo.role_user, 10);

	return roleUser;
}

async function populateLinks() {
	const AllLinksTopList = document.querySelectorAll(".toplist-links");

	for (let LinksTopList of AllLinksTopList) {
		let topID = LinksTopList.dataset.idtop;
		let idtoplist = LinksTopList.dataset.idtoplist;

		const topmeta = await get_top_meta(topID);

		LinksTopList.querySelector(".link-toplist").href =
			SITE_BASE_URL + "toplist/" + topmeta["slug"] + "/" + idtoplist;
		LinksTopList.querySelector(".link-toplist-juge").href =
			SITE_BASE_URL +
			"toplist/" +
			topmeta["slug"] +
			"/" +
			idtoplist +
			"#jugement";
	}
}

async function populateVainkeur() {
	const AllVainkeurBloc = document.querySelectorAll(".vainkeurbloc");
  if (AllVainkeurBloc) {
		for (let VainkeurInfo of AllVainkeurBloc) {
			let uuidVainkeur = VainkeurInfo.dataset.vainkeur;
			let vainkeurHtmlBlock = "";
			const data = await getUserData(uuidVainkeur);
			if (data) {
				const creatorLink = `${SITE_BASE_URL}v/${data.infos_user.pseudo_slug_user}`;
				const creatorName = data.infos_user.pseudo_user;
				vainkeurHtmlBlock += `<td>
                <a href="${creatorLink}" class="btn btn-flat-primary waves-effect avatarbloc" data-creatoruuid="${data.infos_user.uuid_user}">
        <span class="avatar">
          <span class="avatar-picture" style="background-image: url(${data.infos_user.avatar_user});"></span>
        </span>
        <span class="championname scale08">
          <small class="text-muted">Créé par</small>
          <div class="creatornametopmin">
            <h4>${creatorName}</h4>
          </div>
        </span>
      </a>
                </td>`;
				VainkeurInfo.innerHTML = vainkeurHtmlBlock;
			}
    }
  }
}

function getTopIcon(top_cat_name) {
  let cat_icon = "";
  switch (top_cat_name) {
      case 'Sport':
          cat_icon = " 🏓 ";
          break;
      case 'Musique':
          cat_icon = " 💿 ";
          break;
      case 'Jeux vidéo':
          cat_icon = " 🕹️ ";
          break;
      case 'Food':
          cat_icon = " 🥨 ";
          break;
      case 'Écran':
          cat_icon = " 📺 ";
          break;
      case 'Comics':
          cat_icon = " 🕸️ ";
          break;
      case 'Manga':
          cat_icon = " 🐲 ";
          break;
      case 'Autres':
          cat_icon = " ⚔️ ";
          break;
      default:
          cat_icon = " : ";
  }

  return cat_icon;
}

async function populateTopHtml() {
	const AlltopInfoHTML = document.querySelectorAll(".topHtml");
	for (let topInfoHTML of AlltopInfoHTML) {
		let topID        = topInfoHTML.dataset.idtop;
		let toplistID    = topInfoHTML.dataset.idtoplist;
		let topHtmlBlock = "";
		const topInfo    = await get_top_info(topID, 'slim');
  
		if (topInfo.top_url) {
      let link = topInfo.top_url;
      if(toplistID !== null && toplistID !== undefined) {
		    const topMeta        = await get_top_meta(topID);
        link = SITE_BASE_URL + "toplist/" + topMeta["slug"] + "/" + toplistID
      }

			topHtmlBlock += `
      <td>
        <a href="${link}" class="top-card">
          <div class="d-flex align-items-center">
            <div class="avatar" style="border-radius: unset!important;">
              <span class="avatar-picture avatar-top" style="background-image: url(${topInfo.top_img});"></span>
            </div>
            <div class="font-weight-bold topnamebestof">
              <div class="media-body">
                <div class="media-heading">
                  <h6 class="cart-item-title mb-0">
                    TOP ${topInfo.top_number} ${topInfo.top_cat_icon} ${topInfo.top_title}
                  </h6>
                  <span class="cart-item-by legende">
                    ${topInfo.top_question}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </a>
      </td>`;
			topInfoHTML.innerHTML = topHtmlBlock;
		} else {
			let elements = document.getElementsByClassName("top-" + topID);
			if (elements.length > 0) {
				elements[0].remove();
			}
		}
	}
}

async function populateContenderHtml() {
	const contenders = document.querySelectorAll(".contenderHtml");
	for (let contender of contenders) {
		let contenderList = contender.dataset.contenderlist.split(",");
		let contenderHtml = "";
		for (let id_wp of contenderList) {
			const response = await fetch(`https://vainkeurz.com/wp-json/v1/getcontenderinfo/${id_wp}`);
			const data = await response.json();
			const cover = data.thumbnail;

			contenderHtml += `
        <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="bottom" data-bs-original-title="${data.c_name}" class="avatartop3 avatar pull-up">
          <img src="${cover}" alt="${data.c_name}">
        </div>
      `;
		}
		contender.innerHTML = contenderHtml;
	}
}

function displayTopListMondialeVedette(id_top) {
  if (!id_top) return;
  const url = `${SITE_BASE_URL}wp-json/v1/mondialranking/${id_top}`;
  fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json(); // Parsing the JSON data from the response
    })
    .then(data => {
      if (!data || data.length === 0) return;
      const parentDiv = document.getElementById('toplistmondialevedette');
      if (!parentDiv) return;
      const firstToplistDiv = parentDiv.querySelector('.card-toplist-monde-1');
      const secondToplistDiv = parentDiv.querySelector('.card-toplist-monde-2');
      const thirdToplistDiv = parentDiv.querySelector('.card-toplist-monde-3');

      // Define a helper function to inject the data into the found divs
      const injectData = (div, data) => {
        if (!div || !data) return; // Return if div or data is not provided
        const imgElement = div.querySelector('.img-cover');
        if (imgElement) imgElement.src = data.cover; // Update the src of the img tag if found
        const nameElement = div.querySelector('.name-placeholder'); // Assuming there is an element with a class 'name-placeholder' where you want to inject the name
        if (nameElement) nameElement.textContent = data.name; // Update the text content of the name placeholder if found
      };

      // Inject the data into the found divs
      injectData(firstToplistDiv, data[0]);
      injectData(secondToplistDiv, data[1]);
      injectData(thirdToplistDiv, data[2]);

      fetchDataForInfo(id_top);
      console.log("id_top", id_top);
    })
    .catch(err => {
      console.error('Fetching failed:', err); // Log the error to the console in case of failure
    });
}

function fetchDataForInfo(id_top) {
  const infoUrl = `${SITE_BASE_URL}wp-json/v1/infotop/${id_top}/slim`;
  
  fetch(infoUrl)
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json(); // Parsing the JSON data from the response
    })
    .then(data => {
      if (!data) return; // Check if data is received

      // Finding elements and injecting data
      const titreElement = document.querySelector('.titre-toplist-mondiale');
      if (titreElement) titreElement.textContent = data.top_title || ''; // Injecting top title

      const questionElement = document.querySelector('.question-toplist-mondiale');
      if (questionElement) questionElement.textContent = data.top_question || ''; // Injecting top question
      
      const coverTLM = document.querySelector(".cover-toplist-mondiale");
			if (coverTLM && data.top_img) {
				coverTLM.style.backgroundImage = `url('${data.top_img}')`;
			}

      const linkToMondial = document.querySelector('.link-toplist-mondiale');
      if (linkToMondial){
        const linksToMondial = document.querySelectorAll('.link-toplist-mondiale');
        linksToMondial.forEach(link => link.href = data.toplist_mondiale || '' );      
      } 

      const toplistmondialevedette = document.getElementById('toplistmondialevedette');
      if (toplistmondialevedette) toplistmondialevedette.style.display = 'block';
    })
    .catch(err => {
      console.error('Fetching top info failed:', err); // Log the error to the console in case of failure
    });
}

async function getTopInfo(id_top) {
  try {
    const response = await fetch(
			`${SITE_BASE_URL}wp-json/v1/infotop/${id_top}/slim`
		);
    if (!response.ok) throw new Error('Network response was not ok' + response.statusText);
    return await response.json();
  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

const getMedalOrRank = (index) => {
  switch (index) {
    case 0:
      return `<span class="ico">🥇</span><br>`;
    case 1:
      return `<span class="ico">🥈</span><br>`;
    case 2:
      return `<span class="ico">🥉</span><br>`;
    default:
      return `<span>${index + 1}<br></span>`;
  }
};

const getMedalOrRankDevine = (index) => {
  switch (index) {
    case 0:
      return `<span class="ico medaille-devine">🥇</span>`;
    case 1:
      return `<span class="ico medaille-devine">🥈</span>`;
    case 2:
      return `<span class="ico medaille-devine">🥉</span>`;
    default:
      return `<span class="rank-devine">${index + 1}<sup>ème</sup></span>`;
  }
};

// Async function to fetch contender information by ID and type
async function getContenderInfo(id, type = 'simple') {
  const url = `${SITE_BASE_URL}wp-json/v1/getcontenderinfo/${id}/${type}`;
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Could not fetch contender info:", error);
    return null; // or return an error object or default data structure
  }
}

function assignRandomOrderClasses() {
	// Select the elements
	const toOrder1Element = document.querySelector(".to-order-1");
	const toOrder2Element = document.querySelector(".to-order-2");
  toOrder1Element.classList.remove("order-1");
  toOrder1Element.classList.remove("order-1");
  toOrder2Element.classList.remove("order-3");
	toOrder2Element.classList.remove("order-3");

	// Generate a random number (0 or 1)
	const randomOrder = Math.random() < 0.5;

	if (randomOrder) {
		// If random number is 0, assign order-1 to to-order-1 and order-2 to to-order-2
		toOrder1Element.classList.add("order-1");
		toOrder2Element.classList.add("order-3");
	} else {
		// If random number is 1, do the opposite
		toOrder1Element.classList.add("order-3");
		toOrder2Element.classList.add("order-1");
	}
}

function getMaxVotesOfTopList(top_number, top_type) {
  let maxVotes = 0;

  if (top_number < 1) return "Invalid top number. It must be greater than 0.";

  switch (top_type) {
      case 'top1':
          maxVotes = Math.max(0, top_number - 1);
          break;
      case 'top3':
          if (top_number > 1) {
              let baseVotes = Math.floor(top_number / 2);
              let additionalVotes = 3 * Math.max(0, (Math.round(top_number / 2) - 1));
              maxVotes = baseVotes + additionalVotes;
          }
          break;
      case 'complet':
          if (top_number >= 3) {
              let baseComplete = Math.max(0, (top_number - 5) * 2 + 6);
              maxVotes = baseComplete * 2; // Simplified assumption for maximum
          } else {
              return "For 'complet', top number must be 3 or more.";
          }
          break;
      default:
          return "Invalid top type. Choose 'top1', 'top3', or 'complet'.";
  }

  return maxVotes;
}

async function checkIfDevinePossible(idToplistDevine) {
  console.log("idToplistDevine", idToplistDevine);
	const url = `${API_BASE_URL}devine/checkifpossible/${idToplistDevine}`;
	try {
		const response = await fetch(url);
		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		}
		const data = await response.json();
		if (data.is_possible) {
			document.querySelectorAll(".is_devine").forEach((element) => {
				element.style.display = "block";
			});
		} else {
			console.log("Devine is not possible with less than 5 votes.");
			// Optionally, handle the case where it's not possible
		}
	} catch (error) {
		console.error("Could not fetch the devine check status:", error);
	}
}

async function checkDevineExists(
	uuid_devine_e,
	uuid_devine_d,
	id_toplist_devine
) {
	// Endpoint URL
	const url = `${API_BASE_URL}devine/check`;

	try {
		const response = await fetch(url, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				uuid_devine_e: uuid_devine_e,
				uuid_devine_d: uuid_devine_d,
				id_toplist_devine: id_toplist_devine,
			}),
		});

		if (!response.ok) {
			throw new Error("Network response was not ok");
		}

		const result = await response.json();

		// Check if an entry exists
		if (result.exists) {
			document.querySelector(".top_not_started").style.display = "none";
			document.querySelector(".top_started").style.display = "none";
			document.querySelector(".top_finito").style.display = "block";
			document.querySelector(".resultats-devine").style.display = "block";
      fetchAndDisplayDevineScores(id_toplist_devine);
      displayScoreDevine(result.data.score_devine);
      displayRankDevine(id_toplist_devine, uuid_devine_d, uuid_devine_e);
		} else {
      document.querySelector(".top_not_started").style.display = "block";
		}
	} catch (error) {
		console.error("There has been a problem with your fetch operation:", error);
	}
}

async function fetchAndDisplayDevineScores(idToplistDevine) {
	const endpoint = `${API_BASE_URL}devine/getdevine/${idToplistDevine}`;
	try {
		const response = await fetch(endpoint);
		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		}
		const data = await response.json();
		const tableBody = document.querySelector("#table-score-devine tbody");

		// Clear existing rows
		tableBody.innerHTML = "";

		console.log("devine.entries", data.entries);

		if (data && data.entries) {
			data.entries.forEach((entry, index) => {
				const row = document.createElement("tr");
				const rank = index;
				const dateDevine = new Date(entry.date_devine).toLocaleDateString(
					"en-US"
				);
				const score = `${entry.score_devine}%`;

				let coverUser = entry.user_devine_info.infos_user.avatar_user
					? entry.user_devine_info.infos_user.avatar_user
					: "https://vainkeurz.com/wp-content/uploads/2024/11/avatar-rose.png";

				row.innerHTML = `
					<td class="medaille-devine-td">${getMedalOrRankDevine(rank)}</td>
					<td class="text-left">
						<div class="vainkeur-card">
							<a href="${SITE_BASE_URL}v/${
					entry.user_devine_info.infos_user.pseudo_slug_user
				}" class="btn btn-flat-primary waves-effect">
								<span class="avatar">
									<span class="avatar-picture" style="background-image: url(${coverUser});"></span>
								</span>
								<span class="championname scale08"> 
									<div class="creatornametopmin">
										<h4>${entry.user_devine_info.infos_user.pseudo_user}</h4>
										<div class="medailles">
											${getVainkeurEmoji(
												entry.user_devine_info.infos_user.role_user,
												entry.user_devine_info.data_user.level_vkrz.level_name
											)}
										</div>
									</div>
								</span>
							</a>
						</div>
					</td>
					<td class="text-left">
						<span data-bs-toggle="tooltip" data-bs-title="Fait le ${dateDevine}">${score}</span>
					</td>
				`;
				tableBody.appendChild(row);

				// Initialize tooltips for the newly added row
				const tooltips = row.querySelectorAll('[data-bs-toggle="tooltip"]');
				tooltips.forEach((element) => {
					new bootstrap.Tooltip(element);
				});
			});

			// ✅ Destroy and reinitialize DataTables with the new data
			reinitializeDataTable();
		} else {
			// Handle case when there are no entries
			tableBody.innerHTML = '<tr><td colspan="3">No entries found</td></tr>';
		}
	} catch (error) {
		console.error("Error fetching devine scores:", error);
	}
}

// ✅ Function to destroy and reinitialize DataTables
function reinitializeDataTable() {
	let table = $("#table-score-devine").DataTable();
	if ($.fn.DataTable.isDataTable("#table-score-devine")) {
		table.destroy(); // Remove old DataTable instance
	}

	// Reinitialize DataTables with the new data
	$("#table-score-devine").DataTable({
		autoWidth: false,
		lengthMenu: [10],
		searching: false,
		paging: true,
		pageLength: 5,
		columns: [{ orderable: false }, { orderable: false }, { orderable: true }],
		order: [],
	});
}

function displayScoreDevine(targetScore) {
  document.querySelector(".progress-fill").style.width = `${targetScore}%`;
	let scoreD = document.querySelectorAll(".pourcentagescore");
	let duration = 2000;
	let increment = 1;
	let interval = duration / targetScore;
	scoreD.forEach((element) => {
		let currentScore = 0;

		let counter = setInterval(() => {
			currentScore += increment;
			element.innerHTML = `${currentScore}%`;

			if (currentScore >= targetScore) {
				clearInterval(counter);
			}
		}, interval);
	});
}


function determineWinnersInTwitchGames(mode, htmlContent) {
  if(mode === 2) {
    // Create a temporary DOM element to hold and parse the HTML
    let tempDOM = document.createElement('div');
    tempDOM.innerHTML = htmlContent;

    // Find the card body that contains the participant names
    let cardBody = tempDOM.querySelector('.card-body');
    if (!cardBody) {
      return {
        status: 'error',
        message: 'Card body not found.'
      };
    }

    // Get all divs that represent participants within the card body
    let participantDivs = cardBody.querySelectorAll('.card-element');
    if (participantDivs.length === 0) {
      return {
        status: 'error',
        message: 'No participants found.'
      };
    }

    // Extract the text content of each participant div
    let participants = Array.from(participantDivs).map(div => div.textContent.trim());

    return {
      status: 'success',
      participants: participants
    };
  }

  if(mode === 3) {
    // Create a temporary DOM element to hold and parse the HTML
    let tempDOM = document.createElement('div');
    tempDOM.innerHTML = htmlContent;

    // Ensure the table tag is present (this includes tbody implicitly)
    let table = tempDOM.querySelector('.table-points');
    if (!table) {
      return {
        status: 'error',
        message: 'No table found in the provided HTML.'
      };
    }

    // Get the tbody directly now that we are sure table exists
    let tbody = table.querySelector('tbody');
    let rows = tbody.querySelectorAll('tr');
    if (rows.length === 0) {
      return {
        status: 'error',
        message: 'No rows found in tbody.'
      };
    }

    // Object to store participants and their points
    let participants = {};

    // Populate participants object with names and points
    rows.forEach(row => {
      const nameCell = row.querySelector('td:nth-child(2)');
      const pointsCell = row.querySelector('td:nth-child(3)');

      if (nameCell && pointsCell && pointsCell.dataset.order) {
        const name = nameCell.textContent.trim();
        const points = parseInt(pointsCell.dataset.order, 10);
        if (!isNaN(points)) {
          if (participants[points]) {
            participants[points].push(name);
          } else {
            participants[points] = [name];
          }
        }
      }
    });

    // Check if data is collected
    if (Object.keys(participants).length === 0) {
      return {
        status: 'error',
        message: 'No valid data extracted from the rows.'
      };
    }

    const highestScore = Math.max(...Object.keys(participants).map(Number));
    const topScorers = participants[highestScore];

    // Determine if there's a tie or a single winner
    if (topScorers.length > 1) {
      return {
        status: 'tie',
        winners: topScorers
      };
    } else if (topScorers.length === 1) {
      return {
        status: 'single_winner',
        winner: topScorers
      };
    }
  }
}

document.addEventListener("DOMContentLoaded", (event) => {
	// Function to fetch toplist id
	const getTopListId = async (uuidUser, topSlug) => {
		const response = await fetch(
			`${API_BASE_URL}toplist-list/get-with-idtop`,
			{
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify({ uuid_user: uuidUser, top_slug: topSlug }),
			}
		);

		const data = await response.json();
		return data.id_toplist;
	};

	// Function to redirect
	const redirectToUrl = async (uuidUser, topSlug) => {
		const topListId = await getTopListId(uuidUser, topSlug);
		const newUrl = SITE_BASE_URL + "/" + topSlug + "/" + topListId + "/";
		window.location.href = newUrl;
	};

	// Event Listener on button
	document.querySelectorAll(".spoun a").forEach((btn) => {
		btn.addEventListener("click", (e) => {
			e.preventDefault();
			const uuidUser = e.target.getAttribute("data-uuid-user");
			const topSlug = e.target.getAttribute("data-top-slug");
			const stateSlug = e.target.getAttribute("data-state-slug");
			if (stateSlug === "done") {
				redirectToUrl(uuidUser, topSlug);
			}
		});
	});

	var confirmDelete = document.querySelectorAll(".confirm_delete");
	if (confirmDelete.length) {
		confirmDelete.forEach(function (element) {
			element.addEventListener("click", function () {
				var top_url       = this.getAttribute("data-urltop");
				var toplistid     = this.getAttribute("data-toplistid");

				Swal.fire({
					title: this.getAttribute("data-phrase1"),
					text: this.getAttribute("data-phrase2"),
					imageUrl:
						"https://vainkeurz.com/wp-content/uploads/2023/01/face-screaming-in-fear-1f631.png",
					imageWidth: 50,
					imageAlt: "Recommencer Top",
					showCancelButton: true,
					confirmButtonText: "Oui oui je suis sûr",
					cancelButtonText: "Annuler",
					customClass: {
						confirmButton: "btn btn-primary confirmrecommence",
						cancelButton: "btn btn-label-danger waves-effect",
					},
					buttonsStyling: false,
				}).then(function (result) {
					if (result.value) {
						document.querySelector(".waiter-begin").style.display = "block";
						deleteTopList(toplistid, uuid_user).then((responseData) => {
							if (responseData !== null) {
								setTimeout(function () {
                  if(getParamURL('iframe') == "true") {
                    window.location.href = top_url + "?iframe=true";
                  } else {
                    window.location.href = top_url;
                  }
								}, 2000);
							}
						});
					}
				});
			});
		});
	}
});

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Find all elements with the class 'laucher_t'
    var launchers = document.querySelectorAll('.laucher_t');

    // Function to add 'top-onduel' class to <body>
    function addClassToBody() {
        document.body.classList.add('top-onduel');
    }

    // Attach click event listeners to each 'laucher_t' element
    launchers.forEach(function(launcher) {
        launcher.addEventListener('click', addClassToBody);
    });
    
    // Find all elements with the class 'laucher_t'
    var launchers2 = document.querySelectorAll(".laucher_finish_t");

    // Attach click event listeners to each 'laucher_t' element
    launchers2.forEach(function(launcher) {
        launcher.addEventListener('click', addClassToBody);
    });
});

async function displayRankDevine(idToplistDevine, uuidDevineD, uuidDevineE) {
  try {
    // Make the fetch call and await the response
    const response = await fetch(`${API_BASE_URL}devine/getposition`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        id_toplist_devine: idToplistDevine,
        uuid_devine_d: uuidDevineD,
        uuid_devine_e: uuidDevineE
      })
    });

    // Parse the JSON response
    const rankData = await response.json();

    // Set medal icon based on position
    let medalIcon = "";
    if (rankData.position === 1) {
      medalIcon = '<span class="ico" style="font-size: 24px;">🥇</span>';
    } else if (rankData.position === 2) {
      medalIcon = '<span class="ico" style="font-size: 24px;">🥈</span>';
    } else if (rankData.position === 3) {
      medalIcon = '<span class="ico" style="font-size: 24px;">🥉</span>';
    } else {
      medalIcon = rankData.position + "<sup>ème</sup>";
    }

    // Update the DOM
    document.querySelector(".rank-devine").innerHTML = medalIcon;

  } catch (error) {
    console.error('Error fetching rank:', error);
  }
}

async function setDevineDone(id_topList, uuidDevineD) {
  try {
    // Make the fetch call and await the response
    const response = await fetch(`${API_BASE_URL}devine/finish`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        id_topList: id_topList,
        uuid_devine_d: uuidDevineD
      })
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    return data;

  } catch (error) {
    console.error('Error setting devine done:', error);
    throw error;
  }
}