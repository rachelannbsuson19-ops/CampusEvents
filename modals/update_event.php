<div class="modal fade" id="updateEventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="backend/event_code.php" method="POST" class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold">Update Event Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" id="update_id">
        <div class="mb-3"><label class="form-label">Event Title</label><input type="text" class="form-control" name="title" id="update_title" required></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" id="update_description" required></textarea></div>
        <div class="mb-3"><label class="form-label">Event Date & Time</label><input type="datetime-local" class="form-control" name="event_date" id="update_event_date" required></div>
        <div class="mb-3"><label class="form-label">Venue / Room</label><input type="text" class="form-control" name="venue" id="update_venue" required></div>
        <div class="mb-3"><label class="form-label">Organizer / Department</label><input type="text" class="form-control" name="organizer" id="update_organizer" required></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save Changes</button></div>
    </form>
  </div>
</div>