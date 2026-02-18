<?php
require_once 'db.php';

try {
    echo "<h2>Seeding Database...</h2>";

    // 1. Add some leads if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM leads");
    if ($stmt->fetchColumn() == 0) {
        $leads = [
            ['E-commerce Website Redesign', 50000, 4999, 'Looking for a complete redesign of our Shopify store with custom theme development.', 'Rajesh Kumar', '+91 9876543210', 'available'],
            ['Real Estate App Flutter', 30000, 2499, 'Need a hybrid mobile app for property listing with map integration.', 'Sneha Gupta', '+91 9898989898', 'available'],
            ['Law Firm SEO & Website', 15000, 999, 'Basic Wordpress site for a law firm with SEO optimization.', 'Amit Singh', '+91 8765432109', 'available'],
            ['Hospital Management System', 50000, 4999, 'Web-based ERP for a 50-bed hospital. Needs patient records & billing.', 'Dr. Mehta', '+91 7654321098', 'sold'],
            ['Portfolio for Photographer', 15000, 999, 'Minimalist portfolio site with gallery and contact form.', 'Priya Art', '+91 6543210987', 'available']
        ];

        $stmt = $pdo->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, ?)");

        foreach ($leads as $lead) {
            $stmt->execute($lead);
        }
        echo "✅ Added 5 demo leads.<br>";
    } else {
        echo "ℹ️ Leads table already has data.<br>";
    }

    // 2. Add a dummy developer user if none
    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'developer'");
    if ($stmt->fetchColumn() == 0) {
        $pass = password_hash('dev123', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (username, password, role, wallet_balance) VALUES ('dev_demo', ?, 'developer', 1500.00)")
            ->execute([$pass]);
        echo "✅ Added demo developer user (dev_demo / dev123).<br>";
    } else {
        echo "ℹ️ Developers already exist.<br>";
    }

    // 3. Add a purchased lead record if sold leads exist but no purchase record
    // This is to populate the sales chart
    $stmt = $pdo->query("SELECT id FROM leads WHERE status = 'sold' LIMIT 1");
    $sold_lead = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT id FROM users WHERE role = 'developer' LIMIT 1");
    $dev_user = $stmt->fetchColumn();

    if ($sold_lead && $dev_user) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM purchased_leads");
        if ($stmt->fetchColumn() == 0) {
            $pdo->prepare("INSERT INTO purchased_leads (user_id, lead_id, purchase_price, purchased_at) VALUES (?, ?, 4999.00, NOW() - INTERVAL 2 DAY)")
                ->execute([$dev_user, $sold_lead]);
            echo "✅ Added demo purchase record.<br>";
        }
    }

    echo "<h3>Done! <a href='admin_dashboard.php'>Go to Dashboard</a></h3>";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>