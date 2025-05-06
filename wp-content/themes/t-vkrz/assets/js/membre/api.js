const api_url = "http://localhost:8000/vkrz/";
//const api_url = "https://proto.vainkeurz.com/api/vkrz/";

const API_BASE_URL =
	env === "local"
		? api_url
		: env === "proto"
		? "https://proto.vainkeurz.com/api/vkrz/"
		: "https://vainkeurz.com/api/vkrz/";

const SITE_BASE_URL = env === 'local' ? "http://localhost:8888/vkrz-devineBox/"
  : env === 'proto' ? "https://proto.vainkeurz.com/"
    : "https://devine.vainkeurz.com/";

async function fetchDataFuncHelper(url) {
  const response = await fetch(url);
  const data     = await response.json();

  if(!response.ok) {
    throw new Error("Network response was not ok");
  }
  return data;
}

// Check if a TopList to SQL #toolong
async function SQL_checkTopList(id_top, uuid_user) {
  const endpoint = `${API_BASE_URL}toplist-list/check/${encodeURIComponent(id_top)}/${encodeURIComponent(uuid_user)}`;
  try {
    const response = await fetch(endpoint, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      }
    });
    
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
    throw error;
  }
}

// Create a new TopList to SQL // Create a new vainkeur if not exist to SQL
async function SQL_createTopList(data) {
  const endpoint = API_BASE_URL + "toplist-list/new";

  try {
    const response = await fetch(endpoint, {
      method: "POST",
      headers: { "Content-Type": "application/json", },
      body: JSON.stringify(data),
    });

    if (!response.ok) {
      throw new Error(
        `Erreur lors de l'envoi des données : ${response.status}`
      );
    }

    const responseData = await response.json();

    var elements = document.querySelectorAll(".confirm_delete");
		elements.forEach(function (element) {
			element.dataset.toplistid = responseData.id_topList;
		});

    refresh_user_data(uuid_user);

    localStorage.removeItem("inventaire_user");

    console.log("TopList créée avec succès !", responseData.id_topList);
    return responseData.id_topList;

  } catch (error) {
    console.error("Erreur lors de l'envoi des données :", error);
    return null;
  }
}

// Create a new Devine to SQL // Create a new vainkeur if not exist to SQL
async function SQL_createDevineTopList(data) {
	const endpoint = API_BASE_URL + "devine/new";

	try {
		const response = await fetch(endpoint, {
			method: "POST",
			headers: { "Content-Type": "application/json" },
			body: JSON.stringify(data),
		});

		if (!response.ok) {
			throw new Error(
				`Erreur lors de l'envoi des données : ${response.status}`
			);
		}

		const responseData = await response.json();

    console.log("responseData", responseData);

		return responseData;
	} catch (error) {
		console.error("Erreur lors de l'envoi des données :", error);
		return null;
	}
}

// Save TopList to SQL
async function SQL_saveTopList(data) {
  const endpoint = API_BASE_URL + "toplist-list/save";
  try {
    const response = await fetch(endpoint, {
      method: "POST",
      headers: { "Content-Type": "application/json", },
      body: JSON.stringify(data),
    });

    if (!response.ok) {
      throw new Error(
        `Erreur lors de l'envoi des données : ${response.status}`
      );
    }

    let responseJson = await response.json();
    // console.log(responseJson)

    if (data.state_toplist == "done") {
      var element = document.querySelector(".stepbar");
      if (element) {
        element.style.opacity = "0";
      }
      if(getParamURL('iframe') == "true") {
        window.location.href = SITE_BASE_URL + "toplist/" + data.slugTop + "/" + data.id_current_topList + "/" + "?iframe=true" + "&uuid_user=" + data.uuid_user;
      } else {
        window.location.href = SITE_BASE_URL + "toplist/" + data.slugTop + "/" + data.id_current_topList + "/";
      }
    }
  }
  catch (error) {
    console.error("Erreur lors de l'envoi des données :", error);
    return null;
  }
}

// Get Top Info from WP API
async function get_top_info(id, type) {
  const endpoint = SITE_BASE_URL + "/wp-json/v1/infotop/" + id + "/" + type;
  try {
    const response = await fetch(endpoint);

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("There was a problem with the fetch operation:", error);
    return null;
  }
}

// Get Top Info from WP API
async function get_devine_info(id_toplist_devine) {
  const endpoint = API_BASE_URL + "devine/getdata/" + id_toplist_devine;
  try {
    const response = await fetch(endpoint);

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("There was a problem with the fetch operation:", error);
    return null;
  }
}

// Get TopList Info from SQL
async function SQL_getTopList(topList_id) {
  const endpoint = `${API_BASE_URL}toplist-list/get/${topList_id}`;
  try {
    const response = await fetch(endpoint, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      }
    });

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("There was a problem with the fetch operation:", error);
    return null;
  }
}

// Delete TopList into SQL
async function deleteTopList(topList_id, uuid_user) {
  const endpoint = API_BASE_URL + "toplist-list/delete";
  const data = {
		id_topList: topList_id,
		uuid_user: uuid_user,
	};

  try {
    const response = await fetch(endpoint, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });

    const jsonResponse = await response.json();
    return jsonResponse;
  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

// Get number of comments of a Top
async function getNumberOfComments(id_top) {
  const endpoint = SITE_BASE_URL + "/wp-json/wp/v2/comments?post=" + id_top;
  return fetch(endpoint)
    .then((response) => response.json())
    .then((comments) => {
      const numberOfComments = comments.length;
      return { number_of_comments: numberOfComments };
    })
    .catch((error) => console.error(error));
}

async function get_user_data_infos(uuid_user) {
	if (
		localStorage.getItem("user_info") === null ||
		JSON.parse(localStorage.getItem("user_info")).pseudo_user === "Lama2Lombre"
	) {
		// Construct the URL with query parameters
		const endpoint = `${API_BASE_URL}user-list/get?uuid_user=${encodeURIComponent(
			uuid_user
		)}`;

		try {
			const response = await fetch(endpoint, {
				method: "GET", // Explicitly using GET
				headers: {
					"Content-Type": "application/json",
				},
			});

			if (response.ok) {
				const data = await response.json();
				// Store user data in localStorage
				localStorage.setItem("user_info", JSON.stringify(data.infos_user));
				localStorage.setItem("vainkeur_data", JSON.stringify(data.data_user));
			} else {
				console.error("Error:", response.status, response.statusText);
			}
		} catch (error) {
			console.error("Error:", error);
		}
	}
}

async function get_user_trophy_data(id_vainkeur) {
  if (localStorage.getItem("vainkeur_trophy") === null) {
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
        if (data.have_trophy === true) {
          localStorage.setItem("vainkeur_trophy", JSON.stringify(data.trophy_list));
          return data.trophy_list;
        }
      }
      else {
        console.error("Error:", response.status, response.statusText);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }
}

// Get all data of a user about Top & TopList
async function get_user_inventaire(uuid_user) {
  if (localStorage.getItem("inventaire_user") === null) {
    try {
      const response = await fetch(`${API_BASE_URL}inventaire/get`, {
        method: "POST",
        headers: { "Content-Type": "application/json", },
        body: JSON.stringify({ uuid_user }),
      });
      const text = await response.text();
      try {
        const data = JSON.parse(text);
        if (response.ok) {
          if (data.user_exists === true) {
            const inventaire_user_from_sql = {
              list_toplist_done: data.list_toplist_done,
              list_top_pending: data.list_top_pending,
              list_top_done: data.list_top_done,
            };
            localStorage.setItem(
              "inventaire_user",
              JSON.stringify(inventaire_user_from_sql)
            );
          }
        } else {
          console.error("Error:", response.status, response.statusText);
        }
      } catch (error) {
        console.error("Failed to parse JSON:", text);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }
}

async function getUserInfos(uuid_user) {
	try {
		const endpoint = `${API_BASE_URL}user-list/get?uuid_user=${encodeURIComponent(
			uuid_user
		)}`;
		const response = await fetch(endpoint, {
			method: "GET",
			headers: {
				"Content-Type": "application/json",
			},
		});
		if (response.ok) {
			const data = await response.json();
			return data;
		} else {
			console.error("Error:", response.status, response.statusText);
		}
	} catch (error) {
		console.error("Error:", error);
	}
}

// Get Top Info from WP API
async function get_top_meta(idtop) {
  const endpoint = SITE_BASE_URL + "/wp-json/v1/gettopmeta/" + idtop;
  try {
    const response = await fetch(endpoint);

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("There was a problem with the fetch operation:", error);
    return null;
  }
}

async function loadContendersIntoModal(id_top, container) {
  console.log("id_top", id_top);
  console.log("container", container);

  try {
    const response = await fetch(
      `${SITE_BASE_URL}wp-json/v1/getrankingoftop/${id_top}/elo`
    );
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    let initContenders = data.ranking;
    console.log("initContenders", initContenders);

    if (!container) {
      console.error('Container not found');
      return;
    }
    
    container.innerHTML = ""; // Clear existing content

    if (initContenders.length === 0) {
      container.innerHTML = `<p>Aucun contender trouvé.</p>`;
      return;
    }

    const animations = [
      "animate__fadeInDown",
      "animate__backInDown",
      "animate__flipInX",
      "animate__zoomIn",
      "animate__slideInDown",
    ];
    let delay = 0;
    const animation = animations[Math.floor(Math.random() * animations.length)];
    initContenders.sort((a, b) => a.c_name.localeCompare(b.c_name));
    
    // Create and append all contenders
    const contendersHTML = initContenders.map((contender) => `
      <div class="col-md-3 col-sm-4 col-6 contender_item_min p-0 animate__animated contender_item_${contender.id_wp} ${animation}" style="animation-delay: ${delay += 0.1}s">
        <div style="background-image: url(${contender.cover});"
            data-bs-toggle="tooltip"
            data-popup="tooltip-custom"
            data-bs-custom-class="tooltip-danger"
            data-bs-placement="top"
            class="contender-item"
            aria-label="${contender.c_name}"
            data-bs-original-title="${contender.c_name}">
            <img src="${contender.cover}" alt="${contender.c_name}" class="img-fluid">
        </div>
      </div>
    `).join('');
    
    container.innerHTML = contendersHTML;

    // Initialize tooltips
    const tooltips = container.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(el => new bootstrap.Tooltip(el));

  } catch (error) {
    console.error("Error fetching contenders:", error);
    if (container) {
      container.innerHTML = `<p>Une erreur s'est produite lors du chargement des contenders.</p>`;
    }
  }
}

async function loadContenders(id_top) {
  let getRankingContenders = JSON.parse(
		sessionStorage.getItem(`contenders_${id_top}`)
	);
  if(getRankingContenders){
    sessionStorage.removeItem(`contenders_${id_top}`);
  }
	try {
		const response = await fetch(
			`${SITE_BASE_URL}wp-json/v1/getrankingoftop/${id_top}/elo`
		);
		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		}
		const data = await response.json();
		let initContenders = data.ranking;
    
    // Save contenders to sessionStorage.setItem
    sessionStorage.setItem(`contenders_${id_top}`, JSON.stringify(initContenders));

		const contendersContainer = document.querySelector(
			".list-contenders-items"
		);
		contendersContainer.innerHTML = ""; // Clear existing content

		if (initContenders.length === 0) {
			contendersContainer.innerHTML = `<p>Aucun contender trouvé.</p>`;
			return;
		}

		const animations = [
			"animate__fadeInDown",
			"animate__backInDown",
			"animate__flipInX",
			"animate__zoomIn",
			"animate__slideInDown",
		];
		let delay = 0;
		const animation = animations[Math.floor(Math.random() * animations.length)];

		initContenders.sort((a, b) => a.c_name.localeCompare(b.c_name));
		initContenders.forEach((contender) => {
			const contenderHTML = `
          <div class="contender_item_min p-0 animate__animated contender_item_${contender.id_wp} ${animation}" style="animation-delay: ${delay}s">
              <div style="background-image: url(${contender.cover});"
                  data-bs-toggle="tooltip"
                  data-popup="tooltip-custom"
                  data-bs-custom-class="tooltip-danger"
                  data-bs-placement="top"
                  class="contender-item"
                  aria-label="${contender.c_name}"
                  data-bs-original-title="${contender.c_name}">
                  <img src="${contender.cover}" alt="${contender.c_name}" class="img-fluid">
              </div>
              <span class="remove-contender-icon" data-idcontender="${contender.id_wp}">&times;</span>
          </div>
      `;
			contendersContainer.insertAdjacentHTML("beforeend", contenderHTML);
			delay += 0.1;
		});

		// Initialize Bootstrap tooltips
		const tooltipTriggerList = [].slice.call(
			document.querySelectorAll('[data-bs-toggle="tooltip"]')
		);
		tooltipTriggerList.forEach(function (tooltipTriggerEl) {
			new bootstrap.Tooltip(tooltipTriggerEl);
		});

		const resetAllContendersBtn = document.querySelector(
			".btn-reset-contenders"
		);
		resetAllContendersBtn.addEventListener("click", function () {
			window.location.reload();
		});

		const removeContendersBtns = document.querySelectorAll(
			".remove-contender-icon"
		);
		removeContendersBtns.forEach((btn) => {
			btn.addEventListener("click", function () {
				const idContender = btn.dataset.idcontender;
				
				if (initContenders.length == 2) {
					document
						.querySelector(".alert-two-contenders")
						.classList.remove("d-none");
					return;
				}

				resetAllContendersBtn.classList.remove("d-none");

				updateNBcontenders(initContenders.length - 1);

				// First, hide the tooltip
				document
					.querySelectorAll(".tooltip-inner")
					.forEach((el) => el.remove());
				document
					.querySelectorAll(".tooltip-arrow")
					.forEach((el) => el.remove());

				const tooltipObserver = new MutationObserver((mutations) => {
					mutations.forEach((mutation) => {
						mutation.addedNodes.forEach((node) => {
							if (
								node.classList &&
								(node.classList.contains("tooltip-inner") ||
									node.classList.contains("tooltip-arrow"))
							) {
								node.remove();
							}
						});
					});
				});
				tooltipObserver.observe(document.body, {
					childList: true,
					subtree: true,
				});

				setTimeout(() => {
					initContenders = initContenders.filter(
						(contender) => contender.id_wp != idContender
					);
					const contenderToRemove = document.querySelector(
						`.contender_item_${idContender}`
					);
          console.log("contenderToRemove", contenderToRemove);
					if (contenderToRemove) {
            console.log("remove", contenderToRemove);
						contenderToRemove.remove();
            sessionStorage.setItem(`contenders_${id_top}`, JSON.stringify(initContenders));
					}          
				}, 150);
			});
		});
	} catch (error) {
		console.error("Error fetching contenders:", error);
	}
}

function updateNBcontenders(top_number) {

  const removeContendersBtns = document.querySelectorAll(
    ".remove-contender-icon"
  );
  if (top_number == 2)
  removeContendersBtns.forEach((btn) => {
    btn.classList.add("d-none");
  });

  document.querySelectorAll(".nb_contenders").forEach(element => {
    element.innerHTML = top_number;
  });

  automaticTwitchGiftTop1       = false;
  automaticTwitchGiftTop3       = false;
  automaticTwitchGiftTopComplet = false;
  let max, min, moy;

  if (document.querySelector(".cta-complet")) {
    document.querySelector(".cta-complet").classList.remove("d-none");
  }

  // Top1 Logic
  const top1Display = top_number > 6 ? "flex" : "none";
  if (document.querySelector("#choosenumbertop")) {
    document.querySelector("#choosenumbertop").style.display = top1Display;
  }
  if (document.querySelector(".choicetop1-bloc")) {
    document.querySelector(".choicetop1-bloc").style.display = top1Display;
  }

  // Top3 Logic
  const top3Display = top_number > 10 ? "flex" : "none";
  if (document.querySelector(".choicetop3-bloc")) {
    document.querySelector(".choicetop3-bloc").style.display = top3Display;
  }
  if (top_number > 10) {
      max = Math.floor(top_number / 2) + (3 * (Math.round(top_number / 2) - 1));
      min = Math.floor(top_number / 2) + (Math.round(top_number / 2) - 1) + 3;
      moy = (max + min) / 2;
  }

  // TopComplet Logic
  const topCompletDisplay = top_number >= 3 ? "flex" : "none"; // Adjust based on your conditions
  if (document.querySelector(".choicetopcomplet-bloc")) {
    document.querySelector(".choicetopcomplet-bloc").style.display = topCompletDisplay;
  }
  let minComplete = (top_number - 5) * 2 + 6;

  // Updating Twitch gift visibility based on user info and conditions
  const user_infos = JSON.parse(localStorage.getItem("user_info"));
  if(user_infos !== null && user_infos.twitch_user) {
      automaticTwitchGiftTop1 = top_number > 6 && (top_number - 1) > 15;
      automaticTwitchGiftTop3 = top_number > 10 && Math.round(moy) > 15;
      automaticTwitchGiftTopComplet = (top_number >= 10) && (minComplete > 15);

      if(automaticTwitchGiftTop1 || automaticTwitchGiftTop3 || automaticTwitchGiftTopComplet) {
          document.querySelectorAll('.va-twitch-gift-game:not(.va-twitch-gift-game-typetop)').forEach(el => el.classList.remove('d-none'));
      } else {
          document.querySelectorAll('.va-twitch-gift-game').forEach(el => el.classList.add('d-none'));
          document.querySelectorAll('.va-twitch-gift-game:not(.va-twitch-gift-game-typetop)').forEach(el => el.classList.add('d-none'));
      }
  }
}
