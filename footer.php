<?php
// Footer reusable component for BlackHat SEO Course
$base_path = (strpos($_SERVER['SCRIPT_NAME'], '/industries/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/services/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/tools/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/forum/') !== false) ? '../' : '';
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Info -->
            <div class="footer-brand">
                <a href="<?php echo $base_path; ?>index.php" class="brand-logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--amber);">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                    <span>BlackHat<span class="brand-badge">SEO</span></span>
                </a>
                <p>The #1 Black Hat SEO & Inbound Call Generation Training Academy in Delhi, India & Worldwide. Master technical ranking, SERP manipulation, PBN setup, and call center lead generation.</p>
                <div style="font-size: 13px; color: var(--ink-muted);">
                    📍 Delhi, India | ✉️ support@blackhatseocourse.com
                </div>
            </div>

            <!-- Services -->
            <div>
                <h4 class="footer-col-title">SEO Services</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo $base_path; ?>services/black-hat-seo.php">Black Hat SEO</a></li>
                    <li><a href="<?php echo $base_path; ?>services/grey-hat-seo.php">Grey Hat SEO</a></li>
                    <li><a href="<?php echo $base_path; ?>services/high-velocity-indexing.php">High-Velocity Indexing</a></li>
                    <li><a href="<?php echo $base_path; ?>services/ctr-manipulation.php">CTR SERP Bot</a></li>
                    <li><a href="<?php echo $base_path; ?>services/pbn-network-setup.php">PBN Network Setup</a></li>
                    <li><a href="<?php echo $base_path; ?>services/parasite-seo.php">Parasite SEO</a></li>
                    <li><a href="<?php echo $base_path; ?>services/cloaking.php">Technical Cloaking</a></li>
                    <li><a href="<?php echo $base_path; ?>services/negative-seo-protection.php">Negative SEO Defense</a></li>
                </ul>
            </div>

            <!-- Industry Solutions -->
            <div>
                <h4 class="footer-col-title">Industry Solutions</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo $base_path; ?>industries/tech-support.php">Tech Support Leads</a></li>
                    <li><a href="<?php echo $base_path; ?>industries/airlines.php">Airlines Call Generation</a></li>
                    <li><a href="<?php echo $base_path; ?>industries/accounting.php">QuickBooks Accounting</a></li>
                    <li><a href="<?php echo $base_path; ?>industries/crypto.php">Crypto Traffic SEO</a></li>
                    <li><a href="<?php echo $base_path; ?>industries/saas.php">SaaS Lead Gen</a></li>
                    <li><a href="<?php echo $base_path; ?>industries/ecommerce.php">E-Commerce SEO</a></li>
                    <li><a href="<?php echo $base_path; ?>industries/finance.php">Finance & Loans</a></li>
                    <li><a href="<?php echo $base_path; ?>industries/real-estate.php">Real Estate</a></li>
                </ul>
            </div>

            <!-- Account & Support -->
            <div>
                <h4 class="footer-col-title">Support & Community</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo $base_path; ?>tools/index.php">Interactive Tools</a></li>
                    <li><a href="<?php echo $base_path; ?>forum/index.php">Community Forum</a></li>
                    <li><a href="<?php echo $base_path; ?>available_leads.php">Courses Catalog</a></li>
                    <li><a href="<?php echo $base_path; ?>about.php">About Expert</a></li>
                    <li><a href="<?php echo $base_path; ?>contact.php">Contact Advisory</a></li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div>
                &copy; <?php echo date('Y'); ?> BlackHat SEO Course. All Rights Reserved. Master Training & Inbound Lead Generation Systems.
            </div>
            <div style="display: flex; gap: 16px;">
                <span>🔒 256-Bit SSL Encrypted</span>
                <span>⚡ Instant Course Access</span>
                <span>🏆 25+ Yrs Industry Expert</span>
            </div>
        </div>
    </div>
</footer>

<!-- Global JavaScript for Accordion & Interactivity -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        if (question) {
            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                faqItems.forEach(i => i.classList.remove('active'));
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        }
    });
});
</script>