<?php
// seed_live.php
require_once 'db.php';

try {
    // Basic sample leads to seed
    $sample_leads = [
        [
            'niche' => 'E-commerce Website Redesign',
            'budget' => 50000.00,
            'lead_price' => 499.00,
            'description' => 'Looking to redesign our Shopify store to improve conversion rates and add a custom product builder. Need modern UI/UX design.',
            'client_name' => 'Amit Patel',
            'client_phone' => '9876543210'
        ],
        [
            'niche' => 'Real Estate App Flutter',
            'budget' => 30000.00,
            'lead_price' => 249.00,
            'description' => 'Need a cross-platform mobile app for our real estate agency. Should include property listings, map view, and agent contact forms.',
            'client_name' => 'Sara Sharma',
            'client_phone' => '8765432109'
        ],
        [
            'niche' => 'Law Firm SEO & Website',
            'budget' => 15000.00,
            'lead_price' => 99.00,
            'description' => 'We need a professional 5-page WordPress website for our law firm including SEO optimization for local search terms.',
            'client_name' => 'Vikram Singh',
            'client_phone' => '7654321098'
        ],
        [
            'niche' => 'Portfolio for Photographer',
            'budget' => 15000.00,
            'lead_price' => 99.00,
            'description' => 'Looking for a clean, minimalist portfolio website to showcase my wedding photography. Needs a contact form and gallery.',
            'client_name' => 'Priya Das',
            'client_phone' => '9012345678'
        ]
    ];

    echo "<h3>Seeding Live Database...</h3>";

    foreach ($sample_leads as $lead) {
        // Check if lead already exists to avoid duplicates if run multiple times
        $check = $pdo->prepare("SELECT id FROM leads WHERE client_name = ? AND niche = ?");
        $check->execute([$lead['client_name'], $lead['niche']]);
        if (!$check->fetch()) {
            $stmt = $pdo->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, 'available')");
            $stmt->execute([
                $lead['niche'], 
                $lead['budget'], 
                $lead['lead_price'], 
                $lead['description'], 
                $lead['client_name'], 
                $lead['client_phone']
            ]);
            echo "✅ Added " . htmlspecialchars($lead['niche']) . "<br>";
        } else {
            echo "⏭️ Skipped " . htmlspecialchars($lead['niche']) . " (Already exists)<br>";
        }
    }

    echo "<h3>Live Seeding Complete! <a href='index'>Go to Home</a></h3>";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
