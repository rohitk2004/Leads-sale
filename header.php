<?php
// Calculate cart count for the badge
$cart_count = 0;
if (isset($pdo)) {
    $cart_count = count(get_cart_items($pdo));
}
?>
<!-- Noise Overlay -->
<div class="noise-overlay"></div>

<!-- Top Announcement Bar -->
<div class="top-announcement-bar">
    <div class="container">
        <div class="top-announcement-content">
            <span class="top-announcement-badge">🔥 LIVE BATCH OPEN</span>
            <span>Learn Tech Support Call Generation & Advanced Black Hat SEO by 25+ Yrs Industry Expert</span>
            <a href="available_leads" style="color: var(--amber); font-weight: 700; text-decoration: underline; margin-left: 8px;">Enroll Now &rarr;</a>
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<header class="main-header">
    <div class="container">
        <div class="nav-container">
            
            <!-- Brand Logo -->
            <a href="index" class="brand-logo">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span>BlackHat<span class="brand-badge">SEO</span></span>
            </a>

            <!-- Navigation Links with Mega Menu -->
            <ul class="nav-links">
                <li class="nav-item"><a href="index" class="nav-link-btn">Home</a></li>
                
                <!-- Mega Menu: Industries -->
                <li class="nav-item">
                    <button class="nav-link-btn">
                        Industries
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="mega-menu">
                        <div class="mega-menu-grid">
                            <a href="available_leads?category=tech_support" class="mega-menu-card">🎧 Tech Support</a>
                            <a href="available_leads?category=airlines" class="mega-menu-card">✈️ Airlines & Travel</a>
                            <a href="available_leads?category=saas" class="mega-menu-card">💻 SaaS Call Gen</a>
                            <a href="available_leads?category=ecommerce" class="mega-menu-card">🛒 E-Commerce</a>
                            <a href="available_leads?category=finance" class="mega-menu-card">💰 Finance & Loans</a>
                            <a href="available_leads?category=insurance" class="mega-menu-card">🛡️ Insurance Leads</a>
                            <a href="available_leads?category=crypto" class="mega-menu-card">🪙 Cryptocurrency</a>
                            <a href="available_leads?category=realestate" class="mega-menu-card">🏢 Real Estate</a>
                            <a href="available_leads?category=quickbooks" class="mega-menu-card">📊 QuickBooks & Acct</a>
                            <a href="available_leads?category=healthcare" class="mega-menu-card">🏥 Healthcare</a>
                            <a href="available_leads?category=gaming" class="mega-menu-card">🎮 Gaming Traffic</a>
                            <a href="available_leads?category=homeservices" class="mega-menu-card">🔧 Home Services</a>
                        </div>
                    </div>
                </li>

                <!-- Mega Menu: Course Modules & Services -->
                <li class="nav-item">
                    <button class="nav-link-btn">
                        Modules & Services
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="mega-menu">
                        <div class="mega-menu-grid" style="grid-template-columns: repeat(2, 1fr); width: 540px;">
                            <a href="index#modules" class="mega-menu-card">⚡ High-Velocity Indexing</a>
                            <a href="index#modules" class="mega-menu-card">📞 Call Generation Systems</a>
                            <a href="index#modules" class="mega-menu-card">🤖 CTR & SERP Manipulation</a>
                            <a href="index#modules" class="mega-menu-card">🌐 PBN Network Setup</a>
                            <a href="index#modules" class="mega-menu-card">🧬 Cloaking & User Hacking</a>
                            <a href="index#modules" class="mega-menu-card">🛡️ Negative SEO Defense</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item"><a href="available_leads" class="nav-link-btn">Courses & Leads</a></li>
                <li class="nav-item"><a href="about" class="nav-link-btn">About Expert</a></li>
                <li class="nav-item"><a href="contact" class="nav-link-btn">Contact Us</a></li>
            </ul>

            <!-- Navigation Actions -->
            <div class="nav-actions">
                <a href="cart" class="btn-cart">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Cart
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo $_SESSION['role'] == 'admin' ? 'admin_dashboard' : 'developer_dashboard'; ?>" class="btn-outline">
                        Dashboard (<?php echo htmlspecialchars($_SESSION['username']); ?>)
                    </a>
                    <a href="logout" class="btn-outline" style="border-color: rgba(244, 63, 94, 0.4); color: var(--rose);">Logout</a>
                <?php else: ?>
                    <a href="login" class="btn-outline">Login</a>
                    <a href="register" class="btn-primary">Join Course</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</header>