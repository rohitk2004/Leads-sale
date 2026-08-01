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
            <span class="top-announcement-badge">🔥 LIVE BATCH OPEN</span>
            <span>Learn Tech Support Call Generation & Advanced Black Hat SEO by 25+ Yrs Industry Expert</span>
            <a href="<?php echo $base_path; ?>available_leads" style="color: var(--amber); font-weight: 700; text-decoration: underline; margin-left: 8px;">Enroll Now &rarr;</a>
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<header class="main-header">
    <div class="container">
        <div class="nav-container">
            
            <!-- Brand Logo -->
            <a href="<?php echo $base_path; ?>index" class="brand-logo">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span>BlackHat<span class="brand-badge">SEO</span></span>
            </a>

            <!-- Navigation Links with Mega Menu -->
            <ul class="nav-links">
                <li class="nav-item"><a href="<?php echo $base_path; ?>index" class="nav-link-btn">Home</a></li>
                
                <!-- Mega Menu: Industries -->
                <li class="nav-item">
                    <a href="<?php echo $base_path; ?>industries/index" class="nav-link-btn">
                        Industries
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-grid">
                            <a href="<?php echo $base_path; ?>industries/tech-support" class="mega-menu-card">🎧 Tech Support</a>
                            <a href="<?php echo $base_path; ?>industries/airlines" class="mega-menu-card">✈️ Airlines & Travel</a>
                            <a href="<?php echo $base_path; ?>industries/accounting" class="mega-menu-card">📊 QuickBooks & Acct</a>
                            <a href="<?php echo $base_path; ?>industries/crypto" class="mega-menu-card">🪙 Cryptocurrency</a>
                            <a href="<?php echo $base_path; ?>industries/saas" class="mega-menu-card">💻 SaaS Call Gen</a>
                            <a href="<?php echo $base_path; ?>industries/ecommerce" class="mega-menu-card">🛒 E-Commerce</a>
                        </div>
                    </div>
                </li>

                <!-- Mega Menu: Services -->
                <li class="nav-item">
                    <a href="<?php echo $base_path; ?>services/index" class="nav-link-btn">
                        Services
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-grid" style="grid-template-columns: repeat(2, 1fr); width: 540px;">
                            <a href="<?php echo $base_path; ?>services/high-velocity-indexing" class="mega-menu-card">⚡ High-Velocity Indexing</a>
                            <a href="<?php echo $base_path; ?>services/ctr-manipulation" class="mega-menu-card">🤖 CTR & SERP Manipulation</a>
                            <a href="<?php echo $base_path; ?>services/pbn-network-setup" class="mega-menu-card">🌐 PBN Network Setup</a>
                            <a href="<?php echo $base_path; ?>services/cloaking" class="mega-menu-card">🧬 Technical Cloaking</a>
                            <a href="<?php echo $base_path; ?>services/negative-seo-protection" class="mega-menu-card">🛡️ Negative SEO Protection</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item"><a href="<?php echo $base_path; ?>tools/index" class="nav-link-btn">Tools</a></li>
                <li class="nav-item"><a href="<?php echo $base_path; ?>forum/index" class="nav-link-btn">Forum</a></li>
                <li class="nav-item"><a href="<?php echo $base_path; ?>available_leads" class="nav-link-btn">Courses</a></li>
                <li class="nav-item"><a href="<?php echo $base_path; ?>about" class="nav-link-btn">About Expert</a></li>
                <li class="nav-item"><a href="<?php echo $base_path; ?>contact" class="nav-link-btn">Contact Us</a></li>
            </ul>

            <!-- Navigation Actions -->
            <div class="nav-actions">
                <a href="<?php echo $base_path; ?>cart" class="btn-cart">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Cart
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo $base_path; ?><?php echo $_SESSION['role'] == 'admin' ? 'admin_dashboard' : 'developer_dashboard'; ?>" class="btn-outline">
                        Dashboard (<?php echo htmlspecialchars($_SESSION['username']); ?>)
                    </a>
                    <a href="<?php echo $base_path; ?>logout" class="btn-outline" style="border-color: rgba(244, 63, 94, 0.4); color: var(--rose);">Logout</a>
                <?php else: ?>
                    <a href="<?php echo $base_path; ?>login" class="btn-outline">Login</a>
                    <a href="<?php echo $base_path; ?>register" class="btn-primary">Join Course</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</header>