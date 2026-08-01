<?php
require_once 'functions.php';

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $lead_id = $_POST['lead_id'];
    add_to_cart($pdo, $lead_id);
    header("Location: cart");
    exit;
}

$available_leads = get_available_leads($pdo);
$cart_count = count(get_cart_items($pdo));

$total_leads = count($available_leads);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available SEO Courses & Call Gen Leads - BlackHat SEO</title>
    <meta name="description" content="Browse available BlackHat SEO training modules, call generation blueprints, PBN databases, and SERP automation scripts.">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section style="padding: 60px 0 40px; background: rgba(13, 15, 23, 0.7); border-bottom: 1px solid var(--line);">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div>
                    <span class="section-tag">CATALOGUE & TRAINING PACKAGES</span>
                    <h1 style="font-size: 38px; font-weight: 800;">Available Courses & Call Gen Leads</h1>
                    <p style="color: var(--ink-muted); font-size: 16px; margin-top: 6px;">Instant access to SEO blueprints, PBN networks, and live training batches.</p>
                </div>
                <div style="background: rgba(0, 242, 254, 0.1); border: 1px solid var(--teal); padding: 8px 20px; border-radius: 30px; color: var(--teal); font-family: var(--font-mono); font-size: 13px; font-weight: 700;">
                    ● <?php echo $total_leads; ?> Active Packages Available
                </div>
            </div>
        </div>
    </section>

    <!-- Content Body -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div class="grid-3">
                <?php if (!empty($available_leads)): ?>
                    <?php foreach ($available_leads as $lead): ?>
                        <div class="glass-card course-card">
                            <div class="course-card-header">
                                <span class="category-tag"><?php echo htmlspecialchars($lead['niche']); ?></span>
                                <span class="course-price">₹<?php echo number_format($lead['lead_price']); ?></span>
                            </div>

                            <h3 class="course-title"><?php echo htmlspecialchars($lead['niche']); ?></h3>
                            <p class="course-desc"><?php echo htmlspecialchars($lead['description']); ?></p>

                            <ul class="course-features">
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Instructor: <?php echo htmlspecialchars($lead['client_name']); ?>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Instant Full Course & Material Access
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Live Demonstration & Advisory
                                </li>
                            </ul>

                            <form method="POST" style="margin-top: auto;">
                                <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                <button type="submit" name="add_to_cart" class="btn-primary" style="width: 100%; justify-content: center;">
                                    <span>Enroll / Add to Cart</span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; grid-column: 1 / -1; color: var(--ink-muted);">No active courses found. Run <a href="seed" style="color: var(--teal);">seed.php</a> to populate demo packages.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>