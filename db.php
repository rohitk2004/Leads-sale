<?php
// Check environment
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$db = 'lead_selling_db';
$user = 'root';
$pass = '';

// If accessed via a live public domain
if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') === false && strpos($_SERVER['HTTP_HOST'], '127.0.0.1') === false && strpos($_SERVER['HTTP_HOST'], '192.168.') === false) {
    $db = 'u891532816_sales';
    $user = 'u891532816_rohit';
    $pass = 'Rohit@@9313##';
}

$charset = 'utf8mb4';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Fallback to SQLite if MySQL service is offline locally
    $sqlite_file = __DIR__ . '/lead_selling_db.sqlite';
    $pdo = new PDO("sqlite:" . $sqlite_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Auto-create SQLite schema if empty
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='leads'")->fetchAll();
    if (empty($tables)) {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                role TEXT DEFAULT 'developer',
                wallet_balance REAL DEFAULT 0.00,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS leads (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                niche TEXT NOT NULL,
                budget REAL NOT NULL,
                lead_price REAL NOT NULL,
                description TEXT,
                client_name TEXT NOT NULL,
                client_phone TEXT NOT NULL,
                status TEXT DEFAULT 'available',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS purchased_leads (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                lead_id INTEGER NOT NULL,
                purchase_price REAL NOT NULL,
                purchased_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS cart (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                session_id TEXT NOT NULL,
                lead_id INTEGER NOT NULL,
                added_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");

        // Seed default BlackHat SEO courses
        $courses = [
            ['Tech Support Inbound Call Generation Masterclass', 9999, 9999, 'Complete blueprint for generating 500+ daily inbound tech support calls via high-velocity indexing and cloaked landing pages.', 'Suresh Das (25+ Yrs Industry Expert)', '+91 9811002233', 'available'],
            ['Airlines & Flight Reservation SEO Call Generation', 14999, 14999, 'Advanced course on ranking flight booking & GDS search keywords within 48 hours using high-authority PBNs.', 'BlackHat SEO Advisory', '+91 9811002244', 'available'],
            ['CTR Manipulation & SERP Rank Automation Bot Suite', 19999, 19999, 'Access to residential proxy CTR manipulation software and search dwell time emulation.', 'BlackHat Tech Team', '+91 9811002255', 'available'],
            ['High-Velocity PBN & Expired Domain Network Blueprint', 12499, 12499, 'Step-by-step expired domain hunting, metric validation, host fingerprint obfuscation.', 'Suresh Das', '+91 9811002266', 'available'],
            ['QuickBooks & Financial Accounting Lead Gen SEO', 24999, 24999, 'High-ticket accounting call generation methodology for financial software support.', 'Lead Gen Academy', '+91 9811002277', 'available']
        ];

        $stmt = $pdo->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($courses as $c) {
            $stmt->execute($c);
        }
    }
}
?>