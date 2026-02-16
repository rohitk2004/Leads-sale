<?php
require_once 'functions.php';
require_once 'config.php';
require_login('developer');

$user_id = $_SESSION['user_id'];
$purchased_leads = get_my_purchased_leads($pdo, $user_id);
$cart_count = count(get_cart_items($pdo));

$success_msg = '';
$error_msg = '';

// Handle Add Funds
// Razorpay integration replaces manual handling

if (isset($_GET['fund_success'])) {
    $success_msg = "Funds added successfully!";
}

$wallet_balance = get_user_balance($pdo, $user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Quick Project</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">My Dashboard</h1>
            <p class="page-subtitle">Manage your purchased leads and account balance</p>
        </div>
    </section>

    <div class="container" style="padding: 60px 0;">
        <?php if (isset($_GET['purchase_success'])): ?>
            <div class="alert alert-success"
                style="background: #dcfce7; color: #166534; padding: 20px; border-radius: 8px; margin-bottom: 40px; border-left: 5px solid #22c55e;">
                <h3 style="margin: 0 0 10px 0;">🎉 Purchase Successful!</h3>
                <p style="margin: 0;">Thank you for your purchase. You can now view the full details of your leads below.
                </p>
            </div>
        <?php endif; ?>

        <div class="wallet-section"
            style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; border: 1px solid #e2e8f0;">
            <div>
                <h2 style="margin: 0 0 5px 0; font-size: 1.5rem; color: #1e293b;">My Wallet</h2>
                <p style="color: #64748b; margin: 0;">Current Balance</p>
                <div
                    style="font-size: 2.5rem; font-weight: 800; color: #166534; margin-top: 10px; font-family: 'Poppins', sans-serif;">
                    ₹<?php echo number_format($wallet_balance, 2); ?>
                </div>
            </div>

            <div id="add-funds-container"
                style="display: flex; gap: 15px; align-items: flex-end; background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div>
                    <label
                        style="display: block; font-size: 0.9rem; font-weight: 600; color: #475569; margin-bottom: 5px;">Add
                        Money</label>
                    <div style="position: relative;">
                        <span
                            style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-weight: 600;">₹</span>
                        <input type="number" id="fund-amount" min="1" step="1" required placeholder="0"
                            style="padding: 10px 10px 10px 30px; border: 1px solid #cbd5e1; border-radius: 8px; width: 140px; font-weight: 600; outline: none; transition: border 0.3s;">
                    </div>
                </div>
                <button type="button" onclick="startPayment(this)" class="btn btn-primary" style="height: 42px;">
                    + Add Funds
                </button>
            </div>

            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <script>
                async function startPayment(btn) {
                    const amountInput = document.getElementById('fund-amount');
                    const amount = amountInput.value;

                    if (!amount || amount <= 0) {
                        alert('Please enter a valid amount');
                        return;
                    }

                    const originalText = btn.innerText;
                    btn.innerText = 'Processing...';
                    btn.disabled = true;

                    try {
                        const response = await fetch('razorpay_order.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ amount: amount })
                        });

                        const order = await response.json();

                        if (order.error) {
                            alert(order.error);
                            btn.innerText = originalText;
                            btn.disabled = false;
                            return;
                        }

                        const options = {
                            "key": "<?php echo RAZORPAY_KEY_ID; ?>",
                            "amount": order.amount,
                            "currency": "INR",
                            "name": "Quick Project",
                            "description": "Wallet Top-up",
                            "order_id": order.id,
                            "handler": async function (response) {
                                const verifyRes = await fetch('razorpay_verify.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_signature: response.razorpay_signature
                                    })
                                });

                                const result = await verifyRes.json();
                                if (result.success) {
                                    window.location.href = 'developer_dashboard.php?fund_success=1';
                                } else {
                                    alert(result.error);
                                    btn.innerText = originalText;
                                    btn.disabled = false;
                                }
                            },
                            "prefill": {
                                "name": "<?php echo $_SESSION['username']; ?>",
                                "email": "<?php echo $_SESSION['email'] ?? ''; ?>",
                                "contact": ""
                            },
                            "theme": {
                                "color": "#2563eb"
                            },
                            "modal": {
                                "ondismiss": function () {
                                    btn.innerText = originalText;
                                    btn.disabled = false;
                                }
                            }
                        };

                        const rzp = new Razorpay(options);
                        rzp.open();

                    } catch (error) {
                        console.error('Error:', error);
                        alert('Something went wrong!');
                        btn.innerText = originalText;
                        btn.disabled = false;
                    }
                }
            </script>
        </div>

        <?php if ($success_msg): ?>
            <div class="alert alert-success"
                style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #22c55e;">
                <?php echo $success_msg; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_msg): ?>
            <div class="alert alert-danger"
                style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #ef4444;">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <h2 style="margin-bottom: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px;">My Purchased Leads</h2>

        <?php if (empty($purchased_leads)): ?>
            <div style="text-align: center; padding: 60px; background: #f8fafc; border-radius: 16px;">
                <div style="font-size: 4rem; margin-bottom: 20px;">📂</div>
                <h3 style="color: #64748b; margin-bottom: 15px;">You haven't purchased any leads yet</h3>
                <p style="color: #94a3b8; margin-bottom: 30px;">Browse our marketplace to find perfect clients for your
                    business
                </p>
                <a href="available_leads.php" class="btn btn-primary">Browse Available Leads</a>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px;">
                <?php foreach ($purchased_leads as $lead): ?>
                    <div class="card">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                            <h3 style="margin: 0; color: var(--accent-primary);"><?php echo htmlspecialchars($lead['niche']); ?>
                            </h3>
                            <span class="badge badge-new">₹<?php echo number_format($lead['budget']); ?>+</span>
                        </div>

                        <p style="color: var(--text-secondary); margin-bottom: 25px;">
                            <?php echo htmlspecialchars($lead['description']); ?>
                        </p>

                        <div
                            style="background: linear-gradient(135deg, rgba(45, 134, 89, 0.08) 0%, rgba(45, 134, 89, 0.03) 100%); padding: 20px; border-radius: 8px; border: 1.5px solid rgba(45, 134, 89, 0.2); margin-bottom: 20px;">
                            <h4 style="margin: 0 0 15px 0; color: var(--success-color); font-size: 1rem;">✓ Contact Details</h4>

                            <div style="display: grid; gap: 12px;">
                                <div>
                                    <label
                                        style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-bottom: 4px;">Client
                                        Name</label>
                                    <p style="margin: 0; font-size: 1.1rem; font-weight: 600; color: var(--text-primary);">
                                        <?php echo htmlspecialchars($lead['client_name']); ?>
                                    </p>
                                </div>

                                <div>
                                    <label
                                        style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-bottom: 4px;">Phone
                                        Number</label>
                                    <a href="tel:<?php echo htmlspecialchars($lead['client_phone']); ?>"
                                        style="font-size: 1.1rem; font-weight: 600; color: var(--success-color); text-decoration: none;">
                                        📞 <?php echo htmlspecialchars($lead['client_phone']); ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div
                            style="padding-top: 15px; border-top: 1px solid var(--border-light); font-size: 0.85rem; color: var(--text-muted);">
                            <span>Purchased on <?php echo date('d M Y, h:i A', strtotime($lead['purchased_at'])); ?></span>
                            <span style="float: right; color: var(--success-color); font-weight: 600;">
                                Paid ₹<?php echo number_format($lead['purchase_price']); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>