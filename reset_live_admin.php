<?php
require 'db.php';

// Force the connection to production database if you want to run this locally but target remote,
// but usually you just upload this to the live website and open it.

try {    
    // Create new admin user or update existing
    $username = 'admin';
    $password = 'admin123';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if admin exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$hashed_password, $username]);
        echo "Live Admin Password Updated! You can now login with admin / admin123";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, wallet_balance) VALUES (?, ?, 'admin', 0.00)");
        $stmt->execute([$username, $hashed_password]);
        echo "Live Admin Created! You can now login with admin / admin123";
    }

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
