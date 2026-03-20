<?php
require_once 'functions.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_login('admin');

$message = "";
$msg_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toggle_lead_id'])) {
    $lead_id = (int) $_POST['toggle_lead_id'];
    $new_status = ($_POST['current_status'] === 'available') ? 'sold' : 'available';
    $stmt = $pdo->prepare("UPDATE leads SET status = ? WHERE id = ?");
    if ($stmt->execute([$new_status, $lead_id])) {
        $message = "Lead #$lead_id status changed to $new_status.";
        $msg_type = "success";
    } else {
        $message = "Failed to update status.";
        $msg_type = "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_lead_id'])) {
    $lead_id = (int) $_POST['delete_lead_id'];
    try {
        $pdo->prepare("DELETE FROM cart WHERE lead_id = ?")->execute([$lead_id]);
        $pdo->prepare("DELETE FROM purchased_leads WHERE lead_id = ?")->execute([$lead_id]);
        $pdo->prepare("DELETE FROM leads WHERE id = ?")->execute([$lead_id]);
        $message = "Lead #$lead_id deleted successfully.";
        $msg_type = "success";
    } catch (PDOException $e) {
        $message = "Failed to delete lead: " . $e->getMessage();
        $msg_type = "error";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_lead'])) {
    $niche = trim($_POST['niche']);
    $budget = (float) $_POST['budget'];
    $desc = trim($_POST['description']);
    $name = trim($_POST['client_name']);
    $phone = trim($_POST['client_phone']);
    $lead_price = ($budget == 5000) ? 2 : (($budget == 50000) ? 4999 : (($budget == 30000) ? 2499 : 999));
    try {
        $pdo->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?,?,?,?,?,?,'available')")
            ->execute([$niche, $budget, $lead_price, $desc, $name, $phone]);
        $message = "Lead published successfully!";
        $msg_type = "success";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $msg_type = "error";
    }
}

$total_leads = $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$available = $pdo->query("SELECT COUNT(*) FROM leads WHERE status='available'")->fetchColumn();
$sold = $pdo->query("SELECT COUNT(*) FROM leads WHERE status='sold'")->fetchColumn();
$revenue = $pdo->query("SELECT COALESCE(SUM(purchase_price),0) FROM purchased_leads")->fetchColumn();
$devs = $pdo->query("SELECT COUNT(*) FROM users WHERE role='developer'")->fetchColumn();
$conv = $total_leads > 0 ? round(($sold / $total_leads) * 100, 1) : 0;

$clbl = [];
$crev = [];
$csold = [];
for ($i = 5; $i >= 0; $i--) {
    $ms = date('Y-m-01', strtotime("-$i months"));
    $me = date('Y-m-t', strtotime("-$i months"));
    $clbl[] = date('M', strtotime("-$i months"));
    $s = $pdo->prepare("SELECT COALESCE(SUM(purchase_price),0) FROM purchased_leads WHERE purchased_at BETWEEN ? AND ?");
    $s->execute([$ms, "$me 23:59:59"]);
    $crev[] = (float) $s->fetchColumn();
    $s = $pdo->prepare("SELECT COUNT(*) FROM purchased_leads WHERE purchased_at BETWEEN ? AND ?");
    $s->execute([$ms, "$me 23:59:59"]);
    $csold[] = (int) $s->fetchColumn();
}
$has_data = array_sum($crev) > 0 || array_sum($csold) > 0;
if (!$has_data) {
    $crev = [2500, 4999, 1999, 7498, 4999, 9998];
    $csold = [1, 2, 1, 3, 2, 4];
}

$users = $pdo->query("SELECT u.id, u.username, u.wallet_balance, u.created_at,
    (SELECT COUNT(*) FROM purchased_leads WHERE user_id = u.id) as purchases
    FROM users u WHERE u.role='developer' ORDER BY u.created_at DESC LIMIT 8")->fetchAll();

$niches = $pdo->query("SELECT niche, COUNT(*) as cnt FROM leads GROUP BY niche ORDER BY cnt DESC LIMIT 5")->fetchAll();

$txns = $pdo->query("SELECT t.*, u.username FROM transactions t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC LIMIT 6")->fetchAll();

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
            --bg: #f0f2f5;
            --card: #fff;
            --b: #e5e7eb;
            --b2: #f3f4f6;
            --t1: #111827;
            --t2: #374151;
            --t3: #6b7280;
            --t4: #9ca3af;
            --blue: #2563eb;
            --blue-l: #eff6ff;
            --blue-b: #bfdbfe;
            --green: #059669;
            --green-l: #ecfdf5;
            --green-b: #a7f3d0;
            --purple: #7c3aed;
            --purple-l: #f5f3ff;
            --purple-b: #ddd6fe;
            --amber: #d97706;
            --amber-l: #fffbeb;
            --amber-b: #fde68a;
            --red: #dc2626;
            --red-l: #fef2f2;
            --r: 16px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--t1);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        /* ═══════ NAV ═══════ */
        .nav {
            background: var(--card);
            border-bottom: 1px solid var(--b);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 28px;
            display: flex;
            align-items: center;
            height: 64px;
            gap: 24px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.12rem;
            color: var(--t1);
            text-decoration: none;
        }

        .nav-brand-ic {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .95rem;
        }

        .nav-tabs {
            display: flex;
            gap: 4px;
            margin-left: 32px;
        }

        .nav-tab {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: .84rem;
            font-weight: 500;
            color: var(--t3);
            text-decoration: none;
            transition: all .2s;
        }

        .nav-tab:hover {
            background: var(--b2);
            color: var(--t1);
        }

        .nav-tab.act {
            background: var(--blue-l);
            color: var(--blue);
            font-weight: 600;
        }

        .nav-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-live {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .75rem;
            font-weight: 600;
            color: var(--green);
            background: var(--green-l);
            border: 1px solid var(--green-b);
            padding: 5px 12px;
            border-radius: 100px;
        }

        .nav-live::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
            animation: bk 2s infinite;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px 5px 5px;
            border-radius: 100px;
            background: var(--b2);
            font-size: .84rem;
            font-weight: 600;
            color: var(--t2);
        }

        .nav-av {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .65rem;
            font-weight: 700;
        }

        @keyframes bk {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .3;
            }
        }

        /* ═══════ CONTAINER ═══════ */
        .wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 28px 28px 60px;
        }

        /* ═══════ PAGE HEAD ═══════ */
        .ph {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 24px;
        }

        .ph h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .ph p {
            color: var(--t4);
            font-size: .85rem;
            margin-top: 2px;
        }

        .ph-date {
            font-size: .82rem;
            color: var(--t4);
            font-weight: 500;
        }

        /* ═══════ ALERT ═══════ */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: .88rem;
        }

        .alert-s {
            background: var(--green-l);
            border: 1px solid var(--green-b);
            color: var(--green);
        }

        .alert-e {
            background: var(--red-l);
            border: 1px solid #fecaca;
            color: var(--red);
        }

        .alert b {
            font-weight: 700;
        }

        /* ═══════ STAT CARDS ═══════ */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .st {
            background: var(--card);
            border-radius: var(--r);
            padding: 20px 22px;
            border: 1px solid var(--b);
            position: relative;
            overflow: hidden;
            transition: all .3s;
            cursor: default;
        }

        .st:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px -8px rgba(0, 0, 0, .08);
        }

        .st-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .st-ic {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .st-badge {
            font-size: .66rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 100px;
            letter-spacing: .3px;
        }

        .st-num {
            font-size: 1.8rem;
            font-weight: 900;
            letter-spacing: -.5px;
            line-height: 1;
        }

        .st-lbl {
            font-size: .72rem;
            color: var(--t4);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-top: 6px;
        }

        .st-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .st-blue .st-ic {
            background: var(--blue-l);
            color: var(--blue);
        }

        .st-blue .st-badge {
            background: var(--blue-l);
            color: var(--blue);
        }

        .st-blue .st-bar {
            background: linear-gradient(90deg, #2563eb, #60a5fa);
        }

        .st-green .st-ic {
            background: var(--green-l);
            color: var(--green);
        }

        .st-green .st-badge {
            background: var(--green-l);
            color: var(--green);
        }

        .st-green .st-bar {
            background: linear-gradient(90deg, #059669, #34d399);
        }

        .st-purple .st-ic {
            background: var(--purple-l);
            color: var(--purple);
        }

        .st-purple .st-badge {
            background: var(--purple-l);
            color: var(--purple);
        }

        .st-purple .st-bar {
            background: linear-gradient(90deg, #7c3aed, #a78bfa);
        }

        .st-amber .st-ic {
            background: var(--amber-l);
            color: var(--amber);
        }

        .st-amber .st-badge {
            background: var(--amber-l);
            color: var(--amber);
        }

        .st-amber .st-bar {
            background: linear-gradient(90deg, #d97706, #fbbf24);
        }

        /* ═══════ CARD ═══════ */
        .g21 {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 18px;
            margin-bottom: 20px;
        }

        .g11 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 20px;
        }

        .cd {
            background: var(--card);
            border-radius: var(--r);
            padding: 22px;
            border: 1px solid var(--b);
        }

        .cd-h {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .cd-t {
            font-size: .92rem;
            font-weight: 700;
            color: var(--t1);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cd-t i {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .cd-b {
            background: var(--b2);
            color: var(--t3);
            padding: 3px 10px;
            border-radius: 100px;
            font-size: .72rem;
            font-weight: 600;
        }

        /* ═══════ CHART ═══════ */
        .ch-wrap {
            position: relative;
            height: 250px;
        }

        .ch-note {
            position: absolute;
            top: 8px;
            right: 8px;
            background: var(--amber-l);
            color: #92400e;
            font-size: .68rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
            border: 1px solid var(--amber-b);
            z-index: 5;
        }

        /* ═══════ NICHES ═══════ */
        .ni {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .ni-r {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: var(--b2);
            border-radius: 10px;
            transition: background .2s;
        }

        .ni-r:hover {
            background: #e8ecf4;
        }

        .ni-rk {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            background: var(--blue-l);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .62rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .ni-nm {
            flex: 1;
            font-weight: 600;
            font-size: .84rem;
            color: var(--t1);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ni-bw {
            width: 70px;
            height: 5px;
            background: var(--b);
            border-radius: 5px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .ni-bf {
            height: 100%;
            border-radius: 5px;
            background: linear-gradient(90deg, #2563eb, #7c3aed);
        }

        .ni-c {
            font-size: .68rem;
            font-weight: 700;
            color: var(--blue);
            background: var(--blue-l);
            padding: 2px 7px;
            border-radius: 100px;
            flex-shrink: 0;
        }

        /* ═══════ USERS TABLE ═══════ */
        .tbl-w {
            overflow-x: auto;
        }

        .tb {
            width: 100%;
            border-collapse: collapse;
        }

        .tb th {
            text-align: left;
            padding: 10px 14px;
            background: var(--b2);
            color: var(--t4);
            font-size: .68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            border-bottom: 1px solid var(--b);
        }

        .tb td {
            padding: 10px 14px;
            border-bottom: 1px solid var(--b2);
            font-size: .84rem;
            color: var(--t2);
            vertical-align: middle;
        }

        .tb tr:last-child td {
            border-bottom: none;
        }

        .tb tr:hover td {
            background: #fafbfc;
        }

        .uc {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ua {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .62rem;
            color: #fff;
            flex-shrink: 0;
        }

        .un {
            font-weight: 600;
            color: var(--t1);
            font-size: .84rem;
        }

        .us {
            font-size: .7rem;
            color: var(--t4);
        }

        .uw {
            font-weight: 700;
            color: var(--green);
        }

        .up {
            background: var(--purple-l);
            color: var(--purple);
            padding: 2px 8px;
            border-radius: 100px;
            font-size: .68rem;
            font-weight: 700;
        }

        /* ═══════ TRANSACTIONS ═══════ */
        .tx {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--b2);
        }

        .tx:last-child {
            border: none;
        }

        .tx-i {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .82rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .tx-cr .tx-i {
            background: var(--green-l);
            color: var(--green);
        }

        .tx-db .tx-i {
            background: var(--red-l);
            color: var(--red);
        }

        .tx-d {
            font-weight: 600;
            font-size: .84rem;
            color: var(--t1);
        }

        .tx-m {
            font-size: .7rem;
            color: var(--t4);
            margin-top: 1px;
        }

        .tx-a {
            font-weight: 700;
            font-size: .88rem;
            margin-left: auto;
            white-space: nowrap;
        }

        .tx-cr .tx-a {
            color: var(--green);
        }

        .tx-db .tx-a {
            color: var(--red);
        }

        /* ═══════ FILTER ═══════ */
        .fb {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 14px;
            align-items: center;
        }

        .fi {
            padding: 8px 14px;
            background: var(--b2);
            border: 1px solid var(--b);
            border-radius: 10px;
            color: var(--t1);
            font-size: .82rem;
            font-family: inherit;
            transition: all .2s;
        }

        .fi:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
            background: var(--card);
        }

        .fi::placeholder {
            color: var(--t4);
        }

        .fc {
            margin-left: auto;
            font-size: .78rem;
            color: var(--t4);
            font-weight: 500;
        }

        /* ═══════ LEADS TABLE ═══════ */
        .lt {
            width: 100%;
            border-collapse: collapse;
            min-width: 780px;
        }

        .lt th {
            text-align: left;
            padding: 10px 14px;
            background: var(--b2);
            color: var(--t4);
            font-size: .68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            border-bottom: 1px solid var(--b);
        }

        .lt td {
            padding: 10px 14px;
            border-bottom: 1px solid var(--b2);
            font-size: .84rem;
            color: var(--t2);
            vertical-align: middle;
        }

        .lt tr:hover td {
            background: #fafbfc;
        }

        .li {
            font-weight: 700;
            color: var(--t4);
            font-size: .78rem;
        }

        .ln {
            font-weight: 700;
            color: var(--t1);
        }

        .ld {
            font-size: .72rem;
            color: var(--t4);
            margin-top: 2px;
        }

        .lb {
            font-weight: 600;
            color: var(--t2);
        }

        .lp {
            font-weight: 700;
            color: var(--green);
            background: var(--green-l);
            padding: 3px 10px;
            border-radius: 6px;
            display: inline-block;
            font-size: .8rem;
        }

        .lc {
            font-weight: 600;
            color: var(--t1);
        }

        .lcph {
            font-size: .72rem;
            color: var(--t4);
        }

        .ls {
            padding: 3px 10px;
            border-radius: 100px;
            font-size: .68rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .ls b {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        .ls-a {
            background: var(--green-l);
            color: var(--green);
        }

        .ls-s {
            background: var(--amber-l);
            color: var(--amber);
        }

        /* ═══════ FORM ═══════ */
        .fg {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .fgrp {
            margin-bottom: 14px;
        }

        .fl {
            display: block;
            margin-bottom: 5px;
            color: var(--t3);
            font-weight: 500;
            font-size: .82rem;
        }

        .fc2 {
            width: 100%;
            padding: 10px 14px;
            background: var(--b2);
            border: 1px solid var(--b);
            border-radius: 10px;
            color: var(--t1);
            font-family: inherit;
            font-size: .88rem;
            transition: all .2s;
        }

        .fc2:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
            background: var(--card);
        }

        .fc2::placeholder {
            color: var(--t4);
        }

        .btn-p {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: .92rem;
            cursor: pointer;
            transition: all .25s;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(5, 150, 105, .15);
        }

        .btn-p:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(5, 150, 105, .22);
        }

        /* ═══════ EMPTY ═══════ */
        .emp {
            text-align: center;
            padding: 32px 16px;
            color: var(--t4);
        }

        .emp-ic {
            font-size: 2rem;
            margin-bottom: 4px;
        }

        .emp a {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
        }

        /* ═══════ RESPONSIVE ═══════ */
        @media(max-width:900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .g21,
            .g11 {
                grid-template-columns: 1fr;
            }

            .wrap {
                padding: 20px 16px 40px;
            }

            .nav-tabs {
                display: none;
            }
        }

        @media(max-width:600px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .fg {
                grid-template-columns: 1fr;
            }

            .ph {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>

<body>

    <nav class="nav">
        <div class="nav-inner">
            <a href="index" class="nav-brand"><span class="nav-brand-ic">💼</span>QuickProject</a>
            <div class="nav-tabs">
                <a href="#" class="nav-tab act">Overview</a>
                <a href="#leads-sec" class="nav-tab">Leads</a>
                <a href="#add-sec" class="nav-tab">Add Lead</a>
                <a href="change_password" class="nav-tab">🔐 Password</a>
                <a href="index" class="nav-tab">View Site</a>
                <a href="logout" class="nav-tab" style="color:#dc2626;">Logout</a>
            </div>
            <div class="nav-right">
                <span class="nav-live">Live</span>
                <div class="nav-user"><span
                        class="nav-av">AD</span><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></div>
            </div>
        </div>
    </nav>

    <div class="wrap">

        <div class="ph">
            <div>
                <h1>Dashboard</h1>
                <p>Marketplace overview & management</p>
            </div>
            <span class="ph-date"><?php echo date('l, d M Y'); ?></span>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert <?php echo $msg_type == 'success' ? 'alert-s' : 'alert-e'; ?>">
                <?php echo $msg_type == 'success' ? '✅' : '⚠️'; ?>
                <b><?php echo $msg_type == 'success' ? 'Success!' : 'Error:'; ?></b>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="stats">
            <div class="st st-blue">
                <div class="st-top">
                    <div class="st-ic">📊</div><span class="st-badge"><?php echo $available; ?> active</span>
                </div>
                <div class="st-num"><?php echo number_format($total_leads); ?></div>
                <div class="st-lbl">Total Leads</div>
                <div class="st-bar"></div>
            </div>
            <div class="st st-green">
                <div class="st-top">
                    <div class="st-ic">💰</div><span class="st-badge">Lifetime</span>
                </div>
                <div class="st-num">₹<?php echo number_format($revenue); ?></div>
                <div class="st-lbl">Revenue</div>
                <div class="st-bar"></div>
            </div>
            <div class="st st-purple">
                <div class="st-top">
                    <div class="st-ic">👥</div><span class="st-badge">Active</span>
                </div>
                <div class="st-num"><?php echo number_format($devs); ?></div>
                <div class="st-lbl">Developers</div>
                <div class="st-bar"></div>
            </div>
            <div class="st st-amber">
                <div class="st-top">
                    <div class="st-ic">📈</div><span class="st-badge"><?php echo $sold; ?> sold</span>
                </div>
                <div class="st-num"><?php echo $conv; ?>%</div>
                <div class="st-lbl">Conversion</div>
                <div class="st-bar"></div>
            </div>
        </div>

        <!-- Chart + Niches -->
        <div class="g21">
            <div class="cd">
                <div class="cd-h">
                    <div class="cd-t"><i style="background:var(--blue)"></i>Revenue & Sales</div>
                    <?php if (!$has_data): ?><span class="cd-b"
                            style="background:var(--amber-l);color:#92400e;">Sample</span><?php endif; ?>
                </div>
                <div class="ch-wrap"><canvas id="mainChart"></canvas></div>
            </div>
            <div class="cd">
                <div class="cd-h">
                    <div class="cd-t"><i style="background:var(--purple)"></i>Top Niches</div><span
                        class="cd-b"><?php echo count($niches); ?></span>
                </div>
                <div class="ni">
                    <?php $mx = !empty($niches) ? max(array_column($niches, 'cnt')) : 1;
                    foreach ($niches as $x => $n):
                        $p = round(($n['cnt'] / $mx) * 100); ?>
                        <div class="ni-r"><span class="ni-rk"><?php echo $x + 1; ?></span><span
                                class="ni-nm"><?php echo htmlspecialchars($n['niche']); ?></span>
                            <div class="ni-bw">
                                <div class="ni-bf" style="width:<?php echo $p; ?>%"></div>
                            </div><span class="ni-c"><?php echo $n['cnt']; ?></span>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($niches)): ?>
                        <div class="emp">
                            <div class="emp-ic">📁</div>No niches yet
                        </div><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Users + Txns -->
        <div class="g11">
            <div class="cd">
                <div class="cd-h">
                    <div class="cd-t"><i style="background:var(--purple)"></i>Recent Users</div><span
                        class="cd-b"><?php echo $devs; ?> devs</span>
                </div>
                <div class="tbl-w">
                    <table class="tb">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Wallet</th>
                                <th>Purchases</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $cl = ['#2563eb', '#059669', '#7c3aed', '#d97706', '#dc2626', '#0891b2', '#db2777'];
                            foreach ($users as $i => $u):
                                $c = $cl[$i % 7];
                                $in = strtoupper(substr($u['username'], 0, 2)); ?>
                                <tr>
                                    <td>
                                        <div class="uc">
                                            <div class="ua" style="background:<?php echo $c; ?>"><?php echo $in; ?></div>
                                            <div>
                                                <div class="un"><?php echo htmlspecialchars($u['username']); ?></div>
                                                <div class="us">ID #<?php echo $u['id']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="uw">₹<?php echo number_format($u['wallet_balance']); ?></span></td>
                                    <td><span class="up"><?php echo $u['purchases']; ?></span></td>
                                    <td style="color:var(--t4);font-size:.76rem;">
                                        <?php echo date('d M Y', strtotime($u['created_at'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="emp">
                                            <div class="emp-ic">👤</div>No users yet
                                        </div>
                                    </td>
                                </tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="cd">
                <div class="cd-h">
                    <div class="cd-t"><i style="background:var(--green)"></i>Transactions</div>
                </div>
                <?php foreach ($txns as $t):
                    $cr = $t['type'] === 'credit'; ?>
                    <div class="tx <?php echo $cr ? 'tx-cr' : 'tx-db'; ?>">
                        <div class="tx-i"><?php echo $cr ? '↓' : '↑'; ?></div>
                        <div style="flex:1">
                            <div class="tx-d"><?php echo htmlspecialchars($t['description']); ?></div>
                            <div class="tx-m">@<?php echo htmlspecialchars($t['username']); ?> ·
                                <?php echo date('d M, H:i', strtotime($t['created_at'])); ?>
                            </div>
                        </div>
                        <div class="tx-a"><?php echo $cr ? '+' : '-'; ?>₹<?php echo number_format($t['amount']); ?></div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($txns)): ?>
                    <div class="emp">
                        <div class="emp-ic">💳</div>No transactions yet
                    </div><?php endif; ?>
            </div>
        </div>

        <!-- Add Lead -->
        <div class="cd" style="margin-bottom:20px;" id="add-sec">
            <div class="cd-h">
                <div class="cd-t"><i style="background:var(--green)"></i>Add New Lead</div>
            </div>
            <form method="POST"><input type="hidden" name="add_lead" value="1">
                <div class="fg">
                    <div class="fgrp"><label class="fl">Niche</label><input type="text" name="niche" class="fc2"
                            required placeholder="e.g. E-commerce Website"></div>
                    <div class="fgrp"><label class="fl">Budget</label><select name="budget" class="fc2">
                            <option value="5000">₹5k (Test) → ₹2</option>
                            <option value="15000">₹15k–₹30k → ₹999</option>
                            <option value="30000">₹30k–₹50k → ₹2,499</option>
                            <option value="50000">₹50k+ → ₹4,999</option>
                        </select></div>
                </div>
                <div class="fgrp"><label class="fl">Description</label><textarea name="description" class="fc2" required
                        rows="3" placeholder="Project requirements..."></textarea></div>
                <div class="fg">
                    <div class="fgrp"><label class="fl">Client Name</label><input type="text" name="client_name"
                            class="fc2" required placeholder="Full name"></div>
                    <div class="fgrp"><label class="fl">Client Phone</label><input type="text" name="client_phone"
                            class="fc2" required placeholder="+91 98765 43210"></div>
                </div>
                <button type="submit" class="btn-p">🚀 Publish Lead</button>
            </form>
        </div>

        <!-- All Leads -->
        <div class="cd" id="leads-sec">
            <div class="cd-h">
                <div class="cd-t"><i style="background:var(--blue)"></i>All Leads</div><span
                    class="cd-b"><?php echo count($leads); ?> total</span>
            </div>
            <div class="fb">
                <input type="text" id="qs" class="fi" placeholder="🔍 Search..." oninput="fl()"
                    style="min-width:170px;">
                <select id="qst" class="fi" style="min-width:120px;" onchange="fl()">
                    <option value="all">All Status</option>
                    <option value="available">Available</option>
                    <option value="sold">Sold</option>
                </select>
                <select id="qb" class="fi" style="min-width:140px;" onchange="fl()">
                    <option value="all">All Budgets</option>
                    <option value="15000">Basic</option>
                    <option value="30000">Business</option>
                    <option value="50000">Premium</option>
                </select>
                <span class="fc" id="rcnt"><?php echo count($leads); ?> results</span>
            </div>
            <div class="tbl-w">
                <table class="lt" id="ltbl">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Niche</th>
                            <th>Budget</th>
                            <th>Price</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $l): ?>
                            <tr data-n="<?php echo strtolower($l['niche']); ?>"
                                data-c="<?php echo strtolower($l['client_name']); ?>" data-s="<?php echo $l['status']; ?>"
                                data-b="<?php echo $l['budget']; ?>">
                                <td><span class="li">#<?php echo $l['id']; ?></span></td>
                                <td style="max-width:220px;">
                                    <div class="ln"><?php echo htmlspecialchars($l['niche']); ?></div>
                                    <div class="ld"><?php echo htmlspecialchars(substr($l['description'], 0, 50)); ?>...
                                    </div>
                                </td>
                                <td><span class="lb">₹<?php echo number_format($l['budget']); ?>+</span></td>
                                <td><span class="lp">₹<?php echo number_format($l['lead_price']); ?></span></td>
                                <td>
                                    <div class="lc"><?php echo htmlspecialchars($l['client_name']); ?></div>
                                    <div class="lcph"><?php echo htmlspecialchars($l['client_phone']); ?></div>
                                </td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="toggle_lead_id" value="<?php echo $l['id']; ?>">
                                        <input type="hidden" name="current_status" value="<?php echo $l['status']; ?>">
                                        <button type="submit"
                                            style="border:none; background:none; padding:0; cursor:pointer;"
                                            title="Click to toggle">
                                            <?php if ($l['status'] == 'available'): ?>
                                                <span class="ls ls-a"><b></b>Available</span>
                                            <?php else: ?>
                                                <span class="ls ls-s"><b></b>Sold</span>
                                            <?php endif; ?>
                                        </button>
                                    </form>
                                </td>
                                <td style="color:var(--t4);font-size:.76rem;white-space:nowrap;">
                                    <?php echo date('d M Y', strtotime($l['created_at'])); ?>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;">
                                        <a href="edit_lead?id=<?php echo $l['id']; ?>"
                                            style="font-size:12px;text-decoration:none;color:#fff;background:#3b82f6;padding:5px 8px;border-radius:4px;font-weight:600;">Edit</a>
                                        <form method="POST"
                                            onsubmit="return confirm('Are you sure you want to completely delete this lead?');"
                                            style="margin:0;">
                                            <input type="hidden" name="delete_lead_id" value="<?php echo $l['id']; ?>">
                                            <button type="submit"
                                                style="font-size:12px;color:#fff;background:#ef4444;border:none;padding:5px 8px;border-radius:4px;font-weight:600;cursor:pointer;">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($leads)): ?>
                            <tr>
                                <td colspan="8">
                                    <div class="emp">
                                        <div class="emp-ic">📭</div>
                                        <div>No leads found</div>
                                        <div style="margin-top:6px;"><a href="seed">Add Demo Data</a></div>
                                    </div>
                                </td>
                            </tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('mainChart');
            if (!el || typeof Chart === 'undefined') return;
            new Chart(el, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($clbl); ?>,
                    datasets: [
                        { label: 'Revenue (₹)', data: <?php echo json_encode($crev); ?>, backgroundColor: 'rgba(37,99,235,.12)', borderColor: '#2563eb', borderWidth: 2, borderRadius: 8, borderSkipped: false, yAxisID: 'y' },
                        { label: 'Leads Sold', data: <?php echo json_encode($csold); ?>, type: 'line', borderColor: '#7c3aed', backgroundColor: 'rgba(124,58,237,.04)', borderWidth: 2.5, pointBackgroundColor: '#7c3aed', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5, tension: .4, fill: true, yAxisID: 'y1' }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { labels: { color: '#6b7280', font: { size: 11, weight: '500' }, usePointStyle: true, padding: 16 } },
                        tooltip: {
                            backgroundColor: '#fff', titleColor: '#111827', bodyColor: '#374151', borderColor: '#e5e7eb', borderWidth: 1, padding: 12, cornerRadius: 10,
                            callbacks: { label: function (c) { return c.datasetIndex === 0 ? ' ₹' + c.parsed.y.toLocaleString() : ' ' + c.parsed.y + ' leads'; } }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#9ca3af', font: { size: 11 } } },
                        y: { position: 'left', grid: { color: '#f3f4f6' }, ticks: { color: '#9ca3af', font: { size: 11 }, callback: function (v) { return '₹' + v.toLocaleString(); } } },
                        y1: { position: 'right', grid: { display: false }, ticks: { color: '#a78bfa', font: { size: 11 } } }
                    }
                }
            });
        });
        function fl() {
            var s = document.getElementById('qs').value.toLowerCase(), st = document.getElementById('qst').value, b = document.getElementById('qb').value, v = 0;
            document.querySelectorAll('#ltbl tbody tr').forEach(function (r) {
                if (!r.dataset.n) return; // skip "No leads found" row
                var rowB = parseInt(r.dataset.b, 10) || 0;
                var bOk = true;
                if (b !== 'all') {
                    if (b === '15000') bOk = (rowB >= 15000 && rowB < 30000);
                    else if (b === '30000') bOk = (rowB >= 30000 && rowB < 50000);
                    else if (b === '50000') bOk = (rowB >= 50000);
                    else bOk = (rowB === parseInt(b, 10)); // Testing or specific tiers
                }
                var ok = (!s || (r.dataset.n || '').includes(s) || (r.dataset.c || '').includes(s)) && (st === 'all' || r.dataset.s === st) && bOk;
                r.style.display = ok ? '' : 'none'; if (ok) v++;
            });
            document.getElementById('rcnt').textContent = v + ' result' + (v !== 1 ? 's' : '');
        }
    </script>
</body>

</html>