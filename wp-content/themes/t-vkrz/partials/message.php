<div class="offcanvas offcanvas-end top_message bg-deg" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="messages" aria-labelledby="offcanvasScrollLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasScrollLabel" class="offcanvas-title">
      <span class="va va-envelope-in va-lg" style="margin-top: -8px;margin-left: -10px;"></span> Envoyer un message
    </h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <ul class="comments-container media-list info-message" id="top_message">
    </ul>
    <div class="card-footer border-0">
      <div class="d-flex align-items-center commentarea-container">
        <form id="messageForm">
          <textarea id="messageInput" name="message" placeholder="Ton message..."></textarea>
          <input type="hidden" id="id_top" name="id_top">
          <input type="hidden" id="top_name" name="top_name">
          <input type="hidden" id="uuid_message" name="uuid_message">
          <input type="hidden" id="uuid_message_receiver" name="uuid_message_receiver">
          <button id="send_message_btn" type="submit">
            <span class="va va-icon-arrow-up va-z-40"></span>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>