<?php
require_once 'db.php';

try {
    // Database connection is already established in db.php via $pdo
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database `$db`.<br>";

    // 3. Connect to the database
    $pdo->exec("USE `$db`");

    // 4. Read schema
    $sql = file_get_contents('schema.sql');

    // 5. Execute schema
    $pdo->exec($sql);
    echo "Database schema imported successfully.<br>";

    // 6. Create default admin if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $passHash = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, wallet_balance) VALUES ('admin', ?, 'admin', 0)");
        $stmt->execute([$passHash]);
        echo "Default Admin user created (User: admin, Pass: admin123).<br>";
    } else {
        echo "Admin user already exists.<br>";
    }

    echo "<h3 style='color:green'>Setup complete!</h3> <a href='login.php'>Go to Login</a>";

} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
?>