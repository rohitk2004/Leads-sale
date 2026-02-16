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
        $lead_price = 999;
    elseif ($budget == 30000)
        $lead_price = 2499;
    elseif ($budget == 50000)
        $lead_price = 4999;
    else
        $lead_price = 999; // Fallback

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
    <title>Admin Dashboard - Quick Project</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-section {
            padding: 60px 0;
            background: #f8fafc;
            min-height: 100vh;
        }

        .admin-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
            padding: 40px;
            margin-bottom: 40px;
            border: 1px solid rgba(0, 0, 0, 0.02);
            transition: transform 0.3s ease;
        }

        .admin-card h2 {
            margin-bottom: 30px;
            font-size: 1.5rem;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .highlight-bar {
            width: 4px;
            height: 24px;
            background: var(--success-color);
            border-radius: 4px;
            display: inline-block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: #64748b;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s;
            font-family: inherit;
            font-size: 1rem;
            color: #1e293b;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--accent-primary);
            background: white;
            outline: none;
            box-shadow: 0 0 0 4px rgba(44, 95, 125, 0.1);
        }

        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        /* Table Styles */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
            background: white;
        }

        .admin-table th {
            text-align: left;
            padding: 20px 24px;
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .admin-table td {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
            font-size: 0.95rem;
        }

        .admin-table tr:hover td {
            background: #f8fafc;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-available {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .status-sold {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }

        .client-info span {
            display: block;
        }

        .client-name {
            font-weight: 600;
            color: #0f172a;
        }

        .client-phone {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 4px;
        }

        .price-tag {
            font-weight: 700;
            color: #059669;
            background: #ecfdf5;
            padding: 4px 10px;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section class="page-header"
        style="padding: 80px 0; background: linear-gradient(135deg, #0f172a 0%, #334155 100%); color: white;">
        <div class="container">
            <h1 style="color: white; margin-bottom: 15px; font-size: 2.5rem;">Admin Dashboard</h1>
            <p style="opacity: 0.8; font-size: 1.1rem; max-width: 600px;">Manage leads, track status, and oversee
                marketplace operations from one central hub.</p>
        </div>
    </section>

    <div class="admin-section">
        <div class="container">

            <?php if (!empty($message)): ?>
                <div class="admin-card"
                    style="border-left: 5px solid <?php echo $msg_type == 'success' ? '#22c55e' : '#ef4444'; ?>; padding: 20px; margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
                    <div style="font-size: 1.5rem;">
                        <?php echo $msg_type == 'success' ? '🎉' : '⚠️'; ?>
                    </div>
                    <div>
                        <h4
                            style="margin: 0; color: <?php echo $msg_type == 'success' ? '#15803d' : '#b91c1c'; ?>; font-size: 1.1rem;">
                            <?php echo $msg_type == 'success' ? 'Success' : 'Error'; ?>
                        </h4>
                        <p style="margin: 5px 0 0 0; color: #475569;">
                            <?php echo htmlspecialchars($message); ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <h2><span class="highlight-bar"></span> Add New Lead</h2>
                <form method="POST">
                    <input type="hidden" name="add_lead" value="1">

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Niche Category</label>
                            <input type="text" name="niche" class="form-control" required
                                placeholder="e.g. E-commerce Website, Real Estate App">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Client Budget</label>
                            <select name="budget" class="form-control">
                                <option value="15000">Basic (Budget: ₹15k - ₹30k) - Price: ₹999</option>
                                <option value="30000">Business (Budget: ₹30k - ₹50k) - Price: ₹2,499</option>
                                <option value="50000">Premium (Budget: ₹50k - ₹1L+) - Price: ₹4,999</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Project Description</label>
                        <textarea name="description" class="form-control" required rows="4"
                            placeholder="Enter detailed project requirements..."></textarea>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Client Name</label>
                            <input type="text" name="client_name" class="form-control" required
                                placeholder="Start typing name...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Client Phone Number</label>
                            <input type="text" name="client_phone" class="form-control" required
                                placeholder="+91 98765 43210">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>🚀 Publish Lead to Marketplace</span>
                    </button>
                </form>
            </div>

            <div class="admin-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <h2><span class="highlight-bar"></span> All Leads Database</h2>
                    <span
                        style="background: #f1f5f9; padding: 6px 12px; border-radius: 20px; font-weight: 600; color: #64748b; font-size: 0.9rem;">
                        <?php echo count($leads); ?> Total Leads
                    </span>
                </div>

                <div class="table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Niche & Requirements</th>
                                <th>Budget Est.</th>
                                <th>Listing Price</th>
                                <th>Client Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $lead): ?>
                                <tr>
                                    <td>
                                        <span style="font-weight: 700; color: #94a3b8;">#<?php echo $lead['id']; ?></span>
                                    </td>
                                    <td style="max-width: 300px;">
                                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                            <?php echo htmlspecialchars($lead['niche']); ?>
                                        </div>
                                        <div
                                            style="font-size: 0.85rem; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?php echo htmlspecialchars(substr($lead['description'], 0, 50)) . '...'; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            style="font-weight: 600; color: #334155;">₹<?php echo number_format($lead['budget']); ?>+</span>
                                    </td>
                                    <td>
                                        <span class="price-tag">₹<?php echo number_format($lead['lead_price']); ?></span>
                                    </td>
                                    <td>
                                        <div class="client-info">
                                            <span
                                                class="client-name"><?php echo htmlspecialchars($lead['client_name']); ?></span>
                                            <span
                                                class="client-phone"><?php echo htmlspecialchars($lead['client_phone']); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($lead['status'] == 'available'): ?>
                                            <span class="status-badge status-available">
                                                <span
                                                    style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></span>
                                                Available
                                            </span>
                                        <?php else: ?>
                                            <span class="status-badge status-sold">
                                                <span
                                                    style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></span>
                                                Sold Out
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>