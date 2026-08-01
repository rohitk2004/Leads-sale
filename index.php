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
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        :root {
            --orange: #ff5500;
            --orange-dim: rgba(255,85,0,0.15);
            --teal: #00f2fe;
            --bg: #070810;
        }

        body { background: var(--bg); color: #fff; font-family: 'Inter', sans-serif; overflow-x: hidden; }

        /* ─── CANVAS PARTICLES ─── */
        #hero-canvas { position: absolute; inset: 0; z-index: 1; opacity: 0.45; }

        /* ─── ANIMATED GRID ─── */
        .grid-overlay {
            position: absolute; inset: 0; z-index: 2;
            background-image:
                linear-gradient(rgba(255,85,0,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,85,0,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridPan 20s linear infinite;
        }
        @keyframes gridPan { from{background-position:0 0;} to{background-position:60px 60px;} }

        /* ─── 3D FLOATING SHAPES ─── */
        .shapes-layer { position: absolute; inset: 0; z-index: 3; pointer-events: none; overflow: hidden; }

        .shape3d {
            position: absolute;
            transform-style: preserve-3d;
        }

        /* Spinning cube */
        .cube-wrap {
            width: 80px; height: 80px;
            top: 15%; left: 8%;
            animation: floatUpDown 6s ease-in-out infinite;
        }
        .cube {
            width: 80px; height: 80px;
            position: relative; transform-style: preserve-3d;
            animation: spinCube 10s linear infinite;
        }
        .cube-face {
            position: absolute;
            width: 80px; height: 80px;
            border: 1px solid rgba(255,85,0,0.4);
            background: rgba(255,85,0,0.05);
            backdrop-filter: blur(2px);
        }
        .cube-face.front  { transform: translateZ(40px); }
        .cube-face.back   { transform: rotateY(180deg) translateZ(40px); }
        .cube-face.left   { transform: rotateY(-90deg) translateZ(40px); }
        .cube-face.right  { transform: rotateY(90deg) translateZ(40px); }
        .cube-face.top    { transform: rotateX(90deg) translateZ(40px); }
        .cube-face.bottom { transform: rotateX(-90deg) translateZ(40px); }
        @keyframes spinCube { from{transform:rotateX(0) rotateY(0)} to{transform:rotateX(360deg) rotateY(360deg)} }

        /* Spinning ring */
        .ring-wrap {
            width: 120px; height: 120px;
            top: 20%; right: 6%;
            animation: floatUpDown 8s ease-in-out infinite reverse;
        }
        .ring {
            width: 120px; height: 120px;
            border-radius: 50%;
            border: 2px solid rgba(0,242,254,0.35);
            box-shadow: 0 0 20px rgba(0,242,254,0.15), inset 0 0 20px rgba(0,242,254,0.08);
            animation: spinRing 7s linear infinite;
        }
        .ring::after {
            content: '';
            position: absolute;
            top: 10px; left: 10px; right: 10px; bottom: 10px;
            border-radius: 50%;
            border: 1px solid rgba(0,242,254,0.2);
            animation: spinRing 4s linear infinite reverse;
        }
        @keyframes spinRing { from{transform:rotateX(70deg) rotateZ(0)} to{transform:rotateX(70deg) rotateZ(360deg)} }

        /* Diamond */
        .diamond-wrap {
            width: 60px; height: 60px;
            bottom: 30%; left: 5%;
            animation: floatUpDown 7s ease-in-out infinite 2s;
        }
        .diamond {
            width: 60px; height: 60px;
            background: rgba(168,85,247,0.15);
            border: 1px solid rgba(168,85,247,0.4);
            transform: rotate(45deg);
            box-shadow: 0 0 20px rgba(168,85,247,0.2);
            animation: spinDiamond 8s linear infinite;
        }
        @keyframes spinDiamond { from{transform:rotate(45deg) scale(1);} 50%{transform:rotate(225deg) scale(1.15);} to{transform:rotate(405deg) scale(1);} }

        /* Triangle / pyramid */
        .pyramid-wrap {
            width: 70px; height: 70px;
            bottom: 25%; right: 8%;
            animation: floatUpDown 9s ease-in-out infinite 1s;
        }
        .pyramid {
            width: 0; height: 0;
            border-left: 35px solid transparent;
            border-right: 35px solid transparent;
            border-bottom: 60px solid rgba(255,85,0,0.18);
            filter: drop-shadow(0 0 12px rgba(255,85,0,0.4));
            animation: spinPyramid 11s linear infinite;
        }
        @keyframes spinPyramid { from{transform:rotateY(0);} to{transform:rotateY(360deg);} }

        /* Small glowing dots */
        .dot3d {
            border-radius: 50%;
            background: radial-gradient(circle, #ff5500, transparent);
            animation: floatUpDown var(--dur, 5s) ease-in-out infinite var(--delay, 0s);
        }

        @keyframes floatUpDown {
            0%,100%{ transform: translateY(0); }
            50%{ transform: translateY(-24px); }
        }

        /* ─── HERO ─── */
        .hero-section {
            position: relative; min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center; overflow: hidden;
            padding: 130px 24px 90px;
            background: var(--bg);
            perspective: 1200px;
        }

        .hero-content { position: relative; z-index: 10; max-width: 1000px; width: 100%; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,69,0,0.1); border: 1px solid rgba(255,69,0,0.35);
            padding: 7px 22px; border-radius: 100px; margin-bottom: 44px;
            font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700;
            color: #ff6b35; letter-spacing: 1.5px; text-transform: uppercase;
            animation: fadeSlideDown 0.6s ease both;
        }
        .badge-dot { width: 7px; height: 7px; border-radius: 50%; background: #ff4500; box-shadow: 0 0 8px #ff4500; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;box-shadow:0 0 8px #ff4500;} 50%{opacity:0.5;box-shadow:0 0 16px #ff4500;} }

        .hero-headline {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(52px, 7.5vw, 100px);
            font-weight: 900; line-height: 1.0;
            letter-spacing: -3px; margin-bottom: 30px;
            animation: fadeSlideUp 0.7s 0.15s ease both;
        }
        .line-orange {
            display: block; color: #ff5500;
            text-shadow: 0 0 80px rgba(255,85,0,0.55), 0 0 20px rgba(255,85,0,0.25);
            animation: glowPulse 3s ease-in-out infinite;
        }
        @keyframes glowPulse {
            0%,100%{ text-shadow: 0 0 80px rgba(255,85,0,0.55), 0 0 20px rgba(255,85,0,0.25); }
            50%{ text-shadow: 0 0 120px rgba(255,85,0,0.8), 0 0 40px rgba(255,85,0,0.5), 0 0 80px rgba(255,120,50,0.3); }
        }
        .line-white { display: block; color: #fff; text-shadow: 0 0 40px rgba(255,255,255,0.12); }

        /* TYPED TEXT */
        .typed-wrap {
            font-size: 18px; color: rgba(255,255,255,0.55);
            max-width: 700px; margin: 0 auto 44px;
            font-family: 'Inter', sans-serif; line-height: 1.7;
            animation: fadeSlideUp 0.7s 0.3s ease both;
        }
        .typed-accent { color: rgba(255,255,255,0.9); font-weight: 600; }
        .typed-cursor { display: inline-block; width: 2px; height: 1em; background: #ff5500; margin-left: 2px; vertical-align: text-bottom; animation: blink 0.9s step-end infinite; }
        @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:0;} }

        .hero-cta-group {
            display: flex; align-items: center; justify-content: center;
            gap: 14px; flex-wrap: wrap;
            animation: fadeSlideUp 0.7s 0.45s ease both;
        }
        .cta-primary {
            background: linear-gradient(135deg, #ff5500, #cc2200);
            color: #fff; font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700;
            padding: 15px 34px; border-radius: 14px; text-decoration: none;
            display: inline-flex; align-items: center; gap: 9px;
            box-shadow: 0 0 40px rgba(255,85,0,0.4), 0 4px 16px rgba(0,0,0,0.4);
            transition: all 0.25s ease; position: relative; overflow: hidden;
        }
        .cta-primary::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.4s ease;
        }
        .cta-primary:hover::before { left: 100%; }
        .cta-primary:hover { transform: translateY(-3px) scale(1.03); box-shadow: 0 0 60px rgba(255,85,0,0.65), 0 8px 24px rgba(0,0,0,0.5); color: #fff; }
        .cta-secondary {
            background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.8);
            font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 600;
            padding: 14px 30px; border-radius: 14px; text-decoration: none;
            display: inline-flex; align-items: center; gap: 9px;
            border: 1px solid rgba(255,255,255,0.12); transition: all 0.25s ease;
        }
        .cta-secondary:hover { background: rgba(255,255,255,0.11); border-color: rgba(255,255,255,0.28); color: #fff; transform: translateY(-2px); }

        .trust-strip {
            display: flex; justify-content: center; align-items: center; gap: 28px;
            margin-top: 52px; flex-wrap: wrap;
            opacity: 0.45; font-size: 12px;
            font-family: 'JetBrains Mono', monospace; letter-spacing: 0.5px;
            animation: fadeSlideUp 0.7s 0.6s ease both;
        }
        .trust-sep { color: rgba(255,255,255,0.2); }

        /* ─── MARQUEE TICKER ─── */
        .marquee-section {
            background: rgba(255,85,0,0.06);
            border-top: 1px solid rgba(255,85,0,0.2);
            border-bottom: 1px solid rgba(255,85,0,0.2);
            padding: 16px 0; overflow: hidden; position: relative;
        }
        .marquee-track {
            display: flex; gap: 0;
            animation: marqueeScroll 28s linear infinite;
            width: max-content;
        }
        .marquee-track:hover { animation-play-state: paused; }
        .marquee-item {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 0 40px; white-space: nowrap;
            font-family: 'JetBrains Mono', monospace; font-size: 12px; font-weight: 700;
            color: rgba(255,150,80,0.85); letter-spacing: 1px; text-transform: uppercase;
        }
        .marquee-sep { color: rgba(255,85,0,0.4); font-size: 18px; }
        @keyframes marqueeScroll { from{transform:translateX(0);} to{transform:translateX(-50%);} }

        /* Reverse marquee */
        .marquee-track-rev { animation: marqueeScrollRev 32s linear infinite; }
        .marquee-track-rev .marquee-item { color: rgba(0,220,240,0.7); }
        @keyframes marqueeScrollRev { from{transform:translateX(-50%);} to{transform:translateX(0);} }

        /* ─── STATS BAR ─── */
        .stats-bar {
            background: rgba(255,255,255,0.02);
            border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 36px 24px;
        }
        .stats-bar-inner {
            display: flex; justify-content: center; align-items: center;
            max-width: 1100px; margin: 0 auto; flex-wrap: wrap;
        }
        .stat-pill {
            display: flex; align-items: center; gap: 16px;
            padding: 0 48px;
            border-right: 1px solid rgba(255,255,255,0.07);
        }
        .stat-pill:last-child { border-right: none; }
        .stat-icon { font-size: 32px; opacity: 0.8; }
        .stat-num {
            font-family: 'Outfit', sans-serif; font-size: 42px; font-weight: 900;
            letter-spacing: -2px; line-height: 1;
        }
        .stat-lbl { font-size: 12px; color: rgba(255,255,255,0.38); font-weight: 500; line-height: 1.4; max-width: 80px; }

        /* ─── CRITICAL ALERT ─── */
        .alert-section { padding: 60px 24px; }
        .alert-box {
            max-width: 880px; margin: 0 auto;
            background: linear-gradient(135deg, rgba(28,8,4,0.92) 0%, rgba(18,5,10,0.96) 100%);
            border: 1px solid rgba(255,87,34,0.55);
            border-radius: 24px; padding: 48px 52px;
            box-shadow: 0 0 70px rgba(255,69,0,0.22), inset 0 1px 0 rgba(255,150,100,0.12);
            text-align: center; position: relative; overflow: hidden;
            animation: alertPulse 4s ease-in-out infinite;
        }
        @keyframes alertPulse {
            0%,100%{ box-shadow: 0 0 70px rgba(255,69,0,0.22); }
            50%{ box-shadow: 0 0 100px rgba(255,69,0,0.38), 0 0 40px rgba(255,69,0,0.15); }
        }
        .alert-box::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,100,50,0.7), transparent);
        }
        .alert-icon { font-size: 44px; margin-bottom: 14px; animation: alertShake 3s ease-in-out infinite; display: block; }
        @keyframes alertShake {
            0%,100%{transform:rotate(0deg);} 5%{transform:rotate(-8deg);} 10%{transform:rotate(8deg);} 15%{transform:rotate(-4deg);} 20%{transform:rotate(0deg);}
        }
        .alert-title { font-family: 'Outfit', sans-serif; font-size: 34px; font-weight: 900; color: #ff5500; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 16px; }
        .alert-text { font-size: 16px; color: rgba(255,255,255,0.72); line-height: 1.7; margin-bottom: 28px; }
        .alert-highlight { color: #ff7744; font-weight: 700; }
        .alert-tags { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }
        .alert-tag { font-family: 'JetBrains Mono', monospace; font-size: 10px; font-weight: 700; padding: 5px 16px; border-radius: 100px; text-transform: uppercase; letter-spacing: 1px; }
        .tag-r { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.35); color: #f87171; }
        .tag-o { background: rgba(255,107,53,0.15); border: 1px solid rgba(255,107,53,0.35); color: #ff9966; }
        .tag-a { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.35); color: #fbbf24; }

        /* ─── SECTION BASE ─── */
        .section-label { font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700; color: #ff6b35; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 12px; display: block; }
        .section-h2 { font-family: 'Outfit', sans-serif; font-size: clamp(28px, 4vw, 48px); font-weight: 800; line-height: 1.12; letter-spacing: -1.5px; margin-bottom: 16px; }
        .section-p { font-size: 16px; color: rgba(255,255,255,0.42); max-width: 560px; line-height: 1.68; margin-bottom: 52px; }
        .section-wrap { padding: 100px 24px; max-width: 1160px; margin: 0 auto; }

        /* ─── INDUSTRY GRID ─── */
        .industry-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
        .ind-card {
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px; padding: 26px 20px;
            text-decoration: none; color: #fff;
            display: flex; flex-direction: column; gap: 10px;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            transform-style: preserve-3d;
            cursor: pointer; position: relative; overflow: hidden;
        }
        .ind-card::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,85,0,0.08), transparent);
            opacity: 0; transition: opacity 0.3s ease; border-radius: 20px;
        }
        .ind-card:hover { transform: translateY(-8px) rotateX(3deg) rotateY(-2deg); border-color: rgba(255,85,0,0.4); box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 30px rgba(255,85,0,0.15); color: #fff; }
        .ind-card:hover::before { opacity: 1; }
        .ind-emoji { font-size: 30px; }
        .ind-name { font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700; }
        .ind-sub { font-size: 12px; color: rgba(255,255,255,0.38); line-height: 1.4; }
        .ind-arrow { font-size: 13px; color: #ff6b35; opacity: 0; transform: translateX(-6px); transition: all 0.25s ease; margin-top: auto; }
        .ind-card:hover .ind-arrow { opacity: 1; transform: translateX(0); }

        /* ─── MODULES ─── */
        .modules-outer { padding: 100px 24px; background: rgba(255,255,255,0.012); }
        .module-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; max-width: 1160px; margin: 0 auto; }
        .mod-card {
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 22px; padding: 32px 28px;
            transition: all 0.35s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative; overflow: hidden;
            transform-style: preserve-3d;
        }
        .mod-card::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, #ff5500, transparent);
            opacity: 0; transition: opacity 0.3s ease;
        }
        .mod-card:hover { transform: translateY(-6px) rotateX(2deg); border-color: rgba(255,85,0,0.3); box-shadow: 0 16px 50px rgba(0,0,0,0.45); }
        .mod-card:hover::after { opacity: 1; }
        .mod-num { font-family: 'JetBrains Mono', monospace; font-size: 10px; font-weight: 700; color: rgba(255,107,53,0.6); letter-spacing: 1.5px; margin-bottom: 14px; display: block; text-transform: uppercase; }
        .mod-icon-wrap { width: 48px; height: 48px; border-radius: 13px; background: rgba(255,85,0,0.1); border: 1px solid rgba(255,85,0,0.22); display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px; }
        .mod-title { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; margin-bottom: 10px; }
        .mod-desc { font-size: 13px; color: rgba(255,255,255,0.42); line-height: 1.68; }

        /* ─── SECOND MARQUEE (between modules and pricing) ─── */

        /* ─── PRICING ─── */
        .pricing-outer { padding: 100px 24px; }
        .pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; max-width: 1100px; margin: 0 auto; }
        .price-card {
            background: rgba(255,255,255,0.025); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 26px; padding: 38px 34px;
            display: flex; flex-direction: column;
            transition: all 0.35s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative; overflow: hidden; transform-style: preserve-3d;
        }
        .price-card.featured { background: rgba(255,69,0,0.06); border-color: rgba(255,69,0,0.45); box-shadow: 0 0 60px rgba(255,69,0,0.18); }
        .price-card.featured::before { content: 'MOST POPULAR'; position: absolute; top: 20px; right: 20px; font-family: 'JetBrains Mono', monospace; font-size: 9px; font-weight: 700; letter-spacing: 1.5px; color: #ff6b35; background: rgba(255,69,0,0.16); border: 1px solid rgba(255,69,0,0.32); padding: 4px 10px; border-radius: 100px; }
        .price-card:hover { transform: translateY(-8px) rotateX(2deg); box-shadow: 0 25px 70px rgba(0,0,0,0.5); }
        .price-tier { font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.32); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 20px; }
        .price-amount { font-family: 'Outfit', sans-serif; font-size: 50px; font-weight: 900; letter-spacing: -2px; margin-bottom: 8px; line-height: 1; }
        .price-desc { font-size: 14px; color: rgba(255,255,255,0.4); margin-bottom: 28px; line-height: 1.5; }
        .price-divider { height: 1px; background: rgba(255,255,255,0.07); margin-bottom: 26px; }
        .price-features { list-style: none; display: flex; flex-direction: column; gap: 12px; margin-bottom: 34px; flex: 1; }
        .price-features li { font-size: 13px; color: rgba(255,255,255,0.7); display: flex; align-items: flex-start; gap: 10px; }
        .pf-check { flex-shrink: 0; margin-top: 1px; font-size: 14px; }
        .price-btn { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 15px; border-radius: 14px; font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.25s ease; }
        .pb-orange { background: linear-gradient(135deg, #ff5500, #cc2200); color: #fff; box-shadow: 0 4px 24px rgba(255,85,0,0.35); }
        .pb-orange:hover { box-shadow: 0 6px 36px rgba(255,85,0,0.55); transform: translateY(-2px); color: #fff; }
        .pb-outline { background: transparent; border: 1px solid rgba(255,255,255,0.14); color: rgba(255,255,255,0.7); }
        .pb-outline:hover { border-color: rgba(255,255,255,0.32); color: #fff; background: rgba(255,255,255,0.05); }
        .pb-teal { background: linear-gradient(135deg, #00f2fe, #0099cc); color: #000; box-shadow: 0 4px 24px rgba(0,242,254,0.25); }
        .pb-teal:hover { box-shadow: 0 6px 36px rgba(0,242,254,0.45); transform: translateY(-2px); color: #000; }

        /* ─── INSTRUCTOR ─── */
        .instructor-outer { padding: 100px 24px; background: rgba(255,255,255,0.012); }
        .instructor-wrap { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .instructor-avatar {
            aspect-ratio: 1;
            background: linear-gradient(135deg, #0f0a1e 0%, #0a1520 100%);
            border: 1px solid rgba(255,85,0,0.28);
            border-radius: 32px;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px;
            position: relative; overflow: hidden;
            box-shadow: 0 0 90px rgba(255,69,0,0.12);
            animation: avatarFloat 6s ease-in-out infinite;
            transition: all 0.35s ease;
        }
        .instructor-avatar:hover { transform: rotateY(8deg) rotateX(4deg); box-shadow: 0 0 120px rgba(255,69,0,0.2); }
        @keyframes avatarFloat { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-12px);} }
        .instructor-avatar::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at center, rgba(255,69,0,0.07) 0%, transparent 60%); }
        .instructor-initial { font-family: 'Outfit', sans-serif; font-size: 110px; font-weight: 900; color: rgba(255,85,0,0.25); line-height: 1; position: relative; }
        .instructor-name-lrg { font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 800; color: #ff6b35; position: relative; }
        .instructor-tag-sm { font-family: 'JetBrains Mono', monospace; font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.3); letter-spacing: 2.5px; text-transform: uppercase; position: relative; }
        .instructor-bio { font-size: 15px; color: rgba(255,255,255,0.5); line-height: 1.8; margin-bottom: 28px; }
        .instructor-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .istat { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 20px 14px; text-align: center; transition: all 0.25s ease; }
        .istat:hover { border-color: rgba(255,85,0,0.3); background: rgba(255,85,0,0.05); transform: translateY(-3px); }
        .istat-num { font-family: 'Outfit', sans-serif; font-size: 28px; font-weight: 900; color: #ff5500; letter-spacing: -1px; }
        .istat-text { font-size: 11px; color: rgba(255,255,255,0.38); margin-top: 4px; line-height: 1.3; }

        /* ─── FAQ ─── */
        .faq-outer { padding: 100px 24px; }
        .faq-wrap { max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 10px; }
        .faq-item { background: rgba(255,255,255,0.025); border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; overflow: hidden; transition: border-color 0.25s ease; }
        .faq-item.open { border-color: rgba(255,85,0,0.38); }
        .faq-q { width: 100%; padding: 22px 28px; background: none; border: none; color: #fff; font-family: 'Outfit', sans-serif; font-size: 16px; font-weight: 600; text-align: left; display: flex; align-items: center; justify-content: space-between; cursor: pointer; gap: 16px; transition: color 0.2s; }
        .faq-q:hover { color: #ff7744; }
        .faq-icon { flex-shrink: 0; width: 28px; height: 28px; border-radius: 50%; background: rgba(255,255,255,0.07); display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; }
        .faq-item.open .faq-icon { background: rgba(255,85,0,0.16); transform: rotate(45deg); }
        .faq-a { padding: 0 28px 22px; font-size: 14px; color: rgba(255,255,255,0.48); line-height: 1.78; display: none; }
        .faq-item.open .faq-a { display: block; }

        /* ─── FINAL CTA ─── */
        .final-cta { padding: 110px 24px; text-align: center; position: relative; overflow: hidden; background: linear-gradient(180deg, #070810 0%, #0e0618 50%, #070810 100%); }
        .final-cta::before { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 900px; height: 450px; background: radial-gradient(ellipse, rgba(255,69,0,0.13) 0%, transparent 70%); filter: blur(60px); }
        .final-h { font-family: 'Outfit', sans-serif; font-size: clamp(34px, 5vw, 64px); font-weight: 900; line-height: 1.08; letter-spacing: -2px; margin-bottom: 22px; position: relative; }
        .final-sub { font-size: 17px; color: rgba(255,255,255,0.42); max-width: 520px; margin: 0 auto 44px; line-height: 1.68; position: relative; }
        .final-btns { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; position: relative; }

        /* ─── WHATSAPP ─── */
        .wa-float { position: fixed; bottom: 28px; right: 28px; z-index: 9999; display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .wa-pill { background: #059669; color: #fff; font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 13px; padding: 10px 20px; border-radius: 100px; box-shadow: 0 4px 20px rgba(5,150,105,0.5); display: flex; align-items: center; gap: 8px; transition: all 0.25s ease; white-space: nowrap; }
        .wa-float:hover .wa-pill { transform: scale(1.04); box-shadow: 0 6px 30px rgba(5,150,105,0.7); }
        .wa-circle { width: 52px; height: 52px; border-radius: 50%; background: #059669; color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 0 8px rgba(5,150,105,0.2), 0 4px 20px rgba(5,150,105,0.5); position: relative; animation: waPulse 2.5s infinite; }
        .wa-float:hover .wa-circle { box-shadow: 0 0 0 12px rgba(5,150,105,0.25), 0 6px 30px rgba(5,150,105,0.7); }
        .wa-dot { position: absolute; top: 5px; right: 5px; width: 10px; height: 10px; border-radius: 50%; background: #ef4444; border: 2px solid #070810; }
        @keyframes waPulse { 0%,100%{box-shadow:0 0 0 8px rgba(5,150,105,0.2),0 4px 20px rgba(5,150,105,0.5);} 50%{box-shadow:0 0 0 16px rgba(5,150,105,0.07),0 4px 20px rgba(5,150,105,0.5);} }

        /* ─── SCROLL REVEAL ─── */
        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.7s cubic-bezier(0.23, 1, 0.32, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* ─── ANIMATIONS ─── */
        @keyframes fadeSlideDown { from{opacity:0;transform:translateY(-22px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeSlideUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }

        /* ─── RESPONSIVE ─── */
        @media(max-width:1024px){
            .industry-grid { grid-template-columns: repeat(2, 1fr); }
            .module-grid { grid-template-columns: repeat(2, 1fr); }
            .pricing-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
            .instructor-wrap { grid-template-columns: 1fr; }
            .stat-pill { padding: 0 24px; }
        }
        @media(max-width:640px){
            .hero-headline { letter-spacing: -1.5px; }
            .industry-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .module-grid { grid-template-columns: 1fr; }
            .stats-bar-inner { flex-direction: column; gap: 0; }
            .stat-pill { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.06); padding: 20px 0; width: 100%; justify-content: center; }
            .instructor-stats { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<!-- ════════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════ -->
<section class="hero-section">
    <!-- Particle Canvas -->
    <canvas id="hero-canvas"></canvas>

    <!-- Animated grid -->
    <div class="grid-overlay"></div>

    <!-- 3D Floating Shapes -->
    <div class="shapes-layer">
        <!-- Spinning Cube (top-left) -->
        <div class="shape3d cube-wrap" style="position:absolute;">
            <div class="cube">
                <div class="cube-face front"></div>
                <div class="cube-face back"></div>
                <div class="cube-face left"></div>
                <div class="cube-face right"></div>
                <div class="cube-face top"></div>
                <div class="cube-face bottom"></div>
            </div>
        </div>

        <!-- Spinning Ring (top-right) -->
        <div class="shape3d ring-wrap" style="position:absolute;">
            <div class="ring"></div>
        </div>

        <!-- Diamond (bottom-left) -->
        <div class="shape3d diamond-wrap" style="position:absolute;">
            <div class="diamond"></div>
        </div>

        <!-- Pyramid (bottom-right) -->
        <div class="shape3d pyramid-wrap" style="position:absolute;">
            <div class="pyramid"></div>
        </div>

        <!-- Small Glowing Dots -->
        <div class="dot3d" style="position:absolute;width:12px;height:12px;top:25%;left:20%;--dur:4s;--delay:0.5s;opacity:0.6;box-shadow:0 0 14px #ff5500;background:#ff5500;border-radius:50%;"></div>
        <div class="dot3d" style="position:absolute;width:8px;height:8px;top:70%;left:15%;--dur:6s;--delay:1s;opacity:0.5;box-shadow:0 0 10px #00f2fe;background:#00f2fe;border-radius:50%;"></div>
        <div class="dot3d" style="position:absolute;width:10px;height:10px;top:40%;right:18%;--dur:5s;--delay:0s;opacity:0.55;box-shadow:0 0 12px #a855f7;background:#a855f7;border-radius:50%;"></div>
        <div class="dot3d" style="position:absolute;width:6px;height:6px;top:80%;right:22%;--dur:7s;--delay:2s;opacity:0.6;box-shadow:0 0 10px #ff5500;background:#ff5500;border-radius:50%;"></div>

        <!-- Floating text labels (like code snippets) -->
        <div style="position:absolute;top:18%;left:3%;opacity:0.18;font-family:'JetBrains Mono',monospace;font-size:11px;color:#ff5500;animation:floatUpDown 9s ease-in-out infinite;white-space:nowrap;">
            rank_url( "tech support" )<br>
            → position: 1 ✓
        </div>
        <div style="position:absolute;top:60%;right:3%;opacity:0.15;font-family:'JetBrains Mono',monospace;font-size:11px;color:#00f2fe;animation:floatUpDown 7s ease-in-out infinite 1.5s;white-space:nowrap;text-align:right;">
            CTR.boost( 0.38 → 0.74 )<br>
            calls_today: 847
        </div>
    </div>

    <!-- Hero Content -->
    <div class="hero-content">
        <div style="display:flex;justify-content:center;margin-bottom:44px;">
            <div class="hero-badge">
                <div class="badge-dot"></div>
                <span>Live Batch Open — Limited Seats</span>
            </div>
        </div>

        <h1 class="hero-headline">
            <span class="line-orange">Black Hat SEO Course</span>
            <span class="line-white">in Delhi, India</span>
        </h1>

        <div class="typed-wrap">
            Learn to generate <span class="typed-accent">500+ inbound calls/day</span> for tech support, airlines &amp; finance.<br>
            Taught by a <span class="typed-accent">25+ year industry veteran</span> — the #1 underground SEO training in India.<span class="typed-cursor"></span>
        </div>

        <div class="hero-cta-group">
            <a href="#pricing" class="cta-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 10V3L4 14h7v7l9-11h-7z" fill="currentColor" stroke="none"/></svg>
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

        <div class="trust-strip">
            <span>⭐ 4.8/5 Rating</span>
            <span class="trust-sep">|</span>
            <span>📅 Updated Jan 2026</span>
            <span class="trust-sep">|</span>
            <span>🔒 Instant Access</span>
            <span class="trust-sep">|</span>
            <span>🌍 Delhi + Online</span>
            <span class="trust-sep">|</span>
            <span>18,640+ Students</span>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════
     MARQUEE #1 — Orange scrolling ticker
════════════════════════════════════════════ -->
<div class="marquee-section">
    <div style="overflow:hidden;">
        <div class="marquee-track">
            <?php
            $items1 = ["Tech Support Call Gen", "Airlines Call Generation", "QuickBooks Leads", "Crypto Traffic SEO", "High-Velocity Indexing", "CTR Manipulation", "PBN Network Setup", "Parasite SEO", "Cloaking Techniques", "Negative SEO Shield", "Finance Inbound Calls", "Real Estate Leads", "Legal Attorney Calls", "Home Services SEO", "Gaming Traffic"];
            $repeated = array_merge($items1, $items1);
            foreach ($repeated as $item):
            ?>
            <span class="marquee-item">
                <span class="marquee-sep">⚡</span>
                <?php echo $item; ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════
     STATS BAR
════════════════════════════════════════════ -->
<div class="stats-bar">
    <div class="stats-bar-inner">
        <div class="stat-pill reveal">
            <div class="stat-icon">🎓</div>
            <div>
                <div class="stat-num" style="color:#ff5500;" data-count="18640" data-suffix="+">0+</div>
                <div class="stat-lbl">Students Trained Globally</div>
            </div>
        </div>
        <div class="stat-pill reveal reveal-delay-1">
            <div class="stat-icon">💰</div>
            <div>
                <div class="stat-num" style="color:#fbbf24;">₹50Cr+</div>
                <div class="stat-lbl">Call Revenue Generated</div>
            </div>
        </div>
        <div class="stat-pill reveal reveal-delay-2">
            <div class="stat-icon">📅</div>
            <div>
                <div class="stat-num" style="color:#a78bfa;" data-count="25" data-suffix="+">0+</div>
                <div class="stat-lbl">Years Industry Experience</div>
            </div>
        </div>
        <div class="stat-pill reveal reveal-delay-3">
            <div class="stat-icon">📈</div>
            <div>
                <div class="stat-num" style="color:#34d399;" data-count="99" data-suffix=".4%">0%</div>
                <div class="stat-lbl">SERP Domination Rate</div>
            </div>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════
     CRITICAL ALERT
════════════════════════════════════════════ -->
<div class="alert-section">
    <div class="alert-box reveal">
        <span class="alert-icon">⚠️</span>
        <div class="alert-title">Critical Alert</div>
        <p class="alert-text">
            Google has already started tightening policies. <span class="alert-highlight">By Feb 2026, call-driven businesses will face massive restrictions.</span> Is yours at risk? Most call centers are already losing 40–70% of their inbound volume.
        </p>
        <div class="alert-tags">
            <span class="alert-tag tag-r">🔴 High Risk</span>
            <span class="alert-tag tag-o">📉 Urgent Action Needed</span>
            <span class="alert-tag tag-a">⏰ Limited Seats Left</span>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════
     INDUSTRIES
════════════════════════════════════════════ -->
<div style="padding: 100px 0; max-width:1160px; margin:0 auto; padding:100px 24px;">
    <div class="reveal">
        <span class="section-label">Industries We Dominate</span>
        <h2 class="section-h2">Generate Calls From Every<br><span style="color:#ff5500;">High-Intent Niche</span></h2>
        <p class="section-p">Vertical-specific ranking blueprints that route real inbound calls to your center daily.</p>
    </div>

    <div class="industry-grid" style="grid-template-columns:repeat(4,1fr);">
        <?php
        $industries = [
            ["industries/tech-support.php","🎧","Tech Support","Printer, Router & Antivirus Calls","$12-80/call"],
            ["industries/airlines.php","✈️","Airlines & Travel","Flight Booking, Cancellation & Rebooking","$30-120/call"],
            ["industries/finance.php","💰","Finance & Loans","Debt Settlement & Mortgage Calls","$80-400/call"],
            ["industries/insurance.php","🛡️","Insurance","Auto, Health & Medicare Leads","$40-200/call"],
            ["industries/healthcare.php","🏥","Healthcare","Patient Acquisition & Clinic Calls","$50-300/call"],
            ["industries/legal.php","⚖️","Legal & Law","Personal Injury & Attorney Referrals","$150-500/call"],
            ["industries/crypto.php","🪙","Cryptocurrency","Wallet Recovery & Exchange Leads","$100-500/call"],
            ["industries/saas.php","💻","SaaS & B2B","Enterprise Demo & Renewal Calls","$200-2K/deal"],
            ["industries/education.php","🎓","Education","Enrollment & Admissions Calls","$30-150/call"],
            ["industries/home-services.php","🔧","Home Services","HVAC, Plumbing & Roofing Calls","$50-200/call"],
            ["industries/automotive.php","🚗","Automotive","Car Dealer & Warranty Calls","$30-200/call"],
            ["industries/accounting.php","📊","QuickBooks & Acct","Financial Software Support Calls","$50-250/call"],
        ];
        foreach ($industries as $i => $ind):
        ?>
        <a href="<?php echo $ind[0]; ?>" class="ind-card reveal reveal-delay-<?php echo ($i % 4 + 1); ?>">
            <div class="ind-emoji"><?php echo $ind[1]; ?></div>
            <div class="ind-name"><?php echo $ind[2]; ?></div>
            <div class="ind-sub"><?php echo $ind[3]; ?></div>
            <div style="font-family:'JetBrains Mono',monospace;font-size:9px;font-weight:700;color:rgba(255,107,53,0.7);letter-spacing:1px;margin-top:4px;"><?php echo $ind[4]; ?></div>
            <div class="ind-arrow">Learn more →</div>
        </a>
        <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:32px;">
        <a href="industries/index.php" style="display:inline-flex;align-items:center;gap:8px;font-family:'Outfit',sans-serif;font-size:14px;font-weight:600;color:rgba(255,255,255,0.5);text-decoration:none;border:1px solid rgba(255,255,255,0.1);padding:11px 24px;border-radius:100px;transition:all .25s ease;" onmouseover="this.style.color='#fff';this.style.borderColor='rgba(255,255,255,0.25)'" onmouseout="this.style.color='rgba(255,255,255,0.5)';this.style.borderColor='rgba(255,255,255,0.1)'">
            View All 12 Industries →
        </a>
    </div>
</div>

<!-- ════════════════════════════════════════════
     MARQUEE #2 — Teal / reverse direction
════════════════════════════════════════════ -->
<div class="marquee-section" style="background:rgba(0,242,254,0.03);border-color:rgba(0,242,254,0.15);">
    <div style="overflow:hidden;">
        <div class="marquee-track marquee-track-rev">
            <?php
            $items2 = ["18,640+ Students", "₹50Cr+ Revenue Generated", "25+ Years Experience", "99.4% SERP Domination", "Delhi, India", "Online Worldwide", "Live Mentorship", "Recorded Sessions", "Community Forum", "PBN Builds", "Cloaking Blueprints", "CTR SERP Bots", "Call Routing Systems", "Expired Domain Networks", "Tech Support Funnels"];
            $repeated2 = array_merge($items2, $items2);
            foreach ($repeated2 as $item):
            ?>
            <span class="marquee-item" style="color:rgba(0,200,220,0.7);">
                <span style="color:rgba(0,242,254,0.35);font-size:18px;">◆</span>
                <?php echo $item; ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════
     CURRICULUM MODULES
════════════════════════════════════════════ -->
<section class="modules-outer" id="modules">
    <div class="max-w-content" style="max-width:1160px;margin:0 auto;">
        <div class="reveal" style="margin-bottom:52px;">
            <span class="section-label">The Curriculum</span>
            <h2 class="section-h2">8 Advanced Modules That<br><span style="color:#ff5500;">Actually Work</span></h2>
            <p class="section-p">Zero fluff. Battle-tested techniques used by the world's most aggressive SEO operators.</p>
        </div>

        <div class="module-grid">
            <?php
            $modules = [
                ["MODULE 01","⚡","High-Velocity URL Indexing","Force 100,000+ dynamic URLs into Google's index within 24 hours using API pipelines, crawl budget hacking, and GDS sitemaps."],
                ["MODULE 02","📞","Inbound Call Generation","Architect complete inbound phone call funnels for Tech Support, Airlines & Finance targeting ultra-high-intent queries."],
                ["MODULE 03","🤖","CTR SERP Manipulation","Deploy residential proxy search bots to simulate real user behavior, boost CTRs, and rocket organic rankings to Top 3."],
                ["MODULE 04","🧬","Parasite SEO Domination","Leverage high-DA platforms (Medium, LinkedIn, GitHub, Notion) to rank commercial keywords in 24–48 hours with zero domain age."],
                ["MODULE 05","🌐","PBN & Expired Domain Network","Build footprint-free Private Blog Networks with WHOIS obfuscation, diverse IP classes, and high-DA expired domain insertion."],
                ["MODULE 06","🔒","Technical Cloaking","User-agent & IP-based redirection — serve Google-compliant pages to crawlers while showing high-converting funnels to real visitors."],
            ];
            foreach ($modules as $i => $m):
            ?>
            <div class="mod-card reveal reveal-delay-<?php echo ($i % 3 + 1); ?>">
                <span class="mod-num"><?php echo $m[0]; ?></span>
                <div class="mod-icon-wrap"><?php echo $m[1]; ?></div>
                <div class="mod-title"><?php echo $m[2]; ?></div>
                <div class="mod-desc"><?php echo $m[3]; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════
     MARQUEE #3 — Fast moving keywords strip
════════════════════════════════════════════ -->
<div class="marquee-section" style="background:rgba(168,85,247,0.04);border-color:rgba(168,85,247,0.2);">
    <div style="overflow:hidden;">
        <div class="marquee-track" style="animation-duration:18s;">
            <?php
            $items3 = ["#1 SERP RANKING", "GOOGLE DOMINATION", "INBOUND CALL MACHINE", "DELHI'S BEST SEO COURSE", "CTR MANIPULATION", "PBN MASTERY", "BLACK HAT TECHNIQUES", "CALL CENTER SCALING", "TECH SUPPORT LEADS", "AIRLINE CALL GEN", "CRYPTO TRAFFIC", "PARASITE SEO", "HIGH VELOCITY INDEXING"];
            $repeated3 = array_merge($items3, $items3);
            foreach ($repeated3 as $item):
            ?>
            <span class="marquee-item" style="color:rgba(180,120,255,0.75);font-size:13px;letter-spacing:2px;">
                <span style="color:rgba(168,85,247,0.4);">★</span>
                <?php echo $item; ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════
     PRICING
════════════════════════════════════════════ -->
<section class="pricing-outer" id="pricing">
    <div class="reveal" style="text-align:center;margin-bottom:56px;">
        <span class="section-label" style="display:block;">Enrollment</span>
        <h2 class="section-h2">Choose Your <span style="color:#ff5500;">Training Package</span></h2>
    </div>

    <div class="pricing-grid">
        <div class="price-card reveal">
            <div class="price-tier">Starter Pack</div>
            <div class="price-amount" style="color:#fff;">₹9,999</div>
            <p class="price-desc">Core Black Hat SEO techniques for beginners ready to rank fast.</p>
            <div class="price-divider"></div>
            <ul class="price-features">
                <li><span class="pf-check" style="color:#ff6b35;">✓</span> High-Velocity Indexing Blueprint</li>
                <li><span class="pf-check" style="color:#ff6b35;">✓</span> Parasite SEO & Web 2.0 Setup</li>
                <li><span class="pf-check" style="color:#ff6b35;">✓</span> Basic CTR Manipulation Scripts</li>
                <li><span class="pf-check" style="color:#ff6b35;">✓</span> Community Forum Access</li>
                <li><span class="pf-check" style="color:#ff6b35;">✓</span> Lifetime Recorded Sessions</li>
            </ul>
            <a href="register.php" class="price-btn pb-outline">Get Started →</a>
        </div>

        <div class="price-card featured reveal reveal-delay-2">
            <div class="price-tier">Call Gen Masterclass</div>
            <div class="price-amount" style="color:#ff5500;">₹24,999</div>
            <p class="price-desc">The complete inbound call system for tech support, airlines & finance.</p>
            <div class="price-divider"></div>
            <ul class="price-features">
                <li><span class="pf-check" style="color:#ff5500;">✓</span> Everything in Starter Pack</li>
                <li><span class="pf-check" style="color:#ff5500;">✓</span> Tech Support Call Routing Blueprint</li>
                <li><span class="pf-check" style="color:#ff5500;">✓</span> Airlines & Finance Call Funnels</li>
                <li><span class="pf-check" style="color:#ff5500;">✓</span> Technical Cloaking Full Module</li>
                <li><span class="pf-check" style="color:#ff5500;">✓</span> CTR SERP Bot Suite License</li>
                <li><span class="pf-check" style="color:#ff5500;">✓</span> PBN Network Setup Walkthrough</li>
                <li><span class="pf-check" style="color:#ff5500;">✓</span> 3 Months Group Support</li>
            </ul>
            <a href="register.php" class="price-btn pb-orange">Enroll Now →</a>
        </div>

        <div class="price-card reveal reveal-delay-3">
            <div class="price-tier">VIP Mentorship</div>
            <div class="price-amount" style="color:#00f2fe;">₹49,999</div>
            <p class="price-desc">1-on-1 with Suresh Das. Custom PBN build. Direct call center scaling.</p>
            <div class="price-divider"></div>
            <ul class="price-features">
                <li><span class="pf-check" style="color:#00f2fe;">✓</span> Everything in Call Gen Masterclass</li>
                <li><span class="pf-check" style="color:#00f2fe;">✓</span> Private 1-on-1 Sessions (Suresh Das)</li>
                <li><span class="pf-check" style="color:#00f2fe;">✓</span> Custom Footprint-Free PBN Build</li>
                <li><span class="pf-check" style="color:#00f2fe;">✓</span> Dedicated Call Center Scaling Plan</li>
                <li><span class="pf-check" style="color:#00f2fe;">✓</span> 24/7 Priority Emergency Support</li>
                <li><span class="pf-check" style="color:#00f2fe;">✓</span> 6 Months Ongoing Guidance</li>
            </ul>
            <a href="contact.php" class="price-btn pb-teal">Apply for VIP →</a>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════
     INSTRUCTOR
════════════════════════════════════════════ -->
<section class="instructor-outer" id="expert">
    <div class="instructor-wrap">
        <div class="instructor-avatar reveal">
            <div class="instructor-initial">SD</div>
            <div class="instructor-name-lrg">Suresh Das</div>
            <div class="instructor-tag-sm">25+ Years · Delhi, India</div>
        </div>

        <div class="reveal reveal-delay-2">
            <span class="section-label">The Expert Behind the Course</span>
            <h2 class="section-h2" style="margin-bottom:20px;">India's Most Feared<br><span style="color:#ff5500;">Black Hat SEO Trainer</span></h2>
            <p class="instructor-bio">
                Suresh Das has spent 25+ years in the trenches of competitive search — building, breaking, and rebuilding ranking systems before Google had algorithms sophisticated enough to detect them. He has trained over 18,000 marketers, call center owners, and SEO agencies across India and internationally.
            </p>
            <p class="instructor-bio" style="margin-bottom:32px;">
                Unlike theoretical trainers, Suresh runs live call generation operations himself — meaning everything taught is actively working in the real world today.
            </p>
            <div class="instructor-stats">
                <div class="istat">
                    <div class="istat-num" data-count="18" data-suffix="K+">0+</div>
                    <div class="istat-text">Students Trained</div>
                </div>
                <div class="istat">
                    <div class="istat-num" data-count="25" data-suffix="+">0+</div>
                    <div class="istat-text">Years Experience</div>
                </div>
                <div class="istat">
                    <div class="istat-num">₹50Cr</div>
                    <div class="istat-text">Revenue Generated</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════
     FAQ
════════════════════════════════════════════ -->
<section class="faq-outer">
    <div style="text-align:center;margin-bottom:52px;" class="reveal">
        <span class="section-label" style="display:block;">FAQ</span>
        <h2 class="section-h2">Frequently Asked <span style="color:#ff5500;">Questions</span></h2>
    </div>
    <div class="faq-wrap">
        <?php
        $faqs = [
            ["What exactly is the Black Hat SEO Course?", "An advanced SEO training program covering aggressive ranking techniques, high-velocity indexing, CTR manipulation, PBN networks, and inbound call generation systems — all with live real-world demonstrations."],
            ["Does this course teach tech support call generation?", "Yes — this is a core module. You'll learn to rank for printer, router, antivirus, and software support keywords and route real inbound calls to your call center using cloaking and funnel architecture."],
            ["Is prior SEO experience required?", "Basic familiarity helps, but motivated beginners can follow along — the course is structured step-by-step with hands-on practical demonstrations from absolute scratch."],
            ["Is this course available online or only in Delhi?", "Both. Live batches are held in Delhi NCR, and the full course is also available online with recorded sessions, live Q&A calls, and community forum support."],
            ["Can call center owners benefit from this course?", "Absolutely — this was specifically designed for call center owners who want to stop depending on lead buyers and generate their own high-intent inbound call flow using organic search domination."],
        ];
        foreach ($faqs as $i => $faq):
        ?>
        <div class="faq-item reveal reveal-delay-<?php echo ($i % 3 + 1); ?> <?php echo $i === 0 ? 'open' : ''; ?>">
            <button class="faq-q">
                <span><?php echo $faq[0]; ?></span>
                <div class="faq-icon">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                </div>
            </button>
            <div class="faq-a"><?php echo $faq[1]; ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ════════════════════════════════════════════
     FINAL CTA
════════════════════════════════════════════ -->
<section class="final-cta reveal">
    <span class="section-label" style="display:block;margin-bottom:16px;">Don't Wait</span>
    <h2 class="final-h">Stop Buying Leads.<br><span style="color:#ff5500;">Start Generating Them.</span></h2>
    <p class="final-sub">Join 18,640+ marketers and call center owners who have taken control of their inbound call flow.</p>
    <div class="final-btns">
        <a href="register.php" class="cta-primary" style="font-size:16px;padding:17px 42px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Enroll in BlackHat SEO Course
        </a>
        <a href="contact.php" class="cta-secondary" style="font-size:16px;padding:16px 34px;">Talk to Us First →</a>
    </div>
</section>

<!-- ════ FLOATING WHATSAPP ════ -->
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
// ══════════════════════════════════════════
// CANVAS PARTICLE SYSTEM
// ══════════════════════════════════════════
(function() {
    const canvas = document.getElementById('hero-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let W, H, particles = [];

    function resize() {
        W = canvas.width = canvas.parentElement.offsetWidth;
        H = canvas.height = canvas.parentElement.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const COUNT = 80;
    for (let i = 0; i < COUNT; i++) {
        particles.push({
            x: Math.random() * 1920,
            y: Math.random() * 1080,
            r: Math.random() * 1.8 + 0.3,
            vx: (Math.random() - 0.5) * 0.4,
            vy: (Math.random() - 0.5) * 0.4,
            alpha: Math.random() * 0.6 + 0.1,
            color: Math.random() > 0.7 ? '#00f2fe' : Math.random() > 0.5 ? '#a855f7' : '#ff5500',
        });
    }

    let mouse = { x: -999, y: -999 };
    canvas.parentElement.addEventListener('mousemove', e => {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });

    function draw() {
        ctx.clearRect(0, 0, W, H);

        // Connect nearby particles
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(255,85,0,${0.08 * (1 - dist / 120)})`;
                    ctx.lineWidth = 0.5;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }

        particles.forEach(p => {
            // Mouse repel
            const mdx = p.x - mouse.x;
            const mdy = p.y - mouse.y;
            const mdist = Math.sqrt(mdx * mdx + mdy * mdy);
            if (mdist < 100) {
                p.x += (mdx / mdist) * 1.5;
                p.y += (mdy / mdist) * 1.5;
            }

            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0) p.x = W;
            if (p.x > W) p.x = 0;
            if (p.y < 0) p.y = H;
            if (p.y > H) p.y = 0;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = p.color.replace(')', `,${p.alpha})`).replace('rgb', 'rgba');
            if (p.color.startsWith('#')) {
                ctx.fillStyle = p.color;
                ctx.globalAlpha = p.alpha;
            }
            ctx.fill();
            ctx.globalAlpha = 1;
        });

        requestAnimationFrame(draw);
    }
    draw();
})();

// ══════════════════════════════════════════
// 3D TILT ON HOVER (Cards)
// ══════════════════════════════════════════
document.querySelectorAll('.ind-card, .mod-card, .price-card, .istat').forEach(card => {
    card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const cx = rect.width / 2;
        const cy = rect.height / 2;
        const rx = ((y - cy) / cy) * 8;
        const ry = ((x - cx) / cx) * -8;
        card.style.transform = `perspective(700px) rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = '';
        card.style.transition = 'transform 0.4s ease';
    });
});

// ══════════════════════════════════════════
// SCROLL REVEAL
// ══════════════════════════════════════════
const revealEls = document.querySelectorAll('.reveal');
const revealObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObs.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });
revealEls.forEach(el => revealObs.observe(el));

// ══════════════════════════════════════════
// COUNTER ANIMATION
// ══════════════════════════════════════════
function animateCount(el) {
    const target = parseInt(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    let start = 0;
    const duration = 1800;
    const step = (timestamp) => {
        if (!start) start = timestamp;
        const progress = Math.min((timestamp - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.floor(eased * target).toLocaleString() + suffix;
        if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
}

const counterObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && entry.target.dataset.count) {
            animateCount(entry.target);
            counterObs.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-count]').forEach(el => counterObs.observe(el));

// ══════════════════════════════════════════
// TYPED TEXT EFFECT
// ══════════════════════════════════════════
(function() {
    const phrases = [
        "500+ inbound calls/day for tech support, airlines & finance.",
        "Google Page 1 rankings in 24 hours — guaranteed methods.",
        "high-intent callers routed directly to your call center.",
        "PBN networks, CTR bots & parasite SEO that actually works.",
    ];
    const el = document.querySelector('.typed-accent');
    if (!el) return;
    let pi = 0, ci = 0, deleting = false;

    function tick() {
        const phrase = phrases[pi];
        if (!deleting) {
            el.textContent = phrase.substring(0, ci + 1);
            ci++;
            if (ci === phrase.length) { deleting = true; setTimeout(tick, 2000); return; }
        } else {
            el.textContent = phrase.substring(0, ci - 1);
            ci--;
            if (ci === 0) { deleting = false; pi = (pi + 1) % phrases.length; }
        }
        setTimeout(tick, deleting ? 30 : 55);
    }
    tick();
})();

// ══════════════════════════════════════════
// PARALLAX ORBS ON SCROLL
// ══════════════════════════════════════════
const cube = document.querySelector('.cube-wrap');
const ring = document.querySelector('.ring-wrap');
window.addEventListener('scroll', () => {
    const sy = window.scrollY;
    if (cube) cube.style.transform = `translateY(${sy * 0.18}px)`;
    if (ring) ring.style.transform = `translateY(${sy * -0.12}px)`;
});

// ══════════════════════════════════════════
// FAQ ACCORDION
// ══════════════════════════════════════════
document.querySelectorAll('.faq-q').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.closest('.faq-item');
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
    });
});
</script>
</body>
</html>