<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    add_to_cart($pdo, $_POST['lead_id']);
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
    <title>Black Hat SEO Course Delhi, India | Tech Support Call Generation Training – 25+ Yrs Expert</title>
    <meta name="description" content="India's most advanced Black Hat SEO & Inbound Call Generation course. Taught by 25+ year industry veteran Suresh Das. Rank #1 and generate unlimited tech support, airline & finance calls.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* =============================================
           HOMEPAGE PREMIUM STYLES
        ============================================= */

        /* Animated gradient orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            animation: orbFloat 8s ease-in-out infinite;
        }
        .orb-1 { width: 600px; height: 600px; background: rgba(255,69,0,0.18); top: -100px; left: 50%; transform: translateX(-50%); animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: rgba(100,10,200,0.15); top: 100px; left: 10%; animation-delay: -3s; }
        .orb-3 { width: 350px; height: 350px; background: rgba(0,180,255,0.08); top: 50px; right: 5%; animation-delay: -5s; }

        @keyframes orbFloat {
            0%, 100% { transform: translateY(0px) translateX(-50%); }
            50% { transform: translateY(-30px) translateX(-50%); }
        }

        /* HERO */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            padding: 120px 24px 80px;
            background: #070810;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,69,0,0.1);
            border: 1px solid rgba(255,69,0,0.35);
            padding: 7px 20px;
            border-radius: 100px;
            margin-bottom: 40px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            color: #ff6b35;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            animation: fadeSlideDown 0.6s ease both;
        }

        .hero-badge .dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #ff4500;
            box-shadow: 0 0 8px #ff4500;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.4;} }
        @keyframes fadeSlideDown { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeSlideUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }

        .hero-headline {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(48px, 7vw, 96px);
            font-weight: 900;
            line-height: 1.0;
            letter-spacing: -3px;
            margin-bottom: 28px;
            animation: fadeSlideUp 0.7s 0.15s ease both;
        }

        .hero-headline .line-orange {
            display: block;
            color: #ff5500;
            text-shadow: 0 0 80px rgba(255,85,0,0.6), 0 0 20px rgba(255,85,0,0.3);
        }

        .hero-headline .line-white {
            display: block;
            color: #ffffff;
            text-shadow: 0 0 40px rgba(255,255,255,0.15);
        }

        .hero-subtext {
            font-family: 'Inter', sans-serif;
            font-size: 18px;
            color: rgba(255,255,255,0.55);
            max-width: 680px;
            margin: 0 auto 44px;
            line-height: 1.7;
            animation: fadeSlideUp 0.7s 0.3s ease both;
        }

        .hero-subtext strong { color: rgba(255,255,255,0.85); font-weight: 600; }

        .hero-cta-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            animation: fadeSlideUp 0.7s 0.45s ease both;
        }

        .cta-primary {
            background: linear-gradient(135deg, #ff5500 0%, #cc2200 100%);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 700;
            padding: 15px 34px;
            border-radius: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            box-shadow: 0 0 40px rgba(255,85,0,0.4), 0 4px 16px rgba(0,0,0,0.4);
            transition: all 0.25s ease;
            letter-spacing: 0.2px;
        }
        .cta-primary:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 0 60px rgba(255,85,0,0.6), 0 8px 24px rgba(0,0,0,0.5); color: #fff; }

        .cta-secondary {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.8);
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 600;
            padding: 14px 30px;
            border-radius: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            border: 1px solid rgba(255,255,255,0.12);
            transition: all 0.25s ease;
        }
        .cta-secondary:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.25); color: #fff; transform: translateY(-2px); }

        /* STATS TICKER */
        .stats-bar {
            background: rgba(255,255,255,0.03);
            border-top: 1px solid rgba(255,255,255,0.06);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            padding: 28px 0;
            overflow: hidden;
        }
        .stats-bar-inner {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .stat-pill {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 40px;
            border-right: 1px solid rgba(255,255,255,0.08);
        }
        .stat-pill:last-child { border-right: none; }
        .stat-value-large {
            font-family: 'Outfit', sans-serif;
            font-size: 36px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -1px;
        }
        .stat-label-small { font-size: 12px; color: rgba(255,255,255,0.45); font-weight: 500; line-height: 1.4; max-width: 90px; }

        /* CRITICAL ALERT */
        .alert-section {
            padding: 60px 24px;
            background: #070810;
        }
        .alert-box {
            max-width: 900px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(30,8,5,0.9) 0%, rgba(20,5,10,0.95) 100%);
            border: 1px solid rgba(255,87,34,0.5);
            border-radius: 24px;
            padding: 44px 48px;
            box-shadow: 0 0 60px rgba(255,69,0,0.2), inset 0 1px 0 rgba(255,150,100,0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .alert-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,100,50,0.6), transparent);
        }
        .alert-title {
            font-family: 'Outfit', sans-serif;
            font-size: 32px;
            font-weight: 900;
            color: #ff5500;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .alert-text {
            font-size: 16px;
            color: rgba(255,255,255,0.75);
            line-height: 1.7;
            margin-bottom: 28px;
        }
        .alert-text .highlight { color: #ff7744; font-weight: 600; }
        .alert-tags { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }
        .alert-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .tag-red { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.35); color: #f87171; }
        .tag-orange { background: rgba(255,107,53,0.15); border: 1px solid rgba(255,107,53,0.35); color: #ff9966; }
        .tag-amber { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.35); color: #fbbf24; }

        /* INDUSTRIES GRID */
        .section-wrap { padding: 90px 24px; }
        .section-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            color: #ff6b35;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
            display: block;
        }
        .section-h2 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(28px, 4vw, 46px);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 16px;
        }
        .section-p {
            font-size: 16px;
            color: rgba(255,255,255,0.45);
            max-width: 560px;
            line-height: 1.65;
            margin-bottom: 52px;
        }

        .industry-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .ind-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 18px;
            padding: 24px 20px;
            text-decoration: none;
            color: #fff;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .ind-card:hover {
            background: rgba(255,85,0,0.08);
            border-color: rgba(255,85,0,0.35);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.4);
            color: #fff;
        }
        .ind-emoji { font-size: 28px; }
        .ind-name { font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700; }
        .ind-sub { font-size: 12px; color: rgba(255,255,255,0.4); line-height: 1.4; }
        .ind-arrow { font-size: 13px; color: #ff6b35; opacity: 0; transition: opacity 0.2s ease; margin-top: auto; }
        .ind-card:hover .ind-arrow { opacity: 1; }

        /* MODULES */
        .modules-section { padding: 90px 24px; background: rgba(255,255,255,0.015); }
        .module-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
        .mod-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            padding: 30px 28px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .mod-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-color, #ff5500), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .mod-card:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.14); transform: translateY(-3px); }
        .mod-card:hover::before { opacity: 1; }
        .mod-number {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            color: #ff6b35;
            margin-bottom: 14px;
            display: block;
            letter-spacing: 1px;
        }
        .mod-icon-wrap {
            width: 46px; height: 46px;
            border-radius: 12px;
            background: rgba(255,85,0,0.1);
            border: 1px solid rgba(255,85,0,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
        }
        .mod-title { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; margin-bottom: 10px; }
        .mod-desc { font-size: 13px; color: rgba(255,255,255,0.45); line-height: 1.65; }

        /* PRICING */
        .pricing-section { padding: 90px 24px; }
        .pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 1100px; margin: 0 auto; }

        .price-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 36px 32px;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .price-card.featured {
            background: rgba(255,69,0,0.06);
            border-color: rgba(255,69,0,0.4);
            box-shadow: 0 0 50px rgba(255,69,0,0.15);
        }
        .price-card.featured::before {
            content: 'MOST POPULAR';
            position: absolute;
            top: 20px; right: 20px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #ff6b35;
            background: rgba(255,69,0,0.15);
            border: 1px solid rgba(255,69,0,0.3);
            padding: 4px 10px;
            border-radius: 100px;
        }
        .price-card:hover { transform: translateY(-5px); }

        .price-tier { font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.35); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 20px; }
        .price-amount { font-family: 'Outfit', sans-serif; font-size: 48px; font-weight: 900; letter-spacing: -2px; margin-bottom: 4px; line-height: 1; }
        .price-amount.orange { color: #ff5500; }
        .price-amount.teal { color: #00f2fe; }
        .price-amount.white { color: #ffffff; }
        .price-desc { font-size: 14px; color: rgba(255,255,255,0.45); margin-bottom: 28px; line-height: 1.5; }
        .price-divider { height: 1px; background: rgba(255,255,255,0.07); margin-bottom: 24px; }

        .price-features { list-style: none; display: flex; flex-direction: column; gap: 11px; margin-bottom: 32px; flex: 1; }
        .price-features li { font-size: 13px; color: rgba(255,255,255,0.7); display: flex; align-items: flex-start; gap: 10px; }
        .price-features li .check { color: #ff6b35; font-size: 14px; flex-shrink: 0; margin-top: 1px; }

        .price-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 14px;
            border-radius: 14px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s ease;
            margin-top: auto;
        }
        .price-btn-orange { background: linear-gradient(135deg, #ff5500, #cc2200); color: #fff; box-shadow: 0 4px 20px rgba(255,85,0,0.3); }
        .price-btn-orange:hover { box-shadow: 0 6px 30px rgba(255,85,0,0.5); transform: translateY(-1px); color: #fff; }
        .price-btn-outline { background: transparent; border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.7); }
        .price-btn-outline:hover { border-color: rgba(255,255,255,0.35); color: #fff; background: rgba(255,255,255,0.05); }
        .price-btn-teal { background: linear-gradient(135deg, #00f2fe, #0099cc); color: #000; box-shadow: 0 4px 20px rgba(0,242,254,0.25); }
        .price-btn-teal:hover { box-shadow: 0 6px 30px rgba(0,242,254,0.4); transform: translateY(-1px); color: #000; }

        /* INSTRUCTOR */
        .instructor-section { padding: 90px 24px; background: rgba(255,255,255,0.015); }
        .instructor-wrap {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        .instructor-avatar {
            background: linear-gradient(135deg, #0f0a1e 0%, #0a1520 100%);
            border: 1px solid rgba(255,85,0,0.3);
            border-radius: 28px;
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 80px rgba(255,69,0,0.12);
        }
        .instructor-avatar::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at center, rgba(255,69,0,0.08) 0%, transparent 60%);
        }
        .instructor-initial {
            font-family: 'Outfit', sans-serif;
            font-size: 100px;
            font-weight: 900;
            color: rgba(255,85,0,0.3);
            line-height: 1;
            position: relative;
        }
        .instructor-name-large {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #ff6b35;
            position: relative;
        }
        .instructor-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,0.35);
            letter-spacing: 2px;
            text-transform: uppercase;
            position: relative;
        }

        .instructor-text { display: flex; flex-direction: column; gap: 0; }
        .instructor-bio { font-size: 15px; color: rgba(255,255,255,0.55); line-height: 1.75; margin-bottom: 32px; }
        .instructor-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .istat { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 20px 16px; text-align: center; }
        .istat-num { font-family: 'Outfit', sans-serif; font-size: 28px; font-weight: 900; color: #ff5500; letter-spacing: -1px; }
        .istat-text { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 4px; line-height: 1.3; }

        /* FAQ */
        .faq-section { padding: 90px 24px; }
        .faq-wrap { max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 10px; }
        .faq-item-new {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            overflow: hidden;
            transition: border-color 0.25s ease;
        }
        .faq-item-new.open { border-color: rgba(255,85,0,0.35); }
        .faq-q {
            width: 100%; padding: 22px 28px;
            background: none; border: none;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 16px; font-weight: 600;
            text-align: left;
            display: flex; align-items: center; justify-content: space-between;
            cursor: pointer;
            gap: 16px;
        }
        .faq-q:hover { color: #ff7744; }
        .faq-icon { flex-shrink: 0; width: 28px; height: 28px; border-radius: 50%; background: rgba(255,255,255,0.07); display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; }
        .faq-item-new.open .faq-icon { background: rgba(255,85,0,0.15); transform: rotate(45deg); }
        .faq-a { padding: 0 28px 22px; font-size: 14px; color: rgba(255,255,255,0.5); line-height: 1.75; display: none; }
        .faq-item-new.open .faq-a { display: block; }

        /* CTA FINAL SECTION */
        .final-cta {
            padding: 100px 24px;
            text-align: center;
            background: linear-gradient(180deg, #070810 0%, #0d0614 50%, #070810 100%);
            position: relative;
            overflow: hidden;
        }
        .final-cta::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 800px; height: 400px;
            background: radial-gradient(ellipse, rgba(255,69,0,0.12) 0%, transparent 70%);
            filter: blur(60px);
        }
        .final-cta-headline {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(32px, 5vw, 60px);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -2px;
            margin-bottom: 20px;
            position: relative;
        }
        .final-cta-sub { font-size: 17px; color: rgba(255,255,255,0.45); max-width: 520px; margin: 0 auto 40px; line-height: 1.65; position: relative; }

        /* WhatsApp Float */
        .wa-float {
            position: fixed;
            bottom: 28px; right: 28px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .wa-pill {
            background: #059669;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 20px;
            border-radius: 100px;
            box-shadow: 0 4px 20px rgba(5,150,105,0.5);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
            white-space: nowrap;
        }
        .wa-float:hover .wa-pill { transform: scale(1.04); box-shadow: 0 6px 28px rgba(5,150,105,0.7); }
        .wa-circle {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: #059669;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 0 8px rgba(5,150,105,0.2), 0 4px 20px rgba(5,150,105,0.5);
            position: relative;
            animation: waPulse 2.5s infinite;
            transition: all 0.25s ease;
        }
        .wa-float:hover .wa-circle { box-shadow: 0 0 0 12px rgba(5,150,105,0.25), 0 6px 28px rgba(5,150,105,0.7); }
        .wa-dot { position: absolute; top: 5px; right: 5px; width: 10px; height: 10px; border-radius: 50%; background: #ef4444; border: 2px solid #070810; }
        @keyframes waPulse { 0%,100%{box-shadow:0 0 0 8px rgba(5,150,105,0.2),0 4px 20px rgba(5,150,105,0.5);} 50%{box-shadow:0 0 0 14px rgba(5,150,105,0.08),0 4px 20px rgba(5,150,105,0.5);} }

        /* Footer brand */
        .brand-logo { display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .brand-logo span { font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 900; color: #fff; }
        .brand-logo .seo { color: #00f2fe; }

        /* Section utils */
        .text-center { text-align: center; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .max-w-1100 { max-width: 1100px; }

        /* btn-outline, btn-primary in style.css need to also work */
        .btn-outline {
            background: transparent;
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.15);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.25s ease;
            width: 100%;
        }
        .btn-outline:hover { border-color: rgba(255,255,255,0.35); color: #fff; background: rgba(255,255,255,0.05); }

        @media (max-width: 1024px) {
            .industry-grid { grid-template-columns: repeat(2, 1fr); }
            .module-grid { grid-template-columns: repeat(2, 1fr); }
            .pricing-grid { grid-template-columns: 1fr; max-width: 480px; }
            .instructor-wrap { grid-template-columns: 1fr; }
            .stat-pill { padding: 0 24px; }
        }
        @media (max-width: 640px) {
            .industry-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .module-grid { grid-template-columns: 1fr; }
            .hero-headline { letter-spacing: -1.5px; }
            .stats-bar-inner { gap: 16px; }
            .stat-pill { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.08); padding: 16px 0; width: 100%; }
            .instructor-stats { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body style="background-color: #070810; color: #fff; margin: 0; overflow-x: hidden;">

<?php include 'header.php'; ?>

<!-- ════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════ -->
<section class="hero-section">
    <!-- Background orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div style="position: relative; z-index: 10; max-width: 1000px; width: 100%;">
        <!-- Live badge -->
        <div style="display: flex; justify-content: center; margin-bottom: 40px;">
            <div class="hero-badge">
                <div class="dot"></div>
                <span>Live Batch Open — Limited Seats</span>
            </div>
        </div>

        <!-- Main headline -->
        <h1 class="hero-headline">
            <span class="line-orange">Black Hat SEO Course</span>
            <span class="line-white">in Delhi, India</span>
        </h1>

        <!-- Subtext -->
        <p class="hero-subtext">
            Learn to generate <strong>500+ inbound calls/day</strong> for tech support, airlines &amp; finance.<br>
            Taught by a <strong>25+ year industry veteran</strong> — the #1 underground SEO training in India.
        </p>

        <!-- CTA Group -->
        <div class="hero-cta-group">
            <a href="#pricing" class="cta-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Enroll Now — 30 Days
            </a>
            <a href="#modules" class="cta-secondary">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                View Curriculum
            </a>
            <a href="#expert" class="cta-secondary">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 10-16 0"/></svg>
                Meet the Expert
            </a>
        </div>

        <!-- Trust indicators -->
        <div style="display: flex; justify-content: center; align-items: center; gap: 28px; margin-top: 52px; flex-wrap: wrap; opacity: 0.5; font-size: 12px; font-family: 'JetBrains Mono', monospace; letter-spacing: 0.5px;">
            <span>⭐ 4.8/5 Rating (230 reviews)</span>
            <span style="color: rgba(255,255,255,0.25);">|</span>
            <span>📅 Updated Jan 2026</span>
            <span style="color: rgba(255,255,255,0.25);">|</span>
            <span>🔒 Instant Access</span>
            <span style="color: rgba(255,255,255,0.25);">|</span>
            <span>🌍 Delhi + Online</span>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     STATS BAR
════════════════════════════════════════ -->
<div class="stats-bar">
    <div class="stats-bar-inner">
        <div class="stat-pill">
            <div class="stat-value-large" style="color:#ff5500;">18,640+</div>
            <div class="stat-label-small">Students Trained Globally</div>
        </div>
        <div class="stat-pill">
            <div class="stat-value-large" style="color:#fbbf24;">₹50Cr+</div>
            <div class="stat-label-small">Call Revenue Generated</div>
        </div>
        <div class="stat-pill">
            <div class="stat-value-large" style="color:#a78bfa;">25+</div>
            <div class="stat-label-small">Years Industry Experience</div>
        </div>
        <div class="stat-pill">
            <div class="stat-value-large" style="color:#34d399;">99.4%</div>
            <div class="stat-label-small">SERP Domination Rate</div>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════
     CRITICAL ALERT
════════════════════════════════════════ -->
<div class="alert-section">
    <div class="alert-box">
        <div style="font-size: 36px; margin-bottom: 14px;">⚠️</div>
        <div class="alert-title">Critical Alert</div>
        <p class="alert-text">
            Google has already started tightening policies. <span class="highlight">By Feb 2026, call-driven businesses will face massive restrictions.</span> Is yours at risk? Most call centers are already losing 40–70% of their inbound volume — don't be next.
        </p>
        <div class="alert-tags">
            <span class="alert-tag tag-red">🔴 High Risk</span>
            <span class="alert-tag tag-orange">📉 Urgent Action Needed</span>
            <span class="alert-tag tag-amber">⏰ Limited Seats Left</span>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════
     INDUSTRIES
════════════════════════════════════════ -->
<section class="section-wrap">
    <div class="max-w-1100 mx-auto">
        <span class="section-label">Industries We Dominate</span>
        <h2 class="section-h2">Generate Calls From Every<br><span style="color:#ff5500;">High-Intent Niche</span></h2>
        <p class="section-p">From Tech Support to Airlines — learn vertical-specific ranking blueprints that route real inbound calls to your center.</p>

        <div class="industry-grid">
            <a href="industries/tech-support.php" class="ind-card">
                <div class="ind-emoji">🎧</div>
                <div class="ind-name">Tech Support</div>
                <div class="ind-sub">Printer, Router, Antivirus & Software Calls</div>
                <div class="ind-arrow">Learn more →</div>
            </a>
            <a href="industries/airlines.php" class="ind-card">
                <div class="ind-emoji">✈️</div>
                <div class="ind-name">Airlines & Travel</div>
                <div class="ind-sub">Flight Changes, Reservations & Cancellations</div>
                <div class="ind-arrow">Learn more →</div>
            </a>
            <a href="industries/accounting.php" class="ind-card">
                <div class="ind-emoji">📊</div>
                <div class="ind-name">QuickBooks & Acct</div>
                <div class="ind-sub">Financial Software High-Intent Inbound Leads</div>
                <div class="ind-arrow">Learn more →</div>
            </a>
            <a href="industries/finance.php" class="ind-card">
                <div class="ind-emoji">💰</div>
                <div class="ind-name">Finance & Loans</div>
                <div class="ind-sub">Debt Settlement, Mortgage & Personal Loan Calls</div>
                <div class="ind-arrow">Learn more →</div>
            </a>
            <a href="industries/crypto.php" class="ind-card">
                <div class="ind-emoji">🪙</div>
                <div class="ind-name">Cryptocurrency</div>
                <div class="ind-sub">Wallet Recovery, Exchange & Crypto Trade Leads</div>
                <div class="ind-arrow">Learn more →</div>
            </a>
            <a href="industries/saas.php" class="ind-card">
                <div class="ind-emoji">💻</div>
                <div class="ind-name">SaaS & B2B</div>
                <div class="ind-sub">Enterprise Software Demo & Renewal Calls</div>
                <div class="ind-arrow">Learn more →</div>
            </a>
            <a href="industries/insurance.php" class="ind-card">
                <div class="ind-emoji">🛡️</div>
                <div class="ind-name">Insurance</div>
                <div class="ind-sub">Auto, Health, Life & Medicare Inbound Leads</div>
                <div class="ind-arrow">Learn more →</div>
            </a>
            <a href="industries/real-estate.php" class="ind-card">
                <div class="ind-emoji">🏢</div>
                <div class="ind-name">Real Estate</div>
                <div class="ind-sub">Buyer & Seller Local Property Inquiries</div>
                <div class="ind-arrow">Learn more →</div>
            </a>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     CURRICULUM MODULES
════════════════════════════════════════ -->
<section class="modules-section" id="modules">
    <div class="max-w-1100 mx-auto">
        <span class="section-label">The Curriculum</span>
        <h2 class="section-h2">8 Advanced Modules That<br><span style="color:#ff5500;">Actually Work</span></h2>
        <p class="section-p">Zero fluff. Pure battle-tested techniques used by the world's most aggressive SEO operators.</p>

        <div class="module-grid">
            <div class="mod-card">
                <span class="mod-number">MODULE 01</span>
                <div class="mod-icon-wrap">⚡</div>
                <div class="mod-title">High-Velocity URL Indexing</div>
                <div class="mod-desc">Force 100,000+ dynamic URLs into Google's primary index within 24 hours using API pipelines, crawl budget hacking, and GDS sitemaps.</div>
            </div>
            <div class="mod-card">
                <span class="mod-number">MODULE 02</span>
                <div class="mod-icon-wrap">📞</div>
                <div class="mod-title">Inbound Call Generation</div>
                <div class="mod-desc">Architect complete inbound phone call funnels for Tech Support, Airlines &amp; Finance. Target zero-volume, ultra-high-intent queries.</div>
            </div>
            <div class="mod-card">
                <span class="mod-number">MODULE 03</span>
                <div class="mod-icon-wrap">🤖</div>
                <div class="mod-title">CTR SERP Manipulation</div>
                <div class="mod-desc">Deploy residential proxy search bots to simulate real user behavior, boost click-through rates, and rocket organic rankings to Top 3.</div>
            </div>
            <div class="mod-card">
                <span class="mod-number">MODULE 04</span>
                <div class="mod-icon-wrap">🧬</div>
                <div class="mod-title">Parasite SEO Domination</div>
                <div class="mod-desc">Leverage high-DA platforms (Medium, LinkedIn, GitHub, Notion) to rank commercial keywords in 24–48 hours with zero domain age.</div>
            </div>
            <div class="mod-card">
                <span class="mod-number">MODULE 05</span>
                <div class="mod-icon-wrap">🌐</div>
                <div class="mod-title">PBN & Expired Domain Network</div>
                <div class="mod-desc">Build footprint-free Private Blog Networks with WHOIS obfuscation, diverse IP classes, and high-DA expired domain insertion.</div>
            </div>
            <div class="mod-card">
                <span class="mod-number">MODULE 06</span>
                <div class="mod-icon-wrap">🔒</div>
                <div class="mod-title">Technical Cloaking</div>
                <div class="mod-desc">User-agent &amp; IP-based content redirection — serve Google-compliant pages to crawlers while showing high-converting funnels to visitors.</div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     PRICING
════════════════════════════════════════ -->
<section class="pricing-section" id="pricing">
    <div class="text-center" style="margin-bottom: 56px;">
        <span class="section-label" style="display:block;">Enrollment</span>
        <h2 class="section-h2">Choose Your<br><span style="color:#ff5500;">Training Package</span></h2>
    </div>

    <div class="pricing-grid">
        <!-- Basic -->
        <div class="price-card">
            <div class="price-tier">Starter Pack</div>
            <div class="price-amount white">₹9,999</div>
            <p class="price-desc">Core Black Hat SEO techniques for beginners ready to rank fast.</p>
            <div class="price-divider"></div>
            <ul class="price-features">
                <li><span class="check">✓</span> High-Velocity Indexing Blueprint</li>
                <li><span class="check">✓</span> Parasite SEO & Web 2.0 Setup</li>
                <li><span class="check">✓</span> Basic CTR Manipulation Scripts</li>
                <li><span class="check">✓</span> Community Forum Access</li>
                <li><span class="check">✓</span> Lifetime Recorded Sessions</li>
            </ul>
            <a href="register.php" class="price-btn price-btn-outline">Get Started →</a>
        </div>

        <!-- Featured -->
        <div class="price-card featured">
            <div class="price-tier">Call Gen Masterclass</div>
            <div class="price-amount orange">₹24,999</div>
            <p class="price-desc">The complete inbound call system for tech support, airlines &amp; finance.</p>
            <div class="price-divider"></div>
            <ul class="price-features">
                <li><span class="check" style="color:#ff5500;">✓</span> Everything in Starter Pack</li>
                <li><span class="check" style="color:#ff5500;">✓</span> Tech Support Call Routing Blueprint</li>
                <li><span class="check" style="color:#ff5500;">✓</span> Airlines & Finance Call Funnels</li>
                <li><span class="check" style="color:#ff5500;">✓</span> Technical Cloaking Full Module</li>
                <li><span class="check" style="color:#ff5500;">✓</span> CTR SERP Bot Suite License</li>
                <li><span class="check" style="color:#ff5500;">✓</span> PBN Network Setup Walkthrough</li>
                <li><span class="check" style="color:#ff5500;">✓</span> 3 Months Group Support</li>
            </ul>
            <a href="register.php" class="price-btn price-btn-orange">Enroll Now →</a>
        </div>

        <!-- VIP -->
        <div class="price-card">
            <div class="price-tier">VIP Mentorship</div>
            <div class="price-amount teal">₹49,999</div>
            <p class="price-desc">1-on-1 with Suresh Das. Custom PBN build. Direct call center scaling.</p>
            <div class="price-divider"></div>
            <ul class="price-features">
                <li><span class="check" style="color:#00f2fe;">✓</span> Everything in Call Gen Masterclass</li>
                <li><span class="check" style="color:#00f2fe;">✓</span> Private 1-on-1 Sessions (Suresh Das)</li>
                <li><span class="check" style="color:#00f2fe;">✓</span> Custom Footprint-Free PBN Build</li>
                <li><span class="check" style="color:#00f2fe;">✓</span> Dedicated Call Center Scaling Plan</li>
                <li><span class="check" style="color:#00f2fe;">✓</span> 24/7 Priority Emergency Support</li>
                <li><span class="check" style="color:#00f2fe;">✓</span> 6 Months Ongoing Guidance</li>
            </ul>
            <a href="contact.php" class="price-btn price-btn-teal">Apply for VIP →</a>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     INSTRUCTOR
════════════════════════════════════════ -->
<section class="instructor-section" id="expert">
    <div class="instructor-wrap">
        <div class="instructor-avatar">
            <div class="instructor-initial">SD</div>
            <div class="instructor-name-large">Suresh Das</div>
            <div class="instructor-tag">25+ Years · Delhi, India</div>
        </div>
        <div class="instructor-text">
            <span class="section-label">The Expert Behind the Course</span>
            <h2 class="section-h2" style="margin-bottom: 20px;">India's Most Feared<br><span style="color:#ff5500;">Black Hat SEO Trainer</span></h2>
            <p class="instructor-bio">
                Suresh Das has spent 25+ years in the trenches of competitive search — building, breaking, and rebuilding ranking systems before Google even had algorithms sophisticated enough to detect them. He has trained over 18,000 marketers, call center owners, and SEO agencies across India and internationally, generating measurable ₹50Cr+ in verified call revenue.
            </p>
            <p class="instructor-bio" style="margin-bottom: 32px;">
                Unlike theoretical trainers, Suresh runs live call generation operations himself — meaning everything taught in the course is actively working in the real world today.
            </p>
            <div class="instructor-stats">
                <div class="istat">
                    <div class="istat-num">18K+</div>
                    <div class="istat-text">Students Trained</div>
                </div>
                <div class="istat">
                    <div class="istat-num">25+</div>
                    <div class="istat-text">Years Experience</div>
                </div>
                <div class="istat">
                    <div class="istat-num">₹50Cr</div>
                    <div class="istat-text">Call Revenue Generated</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     FAQ
════════════════════════════════════════ -->
<section class="faq-section">
    <div style="text-align: center; margin-bottom: 52px;">
        <span class="section-label" style="display:block;">FAQ</span>
        <h2 class="section-h2">Frequently Asked<br><span style="color:#ff5500;">Questions</span></h2>
    </div>

    <div class="faq-wrap">
        <div class="faq-item-new open">
            <button class="faq-q">
                <span>What exactly is the Black Hat SEO Course?</span>
                <div class="faq-icon">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                </div>
            </button>
            <div class="faq-a">An advanced SEO training program covering aggressive ranking techniques, high-velocity indexing, CTR manipulation, PBN networks, and inbound call generation systems — all taught with live real-world demonstrations.</div>
        </div>
        <div class="faq-item-new">
            <button class="faq-q">
                <span>Does this course teach tech support call generation?</span>
                <div class="faq-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></div>
            </button>
            <div class="faq-a">Yes — this is one of the core modules. You'll learn to rank for printer, router, antivirus, and software support keywords and route real inbound calls directly to your call center using cloaking and funnel architecture.</div>
        </div>
        <div class="faq-item-new">
            <button class="faq-q">
                <span>Is prior SEO experience required to join?</span>
                <div class="faq-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></div>
            </button>
            <div class="faq-a">Basic familiarity with SEO concepts helps, but motivated beginners can follow along — the course is structured step-by-step with hands-on practical demonstrations from absolute scratch.</div>
        </div>
        <div class="faq-item-new">
            <button class="faq-q">
                <span>Is this course available online or only in Delhi?</span>
                <div class="faq-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></div>
            </button>
            <div class="faq-a">Both. Live batches are held in Delhi NCR, but the full course is also available online with recorded sessions, live Q&amp;A calls, and community forum support accessible from anywhere in the world.</div>
        </div>
        <div class="faq-item-new">
            <button class="faq-q">
                <span>Can call center owners benefit from this course?</span>
                <div class="faq-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></div>
            </button>
            <div class="faq-a">Absolutely — this course was specifically designed for call center owners who want to stop depending on lead buyers and generate their own high-intent inbound call flow using organic search domination.</div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     FINAL CTA
════════════════════════════════════════ -->
<section class="final-cta">
    <div style="position: relative;">
        <span class="section-label" style="display: block; margin-bottom: 16px;">Don't Wait</span>
        <h2 class="final-cta-headline">Stop Buying Leads.<br><span style="color:#ff5500;">Start Generating Them.</span></h2>
        <p class="final-cta-sub">Join 18,640+ marketers and call center owners who have taken control of their inbound call flow.</p>
        <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
            <a href="register.php" class="cta-primary" style="font-size: 16px; padding: 17px 40px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Enroll in BlackHat SEO Course
            </a>
            <a href="contact.php" class="cta-secondary" style="font-size: 16px; padding: 16px 32px;">
                Talk to Us First →
            </a>
        </div>
    </div>
</section>

<!-- Floating WhatsApp -->
<a href="https://wa.me/918920624649?text=Hi,%20I%20want%20to%20enroll%20in%20the%20BlackHat%20SEO%20Course" target="_blank" class="wa-float">
    <div class="wa-pill">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
        WhatsApp Now
    </div>
    <div class="wa-circle">
        <svg width="26" height="26" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
        <div class="wa-dot"></div>
    </div>
</a>

<?php include 'footer.php'; ?>

<script>
// FAQ accordion
document.querySelectorAll('.faq-q').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.closest('.faq-item-new');
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item-new').forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
    });
});

// Orb 2 & 3 custom float animations
const orb2 = document.querySelector('.orb-2');
const orb3 = document.querySelector('.orb-3');
if (orb2) {
    orb2.style.animation = 'none';
    let t2 = 0;
    setInterval(() => {
        t2 += 0.02;
        orb2.style.transform = `translateY(${Math.sin(t2) * 25}px)`;
    }, 30);
}
if (orb3) {
    orb3.style.animation = 'none';
    let t3 = 2;
    setInterval(() => {
        t3 += 0.015;
        orb3.style.transform = `translateY(${Math.sin(t3) * 20}px)`;
    }, 30);
}
</script>

</body>
</html>