<?php
require 'db.php';
echo "<h3>DB Debug Info</h3>";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'NOT SET') . "<br>";
echo "Connected DB: " . $db . "<br>";

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h4>Users in DB:</h4>";
echo "<ul>";
foreach ($users as $u) {
    echo "<li>" . htmlspecialchars($u['username']) . " - Role: " . htmlspecialchars($u['role']) . "</li>";
    if ($u['username'] == 'admin') {
        echo " password_verify admin123: " . (password_verify('admin123', $u['password']) ? "SUCCESS" : "FAILED") . "<br>";
    }
}
echo "</ul>";
?>
