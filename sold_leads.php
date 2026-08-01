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
    <title>Completed Batches & Sold Out SEO Packages - BlackHat SEO</title>
    <meta name="description" content="View filled batches and sold out BlackHat SEO course packages and call gen blueprints.">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section style="padding: 60px 0 40px; background: rgba(13, 15, 23, 0.7); border-bottom: 1px solid var(--line);">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div>
                    <span class="section-tag">ARCHIVED BATCHES</span>
                    <h1 style="font-size: 38px; font-weight: 800;">Completed Batches & Sold Out Packages</h1>
                    <p style="color: var(--ink-muted); font-size: 16px; margin-top: 6px;">Fully enrolled course batches and claimed call generation blueprints.</p>
                </div>
                <div style="background: rgba(244, 63, 94, 0.1); border: 1px solid var(--rose); padding: 8px 20px; border-radius: 30px; color: var(--rose); font-family: var(--font-mono); font-size: 13px; font-weight: 700;">
                    ✓ <?php echo $total_sold; ?> Completed Batches
                </div>
            </div>
        </div>
    </section>

    <!-- Content Body -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div class="grid-3">
                <?php if (!empty($sold_leads)): ?>
                    <?php foreach ($sold_leads as $lead): ?>
                        <div class="glass-card course-card" style="opacity: 0.75; border-color: rgba(244, 63, 94, 0.3);">
                            <div class="course-card-header">
                                <span class="category-tag" style="background: rgba(244, 63, 94, 0.15); color: var(--rose); border-color: rgba(244, 63, 94, 0.3);"><?php echo htmlspecialchars($lead['niche']); ?></span>
                                <span class="course-price" style="color: var(--rose);">SOLD OUT</span>
                            </div>

                            <h3 class="course-title"><?php echo htmlspecialchars($lead['niche']); ?></h3>
                            <p class="course-desc"><?php echo htmlspecialchars($lead['description']); ?></p>

                            <ul class="course-features">
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--rose);"><polyline points="20 6 9 17 4 12"/></svg>
                                    Instructor: <?php echo htmlspecialchars($lead['client_name']); ?>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--rose);"><polyline points="20 6 9 17 4 12"/></svg>
                                    Batch Status: Fully Enrolled
                                </li>
                            </ul>

                            <button class="btn-outline" disabled style="width: 100%; justify-content: center; opacity: 0.5; cursor: not-allowed;">
                                <span>Batch Full / Sold Out</span>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; grid-column: 1 / -1; color: var(--ink-muted);">No sold out packages at present.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>