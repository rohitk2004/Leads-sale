<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - QuickProject</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .legal-content {
            padding: 80px 0;
            line-height: 1.8;
            color: #334155;
        }

        .legal-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .legal-content h2 {
            color: #0f172a;
            margin-top: 40px;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
            font-size: 1.5rem;
        }

        .legal-content p,
        .legal-content li {
            font-size: 1.05rem;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Privacy Policy</h1>
            <p class="page-subtitle">Learn how we collect, use, and protect your data.</p>
        </div>
    </section>

    <section class="legal-content">
        <div class="container">
            <div class="legal-container">
                <p>At <strong>QuickProject.in</strong>, we take your privacy seriously. This policy outlines how we
                    handle your data.</p>

                <h2>Information Collection</h2>
                <p>We collect your name, email, and phone number when you register as a developer or client.</p>

                <h2>Data Usage</h2>
                <p>We use this information to provide verified leads, manage your account, and send project updates.</p>

                <h2>Payment Security</h2>
                <p>We do not store your credit card or bank details. All payments are processed securely through our
                    partner, Instamojo.</p>

                <h2>Data Sharing</h2>
                <p>We do not sell or rent your personal information to third parties.</p>

                <h2>Cookies</h2>
                <p>Our website uses cookies to enhance user experience and maintain your login session.</p>

                <h2>Contact</h2>
                <p>For any data-related queries, email us at <a href="mailto:support@quickproject.in"
                        style="font-weight: bold; color: #2563eb; text-decoration: none;">support@quickproject.in</a>.
                </p>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>