<?php
require_once 'functions.php';
$cart_count = count(get_cart_items($pdo));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - QuickProject | India's Premier Lead Marketplace</title>
    <meta name="description"
        content="QuickProject is India's premier marketplace for high-intent web development leads. Powered by Viral Verse Media, we connect developers with verified clients ready to pay.">
    <link rel="stylesheet" href="style.css">
    <style>
        /* ═══════════════════════════════════════════════════
           ABOUT PAGE — PREMIUM IMMERSIVE DESIGN
           ═══════════════════════════════════════════════════ */

        /* ─── HERO - LIGHT ─── */
        .about-hero {
            position: relative;
            padding: 100px 0 80px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0f2fe 100%);
            overflow: hidden;
            text-align: center;
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        }

        .about-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 600px 400px at 20% 50%, rgba(37, 99, 235, 0.08), transparent),
                radial-gradient(ellipse 500px 350px at 80% 30%, rgba(124, 58, 237, 0.06), transparent),
                radial-gradient(ellipse 400px 300px at 50% 80%, rgba(6, 182, 212, 0.06), transparent);
            animation: heroGlow 8s ease-in-out infinite alternate;
        }

        @keyframes heroGlow {
            0% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        /* Animated grid pattern */
        .about-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(37, 99, 235, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, black 30%, transparent 70%);
        }

        .about-hero .container {
            position: relative;
            z-index: 2;
        }

        .about-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(37, 99, 235, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.15);
            border-radius: 100px;
            padding: 8px 20px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 28px;
            backdrop-filter: blur(10px);
            letter-spacing: 0.5px;
        }

        .about-hero-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #3b82f6;
            box-shadow: 0 0 8px rgba(59, 130, 246, 0.4);
            animation: badgePulse 2s ease-in-out infinite;
        }

        @keyframes badgePulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(0.8);
            }
        }

        .about-hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #1e3a5f;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -0.03em;
        }

        .about-hero h1 span {
            background: linear-gradient(135deg, #2563eb, #7c3aed, #0891b2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-hero-subtitle {
            font-size: 1.15rem;
            color: #64748b;
            max-width: 700px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }

        .about-hero-subtitle strong {
            color: #334155;
        }

        /* Floating stats in hero */
        .about-hero-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .about-hero-stat {
            text-align: center;
            padding: 20px 28px;
            background: white;
            border: 1px solid rgba(37, 99, 235, 0.15);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            min-width: 140px;
            transition: all 0.4s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .about-hero-stat:hover {
            background: #f0f7ff;
            border-color: rgba(37, 99, 235, 0.3);
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.1);
        }

        .about-hero-stat-value {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
        }

        .about-hero-stat-label {
            font-size: 0.82rem;
            color: #64748b;
            font-weight: 500;
            margin-top: 4px;
        }

        /* ─── WHO WE ARE ─── */
        .about-who {
            padding: 90px 0;
            background: linear-gradient(180deg, #fdfbf7, #f8f6f0);
            position: relative;
        }

        .about-who-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-who-visual {
            position: relative;
        }

        .about-who-card {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 50%, #0891b2 100%);
            border-radius: 24px;
            padding: 50px 40px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.25);
        }

        .about-who-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .about-who-card::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .about-who-card-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
            position: relative;
            z-index: 1;
        }

        .about-who-card h3 {
            font-size: 1.6rem;
            color: white;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .about-who-card p {
            font-size: 1rem;
            line-height: 1.75;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Floating accent card */
        .about-who-accent {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: white;
            border-radius: 16px;
            padding: 18px 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 3;
            animation: floatAccent 3s ease-in-out infinite;
        }

        @keyframes floatAccent {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .about-who-accent-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #059669, #10b981);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .about-who-accent-text strong {
            display: block;
            font-size: 0.95rem;
            color: #0f172a;
        }

        .about-who-accent-text span {
            font-size: 0.78rem;
            color: #64748b;
        }

        .about-who-content h2 {
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            color: #0f172a;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .about-who-content h2 span {
            color: #2563eb;
        }

        .about-who-content>p {
            font-size: 1.05rem;
            color: #475569;
            line-height: 1.8;
            margin-bottom: 16px;
        }

        .about-who-highlight {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.06), rgba(124, 58, 237, 0.04));
            border-left: 4px solid #2563eb;
            border-radius: 0 12px 12px 0;
            padding: 18px 24px;
            margin-top: 24px;
            font-size: 0.95rem;
            color: #334155;
            line-height: 1.7;
        }

        .about-who-highlight strong {
            color: #1e40af;
        }

        /* ─── DIFFERENTIATORS ─── */
        .about-diff {
            padding: 90px 0;
            background: linear-gradient(180deg, #f8f6f0 0%, #fdfbf7 100%);
            position: relative;
        }

        .about-diff-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .about-diff-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #2563eb;
            margin-bottom: 14px;
        }

        .about-diff-label::before,
        .about-diff-label::after {
            content: '';
            width: 24px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #2563eb);
            border-radius: 2px;
        }

        .about-diff-label::after {
            background: linear-gradient(90deg, #2563eb, transparent);
        }

        .about-diff-header h2 {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            color: #0f172a;
            margin-bottom: 12px;
        }

        .about-diff-header h2 span {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-diff-header p {
            font-size: 1.05rem;
            color: #64748b;
            max-width: 560px;
            margin: 0 auto;
        }

        .about-diff-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .about-diff-card {
            background: white;
            border-radius: 20px;
            padding: 36px 32px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .about-diff-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 20px 20px 0 0;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .about-diff-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            border-color: transparent;
        }

        .about-diff-card:hover::before {
            opacity: 1;
        }

        .about-diff-card:nth-child(1)::before {
            background: linear-gradient(90deg, #2563eb, #3b82f6);
        }

        .about-diff-card:nth-child(2)::before {
            background: linear-gradient(90deg, #7c3aed, #8b5cf6);
        }

        .about-diff-card:nth-child(3)::before {
            background: linear-gradient(90deg, #059669, #10b981);
        }

        .about-diff-card:nth-child(4)::before {
            background: linear-gradient(90deg, #d97706, #f59e0b);
        }

        .about-diff-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
            position: relative;
        }

        .about-diff-card:nth-child(1) .about-diff-icon {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.05));
            color: #2563eb;
        }

        .about-diff-card:nth-child(2) .about-diff-icon {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(139, 92, 246, 0.05));
            color: #7c3aed;
        }

        .about-diff-card:nth-child(3) .about-diff-icon {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.1), rgba(16, 185, 129, 0.05));
            color: #059669;
        }

        .about-diff-card:nth-child(4) .about-diff-icon {
            background: linear-gradient(135deg, rgba(217, 119, 6, 0.1), rgba(245, 158, 11, 0.05));
            color: #d97706;
        }

        .about-diff-icon svg {
            width: 28px;
            height: 28px;
        }

        .about-diff-card h3 {
            font-size: 1.2rem;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .about-diff-card p {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.7;
        }

        /* ─── MISSION - LIGHT ─── */
        .about-mission {
            padding: 90px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            position: relative;
            overflow: hidden;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .about-mission::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 500px 300px at 30% 60%, rgba(37, 99, 235, 0.06), transparent),
                radial-gradient(ellipse 400px 250px at 70% 40%, rgba(124, 58, 237, 0.04), transparent);
        }

        .about-mission .container {
            position: relative;
            z-index: 1;
        }

        .about-mission-inner {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .about-mission-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 28px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(124, 58, 237, 0.08));
            border: 1px solid rgba(37, 99, 235, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            backdrop-filter: blur(10px);
        }

        .about-mission h2 {
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            color: #1e3a5f;
            margin-bottom: 24px;
        }

        .about-mission h2 span {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-mission p {
            font-size: 1.1rem;
            color: #64748b;
            line-height: 1.85;
            margin-bottom: 16px;
        }

        .about-mission-values {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 36px;
            flex-wrap: wrap;
        }

        .about-mission-value {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 100px;
            font-size: 0.88rem;
            color: #475569;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .about-mission-value:hover {
            background: #f0f7ff;
            border-color: rgba(37, 99, 235, 0.3);
            color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }

        .about-mission-value-icon {
            font-size: 1.1rem;
        }

        /* ─── POWERED BY ─── */
        .about-powered {
            padding: 80px 0;
            background: linear-gradient(180deg, #fdfbf7, #f8f6f0);
        }

        .about-powered-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-powered-content h2 {
            font-size: clamp(1.6rem, 2.5vw, 2.2rem);
            color: #0f172a;
            margin-bottom: 18px;
        }

        .about-powered-content h2 span {
            color: #2563eb;
        }

        .about-powered-content p {
            font-size: 1rem;
            color: #475569;
            line-height: 1.8;
            margin-bottom: 14px;
        }

        .about-powered-features {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .about-powered-feat {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 18px 22px;
            background: white;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .about-powered-feat:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transform: translateX(6px);
        }

        .about-powered-feat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .about-powered-feat:nth-child(1) .about-powered-feat-icon {
            background: rgba(37, 99, 235, 0.1);
        }

        .about-powered-feat:nth-child(2) .about-powered-feat-icon {
            background: rgba(5, 150, 105, 0.1);
        }

        .about-powered-feat:nth-child(3) .about-powered-feat-icon {
            background: rgba(217, 119, 6, 0.1);
        }

        .about-powered-feat-text strong {
            display: block;
            font-size: 0.95rem;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .about-powered-feat-text span {
            font-size: 0.88rem;
            color: #64748b;
            line-height: 1.5;
        }

        /* ─── CTA ─── */
        .about-cta {
            padding: 80px 0;
            background: linear-gradient(180deg, #f8f6f0 0%, #fdfbf7 100%);
        }

        .about-cta-card {
            background: linear-gradient(135deg, #1e40af, #2563eb, #0891b2);
            border-radius: 28px;
            padding: 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.25);
        }

        .about-cta-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle 300px at 20% 50%, rgba(255, 255, 255, 0.1), transparent),
                radial-gradient(circle 250px at 80% 50%, rgba(255, 255, 255, 0.08), transparent);
        }

        .about-cta-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .about-cta-card>* {
            position: relative;
            z-index: 1;
        }

        .about-cta-tagline {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 16px;
        }

        .about-cta-card h2 {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            color: white;
            margin-bottom: 14px;
        }

        .about-cta-card p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            max-width: 500px;
            margin: 0 auto 32px;
            line-height: 1.7;
        }

        .about-cta-buttons {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .about-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .about-cta-btn-primary {
            background: white;
            color: #1e40af;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .about-cta-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: #1e40af;
        }

        .about-cta-btn-ghost {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .about-cta-btn-ghost:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: white;
        }

        .about-cta-btn svg {
            width: 18px;
            height: 18px;
        }

        /* Bottom tagline */
        .about-cta-footer {
            margin-top: 36px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .about-cta-slogan {
            font-family: 'Poppins', sans-serif;
            font-size: 1.05rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 0.5px;
        }

        .about-cta-slogan strong {
            color: white;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 900px) {
            .about-who-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .about-who-accent {
                position: relative;
                bottom: 0;
                right: 0;
                margin-top: 16px;
                display: inline-flex;
            }

            .about-diff-grid {
                grid-template-columns: 1fr;
            }

            .about-powered-inner {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .about-cta-card {
                padding: 40px 24px;
            }
        }

        @media (max-width: 600px) {
            .about-hero {
                padding: 70px 0 50px;
            }

            .about-hero-stats {
                gap: 16px;
            }

            .about-hero-stat {
                min-width: 110px;
                padding: 14px 18px;
            }

            .about-hero-stat-value {
                font-size: 1.5rem;
            }

            .about-who-card {
                padding: 32px 24px;
            }

            .about-diff-card {
                padding: 28px 24px;
            }

            .about-mission-values {
                gap: 10px;
            }

            .about-mission-value {
                padding: 8px 16px;
                font-size: 0.82rem;
            }
        }

        /* ─── ANIMATIONS ─── */
        .anim-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .anim-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .anim-in-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .anim-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .anim-in-right {
            opacity: 0;
            transform: translateX(40px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .anim-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- ═══════ HERO ═══════ -->
    <section class="about-hero">
        <div class="container">
            <div class="about-hero-badge">
                <span class="about-hero-badge-dot"></span>
                About QuickProject
            </div>
            <h1>Fueling the Growth of<br><span>Tech Agencies & Freelancers</span></h1>
            <p class="about-hero-subtitle">
                Welcome to <strong>QuickProject</strong>, India's premier marketplace for high-intent web development
                leads. Born from the digital expertise of <strong>Viral Verse Media</strong>, we understand the biggest
                challenge every developer faces: <em>Finding quality clients who are ready to pay.</em>
            </p>
            <div class="about-hero-stats">
                <div class="about-hero-stat">
                    <span class="about-hero-stat-value">500+</span>
                    <span class="about-hero-stat-label">Leads Delivered</span>
                </div>
                <div class="about-hero-stat">
                    <span class="about-hero-stat-value">1,000+</span>
                    <span class="about-hero-stat-label">Happy Developers</span>
                </div>
                <div class="about-hero-stat">
                    <span class="about-hero-stat-value">₹50L+</span>
                    <span class="about-hero-stat-label">Deals Closed</span>
                </div>
                <div class="about-hero-stat">
                    <span class="about-hero-stat-value">4.9★</span>
                    <span class="about-hero-stat-label">Average Rating</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ WHO WE ARE ═══════ -->
    <section class="about-who">
        <div class="container">
            <div class="about-who-grid">
                <div class="about-who-visual anim-in-left">
                    <div class="about-who-card">
                        <span class="about-who-card-icon">🌉</span>
                        <h3>Bridging the Gap</h3>
                        <p>We connect businesses looking for professional web solutions with talented developers looking
                            for their next big project. We don't just provide data — we provide <strong>real
                                opportunities</strong>.</p>
                    </div>
                    <div class="about-who-accent">
                        <div class="about-who-accent-icon">🚀</div>
                        <div class="about-who-accent-text">
                            <strong>Powered by Expertise</strong>
                            <span>By Viral Verse Media</span>
                        </div>
                    </div>
                </div>

                <div class="about-who-content anim-in-right">
                    <h2>Who <span>We Are</span></h2>
                    <p>At QuickProject, we bridge the gap between businesses looking for professional web solutions and
                        talented developers looking for their next big project.</p>
                    <p>We don't just provide data; we provide opportunities. Our team uses advanced digital marketing
                        strategies to capture and verify leads, ensuring that you spend less time <em>"hunting"</em> for
                        work and more time <em>"building"</em> great products.</p>

                    <div class="about-who-highlight">
                        <strong>Our Promise:</strong> Every lead is captured through targeted digital campaigns,
                        verified
                        via OTP and manual checks, and delivered exclusively to you — so you can focus on what you do
                        best.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ WHAT MAKES US DIFFERENT ═══════ -->
    <section class="about-diff">
        <div class="container">
            <div class="about-diff-header anim-in">
                <div class="about-diff-label">Our Edge</div>
                <h2>What Makes Us <span>Different</span></h2>
                <p>We're not just another directory — we're your unfair advantage in winning clients.</p>
            </div>

            <div class="about-diff-grid">
                <div class="about-diff-card anim-in">
                    <div class="about-diff-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                    <h3>Verified High-Intent Leads</h3>
                    <p>Every lead on our platform is verified through OTP and manual checks to ensure you get active
                        phone numbers and real requirements. No junk data, no wasted time.</p>
                </div>

                <div class="about-diff-card anim-in">
                    <div class="about-diff-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                    </div>
                    <h3>Exclusive Access</h3>
                    <p>Unlike generic directories, our leads are sold on a first-come, first-serve basis. Once you buy a
                        lead, it's yours exclusively — no more bidding wars with 20 other people.</p>
                </div>

                <div class="about-diff-card anim-in">
                    <div class="about-diff-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                        </svg>
                    </div>
                    <h3>Transparent Budgeting</h3>
                    <p>We categorize leads into Basic (₹15k+), Business (₹30k+), and Premium (₹50k+) tiers so you can
                        choose projects that fit your agency's scale and ambition.</p>
                </div>

                <div class="about-diff-card anim-in">
                    <div class="about-diff-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                    </div>
                    <h3>Powered by Expertise</h3>
                    <p>Backed by Viral Verse Media, we leverage years of SEO and performance marketing experience to
                        generate the best inquiries in the Indian market.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ MISSION ═══════ -->
    <section class="about-mission">
        <div class="container">
            <div class="about-mission-inner anim-in">
                <div class="about-mission-icon">🎯</div>
                <h2>Our <span>Mission</span></h2>
                <p>Our mission is to empower the Indian developer community by providing a transparent, automated, and
                    reliable lead-generation ecosystem.</p>
                <p>We believe that every skilled developer deserves a steady pipeline of projects without the stress of
                    cold-calling or expensive ad campaigns. QuickProject exists to level the playing field.</p>
                <div class="about-mission-values">
                    <span class="about-mission-value">
                        <span class="about-mission-value-icon">🔍</span> Transparency
                    </span>
                    <span class="about-mission-value">
                        <span class="about-mission-value-icon">⚡</span> Automation
                    </span>
                    <span class="about-mission-value">
                        <span class="about-mission-value-icon">🛡️</span> Reliability
                    </span>
                    <span class="about-mission-value">
                        <span class="about-mission-value-icon">🤝</span> Trust
                    </span>
                    <span class="about-mission-value">
                        <span class="about-mission-value-icon">📈</span> Growth
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ POWERED BY ═══════ -->
    <section class="about-powered">
        <div class="container">
            <div class="about-powered-inner">
                <div class="about-powered-content anim-in-left">
                    <h2>Powered by <span>Viral Verse Media</span></h2>
                    <p>QuickProject is a product of Viral Verse Media — a digital marketing company specializing in
                        high-performance lead generation, SEO, and paid media campaigns.</p>
                    <p>With years of experience in capturing and converting online traffic, we bring the same expertise
                        to the developer ecosystem, ensuring every lead on our platform is a genuine business
                        opportunity.</p>
                </div>
                <div class="about-powered-features anim-in-right">
                    <div class="about-powered-feat">
                        <div class="about-powered-feat-icon">🎯</div>
                        <div class="about-powered-feat-text">
                            <strong>Targeted Campaigns</strong>
                            <span>Leads generated through precision-targeted digital marketing campaigns</span>
                        </div>
                    </div>
                    <div class="about-powered-feat">
                        <div class="about-powered-feat-icon">✅</div>
                        <div class="about-powered-feat-text">
                            <strong>Multi-Step Verification</strong>
                            <span>OTP verification + manual quality checks for every single lead</span>
                        </div>
                    </div>
                    <div class="about-powered-feat">
                        <div class="about-powered-feat-icon">📊</div>
                        <div class="about-powered-feat-text">
                            <strong>Data-Driven Optimization</strong>
                            <span>Continuously improving lead quality through analytics & feedback loops</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ CTA ═══════ -->
    <section class="about-cta">
        <div class="container">
            <div class="about-cta-card anim-in">
                <div class="about-cta-tagline">Connect With Us</div>
                <h2>Ready to Scale Your Business?</h2>
                <p>Whether you are a solo freelancer or a growing digital agency, QuickProject is built to help you
                    scale. Stop searching for clients and start closing deals.</p>
                <div class="about-cta-buttons">
                    <a href="available_leads" class="about-cta-btn about-cta-btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        Browse Leads
                    </a>
                    <a href="contact" class="about-cta-btn about-cta-btn-ghost">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        Get in Touch
                    </a>
                </div>
                <div class="about-cta-footer">
                    <p class="about-cta-slogan"><strong>QuickProject</strong> — Fast Leads. Fresh Opportunities. Real
                        Growth.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Scroll Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const animElements = document.querySelectorAll('.anim-in, .anim-in-left, .anim-in-right');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        // Stagger animations for cards in the same section
                        const delay = entry.target.closest('.about-diff-grid')
                            ? Array.from(entry.target.parentElement.children).indexOf(entry.target) * 120
                            : 0;
                        setTimeout(() => {
                            entry.target.classList.add('visible');
                        }, delay);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: '0px 0px -40px 0px'
            });

            animElements.forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>