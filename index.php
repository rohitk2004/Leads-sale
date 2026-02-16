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

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works-section">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Start earning with leads in 4 simple steps</p>

            <div class="steps-container">
                <!-- Step 1 -->
                <div class="step-box">
                    <div class="step-number-badge">01</div>
                    <div class="step-icon-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </div>
                    <h3>Browse Leads</h3>
                    <p>Explore our curated marketplace and discover high-quality leads that match your expertise.</p>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q25 0, 50 5 T100 5" stroke="url(#gradient1)" stroke-width="2" fill="none" />
                            <defs>
                                <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step-box">
                    <div class="step-number-badge">02</div>
                    <div class="step-icon-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <h3>Add to Cart</h3>
                    <p>Select your desired leads and add them to cart for a seamless checkout experience.</p>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q25 0, 50 5 T100 5" stroke="url(#gradient2)" stroke-width="2" fill="none" />
                            <defs>
                                <linearGradient id="gradient2" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#8b5cf6;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#f59e0b;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-box">
                    <div class="step-number-badge">03</div>
                    <div class="step-icon-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <h3>Secure Payment</h3>
                    <p>Complete payment with instant confirmation and enterprise-grade security protection.</p>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q25 0, 50 5 T100 5" stroke="url(#gradient3)" stroke-width="2" fill="none" />
                            <defs>
                                <linearGradient id="gradient3" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#f59e0b;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#2d8659;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="step-box">
                    <div class="step-number-badge">04</div>
                    <div class="step-icon-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </div>
                    <h3>Close Deals</h3>
                    <p>Get full client details instantly and start converting leads into profitable projects.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section id="reviews" class="reviews-section">
        <div class="container">
            <h2 class="section-title">Trusted by Professional Developers</h2>
            <p class="section-subtitle">Join thousands of developers growing their business with LeadMarket</p>

            <div class="reviews-carousel-wrapper">
                <div class="reviews-carousel">
                    <!-- Review 1 -->
                    <div class="review-card">
                        <div class="review-quote-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                        </div>
                        <div class="review-stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                        </div>
                        <p class="review-text">"LeadMarket transformed my freelance business. I closed 3 deals worth
                            ₹2.5L in just one month! The quality of leads is outstanding."</p>
                        <div class="reviewer">
                            <div class="reviewer-avatar">RS</div>
                            <div class="reviewer-info">
                                <strong>Rahul Sharma</strong>
                                <span>Full Stack Developer, Mumbai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="review-card">
                        <div class="review-quote-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                        </div>
                        <div class="review-stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                        </div>
                        <p class="review-text">"The quality of leads is exceptional. Every client I contacted was
                            genuinely interested and had the budget ready. Amazing platform!"</p>
                        <div class="reviewer">
                            <div class="reviewer-avatar">PP</div>
                            <div class="reviewer-info">
                                <strong>Priya Patel</strong>
                                <span>Web Designer, Bangalore</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 3 -->
                    <div class="review-card">
                        <div class="review-quote-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                        </div>
                        <div class="review-stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                        </div>
                        <p class="review-text">"Best investment for my agency. The exclusive access means no
                            competition. Highly recommended to all professional developers!"</p>
                        <div class="reviewer">
                            <div class="reviewer-avatar">AK</div>
                            <div class="reviewer-info">
                                <strong>Amit Kumar</strong>
                                <span>Agency Owner, Delhi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 4 (Duplicate for infinite scroll) -->
                    <div class="review-card">
                        <div class="review-quote-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                        </div>
                        <div class="review-stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                        </div>
                        <p class="review-text">"LeadMarket transformed my freelance business. I closed 3 deals worth
                            ₹2.5L in just one month! The quality of leads is outstanding."</p>
                        <div class="reviewer">
                            <div class="reviewer-avatar">RS</div>
                            <div class="reviewer-info">
                                <strong>Rahul Sharma</strong>
                                <span>Full Stack Developer, Mumbai</span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 5 (Duplicate for infinite scroll) -->
                    <div class="review-card">
                        <div class="review-quote-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                        </div>
                        <div class="review-stars">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                        </div>
                        <p class="review-text">"The quality of leads is exceptional. Every client I contacted was
                            genuinely interested and had the budget ready. Amazing platform!"</p>
                        <div class="reviewer">
                            <div class="reviewer-avatar">PP</div>
                            <div class="reviewer-info">
                                <strong>Priya Patel</strong>
                                <span>Web Designer, Bangalore</span>
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