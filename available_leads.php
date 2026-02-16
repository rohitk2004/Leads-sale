<?php
require_once 'functions.php';

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $lead_id = $_POST['lead_id'];
    add_to_cart($pdo, $lead_id);
    header("Location: cart.php");
    exit;
}

$available_leads = get_available_leads($pdo);
$cart_count = count(get_cart_items($pdo));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Leads - Quick Project</title>
    <meta name="description" content="Browse all available premium business leads for developers">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Available Leads</h1>
            <p class="page-subtitle">Fresh opportunities updated daily - Ready to unlock</p>
        </div>
    </section>

    <!-- Available Leads Section -->
    <section class="leads-section">
        <div class="container">
            <?php if (empty($available_leads)): ?>
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>No leads available at the moment</h3>
                    <p>Check back soon for new opportunities!</p>
                </div>
            <?php else: ?>
                <div class="leads-grid">
                    <?php foreach ($available_leads as $lead):
                        // Blur phone number - show only last 4 digits
                        $phone = $lead['client_phone'];
                        $blurred_phone = str_repeat('●', max(0, strlen($phone) - 4)) . substr($phone, -4);
                        ?>
                        <div class="lead-card">
                            <div class="lead-header">
                                <h3>
                                    <?php echo htmlspecialchars($lead['niche']); ?>
                                </h3>
                            </div>

                            <!-- 4 Fields: Name, Number (Blurred), Budget, Requirement -->
                            <div class="lead-details">
                                <div class="detail-row">
                                    <div class="detail-item detail-name">
                                        <span class="detail-icon">👤</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Client Name</span>
                                            <span class="detail-value">
                                                <?php echo htmlspecialchars($lead['client_name']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="detail-item detail-phone">
                                        <span class="detail-icon">📞</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Phone Number</span>
                                            <span class="detail-value blurred-text">
                                                <?php echo htmlspecialchars($blurred_phone); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-item detail-budget">
                                        <span class="detail-icon">💰</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Budget</span>
                                            <span class="detail-value text-green">₹
                                                <?php echo number_format($lead['budget']); ?>+
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-item detail-requirement full-width">
                                        <span class="detail-icon">📋</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Requirement</span>
                                            <span class="detail-value">
                                                <?php echo htmlspecialchars($lead['description']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lead-footer">
                                <div class="price-tag">
                                    <span class="price-label">🔓 Unlock Full Details</span>
                                    <span class="price-value">₹
                                        <?php echo number_format($lead['lead_price']); ?>
                                    </span>
                                </div>
                                <form method="POST">
                                    <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                    <input type="hidden" name="add_to_cart" value="1">
                                    <button type="submit" class="btn btn-primary">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>