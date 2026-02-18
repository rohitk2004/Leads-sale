<?php
require_once 'functions.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_login('admin');

$message = "";
$msg_type = "";

// Add Lead
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_lead'])) {
    $niche = trim($_POST['niche']);
    $budget = (float) $_POST['budget'];
    $desc = trim($_POST['description']);
    $name = trim($_POST['client_name']);
    $phone = trim($_POST['client_phone']);
    $lead_price = ($budget == 50000) ? 4999 : (($budget == 30000) ? 2499 : 999);

    try {
        $stmt = $pdo->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, 'available')");
        $stmt->execute([$niche, $budget, $lead_price, $desc, $name, $phone]);
        $message = "Lead published successfully!";
        $msg_type = "success";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $msg_type = "error";
    }
}

// Analytics
$total_leads = $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$available_count = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'available'")->fetchColumn();
$sold_count = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'sold'")->fetchColumn();
$total_revenue = $pdo->query("SELECT COALESCE(SUM(purchase_price), 0) FROM purchased_leads")->fetchColumn();
$total_users = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'developer'")->fetchColumn();
$conversion = $total_leads > 0 ? round(($sold_count / $total_leads) * 100, 1) : 0;

// Monthly chart data (6 months)
$chart_labels = [];
$chart_revenue = [];
$chart_sold = [];
for ($i = 5; $i >= 0; $i--) {
    $ms = date('Y-m-01', strtotime("-$i months"));
    $me = date('Y-m-t', strtotime("-$i months"));
    $chart_labels[] = date('M', strtotime("-$i months"));
    $s = $pdo->prepare("SELECT COALESCE(SUM(purchase_price),0) FROM purchased_leads WHERE purchased_at BETWEEN ? AND ?");
    $s->execute([$ms, "$me 23:59:59"]);
    $chart_revenue[] = (float) $s->fetchColumn();
    $s = $pdo->prepare("SELECT COUNT(*) FROM purchased_leads WHERE purchased_at BETWEEN ? AND ?");
    $s->execute([$ms, "$me 23:59:59"]);
    $chart_sold[] = (int) $s->fetchColumn();
}

// If all chart data is zero, show sample data
$has_chart_data = array_sum($chart_revenue) > 0 || array_sum($chart_sold) > 0;
if (!$has_chart_data) {
    $chart_revenue = [2500, 4999, 1999, 7498, 4999, 9998];
    $chart_sold = [1, 2, 1, 3, 2, 4];
}

// Users, Niches, Transactions
$recent_users = $pdo->query("SELECT u.id, u.username, u.role, u.wallet_balance, u.created_at,
    (SELECT COUNT(*) FROM purchased_leads WHERE user_id = u.id) as total_purchases
    FROM users u WHERE u.role = 'developer' ORDER BY u.created_at DESC LIMIT 8")->fetchAll();

$top_niches = $pdo->query("SELECT niche, COUNT(*) as cnt FROM leads GROUP BY niche ORDER BY cnt DESC LIMIT 5")->fetchAll();

$recent_txns = $pdo->query("SELECT t.*, u.username FROM transactions t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC LIMIT 6")->fetchAll();

$leads = $pdo->query("SELECT * FROM leads ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — QuickProject</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #f4f6fb;
            --white: #ffffff;
            --border: #e8ecf4;
            --text: #0f172a;
            --text2: #475569;
            --text3: #94a3b8;
            --blue: #3b82f6;
            --indigo: #6366f1;
            --green: #10b981;
            --purple: #8b5cf6;
            --amber: #f59e0b;
            --red: #ef4444;
            --radius: 14px;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
            --shadow-lg: 0 10px 30px -5px rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
        }

        /* ═══ SIDEBAR + LAYOUT ═══ */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: var(--white);
            border-right: 1px solid var(--border);
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 50;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 36px;
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
        }

        .sidebar-logo span {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text);
        }

        .sidebar-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text3);
            margin: 20px 0 10px 12px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--text2);
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .sidebar-link:hover {
            background: #f1f5f9;
            color: var(--text);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #eff6ff, #ede9fe);
            color: var(--blue);
            font-weight: 600;
        }

        .sidebar-link .icon {
            font-size: 1.05rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 16px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
        }

        .sidebar-uname {
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--text);
        }

        .sidebar-urole {
            font-size: 0.72rem;
            color: var(--text3);
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 32px 36px 60px;
        }

        /* ═══ HEADER ═══ */
        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .page-head h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .page-head p {
            color: var(--text3);
            font-size: 0.88rem;
            margin-top: 4px;
        }

        .head-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .head-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 100px;
        }

        .head-badge-green {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #bbf7d0;
        }

        .head-badge-green::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            animation: blink 2s infinite;
        }

        .head-date {
            font-size: 0.82rem;
            color: var(--text3);
            font-weight: 500;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .3;
            }
        }

        /* ═══ STAT CARDS ═══ */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat {
            background: var(--white);
            border-radius: var(--radius);
            padding: 22px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .stat:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-3px);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }

        .stat-tag {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 100px;
        }

        .stat-val {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.5px;
            line-height: 1;
        }

        .stat-lbl {
            font-size: 0.75rem;
            color: var(--text3);
            font-weight: 500;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .stat-line {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .st-blue .stat-icon {
            background: #eff6ff;
        }

        .st-blue .stat-tag {
            background: #eff6ff;
            color: #2563eb;
        }

        .st-blue .stat-line {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }

        .st-green .stat-icon {
            background: #ecfdf5;
        }

        .st-green .stat-tag {
            background: #ecfdf5;
            color: #059669;
        }

        .st-green .stat-line {
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .st-purple .stat-icon {
            background: #f5f3ff;
        }

        .st-purple .stat-tag {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .st-purple .stat-line {
            background: linear-gradient(90deg, #8b5cf6, #a78bfa);
        }

        .st-amber .stat-icon {
            background: #fffbeb;
        }

        .st-amber .stat-tag {
            background: #fffbeb;
            color: #d97706;
        }

        .st-amber .stat-line {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }

        /* ═══ CARDS ═══ */
        .grid-2-1 {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .grid-half {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 22px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .card-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .card-badge {
            background: #f1f5f9;
            color: var(--text2);
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        /* ═══ CHART ═══ */
        .chart-wrap {
            position: relative;
            height: 260px;
        }

        <?php if (!$has_chart_data): ?>
            .chart-sample-note {
                position: absolute;
                top: 12px;
                right: 12px;
                background: #fffbeb;
                color: #92400e;
                font-size: 0.7rem;
                font-weight: 600;
                padding: 4px 10px;
                border-radius: 100px;
                border: 1px solid #fde68a;
                z-index: 5;
            }

        <?php endif; ?>

        /* ═══ NICHES ═══ */
        .n-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .n-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: #f8fafc;
            border-radius: 10px;
        }

        .n-rank {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            background: #eff6ff;
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .n-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text);
            flex: 1;
        }

        .n-bar-wrap {
            width: 80px;
            height: 6px;
            background: #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .n-bar-fill {
            height: 100%;
            border-radius: 6px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
        }

        .n-cnt {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--blue);
            background: #eff6ff;
            padding: 2px 8px;
            border-radius: 100px;
        }

        /* ═══ MINI TABLE ═══ */
        .mt {
            width: 100%;
            border-collapse: collapse;
        }

        .mt th {
            text-align: left;
            padding: 10px 14px;
            background: #f8fafc;
            color: var(--text3);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border);
        }

        .mt td {
            padding: 10px 14px;
            border-bottom: 1px solid #f8fafc;
            font-size: 0.85rem;
            color: var(--text2);
            vertical-align: middle;
        }

        .mt tr:hover td {
            background: #fafbfc;
        }

        .u-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .u-av {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.68rem;
            color: #fff;
            flex-shrink: 0;
        }

        .u-name {
            font-weight: 600;
            color: var(--text);
            font-size: 0.85rem;
        }

        .u-sub {
            font-size: 0.72rem;
            color: var(--text3);
        }

        .u-wallet {
            font-weight: 700;
            color: #059669;
        }

        .u-ptag {
            background: #f5f3ff;
            color: #7c3aed;
            padding: 2px 8px;
            border-radius: 100px;
            font-size: 0.68rem;
            font-weight: 700;
        }

        /* ═══ TRANSACTIONS ═══ */
        .tx {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f8fafc;
        }

        .tx:last-child {
            border: none;
        }

        .tx-ic {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .tx-cr .tx-ic {
            background: #ecfdf5;
            color: #059669;
        }

        .tx-db .tx-ic {
            background: #fef2f2;
            color: #dc2626;
        }

        .tx-info {
            flex: 1;
        }

        .tx-desc {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text);
        }

        .tx-meta {
            font-size: 0.72rem;
            color: var(--text3);
            margin-top: 2px;
        }

        .tx-amt {
            font-weight: 700;
            font-size: 0.88rem;
        }

        .tx-cr .tx-amt {
            color: #059669;
        }

        .tx-db .tx-amt {
            color: #dc2626;
        }

        /* ═══ FILTER BAR ═══ */
        .fbar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 14px;
            align-items: center;
        }

        .finput {
            padding: 8px 14px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-size: 0.82rem;
            font-family: inherit;
            transition: all 0.2s;
            min-width: 170px;
        }

        .finput:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
            background: #fff;
        }

        .finput::placeholder {
            color: var(--text3);
        }

        .fcount {
            margin-left: auto;
            font-size: 0.78rem;
            color: var(--text3);
            font-weight: 500;
        }

        /* ═══ LEADS TABLE ═══ */
        .lt {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .lt th {
            text-align: left;
            padding: 12px 16px;
            background: #f8fafc;
            color: var(--text3);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border);
        }

        .lt td {
            padding: 12px 16px;
            border-bottom: 1px solid #f8fafc;
            font-size: 0.85rem;
            color: var(--text2);
            vertical-align: middle;
        }

        .lt tr:hover td {
            background: #fafbfc;
        }

        .l-id {
            font-weight: 700;
            color: var(--text3);
            font-size: 0.8rem;
        }

        .l-niche {
            font-weight: 700;
            color: var(--text);
        }

        .l-desc {
            font-size: 0.75rem;
            color: var(--text3);
            margin-top: 2px;
        }

        .l-budget {
            font-weight: 600;
            color: var(--text2);
        }

        .l-price {
            font-weight: 700;
            color: #059669;
            background: #ecfdf5;
            padding: 3px 10px;
            border-radius: 6px;
            display: inline-block;
            font-size: 0.82rem;
        }

        .l-cname {
            font-weight: 600;
            color: var(--text);
        }

        .l-cphone {
            font-size: 0.75rem;
            color: var(--text3);
        }

        .l-status {
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .l-status i {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        .l-av {
            background: #ecfdf5;
            color: #059669;
        }

        .l-sd {
            background: #fffbeb;
            color: #d97706;
        }

        /* ═══ FORM ═══ */
        .fg2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .fgrp {
            margin-bottom: 14px;
        }

        .flbl {
            display: block;
            margin-bottom: 5px;
            color: var(--text2);
            font-weight: 500;
            font-size: 0.82rem;
        }

        .fctrl {
            width: 100%;
            padding: 10px 14px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: inherit;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .fctrl:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
            background: #fff;
        }

        .fctrl::placeholder {
            color: var(--text3);
        }

        .btn-pub {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.92rem;
            cursor: pointer;
            transition: all 0.25s;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.18);
        }

        .btn-pub:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.28);
        }

        /* ═══ ALERT ═══ */
        .dash-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 18px;
        }

        .alert-ok {
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
        }

        .alert-err {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert-ic {
            font-size: 1.2rem;
        }

        .alert-t {
            font-weight: 700;
            font-size: 0.88rem;
        }

        .alert-ok .alert-t {
            color: #15803d;
        }

        .alert-err .alert-t {
            color: #b91c1c;
        }

        .alert-m {
            color: var(--text2);
            font-size: 0.82rem;
        }

        /* ═══ EMPTY ═══ */
        .empty {
            text-align: center;
            padding: 36px 16px;
            color: var(--text3);
        }

        .empty-ic {
            font-size: 2rem;
            margin-bottom: 6px;
        }

        .empty a {
            color: var(--blue);
            font-weight: 600;
        }

        /* ═══ RESPONSIVE ═══ */
        @media(max-width:1100px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }

        @media(max-width:900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-2-1,
            .grid-half {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 20px 16px 40px;
            }
        }

        @media(max-width:600px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .fg2 {
                grid-template-columns: 1fr;
            }

            .page-head {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="layout">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <span class="sidebar-logo-icon">💼</span>
                <span>QuickProject</span>
            </div>
            <div class="sidebar-label">Main</div>
            <a href="admin_dashboard.php" class="sidebar-link active"><span class="icon">📊</span> Dashboard</a>
            <a href="#leads-section" class="sidebar-link"><span class="icon">📋</span> All Leads</a>
            <a href="#add-lead" class="sidebar-link"><span class="icon">➕</span> Add Lead</a>
            <div class="sidebar-label">Manage</div>
            <a href="#users-section" class="sidebar-link"><span class="icon">👥</span> Users</a>
            <a href="#txn-section" class="sidebar-link"><span class="icon">💳</span> Transactions</a>
            <div class="sidebar-label">Account</div>
            <a href="index.php" class="sidebar-link"><span class="icon">🌐</span> View Site</a>
            <a href="logout.php" class="sidebar-link"><span class="icon">🚪</span> Logout</a>

            <div class="sidebar-bottom">
                <div class="sidebar-user">
                    <div class="sidebar-avatar">AD</div>
                    <div>
                        <div class="sidebar-uname"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>
                        </div>
                        <div class="sidebar-urole">Administrator</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <div class="main-content">

            <!-- Header -->
            <div class="page-head">
                <div>
                    <h1>Dashboard</h1>
                    <p>Overview of your marketplace performance</p>
                </div>
                <div class="head-right">
                    <span class="head-date"><?php echo date('D, d M Y'); ?></span>
                    <span class="head-badge head-badge-green">Live</span>
                </div>
            </div>

            <!-- Alert -->
            <?php if (!empty($message)): ?>
                <div class="dash-alert <?php echo $msg_type == 'success' ? 'alert-ok' : 'alert-err'; ?>">
                    <span class="alert-ic"><?php echo $msg_type == 'success' ? '✅' : '⚠️'; ?></span>
                    <div>
                        <div class="alert-t"><?php echo $msg_type == 'success' ? 'Success' : 'Error'; ?></div>
                        <div class="alert-m"><?php echo htmlspecialchars($message); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Stats -->
            <div class="stats">
                <div class="stat st-blue">
                    <div class="stat-top">
                        <div class="stat-icon">📊</div>
                        <span class="stat-tag"><?php echo $available_count; ?> active</span>
                    </div>
                    <div class="stat-val"><?php echo number_format($total_leads); ?></div>
                    <div class="stat-lbl">Total Leads</div>
                    <div class="stat-line"></div>
                </div>
                <div class="stat st-green">
                    <div class="stat-top">
                        <div class="stat-icon">💰</div>
                        <span class="stat-tag">All time</span>
                    </div>
                    <div class="stat-val">₹<?php echo number_format($total_revenue); ?></div>
                    <div class="stat-lbl">Revenue</div>
                    <div class="stat-line"></div>
                </div>
                <div class="stat st-purple">
                    <div class="stat-top">
                        <div class="stat-icon">👥</div>
                        <span class="stat-tag">Registered</span>
                    </div>
                    <div class="stat-val"><?php echo number_format($total_users); ?></div>
                    <div class="stat-lbl">Developers</div>
                    <div class="stat-line"></div>
                </div>
                <div class="stat st-amber">
                    <div class="stat-top">
                        <div class="stat-icon">📈</div>
                        <span class="stat-tag"><?php echo $sold_count; ?> sold</span>
                    </div>
                    <div class="stat-val"><?php echo $conversion; ?>%</div>
                    <div class="stat-lbl">Conversion</div>
                    <div class="stat-line"></div>
                </div>
            </div>

            <!-- Chart + Niches -->
            <div class="grid-2-1">
                <div class="card">
                    <div class="card-head">
                        <div class="card-title"><span class="dot" style="background:var(--blue)"></span> Revenue & Sales
                        </div>
                        <?php if (!$has_chart_data): ?>
                            <span class="card-badge" style="background:#fffbeb;color:#92400e;">Sample Data</span>
                        <?php endif; ?>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head">
                        <div class="card-title"><span class="dot" style="background:var(--purple)"></span> Top Niches
                        </div>
                        <span class="card-badge"><?php echo count($top_niches); ?> total</span>
                    </div>
                    <div class="n-list">
                        <?php $mx = !empty($top_niches) ? max(array_column($top_niches, 'cnt')) : 1;
                        foreach ($top_niches as $i => $n):
                            $pct = round(($n['cnt'] / $mx) * 100); ?>
                            <div class="n-row">
                                <span class="n-rank"><?php echo $i + 1; ?></span>
                                <span class="n-name"><?php echo htmlspecialchars($n['niche']); ?></span>
                                <div class="n-bar-wrap">
                                    <div class="n-bar-fill" style="width:<?php echo $pct; ?>%"></div>
                                </div>
                                <span class="n-cnt"><?php echo $n['cnt']; ?></span>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($top_niches)): ?>
                            <div class="empty">
                                <div class="empty-ic">📁</div>No niches yet
                            </div><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Users + Transactions -->
            <div class="grid-half" id="users-section">
                <div class="card" id="txn-section">
                    <div class="card-head">
                        <div class="card-title"><span class="dot" style="background:var(--indigo)"></span> Recent Users
                        </div>
                        <span class="card-badge"><?php echo $total_users; ?> total</span>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="mt">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Wallet</th>
                                    <th>Purchases</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $cl = ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444', '#06b6d4', '#ec4899'];
                                foreach ($recent_users as $i => $u):
                                    $c = $cl[$i % 7];
                                    $in = strtoupper(substr($u['username'], 0, 2)); ?>
                                    <tr>
                                        <td>
                                            <div class="u-cell">
                                                <div class="u-av" style="background:<?php echo $c; ?>"><?php echo $in; ?>
                                                </div>
                                                <div>
                                                    <div class="u-name"><?php echo htmlspecialchars($u['username']); ?></div>
                                                    <div class="u-sub">ID #<?php echo $u['id']; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="u-wallet">₹<?php echo number_format($u['wallet_balance']); ?></span>
                                        </td>
                                        <td><span class="u-ptag"><?php echo $u['total_purchases']; ?> leads</span></td>
                                        <td style="color:var(--text3);font-size:0.78rem;">
                                            <?php echo date('d M Y', strtotime($u['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($recent_users)): ?>
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty">
                                                <div class="empty-ic">👤</div>No users yet
                                            </div>
                                        </td>
                                    </tr><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head">
                        <div class="card-title"><span class="dot" style="background:var(--green)"></span> Recent
                            Transactions</div>
                    </div>
                    <?php foreach ($recent_txns as $t):
                        $cr = $t['type'] === 'credit'; ?>
                        <div class="tx <?php echo $cr ? 'tx-cr' : 'tx-db'; ?>">
                            <div class="tx-ic"><?php echo $cr ? '↓' : '↑'; ?></div>
                            <div class="tx-info">
                                <div class="tx-desc"><?php echo htmlspecialchars($t['description']); ?></div>
                                <div class="tx-meta">@<?php echo htmlspecialchars($t['username']); ?> ·
                                    <?php echo date('d M, H:i', strtotime($t['created_at'])); ?></div>
                            </div>
                            <div class="tx-amt"><?php echo $cr ? '+' : '-'; ?>₹<?php echo number_format($t['amount']); ?></div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($recent_txns)): ?>
                        <div class="empty">
                            <div class="empty-ic">💳</div>No transactions yet
                        </div><?php endif; ?>
                </div>
            </div>

            <!-- Add Lead -->
            <div class="card" style="margin-bottom:24px;" id="add-lead">
                <div class="card-head">
                    <div class="card-title"><span class="dot" style="background:var(--green)"></span> Add New Lead</div>
                </div>
                <form method="POST">
                    <input type="hidden" name="add_lead" value="1">
                    <div class="fg2">
                        <div class="fgrp"><label class="flbl">Niche Category</label><input type="text" name="niche"
                                class="fctrl" required placeholder="e.g. E-commerce Website"></div>
                        <div class="fgrp"><label class="flbl">Client Budget</label>
                            <select name="budget" class="fctrl">
                                <option value="15000">Basic (₹15k–₹30k) — ₹999</option>
                                <option value="30000">Business (₹30k–₹50k) — ₹2,499</option>
                                <option value="50000">Premium (₹50k–₹1L+) — ₹4,999</option>
                            </select>
                        </div>
                    </div>
                    <div class="fgrp"><label class="flbl">Project Description</label><textarea name="description"
                            class="fctrl" required rows="3" placeholder="Enter requirements..."></textarea></div>
                    <div class="fg2">
                        <div class="fgrp"><label class="flbl">Client Name</label><input type="text" name="client_name"
                                class="fctrl" required placeholder="Full name"></div>
                        <div class="fgrp"><label class="flbl">Client Phone</label><input type="text" name="client_phone"
                                class="fctrl" required placeholder="+91 98765 43210"></div>
                    </div>
                    <button type="submit" class="btn-pub">🚀 Publish Lead</button>
                </form>
            </div>

            <!-- Leads Table -->
            <div class="card" id="leads-section">
                <div class="card-head">
                    <div class="card-title"><span class="dot" style="background:var(--blue)"></span> All Leads</div>
                    <span class="card-badge"><?php echo count($leads); ?> total</span>
                </div>
                <div class="fbar">
                    <input type="text" id="lSearch" class="finput" placeholder="🔍 Search..." oninput="filterL()">
                    <select id="lStatus" class="finput" style="min-width:120px;" onchange="filterL()">
                        <option value="all">All Status</option>
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                    </select>
                    <select id="lBudget" class="finput" style="min-width:140px;" onchange="filterL()">
                        <option value="all">All Budgets</option>
                        <option value="15000">Basic</option>
                        <option value="30000">Business</option>
                        <option value="50000">Premium</option>
                    </select>
                    <span class="fcount" id="fCnt"><?php echo count($leads); ?> results</span>
                </div>
                <div style="overflow-x:auto;">
                    <table class="lt" id="lTbl">
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
                                <tr data-n="<?php echo strtolower($l['niche']); ?>"
                                    data-c="<?php echo strtolower($l['client_name']); ?>" data-s="<?php echo $l['status']; ?>"
                                    data-b="<?php echo $l['budget']; ?>">
                                    <td><span class="l-id">#<?php echo $l['id']; ?></span></td>
                                    <td style="max-width:240px;">
                                        <div class="l-niche"><?php echo htmlspecialchars($l['niche']); ?></div>
                                        <div class="l-desc">
                                            <?php echo htmlspecialchars(substr($l['description'], 0, 50)) . '...'; ?></div>
                                    </td>
                                    <td><span class="l-budget">₹<?php echo number_format($l['budget']); ?>+</span></td>
                                    <td><span class="l-price">₹<?php echo number_format($l['lead_price']); ?></span></td>
                                    <td>
                                        <div class="l-cname"><?php echo htmlspecialchars($l['client_name']); ?></div>
                                        <div class="l-cphone"><?php echo htmlspecialchars($l['client_phone']); ?></div>
                                    </td>
                                    <td><?php if ($l['status'] == 'available'): ?><span class="l-status l-av"><i></i>
                                                Available</span><?php else: ?><span class="l-status l-sd"><i></i>
                                                Sold</span><?php endif; ?></td>
                                    <td style="color:var(--text3);font-size:0.78rem;white-space:nowrap;">
                                        <?php echo date('d M Y', strtotime($l['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($leads)): ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="empty">
                                            <div class="empty-ic">📭</div>
                                            <div>No leads yet</div>
                                            <div style="margin-top:6px;"><a href="seed.php">Add Demo Data</a></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js from cdnjs (more reliable) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
// Chart
document.addEventListener('DOMContentLoaded', function() {
    var el = document.getElementById('mainChart');
    if (!el) return;
    try {
        new Chart(el, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [
                    {
                        label: 'Revenue (₹)',
                        data: <?php echo json_encode($chart_revenue); ?>,
                        backgroundColor: 'rgba(59,130,246,0.15)',
                        borderColor: '#3b82f6',
                        borderWidth: 2, borderRadius: 6, borderSkipped: false, yAxisID: 'y'
                    },
                    {
                        label: 'Leads Sold',
                        data: <?php echo json_encode($chart_sold); ?>,
                        type: 'line',
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139,92,246,0.05)',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#8b5cf6', pointBorderColor: '#fff',
                        pointBorderWidth: 2, pointRadius: 5,
                        tension: 0.4, fill: true, yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { labels: { color:'#64748b', font:{size:11,weight:500}, usePointStyle:true, padding:16 } },
                    tooltip: {
                        backgroundColor:'#fff', titleColor:'#0f172a', bodyColor:'#475569',
                        borderColor:'#e2e8f0', borderWidth:1, padding:12, cornerRadius:10,
                        callbacks: {
                            label: function(c){ return c.datasetIndex===0 ? ' ₹'+c.parsed.y.toLocaleString() : ' '+c.parsed.y+' leads'; }
                        }
                    }
                },
                scales: {
                    x: { grid:{display:false}, ticks:{color:'#94a3b8',font:{size:11}} },
                    y: { position:'left', grid:{color:'#f1f5f9'}, ticks:{color:'#94a3b8',font:{size:11}, callbac k:v=>'₹'+v.toLocaleString()} },
                    y1:{ position:'right', grid:{display:false}, ticks:{color:'#a78bfa',font:{size:11}} }
                }
            }
        });
    } catch(e) { console.error('Chart error:', e); }
});

// Filter
function filterL(){
    var s=document.getElementById('lSearch').value.toLowerCase(),
        st=document.getElementById('lStatus').value,
        b=document.getElementById('lBudget').value, v=0;
    document.querySelectorAll('#lTbl tbody tr').forEach(function(r){
        var ok=(!s||(r.dataset.n||'').includes(s)||(r.dataset.c||'').includes(s))&&(st==='all'||r.dataset.s===st)&&(b==='all'||r.dataset.b===b);
        r.style.display=ok?'':'none'; if(ok)v++;
    });
    document.getElementById('fCnt').textContent=v+' result'+(v!==1?'s':'');
}
    </script>
</body>

</html>