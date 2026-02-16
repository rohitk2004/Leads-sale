<?php
require_once 'functions.php';

$sold_leads = get_sold_leads($pdo);
$cart_count = count(get_cart_items($pdo));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sold Leads - Quick Project</title>
    <meta name="description" content="View recently sold leads and closed opportunities">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Sold Leads</h1>
            <p class="page-subtitle">Recently closed opportunities - No longer available</p>
        </div>
    </section>

    <!-- Sold Leads Section -->
    <section class="leads-section sold-leads-section">
        <div class="container">
            <?php if (empty($sold_leads)): ?>
                <div class="empty-state">
                    <div class="empty-icon">✅</div>
                    <h3>No sold leads yet</h3>
                    <p>Sold leads will appear here once purchased</p>
                </div>
            <?php else: ?>
                <div class="leads-grid">
                    <?php foreach ($sold_leads as $lead):
                        // Blur phone number - show only last 4 digits (same as available leads)
                        $phone = $lead['client_phone'];
                        $blurred_phone = str_repeat('●', max(0, strlen($phone) - 4)) . substr($phone, -4);
                        ?>
                        <div class="lead-card sold-lead-card">
                            <div class="sold-badge">✓ SOLD</div>
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
                                <div class="sold-notice">
                                    <span class="sold-icon">🔒</span>
                                    <span class="sold-text">This lead has been sold and is no longer available</span>
                                </div>
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