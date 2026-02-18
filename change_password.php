<?php
require_once 'functions.php';
require_login();

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$message = "";
$msg_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($current) || empty($new) || empty($confirm)) {
        $message = "All fields are required.";
        $msg_type = "error";
    } elseif (strlen($new) < 6) {
        $message = "New password must be at least 6 characters.";
        $msg_type = "error";
    } elseif ($new !== $confirm) {
        $message = "New passwords do not match.";
        $msg_type = "error";
    } else {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if ($user && password_verify($current, $user['password'])) {
            $hashed = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed, $user_id]);
            $message = "Password changed successfully!";
            $msg_type = "success";
        } else {
            $message = "Current password is incorrect.";
            $msg_type = "error";
        }
    }
}

$dashboard_url = ($role === 'admin') ? 'admin_dashboard.php' : 'developer_dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password — QuickProject</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .cp-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .06);
        }

        .cp-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .84rem;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 24px;
            transition: color .2s;
        }

        .cp-back:hover {
            color: #111827;
        }

        .cp-back svg {
            width: 16px;
            height: 16px;
        }

        .cp-head {
            margin-bottom: 28px;
        }

        .cp-head h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 4px;
        }

        .cp-head p {
            color: #9ca3af;
            font-size: .88rem;
        }

        .cp-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: .85rem;
            font-weight: 500;
        }

        .cp-alert-ok {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #059669;
        }

        .cp-alert-er {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .cp-group {
            margin-bottom: 18px;
        }

        .cp-label {
            display: block;
            margin-bottom: 6px;
            font-size: .82rem;
            font-weight: 600;
            color: #374151;
        }

        .cp-input-wrap {
            position: relative;
        }

        .cp-input {
            width: 100%;
            padding: 11px 44px 11px 14px;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-family: inherit;
            font-size: .9rem;
            color: #111827;
            transition: all .2s;
        }

        .cp-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
            background: #fff;
        }

        .cp-input::placeholder {
            color: #9ca3af;
        }

        .cp-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 4px;
            transition: color .2s;
        }

        .cp-toggle:hover {
            color: #374151;
        }

        .cp-strength {
            height: 4px;
            background: #e5e7eb;
            border-radius: 4px;
            margin-top: 8px;
            overflow: hidden;
        }

        .cp-strength-bar {
            height: 100%;
            border-radius: 4px;
            transition: width .3s, background .3s;
            width: 0%;
        }

        .cp-hint {
            font-size: .72rem;
            color: #9ca3af;
            margin-top: 6px;
        }

        .cp-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-size: .92rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s;
            margin-top: 8px;
            box-shadow: 0 2px 10px rgba(37, 99, 235, .18);
        }

        .cp-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, .25);
        }

        .cp-footer {
            text-align: center;
            margin-top: 20px;
            font-size: .8rem;
            color: #9ca3af;
        }

        .cp-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="cp-card">
        <a href="<?php echo $dashboard_url; ?>" class="cp-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5m0 0l7 7m-7-7l7-7" />
            </svg>
            Back to Dashboard
        </a>

        <div class="cp-head">
            <h1>🔐 Change Password</h1>
            <p>Update your account password</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="cp-alert <?php echo $msg_type == 'success' ? 'cp-alert-ok' : 'cp-alert-er'; ?>">
                <?php echo $msg_type == 'success' ? '✅' : '⚠️'; ?>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="cp-group">
                <label class="cp-label">Current Password</label>
                <div class="cp-input-wrap">
                    <input type="password" name="current_password" id="cp1" class="cp-input" required
                        placeholder="Enter current password">
                    <button type="button" class="cp-toggle" onclick="tog('cp1')">👁</button>
                </div>
            </div>

            <div class="cp-group">
                <label class="cp-label">New Password</label>
                <div class="cp-input-wrap">
                    <input type="password" name="new_password" id="cp2" class="cp-input" required
                        placeholder="Enter new password" oninput="strength(this.value)">
                    <button type="button" class="cp-toggle" onclick="tog('cp2')">👁</button>
                </div>
                <div class="cp-strength">
                    <div class="cp-strength-bar" id="sbar"></div>
                </div>
                <div class="cp-hint">Minimum 6 characters</div>
            </div>

            <div class="cp-group">
                <label class="cp-label">Confirm New Password</label>
                <div class="cp-input-wrap">
                    <input type="password" name="confirm_password" id="cp3" class="cp-input" required
                        placeholder="Re-enter new password">
                    <button type="button" class="cp-toggle" onclick="tog('cp3')">👁</button>
                </div>
            </div>

            <button type="submit" class="cp-submit">Update Password</button>
        </form>

        <div class="cp-footer"><a href="<?php echo $dashboard_url; ?>">← Return to Dashboard</a></div>
    </div>

    <script>
        function tog(id) { var i = document.getElementById(id); i.type = i.type === 'password' ? 'text' : 'password'; }
        function strength(v) {
            var b = document.getElementById('sbar'), s = 0;
            if (v.length >= 6) s++; if (v.length >= 10) s++; if (/[A-Z]/.test(v)) s++; if (/[0-9]/.test(v)) s++; if (/[^a-zA-Z0-9]/.test(v)) s++;
            var p = [0, 20, 40, 60, 80, 100][s], c = ['#e5e7eb', '#ef4444', '#f59e0b', '#f59e0b', '#22c55e', '#22c55e'][s];
            b.style.width = p + '%'; b.style.background = c;
        }
    </script>
</body>

</html>