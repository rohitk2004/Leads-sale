<?php
require_once 'db.php';

$stmt = $pdo->query("SELECT id, username, password FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h3>Users Table Dump:</h3>";
foreach($users as $u) {
    echo "ID: {$u['id']} | Username: {$u['username']}<br>";
    echo "Hash: " . htmlspecialchars($u['password']) . "<br>";
    echo "Hash Length: " . strlen($u['password']) . "<br><br>";
}
?>
