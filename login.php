<?php
require_once 'db.php';
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="auth-body">

    <div class="auth-container">
        <!-- Left Panel - Brand -->
        <div class="auth-brand-panel">
            <div class="auth-brand-glow auth-brand-glow-1"></div>
            <div class="auth-brand-glow auth-brand-glow-2"></div>
            <div class="auth-brand-grid"></div>

            <div class="auth-brand-content">
                <a href="index.php" class="auth-brand-logo">
                    <span class="auth-logo-icon">💼</span>
                    <span class="auth-logo-text">QuickProject</span>
                </a>

                <h2 class="auth-brand-heading">Welcome back,<br>developer.</h2>
                <p class="auth-brand-tagline">Access your dashboard, manage leads, and close more deals — all in one
                    place.</p>

                <div class="auth-brand-stats">
                    <div class="auth-brand-stat">
                        <span class="auth-brand-stat-icon">🔒</span>
                        <span>Secure Login</span>
                    </div>
                    <div class="auth-brand-stat">
                        <span class="auth-brand-stat-icon">⚡</span>
                        <span>Instant Access</span>
                    </div>
                    <div class="auth-brand-stat">
                        <span class="auth-brand-stat-icon">🛡️</span>
                        <span>Data Protected</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="auth-form-panel">
            <div class="auth-form-wrapper">
                <div class="auth-form-header">
                    <h1>Sign In</h1>
                    <p>Enter your credentials to access your account</p>
                </div>

                <?php if (isset($_GET['registered'])): ?>
                    <div class="auth-alert auth-alert-success">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Registration successful! Please login.</span>
                    </div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="auth-alert auth-alert-error">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="15" y1="9" x2="9" y2="15" />
                            <line x1="9" y1="9" x2="15" y2="15" />
                        </svg>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" class="auth-form">
                    <div class="auth-input-group">
                        <label for="username">Username</label>
                        <div class="auth-input-wrap">
                            <svg class="auth-input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <input type="text" id="username" name="username" placeholder="Enter your username" required>
                        </div>
                    </div>

                    <div class="auth-input-group">
                        <label for="password">Password</label>
                        <div class="auth-input-wrap">
                            <svg class="auth-input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                            <input type="password" id="password" name="password" placeholder="Enter your password"
                                required>
                        </div>
                    </div>

                    <button type="submit" class="auth-submit-btn">
                        <span>Sign In</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </button>
                </form>

                <div class="auth-form-footer">
                    <p>Don't have an account? <a href="register.php">Create one free</a></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>