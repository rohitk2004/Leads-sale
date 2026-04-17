<?php
// Calculate cart count for the badge
$cart_count = 0;
if (isset($pdo)) {
    $cart_count = count(get_cart_items($pdo));
}
?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ELEP38JWY8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ELEP38JWY8');
</script>

<!-- Mini Top Header -->
<div class="top-header">
    <div class="container">
        <div class="top-header-content">
            <div class="top-header-left">
                <a href="mailto:support@quickproject.in" class="top-header-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="top-header-email-text">support@quickproject.in</span>
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

        <!-- Hamburger Toggle -->
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
        </button>

        <nav class="main-nav" id="mainNav">
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

<script>
    // Hamburger toggle
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('navToggle');
        const nav = document.getElementById('mainNav');
        if (toggle && nav) {
            toggle.addEventListener('click', function () {
                nav.classList.toggle('nav-open');
                toggle.classList.toggle('nav-toggle-active');
            });
            // Close menu when a link is clicked
            nav.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    nav.classList.remove('nav-open');
                    toggle.classList.remove('nav-toggle-active');
                });
            });
        }
    });
</script>