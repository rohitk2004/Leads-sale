<?php
// Footer reusable component for BlackHat SEO Course
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Info -->
            <div class="footer-brand">
                <a href="index" class="brand-logo">
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

            <!-- Quick Links -->
            <div>
                <h4 class="footer-col-title">Courses & Modules</h4>
                <ul class="footer-links">
                    <li><a href="available_leads">Tech Support Call Gen</a></li>
                    <li><a href="available_leads">High-Velocity Indexing</a></li>
                    <li><a href="available_leads">CTR & SERP Manipulation</a></li>
                    <li><a href="available_leads">PBN & Expired Domains</a></li>
                    <li><a href="available_leads">Technical Cloaking</a></li>
                </ul>
            </div>

            <!-- Industry Solutions -->
            <div>
                <h4 class="footer-col-title">Industry Solutions</h4>
                <ul class="footer-links">
                    <li><a href="available_leads?category=tech_support">Tech Support Leads</a></li>
                    <li><a href="available_leads?category=airlines">Airlines Call Generation</a></li>
                    <li><a href="available_leads?category=quickbooks">QuickBooks Accounting</a></li>
                    <li><a href="available_leads?category=crypto">Crypto Traffic SEO</a></li>
                    <li><a href="available_leads?category=saas">SaaS Lead Generation</a></li>
                </ul>
            </div>

            <!-- Account & Support -->
            <div>
                <h4 class="footer-col-title">Support & Legal</h4>
                <ul class="footer-links">
                    <li><a href="about">About Trainer</a></li>
                    <li><a href="contact">Contact Advisory</a></li>
                    <li><a href="terms">Terms of Service</a></li>
                    <li><a href="privacy">Privacy Policy</a></li>
                    <li><a href="refund">Refund Policy</a></li>
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
    // FAQ Accordion
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