<?php
require_once 'functions.php';
require_once 'config.php';

// Require login for checkout
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'checkout';
    header("Location: login");
    exit;
}

$message = "";
$msg_type = "";

// Handle payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete_payment'])) {
    $result = process_checkout($pdo, $_SESSION['user_id']);
    $message = $result['message'];
    $msg_type = $result['success'] ? 'success' : 'error';

    if ($result['success']) {
        header("refresh:2;url=developer_dashboard");
    }
}

$cart_items = get_cart_items($pdo);
$total = 0;
foreach ($cart_items as $itm) {
    $total += $itm['lead_price'];
}
$current_balance = isset($_SESSION['user_id']) ? get_user_balance($pdo, $_SESSION['user_id']) : 0;
$can_afford = $current_balance >= $total;

if (empty($cart_items) && empty($message)) {
    header("Location: cart");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout & Enrollment - BlackHat SEO</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <section style="padding: 60px 0;">
        <div class="container" style="max-width: 900px;">
            <span class="section-tag">ENROLLMENT & PAYMENT</span>
            <h1 style="font-size: 36px; font-weight: 800; margin-bottom: 24px;">Complete Course Enrollment</h1>

            <?php if (!empty($message)): ?>
                <div class="glass-card" style="margin-bottom: 30px; border-color: <?php echo $msg_type == 'success' ? 'var(--emerald)' : 'var(--rose)'; ?>;">
                    <h3 style="color: <?php echo $msg_type == 'success' ? 'var(--emerald)' : 'var(--rose)'; ?>; font-size: 20px;">
                        <?php echo $msg_type == 'success' ? '✓ ' : '✗ '; ?>
                        <?php echo htmlspecialchars($message); ?>
                    </h3>
                    <?php if ($msg_type == 'success'): ?>
                        <p style="color: var(--ink-muted); margin-top: 8px;">Redirecting to your student dashboard...</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($cart_items)): ?>
                <div class="glass-card" style="padding: 32px; margin-bottom: 30px;">
                    <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 20px; color: var(--teal);">Enrolled Packages Summary</h3>
                    
                    <?php foreach ($cart_items as $item): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid var(--line);">
                            <div>
                                <div style="font-weight: 700; font-size: 16px; color: var(--ink);"><?php echo htmlspecialchars($item['niche']); ?></div>
                                <div style="font-size: 13px; color: var(--ink-muted);"><?php echo htmlspecialchars($item['description']); ?></div>
                            </div>
                            <div style="font-family: var(--font-display); font-size: 20px; font-weight: 800; color: var(--teal);">
                                ₹<?php echo number_format($item['lead_price']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 20px; font-size: 22px; font-weight: 800;">
                        <span>Total Due</span>
                        <span style="color: var(--amber);">₹<?php echo number_format($total); ?></span>
                    </div>
                </div>

                <div class="glass-card" style="padding: 32px; border-color: var(--teal-glow);">
                    <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 16px;">Student Wallet Balance</h3>
                    <p style="color: var(--ink-muted); margin-bottom: 16px;">Your current wallet balance is: <strong style="color: var(--teal);">₹<?php echo number_format($current_balance, 2); ?></strong></p>

                    <?php if ($can_afford): ?>
                        <form method="POST">
                            <button type="submit" name="complete_payment" class="btn-primary" style="width: 100%; justify-content: center; padding: 16px; font-size: 18px;">
                                Confirm Order & Access Course Materials &rarr;
                            </button>
                        </form>
                    <?php else: ?>
                        <div style="background: rgba(244, 63, 94, 0.15); border: 1px solid var(--rose); color: var(--rose); padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
                            ⚠️ Insufficient wallet balance (Needed: ₹<?php echo number_format($total); ?>).
                        </div>
                        <a href="wallet" class="btn-primary" style="display: inline-flex; justify-content: center;">Add Funds to Wallet &rarr;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>