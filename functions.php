<?php
require_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in and has specific role
 */
function require_login($role = null)
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: login");
        exit;
    }
    if ($role && $_SESSION['role'] !== $role) {
        header("Location: login");
        exit;
    }
}

/**
 * Get or create session cart ID
 */
function get_cart_session_id()
{
    if (!isset($_SESSION['cart_id'])) {
        $_SESSION['cart_id'] = session_id();
    }
    return $_SESSION['cart_id'];
}

/**
 * Add lead to cart
 */
function add_to_cart($pdo, $lead_id)
{
    $session_id = get_cart_session_id();

    try {
        $stmt = $pdo->prepare("INSERT IGNORE INTO cart (session_id, lead_id) VALUES (?, ?)");
        $stmt->execute([$session_id, $lead_id]);
        return ['success' => true, 'message' => 'Added to cart!'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Failed to add to cart.'];
    }
}

/**
 * Get cart items with lead details
 */
function get_cart_items($pdo)
{
    $session_id = get_cart_session_id();

    $sql = "SELECT c.id as cart_id, l.* 
            FROM cart c 
            JOIN leads l ON c.lead_id = l.id 
            WHERE c.session_id = ? AND l.status = 'available'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$session_id]);
    return $stmt->fetchAll();
}

/**
 * Get cart total
 */
function get_cart_total($pdo)
{
    $items = get_cart_items($pdo);
    $total = 0;
    foreach ($items as $item) {
        $total += $item['lead_price'];
    }
    return $total;
}

/**
 * Remove item from cart
 */
function remove_from_cart($pdo, $cart_id)
{
    $session_id = get_cart_session_id();
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND session_id = ?");
    $stmt->execute([$cart_id, $session_id]);
}

/**
 * Clear cart
 */
function clear_cart($pdo)
{
    $session_id = get_cart_session_id();
    $stmt = $pdo->prepare("DELETE FROM cart WHERE session_id = ?");
    $stmt->execute([$session_id]);
}

/**
 * Process checkout - purchase all cart items
 */

/**
 * Get user wallet balance
 */
function get_user_balance($pdo, $user_id)
{
    $stmt = $pdo->prepare("SELECT wallet_balance FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchColumn() ?: 0.00;
}

/**
 * Add funds to user wallet
 */
function add_funds($pdo, $user_id, $amount)
{
    try {
        $pdo->beginTransaction();

        // Update balance
        $stmt = $pdo->prepare("UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?");
        $stmt->execute([$amount, $user_id]);

        // Log transaction
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, amount, type, description) VALUES (?, ?, 'credit', 'Wallet Top-up')");
        $stmt->execute([$user_id, $amount]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

/**
 * Process checkout - purchase all cart items using wallet balance
 */
/**
 * Execute the purchase logic: mark leads as sold, record purchase, clear cart.
 * Private helper function.
 */
function execute_purchase_logic($pdo, $user_id, $cart_items)
{
    foreach ($cart_items as $item) {
        // Record purchase
        $stmt = $pdo->prepare("INSERT INTO purchased_leads (user_id, lead_id, purchase_price) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $item['id'], $item['lead_price']]);

        // Mark lead as sold
        $stmt = $pdo->prepare("UPDATE leads SET status = 'sold' WHERE id = ?");
        $stmt->execute([$item['id']]);
    }
    clear_cart($pdo);
}

/**
 * Process checkout - purchase using wallet balance
 */
function process_checkout($pdo, $user_id)
{
    $cart_items = get_cart_items($pdo);

    if (empty($cart_items)) {
        return ['success' => false, 'message' => 'Cart is empty!'];
    }

    $total_cost = 0;
    foreach ($cart_items as $item) {
        $total_cost += $item['lead_price'];
    }

    try {
        $pdo->beginTransaction();

        // Check balance
        $current_balance = get_user_balance($pdo, $user_id);
        if ($current_balance < $total_cost) {
            throw new Exception("Insufficient wallet balance. Please add funds.");
        }

        // Deduct funds
        $stmt = $pdo->prepare("UPDATE users SET wallet_balance = wallet_balance - ? WHERE id = ?");
        $stmt->execute([$total_cost, $user_id]);

        // Log transaction
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, amount, type, description) VALUES (?, ?, 'debit', 'Lead Purchase (Wallet)')");
        $stmt->execute([$user_id, $total_cost]);

        // Execute Purchase Logic
        execute_purchase_logic($pdo, $user_id, $cart_items);

        $pdo->commit();
        return ['success' => true, 'message' => 'Purchase successful! Check your dashboard.'];

    } catch (Exception $e) {
        $pdo->rollBack();
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

/**
 * Process direct purchase - payment verified externally (Razorpay)
 */
function process_direct_purchase($pdo, $user_id, $payment_id)
{
    $cart_items = get_cart_items($pdo);

    if (empty($cart_items)) {
        return false;
    }

    try {
        $pdo->beginTransaction();

        // Optional: Log payment info if you want a record of external payments linked to user?
        // For now, simpler is better. Just record the purchase.

        execute_purchase_logic($pdo, $user_id, $cart_items);

        $pdo->commit();
        return true;

    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

/**
 * Get user's purchased leads
 */
function get_my_purchased_leads($pdo, $user_id)
{
    $sql = "SELECT l.*, pl.purchase_price, pl.purchased_at 
            FROM leads l 
            JOIN purchased_leads pl ON l.id = pl.lead_id 
            WHERE pl.user_id = ? 
            ORDER BY pl.purchased_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

/**
 * Get all available leads for homepage
 */
function get_available_leads($pdo)
{
    $sql = "SELECT * FROM leads WHERE status = 'available'";

    // Show all available leads regardless of budget (Uncomment below to restrict test leads again)
    // if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    //     $sql .= " AND budget != 5000";
    // }

    $sql .= " ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

/**
 * Get all sold leads for homepage
 */
function get_sold_leads($pdo)
{
    $stmt = $pdo->query("SELECT * FROM leads WHERE status = 'sold' ORDER BY created_at DESC");
    return $stmt->fetchAll();
}
