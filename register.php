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
            header("Location: login?registered=1");
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
    <title>Student Registration - BlackHat SEO Academy</title>
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
                    <h2 style="font-size: 26px; font-weight: 800;">Create Student Account</h2>
                    <p style="color: var(--ink-muted); font-size: 14px; margin-top: 6px;">Join 18,640+ marketers & call center owners.</p>
                </div>

                <?php if (isset($error)): ?>
                    <div style="background: rgba(244, 63, 94, 0.15); border: 1px solid var(--rose); color: var(--rose); padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
                        ⚠️ <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">Desired Username</label>
                        <input type="text" name="username" class="form-control" placeholder="e.g. seo_master" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 14px; margin-top: 10px;">
                        Register Student Account &rarr;
                    </button>
                </form>

                <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--ink-muted);">
                    Already have an account? <a href="login" style="color: var(--teal); font-weight: 700;">Log In</a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>