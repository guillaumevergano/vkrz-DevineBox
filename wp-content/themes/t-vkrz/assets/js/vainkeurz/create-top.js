let placeholder = "",
 placeholder2 = "";
if (WeglotData.lang === "fr") {
	placeholder = "Colle l'URL YouTube de la vidéo ici";
	placeholder2 = "Titre de la vidéo";
} else if (WeglotData.lang === "br-pt") {
	placeholder = "Cole o URL do YouTube do vídeo aqui";
	placeholder2 = "Título do vídeo";
} else if (WeglotData.lang === "es") {
	placeholder = "Coloca el URL de YouTube del video aquí";
	placeholder2 = "Título del vídeo";
} else if (WeglotData.lang === "it") {
	placeholder = "Inserisci l'URL di YouTube del video qui";
	placeholder2 = "Titolo del video";
} else if (WeglotData.lang === "ja") {
	placeholder = "ここにYouTubeのURLを貼り付けてください";
	placeholder2 = "動画のタイトル";
} else {
	placeholder = "Paste the YouTube video URL here";
	placeholder2 = "Video title";
}

const compressImage = (file, quality = 0.6) => {
	return new Promise((resolve, reject) => {
		const reader = new FileReader();
		reader.readAsDataURL(file);

		reader.onload = (event) => {
			const img = new Image();
			img.src = event.target.result;

			img.onload = () => {
				const canvas = document.createElement("canvas");
				const ctx = canvas.getContext("2d");

				// Keep original dimensions
				canvas.width = img.width;
				canvas.height = img.height;
				ctx.drawImage(img, 0, 0, img.width, img.height);

				// Convert to Blob with compression
				canvas.toBlob(
					(blob) => {
						if (blob) {
							resolve(blob);
						} else {
							reject(new Error("Compression failed"));
						}
					},
					file.type || "image/jpeg", // Use original format
					quality // Adjust quality (0.1 = high compression, 1.0 = no compression)
				);
			};

			img.onerror = (error) => reject(error);
		};

		reader.onerror = (error) => reject(error);
	});
};

const normalizeString = (str) => {
	const accentMap = {
		à: "a",
		á: "a",
		â: "a",
		ã: "a",
		ä: "a",
		å: "a",
		æ: "a",
		ç: "c",
		è: "e",
		é: "e",
		ê: "e",
		ë: "e",
		ì: "i",
		í: "i",
		î: "i",
		ï: "i",
		ð: "d",
		ñ: "n",
		ò: "o",
		ó: "o",
		ô: "o",
		õ: "o",
		ö: "o",
		ø: "o",
		ù: "u",
		ú: "u",
		û: "u",
		ü: "u",
		ý: "y",
		þ: "b",
		ÿ: "y",
		ŕ: "r",
	};

	// Add uppercase variants automatically
	Object.entries(accentMap).forEach(([key, value]) => {
		accentMap[key.toUpperCase()] = value.toUpperCase();
	});

	return str
		.replace(/[\u00C0-\u017F]/g, (char) => accentMap[char] || char)
		.replace(/\s+/g, "-")
		.replace(/[^\w-]+/g, "")
		.toLowerCase();
};

const updateCropperContainerWidth = () => {
	const containerElement = document.querySelector(".topbanneredit");

	if (containerElement) {
		const height = containerElement.offsetHeight;
		const width = (16 / 9) * height;
		containerElement.style.width = width + "px";
	}
};

firebase.auth().onAuthStateChanged((user) => {
	const createTopContent = document.querySelector(".create-top-content");
	const mustLogIn = document.querySelector(".must-log-in");

	if (!user) {
		if (createTopContent) {
			createTopContent.classList.add("disable-create-top");
		}
		if (mustLogIn) {
			mustLogIn.classList.remove("d-none");
		}
	}
});

const fullToolbar = [
	["bold", "italic", "underline", "strike"],
	[
		{
			script: "super",
		},
		{
			script: "sub",
		},
	],
	["link"],
	["clean"],
];

const fullEditor = new Quill("#full-editor", {
	bounds: "#full-editor",
	placeholder:
		"Ici, tu dois ajouter quelques phrases pour présenter ton Top...",
	modules: {
		formula: true,
		toolbar: fullToolbar,
	},
	theme: "snow",
});

const createTopDoc = document.querySelector(".create-top-page");
const tabs = createTopDoc.querySelectorAll(".tabs");
const soumettreTop = createTopDoc.querySelector(".soumettre-top");
const updateTop = createTopDoc.querySelector(".update-top");
const soumettreContenders = document.querySelector(".soumettre-contenders");
const steps = createTopDoc.querySelectorAll(".step");
const alertMsg = document.querySelector(".alert");
const alertMsgTL = document.querySelector(".alert-toplist");
const topFormWrapper = createTopDoc.querySelector(".top-form-wrapper");
const topForm = createTopDoc.querySelector(".create-top-form");
const topTitle = topFormWrapper.querySelector("#top-title");
const topType = topFormWrapper.querySelector("#top-type");
const creatorRole = topFormWrapper.querySelector("#creator-role");
const topCategory = topFormWrapper.querySelector("#top-category");
const topQuestion = topFormWrapper.querySelector("#top-question");
const topImage = topFormWrapper.querySelector("#top-image");
const topBackground = topFormWrapper.querySelector("#top-background");
const TopImageUploadWrapper = topFormWrapper.querySelector(".top-image-upload-wrapper");
const topBackgroundUploadWrapper = topFormWrapper.querySelector(".top-background-upload-wrapper");
const topBannerWrapper = topFormWrapper.querySelector(".top-banner-wrapper");
const contenderImgInput = createTopDoc.querySelector(".contender-image-input");
const cropperOptionsBtns = createTopDoc.querySelectorAll("#cropper-options-btn");
let tabIndex = 0;

const showTab = function (direction) { // DEAL TABS
	if (direction === "next") {
		+tabIndex++;
	} else if (direction === "prev") {
		if (tabIndex == 0) return;
		+tabIndex--;
	} else {
		tabIndex = +direction;
	}

	tabs.forEach((tab, index) => {
		tab.classList.add("hidden");
		tab.classList.remove("show");
	});
	tabs[tabIndex].classList.add("show");
	tabs[tabIndex].classList.remove("hidden");
};
steps.forEach((step) => {
	step.addEventListener("click", function (e) {
		showTab(step.dataset.tabindex);
	});
});

let whatContenderToEdit = null;
let changeThumbnailInEditPage = false;
if(window.location.pathname.includes("nouveau-top")) changeThumbnailInEditPage = true;

let cropperBannerTop,
	canvasBannerTop = null;
let cropperContender,
	canvasContender = null;
let isTopToSend,
	isContenderToSend = false;
let dimensions = { width: null, height: null },
	 imageName,
	 contenders = [],
	 imgExtension = "png";
document.addEventListener("change", function (e) {
	const contendersDimensionsChecked = document.querySelector(
		'input[name="contenders-dimension"]:checked'
	);
	const contenderdimensionsRadioInputs = document.querySelectorAll(
		'input[name="contenders-dimension"]'
	);

	if (e.target === contendersDimensionsChecked) {
    // Dimensions changed, but no image selected yet
    if (!contenderImgInput.files || contenderImgInput.files.length === 0) {
      console.log("Dimensions changed, but no image selected. Returning.");
      return; // Exit the function
    }
  }

	if (
		e.target !== topImage &&
		e.target !== topBackground &&
		e.target !== contenderImgInput &&
		e.target !== contendersDimensionsChecked
	)
		return;

	if (e.target.type === "file" && e.target.files && e.target.files.length > 0) {
		let file = e.target.files[0];
		imgExtension = file.name.split(".").pop().toLowerCase();
	}

	const modal = $("#modal");
	const files = e.target.files;
	const image = document.getElementById("image-output");
	const modalRight = document.getElementById("modal-right");
	const modalLeft = document.getElementById("modal-left");
	const cropAndSendBtn = document.querySelector("#cropAndSendBtn");
	const cancelSendBtn = document.querySelector("#cancelSendBtn");
	const contenderNameInput = document.querySelector("#contender-name");
	const contendersImgsWrapper = document.querySelector(".contenders-images");
	const contendersUploadWrapper = document.querySelector(".contender-image-upload-wrapper");

	const imageProcess = function (imageOutput) {
		const done = function (url) {
			imageOutput.src = url;
			modal.modal("show");
		};

		if (files && files.length > 0) {
			let file = files[0];

			if (URL) {
				done(URL.createObjectURL(file));
			} else if (FileReader) {
				reader = new FileReader();
				reader.onload = function (e) {
					done(reader.result);
				};
				reader.readAsDataURL(file);
			}
		} else return;
	};

	const resetCropper = () => {
    if (cropperContender) {
        cropperContender.destroy();
        cropperContender = null;
    }
    if (cropperBannerTop) {
        cropperBannerTop.destroy();
        cropperBannerTop = null;
    }

		// Remove all .cropper-container elements to prevent duplication
    document.querySelectorAll('.cropper-container').forEach((el) => el.remove());
    
    // Reset modal content
    const imageOutput = document.getElementById("image-output");
    if (imageOutput) {
        imageOutput.src = "";
    }

		if (contenderNameInput) {
			contenderNameInput.value = "";
		}
    
    isTopToSend = false;
    isContenderToSend = false;
    changeThumbnailInEditPage = false;
    dimensions = { width: null, height: null };
	};

	const initCropper = function (cropper, image, dimensions) {
		cropper = new Cropper(image, {
			dragMode: "move",
			autoCropArea: 1,
			restore: false,
			guides: false,
			center: false,
			dragCrop: true,
			multiple: true,
			movable: true,
			highlight: false,
			cropBoxMovable: false,
			cropBoxResizable: false,
			toggleDragModeOnDblclick: false,
			modal: true,
			preview: ".preview",

			ready: function () {
				let cropBoxData = {
					width: dimensions.width,
					height: dimensions.height,
				};

				// Get the canvas data
				let canvasData = cropper.getCanvasData();

				// Calculate the left and top values for the cropBox to center it
				cropBoxData.left =
					(canvasData.width - cropBoxData.width) / 2 + canvasData.left;
				cropBoxData.top =
					(canvasData.height - cropBoxData.height) / 2 + canvasData.top;

				cropper.setCropBoxData(cropBoxData);

				updateCropperContainerWidth();
			},
		});

		return cropper;
	};
	
	if ((e.target === topImage) && changeThumbnailInEditPage) { // TOP
		isTopToSend = true;
		isContenderToSend = false;

		if (modalLeft) {
			modalLeft.classList.add("topbanneredit");
		}

		imageProcess(image);

		dimensions.width = 1200;
		dimensions.height = 630;

		image.width = dimensions.width;
		image.height = dimensions.height;

		imageName = normalizeString(topTitle.value)
			? normalizeString(topTitle.value)
			: "";
	} else if ((contendersDimensionsChecked || e.target === contenderImgInput) && !changeThumbnailInEditPage) { // CONTENDER
		isContenderToSend = true;
		isTopToSend = false;
		modalLeft.style.width = "";

		if (contendersDimensionsChecked !== null) {
			contendersUploadWrapper.classList.remove("d-none");

			let selectedValue = contendersDimensionsChecked.value;

			if (selectedValue === "vertical") {
				dimensions = { width: 400, height: 600 };
			} else if (selectedValue === "carre") {
				dimensions = { width: 400, height: 400 };
			} else if (selectedValue === "paysage") {
				dimensions = { width: 600, height: 400 };
			}

			image.width = dimensions.width;
			image.height = dimensions.height;

			document.querySelector(".contender-group-input").classList.remove("d-none");

			modalLeft.className = "col-md-8";
			modalRight.className = "col-md-4";
			imageProcess(image);
		}
	}

	function deleteImage(imagePath, buttonElement, type = "top") {
		const storageRef = firebase.storage().ref();
		let imageRef = storageRef.child(imagePath);

		imageRef
			.delete()
			.then(() => {
				if (type === "top") {
					let imgContainerElement = buttonElement.closest(
						".creation-top-banner-card"
					);
					imgContainerElement.remove();
					document
						.getElementById("add-background-btn")
						.classList.remove("d-none");
					topImage.value = "";
					topImage.classList.remove("d-none");
					TopImageUploadWrapper.setAttribute("data-visible", "true");
					isTopToSend = true;
				} else if (type === "contender") {
					let imgContainerElement = buttonElement.closest(
						".contender-wrapper-preview"
					);
					let imageURL = imgContainerElement.querySelector("img").src;
					let contenderIndex = contenders.findIndex(
						(contender) => contender.contenderURL == imageURL
					);
					if (contenderIndex > -1) {
						contenders.splice(contenderIndex, 1);
					}
					imgContainerElement.remove();
				}
			})
			.catch((error) => {
				console.error("Error deleting image: ", error);
			});
	}

	const cropImage = function (cropperInstance, canvas, imageName, type) {
		const cropAndSendBtnTxt = cropAndSendBtn.querySelector(".cropAndSendBtn-txt"); // START LOADING
		const cropAndSendBtnLoader = cropAndSendBtn.querySelector(".cropAndSendBtn-loader");
		cropAndSendBtnTxt.classList.add("d-none");
		cropAndSendBtnLoader.classList.remove("d-none");

		let updateContenderBoolean = false;

		if (type === "contender") imageName = contenderNameInput.value;

		// PREVENT DUPLICATES FOR CONTENDERS
		if (
			type === "contender" &&
			contenders.some((contender) => contender.contenderName === imageName)
		) {
			alert("Note: Tu as déjà envoyé ce Contender 😉");
		}

		let imagePath = `${normalizeString(imageName)}-${Date.now()}.${
			imgExtension === "png" ? "png" : "webp"
		}`;

		canvas = cropperInstance.getCroppedCanvas({
			width: dimensions.width,
			height: dimensions.height,
		});

		if (!canvas) return;

		const storageRef = firebase.storage().ref();

		canvas.toBlob(function (blob) {
			const uploadTask = storageRef.child(imagePath).put(blob);

			uploadTask.on(
				"state_changed",
				(snapshot) => {
					const progress =
						(snapshot.bytesTransferred / snapshot.totalBytes) * 100;
					switch (snapshot.state) {
						case firebase.storage.TaskState.PAUSED: // or 'paused'
							break;
						case firebase.storage.TaskState.RUNNING: // or 'running'
							break;
					}
				},
				(error) => {},
				() => {
					uploadTask.snapshot.ref.getDownloadURL().then((downloadURL) => {
						if (!alertMsg.classList.contains("d-none"))
							alertMsg.classList.add("d-none");
						modal.modal("hide");
						console.log("File available at", downloadURL);
						if (type === "top") {
							topBannerWrapper.innerHTML = `
								<div class="creation-top-banner-card">
									<img src=${downloadURL} title=${topTitle.value} id="previewTopBanner" class="preview-cover"/>

									<div class="image-sent">
										<span class="va va-check va-z-20"></span>
									</div>
									<button class="delete-btn" data-path="${imagePath}">
										<span class='va va-trash2 va-2x'></span>
									</button>
								</div>
							`;
							topImage.classList.add("d-none");
							document
								.getElementById("add-background-btn")
								.classList.add("d-none");
							TopImageUploadWrapper.setAttribute("data-visible", "false");

							isTopToSend = false;

							if(window.location.pathname.includes("edition-du-top")) {
								document.querySelector(".creation-top-banner-card .delete-btn").addEventListener("click", function() {
									document.querySelector(".top-image-upload-wrapper").classList.remove("d-none");
								});
							}
						} else if (type === "contender") {
							contenderdimensionsRadioInputs.forEach((input) => {
								input.disabled = true;
								input.readOnly = true;
							});
							if (document.querySelector(".video-youtube-btn"))
								document.querySelector(
									".video-youtube-btn"
								).disabled = true;

							if (whatContenderToEdit) {
								// UPDATE DOM
								const contenderImage = document.querySelector(
									`.contender-image-${whatContenderToEdit}`
								);
								contenderImage.querySelector("img").src = downloadURL;
								contenderImage.querySelector("img").alt =
									contenderNameInput.value;
								contenderImage.querySelector(
									".delete-update-top-contenders-btn"
								).dataset.path = imagePath;
								contenderImage.querySelector(
									".delete-update-top-contenders-btn"
								).dataset.contenderidwp = whatContenderToEdit;

								// UPDATE ENDPOINT
								$.ajax({
									url: `${SITE_BASE_URL}wp-json/v1/update_contender`,
									method: "POST",
									data: {
										id_contender: whatContenderToEdit,
										name_contender: contenderNameInput.value,
										url_contender: downloadURL,
									},
									success: function (results) {
										// console.log(downloadURL);
										console.log(results, "update contender ok");
									},
								});

								whatContenderToEdit = null;
								updateContenderBoolean = true;
							} else {
								if (window.location.pathname.includes("edition-du-top")) {
									contendersImgsWrapper.insertAdjacentHTML(
										"beforeend",
										`
										<div class="col-md-3 contender-wrapper-preview" id="contender-before-insert" data-contendername="vkrz-${contenderNameInput.value}">
											<img src=${downloadURL} title=${contenderNameInput.value} class="preview-contender" />
											<div class="image-sent">
												<span class="va va-check va-z-20"></span>
											</div>
											<input type="text" class="contender-title" value="${contenderNameInput.value}">
											<button class="delete-btn" data-path="${imagePath}">
												<span class='va va-trash2 va-2x'></span>
											</button>
										</div>
									`
									);
								} else {
									contendersImgsWrapper.insertAdjacentHTML(
										"beforeend",
										`
										<div class="col-md-3 contender-wrapper-preview" data-contendername="vkrz-${contenderNameInput.value}">
											<img src=${downloadURL} title=${contenderNameInput.value} class="preview-contender" />
											<div class="image-sent">
												<span class="va va-check va-z-20"></span>
											</div>
											<input type="text" class="contender-title" value="${contenderNameInput.value}">
											<button class="delete-btn" data-path="${imagePath}">
												<span class='va va-trash2 va-2x'></span>
											</button>
										</div>
									`
									);
								}
							}

							if (!updateContenderBoolean)
								contenders.push({
									idTop: topForm.dataset.idtop
										? topForm.dataset.idtop
										: getParamURL("id_top"),
									contenderName: contenderNameInput.value,
									contenderURL: downloadURL,
								});
						}

						// HANDLING TOP BANNER AND ALSO CONTENDERS
						const deleteImagesBtns =
							document.querySelectorAll(".delete-btn");
						deleteImagesBtns.forEach((btn) => {
							btn.addEventListener("click", (e) => {
								e.preventDefault();
								let imagePath = btn.dataset.path;
								deleteImage(imagePath, btn, type);
							});
						});

						// HANDLING EDITING CONTENDERS
						const deleteUpdateTopContendersBtn = document.querySelectorAll(
							".delete-update-top-contenders-btn"
						);
						deleteUpdateTopContendersBtn.forEach((btn) => {
							btn.addEventListener("click", (e) => {
								e.preventDefault();
								let imagePath = e.target.parentElement.dataset.path;
								deleteImage(imagePath, e.target, type);
							});
						});

						// FINISH LOADING
						cropAndSendBtnTxt.classList.remove("d-none");
						cropAndSendBtnLoader.classList.add("d-none");
					});
				}
			);
		});
	};

	cropperOptionsBtns.forEach((btn) => {
		btn.addEventListener("click", function (e) {
			const option = e.target.closest("#cropper-options-btn").dataset
				.option;

			switch (option) {
				case "cropper-zoom-in":
					cropperBannerTop?.zoom(0.1);
					cropperContender?.zoom(0.1);
					break;
				case "cropper-zoom-out":
					cropperBannerTop?.zoom(-0.1);
					cropperContender?.zoom(-0.1);
					break;
				case "cropper-move-left":
					cropperBannerTop?.move(-10, 0);
					cropperContender?.move(-10, 0);
					break;
				case "cropper-move-right":
					cropperBannerTop?.move(10, 0);
					cropperContender?.move(10, 0);
					break;
				case "cropper-move-up":
					cropperBannerTop?.move(0, -10);
					cropperContender?.move(0, -10);
					break;
				case "cropper-move-down":
					cropperBannerTop?.move(0, 10);
					cropperContender?.move(0, 10);
					break;
				default:
					console.error(`Error Handling Cropper Options! 📛`);
			}
		});
	});

	cropAndSendBtn.addEventListener("click", handleCropAndSend, { once: true });

	function handleCropAndSend() {
			if (isTopToSend && cropperBannerTop) {
					cropImage(cropperBannerTop, canvasBannerTop, imageName, "top");
			} else if (isContenderToSend && cropperContender) {
					const imageOutput = document.getElementById("image-output");
					cropImage(cropperContender, imageOutput, imageName, "contender");
			}
	}

	modal
		.on("shown.bs.modal", function () {
			if (isTopToSend && dimensions.width && dimensions.height) {
        if (cropperBannerTop) {
          cropperBannerTop.destroy();
          cropperBannerTop = null;
        }
        cropperBannerTop = initCropper(cropperBannerTop, image, dimensions);
      } else if (isContenderToSend && dimensions.width && dimensions.height) {
        // Check if dimensions are valid
        if (cropperContender) {
          cropperContender.destroy();
          cropperContender = null;
        }
        cropperContender = initCropper(cropperContender, image, dimensions);

        contenderNameInput.value = normalizeString(
          contenderImgInput.files[0].name.replace(/\.[^.]*$/, "").slice(0)
        );

        contenderNameInput.focus();
      }

			cancelSendBtn.addEventListener("click", resetCropper, { once: true });
			document.addEventListener("hidden.bs.modal", resetCropper, { once: true });
		})
		.on("hidden.bs.modal", function () {
			cropAndSendBtn.removeEventListener("click", handleCropAndSend);
			resetCropper();
		});
});

document
	.getElementById("top-background")
	.addEventListener("change", async function () {
		if (this.files && this.files.length > 0) {
			var fileName = this.files[0].name;
			const resizedBlob = await compressImage(this.files[0], 0.6);
			var reader = new FileReader();
			reader.onload = function (e) {
				var imagePreviewWrapper = document.querySelector(
					".top-background-preview-wrapper"
				);
				imagePreviewWrapper.classList.remove("d-none");
				imagePreviewWrapper.style.visibility = "visible";
				document.querySelector("#add-background-btn2").classList.add("d-none");
				imagePreviewWrapper.innerHTML = `	
					<div class="creation-top-background-card">
						<img src=${e.target.result} title=${fileName} class="preview-background-top"/>

						<div class="image-sent">
							<span class="va va-check va-z-20"></span>
						</div>
						<button class="delete-bg-top-btn">
							<span class='va va-trash2 va-2x'></span>
						</button>
					</div>
					`;

				document
					.querySelector(".delete-bg-top-btn")
					.addEventListener("click", function () {
						var fileInput = document.getElementById("top-background");
						fileInput.value = "";
						imagePreviewWrapper.innerHTML = "";
						document
							.querySelector(".top-background-upload-wrapper")
							.setAttribute(
								"data-text",
								"Clik ici pour ajouter le background du Top (Optionnel)"
							);
						document
							.querySelector(".top-background-upload-wrapper")
							.setAttribute("data-uploaded", "false");
						document.querySelector(
							".top-background-upload-wrapper"
						).style.visibility = "visible";
						document
							.querySelector("#add-background-btn2")
							.classList.remove("d-none");
					});
			};
			reader.readAsDataURL(resizedBlob);
		}
	});

if (soumettreTop) {
	soumettreTop.addEventListener("click", async function (e) {
		if (
			!topTitle.value ||
			!topCategory.value ||
			!topQuestion.value ||
			!topImage.value
		) {
			alertMsgTL.classList.remove("d-none");
		} else {
			const soumettreTopTxt = soumettreTop.querySelector(".soumettreTop-txt");
			const soumettreTopLoader = soumettreTop.querySelector(".soumettreTop-loader");
			soumettreTopTxt.classList.add("d-none");
			soumettreTopLoader.classList.remove("d-none");

			topTitle.readOnly = "true";
			topCategory.readOnly = "true";
			topCategory.disabled = "true";
			topQuestion.readOnly = "true";
			topImage.readOnly = "true";
			topImage.disabled = "true";
			document.getElementById("top-background").disabled = "true";

			if (document.querySelector(".delete-btn"))
				document.querySelectorAll(".delete-btn").forEach((btn) => btn.remove());
			if (document.querySelector(".delete-bg-top-btn"))
				document
					.querySelectorAll(".delete-bg-top-btn")
					.forEach((btn) => btn.remove());

			const topDescription = fullEditor.root.innerHTML;

			let formData = new FormData();
			formData.append("creatorRole", creatorRole.value);
			formData.append("topType", topType.value);
			formData.append("topTitle", topTitle.value);
			formData.append("topCategory", topCategory.value);
			formData.append("topQuestion", topQuestion.value);
			formData.append("topDescription", topDescription);
			formData.append("topBanner", topBannerWrapper.querySelector(".preview-cover").src);
			formData.append("topAuthor", uuid_user);

			const topBackgroundFile = document.getElementById("top-background").files[0];
			if (topBackgroundFile) {
				try {
					const compressedBlob = await compressImage(topBackgroundFile, 0.6); // Adjust quality
					formData.append("top-background", compressedBlob, topBackgroundFile.name);
				} catch (error) {
					console.error("Image compression failed:", error);
					formData.append("top-background", topBackgroundFile); 
				}
			} else { 
				formData.append("top-background", null);
			}

			$.ajax({
				url: `${SITE_BASE_URL}wp-json/vkrz/v1/addtop`,
				method: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function (results) {
					const [createdIdTop, createdTopUrl] = results;
					topForm.dataset.idtop = createdIdTop;
					topForm.dataset.topurl = createdTopUrl;

					soumettreTopTxt.classList.remove("d-none");
					soumettreTopLoader.classList.add("d-none");

					showTab("next");

					alertMsgTL.classList.add("d-none");
					steps[0].classList.add("active");
					steps[1].classList.remove("disable");
		
					soumettreTop.remove();

					document.querySelectorAll("#visualiser_btn").forEach((el) => {
						el.href = createdTopUrl;
					});
					document
						.querySelectorAll("#validation_btn, #valide_btn")
						.forEach((el) => {
							el.dataset.idtop = createdIdTop;
						});

					console.log(getRoleUser(), "getRoleUser");

					if (getRoleUser() > 2) {
						document.querySelectorAll("#valide_btn").forEach((el) => {
							el.classList.add("d-block");
						});
					} else {
						document.querySelectorAll("#validation_btn").forEach((el) => {
							el.classList.add("d-block");
						});
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.error("AJAX Error:", textStatus, errorThrown);
					alertMsgTL.classList.remove("d-none");
					alertMsgTL.innerHTML = `
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Une erreur est survenue lors de l'envoi de ta TopList.
					`;

					soumettreTopTxt.classList.remove("d-none");
					soumettreTopLoader.classList.add("d-none");
				},
			});
		}
	});
}

if (updateTop) {
	updateTop.addEventListener("click", function (e) {
		e.preventDefault();
		if (!topTitle.value || !topCategory.value || !topQuestion.value) {
			alertMsg.classList.remove("d-none");
		} else {
			alertMsg.classList.add("d-none");
			updateTop.innerHTML = "En cours...";

			const topDescription = fullEditor.root.innerHTML;

			let topBanner = null || "";
			if (document.querySelector(".top-banner-wrapper img") || document.querySelector(".creation-top-banner-card img")) {
				if (
					document
						.querySelector(".top-banner-wrapper img")
						.src.includes("firebasestorage")
				) {
					topBanner = document.querySelector(".top-banner-wrapper img").src;
				} else if (document.querySelector(".creation-top-banner-card img")) {
					topBanner = document.querySelector(".creation-top-banner-card img").src;
				}
			}

			let formData = new FormData();
			formData.append("topTitle", topTitle.value);
			formData.append("topCategory", topCategory.value);
			formData.append("topQuestion", topQuestion.value);
			formData.append("topDescription", topDescription);
			formData.append("topBanner", topBanner);
			formData.append("id_top", id_top_to_edit);
			let topBackground = false;
			if (document.getElementById("top-background").files[0]) {
				topBackground = document.getElementById("top-background").files[0];
			} else {
				if (document.querySelector(".creation-top-background-card")) {
					const imgElement = document.querySelector(
						".creation-top-background-card img"
					);
					if (imgElement && imgElement.src) {
						topBackground = true;
					}
				}
			}
			formData.append("top-background", topBackground);

			$.ajax({
				url: `${SITE_BASE_URL}wp-json/v1/update_top`,
				method: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function (results) {
					updateTop.innerHTML = "Sauvegardé ! <span class='ms-1 va va-disquette va-z-20'></span>";
					setTimeout(() => (updateTop.innerHTML = "Sauvegarder"), 2000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.error("AJAX Error:", textStatus, errorThrown);
				},
			});
		}
	});
}

if (soumettreContenders) {
	soumettreContenders.addEventListener("click", async (e) => {
		e.preventDefault();

		if (!contenderImgInput.value) {
			alertMsg.classList.remove("d-none");
		} else if (contenders.length < 2) {
			alertMsg.innerHTML = `
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Tente de mettre plus de 2 contenders! 🤭
      `;
			alertMsg.classList.remove("d-none");
		} else {
			contenderImgInput.readOnly = "true";
			contenderImgInput.disabled = "true";

			showTab("next");

			steps[1].classList.add("active");
			steps[2].classList.remove("disable");
			steps[2].classList.add("activefinal");

			soumettreContenders.remove();

			console.log(contenders);

			contenders.forEach((contender) => {
				$.ajax({
					url: `${SITE_BASE_URL}wp-json/vkrz/v1/addcontenderfromcreatetop`,
					method: "POST",
					data: {
						idTop: contender.idTop,
						contenderName: document.querySelector(
							`[data-contendername="vkrz-${contender.contenderName}"] .contender-title`
						).value,
						contenderURL: contender.contenderURL,
						topContendersDimensions: document.querySelector(
							'input[name="contenders-dimension"]:checked'
						).value,
					},
					success: function (data) {
						// console.log(data);
					},
				});
			});
		}
	});
}

const updateContenders = document.querySelector(".update-contenders");
if (updateContenders) {
	updateContenders.addEventListener("click", async (e) => {
		e.preventDefault();
		console.log(contenders);

		contenders.forEach((contender) => {
			$.ajax({
				url: `${SITE_BASE_URL}wp-json/vkrz/v1/addcontenderfromcreatetop`,
				method: "POST",
				data: {
					idTop: contender.idTop,
					contenderName: document.querySelector(`[data-contendername="vkrz-${contender.contenderName}"] .contender-title`).value,
					contenderURL: contender.contenderURL,
					topContendersDimensions: document.querySelector('input[name="contenders-dimension"]:checked').value,
				},
				success: function (data) {
					// console.log(data);
					updateContenders.innerHTML = "Sauvegardé ! <span class='ms-1 va va-disquette va-z-20'></span>";
					setTimeout(() => (updateContenders.innerHTML = "Sauvegarder"), 3000);
				},
			});
		});
		
		contenders = [];
	});
}

const updateYouTubeContenders = document.querySelector(".update-contenders-youtube-videos");
if (updateYouTubeContenders) {
	updateYouTubeContenders.addEventListener("click", async (e) => {
		e.preventDefault();

		const youtubeFields = document.querySelectorAll(".youtube-video-field");

		// Disable the update button and show progress
		updateYouTubeContenders.disabled = true;
		updateYouTubeContenders.innerHTML = `Mise à jour en cours...`;

		const updates = [];
		const newContenders = [];
		const recentlyAdded = new Set();
		let hasInvalidFields = false;

		youtubeFields.forEach((field) => {
			const idwp = field.dataset.idwp; // Get the ID of the contender (if existing)
			const youtubeLink = field.querySelector(".youtube-link").value.trim();
			const title = field.querySelector(".youtube-title").value.trim();
			const thumbnailUrl = field.querySelector(".youtube-preview").src;

			// Validate required fields
			if (!title || !youtubeLink || !thumbnailUrl) {
				console.warn("Contender has missing fields and will not be processed.");
				field.classList.add("error"); // Highlight invalid field
				hasInvalidFields = true;
				return;
			} else {
				field.classList.remove("error"); // Remove error state if fields are valid
			}

			// Construct the embed code
			let embedCode = `<iframe id="cover_contender_X" width="560" height="315" src="${youtubeLink.replace(
				"youtu.be/",
				"www.youtube.com/embed/"
			)}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
			embedCode = generateYouTubeEmbedCode(youtubeLink);

			// Separate updates and new contenders
			if (idwp) {
				updates.push({
					id_contender: idwp,
					name_contender: title,
					url_contender: thumbnailUrl, // YouTube Thumbnail
					embedContender: embedCode, // YouTube Embed Code
				});
			} else if (!recentlyAdded.has(field)) {
				newContenders.push({
					idTop: id_top_to_edit,
					contenderName: title,
					contenderURL: thumbnailUrl,
					embedContender: embedCode,
				});
				recentlyAdded.add(field);
			}
		});

		// Stop if there are invalid fields
		if (hasInvalidFields) {
			updateYouTubeContenders.innerHTML = "Veuillez remplir tous les champs !";
			setTimeout(() => {
				updateYouTubeContenders.innerHTML = "Sauvegarder";
				updateYouTubeContenders.disabled = false;
			}, 2000);
			return;
		}

		// Process updates one by one
		for (const update of updates) {
			try {
				await $.ajax({
					url: `${SITE_BASE_URL}wp-json/v1/update_contender`,
					method: "POST",
					data: update,
					success: function (data) {
						console.log(`Contender updated successfully:`, data);
					},
					error: function (xhr, status, error) {
						console.error(`Error updating contender: ${error}`);
					},
				});

				// Small delay to prevent server overload
				await new Promise((resolve) => setTimeout(resolve, 500));
			} catch (error) {
				console.error(`Failed to update contender:`, error);
			}
		}

		// Process new contenders one by one
		for (const newContender of newContenders) {
			try {
				const response = await $.ajax({
					url: `${SITE_BASE_URL}wp-json/vkrz/v1/addcontenderfromcreatetop`,
					method: "POST",
					data: newContender,
				});

				console.log(`New contender added successfully:`, response);

				// Update field with new ID
				const matchingField = [...youtubeFields].find(
					(field) =>
						field.querySelector(".youtube-title").value.trim() ===
						newContender.contenderName
				);
				if (matchingField) {
					matchingField.dataset.idwp = response.id_contender;
				}

				// Small delay to prevent server overload
				await new Promise((resolve) => setTimeout(resolve, 500));
			} catch (error) {
				console.error(`Error adding new contender: ${error}`);
			}
		}

		// Re-enable the button and reset its label
		updateYouTubeContenders.innerHTML = `Mise à jour terminée`;
		setTimeout(() => {
			updateYouTubeContenders.innerHTML = "Sauvegarder";
			updateYouTubeContenders.disabled = false;
		}, 2000);
	});
}

window.addEventListener("resize", updateCropperContainerWidth);

const visuelNormalBtn = document.querySelector(".visuel-normal-btn");
const videoYoutubeBtn = document.querySelector(".video-youtube-btn");
const addContenderBtn = document.querySelector(".add-contender-btn");
const youtubeFieldsWrapper = document.getElementById("youtube-fields-wrapper");
const addVideoBtn = document.querySelector(".add-video-btn");
const soumettreYouTubeVideos = document.getElementById("soumettre-youtube-videos");
const soumettreContendersBTN = document.getElementById("soumettre-images-contenders");
const addBackgroundBtn = document.getElementById("add-background-btn");
const addBackgroundBtn2 = document.getElementById("add-background-btn2");
let videoCount = 2;

if (addBackgroundBtn) {
	addBackgroundBtn.addEventListener("click", () => {
		changeThumbnailInEditPage = true;
		isTopToSend = true;
		document.querySelector("#top-image").click();
	});
}
if (addBackgroundBtn2) {
	addBackgroundBtn2.addEventListener("click", (e) => {
		e.preventDefault();
		document.querySelector("#top-background").click();
	});
}

// Show/Hide sections based on type
if (visuelNormalBtn) {
	visuelNormalBtn.addEventListener("click", () => {
		visuelNormalBtn.classList.add("active-btn-type-contender");
		videoYoutubeBtn.classList.remove("active-btn-type-contender");
		document.querySelector(".visuel-normal").classList.remove("d-none");
		document.querySelector(".videos-youtube").classList.add("d-none");
		soumettreYouTubeVideos.classList.add("d-none");
		soumettreContendersBTN.classList.remove("d-none");
	});
}

if (videoYoutubeBtn) {
	videoYoutubeBtn.addEventListener("click", () => {
		videoYoutubeBtn.classList.add("active-btn-type-contender");
		visuelNormalBtn.classList.remove("active-btn-type-contender");
		document.querySelector(".visuel-normal").classList.add("d-none");
		document.querySelector(".videos-youtube").classList.remove("d-none");
		soumettreYouTubeVideos.classList.remove("d-none");
		soumettreContendersBTN.classList.add("d-none");
	});
}

if (addContenderBtn) {
	addContenderBtn.addEventListener("click", (e) => {
		e.preventDefault();
		document.querySelector(".contender-image-input").click();
	});
}

function extractYouTubeId(input) {
	if (!input || typeof input !== "string") return null;

	// If it's an iframe HTML
	if (input.includes("<iframe")) {
		const match = input.match(/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/);
		return match ? match[1] : null;
	}

	try {
		const url = new URL(input);

		if (url.hostname === "youtu.be") {
			return url.pathname.slice(1);
		}

		if (url.hostname.includes("youtube.com")) {
			if (url.pathname.startsWith("/watch")) {
				return url.searchParams.get("v");
			}
			if (url.pathname.startsWith("/embed/") || url.pathname.startsWith("/shorts/")) {
				return url.pathname.split("/")[2];
			}
		}
	} catch (e) {
		console.warn("Invalid YouTube input:", input);
	}

	return null;
}

function generateYouTubeEmbedCode(link) {
	const videoId = extractYouTubeId(link);
	if (!videoId) {
		console.warn(`Invalid YouTube link: ${link}`);
		return "";
	}

	return `<iframe id="cover_contender_X" width="560" height="315" src="https://www.youtube.com/embed/${videoId}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>`;
}

function getYouTubeThumbnail(url) {
	const videoId = extractYouTubeId(url);
	return videoId ? `https://img.youtube.com/vi/${videoId}/sddefault.jpg` : null;
}

async function getYouTubeVideoTitle(url) {
	try {
		const videoId = extractYouTubeId(url);
		if (!videoId) throw new Error("Invalid YouTube URL");

		const oembedUrl = `https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=${videoId}&format=json`;
		const response = await fetch(oembedUrl);

		if (!response.ok) throw new Error(`Failed to fetch title: ${response.statusText}`);

		const data = await response.json();
		return data.title;
	} catch (error) {
		console.error("Error fetching video title:", error);
		return "Titre indisponible";
	}
}

async function checkYouTubeVideoAvailability(url) {
	try {
		const videoId = extractYouTubeId(url);
		if (!videoId) return false;

		// Check if thumbnail exists
		const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/sddefault.jpg`;
		const thumbRes = await fetch(thumbnailUrl, { method: "HEAD" });
		if (!thumbRes.ok) {
			console.warn("❌ Thumbnail doesn't exist – video is deleted or private");
			return false;
		}

		// Check if embeddable via oEmbed
		const oembedUrl = `https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=${videoId}&format=json`;
		const oembedRes = await fetch(oembedUrl);
		if (!oembedRes.ok) {
			console.warn("❌ Video is not embeddable (oEmbed blocked)");
			return false;
		}

		return true; // ✅ Thumbnail + oEmbed success = allowed
	} catch (error) {
		console.error("❌ Error checking video:", error);
		return false;
	}
}

if (addVideoBtn) {
	// Add a new YouTube video field
	addVideoBtn.addEventListener("click", () => {
		videoCount++;
		const videoFieldHtml = `
		<div class="youtube-video-field" id="video-field-${videoCount}">
			<div class="row">
				<div class="col-9">
					<div class="d-flex align-items-center justify-content-start">
						<h6 class="indication-video-create text-muted">URL YouTube</h6>
						<input type="url" id="youtube-link-${videoCount}" name="youtube-link[]" class="youtube-link form-control" placeholder="${placeholder}" required>
					</div>
					<div id="youtube-title-${videoCount}-wrapper" class="d-flex align-items-center justify-content-start">
						<h6 class="indication-video-create text-muted">Titre</h6>
						<input type="text" id="youtube-title-${videoCount}" name="youtube-title[]" class="youtube-title form-control" placeholder="${placeholder2}" required>
					</div>
				</div>
				<div class="col-3">
					<div class="youtube-preview-placeholder">
						<img id="youtube-preview-${videoCount}" class="youtube-preview" alt="Prévisualisation" style="display: none;">
					</div>
				</div>
			</div>
			<button type="button" class="btn btn-danger remove-video-btn mt-2" data-id="${videoCount}">Supprimer</button>
		</div>
	`;

		youtubeFieldsWrapper.insertAdjacentHTML("beforeend", videoFieldHtml);
	});
}

if (youtubeFieldsWrapper) {
	// Remove dynamically added YouTube video field
	youtubeFieldsWrapper.addEventListener("click", (event) => {
		if (event.target.classList.contains("remove-video-btn")) {
			const videoField = event.target.closest(".youtube-video-field");
			const videoFieldId = videoField.id;

			// Prevent deletion of the first two fields
			if (
				videoFieldId === "video-field-1" ||
				videoFieldId === "video-field-2"
			) {
				alert(
					"Tu ne peux pas supprimer de contenders, car une TopList nécessite au moins deux vidéos."
				);
				return;
			}

			// Remove the field
			videoField.remove();
		}
	});
}

const messagesAlertYouTubeVideo = {
	fr: "Cette vidéo est privée, indisponible ou ne peut pas être intégrée sur d'autres sites. Merci d'utiliser une autre vidéo YouTube.",
	"br-pt": "Este vídeo é privado, indisponível ou não pode ser incorporado em outros sites. Por favor, use outro vídeo do YouTube.",
	es: "Este video es privado, no está disponible o no se puede insertar en otros sitios. Por favor, usa otro video de YouTube.",
	it: "Questo video è privato, non disponibile o non può essere incorporato su altri siti. Per favore, usa un altro video di YouTube.",
	ja: "この動画は非公開、利用不可、または他のサイトに埋め込むことができません。別のYouTube動画を使用してください。",
	en: "This video is private, unavailable, or cannot be embedded on other sites. Please use another YouTube video."
};
const alertYoutubePrivate = messagesAlertYouTubeVideo[WeglotData.lang] || messagesAlertYouTubeVideo.fr;

if (youtubeFieldsWrapper) {
	youtubeFieldsWrapper.addEventListener("input", async (event) => {
		if (event.target.classList.contains("youtube-link")) {
			const input = event.target;
			const titleId = input.id.replace("link", "title");
			const titleField = document.getElementById(titleId);

			// Early validation
			if (!input.value.trim()) return;

			try {
				const isAvailable = await checkYouTubeVideoAvailability(input.value);

				if (!isAvailable) {
					alert(alertYoutubePrivate);
					input.value = "";
					titleField.value = "";
					return;
				}

				// If video is available, proceed with getting title and thumbnail
				const previewId = input.id.replace("link", "preview");
				const previewImage = document.getElementById(previewId);
				const thumbnailUrl = getYouTubeThumbnail(input.value);

				if (thumbnailUrl) {
					previewImage.src = thumbnailUrl;
					previewImage.style.display = "block";

					const title = await getYouTubeVideoTitle(input.value);
					titleField.value = title;
					if (document.querySelector(".visuel-normal-btn")) {
						document.querySelector(".visuel-normal-btn").disabled = false;
					}
				}
			} catch (error) {
				alert(alertYoutubePrivate);
				input.value = "";
				titleField.value = "";
			}
		}
	});
}

if (soumettreYouTubeVideos) {
	// Submit YouTube videos
	soumettreYouTubeVideos.addEventListener("click", (event) => {
		event.preventDefault();
		const formData = new FormData(
			document.getElementById("youtube-videos-form")
		);

		// Collect video data
		const videos = [];
		for (let i = 0; i < videoCount; i++) {
			const link = formData.getAll("youtube-link[]")[i];
			const title = formData.getAll("youtube-title[]")[i];
			const thumbnail = getYouTubeThumbnail(link);

			// Ensure the data is valid
			if (link && title && thumbnail) {
				videos.push({
					link,
					title,
					thumbnail,
					embedCode: generateYouTubeEmbedCode(link),
				});
			}
		}

		if (videos.length < 2) {
			alert(
				"Veuillez ajouter au moins deux vidéos pour soumettre une TopList !"
			);
			return;
		}

		// Send data to the server
		videos.forEach((video) => {
			$.ajax({
				url: `${SITE_BASE_URL}wp-json/vkrz/v1/addcontenderfromcreatetop`,
				method: "POST",
				data: {
					idTop: topForm.dataset.idtop,
					contenderName: video.title,
					contenderURL: video.thumbnail,
					embedContender: video.embedCode,
				},
				success: function (data) {
					console.log("Video added:", data);
				},
			});
		});

		showTab("next");

		steps[1].classList.add("active");
		steps[2].classList.remove("disable");
		steps[2].classList.add("activefinal");

		soumettreYouTubeVideos.remove();

		// alert("TopList avec vidéos YouTube soumise avec succès !");
	});
}

// EDITOR
function simulateContendersDimensionsAction(selector, dimensionValue) {
	const radioButtons = document.querySelectorAll(`${selector}`);
	radioButtons.forEach((radioButton) => {
		if (radioButton.value === dimensionValue) {
			// Trigger events for the matching radio button
			radioButton.checked = true;
			["mousedown", "mouseup", "click"].forEach((event) => {
				radioButton.dispatchEvent(
					new MouseEvent(event, {
						bubbles: true,
						cancelable: true,
						view: window,
					})
				);
			});
			// Trigger the change event as well
			radioButton.dispatchEvent(new Event("change", { bubbles: true }));
		} else {
			radioButton.disabled = true;
		}
	});
}

document.addEventListener("DOMContentLoaded", function () {
	if (typeof id_top_to_edit === "undefined" || id_top_to_edit === null || id_top_to_edit === false) return;

	fetch(`${SITE_BASE_URL}wp-json/v1/editiontop/${id_top_to_edit}`)
		.then((response) => response.json())
		.then((data) => {
			const contendersNormalWrapper = document.querySelector(".contenders-form-wrapper");
			const contendersYouTubeVideosWrapper = document.querySelector(".contenders-youtube-form-wrapper");
			if (data.is_toplist_type_youtube_videos) {
				contendersYouTubeVideosWrapper.classList.remove("d-none");
			} else {
				contendersNormalWrapper.classList.remove("d-none");
			}

			var topTitle = document.getElementById("top-title");
			var topQuestion = document.getElementById("top-question");
			var topImageWrapper = document.querySelector(".top-banner-wrapper");
			var topCategorySelect = document.getElementById("top-category");

			function decodeHtmlEntities(str) {
				var textArea = document.createElement("textarea");
				textArea.innerHTML = str;
				return textArea.value;
			}

			topTitle.value = decodeHtmlEntities(data.top_title);
			topQuestion.value = decodeHtmlEntities(data.top_question);
			fullEditor.clipboard.dangerouslyPasteHTML(0, data.top_precision);

			for (var option of topCategorySelect.options) {
				if (option.value == data.top_cat_id) {
					option.selected = true;
					break;
				}
			}

			// Vérifie si une image est déjà présente
			if (data.top_img && data.top_img !== "null" && data.top_img !== "undefined" && data.top_img !== "false") {
				var topImage = document.createElement("img");
				topImage.src = data.top_img;
				topImage.alt = data.top_title;
				topImage.classList.add("preview-cover");
				topImageWrapper.appendChild(topImage);

				var topImageEditButton = document.createElement("button");
				topImageEditButton.innerHTML = "<span class='va va-change va-2x me-1'></span>";
				topImageEditButton.classList.add("edit-top-image", "btn");
				topImageWrapper.appendChild(topImageEditButton);

				var topImageDeleteButton = document.createElement("button");
				topImageDeleteButton.innerHTML = "<span class='va va-trash2 va-2x'></span>";
				topImageDeleteButton.classList.add("delete-top-image", "btn");
				topImageWrapper.appendChild(topImageDeleteButton);

				topImageDeleteButton.addEventListener("click", function () {
						topImageWrapper.innerHTML = "";
						document.querySelector(".top-image-upload-wrapper").classList.remove("d-none");
				});

				topImageEditButton.addEventListener("click", function (e) {
						changeThumbnailInEditPage = true;
						isTopToSend = true;
						e.preventDefault();
						document.getElementById("top-image").click();
				});
			} else {
				document.querySelector(".image-upload-wrapper").classList.remove("d-none");
			}

			if (data.top_cover) {
				document.querySelector(".top-background-upload-wrapper").classList.add("d-none");

				var imagePreviewWrapper = document.querySelector(".top-background-preview-wrapper");
				imagePreviewWrapper.classList.remove("d-none");
				imagePreviewWrapper.style.visibility = "visible";
				imagePreviewWrapper.innerHTML = `	
					<div class="creation-top-background-card">
						<img src=${data.top_cover} title=${topTitle.value} class="preview-background-top"/>

						<button class="delete-bg-top-btn">
							<span class='va va-trash2 va-2x'></span>
						</button>
					</div>
				`;

				document
					.querySelector(".delete-bg-top-btn")
					.addEventListener("click", function () {
						var fileInput = document.getElementById("top-background");
						fileInput.value = "";
						document.querySelector(".top-background-preview-wrapper").innerHTML = "";

						document
							.querySelector(".top-background-upload-wrapper")
							.classList.remove("d-none");
					});
			}

			// Contenders
			let contendersImagesDiv = document.querySelector(".listing-contenders");

			if (data.is_toplist_type_youtube_videos) {
				contendersImagesDiv = document.querySelector(".listing-contenders-youtube-videos");

				async function getYouTubeVideoTitle(url) {
					try {
						const videoId = extractYouTubeId(url);
						if (!videoId) {
							throw new Error("Invalid YouTube URL");
						}

						const oembedUrl = `https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=${videoId}&format=json`;
						const response = await fetch(oembedUrl);

						if (!response.ok) {
							throw new Error(`Failed to fetch title: ${response.statusText}`);
						}

						const data = await response.json();
						return data.title;
					} catch (error) {
						console.error("Error fetching video title:", error);
						return "Titre indisponible"; // Default fallback title
					}
				}

				async function updateThumbnailAndTitleOnUrlChange(
					inputElement,
					previewElement,
					titleElement
				) {
					let lastValidUrl = "";
					const initialUrl = inputElement.value.trim();
				
					// Vérifier l'URL initiale (mode édition)
					if (initialUrl) {
						const isValid = await checkYouTubeVideoAvailability(initialUrl);
						if (isValid) lastValidUrl = initialUrl;
					}
				
					inputElement.addEventListener("input", async () => {
						const newUrl = inputElement.value.trim();
				
						if (!newUrl) {
							previewElement.style.display = "none";
							titleElement.value = "";
							return;
						}
				
						try {
							// Vérifier si la vidéo est valide
							const isValid = await checkYouTubeVideoAvailability(newUrl);
							if (!isValid) {
								alert(alertYoutubePrivate);
								inputElement.value = lastValidUrl || "";
								return;
							}
				
							// La vidéo est valide, on met à jour l'URL
							lastValidUrl = newUrl;
				
							// Mettre à jour la miniature
							const videoId = extractYouTubeId(newUrl);
							previewElement.src = `https://img.youtube.com/vi/${videoId}/sddefault.jpg`;
							previewElement.style.display = "block";
				
							// Mettre à jour le titre de la vidéo
							const title = await getYouTubeVideoTitle(newUrl);
							titleElement.value = title;
							
						} catch (error) {
							console.error("Erreur lors de la mise à jour de la vidéo :", error);
							alert(alertYoutubePrivate);
							inputElement.value = lastValidUrl || "";
							previewElement.style.display = "none";
							titleElement.value = "";
						}
					});
				}

				// Render existing contenders
				data.list_contenders.forEach(async (contender, index) => {
					const videoFieldId = `video-field-${index + 1}`;
					const videoId = extractYouTubeId(contender.embed);
					const videoUrl = videoId ? `https://youtu.be/${videoId}` : "";
					const videoTitle = contender.c_name
						? decodeHtmlEntities(contender.c_name)
						: videoUrl
						? await getYouTubeVideoTitle(videoUrl)
						: "Titre indisponible";
					const thumbnailSrc =
						contender.cover ||
						(videoId
							? `https://img.youtube.com/vi/${videoId}/sddefault.jpg`
							: "");

					// Create main container
					const youtubeDiv = document.createElement("div");
					youtubeDiv.classList.add("youtube-video-field");
					youtubeDiv.id = videoFieldId;
					youtubeDiv.dataset.idwp = contender.id_wp;

					// Create row container
					const rowDiv = document.createElement("div");
					rowDiv.classList.add("row");

					// Left Column (Inputs)
					const colLeft = document.createElement("div");
					colLeft.classList.add("col-9");

					// URL Input
					const urlWrapper = document.createElement("div");
					urlWrapper.classList.add(
						"d-flex",
						"align-items-center",
						"justify-content-start"
					);
					const urlLabel = document.createElement("h6");
					urlLabel.classList.add("indication-video-create", "text-muted");
					urlLabel.textContent = "URL YouTube";
					const urlInput = document.createElement("input");
					urlInput.type = "url";
					urlInput.id = `youtube-link-${index + 1}`;
					urlInput.name = "youtube-link[]";
					urlInput.classList.add("youtube-link", "form-control");
					urlInput.placeholder = placeholder;
					urlInput.value = videoUrl;
					urlInput.required = true;
					urlWrapper.appendChild(urlLabel);
					urlWrapper.appendChild(urlInput);

					// Title Input
					const titleWrapper = document.createElement("div");
					titleWrapper.classList.add(
						"d-flex",
						"align-items-center",
						"justify-content-start"
					);
					const titleLabel = document.createElement("h6");
					titleLabel.classList.add("indication-video-create", "text-muted");
					titleLabel.textContent = "Titre";
					const titleInput = document.createElement("input");
					titleInput.type = "text";
					titleInput.id = `youtube-title-${index + 1}`;
					titleInput.name = "youtube-title[]";
					titleInput.classList.add("youtube-title", "form-control");
					titleInput.placeholder = placeholder2;
					titleInput.value = videoTitle;
					titleInput.required = true;
					titleWrapper.appendChild(titleLabel);
					titleWrapper.appendChild(titleInput);

					colLeft.appendChild(urlWrapper);
					colLeft.appendChild(titleWrapper);

					// Right Column (Thumbnail)
					const colRight = document.createElement("div");
					colRight.classList.add("col-3");
					const previewWrapper = document.createElement("div");
					previewWrapper.classList.add("youtube-preview-placeholder");
					const previewImg = document.createElement("img");
					previewImg.id = `youtube-preview-${index + 1}`;
					previewImg.classList.add("youtube-preview");
					previewImg.alt = "Prévisualisation";
					previewImg.style.display = videoId ? "block" : "none";
					previewImg.src = thumbnailSrc;
					previewWrapper.appendChild(previewImg);
					colRight.appendChild(previewWrapper);

					// Delete Button
					const deleteButton = document.createElement("button");
					deleteButton.type = "button";
					deleteButton.classList.add(
						"btn",
						"btn-danger",
						"remove-video-btn",
						"mt-2"
					);
					deleteButton.textContent = "Supprimer";

					// Delete functionality
					deleteButton.addEventListener("click", () => {
						if (!youtubeDiv.dataset.idwp) {
							youtubeDiv.remove();
							return;
						}

						const remainingFields = document.querySelectorAll(
							".youtube-video-field"
						).length;
						if (remainingFields <= 2) {
							alert(
								"Tu ne peux pas supprimer de contenders, car une TopList nécessite au moins deux vidéos."
							);
							return;
						}

						$.ajax({
							url: `${SITE_BASE_URL}wp-json/v1/deletecontender/${youtubeDiv.dataset.idwp}`,
							method: "GET",
							success: function (response) {
								if (response.success) {
									youtubeDiv.remove();
									alert(response.message);
								} else {
									alert(
										"Une erreur est survenue lors de la suppression du contender."
									);
								}
							},
							error: function () {
								alert(
									"Une erreur est survenue lors de la suppression du contender."
								);
							},
						});
					});

					// Update thumbnail & title dynamically when URL changes
					updateThumbnailAndTitleOnUrlChange(urlInput, previewImg, titleInput);

					// Append everything
					rowDiv.appendChild(colLeft);
					rowDiv.appendChild(colRight);
					youtubeDiv.appendChild(rowDiv);
					youtubeDiv.appendChild(deleteButton);
					contendersImagesDiv.appendChild(youtubeDiv);
				});

				// Add "Add Video" Button
				const addVideoButton = document.createElement("button");
				addVideoButton.type = "button";
				addVideoButton.id = "add-video-btn";
				addVideoButton.classList.add("btn", "btn-secondary", "mt-3");
				addVideoButton.textContent = "Ajouter une vidéo";
				contendersImagesDiv.appendChild(addVideoButton);

				let videoCount = data.list_contenders.length || 2; // Start from existing videos or 2 by default

				if (addVideoButton) {
					addVideoButton.addEventListener("click", () => {
						videoCount++;

						const videoFieldHtml = `
              <div class="youtube-video-field" id="video-field-${videoCount}">
                <div class="row">
                  <div class="col-9">
                    <div class="d-flex align-items-center justify-content-start">
                      <h6 class="indication-video-create text-muted">URL YouTube</h6>
                      <input type="url" id="youtube-link-${videoCount}" name="youtube-link[]" class="youtube-link form-control" placeholder="${placeholder}" required>
                    </div>
                    <div id="youtube-title-${videoCount}-wrapper" class="d-flex align-items-center justify-content-start">
                      <h6 class="indication-video-create text-muted">Titre</h6>
                      <input type="text" id="youtube-title-${videoCount}" name="youtube-title[]" class="youtube-title form-control" placeholder="${placeholder2}" required>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="youtube-preview-placeholder">
                      <img id="youtube-preview-${videoCount}" class="youtube-preview" alt="Prévisualisation" style="display: none;">
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-danger remove-video-btn mt-2">Supprimer</button>
              </div>
            `;

						// Insert the new field before the "Add Video" button
						addVideoButton.insertAdjacentHTML("beforebegin", videoFieldHtml);

						// Select the new field and its elements
						const newField = document.getElementById(
							`video-field-${videoCount}`
						);
						const newLinkInput = newField.querySelector(".youtube-link");
						const newTitleInput = newField.querySelector(".youtube-title");
						const newPreview = newField.querySelector(".youtube-preview");

						// Attach dynamic event listener for YouTube URL validation
						updateThumbnailAndTitleOnUrlChange(
							newLinkInput,
							newPreview,
							newTitleInput
						);

						// Add delete functionality
						const deleteButton = newField.querySelector(".remove-video-btn");
						deleteButton.addEventListener("click", () => {
							newField.remove();
						});
					});
				}
			} else {
				
				data.list_contenders.forEach((contender) => { // Render Normal Contenders
					console.log(contender)
					const mainDiv = document.createElement("div");
					mainDiv.classList.add("contendertoedit");
					mainDiv.classList.add("col-md-3");
					mainDiv.classList.add(`contender-image-${contender.id_wp}`);
					mainDiv.setAttribute("data-idwp", contender.id_wp);

					const visuelDiv = document.createElement("div");
					visuelDiv.classList.add("visuel-contendertoedit");

					const img = document.createElement("img");
					img.classList.add("img-fluid");
					img.src = contender.cover;
					img.alt =
						"Un problème est survenu pour l'affichage de l'image, il est préférable de la remplacer !";

					const button1 = document.createElement("button");
					button1.innerHTML =
						"<span class='va va-change va-2x' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-original-title='Changer le visuel du contender'></span>";
					button1.className = "edit-contender";

					const button2 = document.createElement("button");
					button2.classList.add("delete-update-top-contenders-btn");
					button2.setAttribute("data-path", contender.cover);
					button2.innerHTML =
						"<span class='va va-trash2 va-2x' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-original-title='Attention : supprime le contender'></span>";

					visuelDiv.appendChild(img);
					visuelDiv.appendChild(button1);
					visuelDiv.appendChild(button2);

					const title = document.createElement("input");
					title.type = "text";
					title.classList.add("contender-title");
					title.value = decodeHtmlEntities(contender.c_name);

					mainDiv.appendChild(visuelDiv);
					mainDiv.appendChild(title);

					contendersImagesDiv.appendChild(mainDiv);
				});
			}

			if (data.top_contenders_dimensions !== false) {
				simulateContendersDimensionsAction(
					'input[name="contenders-dimension"]',
					data.top_contenders_dimensions
				);
			}

			const editContenderButtons = document.querySelectorAll(".edit-contender");
			editContenderButtons.forEach((button) => {
				button.addEventListener("click", function (event) {
					event.preventDefault();

					let imgContainerElement = event.target.closest(".contendertoedit");
					whatContenderToEdit = imgContainerElement.dataset.idwp;
					document.querySelector(".contender-image-input").click();
				});
			});

			const deleteUpdateTopContendersBtn = document.querySelectorAll(
				".delete-update-top-contenders-btn"
			);
			deleteUpdateTopContendersBtn.forEach((btn) => {
				btn.addEventListener("click", (e) => {
					e.preventDefault();

					let imgContainerElement = e.target.closest(".contendertoedit");
					fetch(
						`${SITE_BASE_URL}wp-json/v1/deletecontender/${imgContainerElement.dataset.idwp}`
					)
						.then((response) => response.json())
						.then((data) => {
							console.log(data);
							imgContainerElement.remove();
						});
				});
			});

			document
				.querySelector(".update-contenders")
				.addEventListener("click", function () {
					const editContenderTitleBtns =
						document.querySelectorAll(".contender-title");

					editContenderTitleBtns.forEach((button) => {
						let title =
							typeof decodeHtmlEntities !== "undefined"
								? decodeHtmlEntities(button.value)
								: button.value;
						let idwp = button.closest(".contendertoedit").dataset.idwp
							? button.closest(".contendertoedit").dataset.idwp
							: null;

						$.ajax({
							url: `${SITE_BASE_URL}wp-json/v1/update_contender_name`,
							method: "POST",
							data: {
								id_contender: idwp,
								name_contender: title,
							},
							success: function (results) {
								console.log(results);
							},
							error: function (error) {
								console.error("AJAX error:", error);
							},
						});
					});
				});
		})
		.catch((error) => console.error("An error occurred:", error));
});