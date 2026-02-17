<!-- Footer -->
<footer class="site-footer">
    <!-- Main Footer Content -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand Column -->
                <div class="footer-col footer-brand">
                    <a href="index.php" class="footer-logo">
                        <span class="footer-logo-icon">💼</span>
                        <span class="footer-logo-text">QuickProject</span>
                    </a>
                    <p class="footer-tagline">Your trusted marketplace for premium business leads. Connecting developers
                        with high-value clients since 2024.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Twitter">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                                <rect x="2" y="9" width="4" height="12" />
                                <circle cx="4" cy="4" r="2" />
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                            </svg>
                        </a>
                        <a href="mailto:support@quickproject.in" class="social-link" aria-label="Email">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-heading">Quick Links</h4>
                    <ul class="footer-links-list">
                        <li><a href="available_leads.php">Browse Leads</a></li>
                        <li><a href="index.php#how-it-works">How It Works</a></li>
                        <li><a href="index.php#pricing">Pricing</a></li>
                        <li><a href="index.php#reviews">Reviews</a></li>
                        <li><a href="cart.php">Cart</a></li>
                    </ul>
                </div>

                <!-- Account -->
                <div class="footer-col">
                    <h4 class="footer-heading">Account</h4>
                    <ul class="footer-links-list">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a
                                    href="<?php echo $_SESSION['role'] == 'admin' ? 'admin_dashboard.php' : 'developer_dashboard.php'; ?>">My
                                    Dashboard</a></li>
                            <li><a href="cart.php">My Cart</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-col">
                    <h4 class="footer-heading">Get in Touch</h4>
                    <ul class="footer-contact-list">
                        <li>
                            <div class="footer-contact-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </div>
                            <a href="mailto:support@quickproject.in">support@quickproject.in</a>
                        </li>
                        <li>
                            <div class="footer-contact-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                            </div>
                            <a href="tel:+919876543210">+91 98765 43210</a>
                        </li>
                        <li>
                            <div class="footer-contact-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                            </div>
                            <span>Mumbai, India</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Trust Badges Row -->
            <div class="footer-trust-row">
                <div class="footer-trust-badge">
                    <span class="trust-badge-icon">🔒</span>
                    <span>Secure Payments</span>
                </div>
                <div class="footer-trust-badge">
                    <span class="trust-badge-icon">✅</span>
                    <span>Verified Leads</span>
                </div>
                <div class="footer-trust-badge">
                    <span class="trust-badge-icon">💬</span>
                    <span>24/7 Support</span>
                </div>
                <div class="footer-trust-badge">
                    <span class="trust-badge-icon">🔄</span>
                    <span>Refund Policy</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">&copy; 2026 QuickProject. All rights reserved.</p>
                <div class="footer-legal-links">
                    <a href="terms.php">Terms & Conditions</a>
                    <span class="footer-dot">·</span>
                    <a href="terms.php#refund-policy">Refund Policy</a>
                    <span class="footer-dot">·</span>
                    <a href="contact.php">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Global Scripts -->
<script src="script.js"></script>