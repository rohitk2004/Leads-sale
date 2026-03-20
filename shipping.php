<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping & Delivery Policy - QuickProject</title>
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
            <h1 class="page-title">Shipping & Delivery Policy</h1>
            <p class="page-subtitle">Understanding our digital delivery process.</p>
        </div>
    </section>

    <section class="legal-content">
        <div class="container">
            <div class="legal-container">
                <p><strong>QuickProject.in</strong> provides 100% Digital Services.</p>

                <h2>Nature of Delivery</h2>
                <p>We do not ship any physical products. No courier or postal services are used.</p>

                <h2>Delivery Timeline</h2>
                <p>Access to lead data and project requirements is granted instantly upon successful payment
                    confirmation.</p>

                <h2>Delivery Method</h2>
                <p>Once payment is processed, the digital lead details are unlocked within your user dashboard. You will
                    also receive a confirmation email with the transaction details.</p>

                <h2>Failed Delivery</h2>
                <p>If you do not gain access within 10 minutes of payment, please contact <a
                        href="mailto:support@quickproject.in"
                        style="font-weight: bold; color: #2563eb; text-decoration: none;">support@quickproject.in</a>
                    with your transaction ID, and we will resolve it within 24 hours.</p>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>