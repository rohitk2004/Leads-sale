<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE)
    session_start();

$step = 1; // 1 = enter username, 2 = set new password, 3 = done
$message = "";
$msg_type = "";
$reset_username = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Step 1: Verify username exists
    if (isset($_POST['find_user'])) {
        $username = trim($_POST['username'] ?? '');
        if (empty($username)) {
            $message = "Please enter your username.";
            $msg_type = "error";
        } else {
            $stmt = $pdo->prepare("SELECT id, username FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if ($user) {
                $step = 2;
                $reset_username = $user['username'];
            } else {
                $message = "No account found with that username.";
                $msg_type = "error";
            }
        }
    }

    // Step 2: Set new password
    if (isset($_POST['reset_password'])) {
        $username = trim($_POST['reset_username'] ?? '');
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (empty($new) || empty($confirm)) {
            $message = "Both fields are required.";
            $msg_type = "error";
            $step = 2;
            $reset_username = $username;
        } elseif (strlen($new) < 6) {
            $message = "Password must be at least 6 characters.";
            $msg_type = "error";
            $step = 2;
            $reset_username = $username;
        } elseif ($new !== $confirm) {
            $message = "Passwords do not match.";
            $msg_type = "error";
            $step = 2;
            $reset_username = $username;
        } else {
            $hashed = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->execute([$hashed, $username]);
            $step = 3;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — QuickProject</title>
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

        .fp-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 460px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .06);
        }

        .fp-back {
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

        .fp-back:hover {
            color: #111827;
        }

        .fp-back svg {
            width: 16px;
            height: 16px;
        }

        .fp-head {
            margin-bottom: 28px;
        }

        .fp-head h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 4px;
        }

        .fp-head p {
            color: #9ca3af;
            font-size: .88rem;
            line-height: 1.5;
        }

        .fp-steps {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .fp-step {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .75rem;
            font-weight: 600;
            color: #9ca3af;
        }

        .fp-step.active {
            color: #2563eb;
        }

        .fp-step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .68rem;
            font-weight: 700;
        }

        .fp-step.active .fp-step-num {
            background: #2563eb;
            color: #fff;
        }

        .fp-step.done .fp-step-num {
            background: #059669;
            color: #fff;
        }

        .fp-step-line {
            width: 40px;
            height: 2px;
            background: #e5e7eb;
            border-radius: 2px;
        }

        .fp-step.active~.fp-step-line,
        .fp-step.active~.fp-step .fp-step-line {
            background: #e5e7eb;
        }

        .fp-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: .85rem;
            font-weight: 500;
        }

        .fp-alert-ok {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #059669;
        }

        .fp-alert-er {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .fp-group {
            margin-bottom: 18px;
        }

        .fp-label {
            display: block;
            margin-bottom: 6px;
            font-size: .82rem;
            font-weight: 600;
            color: #374151;
        }

        .fp-input {
            width: 100%;
            padding: 11px 14px;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-family: inherit;
            font-size: .9rem;
            color: #111827;
            transition: all .2s;
        }

        .fp-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
            background: #fff;
        }

        .fp-input::placeholder {
            color: #9ca3af;
        }

        .fp-submit {
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
            box-shadow: 0 2px 10px rgba(37, 99, 235, .18);
        }

        .fp-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, .25);
        }

        .fp-success {
            text-align: center;
            padding: 20px 0;
        }

        .fp-success-icon {
            font-size: 3rem;
            margin-bottom: 12px;
        }

        .fp-success h2 {
            font-size: 1.2rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .fp-success p {
            color: #6b7280;
            font-size: .88rem;
            margin-bottom: 20px;
        }

        .fp-success a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #fff;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: .88rem;
            text-decoration: none;
            transition: all .25s;
        }

        .fp-success a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, .25);
        }

        .fp-footer {
            text-align: center;
            margin-top: 20px;
            font-size: .8rem;
            color: #9ca3af;
        }

        .fp-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .fp-user-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #2563eb;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: .82rem;
            font-weight: 600;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <div class="fp-card">
        <a href="login.php" class="fp-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5m0 0l7 7m-7-7l7-7" />
            </svg>
            Back to Login
        </a>

        <div class="fp-head">
            <h1>🔑 Reset Password</h1>
            <p>
                <?php
                if ($step == 1)
                    echo "Enter your username to find your account.";
                elseif ($step == 2)
                    echo "Set a new password for your account.";
                else
                    echo "Your password has been reset.";
                ?>
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="fp-steps">
            <div class="fp-step <?php echo $step >= 1 ? 'active' : ''; ?> <?php echo $step > 1 ? 'done' : ''; ?>"><span
                    class="fp-step-num">
                    <?php echo $step > 1 ? '✓' : '1'; ?>
                </span>Find Account</div>
            <div class="fp-step-line"></div>
            <div class="fp-step <?php echo $step >= 2 ? 'active' : ''; ?> <?php echo $step > 2 ? 'done' : ''; ?>"><span
                    class="fp-step-num">
                    <?php echo $step > 2 ? '✓' : '2'; ?>
                </span>New Password</div>
            <div class="fp-step-line"></div>
            <div class="fp-step <?php echo $step >= 3 ? 'active' : ''; ?>"><span class="fp-step-num">3</span>Done</div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="fp-alert <?php echo $msg_type == 'success' ? 'fp-alert-ok' : 'fp-alert-er'; ?>">
                <?php echo $msg_type == 'success' ? '✅' : '⚠️'; ?>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($step == 1): ?>
            <form method="POST">
                <input type="hidden" name="find_user" value="1">
                <div class="fp-group">
                    <label class="fp-label">Username</label>
                    <input type="text" name="username" class="fp-input" required placeholder="Enter your username"
                        autofocus>
                </div>
                <button type="submit" class="fp-submit">Find My Account →</button>
            </form>
        <?php endif; ?>

        <?php if ($step == 2): ?>
            <div class="fp-user-badge">👤
                <?php echo htmlspecialchars($reset_username); ?>
            </div>
            <form method="POST">
                <input type="hidden" name="reset_password" value="1">
                <input type="hidden" name="reset_username" value="<?php echo htmlspecialchars($reset_username); ?>">
                <div class="fp-group">
                    <label class="fp-label">New Password</label>
                    <input type="password" name="new_password" class="fp-input" required
                        placeholder="Enter new password (min 6 chars)">
                </div>
                <div class="fp-group">
                    <label class="fp-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="fp-input" required
                        placeholder="Re-enter new password">
                </div>
                <button type="submit" class="fp-submit">Reset Password →</button>
            </form>
        <?php endif; ?>

        <?php if ($step == 3): ?>
            <div class="fp-success">
                <div class="fp-success-icon">🎉</div>
                <h2>Password Reset Successful!</h2>
                <p>Your password has been updated. You can now login with your new password.</p>
                <a href="login.php">Go to Login →</a>
            </div>
        <?php endif; ?>

        <div class="fp-footer">Remember your password? <a href="login.php">Sign In</a></div>
    </div>
</body>

</html>