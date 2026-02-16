<!-- Footer -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>💼 QuickProject</h3>
                <p>Your trusted marketplace for premium business leads. Connecting developers with clients since
                    2024.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="available_leads.php">Browse Leads</a></li>
                    <li><a href="index.php#how-it-works">How It Works</a></li>
                    <li><a href="index.php#reviews">Reviews</a></li>
                    <li><a href="cart.php">Cart</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Account</h4>
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a
                                href="<?php echo $_SESSION['role'] == 'admin' ? 'admin_dashboard.php' : 'developer_dashboard.php'; ?>">My
                                Dashboard</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <li>📧 support@quickproject.in</li>
                    <li>📞 +91 98765 43210</li>
                    <li>📍 Mumbai, India</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 QuickProject. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Refund Policy</a>
            </div>
        </div>
    </div>
</footer>

<!-- Global Scripts -->
<script src="script.js"></script>