<?php
require_once 'functions.php';
require_login('admin');

$message = "";
$msg_type = "";

// Add Lead Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_lead'])) {
    $niche = trim($_POST['niche']);
    $budget = (float) $_POST['budget'];
    $desc = trim($_POST['description']);
    $name = trim($_POST['client_name']);
    $phone = trim($_POST['client_phone']);

    $lead_price = 0;
    if ($budget == 15000)
        $lead_price = 999;
    elseif ($budget == 30000)
        $lead_price = 2499;
    elseif ($budget == 50000)
        $lead_price = 4999;
    else
        $lead_price = 999;

    try {
        $stmt = $pdo->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, 'available')");
        if ($stmt->execute([$niche, $budget, $lead_price, $desc, $name, $phone])) {
            $message = "Lead added successfully!";
            $msg_type = "success";
        } else {
            $message = "Failed to add lead.";
            $msg_type = "error";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
        $msg_type = "error";
    }
}

// ===== ANALYTICS QUERIES =====
// Total leads
$stmt = $pdo->query("SELECT COUNT(*) FROM leads");
$total_leads = $stmt->fetchColumn();

// Available vs Sold
$stmt = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'available'");
$available_leads_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'sold'");
$sold_leads_count = $stmt->fetchColumn();

// Total Revenue
$stmt = $pdo->query("SELECT COALESCE(SUM(purchase_price), 0) FROM purchased_leads");
$total_revenue = $stmt->fetchColumn();

// Total Users
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'developer'");
$total_users = $stmt->fetchColumn();

// Conversion Rate
$conversion_rate = $total_leads > 0 ? round(($sold_leads_count / $total_leads) * 100, 1) : 0;

// Monthly Revenue for Chart (last 6 months)
$monthly_revenue = [];
$monthly_labels = [];
for ($i = 5; $i >= 0; $i--) {
    $month_start = date('Y-m-01', strtotime("-$i months"));
    $month_end = date('Y-m-t', strtotime("-$i months"));
    $month_label = date('M Y', strtotime("-$i months"));
    
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(purchase_price), 0) FROM purchased_leads WHERE purchased_at BETWEEN ? AND ?");
    $stmt->execute([$month_start, $month_end . ' 23:59:59']);
    $rev = $stmt->fetchColumn();
    
    $monthly_revenue[] = (float)$rev;
    $monthly_labels[] = $month_label;
}

// Monthly Leads Sold for Chart
$monthly_sold = [];
for ($i = 5; $i >= 0; $i--) {
    $month_start = date('Y-m-01', strtotime("-$i months"));
    $month_end = date('Y-m-t', strtotime("-$i months"));
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM purchased_leads WHERE purchased_at BETWEEN ? AND ?");
    $stmt->execute([$month_start, $month_end . ' 23:59:59']);
    $monthly_sold[] = (int)$stmt->fetchColumn();
}

// Recent Users
$stmt = $pdo->query("SELECT u.id, u.username, u.role, u.wallet_balance, u.created_at, 
    (SELECT COUNT(*) FROM purchased_leads WHERE user_id = u.id) as total_purchases 
    FROM users WHERE role = 'developer' ORDER BY created_at DESC LIMIT 10");
$recent_users = $stmt->fetchAll();



// Niche distribution
$stmt = $pdo->query("SELECT niche, COUNT(*) as cnt FROM leads GROUP BY niche ORDER BY cnt DESC LIMIT 5");
$top_niches = $stmt->fetchAll();

// Recent Transactions
$stmt = $pdo->query("SELECT t.*, u.username FROM transactions t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC LIMIT 8");
$recent_transactions = $stmt->fetchAll();

// Fetch all leads
$stmt = $pdo->query("SELECT * FROM leads ORDER BY created_at DESC");
$leads = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quick Project</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        /* ===== ADMIN DASHBOARD PREMIUM ===== */
        .adm-body { background: #0f172a; min-height: 100vh; font-family: 'Inter', sans-serif; }

        /* Header */
        .adm-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 48px 0 32px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .adm-header-inner {
            display: flex; justify-content: space-between; align-items: flex-start;
        }
        .adm-header h1 {
            font-size: 2rem; font-weight: 800; color: #f1f5f9; margin: 0 0 8px;
            letter-spacing: -0.5px;
        }
        .adm-header p { color: #64748b; font-size: 0.95rem; margin: 0; }
        .adm-header-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);
            color: #60a5fa; padding: 8px 16px; border-radius: 100px;
            font-size: 0.82rem; font-weight: 600;
        }
        .adm-header-dot {
            width: 8px; height: 8px; border-radius: 50%; background: #22c55e;
            animation: dotPulse 2s ease-in-out infinite;
        }

        /* Stat Cards */
        .adm-stats {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
            margin: -40px 0 32px;
            position: relative; z-index: 2;
        }
        .adm-stat {
            background: #1e293b; border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px; padding: 28px 24px;
            position: relative; overflow: hidden;
            transition: all 0.3s ease;
        }
        .adm-stat:hover { transform: translateY(-4px); border-color: rgba(255,255,255,0.1); }
        .adm-stat-glow {
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            border-radius: 20px 20px 0 0;
        }
        .adm-stat-icon {
            width: 48px; height: 48px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; margin-bottom: 16px;
        }
        .adm-stat-value {
            font-size: 2rem; font-weight: 800; color: #f1f5f9;
            letter-spacing: -1px; margin-bottom: 4px;
        }
        .adm-stat-label {
            font-size: 0.82rem; color: #64748b; font-weight: 500;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .adm-stat-change {
            position: absolute; top: 24px; right: 24px;
            font-size: 0.78rem; font-weight: 700; padding: 4px 10px;
            border-radius: 100px;
        }
        .change-up { background: rgba(34,197,94,0.1); color: #22c55e; }
        .change-neutral { background: rgba(59,130,246,0.1); color: #60a5fa; }

        /* Color variants */
        .stat-blue .adm-stat-glow { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .stat-blue .adm-stat-icon { background: rgba(59,130,246,0.12); color: #60a5fa; }
        .stat-green .adm-stat-glow { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-green .adm-stat-icon { background: rgba(16,185,129,0.12); color: #34d399; }
        .stat-purple .adm-stat-glow { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
        .stat-purple .adm-stat-icon { background: rgba(139,92,246,0.12); color: #a78bfa; }
        .stat-amber .adm-stat-glow { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .stat-amber .adm-stat-icon { background: rgba(245,158,11,0.12); color: #fbbf24; }

        /* Dashboard Grid */
        .adm-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 32px; }
        .adm-grid-equal { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; }

        /* Card */
        .adm-card {
            background: #1e293b; border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px; padding: 28px;
            transition: all 0.3s ease;
        }
        .adm-card-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px;
        }
        .adm-card-title {
            font-size: 1.1rem; font-weight: 700; color: #f1f5f9;
            display: flex; align-items: center; gap: 10px;
        }
        .adm-card-title .bar {
            width: 4px; height: 20px; border-radius: 4px; background: #3b82f6;
        }

        /* Chart */
        .chart-wrapper { position: relative; height: 280px; }

        /* Niche Pills */
        .niche-list { display: flex; flex-direction: column; gap: 12px; }
        .niche-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px; background: rgba(255,255,255,0.03);
            border-radius: 12px; border: 1px solid rgba(255,255,255,0.04);
        }
        .niche-name { color: #e2e8f0; font-weight: 600; font-size: 0.92rem; }
        .niche-count {
            background: rgba(59,130,246,0.1); color: #60a5fa; padding: 4px 12px;
            border-radius: 100px; font-size: 0.78rem; font-weight: 700;
        }
        .niche-bar {
            flex: 1; height: 6px; background: rgba(255,255,255,0.06);
            border-radius: 6px; margin: 0 16px; overflow: hidden;
        }
        .niche-bar-fill { height: 100%; border-radius: 6px; background: linear-gradient(90deg, #3b82f6, #60a5fa); }

        /* Users Table */
        .adm-table-wrap { overflow-x: auto; border-radius: 16px; }
        .adm-tbl {
            width: 100%; border-collapse: collapse; min-width: 600px;
        }
        .adm-tbl th {
            text-align: left; padding: 14px 18px;
            background: rgba(255,255,255,0.03);
            color: #64748b; font-weight: 600; font-size: 0.78rem;
            text-transform: uppercase; letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .adm-tbl td {
            padding: 14px 18px; border-bottom: 1px solid rgba(255,255,255,0.04);
            color: #e2e8f0; font-size: 0.9rem; vertical-align: middle;
        }
        .adm-tbl tr:hover td { background: rgba(255,255,255,0.02); }
        .adm-tbl .user-avatar {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.78rem; color: #fff;
        }
        .adm-tbl .user-cell { display: flex; align-items: center; gap: 12px; }
        .adm-tbl .user-name { font-weight: 600; color: #f1f5f9; }
        .adm-tbl .user-email { font-size: 0.8rem; color: #64748b; }
        .adm-tbl .wallet-val { font-weight: 700; color: #34d399; }
        .adm-tbl .purchase-count {
            background: rgba(139,92,246,0.1); color: #a78bfa; padding: 4px 10px;
            border-radius: 100px; font-size: 0.75rem; font-weight: 700;
        }

        /* Transactions */
        .txn-item {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .txn-item:last-child { border-bottom: none; }
        .txn-icon {
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0;
        }
        .txn-credit .txn-icon { background: rgba(34,197,94,0.1); color: #22c55e; }
        .txn-debit .txn-icon { background: rgba(239,68,68,0.1); color: #ef4444; }
        .txn-info { flex: 1; }
        .txn-desc { font-weight: 600; color: #e2e8f0; font-size: 0.9rem; }
        .txn-user { font-size: 0.78rem; color: #64748b; margin-top: 2px; }
        .txn-amount { font-weight: 700; font-size: 0.95rem; }
        .txn-credit .txn-amount { color: #22c55e; }
        .txn-debit .txn-amount { color: #ef4444; }

        /* Filter Bar */
        .adm-filter {
            display: flex; gap: 12px; align-items: center; flex-wrap: wrap;
        }
        .adm-filter-input {
            padding: 10px 16px; background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08); border-radius: 12px;
            color: #e2e8f0; font-size: 0.88rem; font-family: inherit;
            transition: all 0.3s ease; min-width: 200px;
        }
        .adm-filter-input:focus {
            outline: none; border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }
        .adm-filter-input::placeholder { color: #475569; }
        .adm-filter select.adm-filter-input { cursor: pointer; }
        .adm-filter select.adm-filter-input option { background: #1e293b; color: #e2e8f0; }
        .adm-filter-count {
            margin-left: auto; font-size: 0.82rem; color: #64748b; font-weight: 500;
        }

        /* Leads Table */
        .leads-tbl { width: 100%; border-collapse: collapse; min-width: 900px; }
        .leads-tbl th {
            text-align: left; padding: 16px 20px;
            background: rgba(255,255,255,0.03);
            color: #64748b; font-weight: 600; font-size: 0.78rem;
            text-transform: uppercase; letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .leads-tbl td {
            padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.04);
            color: #e2e8f0; font-size: 0.9rem; vertical-align: middle;
        }
        .leads-tbl tr:hover td { background: rgba(255,255,255,0.02); }
        .lead-id { font-weight: 700; color: #475569; }
        .lead-niche { font-weight: 700; color: #f1f5f9; }
        .lead-desc { font-size: 0.82rem; color: #64748b; margin-top: 4px; }
        .lead-budget { font-weight: 600; color: #94a3b8; }
        .lead-price {
            font-weight: 700; color: #34d399; background: rgba(16,185,129,0.1);
            padding: 4px 12px; border-radius: 8px; display: inline-block;
        }
        .lead-client-name { font-weight: 600; color: #f1f5f9; }
        .lead-client-phone { font-size: 0.82rem; color: #64748b; }
        .lead-status {
            padding: 5px 14px; border-radius: 100px; font-size: 0.75rem;
            font-weight: 700; display: inline-flex; align-items: center; gap: 6px;
        }
        .lead-status-dot {
            width: 6px; height: 6px; border-radius: 50%; background: currentColor;
        }
        .lead-avail { background: rgba(34,197,94,0.1); color: #22c55e; border: 1px solid rgba(34,197,94,0.2); }
        .lead-sold { background: rgba(245,158,11,0.1); color: #fbbf24; border: 1px solid rgba(245,158,11,0.2); }

        /* Add Lead Form */
        .adm-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .adm-form-group { margin-bottom: 20px; }
        .adm-form-label {
            display: block; margin-bottom: 8px; color: #94a3b8;
            font-weight: 500; font-size: 0.88rem;
        }
        .adm-form-control {
            width: 100%; padding: 12px 16px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px; color: #f1f5f9;
            font-family: inherit; font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .adm-form-control:focus {
            outline: none; border-color: #3b82f6;
            background: rgba(255,255,255,0.06);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }
        .adm-form-control::placeholder { color: #475569; }
        .adm-btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white; border: none; padding: 14px 32px;
            border-radius: 12px; font-weight: 700; font-size: 1rem;
            cursor: pointer; transition: all 0.3s; width: 100%;
            display: flex; justify-content: center; align-items: center; gap: 10px;
            box-shadow: 0 4px 16px rgba(16,185,129,0.25);
        }
        .adm-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(16,185,129,0.35);
        }

        /* Alert */
        .adm-alert {
            display: flex; align-items: center; gap: 16px;
            padding: 18px 24px; border-radius: 16px; margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .adm-alert-success { background: rgba(34,197,94,0.08); border-left: 4px solid #22c55e; }
        .adm-alert-error { background: rgba(239,68,68,0.08); border-left: 4px solid #ef4444; }
        .adm-alert-icon { font-size: 1.5rem; }
        .adm-alert-title { font-weight: 700; color: #f1f5f9; font-size: 1rem; }
        .adm-alert-text { color: #94a3b8; font-size: 0.9rem; margin-top: 2px; }

        /* Responsive */
        @media (max-width: 1024px) {
            .adm-stats { grid-template-columns: repeat(2, 1fr); }
            .adm-grid { grid-template-columns: 1fr; }
            .adm-grid-equal { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .adm-stats { grid-template-columns: 1fr; margin: -20px 0 24px; }
            .adm-header-inner { flex-direction: column; gap: 16px; }
            .adm-form-grid { grid-template-columns: 1fr; }
            .adm-filter { flex-direction: column; }
            .adm-filter-input { min-width: 100%; }
        }
    </style>
</head>

<body class="adm-body">
    <?php include 'header.php'; ?>

    <!-- Admin Header -->
    <section class="adm-header">
        <div class="container">
            <div class="adm-header-inner">
                <div>
                    <h1>Admin Dashboard</h1>
                    <p>Manage leads, track revenue, and oversee marketplace operations.</p>
                </div>
                <div class="adm-header-badge">
                    <span class="adm-header-dot"></span>
                    System Online
                </div>
            </div>
        </div>
    </section>

    <div class="container" style="padding-bottom: 60px;">
        <!-- Alert -->
        <?php if (!empty($message)): ?>
            <div class="adm-alert <?php echo $msg_type == 'success' ? 'adm-alert-success' : 'adm-alert-error'; ?>">
                <div class="adm-alert-icon"><?php echo $msg_type == 'success' ? '🎉' : '⚠️'; ?></div>
                <div>
                    <div class="adm-alert-title"><?php echo $msg_type == 'success' ? 'Success' : 'Error'; ?></div>
                    <div class="adm-alert-text"><?php echo htmlspecialchars($message); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Stat Cards -->
        <div class="adm-stats">
            <div class="adm-stat stat-blue">
                <div class="adm-stat-glow"></div>
                <div class="adm-stat-icon">📊</div>
                <div class="adm-stat-value"><?php echo number_format($total_leads); ?></div>
                <div class="adm-stat-label">Total Leads</div>
                <div class="adm-stat-change change-neutral"><?php echo $available_leads_count; ?> active</div>
            </div>
            <div class="adm-stat stat-green">
                <div class="adm-stat-glow"></div>
                <div class="adm-stat-icon">💰</div>
                <div class="adm-stat-value">₹<?php echo number_format($total_revenue); ?></div>
                <div class="adm-stat-label">Total Revenue</div>
                <div class="adm-stat-change change-up">↑ Revenue</div>
            </div>
            <div class="adm-stat stat-purple">
                <div class="adm-stat-glow"></div>
                <div class="adm-stat-icon">👥</div>
                <div class="adm-stat-value"><?php echo number_format($total_users); ?></div>
                <div class="adm-stat-label">Developers</div>
                <div class="adm-stat-change change-neutral">Registered</div>
            </div>
            <div class="adm-stat stat-amber">
                <div class="adm-stat-glow"></div>
                <div class="adm-stat-icon">📈</div>
                <div class="adm-stat-value"><?php echo $conversion_rate; ?>%</div>
                <div class="adm-stat-label">Conversion Rate</div>
                <div class="adm-stat-change change-up"><?php echo $sold_leads_count; ?> sold</div>
            </div>
        </div>

        <!-- Sales Chart + Top Niches -->
        <div class="adm-grid">
            <div class="adm-card">
                <div class="adm-card-header">
                    <div class="adm-card-title"><span class="bar"></span> Revenue & Sales Overview</div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="adm-card">
                <div class="adm-card-header">
                    <div class="adm-card-title"><span class="bar" style="background: #8b5cf6;"></span> Top Niches</div>
                </div>
                <div class="niche-list">
                    <?php
                    $max_niche = !empty($top_niches) ? max(array_column($top_niches, 'cnt')) : 1;
                    foreach ($top_niches as $niche):
                        $pct = round(($niche['cnt'] / $max_niche) * 100);
                    ?>
                        <div class="niche-row">
                            <span class="niche-name"><?php echo htmlspecialchars($niche['niche']); ?></span>
                            <div class="niche-bar"><div class="niche-bar-fill" style="width: <?php echo $pct; ?>%"></div></div>
                            <span class="niche-count"><?php echo $niche['cnt']; ?></span>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($top_niches)): ?>
                        <div style="text-align: center; color: #475569; padding: 40px 0;">No niches yet</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Users + Recent Transactions -->
        <div class="adm-grid-equal">
            <div class="adm-card">
                <div class="adm-card-header">
                    <div class="adm-card-title"><span class="bar" style="background: #a78bfa;"></span> Recent Users</div>
                    <span style="font-size: 0.82rem; color: #64748b; font-weight: 500;"><?php echo $total_users; ?> total</span>
                </div>
                <div class="adm-table-wrap">
                    <table class="adm-tbl">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Wallet</th>
                                <th>Purchases</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colors = ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444', '#06b6d4', '#ec4899'];
                            foreach ($recent_users as $i => $user):
                                $color = $colors[$i % count($colors)];
                                $initials = strtoupper(substr($user['username'], 0, 2));
                            ?>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar" style="background: <?php echo $color; ?>20; color: <?php echo $color; ?>;"><?php echo $initials; ?></div>
                                            <div>
                                                <div class="user-name"><?php echo htmlspecialchars($user['username']); ?></div>
                                                <div class="user-email">User #<?php echo $user['id']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="wallet-val">₹<?php echo number_format($user['wallet_balance']); ?></span></td>
                                    <td><span class="purchase-count"><?php echo $user['total_purchases']; ?> leads</span></td>
                                    <td style="color: #64748b; font-size: 0.82rem;"><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($recent_users)): ?>
                                <tr><td colspan="4" style="text-align: center; color: #475569; padding: 40px 0;">No users yet</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-header">
                    <div class="adm-card-title"><span class="bar" style="background: #10b981;"></span> Recent Transactions</div>
                </div>
                <?php foreach ($recent_transactions as $txn):
                    $is_credit = $txn['type'] === 'credit';
                ?>
                    <div class="txn-item <?php echo $is_credit ? 'txn-credit' : 'txn-debit'; ?>">
                        <div class="txn-icon"><?php echo $is_credit ? '↓' : '↑'; ?></div>
                        <div class="txn-info">
                            <div class="txn-desc"><?php echo htmlspecialchars($txn['description']); ?></div>
                            <div class="txn-user">@<?php echo htmlspecialchars($txn['username']); ?> · <?php echo date('d M, H:i', strtotime($txn['created_at'])); ?></div>
                        </div>
                        <div class="txn-amount"><?php echo $is_credit ? '+' : '-'; ?>₹<?php echo number_format($txn['amount']); ?></div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($recent_transactions)): ?>
                    <div style="text-align: center; color: #475569; padding: 40px 0;">No transactions yet</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add Lead Form -->
        <div class="adm-card" style="margin-bottom: 32px;">
            <div class="adm-card-header">
                <div class="adm-card-title"><span class="bar" style="background: #22c55e;"></span> Add New Lead</div>
            </div>
            <form method="POST">
                <input type="hidden" name="add_lead" value="1">
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Niche Category</label>
                        <input type="text" name="niche" class="adm-form-control" required placeholder="e.g. E-commerce Website, Real Estate App">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Client Budget</label>
                        <select name="budget" class="adm-form-control">
                            <option value="15000">Basic (Budget: ₹15k - ₹30k) - Price: ₹999</option>
                            <option value="30000">Business (Budget: ₹30k - ₹50k) - Price: ₹2,499</option>
                            <option value="50000">Premium (Budget: ₹50k - ₹1L+) - Price: ₹4,999</option>
                        </select>
                    </div>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Project Description</label>
                    <textarea name="description" class="adm-form-control" required rows="3" placeholder="Enter detailed project requirements..."></textarea>
                </div>
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Client Name</label>
                        <input type="text" name="client_name" class="adm-form-control" required placeholder="Start typing name...">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Client Phone Number</label>
                        <input type="text" name="client_phone" class="adm-form-control" required placeholder="+91 98765 43210">
                    </div>
                </div>
                <button type="submit" class="adm-btn-submit">🚀 Publish Lead to Marketplace</button>
            </form>
        </div>

        <!-- Leads Table with Filters -->
        <div class="adm-card">
            <div class="adm-card-header">
                <div class="adm-card-title"><span class="bar"></span> All Leads Database</div>
                <span style="background: rgba(59,130,246,0.1); color: #60a5fa; padding: 6px 14px; border-radius: 100px; font-weight: 700; font-size: 0.82rem;">
                    <?php echo count($leads); ?> Total
                </span>
            </div>

            <!-- Filters -->
            <div class="adm-filter" style="margin-bottom: 20px;">
                <input type="text" id="leadSearch" class="adm-filter-input" placeholder="🔍 Search niche, client..." oninput="filterLeads()">
                <select id="leadStatus" class="adm-filter-input" style="min-width: 140px;" onchange="filterLeads()">
                    <option value="all">All Status</option>
                    <option value="available">Available</option>
                    <option value="sold">Sold</option>
                </select>
                <select id="leadBudget" class="adm-filter-input" style="min-width: 160px;" onchange="filterLeads()">
                    <option value="all">All Budgets</option>
                    <option value="15000">Basic (₹15k)</option>
                    <option value="30000">Business (₹30k)</option>
                    <option value="50000">Premium (₹50k+)</option>
                </select>
                <span class="adm-filter-count" id="filterCount"><?php echo count($leads); ?> results</span>
            </div>

            <div class="adm-table-wrap">
                <table class="leads-tbl" id="leadsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Niche & Requirements</th>
                            <th>Budget</th>
                            <th>Price</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $lead): ?>
                            <tr data-niche="<?php echo htmlspecialchars(strtolower($lead['niche'])); ?>"
                                data-client="<?php echo htmlspecialchars(strtolower($lead['client_name'])); ?>"
                                data-status="<?php echo $lead['status']; ?>"
                                data-budget="<?php echo $lead['budget']; ?>">
                                <td><span class="lead-id">#<?php echo $lead['id']; ?></span></td>
                                <td style="max-width: 280px;">
                                    <div class="lead-niche"><?php echo htmlspecialchars($lead['niche']); ?></div>
                                    <div class="lead-desc"><?php echo htmlspecialchars(substr($lead['description'], 0, 60)) . '...'; ?></div>
                                </td>
                                <td><span class="lead-budget">₹<?php echo number_format($lead['budget']); ?>+</span></td>
                                <td><span class="lead-price">₹<?php echo number_format($lead['lead_price']); ?></span></td>
                                <td>
                                    <div class="lead-client-name"><?php echo htmlspecialchars($lead['client_name']); ?></div>
                                    <div class="lead-client-phone"><?php echo htmlspecialchars($lead['client_phone']); ?></div>
                                </td>
                                <td>
                                    <?php if ($lead['status'] == 'available'): ?>
                                        <span class="lead-status lead-avail"><span class="lead-status-dot"></span> Available</span>
                                    <?php else: ?>
                                        <span class="lead-status lead-sold"><span class="lead-status-dot"></span> Sold</span>
                                    <?php endif; ?>
                                </td>
                                <td style="color: #64748b; font-size: 0.82rem; white-space: nowrap;">
                                    <?php echo date('d M Y', strtotime($lead['created_at'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Chart.js Initialization -->
    <script>
        // Sales Chart
        const ctx = document.getElementById('salesChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($monthly_labels); ?>,
                    datasets: [
                        {
                            label: 'Revenue (₹)',
                            data: <?php echo json_encode($monthly_revenue); ?>,
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: '#3b82f6',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Leads Sold',
                            data: <?php echo json_encode($monthly_sold); ?>,
                            type: 'line',
                            borderColor: '#a78bfa',
                            backgroundColor: 'rgba(167, 139, 250, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: '#a78bfa',
                            pointBorderColor: '#1e293b',
                            pointBorderWidth: 3,
                            pointRadius: 5,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: {
                            labels: { color: '#94a3b8', font: { size: 12, weight: 500 }, usePointStyle: true, padding: 20 }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#f1f5f9',
                            bodyColor: '#94a3b8',
                            borderColor: 'rgba(255,255,255,0.08)',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    if (context.datasetIndex === 0) return ' Revenue: ₹' + context.parsed.y.toLocaleString();
                                    return ' Leads Sold: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(255,255,255,0.04)', drawBorder: false },
                            ticks: { color: '#64748b', font: { size: 11 } }
                        },
                        y: {
                            position: 'left',
                            grid: { color: 'rgba(255,255,255,0.04)', drawBorder: false },
                            ticks: {
                                color: '#64748b', font: { size: 11 },
                                callback: function(val) { return '₹' + val.toLocaleString(); }
                            }
                        },
                        y1: {
                            position: 'right',
                            grid: { display: false },
                            ticks: { color: '#a78bfa', font: { size: 11 } }
                        }
                    }
                }
            });
        }

        // Lead Table Filter
        function filterLeads() {
            const search = document.getElementById('leadSearch').value.toLowerCase();
            const status = document.getElementById('leadStatus').value;
            const budget = document.getElementById('leadBudget').value;
            const rows = document.querySelectorAll('#leadsTable tbody tr');
            let visible = 0;

            rows.forEach(row => {
                const niche = row.dataset.niche || '';
                const client = row.dataset.client || '';
                const rStatus = row.dataset.status || '';
                const rBudget = row.dataset.budget || '';

                const matchSearch = !search || niche.includes(search) || client.includes(search);
                const matchStatus = status === 'all' || rStatus === status;
                const matchBudget = budget === 'all' || rBudget === budget;

                if (matchSearch && matchStatus && matchBudget) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });
            document.getElementById('filterCount').textContent = visible + ' result' + (visible !== 1 ? 's' : '');
        }
    </script>
</body>

</html>