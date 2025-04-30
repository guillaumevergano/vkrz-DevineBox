const BASE_RELPATH = env === 'local' ? '/vkrz-wp/'
  : env === 'proto' ? 'https://proto.vainkeurz.com/'
    : 'https://vainkeurz.com/';

let apiKey, authDomain, projectId, storageBucket, messagingSenderId, appId, measurementId;

if (env === 'local') {
  apiKey = "AIzaSyDPm---LJVXSioVvwOSDXB2ChHPo5h1LFw";
  authDomain = "vkrz-local.firebaseapp.com";
  projectId = "vkrz-local";
  storageBucket = "vkrz-local.appspot.com";
  messagingSenderId = "373147830938";
  appId = "1:373147830938:web:2fed06bcd2370f1c2eed23";
} else if (env === 'proto') {
  apiKey = "AIzaSyB4SXmzcNWLlCNCpT_UMks48uwzMAAyFwk";
  authDomain = "vkrz-proto.firebaseapp.com";
  projectId = "vkrz-proto";
  storageBucket = "vkrz-proto.appspot.com";
  messagingSenderId = "573269516803";
  appId = "1:573269516803:web:607e7b7f2ae5d9c21a6436";
} else if (env === 'prod') {
  apiKey = "AIzaSyC61voM-ZcxW2Gr15Dj27s3F80ARA3KjhA";
  authDomain = "vainkeurz2.firebaseapp.com";
  projectId = "vainkeurz2";
  storageBucket = "vainkeurz2.appspot.com";
  messagingSenderId = "270466740907";
  appId = "1:270466740907:web:ed722b9a43901161647dee";
}

const firebaseConfig = {
	apiKey: apiKey,
	authDomain: authDomain,
	projectId: projectId,
	storageBucket: storageBucket,
	messagingSenderId: messagingSenderId,
	appId: appId,
};

const app = firebase.initializeApp(firebaseConfig);

const User = () => firebase.auth().currentUser;

const checkUserConnected = () => {
	const user = User();

	if (user !== null && user.email !== "") {
		localStorage.setItem("userConnected", true);
		return user;
	} else return false;
};

const setCookie = (name, value, days) => {
	const date = new Date();
	date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
	const expires = "; expires=" + date.toUTCString();
	document.cookie =
		name + "=" + encodeURIComponent(value) + expires + "; path=/";
};

const removeCookie = (name) => {
	setCookie(name, "", -1);
};

const onConnected = () => {
	const checkUser = checkUserConnected();

	if (checkUser) {
		const userConnectedToken = checkUser.uid;
		const userConnectedEmail = checkUser.email;

		const checkUserInDB = async (email) => {
			try {
				const response = await fetch(`${API_BASE_URL}user-list/checkemail`, {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
					},
					body: JSON.stringify({ email }),
				});

				if (response.ok) {
					const data = await response.json();

					if (data.email_exists) {
						const uuid_user_storage = data.data_user.uuid_user;
						uuid_user = data.data_user.uuid_user;
						setCookie("user-connected-uuid", uuid_user_storage, 1);
						localStorage.setItem("user-connected-uuid", uuid_user_storage);
						if (data.data_user.token_firebase_user === null) {
							await updateTokenFirebaseUser(
								userConnectedToken,
								userConnectedEmail
							);
						}
						return uuid_user_storage;
					} else {
						// If user saved in Firebase but not in database
						const providerId = checkUser.providerData[0].providerId;
						if (checkUser.displayName && providerId) {
							let pseudo = checkUser.displayName;
							let originalPseudo = pseudo;
							let counter = 1;
							while (await checkPseudoExists(pseudo)) {
								pseudo = originalPseudo + counter;
								counter++;
							}

							let codeParrain = null;
							if (localStorage.getItem("code_invitation")) {
								let codeParrainStorage =
									localStorage.getItem("code_invitation");
								codeParrain = codeParrainStorage;
								localStorage.removeItem("code_invitation");
							} else {
								if (document.getElementById("register_codeparrain"))
									codeParrain = document.getElementById(
										"register_codeparrain"
									).value;
							}
							console.log("codeParrain-1", codeParrain);
							await createUserSQL(
								uuid_user,
								userConnectedEmail,
								pseudo,
								codeParrain,
								userConnectedToken,
								providerId
							);
							return uuid_user;
						}
					}
				} else {
					console.log("Error fetching user data:", response.status);
					return null;
				}
			} catch (error) {
				console.error("Error fetching user data:", error);
				return null;
			}
		};

		checkUserInDB(userConnectedEmail).then(async (uuid_user) => {
			if (uuid_user) {
				get_user_data_infos(uuid_user);
				await display_user_data();
				const notConnectedElements = document.querySelectorAll(".notconnected");
				for (let i = 0; i < notConnectedElements.length; i++) { notConnectedElements[i].classList.add("d-none"); }
				const isConnectedElements = document.querySelectorAll(".isconnected");
				for (let i = 0; i < isConnectedElements.length; i++) { isConnectedElements[i].classList.add("d-block"); }
			} else {
				console.log("User not connected");
			}
		});
	} else {
		display_user_data_not_logged();
		localStorage.removeItem("user-connected-uuid");
		localStorage.removeItem("userConnected");
		const notConnectedElements = document.querySelectorAll(".notconnected");
		for (let i = 0; i < notConnectedElements.length; i++) { notConnectedElements[i].classList.add("d-block"); }
		const isConnectedElements = document.querySelectorAll(".isconnected");
		for (let i = 0; i < isConnectedElements.length; i++) { isConnectedElements[i].classList.add("d-none"); }
		document.querySelector('.cta-connexion').classList.remove('d-none');
	}

	if (
		(window.location.pathname.includes("connexion") ||
			window.location.pathname.includes("inscription")) &&
		checkUser.email
	) {
		if (window.location.pathname.includes("inscription")) {
			if (
				document.getElementById("register_pseudo").value === "" &&
				document.getElementById("register_email").value === "" &&
				document.getElementById("register_pwd").value === ""
			) {
				window.location = BASE_RELPATH; // REDIRECTION TO HOME PAGE BECAUSE IT'S CONNECTED
			}
		} else {
			window.location = BASE_RELPATH; // REDIRECTION TO HOME PAGE BECAUSE IT'S CONNECTED
		}
	}
};

firebase.auth().onAuthStateChanged(onConnected); // LOGIN ON PAGE LOAD

// FUNCTIONS HELPERS FOR AUTH
const checkPseudoExists = async (pseudo) => {
	const pseudosResponse = await fetch(
		`${API_BASE_URL}user-list/get-all-pseudo?pseudo=${encodeURIComponent(pseudo)}`,
		{
			method: "GET",
			headers: { "Content-Type": "application/json" },
		}
	);
	if (pseudosResponse.ok) {
		const pseudosData = await pseudosResponse.json();
		return pseudosData.includes(pseudo.toLowerCase()); // Return boolean: true if exists, false otherwise
	} else {
		console.error("Error:", pseudosResponse.status, pseudosResponse.statusText);
		throw new Error("Error fetching pseudos"); // Throws an error to catch later
	}
};

const checkEmailExists = async (email) => {
	const emailsResponse = await fetch(API_BASE_URL + "user-list/get-all-email", {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
	});
	if (emailsResponse.ok) {
		const emailsData = await emailsResponse.json();
		if (emailsData.includes(email)) {
			throw new Error("cet email existe déjà :/");
		}
	} else {
		console.error("Error:", emailsResponse.status, emailsResponse.statusText);
	}
};

async function isEmailExists(email) {
	endpointEmail = `${API_BASE_URL}user-list/checkemail`;
	return fetch(endpointEmail, {
		method: "POST",
		headers: { "Content-Type": "application/json" },
		body: JSON.stringify({ email: email }),
	}).then((response) => response.json());
}

async function getOrCreateFirebaseUser(email, password, pseudo_user) {
	let userCredential;

	try {
		userCredential = await firebase
			.auth()
			.createUserWithEmailAndPassword(email, password);
		await userCredential.user.updateProfile({ displayName: pseudo_user });
	} catch (error) {
		if (error.code === "auth/email-already-in-use") {
			userCredential = await firebase
				.auth()
				.signInWithEmailAndPassword(email, password);
		} else {
			throw error;
		}
	}

	return userCredential.user.uid;
}

async function updateTokenFirebaseUser(token_firebase_user, email) {
	return fetch(`${API_BASE_URL}user-list/update-token`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({
			token_firebase_user: token_firebase_user,
			email_user: email,
		}),
	}).then((response) => response.json());
}

// REGISTER USER IN FIREBASE
const createUserFirebase = async (
	uuid_user,
	pseudo,
	email,
	password,
	codeParrain
) => {
	let token_firebase_user;

	try {
		const pseudosResponse = await fetch(
			`${API_BASE_URL}user-list/get-all-pseudo`,
			{
				method: "GET",
				headers: {
					"Content-Type": "application/json",
				},
			}
		);

		if (pseudosResponse.ok) {
			const pseudosData = await pseudosResponse.json();
			if (pseudosData.includes(pseudo.toLowerCase())) {
				throw new Error("Pseudo already exists");
			}
		} else {
			console.error(
				"Error:",
				pseudosResponse.status,
				pseudosResponse.statusText
			);
		}

		// FIREBASE SIGNUP
		const userCredential = await firebase
			.auth()
			.createUserWithEmailAndPassword(email, password);
		token_firebase_user = userCredential.user.uid;
		await userCredential.user.updateProfile({ displayName: pseudo });

		// CREATE USER IN DATABASE
		await createUserSQL(
			uuid_user,
			email,
			pseudo,
			codeParrain,
			token_firebase_user,
			"email"
		);
	} catch (error) {
		setMessage(error); // If an error occurred, display the error message.
	}
};

// CREATE USER IN DATABASE
const createUserSQL = async (
	uuidUser,
	email,
	pseudo,
	codeParrain,
	tokenFirebaseUser,
	providerUser
) => {

	pseudo_slug_user = createSlug(pseudo);

	if (localStorage.getItem("code_invitation")) {
		let codeParrainStorage = localStorage.getItem("code_invitation");
		codeParrain = codeParrainStorage;
		localStorage.removeItem("code_invitation");
	} else {
		if(document.getElementById("register_codeparrain"))
			codeParrain = document.getElementById("register_codeparrain").value;
	}

	const data = {
		uuid_user: uuidUser,
		token_firebase_user: tokenFirebaseUser,
		email_user: email,
		pseudo_user: pseudo,
		pseudo_slug_user: pseudo_slug_user,
		parrained_by: codeParrain,
		provider_user: providerUser,
	};

	fetch(`${API_BASE_URL}user-list/new`, {
		method: "POST",
		headers: { "Content-Type": "application/json", },
		body: JSON.stringify(data),
	})
		.then(async (response) => {
			if (!response.ok) {
				const text = await response.text();
				console.error("Raw response:", text);
				throw new Error("Erreur lors de la création de l'utilisateur");
			}
			return response.json();
		})
		.then(async (data) => {
			console.log("Utilisateur créé avec succès :", data);

			if (data.parrainnage === "Nouveau parrainage") {
				document.getElementById("errorlogin").innerHTML = `
          Tu es bien parrainé pour <b>${data.parrain}</b>, les 500 <span class="va-gem va va-1x"></span> sont bien à toi.
        `;
				document.querySelector(".alertform").style.display = "block";

				setTimeout(() => {
					refresh_user_data(uuidUser);
          if(redirectURL){
            window.location = redirectURL;
          }
				}, 3000);
			} else if (data.parrainnage === "No user found with the provided parrain code") {
				document.getElementById("errorlogin").innerHTML = `
					Inscription réussie ! Cependant, il semble qu'il n'y ait aucun parrain associé au code <b>${codeParrain}</b>
        `;
				document.querySelector(".alertform").style.color = "#c44e21";
				document.querySelector(".alertform").style.display = "block";

				setTimeout(() => {
					refresh_user_data(uuidUser);
					window.location = redirectURL;
				}, 4500);
			} else {
				refresh_user_data(uuidUser);
				window.location = redirectURL;
			}
		})
		.catch((error) => {
			console.error("Erreur :", error);
		});
};

// UPDATE USER IN DATABASE
const updateUserSQL = (userData) => {
	const endpoint = API_BASE_URL + "user-list/update";

	fetch(endpoint, {
		method: "PATCH",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify(userData),
	})
		.then((response) => response.json())
		.then(async (data) => {
			console.log("Success:", data);

			localStorage.removeItem("user_info");
			localStorage.removeItem("user_data");

			await get_user_data_infos(uuid_user);
		})
		.catch((error) => {
			console.error("Error:", error);
		});
};

// LOGIN WITH FIREBASEUI PROVIDERS
if (
	window.location.pathname.includes("connexion") ||
	window.location.pathname.includes("inscription")
) {
	const fui = new firebaseui.auth.AuthUI(firebase.auth());

	fui.start("#firebase-connexion-wrapper", {
		signInOptions: [
			firebase.auth.GoogleAuthProvider.PROVIDER_ID
		],
		signInFlow: "popup",
		callbacks: {
			signInSuccessWithAuthResult: async function (authResult, redirectUrl) {
				const user = authResult.user;
				const isNewUser = authResult.additionalUserInfo.isNewUser;
				const providerId = authResult.additionalUserInfo.providerId;
				const email = user.email;
				let pseudo = user.displayName;
				let originalPseudo = pseudo;
				let counter = 1;
				while (await checkPseudoExists(pseudo)) {
					pseudo = originalPseudo + counter;
					counter++;
				}

				const emailResponse = await isEmailExists(email);

				// if (emailResponse.email_exists) {
				// 	if (emailResponse.data_user.token_firebase_user === null) {
				// 		const updateResponse = await updateTokenFirebaseUser(
				// 			user.uid,
				// 			email
				// 		);
				// 		if (
				// 			updateResponse.message ==
				// 			"Token utilisateur mis à jour avec succès"
				// 		) {
				// 			refresh_user_data(emailResponse.data_user.uuid_user);
				// 			return true;
				// 		} else {
				// 			setMessage("Erreur lors de la mise à jour du Token Firebase");
				// 			return false;
				// 		}
				// 	}
				// } else {
				// 	if (localStorage.getItem("code_invitation")) {
				// 		let codeParrainStorage = localStorage.getItem("code_invitation");
				// 		codeParrain = codeParrainStorage;
				// 		localStorage.removeItem("code_invitation");
				// 	} else {
				// 		if (document.getElementById("register_codeparrain"))
				// 			codeParrain = document.getElementById(
				// 				"register_codeparrain"
				// 			).value;
				// 	}
				// 	console.log("codeParrain-2", codeParrain);
		
				// 	await createUserSQL(
				// 		uuid_user,
				// 		email,
				// 		pseudo,
				// 		codeParrain,
				// 		user.uid,
				// 		providerId
				// 	);
				// }
			},
			signInFailure: function (error) {
				console.error("Erreur lors de la connexion :", error);
				setMessage(error.message);
				return false;
			},
		},
		signInSuccessUrl: redirectURL ? redirectURL : BASE_RELPATH,
	});

	setTimeout(() => {
		const googleButton = document.querySelector(".firebaseui-idp-google .firebaseui-idp-text-long");
		
		if (googleButton) {
				let buttonText;
				
				switch (WeglotData.lang) {
						case "fr":
								buttonText = "Connexion avec Google";
								break;
						case "br-pt":
								buttonText = "Entrar com o Google";
								break;
						case "es":
								buttonText = "Iniciar sesión con Google";
								break;
						case "it":
								buttonText = "Accedi con Google";
								break;
						case "ja":
								buttonText = "Googleでログイン";
								break;
						default:
								buttonText = "Sign in with Google"; // Default to English
								break;
				}
	
				googleButton.innerText = buttonText;
		}
	}, 1000);
}

// LOGIN
const logIn = (email, password) => {
	const submitBtn = document.querySelector(".submit-form-btn");
	const submitBtnTxt = submitBtn.querySelector(".submit-form-btn-txt");
	const submitBtnLoader = submitBtn.querySelector(".submit-form-btn-loader");

	firebase
		.auth()
		.signInWithEmailAndPassword(email, password)
		.then((userCredential) => {
			if (!redirectURL) redirectURL = BASE_RELPATH;
			window.location = redirectURL;
		})
		.catch((error) => {
			console.log(error)
			submitBtnTxt.classList.remove("d-none");
			submitBtnLoader.classList.add("d-none");
			setMessage(error);
		});
};

// LOGOUT
const logOut = () => {
	firebase
		.auth()
		.signOut()
		.then(() => {
			window.location = BASE_RELPATH;
			removeCookie("user-connected-uuid");
			removeCookie("wordpress_vainkeurz_uuid_cookie");
			clear_user_data();
		})
		.catch((error) => {
			alert(error.message);
		});
};

// DEAL ERRORS
const setMessage = (error) => {
	let message = error.message || error;
	if (error.code) {
		// handle specific error codes
		switch (error.code) {
			case "auth/email-already-in-use":
				message = "Cette adresse email est déjà utilisée";
				break;
			case "auth/invalid-email":
				message = "Cette adresse email n'est pas valide";
				break;
			case "auth/weak-password":
				message = "Le mot de passe doit contenir au moins 6 caractères";
				break;
			case "auth/wrong-password":
				message = "Le mot de passe est incorrect :/";
				break;
			case "auth/network-request-failed":
				message = "Le mot de passe est incorrect :/";
				break;
			case "auth/user-not-found":
				message = "Cette adresse email n'est pas enregistrée";
				break;
			default:
				message = "Une erreur est survenue: " + error.code;
				break;
		}
	} else if (error.message === "Pseudo already exists") {
		message = "Ce pseudo est déjà utilisé";
	}

	console.log(message);
	document.getElementById("errorlogin").innerHTML = message;
	document.querySelector(".alertform").style.display = "block";
};

const callApiWithToken = ({ url, method, json, success, error }) => {
	const user = User();
	if (!user) error("not.connected");

	user.getIdToken({ forceRefresh: true }).then((token) => {
		let headers = { Authorization: "Bearer " + token };
		if (json) {
			headers["Content-Type"] = "application/json";
		}

		fetch(API_BASE_URL + url, {
			method: method,
			body: JSON.stringify(json),
			headers: headers,
		})
			.then((response) => response.json())
			.then(success)
			.catch(error);
	});
};

// DOM LAUNCHERS: REGISTER, LOGIN, UPDATE USER SETTINGS & LOGOUT
document.addEventListener("DOMContentLoaded", function () {
	if (document.getElementById("emailpass-update-user")) {
		let checkUserIsConnected = localStorage.getItem("userConnected");
		const userData = localStorage.getItem("user_info");
		const userInfos = JSON.parse(userData);

		if (
			checkUserIsConnected === "true" &&
			userInfos !== null &&
			userInfos.email_user !== null &&
			userInfos.email_user !== undefined
		) {
			document.querySelector("#email-user-field").value = userInfos.email_user;
		}

		document
			.getElementById("emailpass-update-user")
			.addEventListener("submit", async function (e) {
				e.preventDefault();

				const validation = document.querySelector(".validation3");
				const email = document.querySelector("#email-user-field").value;
				const currentPassword = document.querySelector(
					"#current-password-user-field"
				).value;
				const newPassword = document.querySelector(
					"#new-password-user-field"
				).value;

				const checkUser = checkUserConnected();
				if (!checkUser) {
					clear_user_data();
					window.location = BASE_RELPATH + "connexion";
					return;
				}

				const user = firebase.auth().currentUser;
				const credential = firebase.auth.EmailAuthProvider.credential(
					user.email,
					currentPassword
				);

				let userData = {
					token_firebase_user: checkUser.uid,
					email_user: email,
				};

				// Update password only
				if (user.email === email && newPassword) {
					user
						.reauthenticateWithCredential(credential)
						.then(() => {
							// Prompt the user to sign in again
							return firebase
								.auth()
								.signInWithEmailAndPassword(user.email, currentPassword);
						})
						.then(() => {
							// User reauthenticated, now change the password
							return user.updatePassword(newPassword);
						})
						.then(() => {
							console.log("Password has been changed successfully");
							// Add code to handle success (e.g., display a success message)
							document.querySelector(".alertform").style.display = "none";

							validation.style.display = "inline";
							validation.classList.add(
								"animate__animated",
								"animate__lightSpeedInLeft"
							);

							validation.addEventListener("animationend", () => {
								validation.classList.remove(
									"animate__animated",
									"animate__lightSpeedInLeft"
								);
								setTimeout(() => {
									validation.style.display = "none";
								}, 2000);
							});
						})
						.catch((error) => {
							console.error("Error changing password:", error);
							// Add code to handle errors (e.g., display an error message)
							setMessage(error);
						});
				}

				// Update email only
				if (user.email !== email) {
					user
						.reauthenticateWithCredential(credential)
						.then(() => {
							// User reauthenticated, now change the email
							return user.updateEmail(email);
						})
						.then(() => {
							console.log("Email has been changed successfully");
							// Add code to handle success (e.g., display a success message)
							updateUserSQL(userData);
							document.querySelector(".alertform").style.display = "none";

							validation.style.display = "inline";
							validation.classList.add(
								"animate__animated",
								"animate__lightSpeedInLeft"
							);

							validation.addEventListener("animationend", () => {
								validation.classList.remove(
									"animate__animated",
									"animate__lightSpeedInLeft"
								);
								setTimeout(() => {
									validation.style.display = "none";
								}, 2000);
							});
						})
						.catch((error) => {
							// Catch the 'auth/requires-recent-login' error here
							if (error.code === "auth/requires-recent-login") {
								// Display a message that informs the user to re-authenticate
								console.log(
									"For security reasons, please reauthenticate to continue."
								);
							} else {
								console.error("Error changing email:", error);
								// Add code to handle errors (e.g., display an error message)
								setMessage(error);
							}
						});
				}

				// Update both email and password
				if (user.email !== email && newPassword) {
					user
						.reauthenticateWithCredential(credential)
						.then(() => {
							// Prompt the user to sign in again
							return firebase
								.auth()
								.signInWithEmailAndPassword(user.email, currentPassword);
						})
						.then(() => {
							// User reauthenticated, now change the email and password
							return Promise.all([
								user.updateEmail(email),
								user.updatePassword(newPassword),
							]);
						})
						.then(() => {
							console.log("Email and password have been changed successfully");
							// Add code to handle success (e.g., display a success message)
							updateUserSQL(userData);
							document.querySelector(".alertform").style.display = "none";

							validation.style.display = "inline";
							validation.classList.add(
								"animate__animated",
								"animate__lightSpeedInLeft"
							);

							validation.addEventListener("animationend", () => {
								validation.classList.remove(
									"animate__animated",
									"animate__lightSpeedInLeft"
								);
								setTimeout(() => {
									validation.style.display = "none";
								}, 2000);
							});
						})
						.catch((error) => {
							console.error("Error changing email and password:", error);
							// Add code to handle errors (e.g., display an error message)
							setMessage(error);
						});
				}
			});
	}

	if (document.getElementById("infos-generales-user"))
		document
			.getElementById("infos-generales-user")
			.addEventListener("submit", async function (e) {
				e.preventDefault();

				const validation = document.querySelector(".validation");
				let avatar_user = document.getElementById("upload").files[0];
				let cover_user = document.getElementById("uploadcover").files[0];
				let pseudo_user = document.getElementById("pseudo-user-field").value;
				let description_user = document.getElementById(
					"description-user-field"
				).value;

				async function uploadPhoto(file) {
					const storageRef = firebase.storage().ref();
					const photoRef = storageRef.child(`profile_photos/${pseudo_user}`);

					const snapshot = await photoRef.put(file);
					const photoURL = await snapshot.ref.getDownloadURL();
					return photoURL;
				}
				async function uploadCover(file) {
					const storageRef = firebase.storage().ref();
					const coverRef = storageRef.child(`profile_cover/${pseudo_user}`);

					const snapshot = await coverRef.put(file);
					const coverURL = await snapshot.ref.getDownloadURL();
					return coverURL;
				}

				const checkUser = checkUserConnected();
				if (!checkUser) return;

				if (checkUser) {
					const promises = [];
					let photoURL;
					let coverURL;

					if (pseudo_user) {
						promises.push(
							checkUser.updateProfile({ displayName: pseudo_user })
						);
					}

					if (avatar_user) {
						photoURL = await uploadPhoto(avatar_user);
						promises.push(checkUser.updateProfile({ photoURL }));
					}
					if (cover_user) {
						coverURL = await uploadCover(cover_user);
						promises.push(checkUser.updateProfile({ coverURL }));
					}

					console.log("photoURL", photoURL);
					console.log("coverURL", coverURL);

					Promise.all(promises)
						.then(() => {
							let userData = {
								token_firebase_user: checkUser.uid,
								avatar_user: photoURL,
								cover_user: coverURL,
								pseudo_user: pseudo_user,
								description_user: description_user,
							};

							if (photoURL) {
								document
									.querySelectorAll(".avatar-tofill")
									.forEach(function (element) {
										element.style.backgroundImage = "url('" + photoURL + "')";
									});
							}
							if (coverURL) {
								document
									.querySelectorAll(".cover-vainkeur-tofill")
									.forEach(function (element) {
										element.style.backgroundImage = `url('${coverURL}')`;
									});
							}
							document
								.querySelectorAll(".vainkeur-pseudo-tofill")
								.forEach(function (element) {
									element.innerHTML = pseudo_user;
								});

							validation.style.display = "inline";
							validation.classList.add(
								"animate__animated",
								"animate__lightSpeedInLeft"
							);

							validation.addEventListener("animationend", () => {
								validation.classList.remove(
									"animate__animated",
									"animate__lightSpeedInLeft"
								);
								setTimeout(() => {
									validation.style.display = "none";
								}, 2000);
							});

							localStorage.removeItem("user_info");
							localStorage.removeItem("user_data");

							updateUserSQL(userData);
						})
						.catch((error) => {
							console.error("Error updating profile:", error);
						});
				} else {
					console.error("User not logged in");
				}
			});

	if (document.getElementById("infos-networks-user"))
		document
			.getElementById("infos-networks-user")
			.addEventListener("submit", async function (e) {
				e.preventDefault();

				const validation2 = document.querySelector(".validation2");
				let twitch_user = document
					.getElementById("twitch-user-field")
					.value.trim();
				twitch_user = twitch_user === "" ? null : twitch_user;
				let youtube_user = document
					.getElementById("youtube-user-field")
					.value.trim();
				let insta_user = document
					.getElementById("insta-user-field")
					.value.trim();
				let twitter_user = document
					.getElementById("twitter-user-field")
					.value.trim();
				let tiktok_user = document
					.getElementById("tiktok-user-field")
					.value.trim();
				let snapchat_user = document
					.getElementById("snapchat-user-field")
					.value.trim();

				const checkUser = checkUserConnected();
				if (!checkUser) return;

				if (checkUser) {
					const promises = [];

					Promise.all(promises)
						.then(() => {
							let userData = {
								token_firebase_user: checkUser.uid,
								twitch_user: twitch_user,
								youtube_user: youtube_user,
								instagram_user: insta_user,
								twitter_user: twitter_user,
								tiktok_user: tiktok_user,
								snapchat_user: snapchat_user
							};

							updateUserSQL(userData);

							validation2.style.display = "inline";
							validation2.classList.add(
								"animate__animated",
								"animate__lightSpeedInLeft"
							);

							validation2.addEventListener("animationend", () => {
								validation2.classList.remove(
									"animate__animated",
									"animate__lightSpeedInLeft"
								);
								setTimeout(() => {
									validation2.style.display = "none";
								}, 2000);
							});
						})
						.catch((error) => {
							console.error("Error updating profile:", error);
						});
				} else {
					console.error("User not logged in");
				}
			});

	
  if (document.getElementById("inscription-form")) {
	// check query string for code_invitation
	let urlParams = new URLSearchParams(window.location.search);
	let codeParrain = urlParams.get("code_invitation") || localStorage.getItem("code_invitation") || "";

	document.getElementById("register_codeparrain").value = codeParrain;
	document.getElementById("register_codeparrain").addEventListener("change", function() {
		console.log(`code_parrain: ${this.value}`);
		localStorage.setItem("code_invitation", this.value);
	});
		document
			.getElementById("inscription-form")
			.addEventListener("submit", async function (e) {
				e.preventDefault();
				const submitBtn = document.querySelector(".submit-form-btn");
				const submitBtnTxt = submitBtn.querySelector(".submit-form-btn-txt");
				const submitBtnLoader = submitBtn.querySelector(
					".submit-form-btn-loader"
				);
				submitBtnTxt.classList.add("d-none");
				submitBtnLoader.classList.remove("d-none");

				clear_user_data();

				const getSignupFormData = () => {
					return {
						uuid_user: document.getElementById("register_uuid").value,
						pseudo: document.getElementById("register_pseudo").value,
						email: document.getElementById("register_email").value,
						password: document.getElementById("register_pwd").value,
						codeParrain: document.getElementById("register_codeparrain").value,
					};
				};

				try {
					const { uuid_user, pseudo, email, password, codeParrain } =
						getSignupFormData();
					if (await checkPseudoExists(pseudo))
						throw new Error("Ce pseudo est déjà utilisé");


					const isEmailExistsResponse = await isEmailExists(email);
					if (isEmailExistsResponse.email_exists)
						throw new Error("Cet email est déjà utilisé");

					const token_firebase_user = await getOrCreateFirebaseUser(
						email,
						password,
						pseudo
					);
					if (!token_firebase_user)
						throw new Error("Erreur lors de la création du compte");

						
					await createUserSQL(
						uuid_user,
						email,
						pseudo,
						codeParrain,
						token_firebase_user,
						"email"
					);
				} catch (error) {
					submitBtnTxt.classList.remove("d-none");
					submitBtnLoader.classList.add("d-none");
					setMessage(error);
				}
			});
	}
	if (document.getElementById("connexion-form")) {
		document
			.getElementById("connexion-form")
			.addEventListener("submit", function (e) {
				e.preventDefault();
				const submitBtn = document.querySelector(".submit-form-btn");
				const submitBtnTxt = submitBtn.querySelector(".submit-form-btn-txt");
				const submitBtnLoader = submitBtn.querySelector(
					".submit-form-btn-loader"
				);
				submitBtnTxt.classList.add("d-none");
				submitBtnLoader.classList.remove("d-none");

				clear_user_data();

				function getFormData() {
					const email = document.getElementById("email").value;
					const password = document.getElementById("pwd").value;
					return { email, password };
				}
				const { email, password } = getFormData();

				isEmailExists(email).then((response) => {
					if (response.email_exists) {
						if (response.data_user.token_firebase_user === null) {
							getOrCreateFirebaseUser(
								email,
								password,
								response.data_user.pseudo_user
							)
								.then((token_firebase_user) => {
									updateTokenFirebaseUser(token_firebase_user, email)
										.then((data) => {
											if (
												data.message ===
												"Token utilisateur mis à jour avec succès"
											) {
												refresh_user_data(response.data_user.uuid_user);
												logIn(email, password);
											}
										})
										.catch((e) => {
											submitBtnTxt.classList.remove("d-none");
											submitBtnLoader.classList.add("d-none");
											setMessage(e);
										});
								})
								.catch((e) => {
									submitBtnTxt.classList.remove("d-none");
									submitBtnLoader.classList.add("d-none");
									setMessage(e);
								});
						} else {
							logIn(email, password);
						}
					} else {
						logIn(email, password);
					}
				});
			});
	}
	if (document.getElementById("deconnection_cta"))
		document
			.getElementById("deconnection_cta")
			.addEventListener("click", logOut);

	if (document.getElementById("reset-password"))
		document
			.getElementById("reset-password")
			.addEventListener("click", async function (e) {
				e.preventDefault();

				const email = document.getElementById("reset-password-email").value;
				const isEmailExistsResponse = await isEmailExists(email);

				if (isEmailExistsResponse.email_exists) {
					try {
						firebase.auth().sendPasswordResetEmail(email);
						console.log("Password reset email sent.");
						setMessage(
							"Un e-mail de réinitialisation de mot de passe t'a été envoyé. Vérifie ta boîte de réception ✅"
						);
						document.getElementById("reset-password").disabled = true;
					} catch (error) {
						console.error("Error sending password reset email: ", error);
						setMessage(`Error: ${error.message}}`);
					}
				} else {
					setMessage("S'il te plaît, entre une adresse e-mail valide que tu utilises. On veut s'assurer de t'atteindre ! ");
				}
			});

	if (document.querySelector("#passwordResetForm")) {
		const newPasswordInput 		 = document.getElementById("newPassword");
		const confirmPasswordInput = document.getElementById("confirmPassword");
		const updatePasswordBtn    = document.getElementById("updatePassword");

		updatePasswordBtn.addEventListener("click", async (event) => {
			const newPassword 		= newPasswordInput.value;
			const confirmPassword = confirmPasswordInput.value;

			if(newPassword === "" || confirmPassword === "") {
				setMessage("Entre un nouveau mot de passe et confirme-le. stp :)");
				return;
			}

			if (newPassword === confirmPassword) {
				const urlParams = new URLSearchParams(window.location.search);
				const oobCode 	= urlParams.get("oobCode");

				try {
					await firebase.auth().confirmPasswordReset(oobCode, newPassword);
					setMessage(
						"Réinitialisation de ton mot de passe réussie. Tu peux maintenant te connecter avec ton nouveau mot de passe. Tu seras redirigé vers la page de connexion dans 3 secondes. ✅"
					);
					updatePasswordBtn.disabled = true;
					setTimeout(() => {
						window.location = BASE_RELPATH + "connexion"; // Redirect to your login page
					}, 4000);
				} catch (error) {
					console.error("Error resetting password:", error);
					// alert("Error: " + error.message);
					setMessage(`Error: ${error.message}}`);
				}
			} else {
				setMessage(
					"Les mots de passe ne correspondent pas. Essaye à nouveau, stp :)"
				);
			}
		});
	}
});
