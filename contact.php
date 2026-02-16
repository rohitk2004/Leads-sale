<?php
require_once 'functions.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_contact'])) {
    // In a real application, you would send an email here
    // For now, we'll just show a success message
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Simulate successful submission
    $success_message = "Thank you, $name! Your message has been sent successfully. We will get back to you shortly.";
}

$cart_count = count(get_cart_items($pdo));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Quick Project</title>
    <meta name="description" content="Get in touch with our team for support or inquiries.">
    <link rel="stylesheet" href="style.css">
    <style>
        .contact-section {
            padding: 60px 0;
            background-color: #f8fafc;
        }

        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .contact-info {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            color: white;
            padding: 50px;
            position: relative;
            overflow: hidden;
        }

        .contact-info::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .contact-info::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .contact-info h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .contact-info p {
            margin-bottom: 30px;
            opacity: 0.9;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .contact-form {
            padding: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #334155;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            position: relative;
            z-index: 1;
        }

        .social-link {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: white;
            color: #2563eb;
            transform: translateY(-3px);
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #22c55e;
        }

        @media (max-width: 768px) {
            .contact-container {
                grid-template-columns: 1fr;
            }

            .contact-form,
            .contact-info {
                padding: 30px;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Contact Us</h1>
            <p class="page-subtitle">Have questions? We're here to help you grow your business.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-container animate-in">
                <!-- Contact Info Column -->
                <div class="contact-info">
                    <h3>Get in Touch</h3>
                    <p>Whether you have a question about features, pricing, or anything else, our team is ready to
                        answer all your questions.</p>

                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div>
                            <strong>Our Office</strong><br>
                            123 Business Park, Tech City<br>
                            Mumbai, India 400001
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📧</div>
                        <div>
                            <strong>Email Us</strong><br>
                            <a href="mailto:support@quickproject.in"
                                style="color: white; text-decoration: underline;">support@quickproject.in</a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📞</div>
                        <div>
                            <strong>Call Us</strong><br>
                            <a href="tel:+919876543210" style="color: white; text-decoration: underline;">+91 98765
                                43210</a>
                        </div>
                    </div>

                    <div class="social-links">
                        <a href="#" class="social-link">f</a>
                        <a href="#" class="social-link">t</a>
                        <a href="#" class="social-link">in</a>
                        <a href="#" class="social-link">ig</a>
                    </div>
                </div>

                <!-- Contact Form Column -->
                <div class="contact-form">
                    <h3>Send us a Message</h3>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert-success">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Your Name"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="you@example.com" required>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control"
                                placeholder="How can we help?" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" class="form-control" rows="5"
                                placeholder="Write your message here..." required></textarea>
                        </div>

                        <button type="submit" name="submit_contact" class="btn btn-primary btn-lg"
                            style="width: 100%;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>