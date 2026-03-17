<?php
// Footer reusable component
?>
<footer class="site-footer">
    <div class="footer-compact">
        <div class="container">
            <!-- Single compact row: Brand + Links + Contact -->
            <div class="footer-compact-row">
                <div class="footer-compact-brand">
                    <a href="index" class="footer-logo">
                        <span class="footer-logo-icon">💼</span>
                        <span class="footer-logo-text">QuickProject</span>
                    </a>
                    <div class="footer-social">
                        <a href="#" aria-label="Twitter"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg></a>
                        <a href="#" aria-label="LinkedIn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
                        <a href="#" aria-label="Instagram"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                        <a href="mailto:support@quickproject.in" aria-label="Email"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></a>
                    </div>
                </div>

                <nav class="footer-compact-links">
                    <a href="available_leads">Browse Leads</a>
                    <a href="index#how-it-works">How It Works</a>
                    <a href="index#pricing">Pricing</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo $_SESSION['role'] == 'admin' ? 'admin_dashboard' : 'developer_dashboard'; ?>">Dashboard</a>
                        <a href="cart">Cart</a>
                    <?php else: ?>
                        <a href="login">Login</a>
                        <a href="register">Register</a>
                    <?php endif; ?>
                    <a href="contact">Contact</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Slim bottom bar with badges + legal -->
    <div class="footer-bottom-bar">
        <div class="container">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">&copy; <?php echo date('Y'); ?> QuickProject. All rights reserved.</p>
                <div class="footer-badges-inline">
                    <span class="footer-mini-badge">🔒 Secure</span>
                    <span class="footer-mini-badge">✅ Verified</span>
                    <span class="footer-mini-badge">💬 24/7</span>
                    <span class="footer-mini-badge">⚡ Instant</span>
                </div>
                <div class="footer-legal-links">
                    <a href="terms">Terms</a>
                    <span class="footer-dot">·</span>
                    <a href="terms#refund-policy">Refund</a>
                    <span class="footer-dot">·</span>
                    <a href="privacy">Privacy</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Global Scripts -->
<script src="script.js"></script>