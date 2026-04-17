<?php
require_once 'functions.php';
require_login('admin');

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard");
    exit;
}

$id = (int) $_GET['id'];
$message = "";
$msg_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_lead'])) {
    $niche = trim($_POST['niche']);
    $budget = (float) $_POST['budget'];
    $desc = trim($_POST['description']);
    $name = trim($_POST['client_name']);
    $phone = trim($_POST['client_phone']);
    $status = $_POST['status'];
    // Recalculate price based on budget
    $lead_price = ($budget == 5000) ? 2 : (($budget == 50000) ? 499 : (($budget == 30000) ? 249 : 99));

    try {
        $stmt = $pdo->prepare("UPDATE leads SET niche=?, budget=?, lead_price=?, description=?, client_name=?, client_phone=?, status=? WHERE id=?");
        $stmt->execute([$niche, $budget, $lead_price, $desc, $name, $phone, $status, $id]);
        $message = "Lead updated successfully!";
        $msg_type = "success";
    } catch (PDOException $e) {
        $message = "Error updating lead: " . $e->getMessage();
        $msg_type = "error";
    }
}

$stmt = $pdo->prepare("SELECT * FROM leads WHERE id = ?");
$stmt->execute([$id]);
$lead = $stmt->fetch();

if (!$lead) {
    echo "Lead not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lead — QuickProject</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            padding: 40px 20px;
        }

        .edit-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            color: #374151;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            box-sizing: border-box;
            background: #f9fafb;
            transition: all 0.2s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-update {
            width: 100%;
            padding: 14px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-update:hover {
            background: #1d4ed8;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 24px;
            text-decoration: none;
            color: #6b7280;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .btn-back:hover {
            color: #111827;
            background: #f3f4f6;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
    </style>
</head>

<body>

    <div class="edit-container">
        <a href="admin_dashboard" class="btn-back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Dashboard
        </a>

        <h2 style="margin-bottom: 24px; font-weight: 800; color: #111827; font-size: 1.5rem;">Edit Lead #
            <?php echo $lead['id']; ?>
        </h2>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $msg_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="edit_lead" value="1">

            <div class="form-group">
                <label>Niche / Category</label>
                <input type="text" name="niche" value="<?php echo htmlspecialchars($lead['niche']); ?>" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" name="client_name" value="<?php echo htmlspecialchars($lead['client_name']); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Client Phone</label>
                    <input type="text" name="client_phone"
                        value="<?php echo htmlspecialchars($lead['client_phone']); ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Budget Tier</label>
                    <select name="budget" required>
                        <option value="5000" <?php echo ($lead['budget'] == 5000) ? 'selected' : ''; ?>>Testing (₹5,000)
                        </option>
                        <option value="15000" <?php echo ($lead['budget'] == 15000) ? 'selected' : ''; ?>>Basic (₹15,000
                            - ₹30,000)</option>
                        <option value="30000" <?php echo ($lead['budget'] == 30000) ? 'selected' : ''; ?>>Business
                            (₹30,000 - ₹50,000)</option>
                        <option value="50000" <?php echo ($lead['budget'] >= 50000) ? 'selected' : ''; ?>>Premium
                            (₹50,000+)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="available" <?php echo ($lead['status'] === 'available') ? 'selected' : ''; ?>
                            >Available</option>
                        <option value="sold" <?php echo ($lead['status'] === 'sold') ? 'selected' : ''; ?>>Sold</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Project Description</label>
                <textarea name="description" rows="5"
                    required><?php echo htmlspecialchars($lead['description']); ?></textarea>
            </div>

            <button type="submit" class="btn-update">Save Changes</button>
        </form>
    </div>

</body>

</html>