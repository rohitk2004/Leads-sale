<?php
require_once 'db.php';
// functions.php starts session, but we can just use db.php and start session locally if we want to avoid overhead, 
// but let's be consistent. actually functions.php is fine.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        // Check if user should be redirected to checkout
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
        } elseif ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: developer_dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Quick Project</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

    <div class="auth-card">
        <div class="auth-logo">
            <h1>💼 Quick<span style="-webkit-text-fill-color: #059669;">Project</span></h1>
        </div>
        <p class="auth-subtitle">Login to your account</p>

        <?php if (isset($_GET['registered'])): ?>
            <div class="auth-message-success">✅ Registration successful! Please login.</div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="auth-message-error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter your username" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Login</button>
        </form>

        <p class="auth-footer">
            No account? <a href="register.php">Register here</a>
        </p>
    </div>

</body>

</html>