<div class="offcanvas offcanvas-end toplist_comments bg-deg" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="jugement" aria-labelledby="offcanvasScrollLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasScrollLabel" class="offcanvas-title">
      <span class="va va-hache va-lg"></span> Laisser un jugement
    </h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <ul class="comments-container media-list info-jugement" id="toplist_comments">
    </ul>
    <div class="card-footer border-0">
      <div class="d-flex align-items-center commentarea-container">
        <form id="jugementForm">
          <textarea id="jugementInput" name="jugement" placeholder="Juger…"></textarea>
          <input type="hidden" id="id_toplist" name="id_toplist" data-class-jugement-nbr=".jugements-nbr" data-has-label="false">
          <input type="hidden" id="uuid_juge" name="uuid_juge">
          <input type="hidden" id="responseto" name="responseto" value="0">
          <button id="send_comment_btn" type="submit">
            <span class="va va-icon-arrow-up va-z-40"></span>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="module">
    var toplistCommentsCard = document.querySelector(".toplist_comments"),
        sendJugementBtn = toplistCommentsCard.querySelector("#send_comment_btn"),
        commentArea = toplistCommentsCard.querySelector("#jugementInput"),
        commentsContainer = toplistCommentsCard.querySelector(".comments-container");

    /**
     * get ranking id from URl
     * use for single item
     */
    function getRankingIdFromUrl(url) {
        const segments = url.split('#')[0].split('/').filter(segment => segment.trim() !== '');
        return segments[segments.length - 1];
    }

    /**
     * second to str readable
     */
    const secondsToStrFuncHelper = function(seconds) {
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
    };

    /**
     * comment template
     */
    const commentTemplate = async function(commentId, uuid, content, secondes) {
        const response = await fetch(`${API_BASE_URL}user-list/get?uuid_user=${encodeURIComponent(uuid)}`, {
          method: "GET",
          headers: {
              'Content-Type': 'application/json'
          }
        });

        if (!response.ok) {
            throw new Error('🔥 Fetching problem in: /vkrz/user-list/get');
        }

        const data = await response.json();

        let deleteOrNot = "";
        if (uuid == uuid_user) {
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
              <div class="media-left">
                <div class="avatar overflow-visible">
                    <a href="#" class="text-white">
                        <span class="avatar-picture" style="background-image: url(${data?.infos_user?.avatar_user ? data.infos_user.avatar_user : "https://vainkeurz.com/wp-content/uploads/2024/11/avatar-rose.png"});"></span>
                    </a>
                </div>
              </div>

              <div class="media-body text-left">
                <div class="d-flex align-items-center justify-content-between">
                  <div>
                    <a href="#" class="text-white">
                      <small style="font-size: .95em; font-weight: 600;">${data?.infos_user?.pseudo_user ? data.infos_user.pseudo_user : "Lama2Lombre"}</small>
                    </a>
                    <small class="text-muted" style="font-size: .75em; margin-left: .5rem; line-height:0;">Il y a ${secondsToStrFuncHelper(secondes)}</small>
                  </div>

                  ${deleteOrNot}
                </div>

                <p class="media-heading">
                    ${content}
                </p>

                <a href="" class="replyCommentBtn" data-replyTo="${commentId}@${data?.infos_user?.pseudo_user ? data.infos_user.pseudo_user : "Lama2Lombre"}">
                    Répondre
                </a>
              </div>

              <hr>
        </div>
      `;
    };

    /**
     * add reply comment event
     * @param btn
     */
    function addReplyCommentEventListener(btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault();
            const replyTo = e.target.getAttribute('data-replyTo');
            const replyToId = replyTo.split('@')[0]; // Assuming the format is "ID@username"
            document.getElementById('responseto').value = replyToId; // Set the hidden input's value
            commentArea.value = `@${replyTo.split('@')[1]} `; // Pre-fill the textarea with the username
            commentArea.focus(); // Focus the textarea
        });
    }

    /**
     *
     * @param value
     * @param jugementsNumber
     * @param hasLabel
     * @param initialValue
     */
    function updateJugementsNumbers(value, jugementsNumber, hasLabel = false,initialValue = false) {
        var current_count = !isNaN(parseInt(jugementsNumber.getAttribute('data-current-count'), 10)) ?
            parseInt(jugementsNumber.getAttribute('data-current-count'), 10) : 0;
            current_count += value;
        if (current_count < 0) {
            current_count = 0;
        }
        if(initialValue) {
            current_count = initialValue
        }
        jugementsNumber.setAttribute('data-current-count', current_count);

        if (hasLabel == 'true') {
            var jugementTxt = '';
            if (current_count > 1) {
                jugementTxt = 'Voir les ';
            } else if (current_count === 1) {
                jugementTxt = 'Voir ';
            }
            jugementsNumber.innerHTML = jugementTxt + current_count;
        } else {
            jugementsNumber.innerHTML = current_count;
        }
    }

    /**
     * add delele comment event
     */
    function addDeleteCommentEventListener(btn,jugementsNumber,hasLabel) {
        btn.addEventListener("click", async (e) => {
            e.preventDefault();
            e.target.closest(".comment-template").remove();

            const response = await fetch(`${API_BASE_URL}jugement-list/delete`, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: btn.dataset.commentid
                })
            });
            await response.json();
            updateJugementsNumbers(-1,jugementsNumber,hasLabel);
        });
    }

    /**
     * fetch comments/judgment
     */
    async function fetchComments(idRanking) {
        const response = await fetch(`${API_BASE_URL}jugement-list/getfromtoplist`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id_toplist_juge: idRanking
            })
        });
        return await response.json();
    }

    /**
     * save new judgment
     */
    async function sendJugement(comment, idRanking, uuid_user, jugementsNumber, hasLabel, responseToValue) {
        var toplistCommentsCard = document.querySelector(".toplist_comments"),
            commentsContainer = toplistCommentsCard.querySelector(".comments-container");
        
        // urlRanking, nameRanking ONLY FOR NOTIFICATION LATER
        let urlRanking  = false;
        var baseURLElement = document.querySelector(`[data-id-toplist="${idRanking}"]`);
        urlRanking = (baseURLElement && baseURLElement.dataset.linkToplist) ? baseURLElement.dataset.linkToplist : window.location.href;
        if (!urlRanking.endsWith('#jugement')) {
            urlRanking += (urlRanking.includes('#') ? '' : '/') + '#jugement';
        }
        let nameRanking = false;
        if(document.querySelector(`[data-id-toplist="${idRanking}"]`) && document.querySelector(`[data-id-toplist="${idRanking}"]`).dataset.nameToplist) {
            nameRanking = document.querySelector(`[data-id-toplist="${idRanking}"]`).dataset.nameToplist;
        } else {
            if(document.querySelector('.toplist_name') && document.querySelector('.toplist_question'))
                nameRanking = document.querySelector('.toplist_name').innerHTML + " - " + document.querySelector('.toplist_question').innerHTML;
        }
        const response = await fetch(`${API_BASE_URL}jugement-list/new`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id_toplist_juge: idRanking,
                uuid_juge: uuid_user,
                jugement: comment,
                responseto: responseToValue,
                toplist_link: urlRanking,
                toplist_name: nameRanking
            })
        });
        const newComment = await response.json();

        // ADD TO DOM…
        let commentTemplateDiv = await commentTemplate(newComment.id_jugement, uuid_user, comment, "0");
        commentsContainer.insertAdjacentHTML("beforeend", commentTemplateDiv);
        commentsContainer.scrollTop = commentsContainer.scrollHeight;

        // RESET DELETE BUTTONS…
        const deleteCommentsBtns = toplistCommentsCard.querySelectorAll(".deleteCommentBtn");
        deleteCommentsBtns.forEach((btn) => {
            addDeleteCommentEventListener(btn, jugementsNumber,hasLabel);
        });

        const replyCommentsBtns = toplistCommentsCard.querySelectorAll(".replyCommentBtn");
        replyCommentsBtns.forEach(addReplyCommentEventListener);
    }

    /**
     * validJudgement
     * @param e
     * @returns {Promise<void>}
     */
    const validJugement = async function (e) {
        e.preventDefault();
        let comment = commentArea.value;
        if (comment) {
            var noJugementTxtView = document.getElementById('id-no-jugement-txt-view');
            if (noJugementTxtView) {
                noJugementTxtView.remove();
            }
            commentArea.value = "";
            commentArea.focus();

            var inputElement = document.getElementById('id_toplist');
            var idTopList = inputElement.value;
            const responseToValue = document.getElementById('responseto').value;
            var numberShowSelector = inputElement.getAttribute('data-class-jugement-nbr');
            var jugementsNumber = document.querySelector(numberShowSelector);
            var hasLabel = inputElement.getAttribute('data-has-label');
            // SEND COMMENT TO SERVER…
            await sendJugement(comment, idTopList, uuid_user, jugementsNumber, hasLabel, responseToValue);

            var vainkeur_data = JSON.parse(localStorage.getItem("vainkeur_data"));
            if (vainkeur_data) {
                checkTrophy(vainkeur_data.id, 12);
            }
            // Increment
            updateJugementsNumbers(1,jugementsNumber,hasLabel);
        } else {
            commentArea.setAttribute(
                "placeholder",
                "Avec un petit mot ça marchera mieux 🤪"
            );
        }
    };

    /**
     * add the event on sendBtn to validate and save judgement
     */
    sendJugementBtn.addEventListener("click", validJugement);
    commentArea.addEventListener("keypress", (e) => {
        if (13 == e.keyCode) {
            e.preventDefault();
            validJugement(e);
        }
    });

    /**
     * initialise by toplist id
     */
    async function initializeTopListComments(idRanking,numberShowSelector = ".jugements-nbr" , hasLabel = false) {
        var jugementsNumber = document.querySelector(numberShowSelector);
        const commentsData = await fetchComments(idRanking);
        /**
         * update jugements count
         */
        updateJugementsNumbers(0,jugementsNumber,hasLabel,commentsData.length);
        commentsContainer.innerHTML = "";
        if (commentsData.length !== 0) {
            for (let comment of commentsData) {
                const currentDate = new Date();
                const specificDate = new Date(comment.date_jugement);
                const durationInSeconds = Math.floor((currentDate.getTime() - specificDate.getTime()) / 1000);
                const durationString = Math.abs(durationInSeconds);

                commentsContainer.insertAdjacentHTML(
                    "beforeend",
                    await commentTemplate(comment.id, comment.uuid_juge, comment.jugement, durationString)
                );
            }

            const deleteCommentsBtns = toplistCommentsCard.querySelectorAll(".deleteCommentBtn");
            deleteCommentsBtns.forEach((btn) => {
                addDeleteCommentEventListener(btn, jugementsNumber,hasLabel);
            });

            const replyCommentsBtns = toplistCommentsCard.querySelectorAll(".replyCommentBtn");
            replyCommentsBtns.forEach(addReplyCommentEventListener);

            commentsContainer.scrollTop = commentsContainer.scrollHeight;
        } else {
            commentsContainer.innerHTML = `<span id="id-no-jugement-txt-view">Pas encore de jugement, à toi de lancer les hostilités 😬</span>`;
        }
    }

    /**
     * on show offcanvas jugement
     */
    document.getElementById('jugement').addEventListener('show.bs.offcanvas', async function(event) {
        if (event && event.relatedTarget && event.relatedTarget.classList.contains('jugement-listing-trigger')) {
            document.querySelector(".toplist_comments").querySelector(".comments-container").innerHTML = "";
            /**
             * disable other btn
             */
            var jugementButtons = document.querySelectorAll('.jugement-listing-trigger');
            jugementButtons.forEach(function(button) {
                button.disabled = true;
            });
            try {
                let idRanking = event.relatedTarget.getAttribute('data-toplist-id');
                document.querySelector('#id_toplist').value = idRanking;
                document.querySelector('#id_toplist').setAttribute('data-class-jugement-nbr',".jugements-nbr-" + idRanking)
                document.querySelector('#id_toplist').setAttribute('data-has-label',false)
                document.querySelector('#uuid_juge').value  = uuid_user;
                await initializeTopListComments(idRanking, ".jugements-nbr-" + idRanking);
            } catch (error) {
                console.error('Erreur lors de l\'initialisation de Toplist Comments :', error);
            } finally {
                /**
                 * enable all btn
                 */
                jugementButtons.forEach(function(button) {
                    button.disabled = false;
                });
            }
        }
    });
</script>