<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions - QuickProject</title>
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
        }

        .legal-content p,
        .legal-content li {
            font-size: 1.05rem;
            margin-bottom: 15px;
        }

        .legal-content ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .category-box {
            background: #f8fafc;
            padding: 15px 25px;
            border-radius: 12px;
            margin: 10px 0;
            border-left: 4px solid var(--primary-color);
        }

        .policy-alert {
            background: #fff7ed;
            border: 1px solid #ffedd5;
            color: #9a3412;
            padding: 20px;
            border-radius: 12px;
            margin: 25px 0;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Terms and Conditions</h1>
            <p class="page-subtitle">Please read our terms carefully before using our services.</p>
        </div>
    </section>

    <section class="legal-content">
        <div class="container">
            <div class="legal-container">
                <p>Welcome to <strong>QuickProject.in</strong>. By accessing this website and using our lead generation
                    services, you (the "Lead Buyer" or "Developer") agree to be bound by the following terms and
                    conditions. Please read them carefully before purchasing any leads or topping up your wallet.</p>

                <h2>1. Nature of Service</h2>
                <p>QuickProject.in is a lead aggregation platform managed by <strong>Viral Verse Media</strong>. We
                    provide contact details (Name, Phone, Email, and Project Requirements) of potential clients who have
                    expressed interest in web development services. We do not provide the final projects; we only
                    provide the "Inquiry" or "Lead."</p>

                <h2>2. Lead Categories & Pricing</h2>
                <p>Leads are categorized based on the client's estimated budget:</p>
                <div class="category-box"><strong>Basic:</strong> ₹15,000+</div>
                <div class="category-box"><strong>Business:</strong> ₹30,000+</div>
                <div class="category-box"><strong>Premium:</strong> ₹50,000+</div>
                <p>The price per lead is determined by its category and is subject to change at our discretion.</p>

                <h2>3. No Conversion Guarantee</h2>
                <ul>
                    <li><strong>Sales Responsibility:</strong> The conversion of a lead into a paid project depends
                        entirely on the Buyer’s sales expertise, portfolio, and communication.</li>
                    <li><strong>No Results Warranty:</strong> QuickProject.in makes no guarantee that a lead will result
                        in a contract, payment, or successful business relationship.</li>
                </ul>

                <h2>4. Strict Non-Refundable Policy</h2>
                <div class="policy-alert">
                    <ul>
                        <li><strong>Final Sale:</strong> Once a lead is purchased (unblurred/unlocked), the transaction
                            is final and non-refundable.</li>
                        <li><strong>Wallet Balance:</strong> Money added to the QuickProject.in wallet is non-refundable
                            and cannot be withdrawn. It can only be used to purchase leads on this platform.</li>
                        <li><strong>Refusal to Pay:</strong> Refunds will not be granted if the client refuses to pay
                            your quoted price or chooses another developer.</li>
                    </ul>
                </div>

                <h2>5. Lead Replacement Policy</h2>
                <p>Replacement of a lead (credit back to wallet) is only applicable under the following conditions:</p>
                <ul>
                    <li>The phone number provided is Invalid or Does not exist.</li>
                    <li>The niche/requirement is completely irrelevant to web development.</li>
                </ul>
                <p><strong>Note:</strong> Claims must be raised within 24 hours of purchase. "Client not picking up" or
                    "Client not interested" does NOT qualify for a replacement.</p>

                <h2>6. Wallet & Pre-booking</h2>
                <ul>
                    <li><strong>Individual Purchase:</strong> Buyers can purchase leads individually as they appear on
                        the dashboard.</li>
                    <li><strong>Wallet:</strong> Buyers can maintain a balance for faster, one-click purchases.</li>
                    <li><strong>Pre-booking:</strong> Exclusive access to high-budget leads may be offered to premium
                        agencies via pre-booking agreements.</li>
                </ul>

                <h2>7. Intellectual Property & Exclusivity</h2>
                <p>Unless otherwise stated, leads are sold on an Exclusive basis. Once you purchase a lead, it is yours
                    alone. Sharing, reselling, or distributing lead data to third parties is strictly prohibited and
                    will lead to an immediate ban without a refund.</p>

                <h2>8. Limitation of Liability</h2>
                <p>QuickProject.in (and Viral Verse Media) shall not be held liable for any financial losses, loss of
                    business, or disputes between the Buyer and the Lead Client.</p>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>