<?php
require_once 'functions.php';

// Handle Remove Item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_item'])) {
    $cart_id = $_POST['cart_id'];
    remove_from_cart($pdo, $cart_id);
    header("Location: cart");
    exit;
}

// Handle Clear Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clear_cart'])) {
    clear_cart($pdo);
    header("Location: cart");
    exit;
}

$cart_items = get_cart_items($pdo);
$cart_total = get_cart_total($pdo);
$cart_count = count($cart_items);

// Get user balance if logged in
$user_balance = 0;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT wallet_balance FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user_balance = $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Cart - BlackHat SEO Academy</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <section style="padding: 60px 0;">
        <div class="container">
            <span class="section-tag">SHOPPING CART</span>
            <h1 style="font-size: 36px; font-weight: 800; margin-bottom: 30px;">Selected SEO Courses & Packages</h1>

            <?php if (empty($cart_items)): ?>
                <div class="glass-card" style="text-align: center; padding: 60px 20px;">
                    <div style="font-size: 48px; margin-bottom: 16px;">🛒</div>
                    <h3 style="font-size: 24px; margin-bottom: 10px;">Your cart is empty</h3>
                    <p style="color: var(--ink-muted); margin-bottom: 24px;">Browse our available course packages and add them to your cart.</p>
                    <a href="available_leads" class="btn-primary">Browse Available Courses</a>
                </div>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                    
                    <!-- Cart Items -->
                    <div class="glass-card" style="padding: 0; overflow: hidden;">
                        <div style="padding: 20px 28px; background: rgba(255,255,255,0.03); border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="font-size: 18px; font-weight: 700;">Cart Items (<?php echo $cart_count; ?>)</h3>
                            <form method="POST">
                                <button type="submit" name="clear_cart" style="background: none; border: none; color: var(--rose); font-size: 13px; cursor: pointer;">Clear Cart</button>
                            </form>
                        </div>

                        <div style="padding: 0 28px;">
                            <?php foreach ($cart_items as $item): ?>
                                <div style="padding: 20px 0; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div class="category-tag" style="margin-bottom: 6px; inline-size: max-content;"><?php echo htmlspecialchars($item['niche']); ?></div>
                                        <div style="font-size: 18px; font-weight: 700; color: var(--ink);"><?php echo htmlspecialchars($item['niche']); ?></div>
                                        <div style="font-size: 13px; color: var(--ink-muted);"><?php echo htmlspecialchars($item['description']); ?></div>
                                    </div>
                                    <div style="text-align: right;">
                                        <div style="font-family: var(--font-display); font-size: 22px; font-weight: 800; color: var(--teal); margin-bottom: 8px;">
                                            ₹<?php echo number_format($item['lead_price']); ?>
                                        </div>
                                        <form method="POST">
                                            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                            <button type="submit" name="remove_item" style="background: none; border: none; color: var(--ink-dim); font-size: 12px; cursor: pointer; text-decoration: underline;">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="glass-card" style="padding: 28px; height: fit-content; border-color: var(--teal-glow);">
                        <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 20px;">Order Summary</h3>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; color: var(--ink-muted);">
                            <span>Subtotal</span>
                            <span>₹<?php echo number_format($cart_total); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 15px; color: var(--ink-muted);">
                            <span>Access & Setup Fee</span>
                            <span style="color: var(--emerald);">FREE</span>
                        </div>

                        <hr style="border: none; border-top: 1px solid var(--line); margin-bottom: 20px;">

                        <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 20px; font-weight: 800; color: var(--ink);">
                            <span>Total</span>
                            <span style="color: var(--teal);">₹<?php echo number_format($cart_total); ?></span>
                        </div>

                        <a href="checkout" class="btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 16px;">
                            Proceed to Checkout &rarr;
                        </a>
                    </div>

                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>