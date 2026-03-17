<?php
// Footer reusable component
?>
<footer class="site-footer">
    <div class="footer-main-strip">
        <div class="container">
            <div class="footer-row">
                <!-- Brand -->
                <a href="index" class="footer-brand-link">
                    <span class="footer-brand-emoji">💼</span>
                    <span class="footer-brand-name">QuickProject</span>
                </a>

                <!-- Divider -->
                <span class="footer-vr"></span>

                <!-- Navigation Links -->
                <nav class="footer-nav">
                    <a href="available_leads">Browse Leads</a>
                    <a href="index#how-it-works">How It Works</a>
                    <a href="index#pricing">Pricing</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a
                            href="<?php echo $_SESSION['role'] == 'admin' ? 'admin_dashboard' : 'developer_dashboard'; ?>">Dashboard</a>
                        <a href="cart">Cart</a>
                    <?php else: ?>
                        <a href="login">Login</a>
                        <a href="register">Register</a>
                    <?php endif; ?>
                    <a href="contact">Contact</a>
                </nav>

                <!-- Divider -->
                <span class="footer-vr"></span>

                <!-- Socials -->
                <div class="footer-socials">
                    <a href="#" aria-label="Twitter" class="footer-social-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                        </svg>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="footer-social-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                            <rect x="2" y="9" width="4" height="12" />
                            <circle cx="4" cy="4" r="2" />
                        </svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="footer-social-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                        </svg>
                    </a>
                    <a href="mailto:support@quickproject.in" aria-label="Email" class="footer-social-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom bar -->
    <div class="footer-bottom-strip">
        <div class="container">
            <div class="footer-bottom-row">
                <span class="footer-copy">&copy; <?php echo date('Y'); ?> QuickProject</span>
                <div class="footer-trust-pills">
                    <span>🔒 Secure</span>
                    <span>✅ Verified</span>
                    <span>💬 24/7</span>
                    <span>⚡ Instant</span>
                </div>
                <div class="footer-legal">
                    <a href="terms">Terms</a>
                    <a href="terms#refund-policy">Refund</a>
                    <a href="privacy">Privacy</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Global Scripts -->
<script src="script.js"></script>