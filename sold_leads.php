<?php
require_once 'functions.php';

$sold_leads = get_sold_leads($pdo);
$cart_count = count(get_cart_items($pdo));
$total_sold = count($sold_leads);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sold Leads - QuickProject</title>
    <meta name="description" content="View recently sold leads and closed opportunities">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section class="pg-header pg-header-sold">
        <div class="pg-header-bg"></div>
        <div class="container">
            <div class="pg-header-content">
                <div>
                    <h1 class="pg-title">Sold Leads</h1>
                    <p class="pg-subtitle">Recently closed opportunities — no longer available for purchase</p>
                </div>
                <div class="pg-header-badge pg-badge-sold">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    <span><?php echo $total_sold; ?> leads sold</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Scrolling Sold Leads Ticker -->
    <div class="sold-ticker">
        <div class="sold-ticker-label">
            <span class="sold-ticker-dot"></span>
            Live Sales
        </div>
        <div class="sold-ticker-track">
            <div class="sold-ticker-scroll">
                <!-- Set 1 -->
                <div class="sold-ticker-item">
                    <span class="ticker-niche">E-Commerce Website</span>
                    <span class="ticker-meta">Mumbai</span>
                    <span class="ticker-time">2 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">Mobile App Development</span>
                    <span class="ticker-meta">Bangalore</span>
                    <span class="ticker-time">5 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">SEO Services</span>
                    <span class="ticker-meta">Delhi</span>
                    <span class="ticker-time">8 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">WordPress Redesign</span>
                    <span class="ticker-meta">Pune</span>
                    <span class="ticker-time">12 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">CRM Software</span>
                    <span class="ticker-meta">Hyderabad</span>
                    <span class="ticker-time">15 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">Logo & Branding</span>
                    <span class="ticker-meta">Chennai</span>
                    <span class="ticker-time">18 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">React Dashboard</span>
                    <span class="ticker-meta">Ahmedabad</span>
                    <span class="ticker-time">22 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">Shopify Store</span>
                    <span class="ticker-meta">Jaipur</span>
                    <span class="ticker-time">25 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">API Integration</span>
                    <span class="ticker-meta">Kolkata</span>
                    <span class="ticker-time">30 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">Cloud Migration</span>
                    <span class="ticker-meta">Noida</span>
                    <span class="ticker-time">35 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <!-- Set 2 (duplicate for seamless loop) -->
                <div class="sold-ticker-item">
                    <span class="ticker-niche">E-Commerce Website</span>
                    <span class="ticker-meta">Mumbai</span>
                    <span class="ticker-time">2 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">Mobile App Development</span>
                    <span class="ticker-meta">Bangalore</span>
                    <span class="ticker-time">5 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">SEO Services</span>
                    <span class="ticker-meta">Delhi</span>
                    <span class="ticker-time">8 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">WordPress Redesign</span>
                    <span class="ticker-meta">Pune</span>
                    <span class="ticker-time">12 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">CRM Software</span>
                    <span class="ticker-meta">Hyderabad</span>
                    <span class="ticker-time">15 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">Logo & Branding</span>
                    <span class="ticker-meta">Chennai</span>
                    <span class="ticker-time">18 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">React Dashboard</span>
                    <span class="ticker-meta">Ahmedabad</span>
                    <span class="ticker-time">22 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">Shopify Store</span>
                    <span class="ticker-meta">Jaipur</span>
                    <span class="ticker-time">25 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">API Integration</span>
                    <span class="ticker-meta">Kolkata</span>
                    <span class="ticker-time">30 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
                <div class="sold-ticker-item">
                    <span class="ticker-niche">Cloud Migration</span>
                    <span class="ticker-meta">Noida</span>
                    <span class="ticker-time">35 mins ago</span>
                    <span class="ticker-sold">SOLD</span>
                </div>
            </div>
        </div>
    </div>

    <section class="pg-body">
        <div class="container">
            <?php if (empty($sold_leads)): ?>
                <div class="dash-empty">
                    <div class="dash-empty-icon">✅</div>
                    <h3>No sold leads yet</h3>
                    <p>Sold leads will appear here once purchased by developers.</p>
                    <a href="available_leads.php" class="dash-empty-btn">Browse Available Leads</a>
                </div>
            <?php else: ?>
                <div class="filter-results">
                    <span>Showing <strong><?php echo $total_sold; ?></strong> sold leads</span>
                    <a href="available_leads.php" class="dash-section-link">
                        <span>View Available Leads</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>
                <div class="leads-grid">
                    <?php foreach ($sold_leads as $lead):
                        $phone = $lead['client_phone'];
                        $blurred_phone = str_repeat('●', max(0, strlen($phone) - 4)) . substr($phone, -4);
                        ?>
                        <div class="lead-card sold-card">
                            <div class="sold-ribbon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                                SOLD
                            </div>
                            <div class="lead-header">
                                <h3><?php echo htmlspecialchars($lead['niche']); ?></h3>
                            </div>

                            <div class="lead-details">
                                <div class="detail-row">
                                    <div class="detail-item detail-name">
                                        <span class="detail-icon">👤</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Client Name</span>
                                            <span
                                                class="detail-value"><?php echo htmlspecialchars($lead['client_name']); ?></span>
                                        </div>
                                    </div>
                                    <div class="detail-item detail-phone">
                                        <span class="detail-icon">📞</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Phone Number</span>
                                            <span
                                                class="detail-value blurred-text"><?php echo htmlspecialchars($blurred_phone); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-item detail-budget">
                                        <span class="detail-icon">💰</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Budget</span>
                                            <span
                                                class="detail-value text-green">₹<?php echo number_format($lead['budget']); ?>+</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-item detail-requirement full-width">
                                        <span class="detail-icon">📋</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Requirement</span>
                                            <span
                                                class="detail-value"><?php echo htmlspecialchars($lead['description']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lead-footer sold-footer">
                                <div class="sold-notice">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                    <span>This lead has been sold and is no longer available</span>
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