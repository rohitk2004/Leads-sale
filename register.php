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
    <title>Register - QuickProject</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="auth-body">

    <div class="auth-container">
        <!-- Left Panel - Brand -->
        <div class="auth-brand-panel">
            <div class="auth-brand-glow auth-brand-glow-1"></div>
            <div class="auth-brand-glow auth-brand-glow-2"></div>
            <div class="auth-brand-glow auth-brand-glow-3"></div>
            <div class="auth-brand-grid"></div>

            <div class="auth-brand-content">
                <a href="index" class="auth-brand-logo">
                    <span class="auth-logo-icon">💼</span>
                    <span class="auth-logo-text">QuickProject</span>
                </a>

                <h2 class="auth-brand-heading">Start closing<br><span class="auth-heading-accent">deals today.</span>
                </h2>
                <p class="auth-brand-tagline">Join 1,000+ developers who use QuickProject to find verified clients and
                    grow their business.</p>

                <!-- Stats Showcase -->
                <div class="auth-stats-showcase">
                    <div class="auth-stat-card">
                        <div class="auth-stat-number">500+</div>
                        <div class="auth-stat-text">Active Leads</div>
                    </div>
                    <div class="auth-stat-card">
                        <div class="auth-stat-number">₹50L+</div>
                        <div class="auth-stat-text">Deals Closed</div>
                    </div>
                    <div class="auth-stat-card">
                        <div class="auth-stat-number">1K+</div>
                        <div class="auth-stat-text">Developers</div>
                    </div>
                </div>

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
                <!-- Mobile Logo -->
                <a href="index" class="auth-mobile-logo">
                    <span>💼</span>
                    <span>QuickProject</span>
                </a>

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

                <form method="POST" class="auth-form" id="registerForm">
                    <div class="auth-input-group">
                        <label for="username">Username</label>
                        <div class="auth-input-wrap">
                            <svg class="auth-input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <input type="text" id="username" name="username" placeholder="Choose a username" required
                                autocomplete="username" minlength="3">
                        </div>
                        <span class="auth-input-hint">Must be at least 3 characters</span>
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
                                required autocomplete="new-password" minlength="6" oninput="checkStrength(this.value)">
                            <button type="button" class="auth-toggle-pw" onclick="togglePassword('password', this)"
                                aria-label="Toggle password visibility">
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" style="display:none">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                        </div>
                        <!-- Password Strength Bar -->
                        <div class="auth-pw-strength" id="pwStrength">
                            <div class="auth-pw-bar">
                                <div class="auth-pw-fill" id="pwFill"></div>
                            </div>
                            <span class="auth-pw-label" id="pwLabel"></span>
                        </div>
                    </div>

                    <button type="submit" class="auth-submit-btn" id="submitBtn">
                        <span class="btn-text">Create Account</span>
                        <svg class="btn-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </button>

                    <p class="auth-terms">
                        By clicking 'Create Account', you agree to the QuickProject
                        <a href="terms" target="_blank">Terms & Conditions</a> and
                        <a href="terms#refund-policy" target="_blank">Refund Policy</a>.
                    </p>
                </form>

                <div class="auth-form-footer">
                    <p>Already have an account? <a href="login">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const open = btn.querySelector('.eye-open');
            const closed = btn.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                open.style.display = 'none';
                closed.style.display = 'block';
            } else {
                input.type = 'password';
                open.style.display = 'block';
                closed.style.display = 'none';
            }
        }

        function checkStrength(pw) {
            const fill = document.getElementById('pwFill');
            const label = document.getElementById('pwLabel');
            const container = document.getElementById('pwStrength');
            let score = 0;
            if (pw.length >= 6) score++;
            if (pw.length >= 10) score++;
            if (/[A-Z]/.test(pw)) score++;
            if (/[0-9]/.test(pw)) score++;
            if (/[^A-Za-z0-9]/.test(pw)) score++;

            container.style.display = pw.length > 0 ? 'flex' : 'none';

            const levels = [
                { w: '20%', c: '#ef4444', t: 'Very weak' },
                { w: '40%', c: '#f59e0b', t: 'Weak' },
                { w: '60%', c: '#eab308', t: 'Fair' },
                { w: '80%', c: '#22c55e', t: 'Strong' },
                { w: '100%', c: '#10b981', t: 'Very strong' },
            ];
            const level = levels[Math.min(score, 4)];
            fill.style.width = level.w;
            fill.style.background = level.c;
            label.textContent = level.t;
            label.style.color = level.c;
        }
    </script>

</body>

</html>