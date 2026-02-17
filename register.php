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

                <h2 class="auth-brand-heading">Start closing<br>deals today.</h2>
                <p class="auth-brand-tagline">Join 1,000+ developers who use QuickProject to find verified clients and
                    grow their business.</p>

                <div class="auth-brand-stats">
                    <div class="auth-brand-stat">
                        <span class="auth-brand-stat-icon">✅</span>
                        <span>Free to Join</span>
                    </div>
                    <div class="auth-brand-stat">
                        <span class="auth-brand-stat-icon">🎯</span>
                        <span>Verified Leads</span>
                    </div>
                    <div class="auth-brand-stat">
                        <span class="auth-brand-stat-icon">💰</span>
                        <span>No Subscription</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="auth-form-panel">
            <div class="auth-form-wrapper">
                <div class="auth-form-header">
                    <h1>Create Account</h1>
                    <p>Get started with your free developer account</p>
                </div>

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
                            <input type="text" id="username" name="username" placeholder="Choose a username" required>
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
                            <input type="password" id="password" name="password" placeholder="Create a strong password"
                                required minlength="6">
                        </div>
                    </div>

                    <button type="submit" class="auth-submit-btn">
                        <span>Create Account</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </button>

                    <p class="auth-terms">
                        By clicking 'Create Account', you agree to the QuickProject
                        <a href="terms.php" target="_blank">Terms & Conditions</a> and
                        <a href="terms.php#refund-policy" target="_blank">Refund Policy</a>.
                    </p>
                </form>

                <div class="auth-form-footer">
                    <p>Already have an account? <a href="login.php">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>