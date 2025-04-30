// DECLARATION OF VARIABLES…
let listeningForCount = true,
	listeningForJoin = false,
	votePredictionBoolean = false,
	votePointsBoolean = false,
	voteParticipatifBoolean = false,
	winnerAlready = false,
	saveTwitchGameInfo = false,
	usersNumberForParticipatifMode = 0,
	votesNumberForContenderOne = 0,
	votesNumberForContenderTwo = 0,
	users = {},
	losers = {},
	toFilter = [],
	passed = [],
	nonPassed = [],
	sameVoteGroup = [],
	sameVoteGroupObj = {},
	notSameVoteGroup = [],
	notSameVoteGroupObj = {},
	participantsDOM,
	contenderOneVotesPercent,
	contenderTwoVotesPercent,
	votesNumber,
	votePointsTable,
	votePointsTBody,
	votePointsTableFirstCopy,
	preditcionParticipantsNumber,
	preditcionParticipantsVotedNumber,
	pointsParticipantsNumber,
	pointsParticipantsVotedNumber,
	gameModesBanner,
	gameModesBtns,
	gameGiftName,
	gameMode,
	twitchChannel,
	totalVotesNumber,
	votesNumberWording,
	id_twitch_game,
	position = 1,
	positionStr = "",
	userListItem = "",
	X,
	A,
	B;
X = A = B = 0;

const ID_TOPLIST_PROD_UNBONMAILLOT = 611149;
const ID_TOPLIST_PROD_UNBONMAILLOT_2 = 612944;
const ID_TOPLIST_PROD_UNBONMAILLOT_3 = 615238;

(function populateTable() {
	const tableBody = document.querySelector(".table-twitch-gift tbody");
	if (tableBody) tableBody.innerHTML = "";

	let prizes = [];
	if (
		id_top == ID_TOPLIST_PROD_UNBONMAILLOT ||
		id_top == ID_TOPLIST_PROD_UNBONMAILLOT_2 ||
		id_top == ID_TOPLIST_PROD_UNBONMAILLOT_3
	) {
		prizes = [
			{ prize: "5% de réduction", limit: "> 5" },
			{ prize: "10% de réduction", limit: "> 10" },
			{ prize: "20% de réduction", limit: "> 20" },
			{ prize: "-50% sur la box maillot mystère", limit: "> 50" },
			{ prize: "1 box maillot mystère", limit: "> 100" },
			{ prize: "1 box maillot mystère 23/24", limit: "> 500" },
			{ prize: "1 box maillot mystère floqué", limit: "> 1000" },
		];
		if (
			(id_top == ID_TOPLIST_PROD_UNBONMAILLOT ||
				id_top == ID_TOPLIST_PROD_UNBONMAILLOT_3) &&
			document.querySelector(".modes-jeu-twitch")
		)
			document.querySelector(".modes-jeu-twitch").className =
				"modes-jeu-twitch d-none";

		if (document.querySelector(".table-twitch-gift caption")) {
			document.querySelector(".table-twitch-gift caption").innerHTML = `
        <div class="d-flex">
          <p>
          Limité à deux lots par chaîne Twitch. Les gagnants seront contactés par VAINKEURZ pour l'envoi de leurs lots.
          </p>
        </div>
      `;
		}
	} else {
		prizes = [
			{ prize: "500 KEURZ", limit: "> 5", hasGem: true },
			{ prize: "2000 KEURZ", limit: "> 10", hasGem: true },
			{ prize: "5000 KEURZ", limit: "> 20", hasGem: true },
			{ prize: "Carte cadeau 10€", limit: "> 50", hasGem: false },
			{ prize: "Carte cadeau 20€", limit: "> 100", hasGem: false },
			{ prize: "Un jeu (valeur 50€)", limit: "> 500", hasGem: false },
			{ prize: "Un séjour à Disney", limit: "> 1000", hasGem: false },
			{ prize: "Une PS5", limit: "> 5000", hasGem: false },
		];
	}

	prizes.forEach((item, index) => {
		const row = document.createElement("tr");
		const prizeCell = document.createElement("td");
		prizeCell.innerHTML = item.hasGem
			? `${item.prize} <span class="va-gem va va-md"></span>`
			: item.prize;
		const participantCell = document.createElement("td");
		participantCell.innerHTML = `${item.limit} <span class="va-pouce-up va va-lg d-none"></span>`;
		row.appendChild(prizeCell);
		row.appendChild(participantCell);
		if (tableBody) tableBody.appendChild(row);
	});
})();

function updateTableActiveRow(participantCount) {
	let thresholds = [];
	if (
		id_top == ID_TOPLIST_PROD_UNBONMAILLOT ||
		id_top == ID_TOPLIST_PROD_UNBONMAILLOT_2 ||
		id_top == ID_TOPLIST_PROD_UNBONMAILLOT_3
	) {
		thresholds = [
			{ limit: 5, prize: "5% de réduction", row: 0 },
			{ limit: 10, prize: "10% de réduction", row: 1 },
			{ limit: 20, prize: "20% de réduction", row: 2 },
			{ limit: 50, prize: "-50% sur la box maillot mystère", row: 3 },
			{ limit: 100, prize: "1 box maillot mystère", row: 4 },
			{ limit: 500, prize: "1 box maillot mystère 23/24", row: 5 },
			{ limit: 1000, prize: "1 box maillot mystère floqué", row: 6 },
		];
	} else {
		thresholds = [
			{ limit: 5, prize: "500 KEURZ", row: 0 },
			{ limit: 10, prize: "2000 KEURZ", row: 1 },
			{ limit: 20, prize: "5000 KEURZ", row: 2 },
			{ limit: 50, prize: "Carte cadeau 10€", row: 3 },
			{ limit: 100, prize: "Carte cadeau 20€", row: 4 },
			{ limit: 500, prize: "Un jeu (valeur 50€)", row: 5 },
			{ limit: 1000, prize: "Un séjour à Disney", row: 6 },
			{ limit: 5000, prize: "Une PS5", row: 7 },
		];
	}

	const rows = document.querySelector(".table-twitch-gift tbody").rows;

	let selectedPrize = null;

	for (const row of rows) {
		row.classList.remove("active");
		const thumbIcon = row.querySelector(".va-pouce-up");
		thumbIcon.classList.add("d-none");
	}

	for (let i = thresholds.length - 1; i >= 0; i--) {
		if (participantCount >= thresholds[i].limit) {
			selectedPrize = thresholds[i].prize;
			rows[thresholds[i].row].classList.add("active");
			const thumbIcon = rows[thresholds[i].row].querySelector(".va-pouce-up");
			thumbIcon.classList.remove("d-none");
			break;
		}
	}

	if (selectedPrize && automaticTwitchGift) {
		return selectedPrize;
	} else {
		return null;
	}
}

const handleTwitchGames = (automaticGift = false) => {
	const user_infos = JSON.parse(localStorage.getItem("user_info"));
	if (user_infos !== null && user_infos.twitch_user) {

    if(document.querySelector(".twitch-possible")){
      document.querySelector(".twitch-possible").classList.remove("d-none");
    }

		if (automaticGift) {
			if (
				document
					.querySelector(".twitch-gift-container")
					.classList.contains("d-none")
			) {
				document
					.querySelector(".twitch-gift-container")
					.classList.remove("d-none");
			}
		}

		gameModesBanner = document.querySelector(".modes-jeu-twitch");
		gameModesBtns = gameModesBanner.querySelectorAll(".modeGameTwitchBtn");

		gameMode = localStorage.getItem("twitchGameMode");
		twitchVotesContainer = document.querySelector(".twitch-votes-container");
		twitchChannel = user_infos.twitch_user;
		
		if (twitchVotesContainer) {
			totalVotesNumber = twitchVotesContainer.querySelector(
				".votes-number-total"
			);
			votesNumberWording = twitchVotesContainer.querySelector(
				".votes-number-wording"
			);
		}

		if (twitchVotesContainer) {
			votesNumber = twitchVotesContainer.querySelector(".votes-number");
			contenderOneVotesPercent =
				twitchVotesContainer.querySelector("#votes-percent-1");
			contenderTwoVotesPercent =
				twitchVotesContainer.querySelector("#votes-percent-2");
		}

		function resetDefaults() {
			localStorage.removeItem("twitchGameMode");

			votePredictionBoolean = false;
			votePointsBoolean = false;
			voteParticipatifBoolean = false;

			document.querySelectorAll("#begin_t").forEach((btn) => {
				if (!btn.classList.contains("pulsate")) {
					btn.classList.remove("pulsate");
				}
			});

			gameModesBtns.forEach((btn) => {
				if (!btn.classList.contains("selectedGameMode")) {
					btn.classList.remove("selectedGameMode");
				}
			});

			if (!twitchVotesContainer.classList.contains("d-none")) {
				twitchVotesContainer.classList.add("d-none");
			}

			document.querySelectorAll(".taper-zone").forEach((div) => {
				if (!div.classList.contains("d-none")) {
					div.classList.add("d-none");
				}
			});

			const votesStatsContainer = twitchVotesContainer.querySelector(
				".votes-stats-container"
			);
			if (!votesStatsContainer.classList.contains("d-none")) {
				votesStatsContainer.classList.add("d-none");
			}

			const predictionPlayer = document.querySelector("#prediction-player");
			if (!predictionPlayer.classList.contains("d-none")) {
				predictionPlayer.classList.add("d-none");
			}

			const twitchOverlay = document.querySelector(".twitch-overlay");
			if (!twitchOverlay.classList.contains("d-none")) {
				twitchOverlay.classList.add("d-none");
			}

			const rankingPlayer = document.querySelector("#ranking-player");
			if (!rankingPlayer.classList.contains("d-none")) {
				rankingPlayer.classList.add("d-none");
			}

			const tablePoints = document.querySelector(".table-points");
			if (!tablePoints.classList.contains("d-none")) {
				tablePoints.classList.add("d-none");
			}
		}

		function setupParticipatif() {
			resetDefaults();
			twitchVotesContainer.classList.remove("d-none");
			twitchVotesContainer
				.querySelectorAll(".taper-zone")
				.forEach((div) => div.classList.remove("d-none"));
			twitchVotesContainer
				.querySelector(".votes-stats-container")
				.classList.remove("d-none");
			voteParticipatifBoolean = true;
		}

		function setupPrediction() {
			resetDefaults();

			twitchVotesContainer.classList.remove("d-none");
			listeningForCount = false;

			preditcionParticipantsNumber = document.querySelector(
				".prediction-participants"
			);
			preditcionParticipantsVotedNumber = document.querySelector(
				".prediction-participants-votey-nbr"
			);

			document
				.querySelectorAll(".votes-container > p:first-of-type")
				.forEach((p) => (p.style.marginTop = "2rem"));

			document.querySelector("#prediction-player").classList.remove("d-none");

			const twitchOverlay = document.querySelector(".twitch-overlay");
			twitchOverlay.classList.remove("d-none");

			participantsDOM = document.querySelector("#participants");
			participantsDOM.classList.remove("d-none");
			participantsDOM = participantsDOM.querySelector(".card-body");

			(function countdownFunc() {
				const nums = twitchOverlay.querySelectorAll(".nums span");
				const counter = twitchOverlay.querySelector(".counter-for-twitch");
				const finalMessage = twitchOverlay.querySelector(".final");
				const launchGameBtn = twitchOverlay.querySelector("#launchGameBtn");
				const reloadGameBtn = twitchOverlay.querySelector("#reloadGameBtn");
				votePredictionBoolean = true;

				runAnimation();

				function runAnimation() {
					nums.forEach((num, index) => {
						const penultimate = nums.length - 1;
						num.addEventListener("animationend", (e) => {
							listeningForJoin = true;
							if (e.animationName === "goIn" && index !== penultimate) {
								num.classList.remove("in");
								num.classList.add("out");
							} else if (
								e.animationName === "goOut" &&
								num.nextElementSibling
							) {
								num.nextElementSibling.classList.add("in");
							} else {
								counter.classList.add("hide");
								finalMessage.classList.add("show");

								if (Object.keys(users).length < 2) {
									launchGameBtn.classList.add("d-none");
									reloadGameBtn.classList.remove("d-none");
									reloadGameBtn.addEventListener("click", () => {
										window.location.reload();
									});
									twitchOverlay.querySelector(".mode-alert").style.marginTop =
										"50px";
								} else {
									twitchOverlay.querySelector(".mode-alert")?.remove();
								}

								twitchOverlay.querySelector("#countdown").style.margin = "0";
								twitchOverlay.querySelector("h4:first-of-type").remove();
							}
						});
					});
				}

				launchGameBtn.addEventListener(
					"click",
					() => {
						if (Object.keys(users).length < 2) return false;
						window.scrollTo({ top: 0, behavior: "smooth" });

						if (!saveTwitchGameInfo && votePredictionBoolean) {
							const userData = JSON.parse(localStorage.getItem("user_info"));
							const embed = {
								title: `🟣 LIVE en cours de ${twitchChannel} 🟣`,
								color: 0xa98ed6,
								description: `TopList ${topInfo.top_number} ${getTopIcon(
									topInfo.top_cat_name
								)} ${topInfo.top_title} – ${topInfo.top_question}`,
								timestamp: new Date().toISOString(),
								author: {
									url: `${SITE_BASE_URL}v/${userData.pseudo_slug_user}`,
									icon_url: userData.avatar_user
										? userData.avatar_user
										: "https://vainkeurz.com/wp-content/uploads/2023/09/avatar-rose.webp",
									name: userData.pseudo_user,
								},
								fields: [
									{
										name: "Streamer",
										value: twitchChannel,
										inline: true,
									},
									{
										name: "Mode de jeu",
										value: `Mort subite`,
										inline: true,
									},
									{
										name: "Participants",
										value: `👀 ${Object.keys(users).length}`,
										inline: true,
									},
									{
										name: "Type TopList",
										value: type_top ?? "(Inconnu)",
										inline: true,
									},
									{
										name: "Max votes possibles",
										value:
											getMaxVotesOfTopList(+topInfo.top_number, type_top) ??
											"(Inconnu)",
										inline: true,
									},
									{
										name: "À gagner",
										value: automaticTwitchGift
											? updateTableActiveRow(Object.keys(users).length)
												? updateTableActiveRow(Object.keys(users).length)
												: "(Rien :/)"
											: "(Rien :/)",
										inline: true,
									},
								],
								url: `https://www.twitch.tv/${twitchChannel}`,
								image: {
									url: "https://vainkeurz.com/wp-content/uploads/2023/09/gif-mode-game-2-twitch.gif",
								},
								footer: {
									text: "Go Participer Au Live!",
									icon_url:
										"https://vainkeurz.com/wp-content/themes/t-vkrz/assets/images/emojis/twitch.png",
								},
							};
							const messageToSend = {
								username: "NOTEURZ 🤖",
								avatar_url:
									"https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg",
								embeds: [embed],
							};

							// SAVE DATA TO DB…
							fetch(`${API_BASE_URL}twitch/save-game`, {
								method: "POST",
								body: JSON.stringify({
									id_top: id_top,
									id_toplist:
										document.querySelector(".confirm_delete").dataset.toplistid,
									uuid_user: uuid_user,
									stream_channel: twitchChannel,
									number_participants: Object.keys(users).length,
									game_mode: 2,
									participants: Object.keys(users),
									gift: gameGiftName,
									webhook: "twitch-live",
									messageData: messageToSend,
								}),
								headers: { "Content-Type": "application/json" },
							})
								.then((response) => response.json())
								.then((data) => {
									console.log(data);
									id_twitch_game = data.id_game;

									// SHOW LINK TO GO
									const tiragaBtnContainer =
										document.querySelector(".go-to-tirage-vkrz");
									const tiragaBtn = tiragaBtnContainer.querySelector(
										".go-to-tirage-vkrz-btn"
									);
									tiragaBtnContainer.classList.remove("d-none");
									tiragaBtn.href = `${TIRAGE_VAINKEUR_URL}?streamChannel=${twitchChannel}`;
									tiragaBtn.addEventListener("click", async () => {
										const cardPredictionsHTML = document.querySelector(
											"#prediction-player #participants"
										).outerHTML;
										const determineWinnersInTwitchGamesVar =
											determineWinnersInTwitchGames(2, cardPredictionsHTML);
										if (determineWinnersInTwitchGamesVar.status === "success") {
											fetch(`${API_BASE_URL}twitch/update-participants-game`, {
												method: "POST",
												body: JSON.stringify({
													id: data.id_game,
													rest_participants:
														determineWinnersInTwitchGamesVar.participants,
												}),
												headers: { "Content-Type": "application/json" },
											})
												.then((response) => response.json())
												.then((data) => {
													console.log(data);
													if (data.status === "success") {
														tiragaBtnContainer.classList.add("d-none");
													}
												});
										}
									});
								})
								.catch((error) =>
									console.error("Error sending message:", error)
								);
						}

						listeningForCount = true;
						listeningForJoin = false;
						twitchOverlay.classList.add("d-none");
					},
					{ once: true }
				);
			})();
		}

		function setupPoints() {
			resetDefaults();

			twitchVotesContainer.classList.remove("d-none");
			listeningForCount = false;

			pointsParticipantsNumber = document.querySelector(".points-participants");
			pointsParticipantsVotedNumber = document.querySelector(
				".points-participants-votey-nbr"
			);

			document
				.querySelectorAll(".votes-container > p:first-of-type")
				.forEach((p) => (p.style.marginTop = "2rem"));

			document.querySelector("#ranking-player").classList.remove("d-none");

			const twitchOverlay = document.querySelector(".twitch-overlay");
			twitchOverlay.classList.remove("d-none");

			votePointsTable = document.querySelector(".table-points");
			votePointsTBody = votePointsTable.querySelector("tbody");
			if (votePointsTable.classList.contains("d-none")) {
				votePointsTable.classList.remove("d-none");
			}

			(function countdownFunc() {
				const nums = twitchOverlay.querySelectorAll(".nums span");
				const counter = twitchOverlay.querySelector(".counter-for-twitch");
				const finalMessage = twitchOverlay.querySelector(".final");
				const launchGameBtn = twitchOverlay.querySelector("#launchGameBtn");
				const reloadGameBtn = twitchOverlay.querySelector("#reloadGameBtn");
				votePointsBoolean = true;

				runAnimation();

				function runAnimation() {
					nums.forEach((num, index) => {
						const penultimate = nums.length - 1;
						num.addEventListener("animationend", (e) => {
							listeningForJoin = true;
							if (e.animationName === "goIn" && index !== penultimate) {
								num.classList.remove("in");
								num.classList.add("out");
							} else if (
								e.animationName === "goOut" &&
								num.nextElementSibling
							) {
								num.nextElementSibling.classList.add("in");
							} else {
								counter.classList.add("hide");
								finalMessage.classList.add("show");

								if (Object.keys(users).length < 2) {
									launchGameBtn.classList.add("d-none");
									reloadGameBtn.classList.remove("d-none");
									reloadGameBtn.addEventListener("click", () => {
										window.location.reload();
									});
									twitchOverlay.querySelector(".mode-alert").style.marginTop =
										"50px";
								} else {
									twitchOverlay.querySelector(".mode-alert")?.remove();
								}

								twitchOverlay.querySelector("#countdown").style.margin = "0";
								twitchOverlay.querySelector("h4:first-of-type").remove();
							}
						});
					});
				}

				launchGameBtn.addEventListener(
					"click",
					() => {
						if (Object.keys(users).length < 2) return false;
						window.scrollTo({ top: 0, behavior: "smooth" });

						if (!saveTwitchGameInfo && votePointsBoolean) {
							const userData = JSON.parse(localStorage.getItem("user_info"));
							const embed = {
								title: `🟣 LIVE en cours de ${twitchChannel} 🟣`,
								color: 0xa98ed6,
								description: `TopList ${topInfo.top_number} ${getTopIcon(
									topInfo.top_cat_name
								)} ${topInfo.top_title} – ${topInfo.top_question}`,
								timestamp: new Date().toISOString(),
								author: {
									url: `${SITE_BASE_URL}v/${userData.pseudo_slug_user}`,
									icon_url: userData.avatar_user
										? userData.avatar_user
										: "https://vainkeurz.com/wp-content/uploads/2023/09/avatar-rose.webp",
									name: userData.pseudo_user,
								},
								fields: [
									{
										name: "Streamer",
										value: twitchChannel,
										inline: true,
									},
									{
										name: "Mode de jeu",
										value: `Match aux points`,
										inline: true,
									},
									{
										name: "Participants",
										value: `👀 ${Object.keys(users).length}`,
										inline: true,
									},
									{
										name: "Type TopList",
										value: type_top ?? "(Inconnu)",
										inline: true,
									},
									{
										name: "Max votes possibles",
										value:
											getMaxVotesOfTopList(+topInfo.top_number, type_top) ??
											"(Inconnu)",
										inline: true,
									},
									{
										name: "À gagner",
										value: automaticTwitchGift
											? updateTableActiveRow(Object.keys(users).length)
												? updateTableActiveRow(Object.keys(users).length)
												: "(Rien :/)"
											: "(Rien :/)",
										inline: true,
									},
								],
								url: `https://www.twitch.tv/${twitchChannel}`,
								image: {
									url: "https://vainkeurz.com/wp-content/uploads/2023/09/gif-mode-game-3-twitch.gif",
								},
								footer: {
									text: "Go Participer Au Live!",
									icon_url:
										"https://vainkeurz.com/wp-content/themes/t-vkrz/assets/images/emojis/twitch.png",
								},
							};
							const messageToSend = {
								username: "NOTEURZ 🤖",
								avatar_url:
									"https://vainkeurz.com/wp-content/uploads/2022/12/boteurz-image-300x300.jpeg",
								embeds: [embed],
							};

							// SAVE DATA TO DB…
							fetch(`${API_BASE_URL}twitch/save-game`, {
								method: "POST",
								body: JSON.stringify({
									id_top: id_top,
									id_toplist:
										document.querySelector(".confirm_delete").dataset.toplistid,
									uuid_user: uuid_user,
									stream_channel: twitchChannel,
									number_participants: Object.keys(users).length,
									game_mode: 3,
									participants: Object.keys(users),
									webhook: "twitch-live",
									messageData: messageToSend,
									gift: gameGiftName,
								}),
								headers: {
									"Content-Type": "application/json",
								},
							})
								.then((response) => response.json())
								.then((data) => {
									console.log(data);
									id_twitch_game = data.id_game;

									// SHOW LINK TO GO
									const tiragaBtnContainer =
										document.querySelector(".go-to-tirage-vkrz");
									const tiragaBtn = tiragaBtnContainer.querySelector(
										".go-to-tirage-vkrz-btn"
									);
									tiragaBtnContainer.classList.remove("d-none");
									tiragaBtn.href = `${TIRAGE_VAINKEUR_URL}?streamChannel=${twitchChannel}`;
									tiragaBtn.addEventListener("click", async () => {
										const tablePointsHTML =
											document.querySelector(".table-points").outerHTML;
										const determineWinnersInTwitchGamesVar =
											determineWinnersInTwitchGames(3, tablePointsHTML);
										if (determineWinnersInTwitchGamesVar.status === "tie") {
											fetch(`${API_BASE_URL}twitch/update-participants-game`, {
												method: "POST",
												body: JSON.stringify({
													id: data.id_game,
													rest_participants:
														determineWinnersInTwitchGamesVar.winners,
												}),
												headers: { "Content-Type": "application/json" },
											})
												.then((response) => response.json())
												.then((data) => {
													console.log(data);
													if (data.status === "success") {
														tiragaBtnContainer.classList.add("d-none");
													}
												});
										}
									});
								})
								.catch((error) =>
									console.error("Error sending message:", error)
								);
						}

						twitchOverlay.classList.add("d-none");
						listeningForCount = true;
						listeningForJoin = false;
					},
					{ once: true }
				);
			})();
		}

		gameModesBtns.forEach((button) => {
			button.addEventListener("click", function () {
				const wasAlreadySelected =
					button.classList.contains("selectedGameMode");
				gameModesBtns.forEach((btn) =>
					btn.classList.remove("selectedGameMode")
				);

				if (!wasAlreadySelected) {
					button.classList.add("selectedGameMode");
				}

				updateTwitchGiftModeUIBasedOnSelectedMode();

				// Store or remove the game mode from localStorage based on selection
				if (document.querySelector(".selectedGameMode")) {
					localStorage.setItem("twitchGameMode", button.id);
				} else {
					localStorage.removeItem("twitchGameMode");
				}
			});
		});

		function updateTwitchGiftModeUIBasedOnSelectedMode() {
			const selectedMode = document.querySelector(".selectedGameMode");

			// Set visibility based on whether a mode is selected
			if (selectedMode) {
				document
					.querySelectorAll("#begin_t")
					.forEach((btn) => btn.classList.add("pulsate"));
				switch (selectedMode.id) {
					case "voteParticipatif":
						setupParticipatif();
						break;
					case "votePrediction":
						setupPrediction();
						break;
					case "votePoints":
						setupPoints();
						break;
				}
				handleTwitchGiftVisibility(
					automaticTwitchGiftTop1,
					automaticTwitchGiftTop3,
					automaticTwitchGiftTopComplet,
					true
				);
			} else {
				document
					.querySelectorAll("#begin_t")
					.forEach((btn) => btn.classList.remove("pulsate"));
				document
					.querySelector(".twitch-votes-container")
					.classList.add("d-none");
				resetDefaults();
				handleTwitchGiftVisibility(
					automaticTwitchGiftTop1,
					automaticTwitchGiftTop3,
					automaticTwitchGiftTopComplet,
					false
				);
			}
		}

		function handleTwitchGiftVisibility(
			automaticTwitchGiftTop1,
			automaticTwitchGiftTop3,
			automaticTwitchGiftTopComplet,
			isVisible
		) {
			if (voteParticipatifBoolean) {
				document
					.querySelectorAll(".va-twitch-gift-game-typetop")
					.forEach((el) => el.classList.add("d-none"));
				return;
			}

			const action = isVisible ? "remove" : "add";
			if (automaticTwitchGiftTop1) {
				document
					.querySelector(".va-twitch-gift-game-typetop-1")
					.classList[action]("d-none");
			}
			if (automaticTwitchGiftTop3) {
				document
					.querySelector(".va-twitch-gift-game-typetop-3")
					.classList[action]("d-none");
			}
			if (automaticTwitchGiftTopComplet) {
				document
					.querySelector(".va-twitch-gift-game-typetop-complet")
					.classList[action]("d-none");
			}
		}
	}
};
handleTwitchGames(automaticTwitchGift);

// tmi.js
const client = new tmi.Client({ channels: [twitchChannel] });
client.connect();
client.on("message", (channel, tags, message, self) => {
	if (self) return;
	const { username } = tags;

	if (voteParticipatifBoolean) {
		if (
			twitchChannel !== username &&
			!users.hasOwnProperty(username) &&
			(message === "1" || message === "2")
		) {
			users[username] = true;
			usersNumberForParticipatifMode = usersNumberForParticipatifMode + 1;
			X = X + 1;
			votesNumber.textContent = X;
			totalVotesNumber.textContent = +totalVotesNumber.textContent + 1;
			if (X > 1) votesNumberWording.textContent = "Votes";
			if (message === "1") {
				A = A + 1;
				contenderOneVotesPercent.textContent = Math.round((A * 100) / X) + "%";
				contenderTwoVotesPercent.textContent =
					Math.round(100 - Math.round((A * 100) / X)) + "%";
			} else if (message === "2") {
				B = B + 1;
				contenderOneVotesPercent.textContent = Math.round((A * 100) / X) + "%";
				contenderTwoVotesPercent.textContent =
					Math.round(100 - Math.round((A * 100) / X)) + "%";
			}
			if (A > B) {
				document.querySelector(".contender-1-votes-twitch").style.transform =
					"scale(1.05)";
				document.querySelector(".contender-2-votes-twitch").style.transform =
					"scale(0.95)";

				document.querySelector("#votes-stats-1").classList.add("active");
				document.querySelector("#votes-stats-2").classList.remove("active");
			} else if (A == B) {
				document.querySelector(".contender-2-votes-twitch").style.transform =
					"scale(1)";
				document.querySelector(".contender-1-votes-twitch").style.transform =
					"scale(1)";

				document.querySelector("#votes-stats-1").classList.add("active");
				document.querySelector("#votes-stats-2").classList.add("active");
			} else {
				document.querySelector(".contender-2-votes-twitch").style.transform =
					"scale(1.05)";
				document.querySelector(".contender-1-votes-twitch").style.transform =
					"scale(0.95)";

				document.querySelector("#votes-stats-2").classList.add("active");
				document.querySelector("#votes-stats-1").classList.remove("active");
			}
		}
	} else if (votePredictionBoolean) {
		// GET THE PARTICIPANTS FIRST…
		if (
			votePredictionBoolean &&
			listeningForCount === false &&
			listeningForJoin === true &&
			message.toLowerCase() === "toplist" &&
			twitchChannel !== username &&
			!users.hasOwnProperty(username)
		) {
			users[username] = { ...true, voted: false };
			const participants = document.querySelector("#participants-overlay");
			participants.classList.remove("d-none");
			if (Object.keys(users).length < 25) {
				if (Object.keys(users).length > 1) {
					participants.dataset.content = `${
						Object.keys(users).length
					} Participants :`;
				} else {
					participants.dataset.content = `${
						Object.keys(users).length
					} Participant :`;
				}
				participants.textContent = Object.keys(users).join(", "); // SHOW PARTICIPANTS…
			} else {
				participants.dataset.content = ``;

				// RANDOM PARTICIPANTS…
				let randomParticipants = [];
				while (randomParticipants.length < 25) {
					let random =
						Math.floor(Math.random() * Object.keys(users).length + 1) - 1;
					if (randomParticipants.indexOf(random) === -1)
						randomParticipants.push(random);
				}
				participants.innerHTML = `
          ${
						Object.keys(users)[randomParticipants[1]] === username
							? Object.keys(users)[randomParticipants[2]]
							: Object.keys(users)[randomParticipants[1]]
					}, ${
					Object.keys(users)[randomParticipants[3]] === username
						? Object.keys(users)[randomParticipants[4]]
						: Object.keys(users)[randomParticipants[3]]
				}, ${username} et ${
					Object.keys(users).length - 3
				} autres participants… <span class="va va-man-raising va-lg" style="vertical-align: sub !important;"></span>
        `;
			}
			preditcionParticipantsNumber.textContent = Object.keys(users).length;
			// ADD TO THE TABLE…
			userListItem = `<div class="card-element" id="vkrz-${username}">${username}</div>`;
			participantsDOM.insertAdjacentHTML("afterbegin", userListItem);
			if (Object.keys(users).length >= 2) {
				$(".mode-alert").animate({ opacity: 0 }); // REMOVE THE ALERT IF THERE IS MORE THAN 2 PARTICIPANTS…
				if (
					document.querySelector("#launchGameBtn").classList.contains("d-none")
				) {
					document.querySelector("#launchGameBtn").classList.remove("d-none");
				}
				if (
					!document.querySelector("#reloadGameBtn").classList.contains("d-none")
				) {
					document.querySelector("#reloadGameBtn").classList.add("d-none");
				}
			}
			gameGiftName = updateTableActiveRow(Object.keys(users).length);
		}

		// DEALING WITH VOTES…
		if (
			listeningForCount === true &&
			listeningForJoin === false &&
			twitchChannel !== username &&
			users.hasOwnProperty(username) &&
			!users[username].voted &&
			winnerAlready === false &&
			(message === "1" || message === "2")
		) {
			document
				.querySelector(`#prediction-player [id='vkrz-${username}']`)
				.classList.add("text-primary");
			preditcionParticipantsVotedNumber.textContent =
				+preditcionParticipantsVotedNumber.textContent + 1;
			if (message === "1") {
				users[tags.username] = { side: "1", voted: true };
			} else if (message === "2") {
				users[tags.username] = { side: "2", voted: true };
			}
		}
	} else if (votePointsBoolean) {
		// GET THE PARTICIPANTS FIRST…
		if (
			votePointsBoolean &&
			listeningForCount === false &&
			listeningForJoin === true &&
			message.toLowerCase() === "toplist" &&
			twitchChannel !== username &&
			!users.hasOwnProperty(username)
		) {
			users[username] = { ...true, voted: false };

			const participants = document.querySelector("#participants-overlay");
			participants.classList.remove("d-none");
			if (Object.keys(users).length < 25) {
				if (Object.keys(users).length > 1) {
					participants.dataset.content = `${
						Object.keys(users).length
					} Participants :`;
				} else {
					participants.dataset.content = `${
						Object.keys(users).length
					} Participant :`;
				}
				participants.textContent = Object.keys(users).join(", "); // SHOW PARTICIPANTS…
			} else {
				participants.dataset.content = ``;

				// RANDOM PARTICIPANTS…
				let randomParticipants = [];
				while (randomParticipants.length < 25) {
					let random =
						Math.floor(Math.random() * Object.keys(users).length + 1) - 1;
					if (randomParticipants.indexOf(random) === -1)
						randomParticipants.push(random);
				}
				participants.innerHTML = `
          ${
						Object.keys(users)[randomParticipants[1]] === username
							? Object.keys(users)[randomParticipants[2]]
							: Object.keys(users)[randomParticipants[1]]
					}, ${
					Object.keys(users)[randomParticipants[3]] === username
						? Object.keys(users)[randomParticipants[4]]
						: Object.keys(users)[randomParticipants[3]]
				}, ${username} et ${
					Object.keys(users).length - 3
				} autres participants… <span class="va va-man-raising va-lg" style="vertical-align: sub !important;"></span>
        `;
			}
			pointsParticipantsNumber.textContent = Object.keys(users).length;
			if (Object.keys(users).length >= 2) {
				$(".mode-alert").animate({ opacity: 0 }); // REMOVE THE ALERT IF THERE IS MORE THAN 2 PARTICIPANTS…
				if (
					document.querySelector("#launchGameBtn").classList.contains("d-none")
				) {
					document.querySelector("#launchGameBtn").classList.remove("d-none");
				}
				if (
					!document.querySelector("#reloadGameBtn").classList.contains("d-none")
				) {
					document.querySelector("#reloadGameBtn").classList.add("d-none");
				}
			}
			gameGiftName = updateTableActiveRow(Object.keys(users).length);
			switch (position) {
				case 1:
					positionStr = '<span class="ico va va-medal-1 va-lg"></span>';
					break;
				case 2:
					positionStr = '<span class="ico va va-medal-2 va-lg"></span>';
					break;
				case 3:
					positionStr = '<span class="ico va va-medal-3 va-lg"></span>';
					break;
				default:
					positionStr = position;
			}
			userListItem = `
        <tr id="vkrz-${username}">
          <td>${positionStr}</td>
          <td>${username}</td>
          <td data-order="0">0</td>
        </tr>
      `;
			votePointsTBody.insertAdjacentHTML("beforeend", userListItem);
			position++;
		}

		// DEALING WITH VOTES…
		if (
			listeningForCount === true &&
			listeningForJoin === false &&
			twitchChannel !== username &&
			users.hasOwnProperty(username) &&
			!users[username].voted &&
			(message === "1" || message === "2")
		) {
			document
				.querySelector(
					`#ranking-player [id='vkrz-${username}'] td:nth-of-type(2)`
				)
				.classList.add("voted");
			pointsParticipantsVotedNumber.textContent =
				+pointsParticipantsVotedNumber.textContent + 1;
			if (message === "1") {
				users[tags.username] = { side: "1", voted: true };
			} else if (message === "2") {
				users[tags.username] = { side: "2", voted: true };
			}
		}
	}
});
