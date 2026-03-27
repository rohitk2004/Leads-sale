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
        // Redirect to dashboard after 2 seconds
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
    <title>Checkout - Quick Project</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Checkout</h1>
            <p class="page-subtitle">Complete your purchase to access lead details instantly.</p>
        </div>
    </section>

    <div class="container" style="max-width: 900px; padding-bottom: 80px;">

        <?php if (!empty($message)): ?>
            <div class="card"
                style="border-left: 4px solid <?php echo $msg_type == 'success' ? 'var(--success-color)' : 'var(--warning-color)'; ?>; margin-bottom: 30px;">
                <h3
                    style="margin: 0; color: <?php echo $msg_type == 'success' ? 'var(--success-color)' : 'var(--warning-color)'; ?>">
                    <?php echo $msg_type == 'success' ? '✓ ' : '✗ '; ?>
                    <?php echo htmlspecialchars($message); ?>
                </h3>
                <?php if ($msg_type == 'success'): ?>
                    <p style="margin: 10px 0 0 0; color: var(--text-secondary);">Redirecting to your dashboard...</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($cart_items)): ?>
            <div class="card"
                style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);">
                <div
                    style="background: #f8fafc; padding: 20px 30px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b;">Order Summary</h3>
                    <span
                        style="background: #e0f2fe; color: #0369a1; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                        <?php echo count($cart_items); ?> Items
                    </span>
                </div>

                <div style="padding: 20px 30px;">
                    <?php foreach ($cart_items as $item): ?>
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #f1f5f9;">
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <div
                                    style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 700;">
                                    #<?php echo $item['id']; ?>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #0f172a;">
                                        <?php echo htmlspecialchars($item['niche']); ?> Lead
                                    </div>
                                    <div style="font-size: 0.85rem; color: #64748b;">Budget:
                                        ₹<?php echo number_format($item['budget']); ?>+</div>
                                </div>
                            </div>
                            <div style="font-weight: 700; color: #059669; font-size: 1.1rem;">
                                ₹<?php echo number_format($item['lead_price']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div
                    style="background: #f8fafc; padding: 25px 30px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 600; color: #64748b; font-size: 1.1rem;">Total Amount</span>
                    <span
                        style="font-size: 1.8rem; font-weight: 800; color: #059669;">₹<?php echo number_format($total, 2); ?></span>
                </div>
            </div>

            <div class="card" style="margin-top: 20px;">
                <h3 style="margin-bottom: 25px;">Choose Payment Option</h3>

                <div class="payment-selection">
                    <!-- Cashfree Option (Default) -->
                    <label class="payment-option selected" id="option-cashfree">
                        <input type="radio" name="payment_method" value="cashfree" checked style="display: none;"
                            onchange="selectPaymentMethod('cashfree')">
                        <div class="option-content">
                            <div class="option-icon" style="background: #e0f2fe; color: #0284c7;">&#128179;</div>
                            <div class="option-details">
                                <span class="option-name">Online Payment (Cashfree)</span>
                                <span class="option-desc">Cards, UPI, Netbanking</span>
                            </div>
                            <div class="selection-status">&#10003;</div>
                        </div>
                    </label>

                    <!-- Wallet Option -->
                    <label class="payment-option <?php echo !$can_afford ? 'disabled' : ''; ?>" id="option-wallet">
                        <input type="radio" name="payment_method" value="wallet" style="display: none;"
                            onchange="selectPaymentMethod('wallet')" <?php echo !$can_afford ? 'disabled' : ''; ?>>
                        <div class="option-content">
                            <div class="option-icon" style="background: #f0fdf4; color: #166534;">&#128171;</div>
                            <div class="option-details">
                                <span class="option-name">Pay with Wallet</span>
                                <span class="option-desc">Balance: ₹<?php echo number_format($current_balance, 2); ?></span>
                            </div>
                            <?php if (!$can_afford): ?>
                                <a href="developer_dashboard#add-funds-container" class="btn btn-secondary btn-sm"
                                    style="font-size: 0.8rem; padding: 4px 10px; margin-left: auto;">Top Up</a>
                            <?php else: ?>
                                <div class="selection-status">&#10003;</div>
                            <?php endif; ?>
                        </div>
                    </label>
                </div>

                <div style="margin-top: 10px;">
                    <!-- Direct Payment Form (JS triggered) -->
                    <button type="button" id="pay-now-btn" onclick="handlePayment()" class="btn btn-primary btn-pay">
                        <span>Pay ₹<?php echo number_format($total, 2); ?> Now</span>
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>

                    <!-- Hidden form for wallet payment -->
                    <form id="wallet-payment-form" method="POST" style="display: none;">
                        <input type="hidden" name="complete_payment" value="1">
                    </form>
                </div>

                <p style="text-align: center; margin-top: 15px; font-size: 0.8rem; color: #64748b; line-height: 1.4;">
                    By clicking 'Pay Now', you agree to the QuickProject.in <a href="terms" target="_blank"
                        style="color: #2563eb;">Terms & Conditions</a> and <a href="terms#refund-policy" target="_blank"
                        style="color: #2563eb;">Refund Policy</a>.
                </p>
                <p style="text-align: center; margin-top: 20px; font-size: 0.85rem; color: #94a3b8;">
                    <span style="display: inline-flex; align-items: center; gap: 4px;">🔒 100% Secure Transaction via
                        Encrypted Gateway</span>
                </p>
            </div>

            <style>
                .payment-selection {
                    display: flex;
                    flex-direction: column;
                    gap: 15px;
                    margin-bottom: 30px;
                }

                .payment-option {
                    display: block;
                    border: 2px solid #e2e8f0;
                    border-radius: 16px;
                    padding: 24px;
                    cursor: pointer;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    position: relative;
                }

                .payment-option:hover:not(.disabled) {
                    border-color: #3b82f6;
                    background: #f8fafc;
                    transform: translateY(-2px);
                }

                .payment-option.selected {
                    border-color: #2563eb;
                    background: #eff6ff;
                    box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.15);
                }

                .payment-option.disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                    background: #f1f5f9;
                    filter: grayscale(1);
                }

                .option-content {
                    display: flex;
                    align-items: center;
                    gap: 20px;
                }

                .option-icon {
                    width: 56px;
                    height: 56px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.8rem;
                    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
                }

                .option-details {
                    display: flex;
                    flex-direction: column;
                    gap: 4px;
                }

                .option-name {
                    font-weight: 800;
                    font-size: 1.1rem;
                    color: #1e293b;
                }

                .option-desc {
                    font-size: 0.9rem;
                    color: #64748b;
                }

                .selection-status {
                    margin-left: auto;
                    width: 28px;
                    height: 28px;
                    background: #2563eb;
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 0.9rem;
                    font-weight: bold;
                    opacity: 0;
                    transform: scale(0.5);
                    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                }

                .payment-option.selected .selection-status {
                    opacity: 1;
                    transform: scale(1);
                }

                .btn-pay {
                    width: 100%;
                    padding: 20px;
                    font-size: 1.2rem;
                    font-weight: 700;
                    border-radius: 16px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 12px;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
                }

                .btn-pay:active {
                    transform: scale(0.98);
                }
            </style>

            <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
            <script>
                const cashfree = Cashfree({
                    mode: "sandbox" // "production" for live
                });

                function selectPaymentMethod(method) {
                    document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
                    document.getElementById('option-' + method).classList.add('selected');
                }

                function handlePayment() {
                    const method = document.querySelector('input[name="payment_method"]:checked').value;
                    const btn = document.getElementById('pay-now-btn');

                    if (method === 'cashfree') {
                        startDirectPayment(btn);
                    } else if (method === 'wallet') {
                        btn.innerHTML = 'Processing Wallet Payment...';
                        btn.disabled = true;
                        document.getElementById('wallet-payment-form').submit();
                    }
                }

                async function startDirectPayment(btn) {
                    const originalContent = btn.innerHTML;
                    btn.innerHTML = 'Initiating Secure Payment...';
                    btn.disabled = true;

                    try {
                        // Create Order on backend
                        const response = await fetch('cashfree_checkout_order.php', { method: 'POST' });
                        const order = await response.json();

                        if (order.error) {
                            alert(order.error);
                            btn.innerHTML = originalContent;
                            btn.disabled = false;
                            return;
                        }

                        let checkoutOptions = {
                            paymentSessionId: order.payment_session_id,
                            redirectTarget: "_modal",
                        };

                        cashfree.checkout(checkoutOptions).then(async (result) => {
                            if (result.error) {
                                alert(result.error.message || "Payment Failed");
                                btn.innerHTML = originalContent;
                                btn.disabled = false;
                            }
                            if (result.paymentDetails) {
                                const verifyRes = await fetch('cashfree_checkout_verify.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_id: order.order_id
                                    })
                                });

                                const verifyData = await verifyRes.json();
                                if (verifyData.success) {
                                    window.location.href = 'sold_leads?purchase_success=1';
                                } else {
                                    alert(verifyData.error || "Payment verification failed");
                                    btn.innerHTML = originalContent;
                                    btn.disabled = false;
                                }
                            }
                        });


                    } catch (error) {
                        console.error(error);
                        alert('Something went wrong');
                        btn.innerHTML = originalContent;
                        btn.disabled = false;
                    }
                }
            </script>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>