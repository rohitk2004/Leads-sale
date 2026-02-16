<?php
require_once 'db.php';

try {
    // Add cart table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        session_id VARCHAR(100) NOT NULL,
        lead_id INT NOT NULL,
        added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (lead_id) REFERENCES leads(id),
        UNIQUE KEY unique_cart_item (session_id, lead_id)
    )";

    $pdo->exec($sql);

    echo "<h2 style='color: green;'>✓ Cart table created successfully!</h2>";
    echo "<p>You can now go back to: <a href='index.php'>Homepage</a></p>";

} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Error: " . $e->getMessage() . "</h2>";
}
?>