<?php
require_once 'functions.php';
require_once 'config.php';
require_login('developer');

$user_id = $_SESSION['user_id'];
$purchased_leads = get_my_purchased_leads($pdo, $user_id);
$cart_count = count(get_cart_items($pdo));

$success_msg = '';
$error_msg = '';

if (isset($_GET['fund_success'])) {
    $success_msg = "Funds added successfully!";
}

$wallet_balance = get_user_balance($pdo, $user_id);
$total_leads = count($purchased_leads);
$total_spent = 0;
foreach ($purchased_leads as $l) {
    $total_spent += $l['purchase_price'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - QuickProject</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- Dashboard Header -->
    <section class="dash-header">
        <div class="dash-header-bg"></div>
        <div class="container">
            <div class="dash-header-content">
                <div class="dash-header-text">
                    <div class="dash-greeting">Welcome back,
                        <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                    </div>
                    <p class="dash-subtitle">Manage your leads, track purchases, and grow your business.</p>
                </div>
                <a href="change_password" class="dash-header-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0110 0v4" />
                    </svg>
                    <span>Change Password</span>
                </a>
                <a href="available_leads" class="dash-header-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <span>Browse Leads</span>
                </a>
            </div>
        </div>
    </section>

    <div class="container dash-container">

        <!-- Alerts -->
        <?php if (isset($_GET['purchase_success'])): ?>
            <div class="dash-alert dash-alert-success">
                <div class="dash-alert-icon">🎉</div>
                <div>
                    <strong>Purchase Successful!</strong>
                    <p>Thank you for your purchase. You can now view the full details of your leads below.</p>
                </div>
                <button class="dash-alert-close" onclick="this.parentElement.remove()">×</button>
            </div>
        <?php endif; ?>

        <?php if ($success_msg): ?>
            <div class="dash-alert dash-alert-success">
                <div class="dash-alert-icon">✅</div>
                <div><strong><?php echo $success_msg; ?></strong></div>
                <button class="dash-alert-close" onclick="this.parentElement.remove()">×</button>
            </div>
        <?php endif; ?>

        <?php if ($error_msg): ?>
            <div class="dash-alert dash-alert-error">
                <div class="dash-alert-icon">⚠️</div>
                <div><strong><?php echo $error_msg; ?></strong></div>
                <button class="dash-alert-close" onclick="this.parentElement.remove()">×</button>
            </div>
        <?php endif; ?>

        <!-- Stats Grid -->
        <div class="dash-stats-grid">
            <div class="dash-stat-card dash-stat-balance">
                <div class="dash-stat-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <rect x="2" y="6" width="20" height="12" rx="2" />
                        <path d="M2 10h20" />
                        <path d="M6 14h.01M10 14h.01" />
                    </svg>
                </div>
                <div class="dash-stat-info">
                    <span class="dash-stat-label">Wallet Balance</span>
                    <span
                        class="dash-stat-value dash-stat-green">₹<?php echo number_format($wallet_balance, 2); ?></span>
                </div>
            </div>
            <div class="dash-stat-card">
                <div class="dash-stat-icon dash-stat-icon-blue">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" y1="8" x2="20" y2="14" />
                        <line x1="23" y1="11" x2="17" y2="11" />
                    </svg>
                </div>
                <div class="dash-stat-info">
                    <span class="dash-stat-label">Leads Purchased</span>
                    <span class="dash-stat-value"><?php echo $total_leads; ?></span>
                </div>
            </div>
            <div class="dash-stat-card">
                <div class="dash-stat-icon dash-stat-icon-purple">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                    </svg>
                </div>
                <div class="dash-stat-info">
                    <span class="dash-stat-label">Total Spent</span>
                    <span class="dash-stat-value">₹<?php echo number_format($total_spent); ?></span>
                </div>
            </div>
            <div class="dash-stat-card">
                <div class="dash-stat-icon dash-stat-icon-amber">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 01-8 0" />
                    </svg>
                </div>
                <div class="dash-stat-info">
                    <span class="dash-stat-label">Cart Items</span>
                    <span class="dash-stat-value"><?php echo $cart_count; ?></span>
                </div>
            </div>
        </div>

        <!-- Wallet Section -->
        <div class="dash-wallet-card">
            <div class="dash-wallet-left">
                <div class="dash-wallet-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <rect x="2" y="6" width="20" height="12" rx="2" />
                        <path d="M2 10h20" />
                    </svg>
                    <h3>Add Funds to Wallet</h3>
                </div>
                <p class="dash-wallet-desc">Top up your wallet to purchase leads instantly. Payments are secured via
                    Cashfree.</p>
            </div>
            <div class="dash-wallet-right">
                <div class="dash-wallet-input-group">
                    <label for="fund-amount">Amount (₹)</label>
                    <div class="dash-wallet-input-wrap">
                        <span class="dash-wallet-currency">₹</span>
                        <input type="number" id="fund-amount" min="1" step="1" required placeholder="500">
                    </div>
                </div>
                <div class="dash-wallet-presets">
                    <button type="button" class="dash-preset-btn"
                        onclick="document.getElementById('fund-amount').value=500">₹500</button>
                    <button type="button" class="dash-preset-btn"
                        onclick="document.getElementById('fund-amount').value=1000">₹1,000</button>
                    <button type="button" class="dash-preset-btn"
                        onclick="document.getElementById('fund-amount').value=2000">₹2,000</button>
                    <button type="button" class="dash-preset-btn"
                        onclick="document.getElementById('fund-amount').value=5000">₹5,000</button>
                </div>
                <button type="button" onclick="startPayment(this)" class="dash-add-funds-btn" id="payBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    <span>Add Funds</span>
                </button>
                <p class="dash-wallet-terms">
                    By adding funds, you agree to the
                    <a href="terms" target="_blank">Terms & Conditions</a> and
                    <a href="terms#refund-policy" target="_blank">Refund Policy</a>.
                </p>
            </div>

            <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
            <script>
                const cashfree = Cashfree({
                    mode: "production" // "production" for live
                });

                async function startPayment(btn) {
                    const amountInput = document.getElementById('fund-amount');
                    const amount = amountInput.value;

                    if (!amount || amount <= 0) {
                        alert('Please enter a valid amount');
                        return;
                    }

                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = '<span class="dash-btn-spinner"></span> Processing...';
                    btn.disabled = true;

                    try {
                        const response = await fetch('cashfree_order', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ amount: amount })
                        });

                        const order = await response.json();

                        if (order.error) {
                            alert(order.error);
                            btn.innerHTML = originalHTML;
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
                                btn.innerHTML = originalHTML;
                                btn.disabled = false;
                            }
                            if (result.paymentDetails) {
                                const verifyRes = await fetch('cashfree_verify', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        order_id: order.order_id
                                    })
                                });

                                const verifyData = await verifyRes.json();
                                if (verifyData.success) {
                                    window.location.href = 'developer_dashboard?fund_success=1';
                                } else {
                                    alert(verifyData.error || "Payment verification failed");
                                    btn.innerHTML = originalHTML;
                                    btn.disabled = false;
                                }
                            }
                        });

                    } catch (error) {
                        console.error('Error:', error);
                        alert('Something went wrong!');
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                    }
                }
            </script>
        </div>

        <!-- Purchased Leads -->
        <div class="dash-section">
            <div class="dash-section-header">
                <div>
                    <h2 class="dash-section-title">My Purchased Leads</h2>
                    <p class="dash-section-subtitle"><?php echo $total_leads; ?>
                        lead<?php echo $total_leads !== 1 ? 's' : ''; ?> purchased</p>
                </div>
                <?php if ($total_leads > 0): ?>
                    <a href="available_leads" class="dash-section-link">
                        <span>Browse More</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <?php if (empty($purchased_leads)): ?>
                <div class="dash-empty">
                    <div class="dash-empty-icon">📂</div>
                    <h3>No leads purchased yet</h3>
                    <p>Browse our marketplace to find verified clients and grow your business.</p>
                    <a href="available_leads" class="dash-empty-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <span>Browse Available Leads</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="dash-leads-grid">
                    <?php foreach ($purchased_leads as $lead): ?>
                        <div class="dash-lead-card">
                            <div class="dash-lead-top">
                                <div class="dash-lead-niche"><?php echo htmlspecialchars($lead['niche']); ?></div>
                                <span class="dash-lead-budget">₹<?php echo number_format($lead['budget']); ?>+</span>
                            </div>

                            <p class="dash-lead-desc"><?php echo htmlspecialchars($lead['description']); ?></p>

                            <div class="dash-lead-contact">
                                <div class="dash-lead-contact-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                                        <polyline points="22 4 12 14.01 9 11.01" />
                                    </svg>
                                    <span>Contact Details Unlocked</span>
                                </div>
                                <div class="dash-lead-contact-grid">
                                    <div class="dash-lead-contact-item">
                                        <span class="dash-contact-label">Client Name</span>
                                        <span
                                            class="dash-contact-value"><?php echo htmlspecialchars($lead['client_name']); ?></span>
                                    </div>
                                    <div class="dash-lead-contact-item">
                                        <span class="dash-contact-label">Phone Number</span>
                                        <a href="tel:<?php echo htmlspecialchars($lead['client_phone']); ?>"
                                            class="dash-contact-phone">
                                            📞 <?php echo htmlspecialchars($lead['client_phone']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="dash-lead-footer">
                                <span class="dash-lead-date">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    <?php echo date('d M Y, h:i A', strtotime($lead['purchased_at'])); ?>
                                </span>
                                <span class="dash-lead-paid">Paid ₹<?php echo number_format($lead['purchase_price']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>