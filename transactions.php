<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'connection.php';

$logs = [];
$errorMsg = '';

try {
    $stmt = $pdo->query("SELECT * FROM transactions ORDER BY log_time DESC");
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorMsg = "Database table 'transactions' not found. Please run the SQL script in phpMyAdmin.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transactions & Logs - CampusEvents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #2b313d 0%, #4e607c 50%, #a5b1c3 100%);
            color: #2b313d;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 40px;
        }
        .container-box { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 30px; 
            border-radius: 16px; 
            box-shadow: 0 8px 24px rgba(43, 49, 61, 0.25); 
            margin-top: 30px; 
            border-top: 5px solid #4e607c;
        }
        .navbar-custom { background-color: rgba(43, 49, 61, 0.9); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">🌊 CampusEvents Dashboard</a>
        <div>
            <a href="index.php" class="btn btn-outline-light btn-sm me-2">Back to Events</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Sign Out</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="container-box">
        <h2 class="fw-bold mb-3">System Transactions & Activity Logs</h2>
        <p class="text-muted">Tracking all user actions and database transactions.</p>

        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Action Type</th>
                        <th>Details</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($logs) > 0): ?>
                        <?php foreach ($logs as $index => $log): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><strong><?php echo htmlspecialchars($log['username']); ?></strong></td>
                                <td>
                                    <?php 
                                        $badgeColor = 'bg-secondary';
                                        if ($log['action_type'] === 'CREATE') $badgeColor = 'bg-success';
                                        elseif ($log['action_type'] === 'UPDATE') $badgeColor = 'bg-primary';
                                        elseif ($log['action_type'] === 'DELETE') $badgeColor = 'bg-danger';
                                    ?>
                                    <span class="badge <?php echo $badgeColor; ?>"><?php echo htmlspecialchars($log['action_type']); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($log['details']); ?></td>
                                <td><?php echo htmlspecialchars($log['log_time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">No transaction logs recorded yet. Try adding, updating, or deleting an event!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>