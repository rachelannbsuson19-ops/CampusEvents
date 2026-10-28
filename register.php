<?php
session_start();
include 'connection.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $role]);
        $success = "Registration successful! You can now <a href='login.php'>Sign In</a>.";
    } catch (PDOException $e) {
        $error = "Username already taken or database error!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - CampusEvents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2b313d 0%, #4e607c 50%, #a5b1c3 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(43, 49, 61, 0.3);
            width: 100%;
            max-width: 420px;
            border-top: 5px solid #4e607c;
        }
        .btn-custom { background-color: #4e607c; color: #fff; font-weight: 600; }
        .btn-custom:hover { background-color: #2b313d; color: #fff; }
    </style>
</head>
<body>
<div class="auth-card">
    <h3 class="text-center mb-3 fw-bold" style="color: #2b313d;">🌊 CampusEvents</h3>
    <p class="text-center text-muted mb-4">Create a New User Account</p>
    
    <?php if (!empty($error)): ?><div class="alert alert-danger py-2"><?php echo $error; ?></div><?php endif; ?>
    <?php if (!empty($success)): ?><div class="alert alert-success py-2"><?php echo $success; ?></div><?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label text-secondary">Username</label>
            <input type="text" name="username" class="form-control" required placeholder="Choose a username">
        </div>
        <div class="mb-3">
            <label class="form-label text-secondary">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="••••••••">
        </div>
        <div class="mb-3">
            <label class="form-label text-secondary">Role</label>
            <select name="role" class="form-select">
                <option value="Student">Student</option>
                <option value="Professor">Professor</option>
                <option value="Coordinator">Coordinator</option>
            </select>
        </div>
        <button type="submit" class="btn btn-custom w-100 py-2 mt-2">Register</button>
    </form>
    <div class="text-center mt-3 small">
        Already have an account? <a href="login.php" class="text-decoration-none fw-bold" style="color: #4e607c;">Sign In</a>
    </div>
</div>
</body>
</html>