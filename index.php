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
    <title>Quick Project Marketplace - Premium Business Leads for Developers</title>
    <meta name="description"
        content="Connect with high-quality business leads. Unlock verified client contact details and grow your freelance or agency business.">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title animate-fade-in">Unlock Premium Business Leads</h1>
                <p class="hero-subtitle animate-fade-in-delay">Connect with clients ready to invest. Get verified
                    contact details instantly.</p>
                <div class="hero-cta animate-fade-in-delay-2">
                    <a href="#leads" class="btn btn-primary btn-lg">Browse Leads</a>
                    <a href="#how-it-works" class="btn btn-outline btn-lg">Learn More</a>
                </div>
                <div class="hero-stats animate-fade-in-delay-3">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Active Leads</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Happy Developers</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">₹50L+</div>
                        <div class="stat-label">Deals Closed</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Available Leads Section -->
    <section id="leads" class="leads-section">
        <div class="container">
            <h2 class="section-title">Available Leads</h2>
            <p class="section-subtitle">Fresh opportunities updated daily</p>

            <?php if (empty($available_leads)): ?>
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>No leads available at the moment</h3>
                    <p>Check back soon for new opportunities!</p>
                </div>
            <?php else: ?>
                <div class="leads-grid">
                    <?php foreach ($available_leads as $lead):
                        // Blur phone number - show only last 4 digits
                        $phone = $lead['client_phone'];
                        $blurred_phone = str_repeat('●', max(0, strlen($phone) - 4)) . substr($phone, -4);
                        ?>
                        <div class="lead-card">
                            <div class="lead-header">
                                <h3><?php echo htmlspecialchars($lead['niche']); ?></h3>
                                <span class="budget-badge">₹<?php echo number_format($lead['budget']); ?>+</span>
                            </div>

                            <!-- 4 Fields: Name, Number (Blurred), Budget, Requirement -->
                            <div class="lead-details">
                                <div class="detail-row">
                                    <div class="detail-item detail-name">
                                        <span class="detail-icon">👤</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Client Name</span>
                                            <span
                                                class="detail-value"><?php echo htmlspecialchars($lead['client_name']); ?></span>
                                        </div>
                                    </div>
                                    <div class="detail-item detail-phone">
                                        <span class="detail-icon">📞</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Phone Number</span>
                                            <span
                                                class="detail-value blurred-text"><?php echo htmlspecialchars($blurred_phone); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-item detail-budget">
                                        <span class="detail-icon">💰</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Budget</span>
                                            <span
                                                class="detail-value text-green">₹<?php echo number_format($lead['budget']); ?>+</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="detail-item detail-requirement full-width">
                                        <span class="detail-icon">📋</span>
                                        <div class="detail-content">
                                            <span class="detail-label">Requirement</span>
                                            <span
                                                class="detail-value"><?php echo htmlspecialchars($lead['description']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lead-footer">
                                <div class="price-tag">
                                    <span class="price-label">🔓 Unlock Full Details</span>
                                    <span class="price-value">₹<?php echo number_format($lead['lead_price']); ?></span>
                                </div>
                                <form method="POST">
                                    <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                    <input type="hidden" name="add_to_cart" value="1">
                                    <button type="submit" class="btn btn-primary">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="view-all-container" style="text-align: center; margin-top: 40px;">
                    <a href="available_leads.php" class="btn btn-outline btn-lg">View All Available Leads</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose LeadMarket?</h2>
            <p class="section-subtitle">Professional lead marketplace built for serious developers</p>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon-wrapper feature-icon-verified">
                        <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3>Verified Leads</h3>
                    <p>Every lead is verified and comes with accurate budget and project requirements.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-wrapper feature-icon-instant">
                        <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3>Instant Access</h3>
                    <p>Get client contact details immediately after purchase. No waiting period.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-wrapper feature-icon-exclusive">
                        <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0110 0v4"></path>
                        </svg>
                    </div>
                    <h3>Exclusive Rights</h3>
                    <p>Once you buy a lead, it's yours exclusively. No competition from other developers.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon-wrapper feature-icon-pricing">
                        <svg class="feature-icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"></path>
                        </svg>
                    </div>
                    <h3>Affordable Pricing</h3>
                    <p>Pay only for what you need. Transparent pricing based on project budget.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="container">
            <h2 class="section-title">Transparent Pricing</h2>
            <p class="section-subtitle">Choose the lead category that fits your business goals</p>

            <div class="pricing-cards-grid">
                <!-- Basic Plan -->
                <div class="pricing-card pricing-basic">
                    <div class="pricing-card-glow"></div>
                    <div class="pricing-tier-badge">
                        <span class="pricing-tier-dot"></span>
                        Basic
                    </div>
                    <div class="pricing-budget-range">
                        <span class="pricing-budget-label">Client Budget</span>
                        <span class="pricing-budget-value">₹15,000 — ₹30,000</span>
                    </div>
                    <div class="pricing-divider"></div>
                    <div class="pricing-prices">
                        <div class="pricing-standard">
                            <span class="pricing-price-label">Standard Price</span>
                            <span class="pricing-price-amount pricing-standard-amount">₹999</span>
                        </div>
                        <div class="pricing-wallet">
                            <span class="pricing-save-badge">SAVE 20%</span>
                            <span class="pricing-price-label">Wallet Price</span>
                            <span class="pricing-price-amount pricing-wallet-amount">₹799</span>
                        </div>
                    </div>
                    <a href="available_leads.php" class="btn btn-outline pricing-btn">Browse Basic Leads</a>
                </div>

                <!-- Business Plan - Popular -->
                <div class="pricing-card pricing-business pricing-featured">
                    <div class="pricing-card-glow"></div>
                    <div class="pricing-popular-tag">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        Most Popular
                    </div>
                    <div class="pricing-tier-badge">
                        <span class="pricing-tier-dot"></span>
                        Business
                    </div>
                    <div class="pricing-budget-range">
                        <span class="pricing-budget-label">Client Budget</span>
                        <span class="pricing-budget-value">₹30,000 — ₹50,000</span>
                    </div>
                    <div class="pricing-divider"></div>
                    <div class="pricing-prices">
                        <div class="pricing-standard">
                            <span class="pricing-price-label">Standard Price</span>
                            <span class="pricing-price-amount pricing-standard-amount">₹2,499</span>
                        </div>
                        <div class="pricing-wallet">
                            <span class="pricing-save-badge">SAVE 20%</span>
                            <span class="pricing-price-label">Wallet Price</span>
                            <span class="pricing-price-amount pricing-wallet-amount">₹1,999</span>
                        </div>
                    </div>
                    <a href="available_leads.php" class="btn btn-primary pricing-btn">Browse Business Leads</a>
                </div>

                <!-- Premium Plan -->
                <div class="pricing-card pricing-premium">
                    <div class="pricing-card-glow"></div>
                    <div class="pricing-tier-badge">
                        <span class="pricing-tier-dot"></span>
                        Premium
                    </div>
                    <div class="pricing-budget-range">
                        <span class="pricing-budget-label">Client Budget</span>
                        <span class="pricing-budget-value">₹50,000 — ₹1L+</span>
                    </div>
                    <div class="pricing-divider"></div>
                    <div class="pricing-prices">
                        <div class="pricing-standard">
                            <span class="pricing-price-label">Standard Price</span>
                            <span class="pricing-price-amount pricing-standard-amount">₹4,999</span>
                        </div>
                        <div class="pricing-wallet">
                            <span class="pricing-save-badge">SAVE 20%</span>
                            <span class="pricing-price-label">Wallet Price</span>
                            <span class="pricing-price-amount pricing-wallet-amount">₹3,999</span>
                        </div>
                    </div>
                    <a href="available_leads.php" class="btn btn-outline pricing-btn">Browse Premium Leads</a>
                </div>
            </div>

            <div class="pricing-footer-tip">
                <div class="pricing-tip-icon">⚡</div>
                <p><span class="pricing-tip-highlight">Pro Tip:</span> Wallet members save up to <strong>20%
                        EXTRA</strong> on every purchase. <a href="login.php" class="pricing-tip-link">Login to top up
                        →</a></p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="hiw-section">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Start earning with leads in 4 simple steps</p>

            <div class="hiw-timeline">
                <!-- Progress Line -->
                <div class="hiw-progress-line">
                    <div class="hiw-progress-fill"></div>
                </div>

                <!-- Step 1 -->
                <div class="hiw-step hiw-step-1">
                    <div class="hiw-step-node">
                        <div class="hiw-node-ring"></div>
                        <span>01</span>
                    </div>
                    <div class="hiw-step-card">
                        <div class="hiw-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                        <div class="hiw-card-content">
                            <h3>Browse Leads</h3>
                            <p class="hiw-card-subtitle">Discover opportunities</p>
                            <p>Explore our curated marketplace and discover high-quality leads that match your expertise
                                and tech stack.</p>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="hiw-step hiw-step-2">
                    <div class="hiw-step-node">
                        <div class="hiw-node-ring"></div>
                        <span>02</span>
                    </div>
                    <div class="hiw-step-card">
                        <div class="hiw-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </div>
                        <div class="hiw-card-content">
                            <h3>Add to Cart</h3>
                            <p class="hiw-card-subtitle">Select & save</p>
                            <p>Select your desired leads and add them to cart for a seamless, one-click checkout
                                experience.</p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="hiw-step hiw-step-3">
                    <div class="hiw-step-node">
                        <div class="hiw-node-ring"></div>
                        <span>03</span>
                    </div>
                    <div class="hiw-step-card">
                        <div class="hiw-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <div class="hiw-card-content">
                            <h3>Secure Payment</h3>
                            <p class="hiw-card-subtitle">Instant & safe</p>
                            <p>Complete payment with instant confirmation, wallet savings, and enterprise-grade security
                                protection.</p>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="hiw-step hiw-step-4">
                    <div class="hiw-step-node">
                        <div class="hiw-node-ring"></div>
                        <span>04</span>
                    </div>
                    <div class="hiw-step-card">
                        <div class="hiw-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </div>
                        <div class="hiw-card-content">
                            <h3>Close Deals</h3>
                            <p class="hiw-card-subtitle">Start earning</p>
                            <p>Get full client details instantly and start converting leads into profitable, long-term
                                projects.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hiw-cta">
                <a href="#leads" class="btn btn-primary btn-lg">Browse Leads Now →</a>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section id="reviews" class="reviews-section">
        <div class="container">
            <div class="reviews-header">
                <h2 class="section-title">Trusted by Professional Developers</h2>
                <p class="section-subtitle">Join thousands of developers growing their business with QuickProject</p>
                <!-- Trust Stats Bar -->
                <div class="reviews-trust-bar">
                    <div class="trust-stat">
                        <div class="trust-stat-icon">⭐</div>
                        <div class="trust-stat-info">
                            <strong>4.9/5</strong>
                            <span>Average Rating</span>
                        </div>
                    </div>
                    <div class="trust-divider"></div>
                    <div class="trust-stat">
                        <div class="trust-stat-icon">👥</div>
                        <div class="trust-stat-info">
                            <strong>1,000+</strong>
                            <span>Happy Developers</span>
                        </div>
                    </div>
                    <div class="trust-divider"></div>
                    <div class="trust-stat">
                        <div class="trust-stat-icon">✅</div>
                        <div class="trust-stat-info">
                            <strong>₹50L+</strong>
                            <span>Deals Closed</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 1: Scrolls Left -->
            <div class="reviews-carousel-wrapper">
                <div class="reviews-carousel reviews-row-1">
                    <!-- Review 1 -->
                    <div class="review-card review-accent-blue">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"QuickProject transformed my freelance business. I closed 3 deals worth
                            ₹2.5L in just one month! The quality of leads is outstanding."</p>
                        <div class="review-deal-tag">💰 Closed ₹2.5L in deals</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-blue">RS</div>
                            <div class="reviewer-info">
                                <strong>Rahul Sharma</strong>
                                <span>Full Stack Developer, Mumbai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="review-card review-accent-purple">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"The quality of leads is exceptional. Every client I contacted was
                            genuinely interested and had the budget ready. Amazing platform!"</p>
                        <div class="review-deal-tag">💰 Closed ₹1.8L in deals</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-purple">PP</div>
                            <div class="reviewer-info">
                                <strong>Priya Patel</strong>
                                <span>Web Designer, Bangalore</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 3 -->
                    <div class="review-card review-accent-green">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"Best investment for my agency. The exclusive access means no
                            competition. We've scaled to 10+ projects per month using QuickProject leads!"</p>
                        <div class="review-deal-tag">💰 Closed ₹5L+ in deals</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-green">AK</div>
                            <div class="reviewer-info">
                                <strong>Amit Kumar</strong>
                                <span>Agency Owner, Delhi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 4 -->
                    <div class="review-card review-accent-amber">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"I was skeptical at first, but QuickProject proved me wrong. Got my first
                            client within 2 days of purchasing a lead. The ROI is incredible!"</p>
                        <div class="review-deal-tag">💰 Closed ₹45K in first week</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-amber">SM</div>
                            <div class="reviewer-info">
                                <strong>Sneha Mishra</strong>
                                <span>WordPress Developer, Pune</span>
                            </div>
                        </div>
                    </div>

                    <!-- Duplicates for seamless scroll -->
                    <div class="review-card review-accent-blue">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"QuickProject transformed my freelance business. I closed 3 deals worth
                            ₹2.5L in just one month! The quality of leads is outstanding."</p>
                        <div class="review-deal-tag">💰 Closed ₹2.5L in deals</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-blue">RS</div>
                            <div class="reviewer-info">
                                <strong>Rahul Sharma</strong>
                                <span>Full Stack Developer, Mumbai</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card review-accent-purple">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"The quality of leads is exceptional. Every client I contacted was
                            genuinely interested and had the budget ready. Amazing platform!"</p>
                        <div class="review-deal-tag">💰 Closed ₹1.8L in deals</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-purple">PP</div>
                            <div class="reviewer-info">
                                <strong>Priya Patel</strong>
                                <span>Web Designer, Bangalore</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card review-accent-green">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"Best investment for my agency. The exclusive access means no
                            competition. We've scaled to 10+ projects per month using QuickProject leads!"</p>
                        <div class="review-deal-tag">💰 Closed ₹5L+ in deals</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-green">AK</div>
                            <div class="reviewer-info">
                                <strong>Amit Kumar</strong>
                                <span>Agency Owner, Delhi</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card review-accent-amber">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"I was skeptical at first, but QuickProject proved me wrong. Got my first
                            client within 2 days of purchasing a lead. The ROI is incredible!"</p>
                        <div class="review-deal-tag">💰 Closed ₹45K in first week</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-amber">SM</div>
                            <div class="reviewer-info">
                                <strong>Sneha Mishra</strong>
                                <span>WordPress Developer, Pune</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Scrolls Right (reverse) -->
            <div class="reviews-carousel-wrapper">
                <div class="reviews-carousel reviews-row-2">
                    <!-- Review 5 -->
                    <div class="review-card review-accent-teal">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"The wallet system is genius — I save 20% on every purchase. Already
                            bought 15+ leads this month. My pipeline has never been this full!"</p>
                        <div class="review-deal-tag">💰 15+ leads purchased</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-teal">VR</div>
                            <div class="reviewer-info">
                                <strong>Vikram Reddy</strong>
                                <span>React Developer, Hyderabad</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 6 -->
                    <div class="review-card review-accent-rose">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"As a solo developer, finding clients was my biggest challenge.
                            QuickProject solved it completely. Every lead comes with clear requirements!"</p>
                        <div class="review-deal-tag">💰 Closed ₹3.2L in deals</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-rose">ND</div>
                            <div class="reviewer-info">
                                <strong>Neha Desai</strong>
                                <span>UI/UX Designer, Ahmedabad</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 7 -->
                    <div class="review-card review-accent-indigo">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"Switched from cold outreach to QuickProject and it's been a game
                            changer. Clients already know what they want — conversion rate is 10x better."</p>
                        <div class="review-deal-tag">💰 10x conversion improvement</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-indigo">KS</div>
                            <div class="reviewer-info">
                                <strong>Karan Singh</strong>
                                <span>Shopify Expert, Jaipur</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 8 -->
                    <div class="review-card review-accent-orange">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"Premium leads are worth every rupee. Got a ₹1L project from a single
                            lead purchase. The support team is also very responsive and helpful!"</p>
                        <div class="review-deal-tag">💰 ₹1L from single lead</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-orange">DG</div>
                            <div class="reviewer-info">
                                <strong>Deepak Gupta</strong>
                                <span>App Developer, Chennai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Duplicates for seamless scroll -->
                    <div class="review-card review-accent-teal">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"The wallet system is genius — I save 20% on every purchase. Already
                            bought 15+ leads this month. My pipeline has never been this full!"</p>
                        <div class="review-deal-tag">💰 15+ leads purchased</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-teal">VR</div>
                            <div class="reviewer-info">
                                <strong>Vikram Reddy</strong>
                                <span>React Developer, Hyderabad</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card review-accent-rose">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"As a solo developer, finding clients was my biggest challenge.
                            QuickProject solved it completely. Every lead comes with clear requirements!"</p>
                        <div class="review-deal-tag">💰 Closed ₹3.2L in deals</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-rose">ND</div>
                            <div class="reviewer-info">
                                <strong>Neha Desai</strong>
                                <span>UI/UX Designer, Ahmedabad</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card review-accent-indigo">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"Switched from cold outreach to QuickProject and it's been a game
                            changer. Clients already know what they want — conversion rate is 10x better."</p>
                        <div class="review-deal-tag">💰 10x conversion improvement</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-indigo">KS</div>
                            <div class="reviewer-info">
                                <strong>Karan Singh</strong>
                                <span>Shopify Expert, Jaipur</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-card review-accent-orange">
                        <div class="review-card-top">
                            <div class="review-stars">
                                <span class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span><span class="star filled">★</span><span
                                    class="star filled">★</span>
                            </div>
                            <span class="review-verified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                                </svg>
                                Verified
                            </span>
                        </div>
                        <p class="review-text">"Premium leads are worth every rupee. Got a ₹1L project from a single
                            lead purchase. The support team is also very responsive and helpful!"</p>
                        <div class="review-deal-tag">💰 ₹1L from single lead</div>
                        <div class="reviewer">
                            <div class="reviewer-avatar avatar-orange">DG</div>
                            <div class="reviewer-info">
                                <strong>Deepak Gupta</strong>
                                <span>App Developer, Chennai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Grow Your Business?</h2>
            <p>Join thousands of developers who are already closing deals with premium leads.</p>
            <a href="#leads" class="btn btn-primary btn-lg">Get Started Now</a>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>