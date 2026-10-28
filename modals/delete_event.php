<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="backend/event_code.php" method="POST" class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold">Delete Seminar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" id="delete_id">
        <p>Are you sure you want to delete <strong id="delete_title_text"></strong>?</p>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-danger">Delete</button></div>
    </form>
  </div>
</div>