<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'db.php';
$stmt = $pdo->query("SELECT id, username FROM users WHERE role = 'admin'");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($admins) > 0) {
    foreach ($admins as $admin) {
        $username = $admin['username'];
        $new_pass = 'newadminpass123';
        $hash = password_hash($new_pass, PASSWORD_DEFAULT);

        $upd = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $upd->execute([$hash, $admin['id']]);

        echo "Admin Found! Username: " . $username . "\nPassword has been reset to: " . $new_pass . "\n";
    }
} else {
    echo "No admin users found in the database.\n";
}
?>