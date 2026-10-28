<div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="backend/event_code.php" method="POST" class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold">Add New Seminar Proposal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" value="add">
        <div class="mb-3"><label class="form-label">Event Title</label><input type="text" class="form-control" name="title" required></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" required></textarea></div>
        <div class="mb-3"><label class="form-label">Event Date & Time</label><input type="datetime-local" class="form-control" name="event_date" required></div>
        <div class="mb-3"><label class="form-label">Venue / Room</label><input type="text" class="form-control" name="venue" required></div>
        <div class="mb-3"><label class="form-label">Organizer / Department</label><input type="text" class="form-control" name="organizer" required></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-success">+ Add Event</button></div>
    </form>
  </div>
</div>