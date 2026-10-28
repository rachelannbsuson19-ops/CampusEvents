<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'connection.php';
include 'classes/event.php';

$eventObj = new Event($pdo);
$events = $eventObj->getAllEvents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusEvents - Student Event Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #2b313d 0%, #4e607c 50%, #a5b1c3 100%);
            color: #2b313d;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 40px;
        }
        .board-container { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 30px; 
            border-radius: 16px; 
            box-shadow: 0 8px 24px rgba(43, 49, 61, 0.25); 
            margin-top: 30px; 
            border-top: 5px solid #4e607c;
        }
        .table-custom-header { background-color: #2b313d !important; color: #fff !important; }
        .navbar-custom { background-color: rgba(43, 49, 61, 0.9); }
        
        /* Pale Light Ocean Button for Transactions */
        .btn-pale-ocean {
            background-color: #a5b1c3;
            color: #2b313d;
            border: none;
            font-weight: 600;
        }
        .btn-pale-ocean:hover {
            background-color: #8c9cb3;
            color: #2b313d;
        }

        /* Light Dark Pastel Green Moss Palette */
        .btn-moss-add {
            background-color: #728c79; 
            color: #fff;
            border: none;
            font-weight: 600;
        }
        .btn-moss-add:hover {
            background-color: #5c7563;
            color: #fff;
        }

        .btn-ocean-update {
            background-color: #788e9b; 
            color: #fff;
            border: none;
            font-weight: 600;
        }
        .btn-ocean-update:hover {
            background-color: #5d7380;
            color: #fff;
        }

        .btn-dark-coral-delete {
            background-color: #d1887e; 
            color: #fff;
            border: none;
            font-weight: 600;
        }
        .btn-dark-coral-delete:hover {
            background-color: #b56e63;
            color: #fff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">🌊 CampusEvents Dashboard</a>
        <div class="d-flex align-items-center">
            <a href="transactions.php" class="btn btn-pale-ocean btn-sm me-3 shadow-sm">View Transactions</a>
            <span class="text-light me-3">User: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> (<?php echo htmlspecialchars($_SESSION['role']); ?>)</span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Sign Out</a>
        </div>
    </div>
</nav>

<div class="container">

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-<?php echo htmlspecialchars($_SESSION['flash']['type']); ?> alert-dismissible fade show shadow-sm mt-4 mb-0" role="alert">
            <?php echo htmlspecialchars($_SESSION['flash']['msg']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="board-container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2>Student Event Board</h2>
                <p class="text-muted mb-0">View approved upcoming seminars and manage workshop schedules.</p>
            </div>
            <button class="btn btn-moss-add shadow-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">+ Add New Event</button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="table-custom-header">
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date & Time</th>
                        <th>Venue</th>
                        <th>Organizer</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($events) > 0): ?>
                        <?php foreach ($events as $index => $event): ?>
                            <tr>
                                <td><strong><?php echo $index + 1; ?></strong></td>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td class="text-muted"><?php echo htmlspecialchars($event['description']); ?></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($event['event_date']); ?></span></td>
                                <td><?php echo htmlspecialchars($event['venue']); ?></td>
                                <td><?php echo htmlspecialchars($event['organizer']); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-ocean-update btn-sm update-btn me-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateEventModal"
                                        data-id="<?php echo $event['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($event['title']); ?>"
                                        data-description="<?php echo htmlspecialchars($event['description']); ?>"
                                        data-date="<?php echo $event['event_date']; ?>"
                                        data-venue="<?php echo htmlspecialchars($event['venue']); ?>"
                                        data-organizer="<?php echo htmlspecialchars($event['organizer']); ?>">
                                        Update
                                    </button>
                                    <button class="btn btn-dark-coral-delete btn-sm delete-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteEventModal"
                                        data-id="<?php echo $event['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($event['title']); ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">No upcoming seminars found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'modals/add_event.php'; ?>
<?php include 'modals/update_event.php'; ?>
<?php include 'modals/delete_event.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('update_id').value = this.dataset.id;
            document.getElementById('update_title').value = this.dataset.title;
            document.getElementById('update_description').value = this.dataset.description;
            document.getElementById('update_event_date').value = this.dataset.date.replace(' ', 'T');
            document.getElementById('update_venue').value = this.dataset.venue;
            document.getElementById('update_organizer').value = this.dataset.organizer;
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('delete_id').value = this.dataset.id;
            document.getElementById('delete_title_text').textContent = this.dataset.title;
        });
    });
</script>
</body>
</html>