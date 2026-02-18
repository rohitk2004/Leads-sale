<?php
require_once 'functions.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
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

// ===== ANALYTICS =====
$total_leads = $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$available_leads_count = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'available'")->fetchColumn();
$sold_leads_count = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'sold'")->fetchColumn();
$total_revenue = $pdo->query("SELECT COALESCE(SUM(purchase_price), 0) FROM purchased_leads")->fetchColumn();
$total_users = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'developer'")->fetchColumn();
$conversion_rate = $total_leads > 0 ? round(($sold_leads_count / $total_leads) * 100, 1) : 0;

// Monthly data (last 6 months)
$monthly_revenue = [];
$monthly_labels = [];
$monthly_sold = [];
for ($i = 5; $i >= 0; $i--) {
    $ms = date('Y-m-01', strtotime("-$i months"));
    $me = date('Y-m-t', strtotime("-$i months"));
    $monthly_labels[] = date('M Y', strtotime("-$i months"));

    $stmt = $pdo->prepare("SELECT COALESCE(SUM(purchase_price), 0) FROM purchased_leads WHERE purchased_at BETWEEN ? AND ?");
    $stmt->execute([$ms, "$me 23:59:59"]);
    $monthly_revenue[] = (float) $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM purchased_leads WHERE purchased_at BETWEEN ? AND ?");
    $stmt->execute([$ms, "$me 23:59:59"]);
    $monthly_sold[] = (int) $stmt->fetchColumn();
}

// Recent Users
$recent_users = $pdo->query("SELECT u.id, u.username, u.role, u.wallet_balance, u.created_at,
    (SELECT COUNT(*) FROM purchased_leads WHERE user_id = u.id) as total_purchases
    FROM users u WHERE u.role = 'developer' ORDER BY u.created_at DESC LIMIT 10")->fetchAll();

// Top Niches
$top_niches = $pdo->query("SELECT niche, COUNT(*) as cnt FROM leads GROUP BY niche ORDER BY cnt DESC LIMIT 5")->fetchAll();

// Recent Transactions
$recent_transactions = $pdo->query("SELECT t.*, u.username FROM transactions t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC LIMIT 8")->fetchAll();

// All Leads
$leads = $pdo->query("SELECT * FROM leads ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - QuickProject</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f0f4f8;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Layout ─── */
        .dash-wrap {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ─── Top Bar ─── */
        .dash-topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .dash-topbar-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dash-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            text-decoration: none;
        }

        .dash-logo-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
        }

        .dash-topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .dash-badge-online {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #16a34a;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 6px 14px;
            border-radius: 100px;
        }

        .dash-badge-online::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse-dot 2s infinite;
        }

        .dash-user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px 6px 6px;
            border-radius: 100px;
            background: #f1f5f9;
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
        }

        .dash-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        /* ─── Page Header ─── */
        .dash-page-header {
            padding: 36px 0 28px;
        }

        .dash-page-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .dash-page-header p {
            color: #64748b;
            font-size: 0.92rem;
        }

        /* ─── Stat Cards ─── */
        .dash-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .dash-stat {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .dash-stat::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            border-radius: 0 4px 4px 0;
        }

        .dash-stat:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }

        .dash-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .dash-stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            line-height: 1;
        }

        .dash-stat-label {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 6px;
        }

        .dash-stat-tag {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 100px;
            margin-top: 8px;
            display: inline-block;
        }

        .s-blue::before {
            background: #3b82f6;
        }

        .s-blue .dash-stat-icon {
            background: #eff6ff;
            color: #3b82f6;
        }

        .s-blue .dash-stat-tag {
            background: #eff6ff;
            color: #2563eb;
        }

        .s-green::before {
            background: #10b981;
        }

        .s-green .dash-stat-icon {
            background: #ecfdf5;
            color: #10b981;
        }

        .s-green .dash-stat-tag {
            background: #ecfdf5;
            color: #059669;
        }

        .s-purple::before {
            background: #8b5cf6;
        }

        .s-purple .dash-stat-icon {
            background: #f5f3ff;
            color: #8b5cf6;
        }

        .s-purple .dash-stat-tag {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .s-amber::before {
            background: #f59e0b;
        }

        .s-amber .dash-stat-icon {
            background: #fffbeb;
            color: #f59e0b;
        }

        .s-amber .dash-stat-tag {
            background: #fffbeb;
            color: #d97706;
        }

        /* ─── Cards ─── */
        .dash-grid {
            display: grid;
            grid-template-columns: 5fr 3fr;
            gap: 24px;
            margin-bottom: 28px;
        }

        .dash-grid-half {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }

        .dash-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .dash-card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .dash-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dash-card-title .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .dash-card-count {
            background: #f1f5f9;
            color: #475569;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        /* ─── Chart ─── */
        .chart-box {
            height: 280px;
            position: relative;
        }

        /* ─── Niches ─── */
        .niche-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .niche-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #f1f5f9;
        }

        .niche-name {
            font-weight: 600;
            font-size: 0.88rem;
            color: #334155;
            white-space: nowrap;
        }

        .niche-bar-wrap {
            flex: 1;
            height: 8px;
            background: #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .niche-bar-fill {
            height: 100%;
            border-radius: 8px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            transition: width 0.6s ease;
        }

        .niche-count {
            background: #eff6ff;
            color: #2563eb;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
        }

        /* ─── Tables ─── */
        .d-table-wrap {
            overflow-x: auto;
        }

        .d-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .d-tbl th {
            text-align: left;
            padding: 12px 16px;
            background: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }

        .d-tbl td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.88rem;
            vertical-align: middle;
            color: #334155;
        }

        .d-tbl tr:hover td {
            background: #fafbfc;
        }

        .d-user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .d-avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.72rem;
            color: #fff;
        }

        .d-user-name {
            font-weight: 600;
            color: #0f172a;
        }

        .d-user-sub {
            font-size: 0.78rem;
            color: #94a3b8;
        }

        .d-wallet {
            font-weight: 700;
            color: #059669;
        }

        .d-purchase-tag {
            background: #f5f3ff;
            color: #7c3aed;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        /* ─── Transactions ─── */
        .txn-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .txn-item:last-child {
            border-bottom: none;
        }

        .txn-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .txn-credit .txn-icon {
            background: #ecfdf5;
            color: #059669;
        }

        .txn-debit .txn-icon {
            background: #fef2f2;
            color: #dc2626;
        }

        .txn-info {
            flex: 1;
        }

        .txn-desc {
            font-weight: 600;
            font-size: 0.88rem;
            color: #1e293b;
        }

        .txn-meta {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        .txn-amt {
            font-weight: 700;
            font-size: 0.92rem;
        }

        .txn-credit .txn-amt {
            color: #059669;
        }

        .txn-debit .txn-amt {
            color: #dc2626;
        }

        /* ─── Filter Bar ─── */
        .dash-filter {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .dash-filter-input {
            padding: 9px 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #334155;
            font-size: 0.85rem;
            font-family: inherit;
            transition: all 0.2s;
            min-width: 180px;
        }

        .dash-filter-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: #fff;
        }

        .dash-filter-input::placeholder {
            color: #94a3b8;
        }

        .dash-filter select {
            cursor: pointer;
        }

        .dash-filter select option {
            background: #fff;
        }

        .dash-filter-count {
            margin-left: auto;
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        /* ─── Lead Table ─── */
        .lead-id {
            font-weight: 700;
            color: #94a3b8;
            font-size: 0.82rem;
        }

        .lead-niche {
            font-weight: 700;
            color: #0f172a;
        }

        .lead-desc {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 3px;
        }

        .lead-budget {
            font-weight: 600;
            color: #475569;
        }

        .lead-price {
            font-weight: 700;
            color: #059669;
            background: #ecfdf5;
            padding: 3px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .lead-client-name {
            font-weight: 600;
            color: #1e293b;
        }

        .lead-client-phone {
            font-size: 0.78rem;
            color: #94a3b8;
        }

        .lead-status {
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .lead-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .lead-avail {
            background: #ecfdf5;
            color: #059669;
        }

        .lead-sold {
            background: #fffbeb;
            color: #d97706;
        }

        /* ─── Form ─── */
        .dash-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .dash-form-group {
            margin-bottom: 16px;
        }

        .dash-form-label {
            display: block;
            margin-bottom: 6px;
            color: #475569;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .dash-form-control {
            width: 100%;
            padding: 10px 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #1e293b;
            font-family: inherit;
            font-size: 0.92rem;
            transition: all 0.2s;
        }

        .dash-form-control:focus {
            outline: none;
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dash-form-control::placeholder {
            color: #94a3b8;
        }

        .dash-btn-submit {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.25s;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
        }

        .dash-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        /* ─── Alert ─── */
        .dash-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .dash-alert-ok {
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
        }

        .dash-alert-err {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .dash-alert-icon {
            font-size: 1.3rem;
        }

        .dash-alert-title {
            font-weight: 700;
            font-size: 0.92rem;
        }

        .dash-alert-ok .dash-alert-title {
            color: #15803d;
        }

        .dash-alert-err .dash-alert-title {
            color: #b91c1c;
        }

        .dash-alert-text {
            color: #64748b;
            font-size: 0.85rem;
        }

        /* ─── Empty State ─── */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #94a3b8;
        }

        .empty-state-icon {
            font-size: 2.5rem;
            margin-bottom: 8px;
        }

        .empty-state a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        /* ─── Responsive ─── */
        @media (max-width: 1024px) {
            .dash-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .dash-grid,
            .dash-grid-half {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .dash-stats {
                grid-template-columns: 1fr;
            }

            .dash-form-grid {
                grid-template-columns: 1fr;
            }

            .dash-topbar-right .dash-badge-online {
                display: none;
            }

            .dash-page-header h1 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>

    <!-- Top Bar -->
    <header class="dash-topbar">
        <div class="dash-wrap">
            <div class="dash-topbar-inner">
                <a href="index.php" class="dash-logo">
                    <span class="dash-logo-icon">💼</span>
                    QuickProject
                </a>
                <div class="dash-topbar-right">
                    <span class="dash-badge-online">System Online</span>
                    <div class="dash-user-pill">
                        <span class="dash-user-avatar">A</span>
                        Admin
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="dash-wrap" style="padding-bottom: 60px;">

        <!-- Page Header -->
        <div class="dash-page-header">
            <h1>Dashboard Overview</h1>
            <p>Manage leads, track revenue, and oversee marketplace operations.</p>
        </div>

        <!-- Alert -->
        <?php if (!empty($message)): ?>
            <div class="dash-alert <?php echo $msg_type == 'success' ? 'dash-alert-ok' : 'dash-alert-err'; ?>">
                <span class="dash-alert-icon"><?php echo $msg_type == 'success' ? '✅' : '⚠️'; ?></span>
                <div>
                    <div class="dash-alert-title"><?php echo $msg_type == 'success' ? 'Success' : 'Error'; ?></div>
                    <div class="dash-alert-text"><?php echo htmlspecialchars($message); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="dash-stats">
            <div class="dash-stat s-blue">
                <div class="dash-stat-icon">📊</div>
                <div>
                    <div class="dash-stat-value"><?php echo number_format($total_leads); ?></div>
                    <div class="dash-stat-label">Total Leads</div>
                    <span class="dash-stat-tag"><?php echo $available_leads_count; ?> active</span>
                </div>
            </div>
            <div class="dash-stat s-green">
                <div class="dash-stat-icon">💰</div>
                <div>
                    <div class="dash-stat-value">₹<?php echo number_format($total_revenue); ?></div>
                    <div class="dash-stat-label">Total Revenue</div>
                    <span class="dash-stat-tag">All time</span>
                </div>
            </div>
            <div class="dash-stat s-purple">
                <div class="dash-stat-icon">👥</div>
                <div>
                    <div class="dash-stat-value"><?php echo number_format($total_users); ?></div>
                    <div class="dash-stat-label">Developers</div>
                    <span class="dash-stat-tag">Registered</span>
                </div>
            </div>
            <div class="dash-stat s-amber">
                <div class="dash-stat-icon">📈</div>
                <div>
                    <div class="dash-stat-value"><?php echo $conversion_rate; ?>%</div>
                    <div class="dash-stat-label">Conversion</div>
                    <span class="dash-stat-tag"><?php echo $sold_leads_count; ?> sold</span>
                </div>
            </div>
        </div>

        <!-- Chart + Niches -->
        <div class="dash-grid">
            <div class="dash-card">
                <div class="dash-card-head">
                    <div class="dash-card-title"><span class="dot" style="background:#3b82f6;"></span> Revenue & Sales
                    </div>
                </div>
                <div class="chart-box"><canvas id="salesChart"></canvas></div>
            </div>
            <div class="dash-card">
                <div class="dash-card-head">
                    <div class="dash-card-title"><span class="dot" style="background:#8b5cf6;"></span> Top Niches</div>
                </div>
                <div class="niche-list">
                    <?php
                    $max_n = !empty($top_niches) ? max(array_column($top_niches, 'cnt')) : 1;
                    foreach ($top_niches as $n):
                        $pct = round(($n['cnt'] / $max_n) * 100);
                        ?>
                        <div class="niche-row">
                            <span class="niche-name"><?php echo htmlspecialchars($n['niche']); ?></span>
                            <div class="niche-bar-wrap">
                                <div class="niche-bar-fill" style="width:<?php echo $pct; ?>%"></div>
                            </div>
                            <span class="niche-count"><?php echo $n['cnt']; ?></span>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($top_niches)): ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📁</div>No niches yet
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Users + Transactions -->
        <div class="dash-grid-half">
            <div class="dash-card">
                <div class="dash-card-head">
                    <div class="dash-card-title"><span class="dot" style="background:#6366f1;"></span> Recent Users
                    </div>
                    <span class="dash-card-count"><?php echo $total_users; ?> total</span>
                </div>
                <div class="d-table-wrap">
                    <table class="d-tbl">
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
                            foreach ($recent_users as $i => $u):
                                $c = $colors[$i % count($colors)];
                                $init = strtoupper(substr($u['username'], 0, 2));
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-user-cell">
                                            <div class="d-avatar" style="background:<?php echo $c; ?>"><?php echo $init; ?>
                                            </div>
                                            <div>
                                                <div class="d-user-name"><?php echo htmlspecialchars($u['username']); ?>
                                                </div>
                                                <div class="d-user-sub">ID #<?php echo $u['id']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="d-wallet">₹<?php echo number_format($u['wallet_balance']); ?></span>
                                    </td>
                                    <td><span class="d-purchase-tag"><?php echo $u['total_purchases']; ?> leads</span></td>
                                    <td style="color:#94a3b8; font-size:0.8rem;">
                                        <?php echo date('d M Y', strtotime($u['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($recent_users)): ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">👤</div>No users yet
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dash-card">
                <div class="dash-card-head">
                    <div class="dash-card-title"><span class="dot" style="background:#10b981;"></span> Recent
                        Transactions</div>
                </div>
                <?php foreach ($recent_transactions as $t):
                    $cr = $t['type'] === 'credit';
                    ?>
                    <div class="txn-item <?php echo $cr ? 'txn-credit' : 'txn-debit'; ?>">
                        <div class="txn-icon"><?php echo $cr ? '↓' : '↑'; ?></div>
                        <div class="txn-info">
                            <div class="txn-desc"><?php echo htmlspecialchars($t['description']); ?></div>
                            <div class="txn-meta">@<?php echo htmlspecialchars($t['username']); ?> ·
                                <?php echo date('d M, H:i', strtotime($t['created_at'])); ?></div>
                        </div>
                        <div class="txn-amt"><?php echo $cr ? '+' : '-'; ?>₹<?php echo number_format($t['amount']); ?></div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($recent_transactions)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">💳</div>No transactions yet
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add Lead Form -->
        <div class="dash-card" style="margin-bottom: 28px;">
            <div class="dash-card-head">
                <div class="dash-card-title"><span class="dot" style="background:#10b981;"></span> Add New Lead</div>
            </div>
            <form method="POST">
                <input type="hidden" name="add_lead" value="1">
                <div class="dash-form-grid">
                    <div class="dash-form-group">
                        <label class="dash-form-label">Niche Category</label>
                        <input type="text" name="niche" class="dash-form-control" required
                            placeholder="e.g. E-commerce Website, Real Estate App">
                    </div>
                    <div class="dash-form-group">
                        <label class="dash-form-label">Client Budget</label>
                        <select name="budget" class="dash-form-control">
                            <option value="15000">Basic (₹15k–₹30k) — ₹999</option>
                            <option value="30000">Business (₹30k–₹50k) — ₹2,499</option>
                            <option value="50000">Premium (₹50k–₹1L+) — ₹4,999</option>
                        </select>
                    </div>
                </div>
                <div class="dash-form-group">
                    <label class="dash-form-label">Project Description</label>
                    <textarea name="description" class="dash-form-control" required rows="3"
                        placeholder="Enter detailed project requirements..."></textarea>
                </div>
                <div class="dash-form-grid">
                    <div class="dash-form-group">
                        <label class="dash-form-label">Client Name</label>
                        <input type="text" name="client_name" class="dash-form-control" required
                            placeholder="Full name">
                    </div>
                    <div class="dash-form-group">
                        <label class="dash-form-label">Client Phone</label>
                        <input type="text" name="client_phone" class="dash-form-control" required
                            placeholder="+91 98765 43210">
                    </div>
                </div>
                <button type="submit" class="dash-btn-submit">🚀 Publish Lead to Marketplace</button>
            </form>
        </div>

        <!-- Leads Table -->
        <div class="dash-card">
            <div class="dash-card-head">
                <div class="dash-card-title"><span class="dot" style="background:#3b82f6;"></span> All Leads</div>
                <span class="dash-card-count"><?php echo count($leads); ?> total</span>
            </div>

            <div class="dash-filter">
                <input type="text" id="leadSearch" class="dash-filter-input" placeholder="🔍 Search niche or client..."
                    oninput="filterLeads()">
                <select id="leadStatus" class="dash-filter-input" style="min-width:130px;" onchange="filterLeads()">
                    <option value="all">All Status</option>
                    <option value="available">Available</option>
                    <option value="sold">Sold</option>
                </select>
                <select id="leadBudget" class="dash-filter-input" style="min-width:150px;" onchange="filterLeads()">
                    <option value="all">All Budgets</option>
                    <option value="15000">Basic (₹15k)</option>
                    <option value="30000">Business (₹30k)</option>
                    <option value="50000">Premium (₹50k+)</option>
                </select>
                <span class="dash-filter-count" id="filterCount"><?php echo count($leads); ?> results</span>
            </div>

            <div class="d-table-wrap">
                <table class="d-tbl" id="leadsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Niche</th>
                            <th>Budget</th>
                            <th>Price</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $l): ?>
                            <tr data-niche="<?php echo htmlspecialchars(strtolower($l['niche'])); ?>"
                                data-client="<?php echo htmlspecialchars(strtolower($l['client_name'])); ?>"
                                data-status="<?php echo $l['status']; ?>" data-budget="<?php echo $l['budget']; ?>">
                                <td><span class="lead-id">#<?php echo $l['id']; ?></span></td>
                                <td style="max-width:260px;">
                                    <div class="lead-niche"><?php echo htmlspecialchars($l['niche']); ?></div>
                                    <div class="lead-desc">
                                        <?php echo htmlspecialchars(substr($l['description'], 0, 55)) . '...'; ?></div>
                                </td>
                                <td><span class="lead-budget">₹<?php echo number_format($l['budget']); ?>+</span></td>
                                <td><span class="lead-price">₹<?php echo number_format($l['lead_price']); ?></span></td>
                                <td>
                                    <div class="lead-client-name"><?php echo htmlspecialchars($l['client_name']); ?></div>
                                    <div class="lead-client-phone"><?php echo htmlspecialchars($l['client_phone']); ?></div>
                                </td>
                                <td>
                                    <?php if ($l['status'] == 'available'): ?>
                                        <span class="lead-status lead-avail"><span class="lead-status-dot"></span>
                                            Available</span>
                                    <?php else: ?>
                                        <span class="lead-status lead-sold"><span class="lead-status-dot"></span> Sold</span>
                                    <?php endif; ?>
                                </td>
                                <td style="color:#94a3b8; font-size:0.8rem; white-space:nowrap;">
                                    <?php echo date('d M Y', strtotime($l['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($leads)): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📭</div>
                                        <div>No leads found.</div>
                                        <div style="margin-top:8px;"><a href="seed.php">Add Demo Data</a></div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
// ─── Chart ───
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
                    backgroundColor: 'rgba(59,130,246,0.12)',
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                    yAxisID: 'y',
                },
                {
                    label: 'Leads Sold',
                    data: <?php echo json_encode($monthly_sold); ?>,
                    type: 'line',
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.06)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#8b5cf6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
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
                    labels: {
                        color: '#64748b', font: { size: 12, weight: 500 },
                        usePointStyle: true, padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#0f172a',
                    bodyColor: '#475569',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 10,
                    boxShadow: '0 4px 12px rgba(0,0,0,0.08)',
                    callbacks: {
                        label: function(c) {
                            return c.datasetIndex === 0
                                ? ' Revenue: ₹' + c.parsed.y.toLocaleString()
                                : ' Leads Sold: ' + c.parsed.y;
                        }
                    }
                }
            },
             scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11 } }
                },
                y: {
                    position: 'left',
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        color: '#94a3b8', font: { size: 11 },
                        callback: v => '₹' + v.toLocaleString()
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

// ─── Filter ───
function filterLeads() {
    const s = document.getElementById('leadSearch').value.toLowerCase();
    const st = document.getElementById('leadStatus').value;
    const b = document.getElem entById('leadBudget').value;
    let v = 0;
    document.querySelectorAll('#leadsTable tbody tr').forEach(r => {
        const ok =
            (!s || (r.dataset.niche||'').includes(s) || (r.dataset.client||'').includes(s)) &&
            (st === 'all' || r.dataset.status === st) &&
            (b === 'all' || r.dataset.budget === b);
        r.style.display = ok ? '' : 'none';
        if (ok) v++;
    });
    document.getElementById('filterCount').textContent = v + ' result' + (v !== 1 ? 's' : '');
}
    </script>
</body>

</html>