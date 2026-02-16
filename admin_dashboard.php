<?php
require_once 'functions.php';
require_login('admin');

$message = "";
$msg_type = "";

// Add Lead Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_lead'])) {
    $niche = trim($_POST['niche']);
    $budget = (float) $_POST['budget'];
    $desc = trim($_POST['description']);
    $name = trim($_POST['client_name']);
    $phone = trim($_POST['client_phone']);

    // Calculate lead price based on budget
    $lead_price = 0;
    if ($budget == 15000)
        $lead_price = 1000;
    elseif ($budget == 30000)
        $lead_price = 2000;
    elseif ($budget == 50000)
        $lead_price = 3000;
    else
        $lead_price = 1000; // Fallback

    try {
        $stmt = $pdo->prepare("INSERT INTO leads (niche, budget, lead_price, description, client_name, client_phone, status) VALUES (?, ?, ?, ?, ?, ?, 'available')");
        if ($stmt->execute([$niche, $budget, $lead_price, $desc, $name, $phone])) {
            $message = "Lead added successfully!";
            $msg_type = "success";
        } else {
            $message = "Failed to add lead.";
            $msg_type = "error";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
        $msg_type = "error";
    }
}

// Fetch all leads
$stmt = $pdo->query("SELECT * FROM leads ORDER BY created_at DESC");
$leads = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <div class="container">
            <h1>Admin Panel</h1>
            <nav>
                <span class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">

        <?php if (!empty($message)): ?>
            <div class="card"
                style="border-left: 4px solid <?php echo $msg_type == 'success' ? 'var(--success-color)' : 'var(--accent-color)'; ?>">
                <p
                    style="margin:0; color: <?php echo $msg_type == 'success' ? 'var(--success-color)' : 'var(--accent-color)'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="card">
            <h2><span style="border-bottom: 3px solid var(--success-color);">Add New Lead</span></h2>
            <form method="POST">
                <input type="hidden" name="add_lead" value="1">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label class="text-muted">Niche</label>
                        <input type="text" name="niche" required placeholder="e.g. Website Development">
                    </div>
                    <div>
                        <label class="text-muted">Budget</label>
                        <select name="budget">
                            <option value="15000">15k (Price: 1000)</option>
                            <option value="30000">30k (Price: 2000)</option>
                            <option value="50000">50k (Price: 3000)</option>
                        </select>
                    </div>
                </div>

                <label class="text-muted">Description</label>
                <textarea name="description" required rows="3" placeholder="Project details..."></textarea>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label class="text-muted">Client Name</label>
                        <input type="text" name="client_name" required placeholder="John Doe">
                    </div>
                    <div>
                        <label class="text-muted">Client Phone</label>
                        <input type="text" name="client_phone" required placeholder="+91 99999 99999">
                    </div>
                </div>

                <button type="submit" class="btn btn-green" style="width: 100%;">Post Lead</button>
            </form>
        </div>

        <div class="card">
            <h2>All Leads</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Niche</th>
                        <th>Budget</th>
                        <th>Price</th>
                        <th>Client</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td>#<?php echo $lead['id']; ?></td>
                            <td><?php echo htmlspecialchars($lead['niche']); ?></td>
                            <td>₹<?php echo number_format($lead['budget']); ?></td>
                            <td>₹<?php echo number_format($lead['lead_price']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($lead['client_name']); ?>
                                <br>
                                <small class="text-muted"><?php echo htmlspecialchars($lead['client_phone']); ?></small>
                            </td>
                            <td>
                                <?php if ($lead['status'] == 'available'): ?>
                                    <span class="badge badge-new"
                                        style="background: linear-gradient(135deg, rgba(45, 134, 89, 0.15) 0%, rgba(45, 134, 89, 0.1) 100%); color: var(--success-color); border: 1px solid rgba(45, 134, 89, 0.2);">Available</span>
                                <?php else: ?>
                                    <span class="badge badge-sold"
                                        style="background: linear-gradient(135deg, rgba(199, 137, 63, 0.15) 0%, rgba(199, 137, 63, 0.1) 100%); color: var(--warning-color); border: 1px solid rgba(199, 137, 63, 0.2);">Sold</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>