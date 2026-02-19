<?php
require_once 'db.php';

try {
    // 1. Delete existing admin user if exists to start fresh
    $stmt = $pdo->prepare("DELETE FROM users WHERE username = 'Rohit585'");
    $stmt->execute();

    // 2. Create new admin user
    $username = 'Rohit585';
    $password = 'Rohit@9313';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'admin';
    $wallet_balance = 0.00;

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role, wallet_balance) VALUES (?, ?, ?, ?)");

    if ($stmt->execute([$username, $hashed_password, $role, $wallet_balance])) {
        echo "<div style='font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; text-align: center;'>";
        echo "<h2 style='color: #2ecc71;'>Admin User Reset Successfully!</h2>";
        echo "<p>You can now login with the following credentials:</p>";
        echo "<p><strong>Username:</strong> Rohit585</p>";
        echo "<p><strong>Password:</strong> Rohit@9313</p>";
        echo "<br>";
        echo "<a href='login' style='display: inline-block; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px;'>Go to Login</a>";
        echo "</div>";
    } else {
        echo "Error: Could not insert admin user.";
    }

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>