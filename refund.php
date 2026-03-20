<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund & Cancellation Policy - QuickProject</title>
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
            <h1 class="page-title">Refund & Cancellation Policy</h1>
            <p class="page-subtitle">Learn about our refund, cancellation, and replacement policies.</p>
        </div>
    </section>

    <section class="legal-content">
        <div class="container">
            <div class="legal-container">
                <p>Because <strong>QuickProject.in</strong> provides instant digital access to proprietary lead data and
                    project information, we maintain a strict refund policy:</p>

                <h2>No Refunds</h2>
                <p>All sales of lead credits or subscriptions are final. Once digital data is accessed or unlocked, no
                    refunds will be issued.</p>

                <h2>Invalid Leads</h2>
                <p>If a lead is found to have an inactive phone number or email, please report it within 48 hours. After
                    verification, we will provide a replacement lead credit to your account.</p>

                <h2>Cancellation</h2>
                <p>You may cancel your subscription at any time via your dashboard. Cancellation prevents future billing
                    but does not entitle the user to a refund for the current period.</p>

                <h2>Duplicate Charges</h2>
                <p>In case of a technical error resulting in a double payment, the extra amount will be refunded to the
                    original payment source within 7-10 working days.</p>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>