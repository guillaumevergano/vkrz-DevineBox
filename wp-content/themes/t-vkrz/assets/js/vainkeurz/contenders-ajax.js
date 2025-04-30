let TOP                         = [],
    contenders                  = [],
    listWR                      = [],
    listLR                      = [],
    type_top                    = "",
    timelineVotes               = 0,
    timelineMain                = 1,
    id_toplist_contenders_ajax  = null,
    id_top_contenders_ajax      = null,
    passOnlyOnceInTimelineMain3 = false,
    alreadyVoted                = false,
    UTM                         = getParamURL("utm_campaign") ? getParamURL("utm_campaign") : localStorage.getItem("utm_campaign");

const waiterTop = document.querySelector("#waiter-top");
let isConvention        = false;
let guessVotesBoolean   = false;
let currentRightGuesses = 0;

function addGuessVote() {
  const innerProgressBar    = document.querySelector(".inner-progress-bar");
  const outerProgressBar    = document.querySelector(".outer-progress-bar");
  const stepsProgressBar    = document.querySelector(".steps-progress-bar");
  const textProgressBar     = document.querySelector(".text-progress-bar");
  const titleDevineVote     = document.querySelector(".title-devine-vote");
  const subTitleDevineVote  = document.querySelector(".subtitle-devine-vote");

  if (currentRightGuesses < 10) {
      currentRightGuesses++;
      const width = currentRightGuesses * 10; // Each step is 10% of the width
      innerProgressBar.style.width = `${width}%`;
      if(stepsProgressBar)
        stepsProgressBar.textContent = currentRightGuesses;
  }

  if (currentRightGuesses === 9) {
    textProgressBar.innerHTML = `DUEL FINAL <span class="va-face-screaming va va-md"></span>`;
    textProgressBar.classList.add('text-progress-bar-finish')
    innerProgressBar.classList.add('inner-progress-bar-finish')
  }

  // Optional: Check if the progress is complete
  if (currentRightGuesses === 10) {
    outerProgressBar.classList.add('d-none');
    subTitleDevineVote.classList.add('d-none');
    titleDevineVote.innerHTML = `&nbsp; &nbsp; C’EST GAGNÉ ! <span class="va-party-popper va va-lg"></span>`;
    confetti.start();
    setTimeout(function () { confetti.stop(); }, 20000);
  }
}
const userInfos = JSON.parse(localStorage.getItem("user_info"));
if (
	isConvention &&
	userInfos &&
	userInfos.pseudo_user != "Lama2Lombre" &&
	!localStorage.getItem("twitchGameMode") &&
	!window.location.href.includes("openings-manga") &&
	!window.location.href.includes("anime-ending") &&
	!window.location.href.includes("arcane-5") &&
	!window.location.href.includes("meilleur-moment-danime")
) {
	if (
		userInfos.pseudo_slug_user.toLowerCase() == "voteurz" ||
		userInfos.pseudo_slug_user.toLowerCase() == "vergy" ||
		userInfos.pseudo_slug_user.toLowerCase() == "voteurz2" ||
		userInfos.pseudo_slug_user.toLowerCase() == "voteurz3" ||
		userInfos.uuid_user == "staphylo062021"
	) {
		if (document.querySelector(".devine-votes-steps")) {
			document.querySelector(".devine-votes-steps").classList.remove("d-none");
			guessVotesBoolean = true;
		}
	}
}

if (
	window.location.href.includes("openings-manga") ||
	window.location.href.includes("openings-ending") ||
	window.location.href.includes("star-wars-film-prefere")
) {
	if (document.querySelector(".vote-byvoice-container")) {
		document
			.querySelector(".vote-byvoice-container")
			.classList.remove("d-none");
	}

	if (
		document.querySelector(".voicevote_contender_1") &&
		document.querySelector(".voicevote_contender_2")
	) {
		document.querySelector(".voicevote_contender_1").classList.remove("d-none");
		document.querySelector(".voicevote_contender_2").classList.remove("d-none");
	}
}

const youtubeVideos = { // DEALING WITH YOUTUBE VIDEOS
	646373:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/1F3OGIFnW1k?si=Q6QJ5RCOJMpnHe7d" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646372:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/D9G1VOjN_84?si=jzVtb_hqQLxqmChw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646374:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/3jf6xOg6e7Y?si=B2W4GaEyV4qvlKxq" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646375:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/Tg9yLrJTmTc?si=UzAH4Y4KZffUkpQ_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646376:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/liPu1_aPH5k?si=17lGY1ZD3Tgw7oVB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646377:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/n68BF6IlGhk?si=ufvqN7qUgmbIGt35" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646378:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/Ns0N8bcB95I?si=Hr9eC694-BwSDViC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646380:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/pKNEx-9OqRM?si=88sxm0woSwy6MPB8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646381:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/mlJWzAOprrI?si=iNBj9RvrPz4F6wc9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	646382:
		'<iframe  id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/JYDwTQC5TlE?si=Jlr3BYCc811x5QwL" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
	653129:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/hvf570" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
	653134:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/jfbt09" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
	653136:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/62hylt" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
	653135:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/qqbnfh" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
	653130:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/txrwxd" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
	653132:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/7vv7c9" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
	653133:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/yhch89" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
	653131:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/95meg9" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
	653137:
		'<iframe  id="cover_contender_X" width="400" height="315" src="https://streamable.com/e/y2k4ga" title="Streamable video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
};

function replaceWithYoutubeIframe(contenderId, elementClass) {
  // Check if the contenderId exists in youtubeVideos array
  if (youtubeVideos[contenderId]) {
    let iframeHtml = youtubeVideos[contenderId];
    iframeHtml = iframeHtml.replace("contender_X", elementClass);
    document.querySelector(`.${elementClass} .illu`).innerHTML = iframeHtml;
    return;
  }

  // Check if the TopList is for YouTube videos
  if (is_toplist_type_youtube_videos_var) {
    const contender = contenders.find((item) => item.id_wp === contenderId);

    if (contender && contender.embed) {
      let iframeHtml = contender.embed;
      iframeHtml = iframeHtml.replace("contender_X", elementClass);
      document.querySelector(`.${elementClass} .illu`).innerHTML = iframeHtml;
    } else {
      console.warn(`Contender with ID ${contenderId} not found or missing .embed`);
    }
  }
}

// LAUNCH FINISH TOPLIST
const laucher_finish_Btns = document.querySelectorAll(".laucher_finish_t");
laucher_finish_Btns.forEach((btn) => {
  btn.addEventListener("click", async (e) => {
    const laucher = btn;
    const topList_id = btn.dataset.toplistid;

    id_toplist_contenders_ajax = topList_id;

    waiterTop.style.display = "block";
    waiterTop.classList.add("fade-in");
    document.querySelector("#global-page").classList.add("focus-top");

    let TOP = topListData;
    if(!TOP) {
      TOP = await SQL_getTopList(topList_id);
      contenders = JSON.parse(TOP.toplist_info.ranking);
    }
    let id_top     = TOP.toplist_info.id_top_rank;
    contenders     = JSON.parse(TOP.toplist_info.ranking);
    type_top       = TOP.toplist_info.type_rank;
    UTM            = TOP.toplist_info.UTM;
    timelineVotes  = TOP.toplist_info.nb_votes;
    timelineMain   = TOP.toplist_info.timelineMain;
    listLR         = JSON.parse(TOP.toplist_info.listLR) ?? [];
    listWR         = JSON.parse(TOP.toplist_info.listWR) ?? [];

    if (timelineVotes === null) 
      timelineVotes = 0;
    
    if (timelineMain === null) 
      timelineMain = 1;
  
    id_top_contenders_ajax = id_top;

    var elementtoplistexists = document.querySelectorAll(".toplistexists");
    elementtoplistexists.forEach(function (element) {
      element.style.display = "block";
    });
    var elements = document.querySelectorAll(".confirm_delete");
    elements.forEach(function (element) {
      element.dataset.toplistid = topList_id;
    });

    await lauch_first_duel(contenders);
    setTimeout(function () {
      waiterTop.style.display = "none";
      waiterTop.classList.remove("fade-in", "fade-out");
      localStorage.getItem("twitchGameMode") ? handleTwitchGames(automaticTwitchGift) : null;
      lauchTop();
    }, 500);
  });
});

const emailInput    = document.getElementById('t-sponso-email-input');
const termsCheckbox = document.getElementById('acceptTopSponsoTerms');
if(!Boolean(participation_inscription_fin_var) && userInfos && userInfos.email_user && emailInput) {
  emailInput.value = userInfos.email_user;
  emailInput.classList.add('d-none');
  termsCheckbox.checked = true;
} 

// LAUNCH BEGIN TOPLIST
const launchTopListBtns = document.querySelectorAll(".laucher_t");
launchTopListBtns.forEach((btn) => {
  btn.addEventListener("click", async (e) => {
    const participationWtihPhone = btn.dataset.phoneparticipation;

    const phoneInput    = document.getElementById('t-sponso-tel-input');
    const launchButton  = document.querySelector('.launcher_t_sponso');
    const errorMessageElemContainer = document.querySelector(".t-sponso-email-alert");
    const errorMessageElem          = document.querySelector(".t-sponso-email-alert span"); 
    if(launchButton && !Boolean(participation_inscription_fin_var)) {
      launchButton.disabled = true;
      function validateEmail(email) {
				const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
				return regex.test(email);
			}
			function updateLaunchButtonState() {
				launchButton.disabled =
					!validateEmail(emailInput.value) || !termsCheckbox.checked;
			}
			emailInput.addEventListener("input", updateLaunchButtonState);
			termsCheckbox.addEventListener("change", updateLaunchButtonState);

			const vainkeurData = JSON.parse(localStorage.getItem("vainkeur_data"));
			errorMessageElemContainer.classList.add("d-none");

			if (participationWtihPhone == "true") {
				if (!termsCheckbox.checked) {
					errorMessageElem.textContent =
						"Hey, n'oublie pas d'accepter les conditions générales pour pouvoir participer !";
					errorMessageElemContainer.classList.remove("d-none");
					return;
				}

				function validatePhone(phone) {
					const regex = /^[0-9]\d{1,14}$/;
					return regex.test(phone);
				}
				function updateLaunchButtonState() {
					launchButton.disabled =
						!validatePhone(phoneInput.value) || !termsCheckbox.checked;
				}

				phoneInput.addEventListener("input", updateLaunchButtonState);
				termsCheckbox.addEventListener("change", updateLaunchButtonState);

				if (phoneInput.value === "" || !validatePhone(phoneInput.value)) {
					errorMessageElem.textContent =
						"Pour continuer, entre ton numéro de téléphone valide, stp";
					errorMessageElemContainer.classList.remove("d-none");
					return;
				}

				function getCountryCodeFromTitle() {
					if (document.querySelector(".iti__selected-flag")) {
						var selectedFlag = document.querySelector(".iti__selected-flag");
						var title = selectedFlag.getAttribute("title");
						var countryCodeMatch = title.match(/:\s\+(\d+)/);
						return countryCodeMatch ? `+${countryCodeMatch[1]}` : "";
					}
					return "";
				}

				var countryCode = getCountryCodeFromTitle();
				var fullPhoneNumber = countryCode + phoneInput.value.replace(/^0+/, ""); // Remove leading zeros from input

				try {
					let response = await fetch(`${API_BASE_URL}participation-list/new`, {
						method: "POST",
						headers: { "Content-Type": "application/json" },
						body: JSON.stringify({
							id_top_p: id_top,
							uuid_vainkeur: uuid_user,
							email_p: emailInput.value,
							phone_p: fullPhoneNumber,
						}),
					});

					let data = await response.json();
					console.log(data);

					if (data.status === "Nouvelle participation ajoutée") {
						checkTrophy(vainkeurData.id, 17);
					}
				} catch (error) {
					console.error("An error occurred:", error);
					errorMessageElem.textContent =
						"Une erreur est survenue, veuillez réessayer plus tard";
					errorMessageElemContainer.classList.remove("d-none");
					return;
				}
			} else {
				function validateEmail(email) {
					const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
					return regex.test(email);
				}
				function updateLaunchButtonState() {
					launchButton.disabled =
						!validateEmail(emailInput.value) || !termsCheckbox.checked;
				}
				emailInput.addEventListener("input", updateLaunchButtonState);
				termsCheckbox.addEventListener("change", updateLaunchButtonState);

				if (!termsCheckbox.checked) {
					errorMessageElem.textContent =
						"Hey, n'oublie pas d'accepter les conditions générales pour pouvoir participer !";
					errorMessageElemContainer.classList.remove("d-none");
					return;
				}

				if (emailInput.value === "" || !validateEmail(emailInput.value)) {
					errorMessageElem.textContent =
						"Pour continuer, entre ton adresse e-mail valide, stp";
					errorMessageElemContainer.classList.remove("d-none");
					return;
				}

				try {
					let response = await fetch(`${API_BASE_URL}participation-list/new`, {
						method: "POST",
						headers: { "Content-Type": "application/json" },
						body: JSON.stringify({
							id_top_p: id_top,
							uuid_vainkeur: uuid_user,
							email_p: emailInput.value,
						}),
					});

					let data = await response.json();
					console.log(data);

					if (data.status === "Nouvelle participation ajoutée") {
						checkTrophy(vainkeurData.id, 17);
					}
				} catch (error) {
					console.error("An error occurred:", error);
					window.location.reload();
				}
			}
    }

    document.querySelector("#global-page").classList.add("focus-top");
    waiterTop.style.display = "block";
    waiterTop.classList.add("fade-in");

    type_top = btn.dataset.type_top;
    adjustTypeTopVisibility(type_top);

    if (type_top === "top1") {
      automaticTwitchGift = automaticTwitchGiftTop1;
    } else if (type_top === "top3") {
      automaticTwitchGift = automaticTwitchGiftTop3;
    } else if (type_top === "complet") {
      automaticTwitchGift = automaticTwitchGiftTopComplet;
    } else {
      automaticTwitchGift = false;
    }

    let initContenders = JSON.parse(sessionStorage.getItem(`contenders_${id_top}`));
    if(!initContenders) {
      TOP = await fetchDataFuncHelper(`${SITE_BASE_URL}wp-json/v1/getrankingoftop/${id_top}/elo`);
      contenders = TOP.ranking;
    }
    else{
      contenders = initContenders;
    }
    console.log(contenders, "contenders");

    document.querySelectorAll(".toplistexists").forEach((element) => {
      element.style.display = "block";
    });

    id_toplist_contenders_ajax = await SQL_createTopList({
      uuid_user: uuid_user,
      ranking: contenders,
      id_top_rank: id_top,
      type_rank: type_top,
      uuid_creator: btn.dataset.uuid_creator,
      UTM: UTM,
    });

    await lauch_first_duel(contenders);

    setTimeout(() => {
      localStorage.getItem("twitchGameMode") && handleTwitchGames(automaticTwitchGift); 
      lauchTop(); 
      waiterTop.style.display = "none";
      waiterTop.classList.remove("fade-in", "fade-out");
    }, 500);
  });
});

function adjustTypeTopVisibility(type_top) {
  if (type_top === "top3") {
    $(".cta-complet, .cta-top1").hide();
  } else if (type_top === "complet") {
    $(".cta-top3, .cta-top1").hide();
  } else if (type_top === "top1") {
    $(".cta-top3, .cta-complet").hide();
  }
}

// ALGORITHM FUNCTIONS
function get_contenders_top_3_2(contenders) {
  const listInf1 = [];
  const listContenders = contenders;
  listContenders.forEach((contender) => {
    if (contender.less_to.length === 0) {
      listInf1.push(contender.id_wp);
    }
  });
  contenders = listContenders;
  return listInf1;
}

function get_contenders_top_3_2_top1(contenders) {
  const listInf1 = [];
  const listContenders = contenders;
  listContenders.forEach((contender) => {
    if (contender.less_to.length === 0) {
      listInf1.push({ id_wp: contender.id_wp, ratio: contender.ratio });
    }
  });
  listInf1.sort((a, b) => a.ratio - b.ratio);
  contenders = listContenders;
  return listInf1;
}

function get_contenders_top_3_3(contenders) {
  const listInf2 = [];
  const listContenders = contenders;
  listContenders.forEach((contender) => {
    if (contender.less_to && contender.less_to.length === 1) {
      listInf2.push(contender.id_wp);
    }
  });
  return listInf2;
}

function get_contenders_top_3_4(contenders) {
  const listInf3 = [];
  const listContenders = contenders;
  listContenders.forEach((contender) => {
    if (contender.less_to && contender.less_to.length === 2) {
      listInf3.push(contender.id_wp);
    }
  });
  return listInf3;
}

function get_steps(contenders) {
  const list_contenders = contenders;
  const nb_contenders   = list_contenders.length;
  let counter = 0;
  if(type_top === "top1") {
    const current_step = Math.round(timelineVotes / (nb_contenders - 1) * 100);

    return current_step;
  } else if (type_top === "top3") {
    let inf_1 = 0;
    let inf_2 = 0;
    let inf_3 = 0;
    const fact_inf_1 = 50 / (nb_contenders - 1);
    const fact_inf_2 = 25 / (nb_contenders - 2);
    const fact_inf_3 = 25 / (nb_contenders - 3);

    list_contenders.forEach((contender) => {
      if (contender["less_to"].length >= 1) {
        inf_1++;
      }
      if (contender["less_to"].length >= 2) {
        inf_2++;
      }
      if (contender["less_to"].length >= 3) {
        inf_3++;
      }
    });

    const current_step = Math.round(
      inf_1 * fact_inf_1 + inf_2 * fact_inf_2 + inf_3 * fact_inf_3
    );

    return current_step;
  } else {
    list_contenders.forEach((contender) => {
      counter += contender["more_to"].length + contender["less_to"].length;
    });
    const current_step = Math.round(
      (counter * 100) / ((nb_contenders - 1) * nb_contenders)
    );

    return current_step;
  }
}

function do_vote(idWinner, idLooser, contenders) {
	let listContenders = contenders,
		alreadySupTo = [],
		alreadyInfTo = [],
		listSupToL = [],
		listInfToV = [];
	listContenders.forEach((contender, key) => {
		if (contender.more_to.includes(idWinner)) {
			alreadySupTo.push(contender.id_wp);
		}
		if (contender.less_to.includes(idLooser)) {
			alreadyInfTo.push(contender.id_wp);
		}
	});
	if (idWinner) {
		alreadySupTo.push(idWinner);

		listSupToL = contenders.find((item) => item.id_wp == idLooser).more_to;

		if (timelineMain === 1) {
			listWR.push(idWinner);
		}
	}
	if (idLooser) {
		alreadyInfTo.push(idLooser);

		listInfToV = contenders.find((item) => item.id_wp == idWinner).less_to;

		if (timelineMain === 1) {
			listLR.push(idLooser);
		}
	}

	[...new Set(alreadySupTo)].forEach((k) => {
		let toUpSupTo = contenders.find((item) => item.id_wp == k).more_to;

		toUpSupTo.push(idLooser);

		let totalSupTo = [...listSupToL, ...toUpSupTo];
		contenders.find((item) => item.id_wp == k).more_to = [
			...new Set(totalSupTo),
		];

		let countSupOf = contenders.find((item) => item.id_wp == k).more_to.length;
		let newPlace = countSupOf;

		let countInfOf = contenders.find((item) => item.id_wp == k).less_to.length;
		let ratio = countSupOf - countInfOf;

		contenders.find((item) => item.id_wp == k).place = newPlace;
		contenders.find((item) => item.id_wp == k).ratio = ratio;
	});

	[...new Set(alreadyInfTo)].forEach((k) => {
		let toUpInfTo = contenders.find((item) => item.id_wp == k).less_to;

		toUpInfTo.push(idWinner);

		let totalInfTo = [...listInfToV, ...toUpInfTo];
		contenders.find((item) => item.id_wp == k).less_to = [
			...new Set(totalInfTo),
		];

		let countSupOf = contenders.find((item) => item.id_wp == k).more_to.length;
		let newPlace = countSupOf;

		let countInfOf = contenders.find((item) => item.id_wp == k).less_to.length;
		let ratio = countSupOf - countInfOf;

		contenders.find((item) => item.id_wp == k).place = newPlace;
		contenders.find((item) => item.id_wp == k).ratio = ratio;
	});
	fetch(`${API_BASE_URL}vote-list/new`, {
		method: "POST",
		headers: { "Content-Type": "application/json", },
		body: JSON.stringify({
			id_winner_contender: +idWinner,
			id_looser_contender: +idLooser,
			id_top_v: +id_top,
      id_toplist_v: +id_toplist_contenders_ajax,
			uuid_vainkeur: uuid_user,
		}),
	}).then((response) => response.json());
	timelineVotes++;
	const xpcagnotteElements      = document.querySelectorAll(".nb_decompte_level_vkrz");
	const barrecagnottesElements  = document.querySelectorAll(".next-level-bar");
	const wordingLevelTop         = document.querySelectorAll(".decompte-txt");
	xpcagnotteElements.forEach((xpcagnotte, index) => {
		var xpcagnotte = xpcagnotteElements[index];
		if (xpcagnotte) {
			var XPrestantActual = parseInt(xpcagnotte.textContent);
		}
		var barrecagnottes = barrecagnottesElements[index];
		const vainkeur_data = JSON.parse(localStorage.getItem("vainkeur_data"));
		const user_level = vainkeur_data.level_vkrz;
		const user_next_level_score = user_level.next_level_score;
		if (!isNaN(XPrestantActual)) {
			XPrestantActual -= 1;
			xpcagnotte.textContent = XPrestantActual;
			if (XPrestantActual == 0) {
				const apiURL = API_BASE_URL + "level/check"; // Ensure API_BASE_URL is defined
				const uuid_user = vainkeur_data.uuid_user;
				fetch(apiURL, {
					method: "POST",
					headers: { "Content-Type": "application/json" },
					body: JSON.stringify({ uuid_user: uuid_user }),
				})
					.then((response) => response.json())
					.then((data) => {
						console.log("data", data);
						if (data.new_level && data.new_level.is_new_level) {
							wordingLevelTop.forEach((element) => {
								element.innerHTML = `Bravo, tu passes <span class="va va-lg va-${data.new_level.next_new_level}"></span>`;
							});
							var progressBarPrimaryElements = document.querySelectorAll(
								".progress-bar-primary"
							);
							progressBarPrimaryElements.forEach((element) => {
								element.style.display = "none";
							});
						}
					})
					.catch((error) => {
						console.error("Error:", error);
					});
			} else {
				var XPvaleurActual = user_next_level_score - XPrestantActual;
				barrecagnottes.style.width =
					Math.round((XPvaleurActual / user_next_level_score) * 100) + "%";
			}
		}
	});
}

function check_battle_2(contenders, list) {
  let list_contenders = contenders,
      list_inf_of_c1 = [],
      list_inf_of_c2 = [],
      list_sup_of_c1 = [],
      list_sup_of_c2 = [],
      battle = false,
      nb_list = list.length,
      nextDuel = [],
      key_c1,
      key_c1_wp,
      key_c2,
      key_c2_wp;
  for (let m = 0; m < nb_list; m++) {
    if (!battle) {
      for (let key in list_contenders) {
        let contender = list_contenders[key];

        if (contender.id_wp == list[timelineVotes - nb_list]) {
          key_c1         = contender.id;
          key_c1_wp      = contender.id_wp;
          list_inf_of_c1 = contender.more_to;
          list_sup_of_c1 = contender.less_to;
        }

        if (contender.id_wp == list[timelineVotes + 1 - nb_list]) {
          key_c2         = contender.id;
          key_c2_wp      = contender.id_wp;
          list_inf_of_c2 = contender.more_to;
          list_sup_of_c2 = contender.less_to;
        }
      }

      let c1_less_more = list_inf_of_c1.concat(list_sup_of_c1);
      let c2_less_more = list_inf_of_c2.concat(list_sup_of_c2);

      if (
        c2_less_more.includes(String(key_c1_wp)) ||
        c1_less_more.includes(String(key_c2_wp)) ||
        key_c1 == key_c2
      ) {
        battle = false;
        timelineVotes++;
      } else {
        battle = true;
        nextDuel.push(+key_c1_wp);
        nextDuel.push(+key_c2_wp);
      }
    } else {
      break;
    }
  } 
  return nextDuel;
}

function check_battle_4(contenders, list) {
  let list_contenders = contenders,
      list_inf_of_c1  = [],
      list_inf_of_c2  = [],
      list_sup_of_c1  = [],
      list_sup_of_c2  = [],
      battle          = false,
      nb_list         = list.length,
      nextDuel        = [],
      key_c1,
      key_c1_wp,
      key_c2,
      key_c2_wp;
  for (let m = 1; m < 5; m++) {
    if (!battle) {
      for (let key in list_contenders) {
        let contender = list_contenders[key];

        if (contender.id_wp == list[(timelineVotes - nb_list) - 5]) {
          key_c1         = contender.id;
          key_c1_wp      = contender.id_wp;
          list_inf_of_c1 = contender.more_to;
          list_sup_of_c1 = contender.less_to;
        }

        if (contender.id_wp == list[(timelineVotes - nb_list) - 4]) {
          key_c2         = contender.id;
          key_c2_wp      = contender.id_wp;
          list_inf_of_c2 = contender.more_to;
          list_sup_of_c2 = contender.less_to;
        }
      }

      let c1_less_more = list_inf_of_c1.concat(list_sup_of_c1);
      let c2_less_more = list_inf_of_c2.concat(list_sup_of_c2);

      if (
        c2_less_more.includes(String(key_c1_wp)) ||
        c1_less_more.includes(String(key_c2_wp)) ||
        key_c1 == key_c2
      ) {
        battle = false;
        timelineVotes++;
      } else {
        battle = true;
        nextDuel.push(+key_c1_wp);
        nextDuel.push(+key_c2_wp);
      }
    } else {
      break;
    }
  }
  return nextDuel;
}

function check_battle_5(contenders) {
  let list_contenders = contenders;
  list_contenders = list_contenders.sort((a, b) => a.ratio - b.ratio);
  let list = list_contenders;
  let list_inf_of_c1 = [];
  let list_inf_of_c2 = [];
  let list_sup_of_c1 = [];
  let list_sup_of_c2 = [];
  let battle = false;
  let nb_list = list_contenders.length;
  let next_duel = [];
  let timeline = 0;
  for (let m = 1; m <= nb_list; m++) {
    if (!battle) {
      timeline += 1;

      let key_c1, key_c1_wp, key_c2, key_c2_wp;

      for (let key in list_contenders) {
        let contender = list_contenders[key];

        if (contender.id_wp == list[timeline - 1].id_wp) {
          key_c1 = contender.id;
          key_c1_wp = String(contender.id_wp);
          list_inf_of_c1 = contender.more_to;
          list_sup_of_c1 = contender.less_to;
        }

        if (contender.id_wp == list[timeline]?.id_wp) {
          key_c2 = contender.id;
          key_c2_wp = String(contender.id_wp);
          list_inf_of_c2 = contender.more_to;
          list_sup_of_c2 = contender.less_to;
        }
      }

      let c1_less_more = list_inf_of_c1.concat(list_sup_of_c1);
      let c2_less_more = list_inf_of_c2.concat(list_sup_of_c2);

      if (
        c2_less_more.includes(key_c1_wp) ||
        c1_less_more.includes(key_c2_wp) ||
        key_c1 == key_c2
      ) {
        battle = false;
      } else {
        battle = true;
        next_duel.push(+key_c1_wp);
        next_duel.push(+key_c2_wp);
      }
    } else {
      break;
    }
  }
  return next_duel;
}

async function get_nextDuel(contenders) {
  let nextDuel   = [];
  let isNextDuel = true;
  let contender1 = 0;
  let contender2 = 0;
  let listContenders = contenders;
  let nbContenders   = listContenders.length;
  if(type_top === "top1") {
    let halfInf = Math.floor(nbContenders / 2);

    if (timelineMain === 1) {
      if (timelineVotes === halfInf) {
        timelineMain = 2;
      } else {
        let keyC1 = nbContenders - (1 + timelineVotes);
        let keyC2 = nbContenders - (1 + halfInf + timelineVotes);

        nextDuel.push(contenders[keyC1].id_wp);
        nextDuel.push(contenders[keyC2].id_wp);
      }
    }

    if (timelineMain === 2) {
      let listInf1   = get_contenders_top_3_2_top1(contenders);
      let nbListInf1 = listInf1.length;
      if (nbListInf1 < 2) {
        isNextDuel = false;
      } else {
        listInf1Sorted = listInf1.sort((a, b) => b.ratio - a.ratio);
        let keyC1 = listInf1[nbListInf1 - 2].id_wp;
        let keyC2 = listInf1[nbListInf1 - 1].id_wp;
        nextDuel.push(keyC1);
        nextDuel.push(keyC2);
      }
    }

  } else if (type_top === "top3") {
    let halfInf = Math.floor(nbContenders / 2);

    if (timelineMain === 1) {
      if (timelineVotes === halfInf) {
        timelineMain = 2;
      } else {
        let keyC1 = nbContenders - (1 + timelineVotes);
        let keyC2 = nbContenders - (1 + halfInf + timelineVotes);

        nextDuel.push(contenders[keyC1].id_wp);
        nextDuel.push(contenders[keyC2].id_wp);
      }
    }

    if (timelineMain === 2) {
      let listInf1 = get_contenders_top_3_2(contenders);
      let nbListInf1 = listInf1.length;
      let random = Math.floor(Math.random() * (nbListInf1 - 1)) + 2;

      if (nbListInf1 === 1) {
        timelineMain = 3;
      } else {
        let keyC1 = listInf1[random - 2];
        let keyC2 = listInf1[random - 1];
        nextDuel.push(keyC1);
        nextDuel.push(keyC2);
      }
    }

    if (timelineMain === 3) {
      let listInf2 = get_contenders_top_3_3(contenders);
      let nbListInf2 = listInf2.length;
      let random = Math.floor(Math.random() * (nbListInf2 - 1)) + 2;

      if (nbListInf2 === 1) {
        timelineMain = 4;
      } else {
        let keyC1 = listInf2[random - 2];
        let keyC2 = listInf2[random - 1];
        nextDuel.push(keyC1);
        nextDuel.push(keyC2);
      }
    }

    if (timelineMain === 4) {
      let listInf3 = get_contenders_top_3_4(contenders);
      let nbListInf3 = listInf3.length;
      let random = Math.floor(Math.random() * (nbListInf3 - 1)) + 2;

      if (nbListInf3 < 2) {
        isNextDuel = false;
      } else {
        let keyC1 = listInf3[random - 2];
        let keyC2 = listInf3[random - 1];
        nextDuel.push(keyC1);
        nextDuel.push(keyC2);
      }
    }

  } else if (type_top === "complet") {
    if (nbContenders >= 10) {
      if (timelineVotes === nbContenders - 5) {
        timelineMain = 2;
      }
    } else {
      if (timelineVotes < nbContenders - 1) {
        timelineMain = 6;
      } else {
        timelineMain = 7;
      }
    }

    if (timelineMain === 1) {
      console.log("timelineMain === 1")

      let keyC1 = nbContenders - (1 + timelineVotes);
      let keyC2 = nbContenders - (6 + timelineVotes);

      nextDuel.push(contenders[keyC1].id_wp);
      nextDuel.push(contenders[keyC2].id_wp);
    }

    if (timelineMain === 2) {
      console.log("timelineMain === 2")

      nextDuel = [];
      nextDuel = check_battle_2(contenders, listLR);

      if (
        nextDuel.some((item) => item === undefined ||
        nextDuel.some((item) => isNaN(item))) ||
        nextDuel.length < 2
      ) {
        timelineMain = 3;
      }
    }

    if( timelineMain === 3) {
      console.log("timelineMain === 3");

      if(passOnlyOnceInTimelineMain3 === false) {

        let keyC1, keyC2, keyC1_WP, keyC2_WP, listInfOfC1, listSupOfC1, listInfOfC2, listSupOfC2, C1lessMore, C2lessMore;

        keyC1       = listWR.length - 5;
        keyC2       = listLR.length - 1;

        keyC1_WP    = listWR[keyC1];
        keyC2_WP    = listLR[keyC2];

        keyC1_WP_CONTENDERS = contenders.find(item => item.id_wp == keyC1_WP);
        keyC2_WP_CONTENDERS = contenders.find(item => item.id_wp == keyC2_WP);

        listInfOfC1 = keyC1_WP_CONTENDERS.more_to;
        listSupOfC1 = keyC1_WP_CONTENDERS.less_to;

        listInfOfC2 = keyC2_WP_CONTENDERS.more_to;
        listSupOfC2 = keyC2_WP_CONTENDERS.less_to;

        C1lessMore  = listInfOfC1.concat(listSupOfC1);
        C2lessMore  = listInfOfC2.concat(listSupOfC2);

        if (
          C2lessMore.includes(String(keyC1_WP_CONTENDERS.id_wp)) ||
          C1lessMore.includes(String(keyC2_WP_CONTENDERS.id_wp)) ||
          keyC1 == keyC2
        ) {
          timelineMain = 4;
          timelineVotes++;
        } else {
          nextDuel = [];
          nextDuel.push(keyC1_WP_CONTENDERS.id_wp);
          nextDuel.push(keyC2_WP_CONTENDERS.id_wp);
        }
        
        passOnlyOnceInTimelineMain3 = true;
      } else {
        timelineMain = 4;
      }

    }

    if (timelineMain === 4) {
      console.log("timelineMain === 4")

      nextDuel = [];
      nextDuel = check_battle_4(contenders, listWR);

      if (
        nextDuel.some((item) => item === undefined) ||
        nextDuel.some((item) => isNaN(item)) ||
        nextDuel.length < 2 
      ) {
        timelineMain = 5;

        nextDuel = [];
        nextDuel = check_battle_5(contenders);

        if (
          nextDuel.some((item) => item === undefined) ||
          nextDuel.some((item) => isNaN(item))
        ) {
          isNextDuel = false;
        }
      }
    }

    if (timelineMain === 5) {
      console.log("timelineMain === 5")

      timelineMain = 5;

      nextDuel = [];
      nextDuel = check_battle_5(contenders);

      if (
        nextDuel.some((item) => item === undefined) ||
        nextDuel.some((item) => isNaN(item))
      ) {
        isNextDuel = false;
      }
    }

    if (timelineMain === 6) {
      console.log("timelineMain === 6")
      timelineMain = 6;

      let keyC1 = nbContenders - (2 + timelineVotes);
      let keyC2 = nbContenders - (1 + timelineVotes);

      nextDuel.push(contenders[keyC1].id_wp);
      nextDuel.push(contenders[keyC2].id_wp);
    }

    if (timelineMain === 7) {
      console.log("timelineMain === 7")

      timelineMain = 7;

      nextDuel = [];
      nextDuel = check_battle_5(contenders);

      if (
        nextDuel.some((item) => item === undefined) ||
        nextDuel.some((item) => isNaN(item))
      ) {
        isNextDuel = false;
      }
    }
  }
  if (isNextDuel) {

    let val1 = Math.floor(Math.random() * 2);
    let val2 = val1 === 0 ? 1 : 0;
    contender1 = nextDuel[val1];
    contender2 = nextDuel[val2];

    if (timelineVotes > 0){
      await SQL_saveTopList({
        id_current_topList: id_toplist_contenders_ajax,
        uuid_user: uuid_user,
        id_top_rank: id_top,
        type_rank: type_top,
        nb_votes: timelineVotes,
        timelineMain: timelineMain,
        ranking: contenders,
        listWR: JSON.stringify(listWR),
        listLR: JSON.stringify(listLR),
        UTM: UTM,
        state_toplist: "pending",
      });
    }
  } else {
    document.getElementById("waiter-toplist").style.display = "block";

     // SAVE TWITCH GAME RESULTS…
     if (
      document.querySelector(".display_battle") &&
      localStorage.getItem("twitchGameMode") !== null &&
      votePointsBoolean
    ) {
      const twitchGameResumeObj = {
        idRanking: id_toplist_contenders_ajax,
        id_twitch_game: id_twitch_game,
        mode: "votePoints",
      };
      localStorage.setItem("resumeTwitchGame", JSON.stringify(twitchGameResumeObj));

      // SAVE TO DATABASE
      fetch(`${API_BASE_URL}twitch/update-participants-game`, {
        method: 'POST',
        body: JSON.stringify({
          id: id_twitch_game,
          extra_field_for_points_game: ((document.querySelector(".table-points tbody").innerHTML).trim()).replace(/>[\s]+</g, '><')
        }),
        headers: { 'Content-Type': 'application/json' }
      })
        .then(response => response.json()) 
        .then(data => { console.log(data, "new request to save points game") })
    } 
    if (document.querySelector(".display_battle") && localStorage.getItem("twitchGameMode") !== null && votePredictionBoolean && winnerAlready === false) {
      fetch(`${API_BASE_URL}twitch/update-participants-game`, {
        method: 'POST',
        body: JSON.stringify({
          id: id_twitch_game,
          rest_participants: Object.keys(users)
        }),
        headers: { 'Content-Type': 'application/json', }
      })
        .then(response => response.json()) 
        .then(data => {
          if(data.status === "success") { 
            const twitchGameResumeObj = {
              idRanking: id_toplist_contenders_ajax,
              participantsNumber: `${Object.keys(users).length}`,
              mode: "votePrediction",
              winner: null,
            };
            localStorage.setItem("resumeTwitchGame", JSON.stringify(twitchGameResumeObj));
          }
        })
    }

    setTimeout(async function () {
			await SQL_saveTopList({
        id_current_topList: id_toplist_contenders_ajax,
        uuid_user: uuid_user,
        id_top_rank: id_top,
        type_rank: type_top,
        nb_votes: timelineVotes,
        ranking: contenders,
        UTM: UTM,
        timelineMain: timelineMain,
        state_toplist: "done",
        slugTop: slugTop
      });
      refresh_user_data(uuid_user);
		}, 500);
  }
  let currentStep = get_steps(contenders);
  if (currentStep){
    document.querySelector(".stepbarcontent").style.display = "block";
    document.querySelector(".stepbar").style.display = "block";
    document.querySelector(".stepbar").style.width = currentStep + "%";
    document.querySelector(".stepbar-content span").innerHTML = currentStep + "%";
  }
  return {
    isNextDuel,
    contender1,
    contender2,
    timelineMain,
    timelineVotes,
    currentStep,
  };
}

async function do_user_ranking(idWinner, idLooser) {
  do_vote(idWinner, idLooser, contenders);
  guessVotesBoolean && addGuessVote();
  return await get_nextDuel(contenders);
}

// KEYUP EVENTS VOTES
window.addEventListener("keyup", function (e) {
  if (e.keyCode === 37 && alreadyVoted === false) {
    document.querySelector("#c_1").click();
    alreadyVoted = true;
  } else if (e.keyCode === 39 && alreadyVoted === false) {
    document.querySelector("#c_2").click();
    alreadyVoted = true;
  }
});

// FIRST DUEL
async function lauch_first_duel(contenders) {
  $(".contender_zone").removeClass(
		"animate__animated animate__zoomIn animate__fadeInUp animate__fadeInDown"
	);

  const firstDuel = await get_nextDuel(contenders);

  const firstDuelContenderOneId = firstDuel.contender1;
  const firstDuelContenderTwoId = firstDuel.contender2;

  const firstDuelContenderOneIdData = contenders.find(
    (item) => item.id_wp === firstDuelContenderOneId
  );
  const firstDuelContenderTwoIdData = contenders.find(
    (item) => item.id_wp === firstDuelContenderTwoId
  );

  document.querySelector("#cover_contender_1").src =
    firstDuelContenderOneIdData.cover;
  document.querySelector("#cover_contender_2").src =
    firstDuelContenderTwoIdData.cover;

  document.querySelector("#c_1").dataset.idwinner =
    firstDuelContenderOneIdData.id_wp;
  document.querySelector("#c_1").dataset.idlooser =
    firstDuelContenderTwoIdData.id_wp;

  document.querySelector("#c_2").dataset.idwinner =
    firstDuelContenderTwoIdData.id_wp;
  document.querySelector("#c_2").dataset.idlooser =
    firstDuelContenderOneIdData.id_wp;

  document.querySelector("#name_contender_1").innerHTML = firstDuelContenderOneIdData.c_name;
  document.querySelector("#name_contender_2").innerHTML = firstDuelContenderTwoIdData.c_name;

  $("#c_1").addClass("animate__animated animate__fadeInDown");
  $("#c_2").addClass("animate__animated animate__fadeInUp");

  // DEALING WITH YOUTUBE VIDEOS
  setTimeout(() => {
    replaceWithYoutubeIframe(firstDuelContenderOneIdData.id_wp, 'contender_1');
    replaceWithYoutubeIframe(firstDuelContenderTwoIdData.id_wp, 'contender_2');
  }, 500);
}

// NEXT DUEL
const contendersDOM = document.querySelectorAll(".link-contender");
contendersDOM.forEach((contender) => {
  contender.addEventListener("click", async function (e) {
    e.preventDefault();

    $("#c_1").removeClass("animate__animated animate__fadeInDown");
    $("#c_2").removeClass("animate__animated animate__fadeInUp");

    const target            = e.target.closest(".contenders_min");
    const contenderIdWinner = target.dataset.idwinner;
    const contenderIdLooser = target.dataset.idlooser;

    // KEURZ ANIMATION
    const notificationXP = document.querySelector('.xp-notification');
    function showXPNotification() {
      notificationXP.style.animation = 'slideToTop 2s forwards';

      setTimeout(() => {
        notificationXP.style.animation = '';
      }, 2000);
    }
    if (notificationXP) showXPNotification();

    if (contenderIdWinner === "" || contenderIdLooser === "") {
			return;
		} else {
      // TWITCH
			if (
				document.querySelector(".display_battle") &&
				localStorage.getItem("twitchGameMode") !== null
			) {
				if (voteParticipatifBoolean) {
          if(!saveTwitchGameInfo) {
            const userData = JSON.parse(localStorage.getItem("user_info"));
            const embed = {
              title: `🟣 LIVE en cours de ${twitchChannel} 🟣`,
              color: 0xA98ED6,
              description: `TopList ${topInfo.top_number} ${getTopIcon(topInfo.top_cat_name)} ${topInfo.top_title} – ${topInfo.top_question}`,
              timestamp: new Date().toISOString(),
              author: {
                  url: `${SITE_BASE_URL}v/${userData.pseudo_slug_user}`,
                  icon_url: userData.avatar_user ? userData.avatar_user : "https://vainkeurz.com/wp-content/uploads/2023/09/avatar-rose.webp",
                  name: userData.pseudo_user,
              },
              fields: [
                { name: "Streamer", value: twitchChannel, inline: true },
                { name: "Mode de jeu", value: "Participatif", inline: true },
                {
                  name: "Participants",
                  value: `👀 ${usersNumberForParticipatifMode}`,
                  inline: true,
                },
                { name: "Type TopList", value: type_top ?? "(Inconnu)", inline: true },
                { name: "Max votes possibles", value: getMaxVotesOfTopList(+topInfo.top_number, type_top) ?? "(Inconnu)", inline: true },
              ],
              url: `https://www.twitch.tv/${twitchChannel}`,
              image: { url: "https://vainkeurz.com/wp-content/uploads/2023/09/gif-mode-game-1-twitch.gif" },
              footer: { text: 'Go Participer Au Live!', icon_url: 'https://vainkeurz.com/wp-content/themes/t-vkrz/assets/images/emojis/twitch.png' }
            };
            const messageToSend = {
                username: "NOTEURZ 🤖",
                avatar_url: 'https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg',
                embeds: [embed],
            };
            // SAVE DATA TO DB…
            fetch(`${API_BASE_URL}twitch/save-game`, {
              method: 'POST',
              body: JSON.stringify({
                id_top: id_top,
                id_toplist: document.querySelector('.confirm_delete').dataset.toplistid,
                uuid_user: uuid_user,
                stream_channel: twitchChannel,
                number_participants: Object.keys(users).length,
                game_mode: 1,
                participants: Object.keys(users),
                webhook: 'twitch-live',
                messageData: messageToSend
              }),
              headers: { 'Content-Type': 'application/json' }
            })
              .then(response => response.json()) 
              .then(data => {
                console.log(data)
                id_twitch_game = data.id_game;
                saveTwitchGameInfo = true;

                // SHOW LINK TO GO
                const tiragaBtnContainer = document.querySelector('.go-to-tirage-vkrz');
                const tiragaBtn          = tiragaBtnContainer.querySelector('.go-to-tirage-vkrz-btn');
                tiragaBtnContainer.classList.remove('d-none');
                tiragaBtn.href = `${TIRAGE_VAINKEUR_URL}?streamChannel=${twitchChannel}`;
                tiragaBtn.addEventListener('click', () => tiragaBtnContainer.classList.add('d-none'));
              })
              .catch((error) => console.error("Error sending message:", error));
          };
          users = {};
					votesNumber.textContent = "0";
					votesNumberForContenderOne = 0;
					votesNumberForContenderTwo = 0;
					contenderOneVotesPercent.textContent = "0%";
					contenderTwoVotesPercent.textContent = "0%";
					X = A = B = 0;
					document.querySelector("#votes-stats-1").classList.remove("active");
					document.querySelector("#votes-stats-2").classList.remove("active");
				} else if (votePredictionBoolean && winnerAlready === false) {
					let side;
					if (target.id === "c_1") side = "1";
					else if (target.id === "c_2") side = "2";

					toFilter = Object.entries(users);
					nonPassed = toFilter.filter(([key, value]) => value.side !== side);
					passed = toFilter.filter(([key, value]) => value.side === side);

					// WINNER CHICKEN DINNER…
					if (passed.length === 1 && winnerAlready === false) {
						winnerAlready = true;
						document
							.querySelector("#prediction-player")
							.classList.add("d-none");
						document
							.querySelector("#prediction-player .card-header")
							.classList.add("flex-column-reverse");
						document.querySelector(
							"#prediction-player .card-header"
						).style.gap = "8px";
						document
							.querySelectorAll(".votes-container > p:first-of-type")
							.forEach((p) => p.remove());
						document
							.querySelector(".contenders-containers")
							.classList.add("blur");
						document.querySelector("#winner-sound").play();
						document.querySelector(".twitchGamesWinnerName").textContent =
							passed[0][0];
						$(".twitchGamesWinnerContainer").addClass("show");
						confetti();

						function rnd(m, n) {
							m = parseInt(m);
							n = parseInt(n);

							return Math.floor(Math.random() * (n - m + 1)) + m;
						}

						function confetti() {
							$.each($(".twitchGamesWinnerName.confetti"), function () {
								var confetticount = ($(this).width() / 50) * 10;
								for (var i = 0; i <= confetticount; i++) {
									$(this).append(
										'<span class="particle c' +
											rnd(1, 4) +
											'" style="top:' +
											rnd(10, 50) +
											"%; left:" +
											rnd(0, 100) +
											"%;width:" +
											rnd(5, 15) +
											"px; height:" +
											rnd(5, 10) +
											"px;animation-delay: " +
											rnd(0, 30) / 10 +
											's;"></span>'
									);
								}
							});
						}

            document.querySelector('.confirm_deletee').addEventListener('click', function(){
              document.querySelector('.confirm_delete').click();
            })

						document
							.querySelector("#winner-continuer")
							.addEventListener("click", () => {
								document
									.querySelector(".contenders-containers")
									.classList.remove("blur");
								document.querySelector(".twitchGamesWinnerContainer").remove();
								document.querySelector("#prediction-player").classList.remove("d-none");
							});

						// SAVE TO LOCAL STORAGE…
						const twitchGameResumeObj = {
							idRanking: id_toplist_contenders_ajax,
							participantsNumber: `${Object.keys(users).length + Object.keys(losers).length}`,
							mode: "votePrediction",
							winner: `${passed[0][0]}`,
						};
						localStorage.setItem("resumeTwitchGame", JSON.stringify(twitchGameResumeObj));

            // Send data to the server
            fetch(`${API_BASE_URL}twitch/winner-game`, {
              method: 'POST',
              body: JSON.stringify({
                id_twitch_game: id_twitch_game,
                winner: passed[0][0],
                stream_channel: twitchChannel
              }),
              headers: {
                'Content-Type': 'application/json',
              }
            })
              .then(response => response.json())
              .then(data => {
                console.log(data);
              })
              .catch((error) => console.error("Error updating winner:", error));
					}

					for (let user of toFilter) {
						user[1]["voted"] = false;
						user[1]["side"] = "0";
						document
              .querySelector(`#prediction-player [id="vkrz-${user[0]}"]`)
							.classList.remove("text-primary");
					}

					if (passed.length === 0) {
						users = Object.fromEntries(nonPassed);
					} else {
						users = Object.fromEntries(passed);
						losers = { ...losers, ...Object.fromEntries(nonPassed) };

						// PROCESS FOR LOSERS…
						if (nonPassed.length > 0) {
							const elimines = document.querySelector(
								"#participants .card-title.elimines"
							);
							elimines.classList.remove("d-none");
							elimines.innerHTML = `<span class="va va-unknow va-lg"></span> ${
								Object.keys(losers).length
							} ${Object.keys(losers).length > 1 ? "Eliminés" : "Eliminé"}`;

							for (const [key, loser] of Object.entries(nonPassed)) {
								let target = document.querySelector( `#prediction-player [id='vkrz-${loser[0]}']`);
								target.classList.remove("text-primary");
								target.classList.add("beforeDelete");
								setTimeout(() => {
									target.remove();
								}, 4000);
							}
						}
					}

					if (Object.keys(users).length === 1 || winnerAlready === true) {
						document.querySelector("#participants .card-title").innerHTML =
							"<i class='fab fa-twitch'></i> Le gagnant!! 🎉";
					} else if (Object.keys(users).length > 1) {
						preditcionParticipantsVotedNumber.textContent = 0;
						preditcionParticipantsNumber.textContent =
							Object.keys(users).length;
					} else if (Object.keys(users).length === 0) {
						document.querySelector("#participants .card-title").innerHTML =
							"<i class='fab fa-twitch'></i> 0 Participants";
					}
				} else if (votePointsBoolean) {
					let side;
					if (target.id === "c_1") side = "1";
					else if (target.id === "c_2") side = "2";

					toFilter = Object.entries(users);

					let oppositeSide = side === "1" ? "2" : "1";
					notSameVoteGroup = toFilter.filter(
						([key, value]) => value.side === oppositeSide
					);
					notSameVoteGroupObj = Object.fromEntries(notSameVoteGroup);

					sameVoteGroup = toFilter.filter(
						([key, value]) => value.side === side
					);
					sameVoteGroupObj = Object.fromEntries(sameVoteGroup);

					for (const vainkeurPlusOne of Object.keys(sameVoteGroupObj)) {
						const vainkeurPlusOneDOM = document.querySelector(
								`#ranking-player [id="vkrz-${vainkeurPlusOne}"]`
							),
							vainkeurPlusOneDOMpoints =
								vainkeurPlusOneDOM.querySelector("td:last-of-type");

						vainkeurPlusOneDOMpoints.innerHTML = `${
							+vainkeurPlusOneDOMpoints.dataset.order + 1
						} &uarr;`;
						vainkeurPlusOneDOMpoints.classList.add("text-success");
						vainkeurPlusOneDOMpoints.setAttribute(
							"data-order",
							`${+vainkeurPlusOneDOMpoints.dataset.order + 1}`
						);
					}

					if (notSameVoteGroup.length > 0) {
						for (let vainkeurMinusOne of Object.keys(notSameVoteGroupObj)) {
							const vainkeurMinusOneDOM = document.querySelector(
									`#ranking-player [id="vkrz-${vainkeurMinusOne}"]`
								),
								vainkeurMinusOneDOMpoints =
									vainkeurMinusOneDOM.querySelector("td:last-of-type");

							vainkeurMinusOneDOMpoints.innerHTML =
								vainkeurMinusOneDOMpoints.dataset.order;
							vainkeurMinusOneDOMpoints.classList.remove("text-success");
							vainkeurMinusOneDOMpoints.setAttribute(
								"data-order",
								vainkeurMinusOneDOMpoints.dataset.order
							);
						}
					}

					if (Object.keys(users).length) {
						const initTable = (function () {
							let table = $(".table-points").dataTable();
							table.fnDestroy();

							table.dataTable({
								autoWidth: true,
								paging: false,
								searching: false,
								order: [[2, "desc"]],
							});

							positionStr = "";
							document
								.querySelector(".table-points tbody")
								.querySelectorAll("tr")
								.forEach((row, index) => {
									switch (index) {
										case 0:
											positionStr =
												'<span class="ico va va-medal-1 va-lg"></span>';
											break;
										case 1:
											positionStr =
												'<span class="ico va va-medal-2 va-lg"></span>';
											break;
										case 2:
											positionStr =
												'<span class="ico va va-medal-3 va-lg"></span>';
											break;
										default:
											positionStr = index + 1;
									}

									row.querySelector("td:first-of-type").innerHTML = positionStr;
									row
										.querySelector("td:nth-of-type(2)")
										.classList.remove("voted");
								});
						})();
					}

					pointsParticipantsVotedNumber.textContent = 0;

					for (let user in users) users[user] = { side: "0", voted: false };
				}
			}

			if (target.id === "c_1") {
				$("#c_1").addClass("vainkeurz animate__animated animate__shakeY");
				$("#c_2").addClass("animate__animated animate__backOutRight");
			} else if (target.id === "c_2") {
				$("#c_2").addClass("vainkeurz animate__animated animate__shakeY");
				$("#c_1").addClass("animate__animated animate__backOutLeft");
			}

			setTimeout(async () => {
				$(".contender_zone").removeClass("vainkeurz animate__animated animate__zoomIn animate__fadeInUp animate__fadeInDown animate__shakeY animate__backOutLeft animate__backOutRight");

				const duel = await do_user_ranking(contenderIdWinner, contenderIdLooser);
        
				if (!duel.isNextDuel) return;

				const firstDuelContenderOneId = duel.contender1;
				const firstDuelContenderTwoId = duel.contender2;

				const firstDuelContenderOneIdData = contenders.find(
					(item) => item.id_wp === firstDuelContenderOneId
				);
				const firstDuelContenderTwoIdData = contenders.find(
					(item) => item.id_wp === firstDuelContenderTwoId
				);

				document.querySelector("#cover_contender_1").src =
					firstDuelContenderOneIdData.cover;
				document.querySelector("#cover_contender_2").src =
					firstDuelContenderTwoIdData.cover;

				document.querySelector("#c_1").dataset.idwinner =
					firstDuelContenderOneIdData.id_wp;
				document.querySelector("#c_1").dataset.idlooser =
					firstDuelContenderTwoIdData.id_wp;

				document.querySelector("#c_2").dataset.idwinner =
					firstDuelContenderTwoIdData.id_wp;
				document.querySelector("#c_2").dataset.idlooser =
					firstDuelContenderOneIdData.id_wp;

        document.querySelector("#name_contender_1").innerHTML = firstDuelContenderOneIdData.c_name;
        document.querySelector("#name_contender_2").innerHTML = firstDuelContenderTwoIdData.c_name;

				$("#c_1").addClass("animate__animated animate__fadeInDown");
				$("#c_2").addClass("animate__animated animate__fadeInUp");

        // DEALING WITH YOUTUBE VIDEOS
        setTimeout(() => {
          if (duel.isNextDuel) {
              replaceWithYoutubeIframe(duel.contender1, 'contender_1');
              replaceWithYoutubeIframe(duel.contender2, 'contender_2');
          }
        }, 500);

				alreadyVoted = false;
			}, 500);
		}
  });
});