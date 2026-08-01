<?php
require_once 'functions.php';

$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contact_submit'])) {
    $message_sent = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Advisory Consultation | BlackHat SEO Course</title>
    <meta name="description" content="Get in touch with BlackHat SEO course advisors in Delhi, India. Book a private consultation or inquire about batch schedules.">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Banner -->
    <section style="padding: 60px 0 40px; background: rgba(13, 15, 23, 0.7); border-bottom: 1px solid var(--line);">
        <div class="container" style="text-align: center;">
            <span class="section-tag">GET IN TOUCH</span>
            <h1 style="font-size: 42px; font-weight: 800; margin-bottom: 12px;">Contact Course Advisory</h1>
            <p style="color: var(--ink-muted); max-width: 600px; margin: 0 auto; font-size: 16px;">Have questions about batch schedules, custom team training, or call gen blueprints?</p>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 80px 0;">
        <div class="container">
            <div class="grid-2" style="gap: 40px;">
                
                <!-- Contact Form -->
                <div class="glass-card" style="padding: 36px;">
                    <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 20px;">Send a Message</h3>
                    
                    <?php if ($message_sent): ?>
                        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid var(--emerald); color: var(--emerald); padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
                            ✅ Thank you! Your inquiry has been sent. A senior SEO advisor will contact you shortly.
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label class="form-label">Your Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Vikram Sharma" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="e.g. vikram@agency.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number / WhatsApp</label>
                            <input type="text" name="phone" class="form-control" placeholder="+91 9876543210" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Primary Interest / Industry</label>
                            <select name="industry" class="form-control" required>
                                <option value="Tech Support">Tech Support Call Gen</option>
                                <option value="Airlines">Airlines & Travel SEO</option>
                                <option value="PBN & Indexing">PBN & High-Velocity Indexing</option>
                                <option value="CTR Manipulation">CTR & SERP Automation Bot</option>
                                <option value="QuickBooks">QuickBooks & Accounting</option>
                                <option value="Crypto">Cryptocurrency Traffic</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Message / Details</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your project or call center requirements..." required></textarea>
                        </div>
                        <button type="submit" name="contact_submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                            <span>Submit Advisory Inquiry</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                        </button>
                    </form>
                </div>

                <!-- Info Box -->
                <div>
                    <div class="glass-card" style="padding: 32px; margin-bottom: 24px;">
                        <h4 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: var(--teal);">Training Center HQ</h4>
                        <p style="color: var(--ink-muted); margin-bottom: 12px; font-size: 15px;">
                            📍 <strong>Address:</strong> BlackHat SEO Training Academy, Cannaught Place / South Extension, New Delhi, India
                        </p>
                        <p style="color: var(--ink-muted); margin-bottom: 12px; font-size: 15px;">
                            ✉️ <strong>Email Support:</strong> support@blackhatseocourse.com
                        </p>
                        <p style="color: var(--ink-muted); font-size: 15px;">
                            📞 <strong>Advisory Helpline:</strong> +91 9811002233
                        </p>
                    </div>

                    <div class="glass-card" style="padding: 32px; border-color: rgba(255, 159, 67, 0.3);">
                        <h4 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--amber);">⚡ Private 1-on-1 Mentorship</h4>
                        <p style="color: var(--ink-muted); font-size: 14px; line-height: 1.6;">
                            Need private custom cloaking setups or dedicated PBN architecture for enterprise-level call centers? Contact our senior team for private consulting retainer agreements.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>