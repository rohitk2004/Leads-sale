<?php
require_once 'db.php';

echo "<h3>Live Site Diagnostics</h3>";
echo "<strong>Environment connected database:</strong> " . htmlspecialchars($db) . "<br><hr>";

// Count leads
$stmt = $pdo->query("SELECT COUNT(*) FROM leads");
$total = $stmt->fetchColumn();
echo "Total leads in database: <strong>$total</strong><br>";

// Count available
$stmt = $pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'available'");
$available = $stmt->fetchColumn();
echo "Available leads in database: <strong>$available</strong><br><hr>";

// List all leads explicitly
$stmt = $pdo->query("SELECT * FROM leads");
$all_leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($all_leads)) {
    echo "<h4 style='color:red;'>⚠️ Your leads table is completely EMPTY! This is why the frontend has no data!</h4>";
    echo "To fix this, upload your Local PC database properly through phpMyAdmin, OR run <a href='seed_live.php'>seed_live.php</a> to automatically inject sample leads!";
} else {
    echo "<h4>Leads currently stored:</h4>";
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>ID</th><th>Niche</th><th>Status</th><th>Budget</th><th>Price</th></tr>";
    foreach ($all_leads as $lead) {
        echo "<tr>";
        echo "<td>" . $lead['id'] . "</td>";
        echo "<td>" . htmlspecialchars($lead['niche']) . "</td>";
        echo "<td>" . $lead['status'] . "</td>";
        echo "<td>" . $lead['budget'] . "</td>";
        echo "<td>" . $lead['lead_price'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<hr>";
echo "<p>If the table holds leads but they aren't on the frontend, check your browser developer tools for Javascript errors.</p>";
?>
