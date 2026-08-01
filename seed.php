<?php
// Force clean and re-seed all databases (MySQL & SQLite)

$host = 'localhost';
$db = 'lead_selling_db';
$user = 'root';
$pass = '';

$courses = [
    [
        'Tech Support Inbound Call Generation Masterclass', 
        24999, 
        24999, 
        'Complete blueprint for generating 500+ daily inbound tech support calls via high-velocity indexing, parasite SERP takeover, and cloaked landing pages.', 
        'Suresh Das (25+ Yrs Industry Expert)', 
        '+91 9811002233', 
        'available'
    ],
    [
        'Airlines & Flight Reservation SEO Call Generation', 
        24999, 
        24999, 
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
        'Basic Black Hat SEO Training Package', 
        9999, 
        9999, 
        'Fundamentals of aggressive SEO, high-velocity indexing pipelines, parasite web 2.0 setup, and SERP rank tracking.', 
        'BlackHat SEO Elite', 
        '+91 9811002288', 
        'available'
    ]
];

// 1. Try MySQL
try {
    $pdo_mysql = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $pdo_mysql->exec("TRUNCATE TABLE leads");
    $stmt = $pdo_mysql->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($courses as $c) {
        $stmt->execute($c);
    }
    echo "✅ MySQL Database `lead_selling_db` purged and re-seeded successfully.<br>";
} catch (Exception $e) {
    echo "ℹ️ MySQL info: " . $e->getMessage() . "<br>";
}

// 2. Try SQLite
try {
    $sqlite_file = __DIR__ . '/lead_selling_db.sqlite';
    $pdo_sqlite = new PDO("sqlite:" . $sqlite_file);
    $pdo_sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo_sqlite->exec("DELETE FROM leads");
    $stmt = $pdo_sqlite->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($courses as $c) {
        $stmt->execute($c);
    }
    echo "✅ SQLite Database purged and re-seeded successfully.<br>";
} catch (Exception $e) {
    echo "ℹ️ SQLite info: " . $e->getMessage() . "<br>";
}
?>