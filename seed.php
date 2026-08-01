<?php
require_once 'db.php';

try {
    echo "<h2 style='color:#00f2fe; font-family:sans-serif;'>Seeding BlackHat SEO Course & Call Gen Marketplace...</h2>";

    // Clean existing leads table
    $pdo->exec("DELETE FROM leads");

    $courses = [
        [
            'Tech Support Inbound Call Generation Masterclass', 
            9999, 
            9999, 
            'Complete blueprint for generating 500+ daily inbound tech support calls via high-velocity indexing, parasite SERP takeover, and cloaked landing pages.', 
            'Suresh Das (25+ Yrs Industry Expert)', 
            '+91 9811002233', 
            'available'
        ],
        [
            'Airlines & Flight Reservation SEO Call Generation', 
            14999, 
            14999, 
            'Advanced course on ranking flight booking & GDS search keywords within 48 hours using high-authority PBNs and automated parasite subdomains.', 
            'BlackHat SEO Advisory', 
            '+91 9811002244', 
            'available'
        ],
        [
            'CTR Manipulation & SERP Rank Automation Bot Suite', 
            19999, 
            19999, 
            'Access to residential proxy CTR manipulation software, custom browser automation scripts, and search dwell time emulation for ranking top 3.', 
            'BlackHat Tech Team', 
            '+91 9811002255', 
            'available'
        ],
        [
            'High-Velocity PBN & Expired Domain Network Blueprint', 
            12499, 
            12499, 
            'Master step-by-step expired domain hunting, metric validation, host fingerprint obfuscation, and tier-1 PBN link insertion techniques.', 
            'Suresh Das', 
            '+91 9811002266', 
            'available'
        ],
        [
            'QuickBooks & Financial Accounting Lead Gen SEO', 
            24999, 
            24999, 
            'High-ticket accounting call generation methodology. Target high-intent financial software support calls with 0 footprint redirection.', 
            'Lead Gen Academy', 
            '+91 9811002277', 
            'available'
        ],
        [
            'Crypto & Forex High-Volume Organic Traffic Engine', 
            29999, 
            29999, 
            'Aggressive parasite SEO techniques for high-competition cryptocurrency exchange, wallet recovery, and trading platform organic traffic.', 
            'BlackHat SEO Elite', 
            '+91 9811002288', 
            'sold'
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, ?)");

    foreach ($courses as $course) {
        $stmt->execute($course);
    }
    echo "✅ Successfully seeded 6 BlackHat SEO Courses & Call Gen Blueprints.<br>";

    // Ensure demo user exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'developer'");
    if ($stmt->fetchColumn() == 0) {
        $pass = password_hash('dev123', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (username, password, role, wallet_balance) VALUES ('seo_student', ?, 'developer', 50000.00)")
            ->execute([$pass]);
        echo "✅ Added demo student user (seo_student / dev123).<br>";
    }

    echo "<h3 style='color:#10b981; font-family:sans-serif;'>Database Seeding Complete! <a href='index' style='color:#00f2fe;'>Return to Homepage</a></h3>";

} catch (PDOException $e) {
    die("Seeding Error: " . $e->getMessage());
}
?>