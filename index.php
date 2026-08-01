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

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>

        <div class="container">
            <div class="hero-content">
                <div class="hero-pill">
                    <span>⚡ #1 Black Hat SEO & Call Generation Course in Delhi & Worldwide</span>
                </div>

                <h1 class="hero-title">
                    Dominate SERPs. Generate High-Intent <span class="gradient-text-teal">Inbound Calls</span> & Scale Organic <span class="gradient-text-amber">Traffic Fast</span>.
                </h1>

                <p class="hero-subtitle">
                    Master aggressive technical SEO, high-velocity indexing, PBN domain networks, SERP manipulation, and inbound call generation strategies for Tech Support, Airlines, Crypto & Competitive Niches.
                </p>

                <div class="hero-ctas">
                    <a href="available_leads" class="btn-primary" style="padding: 14px 32px; font-size: 16px;">
                        <span>Explore Courses & Blueprints</span>
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
                        <div class="stat-value" style="color: var(--amber);">₹50Cr+</div>
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
        </div>
    </section>

    <!-- INDUSTRY VERTICALS SECTION -->
    <section style="padding: 60px 0; border-top: 1px solid var(--line);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">HIGH-CONVERTING NICHES</span>
                <h2 class="section-title">Inbound Call Generation for Competitive Industries</h2>
                <p class="section-description">Learn niche-specific BlackHat SEO techniques engineered to rank keywords and route live phone calls directly to call centers.</p>
            </div>

            <div class="grid-4">
                <a href="available_leads?category=tech_support" class="industry-card">
                    <div class="industry-icon">🎧</div>
                    <div>
                        <div class="industry-name">Tech Support</div>
                        <div style="font-size: 12px; color: var(--ink-muted);">Printer, Router & Software Calls</div>
                    </div>
                </a>
                <a href="available_leads?category=airlines" class="industry-card">
                    <div class="industry-icon">✈️</div>
                    <div>
                        <div class="industry-name">Airlines & Travel</div>
                        <div style="font-size: 12px; color: var(--ink-muted);">Flight Changes & Reservations</div>
                    </div>
                </a>
                <a href="available_leads?category=quickbooks" class="industry-card">
                    <div class="industry-icon">📊</div>
                    <div>
                        <div class="industry-name">QuickBooks & Acct</div>
                        <div style="font-size: 12px; color: var(--ink-muted);">Financial Software Inbound Leads</div>
                    </div>
                </a>
                <a href="available_leads?category=crypto" class="industry-card">
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
                    <p class="module-text">Architect inbound phone call funnels for Tech Support, Airlines, and Finance. Target zero-search-volume high-intent intent queries.</p>
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

    <!-- AVAILABLE COURSES & LEADS MARKETPLACE -->
    <section style="padding: 80px 0; border-top: 1px solid var(--line);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">AVAILABLE BLUEPRINTS & PACKAGES</span>
                <h2 class="section-title">Live Courses & Call Generation Packages</h2>
                <p class="section-description">Select a course package or lead blueprint below for instant access.</p>
            </div>

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
                                    Live Demonstration & Strategy Support
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
                    <p style="text-align: center; grid-column: 1 / -1; color: var(--ink-muted);">No active courses found. Please run <a href="seed" style="color: var(--teal);">seed.php</a> to populate live courses.</p>
                <?php endif; ?>
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
    <section style="padding: 80px 0; background: linear-gradient(135deg, rgba(0, 242, 254, 0.08) 0%, rgba(255, 159, 67, 0.08) 100%); border-top: 1px solid var(--line);">
        <div class="container" style="text-align: center;">
            <span class="section-tag">TAKE YOUR RANKINGS TO THE NEXT LEVEL</span>
            <h2 style="font-size: 42px; font-weight: 800; margin-bottom: 20px;">Ready to Scale Inbound Calls & Dominate Google SERPs?</h2>
            <p style="color: var(--ink-muted); max-width: 640px; margin: 0 auto 30px; font-size: 18px;">Join thousands of successful SEO professionals, affiliates, and call center owners.</p>
            <a href="available_leads" class="btn-primary" style="padding: 16px 40px; font-size: 18px;">Enroll in BlackHat SEO Course Now &rarr;</a>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>