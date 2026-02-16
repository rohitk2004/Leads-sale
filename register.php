<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'developer';
    $wallet_balance = 0.00;

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $error = "Username already exists.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, wallet_balance) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $hashed_password, $role, $wallet_balance])) {
            header("Location: login.php?registered=1");
            exit;
        } else {
            $error = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Quick Project</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="display: flex; align-items: center; justify-content: center; height: 100vh;">

    <div class="card" style="width: 100%; max-width: 400px;">
        <h1 style="text-align: center; color: var(--success-color);">Join Quick Project</h1>
        <h2 style="text-align: center; color: var(--text-muted); font-size: 1.2rem; margin-bottom: 30px;">Create Account
        </h2>

        <?php if (isset($error))
            echo "<p style='color: var(--accent-color); text-align:center;'>$error</p>"; ?>

        <form method="POST">
            <label class="text-muted">Username</label>
            <input type="text" name="username" required>

            <label class="text-muted">Password</label>
            <input type="password" name="password" required>

            <button type="submit" class="btn btn-green" style="width: 100%; margin-top: 10px;">Register</button>

            <p style="font-size: 0.8rem; color: #64748b; margin-top: 15px; text-align: center; line-height: 1.4;">
                By clicking 'Register', you agree to the QuickProject.in <a href="terms.php" target="_blank"
                    style="color: #059669;">Terms & Conditions</a> and <a href="terms.php#refund-policy" target="_blank"
                    style="color: #059669;">Refund Policy</a>.
            </p>
        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>

</body>

</html>