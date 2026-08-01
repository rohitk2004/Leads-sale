<?php
// Calculate cart count for the badge
$cart_count = 0;
if (isset($pdo)) {
    $cart_count = count(get_cart_items($pdo));
}

// Helper function for relative paths depending on directory depth
$base_path = (strpos($_SERVER['SCRIPT_NAME'], '/industries/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/services/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/tools/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/forum/') !== false) ? '../' : '';
?>
<!-- Noise Overlay -->
<div class="noise-overlay"></div>

<!-- Top Announcement Bar -->
<div class="top-announcement-bar">
    <div class="container">
        <div class="top-announcement-content">
            <span class="top-announcement-badge">🚨 FINAL WAKE-UP CALL</span>
            <span>Learn Tech Support Call Generation & Advanced Black Hat SEO in 30 Days</span>
            <a href="<?php echo $base_path; ?>available_leads.php" style="color: #ff6b35; font-weight: 700; text-decoration: underline; margin-left: 8px;">Enroll Now &rarr;</a>
        </div>
    </div>
</div>

<!-- Main Navigation Header (Matching Screenshot Layout) -->
<header class="main-header">
    <div class="container">
        <div class="nav-container">
            
            <!-- Brand Logo (Left) -->
            <a href="<?php echo $base_path; ?>index.php" class="brand-logo">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span>BlackHat<span class="brand-badge">SEO</span></span>
            </a>

            <!-- Navigation Links (Center - Matching Screenshot) -->
            <ul class="nav-links">
                <li class="nav-item"><a href="<?php echo $base_path; ?>forum/index.php" class="nav-link-btn">FORUM</a></li>
                <li class="nav-item"><a href="<?php echo $base_path; ?>tools/index.php" class="nav-link-btn">TOOLS</a></li>
                
                <!-- Mega Menu: Industries -->
                <li class="nav-item">
                    <a href="<?php echo $base_path; ?>industries/index.php" class="nav-link-btn">
                        INDUSTRIES
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-grid">
                            <a href="<?php echo $base_path; ?>industries/tech-support.php" class="mega-menu-card">🎧 Tech Support</a>
                            <a href="<?php echo $base_path; ?>industries/airlines.php" class="mega-menu-card">✈️ Airlines & Travel</a>
                            <a href="<?php echo $base_path; ?>industries/accounting.php" class="mega-menu-card">📊 QuickBooks & Acct</a>
                            <a href="<?php echo $base_path; ?>industries/crypto.php" class="mega-menu-card">🪙 Cryptocurrency</a>
                            <a href="<?php echo $base_path; ?>industries/saas.php" class="mega-menu-card">💻 SaaS Call Gen</a>
                            <a href="<?php echo $base_path; ?>industries/ecommerce.php" class="mega-menu-card">🛒 E-Commerce</a>
                            <a href="<?php echo $base_path; ?>industries/finance.php" class="mega-menu-card">💰 Finance & Loans</a>
                            <a href="<?php echo $base_path; ?>industries/insurance.php" class="mega-menu-card">🛡️ Insurance Leads</a>
                            <a href="<?php echo $base_path; ?>industries/healthcare.php" class="mega-menu-card">🏥 Healthcare</a>
                            <a href="<?php echo $base_path; ?>industries/real-estate.php" class="mega-menu-card">🏢 Real Estate</a>
                            <a href="<?php echo $base_path; ?>industries/legal.php" class="mega-menu-card">⚖️ Legal & Attorneys</a>
                            <a href="<?php echo $base_path; ?>industries/home-services.php" class="mega-menu-card">🔧 Home Services</a>
                        </div>
                    </div>
                </li>

                <!-- Mega Menu: Services -->
                <li class="nav-item">
                    <a href="<?php echo $base_path; ?>services/index.php" class="nav-link-btn">
                        SERVICES
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-grid" style="grid-template-columns: repeat(2, 1fr); width: 540px;">
                            <a href="<?php echo $base_path; ?>services/black-hat-seo.php" class="mega-menu-card">🚀 Black Hat SEO</a>
                            <a href="<?php echo $base_path; ?>services/grey-hat-seo.php" class="mega-menu-card">🛡️ Grey Hat SEO</a>
                            <a href="<?php echo $base_path; ?>services/high-velocity-indexing.php" class="mega-menu-card">⚡ High-Velocity Indexing</a>
                            <a href="<?php echo $base_path; ?>services/ctr-manipulation.php" class="mega-menu-card">🤖 CTR SERP Bot</a>
                            <a href="<?php echo $base_path; ?>services/pbn-network-setup.php" class="mega-menu-card">🌐 PBN Network Setup</a>
                            <a href="<?php echo $base_path; ?>services/parasite-seo.php" class="mega-menu-card">🧬 Parasite SEO</a>
                            <a href="<?php echo $base_path; ?>services/cloaking.php" class="mega-menu-card">🔒 Technical Cloaking</a>
                            <a href="<?php echo $base_path; ?>services/negative-seo-protection.php" class="mega-menu-card">🛡️ Negative SEO Defense</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item"><a href="<?php echo $base_path; ?>available_leads.php" class="nav-link-btn">COURSES</a></li>
                <li class="nav-item"><a href="<?php echo $base_path; ?>about.php" class="nav-link-btn">ABOUT EXPERT</a></li>
                <li class="nav-item"><a href="<?php echo $base_path; ?>contact.php" class="nav-link-btn">CONTACT US</a></li>
            </ul>

            <!-- Navigation Right Actions (Phone Pill & Cart - Matching Screenshot) -->
            <div class="nav-actions">
                <a href="tel:+919811002233" class="header-phone-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    +91 (892) 062-4649
                </a>

                <a href="<?php echo $base_path; ?>cart.php" class="btn-cart">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Cart
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo $base_path; ?>register.php" class="btn-primary" style="padding: 8px 18px; font-size: 13px;">Join Course</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</header>