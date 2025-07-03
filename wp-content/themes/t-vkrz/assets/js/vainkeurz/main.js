$.fn.equalHeights = function () {
  var max_height = 0;
  $(this).each(function () {
    max_height = Math.max($(this).height(), max_height);
  });
  $(this).each(function () {
    $(this).height(max_height);
  });
};

$(window).scroll(function () {
  var scroll = $(window).scrollTop();

  if (scroll > 10) {
    $(".intro-mobile").addClass("opfull");
    $(".menu-user").addClass("opfull");
  } else {
    $(".intro-mobile").addClass("opfull");
    $(".menu-user").removeClass("opfull");
  }

  if (scroll > 60) {
    $(".menu-user").addClass("menuvkrzmobilehide");
  } else {
    $(".menu-user").removeClass("menuvkrzmobilehide");
  }
});

jQuery(document).ready(function ($) {
	$(".eh").equalHeights();
	$(".ehcard").equalHeights();
	$(".eh1").equalHeights();
	$(".eh2").equalHeights();
	$(".eh3").equalHeights();
	$(".ico-master").equalHeights();
	$(".same-h").equalHeights();
	$(".same-h2").equalHeights();
	$(".agagner-equal-height").equalHeights();

	//init slick
	$('.kl-slick').on('init', function(event, slick){
		$(this).closest('.kl-wrapper-slick').removeClass('kl-hidden-slick');
	});

	$(".slick-carousel").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots"),
		nextArrow: $(".vk-next"),
		prevArrow: $(".vk-prev"),
		swipe: true,
		draggable: true,
	});
	$(".slick-carousel-cat1").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat1"),
		nextArrow: $(".vk-next-cat1"),
		prevArrow: $(".vk-prev-cat1"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat2").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat2"),
		nextArrow: $(".vk-next-cat2"),
		prevArrow: $(".vk-prev-cat2"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat3").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat3"),
		nextArrow: $(".vk-next-cat3"),
		prevArrow: $(".vk-prev-cat3"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat4").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat4"),
		nextArrow: $(".vk-next-cat4"),
		prevArrow: $(".vk-prev-cat4"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat5").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat5"),
		nextArrow: $(".vk-next-cat5"),
		prevArrow: $(".vk-prev-cat5"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat6").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat6"),
		nextArrow: $(".vk-next-cat6"),
		prevArrow: $(".vk-prev-cat6"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat7").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat7"),
		nextArrow: $(".vk-next-cat7"),
		prevArrow: $(".vk-prev-cat7"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat8").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat8"),
		nextArrow: $(".vk-next-cat8"),
		prevArrow: $(".vk-prev-cat8"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat9").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat9"),
		nextArrow: $(".vk-next-cat9"),
		prevArrow: $(".vk-prev-cat9"),
		swipe: true,
  	draggable: true,
	});
  $(".slick-carousel-cat-special").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: false,
		appendDots: $(".slick-nav-dots-cat-special"),
		nextArrow: $(".vk-next-cat-special"),
		prevArrow: $(".vk-prev-cat-special"),
		swipe: true,
		draggable: true,
	});
	
	$(".actu-caroussel").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: false,
		nextArrow: $(".vk-next-new"),
		prevArrow: $(".vk-prev-new"),
		swipe: true,
  	draggable: true,
	});

	var checkExist = setInterval(function () {
    if ($(".eh").length) {
      $(".eh").equalHeights();
      clearInterval(checkExist);
    }
  }, 100);

	if (document.querySelector(".popup-overlay")) {
		const popUps = document.querySelectorAll(".popup-overlay");

		const dealClosePopUp = function (popUp) {
			let copyLinkTopList = popUp.querySelector(".sharelinkbtn .fa-link");
			let copyLinkTop = popUp.querySelector(".sharelinkbtn2 .fa-link");
			let closeButtons = Array.from(
				popUp.querySelectorAll(".close-popup, #close-popup")
			);

			document.addEventListener("click", (e) => {
				if (
					e.target.closest(".popup") !== popUp.querySelector(".popup") ||
					closeButtons.includes(e.target)
				) {
					if (
						e.target !== copyLinkTopList &&
						e.target !== copyLinkTop &&
						closeButtons.includes(e.target)
					) {
						popUp.classList.add("d-none");
					}
				}
			});

			document.addEventListener("keydown", function (e) {
				if (e.key === "Escape") {
					popUp.classList.add("d-none");
				}
			});
		};

		popUps.forEach((popUp) => {
			if (
				!popUp.classList.contains("d-none") ||
				popUp.querySelector(".finish-participate-popup")
			) {
				dealClosePopUp(popUp);
			}
		});

		// TOP SPONSO POPUP SLIDE DOTS
		if (document.querySelector(".popup-dots")) {
			const dots = document.querySelectorAll(".dot");
			const slideOne = document.querySelector(".popup-slide-1");
			const slideTwo = document.querySelector(".popup-slide-2");
			const retourBtn = document.querySelector(".popup-retour");

			dots.forEach((dot) => {
				dot.addEventListener("click", function () {
					if (!dot.classList.contains("active")) {
						dots.forEach((dot) => dot.classList.remove("active"));
						dot.classList.add("active");

						if (dot.dataset.slide === "2") {
							slideOne.classList.add("slide-left");
							slideTwo.classList.remove("slide-right");

							retourBtn.classList.remove("invisible");
							retourBtn.addEventListener("click", () => {
								dots.forEach((dot) => dot.classList.remove("active"));
								dots[0].classList.add("active");

								retourBtn.classList.add("invisible");
								slideOne.classList.remove("slide-left");
								setTimeout(() => slideTwo.classList.add("slide-right"), 100);
							});
						} else {
							retourBtn.classList.add("invisible");
							slideOne.classList.remove("slide-left");
							setTimeout(() => slideTwo.classList.add("slide-right"), 100);
						}
					}
				});
			});
		}
	}

	const popUps = document.querySelectorAll(".popup-overlay");
	const closeButtons = Array.from(
		document.querySelectorAll(".close-popup, #close-popup")
	);
	closeButtons.forEach((closeButton) => {
		closeButton.addEventListener("click", () => {
			const popUp = closeButton.closest(".popup-overlay");
			if (popUp) {
				popUp.classList.add("d-none");
			}
		});
	});

	let url 						= new URL(window.location.href);
	let utm_campaign 		= url.searchParams.get("utm_campaign");
	let code_invitation = url.searchParams.get("code_invitation");
	if (utm_campaign !== null) 
		localStorage.setItem("utm_campaign", utm_campaign);
	if (code_invitation !== null)
		localStorage.setItem("code_invitation", code_invitation);

	checkMobileToSlickify();
});

$(window).on("resize orientationchange", function () {
	checkMobileToSlickify();
});

function checkMobileToSlickify() {
	if (window.matchMedia("(min-width: 992px)").matches) {
    destroySlickTopList();
	} else {
		slickifyTopList();
	}
}

function slickifyTopList() {
  $(".toplist-amis")
    .not(".slick-initialized")
    .slick({
      arrows: true,
      infinite: true,
      slidesToShow: 1,
			slidesToScroll: 1,
			dots: true,
			autoplay: false,
			appendDots: $(".toplist-amis-slick-nav-dots"),
      prevArrow: $(".toplist-amis-prev"),
      nextArrow: $(".toplist-amis-next"),
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1,
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
					}
				},
			]
    });
}

function destroySlickTopList() {
  $(".toplist-amis").filter(".slick-initialized").slick("unslick");
}

/* ------------------------------ SEARCH -------------------------------- */
let prefetUsers = null;
let prefetContent = null;

// Initialize Bloodhound for Users
function initializePrefetUsers() {
	if (!prefetUsers) {
		prefetUsers = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: `${API_BASE_URL}user-list/get-all-pseudo`,
		});
		prefetUsers.initialize();
		// Attach Typeahead after initialization
		$(".searchmembres")
			.typeahead(
				{
					highlight: true,
					minLength: 3,
				},
				{
					name: "result",
					source: prefetUsers,
				}
			)
			.on("typeahead:select", function (ev, suggestion) {
				$(".searchmembres").val(suggestion);
				$(".searchform").submit();
			});
	}
}

// Initialize Bloodhound for Content
function initializePrefetContent() {
	if (!prefetContent) {
		prefetContent = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: `${SITE_BASE_URL}wp-json/v1/getcontent?_ecl=600`,
		});
		prefetContent.initialize();
		// Attach Typeahead after initialization
		$(".searchtops")
			.typeahead(
				{
					highlight: true,
					minLength: 3,
				},
				{
					name: "result",
					source: prefetContent,
				}
			)
			.on("typeahead:select", function (ev, suggestion) {
				$(".searchtops").val(suggestion);
				$(".searchform").submit();
			});
	}
}

$(".searchtops").on("click", function () {
	initializePrefetContent();
  $(".searchtops").focus();
});

// Handle Type Search Toggle
$(".typesearch").change(function () {
	const typesearch = $(this).val();
	if (typesearch === "Membres") {
		$(".searchtops").hide();
		$(".searchmembres").show();
		initializePrefetUsers(); // Initialize if not already done
		$(".searchmembres").focus(); // Focus on the search field
	} else {
		$(".searchmembres").hide();
		$(".searchtops").show();
		initializePrefetContent(); // Initialize if not already done
		$(".searchtops").focus(); // Focus on the search field
	}
});

// Show and Hide Search Modal
$(".opensearch").on("click", function () {
	$("#waiter-recherche").fadeIn();
});
$(".fermerrecherche").on("click", function () {
	$("#waiter-recherche").fadeOut();
});
/* ------------------------------ FIN SEARCH -------------------------------- */


/* ------------------------------ MODALS -------------------------------- */
if (document.querySelector(".modal")) {
  document.querySelectorAll(".modal").forEach(function (modal) {
    
    modal.addEventListener("show.bs.modal", function (e) {
      let modal = e.currentTarget;
      let iframe = modal.querySelector("iframe");
        
      if (iframe && iframe.src.indexOf('youtube.com') > -1 && iframe.src.indexOf('autoplay=1') === -1) {
        iframe.src += (iframe.src.indexOf('?') > -1 ? '&' : '?') + 'autoplay=1';
      }
    });

    modal.addEventListener("hidden.bs.modal", function (e) {
      let modal = e.currentTarget;
      let iframe = modal.querySelector("iframe");
      if(iframe) {
        // Save the src in a data attribute to restore it later
        iframe.dataset.src = iframe.src;
        // Remove the src to stop the video
        iframe.removeAttribute('src');
      }
    });

    modal.addEventListener("show.bs.modal", function (e) {
      let modal = e.currentTarget;
      let iframe = modal.querySelector("iframe");
      if(iframe && iframe.dataset.src) {
        // Restore the original src from the data attribute
        iframe.src = iframe.dataset.src;
      }
    });

  });
}

document.addEventListener("DOMContentLoaded", function (e) {

	const user_infos = JSON.parse(localStorage.getItem("user_info"));
	let avatarBox = document.getElementById("uploadedAvatar");
	const avatarInput = document.querySelector(".account-file-input"),
		avatarReset = document.querySelector(".account-image-reset");
	if (avatarBox) {
		avatarInput.onchange = () => {
			if (avatarInput.files[0]) {
				avatarBox.style.backgroundImage =
					"url('" + window.URL.createObjectURL(avatarInput.files[0]) + "')";
			}
		};
		avatarReset.onclick = () => {
			avatarInput.value = "";
			avatarBox.src = avatarBox.style.backgroundImage =
				"url('" + user_infos.avatar_user + "')";
		};
	}

	let coverBox = document.getElementById("uploadedCover");
	const coverInput = document.querySelector(".account-cover-input"),
		coverReset = document.querySelector(".account-cover-reset");
	if (coverBox) {
		coverInput.onchange = () => {
			if (coverInput.files[0]) {
				coverBox.style.backgroundImage =
					"url('" + window.URL.createObjectURL(coverInput.files[0]) + "')";
			}
		};
		coverReset.onclick = () => {
			coverInput.value = "";
			coverBox.src = coverBox.style.backgroundImage =
				"url('" + user_infos.cover_user + "')";
		};
	}

	var copyBtns = document.querySelectorAll(".sharelinkbtn");
	copyBtns.forEach((copyBtn) => {
		copyBtn.addEventListener("click", function (event) {
			var copyInputs = copyBtn.querySelectorAll(".input_to_share");

			copyInputs.forEach((copyInput) => {
				copyInput.focus();
				copyInput.select();
				try {
					var successful = document.execCommand("copy");
					var msg = successful ? "successful" : "unsuccessful";
					copyBtn.innerHTML = "Copié ✅";
				} catch (err) {
					console.log("Oops, impossible de copier - Demandes pas pourquoi :/");
				}
			});
		});
	});

	var copyBtns2 = document.querySelectorAll(".sharelinkbtn2");
	copyBtns2.forEach((copyBtn) => {
		copyBtn.addEventListener("click", function (event) {
			var copyInputs = copyBtn.querySelectorAll(".input_to_share2");

			copyInputs.forEach((copyInput) => {
				copyInput.focus();
				copyInput.select();
				try {
					var successful = document.execCommand("copy");
					var msg = successful ? "successful" : "unsuccessful";
					copyBtn.innerHTML = "Copié ✅";
				} catch (err) {
					console.log("Oops, impossible de copier - Demandes pas pourquoi :/");
				}
			});
		});
	});

	if (document.querySelector("#copyReferralLink")) {
		const buttons = document.querySelectorAll("#copyReferralLink");

		buttons.forEach((button) =>
			button.addEventListener("click", function (e) {
				e.preventDefault();
				const copy = (text) => navigator.clipboard.writeText(text);
				copy(button.getAttribute("href"));
				button.querySelector("p:first-of-type").innerHTML = "Bien copié !";
			})
		);
	}

  var tournoiSponsoMin = document.querySelectorAll(".t-min-sponso");
  if (tournoiSponsoMin) {
		tournoiSponsoMin.forEach(function (el) {
			var color = el.getAttribute("data-color");
			var h5 = el.querySelector("h5");
			if (h5) {
				h5.style.color = color;
			}
			var titrewin = el.querySelector(".titrewin");
			if (titrewin) {
				titrewin.style.backgroundColor = color;
			}
			var titrewin = el.querySelector(".cta-participer");
			if (titrewin) {
				titrewin.style.backgroundColor = color;
			}
		});
	}

	function setupCopyButtons() {
    const buttons = document.querySelectorAll('.copy-button');

			buttons.forEach(button => {
					button.addEventListener('click', function() {
							const link 						= this.getAttribute('data-link');
							const textToShowAfter = this.getAttribute('data-textafter');
							navigator.clipboard.writeText(link).then(() => {
									this.innerHTML = textToShowAfter;
							}).catch(err => {
									console.error('Error in copying text: ', err);
							});
					});
			});
	}
	setupCopyButtons();

	if(document.querySelector('.menuuser-bell')) {
		const bell = document.querySelector('.menuuser-bell');

		bell.addEventListener('click', async () => {

			await fetchDataFuncHelper(`${API_BASE_URL}notification-list/getnew/${uuid_user}`)
			.then(async results => {
				const notificationsContainer = document.querySelector(".notifications-container");
				if(results.success) {
					const notificationsList = results.data;
					if(notificationsList.length > 0) {
						document.querySelectorAll(".notifications-nombre").forEach((nombre) => nombre.textContent = notificationsList.length );
						document.querySelector(".notifications-span").textContent = notificationsList.length <= 1 ? "Nouvelle" : "Nouvelles";
						document.querySelector('.badge-notifications').classList.remove('d-none');
						let html = "";
	
						// REMOVE DUPLICATE UUIDs FROM ARRAY…
						let notificationsUsersUuids = [];
						notificationsList.forEach((notification) => notificationsUsersUuids.push(notification.uuid_sender));
						let set = new Set(notificationsUsersUuids.map((notificationUserUuid) => JSON.stringify(notificationUserUuid)));
						notificationsUsersUuids = Array.from(set).map((elem) => JSON.parse(elem));
	
						// GET USERS DATA FIRST…
						const map = new Map();
						await Promise.all(
							notificationsUsersUuids.map(async (uuid) => {
								await getUserInfos(uuid)
									.then((data) => { map.set(data.data_user.uuid_user, data) });
							})
						);
	
						notificationsList.forEach((notification) => {
							let avatarImg         = "https://vainkeurz.com/wp-content/uploads/2024/11/avatar-rose.png";
							if(map.get(notification.uuid_sender) && map.get(notification.uuid_sender).infos_user.avatar_user) {
								avatarImg = map.get(notification.uuid_sender).infos_user.avatar_user;
							}
							const currentDate       = new Date();
							const specificDate      = new Date(notification.date);
							const durationInSeconds = Math.floor((currentDate.getTime() - specificDate.getTime()) / 1000);
							const durationString    = Math.abs(durationInSeconds);
							const duration          = secondsToStrFuncHelper(durationString);
	
							// User pseudo
							let userPseudo = '';
							let pseudoFound = false;
							if (map.get(notification.uuid_sender)) {
									userPseudo = map.get(notification.uuid_sender).infos_user.pseudo_user;
							}
	
							/*
							let notificationTextWithLink = notification.notification_text;
							if (userPseudo && !(notification.notification_url).includes("keurz")) {
									const pseudoEscaped = userPseudo.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'); // Escape special characters
									const pseudoRegex = new RegExp(pseudoEscaped, 'g'); // Create a global regex
									const pseudoLink = `<a href="${SITE_BASE_URL}v/${map.get(notification.uuid_sender).infos_user.pseudo_slug_user}">${userPseudo}</a>`;
									if (notificationTextWithLink.search(pseudoRegex) !== -1) {
											notificationTextWithLink = notificationTextWithLink.replace(pseudoRegex, pseudoLink);
											pseudoFound = true;
									}
							}
	
							// If pseudo not found, wrap entire text. Otherwise, wrap from 'TopList' to end.
							if (!pseudoFound) {
									notificationTextWithLink = `<a href="${notification.notification_url}">${notificationTextWithLink}</a>`;
							} else {
									const toplistIndex = notificationTextWithLink.indexOf('TopList');
									if (toplistIndex !== -1) {
											const beforeTopList = notificationTextWithLink.substring(0, toplistIndex);
											const fromTopListToEnd = notificationTextWithLink.substring(toplistIndex);
											const toplistLink = `<a href="${notification.notification_url}">${fromTopListToEnd}</a>`;
											notificationTextWithLink = beforeTopList + toplistLink;
									}
							}
              */

              notificationTextWithLink = `<a href="${notification.notification_url}">${notification.notification_text}</a>`;
	
							html += `
								<div 
									class="d-flex" 
									id="readNotification" 
									data-id="${notification.id}"
								>
									<div class="media d-flex align-items-start">
										<div class="media-left">
											<div class="avatar">                  
												<span class="avatar-picture" style="background-image: url(${avatarImg});"></span>
											</div>
										</div>
	
										<div class="media-body">
											<p class="media-heading mb-0">
												<span class="font-weight-bolder">
													${notificationTextWithLink}
												</span>
												<small class="notification-text">Il y a ${duration}</small>
											</p>
										</div>
									</div>
								</div>
							`;
						});
						notificationsContainer.innerHTML = html;
	
						// PROCESS TO UPDATE STATUT… 🎺
						const buttons = document.querySelectorAll("#readNotification");
						buttons.forEach((button) => {
							button.addEventListener("click", async function () {
								let id = button.dataset.id;
	
								await fetch(`${API_BASE_URL}notification-list/update/${id}`, {
									method: "PUT",
									headers: { "Content-Type": "application/json", },
								})
									.then((response) => response.json())
									.then((data) => console.log(data) );
							});
						});
					}
				}
			});
			
		})
	}

	if(document.querySelector('#bandeau')) {
		firebase.auth().onAuthStateChanged((user) => {
			if (user) {
				if (!localStorage.getItem('bandeauClicked')) {
						const bandeau = document.getElementById('bandeau');
						bandeau.classList.remove('d-none');
						
						// Close bandeau when the close button is clicked
						document.getElementById('close-bandeau').addEventListener('click', () => {
								bandeau.classList.add('d-none');
								localStorage.setItem('bandeauClicked', 'true');
						});

						// Close bandeau when the bandeau itself is clicked
						bandeau.addEventListener('click', () => {
								bandeau.classList.add('d-none');
								localStorage.setItem('bandeauClicked', 'true');
						});
				}
			}
		});
	}
});

function initializeTooltips() {
	var tooltipTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="tooltip"]')
	);
	tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});
}

async function fetchTopsGestionData() {
	const endpoint = `${SITE_BASE_URL}wp-json/v1/getalltopsdata/`;

	return fetch(endpoint)
		.then((response) => response.json())
		.then((data) => {
			// grab elements
			const topvalideEl = document.querySelector("#top_valide");
			const topvalidationEl = document.querySelector("#top_validation");
			const topcreationEl = document.querySelector("#top_creation");
			const toprefuseEl = document.querySelector("#top_refuse");
			const toparchiveEl = document.querySelector("#top_archive");

			// Update the elements with data from the endpoint
			topvalideEl.textContent = data.top_valide;
			topvalidationEl.textContent = data.top_validation;
			topcreationEl.textContent = data.top_creation;
			toprefuseEl.textContent = data.top_refuse;
      toparchiveEl.textContent = data.top_archive;
		})
		.catch((error) => {
			console.error("There was an error fetching the tops data:", error);
		});
}
if (document.getElementById("menu-gestionnaire")) {
	fetchTopsGestionData();
}

function getTopStatus(topInfo) {
	const statuses = {
		valide: { wording: "Actif", state: "success" },
		validation: { wording: "Validation", state: "warning" },
		creation: { wording: "En création", state: "info" },
		refuse: { wording: "Refusé", state: "danger" },
	};

	return statuses[topInfo.top_state] || { wording: "", state: "" };
} 

function getTopType(topInfo) {
	const types = {
		sponso: { wording: "Sponso", state: "dark" },
		private: { wording: "Privé", state: "secondary" },
		classik: { wording: "Classik", state: "primary" },
	};

	return types[topInfo.top_type] || { wording: "", state: "" };
}

function getCreatorContent(topInfo) {
	if (topInfo.creator_infos && topInfo.creator_infos.infos_user) {
		const creatorLink = `${SITE_BASE_URL}v/${topInfo.creator_infos.infos_user.pseudo_slug_user}`;
		const creatorName = topInfo.creator_infos.infos_user.pseudo_user;
		return `
      <a href="${creatorLink}" class="btn btn-flat-primary waves-effect avatarbloc" data-creatoruuid="${topInfo.creator_infos.infos_user.uuid_user}">
        <span class="avatar">
          <span class="avatar-picture" style="background-image: url(${topInfo.creator_infos.infos_user.avatar_user});"></span>
        </span>
        <span class="championname scale08">
          <small class="text-muted">Créé par</small>
          <div class="creatornametopmin">
            <h4>${creatorName}</h4>
          </div>
        </span>
      </a>
    `;
	}
  else{
   return "<span>No creator found</span>"; 
  }
}

function getUserContent(data) {
	if (data.infos_user) {
		const creatorLink = `${SITE_BASE_URL}v/${data.infos_user.pseudo_slug_user}`;
		const creatorName = data.infos_user.pseudo_user;
		return `
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
    `;
	}
  else{
   return "<span>No creator found</span>"; 
  }
}

function listingTop(endpoint, renderDOM) {
	fetch(endpoint)
		.then((response) => response.json())
		.then((data) => {
			let rows = "";
			const listTopCreated = data.list_creator_tops;

			listTopCreated.forEach((topInfo) => {

        fetch(`${API_BASE_URL}message-list/getfromtop`, {
					method: "POST",
					headers: { "Content-Type": "application/json", },
					body: JSON.stringify({ id_top: topInfo.top_id, }),
				})
        .then((response) => response.json())
        .then((data) => {
          // Find the .nb-message-info element within the current row
          const messageButton = document.querySelector(
            `#idtop-${topInfo.top_id} .nb-message-info`
          );
          if (messageButton) {
            messageButton.textContent = data.nb_message;
          }
        })
        .catch((error) => {
          console.error("Error fetching message count:", error);
        });
        
				const status = getTopStatus(topInfo);
				const statusBadge = `<span class="badge bg-label-${status.state}">${status.wording}</span>`;

				const type = getTopType(topInfo);
				const typeBadge = `<span class="badge bg-label-${type.state}">${type.wording}</span>`;

        let creatorContent = "<span>No creator found</span>";

        if(topInfo.creator_infos){
          creatorContent = getUserContent(topInfo.creator_infos);
        }

				const badgeTypeSelector = `#top_${topInfo.top_type}_nb`;
				const badgeTypeElem = document.querySelector(badgeTypeSelector);
				if (badgeTypeElem) {
					badgeTypeElem.textContent =
						parseInt(badgeTypeElem.textContent, 10) + 1;
				}

				const linkEditorWP = `${SITE_BASE_URL}wp-admin/post.php?post=${topInfo.top_id}&action=edit`;

				let validateButton =
					topInfo.top_state !== "valide"
						? `<button class="btn btn-icon btn-label-primary waves-effect validetop" data-idtop="${topInfo.top_id}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Valider le Top">
              <span class="va va-check va-lg"></span>
            </button>`
						: "";

				let refuseButton =
					topInfo.top_state !== "refuse"
						? `<button class="btn btn-icon btn-label-primary waves-effect refusetop" data-idtop="${topInfo.top_id}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refuser le Top">
                <span class="va va-pouce-down va-lg"></span>
              </button>`
						: "";

				let archiveButton =
					topInfo.top_state !== "archive"
						? `<button class="btn btn-icon btn-label-primary waves-effect archivetop" data-idtop="${topInfo.top_id}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Archiver le Top">
              <span class="va va-folder-empty va-lg"></span>
            </button>`
						: "";

				rows += `
          <tr class="listingtopcreated" id="idtop-${topInfo.top_id}">
            <td style="width: 33%;" class="signal">
              <a href="${topInfo.top_url}" class="top-card">
                  <div class="d-flex align-items-center">
                      <div class="avatar d-none d-sm-block" style="border-radius: unset!important;">
                          <span class="avatar-picture avatar-top" style="background-image: url(${topInfo.top_img_min});"></span>
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
            </td>

            <td class="text-left">
              ${statusBadge}
            </td>

            <td class="text-left">
              ${typeBadge}
            </td>

            <td class="text-left">
              ${topInfo.top_date}
            </td>

            <td class="creatorbloc">
              ${creatorContent}
            </td>

            <td class="text-center d-none">
              <a href="${topInfo.url_tm}#commentaires" class="btn btn-icon btn-label-primary waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Voir les commentaires">
                ${topInfo.nb_comments}
              </a>
            </td>
            
            <td class="text-center">
              <div data-idtop="${topInfo.top_id}" data-topname="TopList ${topInfo.top_number} ${getCategoryIcon(topInfo.top_cat_name)} ${topInfo.top_title} – ${topInfo.top_question}" data-uuid_user="${uuid_user}" data-bs-toggle="offcanvas" data-bs-target="#messages" aria-controls="offcanvasScroll" class="boxmessageBtn">
                <a href="#" class="nb-message-info btn btn-icon btn-label-primary waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Envoyer un message">
                  0
                </a>
              </div>
            </td>

            <td class="text-right">
              <div class="d-flex align-items-center justify-content-end col-actions">
                <a class="btn btn-icon btn-label-primary waves-effect" href="${linkEditorWP}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Voir dans WP" target="_blank">
                  <span class="va va-monocle va-lg"></span>
                </a>
                ${validateButton}
                <a class="btn btn-icon btn-label-primary waves-effect" href="${SITE_BASE_URL}/creation/edition-du-top/?id_top=${topInfo.top_id}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Modifier le Top">
                  <span class="va va-pencil va-lg"></span>
                </a>
              </div>
              <div class="d-flex align-items-center justify-content-end col-actions mt-1">
                ${refuseButton}
                ${archiveButton}
                <button class="btn btn-icon btn-label-primary waves-effect deletetop" data-idtop="${topInfo.top_id}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Détruire le Top et ses contenders">
                  <span class="va va-dynamite va-lg"></span>
                </button>
              </div>
            </td>
            
          </tr>`;
			});

			renderDOM.innerHTML = rows;

			document.querySelectorAll(".validetop").forEach((item) => {
				item.addEventListener("click", (event) => {
					event.preventDefault();

					var tooltipInstance = bootstrap.Tooltip.getInstance(item);
					if (tooltipInstance) {
						tooltipInstance.hide();
					}

					var idTop = event.currentTarget.dataset.idtop;
					document.getElementById("idtop-" + idTop).style.opacity = "0.2";
					document
						.getElementById("idtop-" + idTop)
						.classList.add("top-valide-tr");

					fetch(SITE_BASE_URL + "/wp-json/v1/validetop/" + idTop + "/" + uuid_user, {
						method: "GET",
					})
						.then((response) => response.json())
						.then(async (response) => {
							console.log("Success:", response);
							document.getElementById("idtop-" + idTop).remove();
							await fetchTopsGestionData();
						})
						.catch((error) => {
							console.log("Error:", error);
						});
				});
			});
			document.querySelectorAll(".refusetop").forEach((item) => {
				item.addEventListener("click", (event) => {
					event.preventDefault();

					var tooltipInstance = bootstrap.Tooltip.getInstance(item);
					if (tooltipInstance) {
						tooltipInstance.hide();
					}

					var idTop = event.currentTarget.dataset.idtop;
					document.getElementById("idtop-" + idTop).style.opacity = "0.2";
					document
						.getElementById("idtop-" + idTop)
						.classList.add("top-refuse-tr");
					fetch(SITE_BASE_URL + "/wp-json/v1/refusetop/" + idTop + "/" + uuid_user, {
						method: "GET",
					})
						.then((response) => response.json())
						.then(async (response) => {
							console.log("Success:", response);
							document.getElementById("idtop-" + idTop).remove();
							await fetchTopsGestionData();
						})
						.catch((error) => {
							console.log("Error:", error);
						});
				});
			});
			document.querySelectorAll(".deletetop").forEach((item) => {
				item.addEventListener("click", (event) => {
					event.preventDefault();
					var tooltipInstance = bootstrap.Tooltip.getInstance(item);
					if (tooltipInstance) {
						tooltipInstance.hide();
					}
					var idTop = event.currentTarget.dataset.idtop;
					document.getElementById("idtop-" + idTop).style.opacity = "0.2";
					document
						.getElementById("idtop-" + idTop)
						.classList.add("top-destroy-tr");
					fetch(SITE_BASE_URL + "/wp-json/v1/deletetop/" + idTop + "/" + uuid_user, {
						method: "GET",
					})
						.then((response) => response.json())
						.then(async (response) => {
							console.log("Success:", response);
							document.getElementById("idtop-" + idTop).remove();
							await fetchTopsGestionData();
						})
						.catch((error) => {
							console.log("Error:", error);
						});
				});
			});
			document.querySelectorAll(".archivetop").forEach((item) => {
				item.addEventListener("click", (event) => {
					event.preventDefault();

					var tooltipInstance = bootstrap.Tooltip.getInstance(item);
					if (tooltipInstance) {
						tooltipInstance.hide();
					}

					var idTop = event.currentTarget.dataset.idtop;
					document.getElementById("idtop-" + idTop).style.opacity = "0.2";

					fetch(SITE_BASE_URL + "/wp-json/v1/archivetop/" + idTop + "/" + uuid_user, {
						method: "GET",
					})
						.then((response) => response.json())
						.then(async (response) => {
							console.log("Success:", response);
							document.getElementById("idtop-" + idTop).remove();
							await fetchTopsGestionData();
						})
						.catch((error) => {
							console.log("Error:", error);
						});
				});
			});

			if (typeof initializeTooltips === "function") {
				initializeTooltips();
			}

			if (!$.fn.DataTable.isDataTable(".table-creator")) {
				const table = $(".table-creator").DataTable({
					autoWidth: false,
					lengthMenu: [25],
					pagingType: "full_numbers",
					columns: [
						{
							orderable: false,
						},
						{
							orderable: true,
						},
						{
							orderable: true,
						},
						{
							orderable: true,
							render: function (data, type, row) {
								if (type === "sort" || type === "type") {
									var dateParts = data.split("/");
									return dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
								}
								return data;
							},
						},
						{
							orderable: false,
						},
						{
							orderable: true,
						},
						{
							orderable: true,
						},
						{
							orderable: false,
						},
					],
					language: {
						search: "_INPUT_",
						searchPlaceholder: "Rechercher...",
						processing: "Traitement en cours...",
						info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
						infoEmpty:
							"Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
						infoFiltered:
							"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
						infoPostFix: "",
						loadingRecords: "Chargement en cours...",
						zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
						emptyTable: "Aucun résultat trouvé 😩",
						paginate: {
							first: "Premier",
							previous: "Pr&eacute;c&eacute;dent",
							next: "Suivant",
							last: "Dernier",
						},
					},
					order: [],
				});
				$("#DataTables_Table_0_filter").prependTo("#searchtable");
				$("#customNavbarFilter .nav-link").on("click", function (e) {
					e.preventDefault();
					const filterValue = $(this).data("filter");
					if ($(this).hasClass("active")) {
						// If already active, reset the filter
						table.column(2).search("").draw();
						$(this).removeClass("active");
					} else {
						// Apply the filter
						table.column(2).search(filterValue).draw();
						$(this).addClass("active").siblings().removeClass("active");
					}
				});
			}

			// Envoyer un message #Admin
      document.querySelectorAll(".boxmessageBtn").forEach(function (item) {
        item.addEventListener("click", function () {
					var parentRow 	= item.closest('tr');
					var creatorBloc = parentRow.querySelector('.creatorbloc a');
					var creatorUuid = creatorBloc.getAttribute('data-creatoruuid');

          var idTop    = this.getAttribute("data-idtop");
          var uuidUser = this.getAttribute("data-uuid_user");
          var topName  = this.getAttribute("data-topname");
          document.getElementById("id_top").value = idTop;
          document.getElementById("top_name").value = topName;
          document.getElementById("uuid_message").value = uuidUser;
          document.getElementById("uuid_message_receiver").value = creatorUuid;
          fetchMessages(idTop);
        });
      });
		})
		.catch((error) => {
			console.error("There was an error fetching the tops:", error);
		});
}

document.querySelectorAll("#valide_btn").forEach((item) => {
	item.addEventListener("click", (event) => {
		event.preventDefault();

		var idTop = event.currentTarget.dataset.idtop;

		fetch(SITE_BASE_URL + "/wp-json/v1/validetop/" + idTop + "/" + uuid_user, {
			method: "GET",
		})
			.then((response) => response.json())
			.then((response) => {
				console.log("Success:", response);
				window.location.href = SITE_BASE_URL + "/creation/listing-top";
			})
			.catch((error) => {
				console.log("Error:", error);
			});
	});
});

document.querySelectorAll("#validation_btn").forEach((item) => {
	item.addEventListener("click", (event) => {
		event.preventDefault();
	
		var idTop = event.currentTarget.dataset.idtop;

		fetch(SITE_BASE_URL + "/wp-json/v1/validationtop/" + idTop + "/" + uuid_user, {
			method: "GET",
		})
			.then((response) => response.json())
			.then((response) => {
				console.log("Success:", response);
        window.location.href = SITE_BASE_URL + "/creation/listing-top";
			})
			.catch((error) => {
				console.log("Error:", error);
			});
	});
});

function secondsToStrFuncHelper(seconds) {
	function numberEnding(number) {
		return number > 1 ? "s" : "";
	}

	let temp = seconds;
	let years = Math.floor(temp / 31536000);
	temp %= 31536000;
	if (years) {
		return years + " an" + numberEnding(years);
	}
	let days = Math.floor(temp / 86400);
	temp %= 86400;
	if (days) {
		return days + " jour" + numberEnding(days);
	}
	let hours = Math.floor(temp / 3600);
	temp %= 3600;
	if (hours) {
		return hours + " heure" + numberEnding(hours);
	}
	let minutes = Math.floor(temp / 60);
	let remainingSeconds = temp % 60;
	let output = "";
	if (minutes) {
		output += minutes + " minute" + numberEnding(minutes);
	} else if (remainingSeconds) {
		output += remainingSeconds + " seconde" + numberEnding(remainingSeconds);
	} else {
		output = "moins d'une seconde"; //'just now' //or other string you like;
	}
	return output;
}

async function commentTemplate(commentId, uuid, content, secondes){
	const userResponse = await fetch(
		`${API_BASE_URL}user-list/get?uuid_user=${encodeURIComponent(uuid)}`,
		{
			method: "GET",
			headers: {
				"Content-Type": "application/json",
			},
		}
	);
	if (!userResponse.ok) {
		throw new Error("🔥 Fetching problem in: /vkrz/user-list/get");
	}
	const data = await userResponse.json();

	let deleteOrNot = "";
	if (uuid == uuid_user) {
		// assuming uuid_user is globally available
		deleteOrNot = `
			<a 
				href="" 
				style=""
				class="deleteCommentBtn ml-3"
				data-commentId="${commentId}"
			>
			</a>
		`;
	}

	return `
		<div class="comment-template media d-flex align-items-start mb-2 p-0">
			<div class="media-body">
				<div class="d-flex align-items-center justify-content-between">
					<div class="avatar-message">
						<a href="${SITE_BASE_URL}v/${data.infos_user.pseudo_slug_user}" class="text-white">
							<div class="avatar-picture" style="background-image: url(${
								data?.infos_user?.avatar_user
									? data.infos_user.avatar_user
									: "https://vainkeurz.com/wp-content/uploads/2024/11/avatar-rose.png"
							});"></div>
						</a>
						<a href="${SITE_BASE_URL}v/${data.infos_user.pseudo_slug_user}" class="text-white pseudo-text">
							<small>${
								data?.infos_user?.pseudo_user
									? data.infos_user.pseudo_user
									: "Lama2Lombre"
							}</small>
						</a>
						<small class="text-muted">Il y a ${secondsToStrFuncHelper(secondes)}</small>
					</div>
					${deleteOrNot}
				</div>
			
				<p class="media-heading mb-0">
					${content}
				</p>
			</div>
			<hr>
		</div>
	`;
};

async function fetchMessages(idTop) {
	try {
    const toplistCommentsCard = document.querySelector(".top_message"),
			commentsContainer = toplistCommentsCard.querySelector(
				".comments-container"
			);
		commentsContainer.innerHTML = "";

		const response = await fetch(`${API_BASE_URL}message-list/getfromtop`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				id_top: idTop,
			}),
		});

		if (!response.ok) {
			throw new Error("Network response was not ok");
		}

		const commentsData = await response.json();
		if (commentsData.list_of_message.length !== 0) {
			const commentPromises = commentsData.list_of_message.map(
				async (comment) => {
					const currentDate = new Date();
					const specificDate = new Date(comment.date_message);
					const durationInSeconds = Math.floor(
						(currentDate.getTime() - specificDate.getTime()) / 1000
					);
					const durationString = Math.abs(durationInSeconds);

					return commentTemplate(
						comment.id,
						comment.uuid_message,
						comment.message,
						durationString
					);
				}
			);

			const allComments = await Promise.all(commentPromises);

			allComments.forEach((commentHTML) => {
				commentsContainer.insertAdjacentHTML("beforeend", commentHTML);
			});

			const deleteCommentsBtns =
				toplistCommentsCard.querySelectorAll(".deleteCommentBtn");
			deleteCommentsBtns.forEach((btn) => {
				btn.addEventListener("click", async (e) => {
					e.preventDefault();
					e.target.closest(".comment-template").remove();

					const deleteResponse = await fetch(
						`${API_BASE_URL}message-list/delete`,
						{
							method: "POST",
							headers: {
								"Content-Type": "application/json",
							},
							body: JSON.stringify({
								id: btn.dataset.commentid,
							}),
						}
					);

					const deletedComment = await deleteResponse.json();
				});
			});

			commentsContainer.scrollTop = commentsContainer.scrollHeight;
		} else {
			commentsContainer.innerHTML = `<span>Pas encore de message 😬</span>`;
		}
	} catch (error) {
		console.error("There was a problem with the fetch operation:", error);
	}
}

async function sendMessage(comment, idTop, uuid_user, uuid_receiver, topName) {
  const toplistCommentsCard = document.querySelector(".top_message"),
		commentsContainer = toplistCommentsCard.querySelector(
			".comments-container"
		),
		commentArea = toplistCommentsCard.querySelector("#messageInput");

	const response = await fetch(`${API_BASE_URL}message-list/new`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({
			id_top: idTop,
			uuid_message: uuid_user,
			message: comment,
			uuid_receiver: uuid_receiver,
			toplist_name: topName,
		}),
	});
	const newComment = await response.json();

	let commentTemplateDiv = await commentTemplate(
		newComment.id_message,
		uuid_user,
		comment
	);
	commentsContainer.insertAdjacentHTML("beforeend", commentTemplateDiv);
	commentsContainer.scrollTop = commentsContainer.scrollHeight;

	const deleteCommentsBtns = toplistCommentsCard.querySelectorAll(".deleteCommentBtn");
	deleteCommentsBtns.forEach((btn) => {
		btn.addEventListener("click", async (e) => {
			e.preventDefault();
			e.target.closest(".comment-template").remove();

			const response = await fetch(`${API_BASE_URL}message-list/delete`, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify({
					id: btn.dataset.commentid,
				}),
			});
			const deletedComment = await response.json();
		});
	});

	const replyCommentsBtns =
		toplistCommentsCard.querySelectorAll(".replyCommentBtn");
	replyCommentsBtns.forEach((btn) => {
		btn.addEventListener("click", (e) => {
			e.preventDefault();
			commentArea.value = `${btn.dataset.replyto} `;
			commentArea.focus();
		});
	});

  updateMessageCount(idTop);
}

const validMessage = function (e) {
	e.preventDefault();

	const toplistCommentsCard = document.querySelector(".top_message"),
		commentsContainer = toplistCommentsCard.querySelector(
			".comments-container"
		),
		commentArea = toplistCommentsCard.querySelector("#messageInput");
	const idTop = document.getElementById("id_top").value;
	const uuid_receiver = document.getElementById("uuid_message_receiver").value;
	const topName = document.getElementById("top_name").value;
	let comment = commentArea.value;

	if (comment) {
		if (
			commentsContainer.innerHTML.includes(
				"Pas encore de message 😬"
			)
		) {
			commentsContainer.innerHTML = "";
		}
		commentArea.value = "";
		commentArea.focus();

		sendMessage(comment, idTop, uuid_user, uuid_receiver, topName);
	} else {
		commentArea.setAttribute(
			"placeholder",
			"Avec un petit mot ça marchera mieux 🤪"
		);
	}
};
let messageForm 	 = document.getElementById("messageForm");
let sendMessageBtn = document.querySelector("#send_message_btn");
let messageInput 	 = document.querySelector("#messageInput");
if (messageForm) {
	messageForm.addEventListener("submit", function (e) {
		e.preventDefault();
	});
}
if (sendMessageBtn) {
	sendMessageBtn.addEventListener("click", validMessage);
}
if (messageInput) {
	messageInput.addEventListener("keypress", (e) => {
		if (13 == e.keyCode) {
			e.preventDefault();
			validMessage(e);
		}
	});
}

function updateMessageCount(idTop) {
	fetch(`${API_BASE_URL}message-list/getfromtop`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({
			id_top: idTop,
		}),
	})
		.then((response) => response.json())
		.then((data) => {
			// Find the .nb-message-info element within the current row
			const messageButton = document.querySelector(
				`#idtop-${idTop} .nb-message-info`
			);
			if (messageButton) {
				messageButton.textContent = data.nb_message;
			}
		})
		.catch((error) => {
			console.error("Error fetching message count:", error);
		});
}

if(document.getElementById("contenders-scrollbar")){
  new PerfectScrollbar(document.getElementById("contenders-scrollbar"), {
    wheelPropagation: false,
  });
}

function extractTermFromURL(url) {
	const parts = url.split("/"); // Split the URL into parts
	const rubriqueIndex = parts.indexOf("rubrique"); // Find the index of 'rubrique'

	if (rubriqueIndex !== -1 && rubriqueIndex < parts.length - 1) {
		return parts[rubriqueIndex + 1]; // Return the term after 'rubrique'
	}

	return null; // Return null if 'rubrique' is not found or there is no term after it
}

function animateValue(obj, start, end, duration) {
	let startTimestamp = null;
	const step = (timestamp) => {
		if (!startTimestamp) startTimestamp = timestamp;
		const progress = Math.min((timestamp - startTimestamp) / duration, 1);
		obj.textContent = Math.floor(progress * (end - start) + start);
		if (progress < 1) {
			window.requestAnimationFrame(step);
		}
	};
	window.requestAnimationFrame(step);
}

if(document.querySelector('.top-permanent-checking-date')) {
	const checkingDateDOM = document.querySelectorAll('.top-permanent-checking-date');
	function getFirstThursdayOfNextMonth() {
		var now = new Date();
		var nextMonth = new Date(now.getFullYear(), now.getMonth() + 1, 1);
		var toThursday = (4 - nextMonth.getDay() + 7) % 7;
		nextMonth.setDate(1 + toThursday);
		return nextMonth;
	}
	function formatDateInFrench(date) {
		var months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
		return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
	}
	var firstThursday = getFirstThursdayOfNextMonth();
	var formattedDate = formatDateInFrench(firstThursday);
	checkingDateDOM.forEach(checkingDate => checkingDate.textContent = "le " + formattedDate )
}

function fetchRubriqueData(rubriqueName, item) {
	const apiUrl = `${SITE_BASE_URL}wp-json/v1/getalltopsfromsearch/${encodeURIComponent(rubriqueName)}`;
	fetch(apiUrl)
		.then((response) => response.json())
		.then((data) => {
			if (data && data.length > 0) {
				const nbResult = data[0].nb_result;
				const infoSpan = item.querySelector(".infosrubriquenbtoplist");
				if (infoSpan) {
					infoSpan.textContent = `${nbResult} TopList`;
					infoSpan.style.display = "inline-block";
				}
			}
		})
		.catch((error) => {
			console.error("Error fetching rubrique data:", error);
		});
}

function transformFirebaseStorageUrl(originalUrl, width) {
	if (typeof originalUrl === "string" && originalUrl.startsWith("https://firebasestorage.googleapis.com")) {
			const matchResult = originalUrl.match(/\/o\/([^?]+)\?alt=media&token=([^&]+)/);
			if (matchResult && matchResult.length === 3) {
					const filename = matchResult[1];
					const token = matchResult[2];
					const transformedUrl = `https://api.vainkeurz.com/vkrz/firestoreimage?file=${filename}&_ecl=600&token=${token}&width=${width}`;
					return transformedUrl;
			}
	}
	return originalUrl;
}

if (navigator.userAgent.includes('Instagram')) {
	console.warn('For the best experience, please open this page in your browser.');
	if(document.querySelector('#firebase-connexion-wrapper'))
		document.querySelector('#firebase-connexion-wrapper').classList.add('d-none');

	if(document.querySelector('.auth-wrapper .text-center h3'))
		document.querySelector('.auth-wrapper .text-center h3').classList.add('d-none');
}

if(getParamURL('iframe') == "true") {
	if (document.querySelector('.layout-navbar')) {
		document.querySelector('.layout-navbar').style.display = "none";
	}	
	if (document.querySelector('#layout-menu')) {
		document.querySelector('#layout-menu').style.display = "none";
	}
	if (document.querySelector('.logo-simple')) {
		document.querySelectorAll('.logo-simple').forEach((element) => {
			element.style.visibility = "hidden";
		});
	}
	if (document.querySelector('.right-slim')) {
		document.querySelector('.right-slim').style.visibility = "hidden";
	}	
	if (document.querySelector('.xp-notification')) {
		document.querySelector('.xp-notification').style.visibility = "hidden";
	}
	
	if (document.querySelector('.footer')) {
		document.querySelector('.footer').style.display = "none";
	}	
	document.querySelectorAll('.crisp-client').forEach((element) => {
		element.style.display = "none";
	});
	document.querySelectorAll('.niveau-slim').forEach((element) => {
		element.style.display = "none";
	});
	
	// Listen for messages from the parent window
	window.addEventListener('message', (event) => {
		// Ensure the message is from the expected origin
		if (event.origin !== 'https://unbonmaillot.com') {
			return;
		}

		if(!window.location.href.includes('unbonmaillot')) {
			return;
		}

		// Get the parameters from the event data
		const params = event.data;

		// You can now use the params as needed
		console.log(event.origin, params.email);

		if(params.email && document.querySelector('#t-sponso-email-input') && document.querySelector('#t-sponso-tel-input')) {
			document.querySelector('#t-sponso-tel-input').classList.remove('d-none');

			var input = document.querySelector("#t-sponso-tel-input");
			var iti = window.intlTelInput(input, {
				initialCountry: "fr",
				preferredCountries: ["fr", "de", "gb", "it", "es"],
				utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
			});

			document.querySelector('#t-sponso-email-input').classList.add('d-none');
			document.querySelector('#t-sponso-email-input').value = params.email;
			if(document.querySelector(".laucher_t")) {
				document.querySelectorAll(".laucher_t").forEach(el => el.setAttribute("data-phoneparticipation", true));
			}
		}
	});
}

// TEL INPUT
if(getParamURL('email') && document.querySelector('#t-sponso-email-input') && document.querySelector('#t-sponso-tel-input')) {
	document.querySelector('#t-sponso-tel-input').classList.remove('d-none');

	var input = document.querySelector("#t-sponso-tel-input");
	var iti = window.intlTelInput(input, {
		initialCountry: "fr",
		preferredCountries: ["fr", "de", "gb", "it", "es"],
		utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
	});

	document.querySelector('#t-sponso-email-input').classList.add('d-none');
	document.querySelector('#t-sponso-email-input').value = getParamURL('email');
	if(document.querySelector(".laucher_t")) {
		document.querySelectorAll(".laucher_t").forEach(el => el.setAttribute("data-phoneparticipation", true));
	}
}

// SHARE
const shareClassementNatif = document.querySelector(".share-natif-classement");
const shareTopNatif = document.querySelector(".share-natif-top");
const shareClassement = document.querySelector("#share-classement");
const shareTop = document.querySelector("#share-classement");
if (shareClassementNatif) {
    shareClassementNatif.addEventListener("click", (event) => {
        if (navigator.share && window.matchMedia("(max-width: 1024px)").matches) {
            $(".share-natif-classement").click(function () {
                $(".share-classement-content").removeClass("active-box");
            });
            navigator
                .share({
                    title: "ShareNatif API",
                    url: "",
                })
                .then(() => {
                    console.log("Merci pour le partage !");
                })
                .catch(console.error);
        } else {
            $(".share-natif-classement").click(function () {
                $(".share-classement-content").addClass("active-box");
            });
            $(".close-share").click(function () {
                $(".share-classement-content").removeClass("active-box");
            });
        }
    });
}
if (shareTopNatif){
    shareTopNatif.addEventListener("click", (event) => {
        if (navigator.share && window.matchMedia("(max-width: 1024px)").matches) {
            $(".share-natif-top").click(function () {
                $(".share-top-content").removeClass("active-box");
            });
            navigator
                .share({
                    title: "ShareNatif API",
                    url: "",
                })
                .then(() => {
                    console.log("Merci pour le partage !");
                })
                .catch(console.error);
        } else {
            $(".share-natif-top").click(function () {
                $(".share-top-content").addClass("active-box");
            });
            $(".close-share").click(function () {
                $(".share-top-content").removeClass("active-box");
            });
        }
    });
}

// TABLE
$(".table-vainkeurz-recherche").DataTable({
	autoWidth: false,
	lengthMenu: [25],
	searching: false,
	paging: false,
	columns: [
		{ orderable: false },
		{ orderable: true },
		{ orderable: true },
		{ orderable: true },
	],
	order: [],
});
$(".table-toplist-room").DataTable({
	autoWidth: false,
	lengthMenu: [25],
	pagingType: "full_numbers",
	columns: [
		{ orderable: false },
		{ orderable: true },
		{ orderable: true },
		{ orderable: false },
	],
	language: {
		search: "_INPUT_",
		searchPlaceholder: "Rechercher un vainkeur...",
		processing: "Traitement en cours...",
		info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
		infoEmpty:
			"Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
		infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
		infoPostFix: "",
		loadingRecords: "Chargement en cours...",
		zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
		emptyTable: "Aucun résultat trouvé 😩",
		paginate: {
			first: "Premier",
			previous: "Pr&eacute;c&eacute;dent",
			next: "Suivant",
			last: "Dernier",
		},
	},
	order: [],
});
$(".table-bestops").DataTable({
	autoWidth: true,
	lengthMenu: [20],
	searching: false,
	paging: false,
	columns: [
		{ orderable: false },
		{ orderable: false },
		{ orderable: false },
		{ orderable: false },
		{ orderable: false }
	],
	order: [],
});

if (document.querySelector(".menuuser-bell")) {
	const bell = document.querySelector(".menuuser-bell");

	bell.addEventListener("click", async () => {
		await fetchDataFuncHelper(
			`${API_BASE_URL}notification-list/getnew/${uuid_user}`
		).then(async (results) => {
			const notificationsContainer = document.querySelector(
				".notifications-container"
			);
			if (results.success) {
				const notificationsList = results.data;
				if (notificationsList.length > 0) {
					document
						.querySelectorAll(".notifications-nombre")
						.forEach(
							(nombre) => (nombre.textContent = notificationsList.length)
						);
					document.querySelector(".notifications-span").textContent =
						notificationsList.length <= 1 ? "Nouvelle" : "Nouvelles";
					document
						.querySelector(".badge-notifications")
						.classList.remove("d-none");
					let html = "";

					// REMOVE DUPLICATE UUIDs FROM ARRAY…
					let notificationsUsersUuids = [];
					notificationsList.forEach((notification) =>
						notificationsUsersUuids.push(notification.uuid_sender)
					);
					let set = new Set(
						notificationsUsersUuids.map((notificationUserUuid) =>
							JSON.stringify(notificationUserUuid)
						)
					);
					notificationsUsersUuids = Array.from(set).map((elem) =>
						JSON.parse(elem)
					);

					// GET USERS DATA FIRST…
					const map = new Map();
					await Promise.all(
						notificationsUsersUuids.map(async (uuid) => {
							await getUserInfos(uuid).then((data) => {
								map.set(data.data_user.uuid_user, data);
							});
						})
					);

					notificationsList.forEach((notification) => {
						let avatarImg =
							"https://vainkeurz.com/wp-content/uploads/2024/11/avatar-rose.png";
						if (
							map.get(notification.uuid_sender) &&
							map.get(notification.uuid_sender).infos_user.avatar_user
						) {
							avatarImg = map.get(notification.uuid_sender).infos_user
								.avatar_user;
						}
						const currentDate = new Date();
						const specificDate = new Date(notification.date);
						const durationInSeconds = Math.floor(
							(currentDate.getTime() - specificDate.getTime()) / 1000
						);
						const durationString = Math.abs(durationInSeconds);
						const duration = secondsToStrFuncHelper(durationString);

						// User pseudo
						let userPseudo = "";
						let pseudoFound = false;
						if (map.get(notification.uuid_sender)) {
							userPseudo = map.get(notification.uuid_sender).infos_user
								.pseudo_user;
						}

						// Replace pseudo in the notification text with a link
						let notificationTextWithLink = notification.notification_text;
						if (
							userPseudo &&
							!notification.notification_url.includes("keurz")
						) {
							const pseudoEscaped = userPseudo.replace(
								/[-\/\\^$*+?.()|[\]{}]/g,
								"\\$&"
							); // Escape special characters
							const pseudoRegex = new RegExp(pseudoEscaped, "g"); // Create a global regex
							const pseudoLink = `<a href="${SITE_BASE_URL}v/${
								map.get(notification.uuid_sender).infos_user.pseudo_slug_user
							}">${userPseudo}</a>`;
							if (notificationTextWithLink.search(pseudoRegex) !== -1) {
								notificationTextWithLink = notificationTextWithLink.replace(
									pseudoRegex,
									pseudoLink
								);
								pseudoFound = true;
							}
						}

						// If pseudo not found, wrap entire text. Otherwise, wrap from 'TopList' to end.
						if (!pseudoFound) {
							notificationTextWithLink = `<a href="${notification.notification_url}">${notificationTextWithLink}</a>`;
						} else {
							const toplistIndex = notificationTextWithLink.indexOf("TopList");
							if (toplistIndex !== -1) {
								const beforeTopList = notificationTextWithLink.substring(
									0,
									toplistIndex
								);
								const fromTopListToEnd =
									notificationTextWithLink.substring(toplistIndex);
								const toplistLink = `<a href="${notification.notification_url}">${fromTopListToEnd}</a>`;
								notificationTextWithLink = beforeTopList + toplistLink;
							}
						}

						html += `
								<div 
									class="d-flex" 
									id="readNotification" 
									data-id="${notification.id}"
								>
									<div class="media d-flex align-items-start">
										<div class="media-left">
											<div class="avatar">                  
												<span class="avatar-picture" style="background-image: url(${avatarImg});"></span>
											</div>
										</div>
	
										<div class="media-body">
											<p class="media-heading mb-0">
												<span class="font-weight-bolder">
													${notificationTextWithLink}
												</span>
												<small class="notification-text">Il y a ${duration}</small>
											</p>
										</div>
									</div>
								</div>
							`;
					});
					notificationsContainer.innerHTML = html;

					// PROCESS TO UPDATE STATUT… 🎺
					const buttons = document.querySelectorAll("#readNotification");
					buttons.forEach((button) => {
						button.addEventListener("click", async function () {
							let id = button.dataset.id;

							await fetch(`${API_BASE_URL}notification-list/update/${id}`, {
								method: "PUT",
								headers: { "Content-Type": "application/json" },
							})
								.then((response) => response.json())
								.then((data) => console.log(data));
						});
					});
				}
			}
		});
	});
}

function waitForWeglot(callback) {
	if (typeof Weglot !== "undefined") {
		callback();
	} else {
		setTimeout(() => waitForWeglot(callback), 100);
	}
}
