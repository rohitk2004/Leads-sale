<?php
require_once 'functions.php';

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $lead_id = $_POST['lead_id'];
    add_to_cart($pdo, $lead_id);
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
    <title>Black Hat SEO Course Delhi, India | Learn Tech Support Call Generation Training by 25+ Years Industry Expert</title>
    <meta name="description" content="Join the Black Hat SEO Course in Delhi, India, led by a 25+ years industry expert. Learn advanced SEO techniques, aggressive ranking strategies, traffic generation methods, and real-world SEO experiments.">
    <meta name="keywords" content="Black Hat SEO Course, Black Hat SEO Training, Advanced SEO Techniques, Tech Support Call Generation, SEO Traffic Course, Ranking Methods, Suresh Das">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- HERO SECTION (EXACTLY MATCHING SCREENSHOT DESIGN) -->
    <section class="hero">
        <div class="hero-glow-amber"></div>

        <div class="container">
            <!-- Small Wakeup Badge -->
            <div class="hero-wake-badge">
                <span>🚨 FINAL WAKE-UP CALL</span>
            </div>

            <!-- NEON GLOWING BOX FROM SCREENSHOT -->
            <div class="hero-glowing-box">
                <span class="hero-box-title-orange">Black Hat SEO Course</span>
                <span class="hero-box-title-white">in Delhi, India</span>
            </div>

            <!-- Subtitle Below Box -->
            <h2 class="hero-headline-sub">
                Learn Advanced Call-Generation & Survival SEO in 30 Days — Before Your Business Dies
            </h2>

            <!-- Paragraph -->
            <p class="hero-description-main">
                Google Ads bans, silent account throttling, and rising PPC costs are destroying call-driven businesses. This intensive program teaches you to generate calls, dominate SERPs, and protect your revenue when traditional marketing fails.
            </p>

            <div class="hero-ctas" style="justify-content: center; display: flex; gap: 16px; margin-bottom: 50px;">
                <a href="#pricing" class="btn-primary" style="padding: 14px 36px; font-size: 16px;">
                    <span>Enroll in 30-Day Program</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="#expert" class="btn-outline" style="padding: 14px 28px; font-size: 16px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                    <span>Meet 25+ Yrs Expert</span>
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="hero-stats-grid">
                <div class="stat-item">
                    <div class="stat-value" style="color: var(--teal);">18,640+</div>
                    <div class="stat-label">Students Trained</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" style="color: #ff6b35;">₹50Cr+</div>
                    <div class="stat-label">Call Value Generated</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" style="color: var(--purple);">25+ Yrs</div>
                    <div class="stat-label">Industry Expertise</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" style="color: var(--emerald);">99.4%</div>
                    <div class="stat-label">SERP Domination Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating WhatsApp CTA (From Screenshot) -->
    <a href="https://wa.me/919811002233?text=Hi,%20I%20am%20interested%20in%20BlackHat%20SEO%20Course" target="_blank" class="whatsapp-float-btn">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
        <span>WhatsApp Now</span>
    </a>

    <!-- INDUSTRY VERTICALS SECTION -->
    <section style="padding: 60px 0; border-top: 1px solid var(--line);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">HIGH-CONVERTING NICHES</span>
                <h2 class="section-title">Inbound Call Generation for Competitive Industries</h2>
                <p class="section-description">Learn niche-specific BlackHat SEO techniques engineered to rank keywords and route live phone calls directly to call centers.</p>
            </div>

            <div class="grid-4">
                <a href="industries/tech-support.php" class="industry-card">
                    <div class="industry-icon">🎧</div>
                    <div>
                        <div class="industry-name">Tech Support</div>
                        <div style="font-size: 12px; color: var(--ink-muted);">Printer, Router & Software Calls</div>
                    </div>
                </a>
                <a href="industries/airlines.php" class="industry-card">
                    <div class="industry-icon">✈️</div>
                    <div>
                        <div class="industry-name">Airlines & Travel</div>
                        <div style="font-size: 12px; color: var(--ink-muted);">Flight Changes & Reservations</div>
                    </div>
                </a>
                <a href="industries/accounting.php" class="industry-card">
                    <div class="industry-icon">📊</div>
                    <div>
                        <div class="industry-name">QuickBooks & Acct</div>
                        <div style="font-size: 12px; color: var(--ink-muted);">Financial Software Inbound Leads</div>
                    </div>
                </a>
                <a href="industries/crypto.php" class="industry-card">
                    <div class="industry-icon">🪙</div>
                    <div>
                        <div class="industry-name">Cryptocurrency</div>
                        <div style="font-size: 12px; color: var(--ink-muted);">Wallet & Exchange High Traffic</div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- COURSE CURRICULUM MODULES -->
    <section id="modules" style="padding: 80px 0; background: rgba(13, 15, 23, 0.6); border-top: 1px solid var(--line);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">COMPREHENSIVE CURRICULUM</span>
                <h2 class="section-title">8 Advanced BlackHat SEO Master Modules</h2>
                <p class="section-description">Practical, step-by-step methodologies tested in competitive search environments.</p>
            </div>

            <div class="grid-3">
                <div class="glass-card">
                    <div class="module-icon">⚡</div>
                    <h3 class="module-title">Module 1: High-Velocity Indexing</h3>
                    <p class="module-text">Hack googlebot crawl budgets and force 100,000+ aggressive URLs into Google index within 24 hours using API pipelines.</p>
                </div>

                <div class="glass-card">
                    <div class="module-icon">📞</div>
                    <h3 class="module-title">Module 2: Call Gen Systems</h3>
                    <p class="module-text">Architect inbound phone call funnels for Tech Support, Airlines, and Finance. Target zero-search-volume high-intent queries.</p>
                </div>

                <div class="glass-card">
                    <div class="module-icon">🤖</div>
                    <h3 class="module-title">Module 3: CTR SERP Manipulation</h3>
                    <p class="module-text">Deploy residential proxy search emulation bots to boost search CTRs and elevate organic rankings to Top 3 spots safely.</p>
                </div>

                <div class="glass-card">
                    <div class="module-icon">🧬</div>
                    <h3 class="module-title">Module 4: Technical Cloaking</h3>
                    <p class="module-text">User-Agent and IP header redirection strategies to serve compliant pages to crawlers while showing call funnels to real users.</p>
                </div>

                <div class="glass-card">
                    <div class="module-icon">🌐</div>
                    <h3 class="module-title">Module 5: PBN & Expired Domain Net</h3>
                    <p class="module-text">Build stealth Private Blog Networks with footprint-free WHOIS, CDN hosting, and high-authority expired domain metrics.</p>
                </div>

                <div class="glass-card">
                    <div class="module-icon">🛡️</div>
                    <h3 class="module-title">Module 6: Negative SEO Defense</h3>
                    <p class="module-text">Identify and neutralize toxic disavow attacks, spam link injections, scraper sites, and algorithmic penalty recovery.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- OFFICIAL COURSE PRICING TIERS -->
    <section id="pricing" style="padding: 80px 0; border-top: 1px solid var(--line);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">OFFICIAL ENROLLMENT TIERS</span>
                <h2 class="section-title">Select Your Black Hat SEO Training Package</h2>
                <p class="section-description">Choose your desired level of training, live mentorship, and call generation software suite.</p>
            </div>

            <div class="grid-3">
                <!-- Tier 1: Basic Training -->
                <div class="glass-card course-card">
                    <div class="course-card-header">
                        <span class="category-tag">STARTER PACK</span>
                        <span class="course-price">₹9,999</span>
                    </div>

                    <h3 class="course-title">Basic Black Hat SEO Training</h3>
                    <p class="course-desc">Core training on aggressive ranking techniques, rapid indexing API scripts, and parasite Web 2.0 setups.</p>

                    <ul class="course-features">
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            High-Velocity Indexing Blueprint
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Parasite SEO & Web 2.0 Automation
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Community Forum Access
                        </li>
                    </ul>

                    <a href="register.php" class="btn-outline" style="width: 100%; justify-content: center; margin-top: auto;">
                        Enroll in Basic Batch &rarr;
                    </a>
                </div>

                <!-- Tier 2: Call Gen Masterclass -->
                <div class="glass-card course-card" style="border-color: #ff5722; box-shadow: 0 0 35px rgba(255, 87, 34, 0.45);">
                    <div class="course-card-header">
                        <span class="category-tag" style="background: rgba(255, 87, 34, 0.18); color: #ff6b35; border-color: #ff5722;">MOST POPULAR</span>
                        <span class="course-price" style="color: #ff6b35;">₹24,999</span>
                    </div>

                    <h3 class="course-title">Tech Support & Call Gen Masterclass</h3>
                    <p class="course-desc">Full inbound call generation system for Tech Support, Airlines, QuickBooks & High-Intent Call Centers.</p>

                    <ul class="course-features">
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #ff6b35;"><polyline points="20 6 9 17 4 12"/></svg>
                            Everything in Starter Pack
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #ff6b35;"><polyline points="20 6 9 17 4 12"/></svg>
                            Tech Support & Airlines Call Routing Blueprint
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #ff6b35;"><polyline points="20 6 9 17 4 12"/></svg>
                            Technical Cloaking & User-Agent Redirect Setup
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #ff6b35;"><polyline points="20 6 9 17 4 12"/></svg>
                            CTR Search Bot Suite License
                        </li>
                    </ul>

                    <a href="register.php" class="btn-primary" style="width: 100%; justify-content: center; margin-top: auto; background: linear-gradient(135deg, #ff6b35 0%, #ff3838 100%); color: #fff; box-shadow: 0 4px 18px rgba(255, 87, 34, 0.4);">
                        Enroll in Call Gen Masterclass &rarr;
                    </a>
                </div>

                <!-- Tier 3: VIP Enterprise Mentorship -->
                <div class="glass-card course-card">
                    <div class="course-card-header">
                        <span class="category-tag" style="background: rgba(0, 242, 254, 0.15); color: var(--teal); border-color: var(--teal);">VIP MENTORSHIP</span>
                        <span class="course-price" style="color: var(--teal);">₹49,999</span>
                    </div>

                    <h3 class="course-title">VIP 1-on-1 Mentorship & PBN Build</h3>
                    <p class="course-desc">Direct private consultation with Suresh Das, custom PBN network setup, and dedicated call center scaling.</p>

                    <ul class="course-features">
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--teal);"><polyline points="20 6 9 17 4 12"/></svg>
                            Everything in Call Gen Masterclass
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--teal);"><polyline points="20 6 9 17 4 12"/></svg>
                            Private 1-on-1 Mentorship with Suresh Das
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--teal);"><polyline points="20 6 9 17 4 12"/></svg>
                            Custom Footprint-Free PBN Network Setup
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--teal);"><polyline points="20 6 9 17 4 12"/></svg>
                            24/7 Priority Emergency Support
                        </li>
                    </ul>

                    <a href="contact.php" class="btn-outline" style="width: 100%; justify-content: center; margin-top: auto; border-color: var(--teal); color: var(--teal);">
                        Apply for VIP Mentorship &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- INSTRUCTOR PROFILE -->
    <section id="expert" style="padding: 80px 0; background: rgba(13, 15, 23, 0.6); border-top: 1px solid var(--line);">
        <div class="container">
            <div class="instructor-card">
                <div>
                    <div style="width: 100%; height: 260px; background: linear-gradient(135deg, #1e1b4b 0%, #002b36 100%); border-radius: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid var(--teal);">
                        <div style="font-size: 64px;">🏆</div>
                        <div style="font-family: var(--font-display); font-weight: 800; font-size: 22px; color: var(--teal); margin-top: 10px;">Suresh Das</div>
                        <div style="font-size: 13px; color: var(--ink-muted);">25+ Years Industry Veteran</div>
                    </div>
                </div>
                <div>
                    <span class="section-tag">LEAD TRAINER & EXPERT</span>
                    <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 16px;">Trained 18,640+ Marketers & Call Center Owners Worldwide</h2>
                    <p style="color: var(--ink-muted); margin-bottom: 20px; font-size: 15px;">
                        With over 25 years of hands-on experience in aggressive search engine optimization and lead generation, Suresh Das has pioneered high-converting call generation systems for Tech Support, Airlines, Financial Services, and Global Call Centers in Delhi NCR and across international markets.
                    </p>
                    <div style="display: flex; gap: 24px; font-weight: 700; font-size: 14px;">
                        <div>✓ 25+ Yrs Industry Experience</div>
                        <div>✓ Live Hands-on Training</div>
                        <div>✓ Real-World Case Studies</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ SECTION (SCHEMA COMPLIANT) -->
    <section style="padding: 80px 0; border-top: 1px solid var(--line);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">FREQUENTLY ASKED QUESTIONS</span>
                <h2 class="section-title">Everything You Need to Know</h2>
                <p class="section-description">Got questions about the Black Hat SEO Course & Tech Support Call Gen Training? We've got answers.</p>
            </div>

            <div class="faq-list">
                <div class="faq-item active">
                    <button class="faq-question">
                        <span>What is the Black Hat SEO Course?</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        The Black Hat SEO Course is an advanced SEO training program that teaches aggressive ranking techniques, high-velocity traffic generation methods, PBN architecture, and real-world SEO experiments.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Does this course teach tech support call generation?</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        Yes! The training includes step-by-step methods for generating high-intent inbound tech support calls (printers, routers, software, email support) using advanced SEO, cloaking, and traffic strategies.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Is the Black Hat SEO Course available in Delhi, India?</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        Yes, the course is available for learners in Delhi, India, and globally through structured online live batches, recording modules, and personal mentorship sessions.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Who is the trainer for the course?</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        The course is led by Suresh Das, an industry expert with over 25 years of hands-on experience in SEO, SERP manipulation, and call center lead generation.
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Is prior SEO experience required?</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-answer">
                        Basic familiarity with digital marketing is recommended, but dedicated beginners can easily follow along as step-by-step practical setups are demonstrated from scratch.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CALL TO ACTION BANNER -->
    <section style="padding: 80px 0; background: linear-gradient(135deg, rgba(255, 87, 34, 0.08) 0%, rgba(0, 242, 254, 0.08) 100%); border-top: 1px solid var(--line);">
        <div class="container" style="text-align: center;">
            <span class="section-tag">TAKE YOUR RANKINGS TO THE NEXT LEVEL</span>
            <h2 style="font-size: 42px; font-weight: 800; margin-bottom: 20px;">Ready to Scale Inbound Calls & Dominate Google SERPs?</h2>
            <p style="color: var(--ink-muted); max-width: 640px; margin: 0 auto 30px; font-size: 18px;">Join thousands of successful SEO professionals, affiliates, and call center owners.</p>
            <a href="register.php" class="btn-primary" style="padding: 16px 40px; font-size: 18px; background: linear-gradient(135deg, #ff6b35 0%, #ff3838 100%); color: #fff;">Enroll in BlackHat SEO Course Now &rarr;</a>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>