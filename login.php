<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard");
    } else {
        header("Location: developer_dashboard");
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
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
            header("Location: admin_dashboard");
        } else {
            header("Location: developer_dashboard");
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
    <title>Student Login - BlackHat SEO Academy</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <section style="padding: 80px 0; min-height: 80vh; display: flex; align-items: center;">
        <div class="container" style="max-width: 480px;">
            <div class="glass-card" style="padding: 40px; border-color: var(--teal-glow);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <a href="index" class="brand-logo" style="justify-content: center; margin-bottom: 12px;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--amber);">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                        <span>BlackHat<span class="brand-badge">SEO</span></span>
                    </a>
                    <h2 style="font-size: 26px; font-weight: 800;">Student Portal Login</h2>
                    <p style="color: var(--ink-muted); font-size: 14px; margin-top: 6px;">Access your course modules & call gen tools.</p>
                </div>

                <?php if (isset($error)): ?>
                    <div style="background: rgba(244, 63, 94, 0.15); border: 1px solid var(--rose); color: var(--rose); padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
                        ⚠️ <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="e.g. seo_student" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 14px; margin-top: 10px;">
                        Sign In &rarr;
                    </button>
                </form>

                <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--ink-muted);">
                    Don't have an account? <a href="register" style="color: var(--teal); font-weight: 700;">Join Course</a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>