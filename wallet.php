<?php
require_once 'functions.php';
require_login('developer');

$user_id = $_SESSION['user_id'];
$message = "";
$msg_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['amount'])) {
    $amount = floatval($_POST['amount']);

    if ($amount > 0) {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?");
            if ($stmt->execute([$amount, $user_id])) {
                $stmt = $pdo->prepare("INSERT INTO transactions (user_id, amount, type, description) VALUES (?, ?, 'credit', 'Wallet Top-up')");
                $stmt->execute([$user_id, $amount]);

                $pdo->commit();
                $message = "₹$amount added successfully!";
                $msg_type = "success";
            } else {
                throw new Exception("Failed to update balance.");
            }

        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "Transaction failed: " . $e->getMessage();
            $msg_type = "error";
        }
    } else {
        $message = "Invalid amount.";
        $msg_type = "error";
    }
}

$current_balance = get_user_balance($pdo, $user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wallet - Quick Project</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <div class="container">
            <h1>My Wallet</h1>
            <nav>
                <a href="developer_dashboard.php">Dashboard</a>
                <a href="logout.php" style="color:red;">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">

            <!-- Balance & Top-up -->
            <div class="card">
                <h3>Current Balance</h3>
                <h1 class="text-green" style="font-size: 3rem; margin: 10px 0;">
                    ₹<?php echo number_format($current_balance, 2); ?></h1>

                <?php if (!empty($message)): ?>
                    <p
                        style="color: <?php echo $msg_type == 'success' ? 'var(--success-color)' : 'var(--accent-color)'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </p>
                <?php endif; ?>

                <form method="POST" style="margin-top: 20px;">
                    <label class="text-muted">Enter Amount to Add</label>
                    <input type="number" name="amount" min="100" required placeholder="e.g. 5000">
                    <button type="submit" class="btn btn-green" style="width:100%;">Add Money (Mock)</button>
                </form>
            </div>

            <!-- Transaction History -->
            <div class="card">
                <h3>Transaction History</h3>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
                $stmt->execute([$user_id]);
                $transactions = $stmt->fetchAll();
                ?>
                <?php if (empty($transactions)): ?>
                    <p class="text-muted">No transactions yet.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td class="text-muted"><?php echo date('d M, h:i A', strtotime($t['created_at'])); ?></td>
                                    <td><?php echo htmlspecialchars($t['description']); ?></td>
                                    <td>
                                        <?php if ($t['type'] == 'credit'): ?>
                                            <span class="badge badge-new">Credit</span>
                                        <?php else: ?>
                                            <span class="badge badge-sold">Debit</span>
                                        <?php endif; ?>
                                    </td>
                                    <td
                                        style="font-weight: bold; color: <?php echo $t['type'] == 'credit' ? 'var(--success-color)' : 'var(--accent-color)'; ?>">
                                        <?php echo $t['type'] == 'credit' ? '+' : '-'; ?>
                                        ₹<?php echo number_format($t['amount'], 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        </div>
    </div>

</body>

</html>