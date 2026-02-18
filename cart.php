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

// Checkout logic has been moved to checkout.php

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
    <title>Shopping Cart - Quick Project</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-section {
            padding: 60px 0;
            background-color: #f8fafc;
            min-height: 60vh;
        }

        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .cart-items-box {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .cart-header {
            padding: 20px 30px;
            background: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-header h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #334155;
        }

        .cart-item {
            padding: 25px 30px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.2s;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item:hover {
            background-color: #f8fafc;
        }

        .item-info {
            flex: 1;
        }

        .item-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            display: block;
        }

        .item-meta {
            font-size: 0.9rem;
            color: #64748b;
            display: flex;
            gap: 15px;
        }

        .item-price {
            font-weight: 700;
            color: #0f172a;
            font-size: 1.1rem;
        }

        .btn-remove {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
        }

        .btn-remove:hover {
            background-color: #fef2f2;
        }

        .cart-summary-box {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #64748b;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 1.3rem;
            font-weight: 800;
            color: #0f172a;
        }

        .btn-checkout {
            width: 100%;
            margin-top: 25px;
            padding: 16px;
            font-size: 1.1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 16px;
            grid-column: 1 / -1;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            grid-column: 1 / -1;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }

        @media (max-width: 900px) {
            .cart-container {
                grid-template-columns: 1fr;
            }

            .cart-summary-box {
                position: static;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Shopping Cart</h1>
            <p class="page-subtitle">Review your selected leads before purchase</p>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">


            <?php if (empty($cart_items)): ?>
                <div class="cart-container">
                    <div class="cart-items-box empty-cart">
                        <div class="empty-icon">🛒</div>
                        <h2>Your cart is empty</h2>
                        <p style="margin-bottom: 30px; color: #64748b;">Looks like you haven't added any leads yet.</p>
                        <a href="available_leads" class="btn btn-primary">Browse Available Leads</a>
                    </div>
                </div>
            <?php else: ?>

                <div class="cart-container">
                    <!-- Cart Items List -->
                    <div class="cart-items-box">
                        <div class="cart-header">
                            <h3><?php echo $cart_count; ?> Item<?php echo $cart_count !== 1 ? 's' : ''; ?> in Cart</h3>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?');">
                                <input type="hidden" name="clear_cart" value="1">
                                <button type="submit" class="btn-remove" style="color: #64748b;">
                                    Clear Cart
                                </button>
                            </form>
                        </div>

                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-item animate-in">
                                <div class="item-info">
                                    <span class="item-title"><?php echo htmlspecialchars($item['niche']); ?> Lead</span>
                                    <div class="item-meta">
                                        <span>👤 <?php echo htmlspecialchars($item['client_name']); ?></span>
                                        <span>💰 Budget: ₹<?php echo number_format($item['budget']); ?>+</span>
                                    </div>
                                </div>
                                <div class="item-price">
                                    ₹<?php echo number_format($item['lead_price']); ?>
                                </div>
                                <div style="margin-left: 20px;">
                                    <form method="POST">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                        <input type="hidden" name="remove_item" value="1">
                                        <button type="submit" class="btn-remove" title="Remove Item">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary-box animate-in">
                        <h3 style="margin-bottom: 25px;">Order Summary</h3>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>₹<?php echo number_format($cart_total); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (0%)</span>
                            <span>₹0</span>
                        </div>

                        <div class="summary-total">
                            <span>Total</span>
                            <span>₹<?php echo number_format($cart_total); ?></span>
                        </div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div
                                style="margin-top: 20px; padding: 15px; background: #e0f2fe; border-radius: 8px; font-size: 0.9rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="color: #0369a1;">Wallet Balance</span>
                                    <span
                                        style="font-weight: 700; color: #0284c7;">₹<?php echo number_format($user_balance); ?></span>
                                </div>
                                <?php if ($user_balance < $cart_total): ?>
                                    <div style="color: #dc2626; font-size: 0.85rem; margin-top: 5px;">
                                        ⚠️ Insufficient balance. Choose Online Pay at checkout.
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <a href="checkout" class="btn btn-primary btn-checkout" style="text-decoration: none;">
                            Proceed to Checkout
                        </a>

                        <div style="margin-top: 20px; text-align: center; color: #64748b; font-size: 0.85rem;">
                            <p>🔒 Secure Payment Options Available</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>