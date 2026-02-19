<?php
// Calculate cart count for the badge
$cart_count = 0;
if (isset($pdo)) {
    $cart_count = count(get_cart_items($pdo));
}
?>
<!-- Mini Top Header -->
<div class="top-header">
    <div class="container">
        <div class="top-header-content">
            <div class="top-header-left">
                <a href="mailto:contact@leadmarket.com" class="top-header-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    contact@quickproject.in
                </a>
                <a href="tel:+919876543210" class="top-header-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    +91 98765 43210
                </a>
            </div>
            <div class="top-header-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="top-header-user">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                    <a href="<?php echo $_SESSION['role'] == 'admin' ? 'admin_dashboard' : 'developer_dashboard'; ?>"
                        class="top-header-btn">Dashboard</a>
                    <a href="logout" class="top-header-link">Logout</a>
                <?php else: ?>
                    <a href="login" class="top-header-btn">Login</a>
                    <a href="register" class="top-header-btn top-header-btn-primary">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header">
    <div class="container">
        <div class="logo">
            <a href="index" style="text-decoration: none;">
                <h1>💼 Quick<span style="color: var(--success-color);">Project</span></h1>
            </a>
        </div>
        <nav>
            <a href="index" class="nav-link">Home</a>
            <a href="about" class="nav-link">About Us</a>
            <a href="available_leads" class="nav-link">Available Leads</a>
            <a href="sold_leads" class="nav-link">Sold Leads</a>
            <a href="contact" class="nav-link">Contact Us</a>
            <a href="cart" class="cart-link">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Cart
                <?php if ($cart_count > 0): ?>
                    <span class="cart-badge">
                        <?php echo $cart_count; ?>
                    </span>
                <?php endif; ?>
            </a>
        </nav>
    </div>
</header>