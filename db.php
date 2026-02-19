<?php
// Local Development
$host = 'localhost';
$db = 'lead_selling_db'; // Ensure this database exists in phpMyAdmin
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Production Settings (Uncomment for Live Site)
// $host = 'localhost';
// $db = 'u891532816_sales';
// $user = 'u891532816_rohit';
// $pass = 'Rohit@@9313##';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // If database not found (Error 1049), redirect to setup
    /* if ($e->getCode() == 1049) {
        header("Location: setup.php");
        exit;
    } */
    // throw new \PDOException($e->getMessage(), (int) $e->getCode());
    die("<h3>Database Connection Failed</h3><p>Please check your configuration.</p>");
}
?>