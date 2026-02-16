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

<body style="display: flex; align-items: center; justify-content: center; height: 100vh;">

    <div class="card" style="width: 100%; max-width: 400px;">
        <h1 style="text-align: center; color: var(--success-color);">Quick Project</h1>
        <h2 style="text-align: center; color: var(--text-muted); font-size: 1.2rem; margin-bottom: 30px;">Login to
            Account</h2>

        <?php if (isset($_GET['registered']))
            echo "<p style='color: var(--success-color); text-align:center;'>Registration successful! Please login.</p>"; ?>
        <?php if (isset($error))
            echo "<p style='color: var(--accent-color); text-align:center;'>$error</p>"; ?>

        <form method="POST">
            <label class="text-muted">Username</label>
            <input type="text" name="username" required>

            <label class="text-muted">Password</label>
            <input type="password" name="password" required>

            <button type="submit" class="btn btn-green" style="width: 100%; margin-top: 10px;">Login</button>
        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
            No account? <a href="register.php">Register here</a>
        </p>
    </div>

</body>

</html>