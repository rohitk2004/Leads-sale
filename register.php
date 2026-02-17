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

<body class="auth-page">

    <div class="auth-card">
        <div class="auth-logo">
            <h1>💼 Quick<span style="-webkit-text-fill-color: #059669;">Project</span></h1>
        </div>
        <p class="auth-subtitle">Create your account</p>

        <?php if (isset($error)): ?>
            <div class="auth-message-error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="Choose a username" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Create a strong password" required>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Create Account</button>

            <p class="auth-terms">
                By clicking 'Create Account', you agree to the QuickProject.in <a href="terms.php" target="_blank">Terms
                    &
                    Conditions</a> and <a href="terms.php#refund-policy" target="_blank">Refund Policy</a>.
            </p>
        </form>

        <p class="auth-footer">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>

</body>

</html>