<?php
session_start();
include 'connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In - CampusEvents</title>
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
    <p class="text-center text-muted mb-4">Secure User Login[cite: 5, 16]</p>
    
    <?php if (!empty($error)): ?><div class="alert alert-danger py-2"><?php echo $error; ?></div><?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label text-secondary">Username</label>
            <input type="text" name="username" class="form-control" required placeholder="e.g. avery_coordinator">
        </div>
        <div class="mb-3">
            <label class="form-label text-secondary">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-custom w-100 py-2 mt-2">Sign In</button>
    </form>
    <div class="text-center mt-3 small">
        Don't have an account? <a href="register.php" class="text-decoration-none fw-bold" style="color: #4e607c;">Register here</a>
    </div>
</div>
</body>
</html>