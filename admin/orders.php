<?php
// admin/orders.php - Order Fulfillment & Tracking
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$pdo = getDBConnection();
$msg = '';

// Handle Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = sanitize($_POST['status'] ?? 'Pending');
    
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$newStatus, $orderId]);
    $msg = "Order #{$orderId} status updated to '{$newStatus}'!";
}

// Fetch all orders
$orders = $pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders Manager | PHBN Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100 text-spice-dark flex flex-col min-h-screen">

    <header class="bg-spice-dark text-white px-6 py-4 shadow-md flex justify-between items-center sticky top-0 z-50">
        <a href="index.php" class="font-bold text-lg uppercase tracking-wider">PHBN <span class="text-spice-gold">Admin</span></a>
        <nav class="flex items-center gap-6 text-xs font-semibold">
            <a href="index.php" class="hover:text-amber-300">Dashboard</a>
            <a href="products.php" class="hover:text-amber-300">Products</a>
            <a href="categories.php" class="hover:text-amber-300">Categories</a>
            <a href="orders.php" class="text-spice-gold">Orders</a>
            <a href="inquiries.php" class="hover:text-amber-300">Wholesale Leads</a>
            <a href="logout.php" class="bg-red-700 text-white px-3 py-1.5 rounded-lg">Logout</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-8">

        <?php if ($msg): ?>
            <div class="p-3 bg-emerald-100 text-emerald-800 text-xs rounded-xl font-bold"><?= $msg ?></div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl border border-spice-border p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-base text-spice-dark">Customer Orders (<?= count($orders) ?>)</h3>

            <?php if (empty($orders)): ?>
                <p class="text-xs text-gray-400 text-center py-8">No customer orders placed yet.</p>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($orders as $o): 
                        // Fetch items for each order
                        $itemStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
                        $itemStmt->execute([$o['id']]);
                        $items = $itemStmt->fetchAll();
                    ?>
                    <div class="border border-spice-border rounded-2xl p-6 space-y-4 bg-gray-50/50">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-b border-spice-border pb-3">
                            <div>
                                <span class="font-mono font-bold text-spice-red text-sm"><?= sanitize($o['order_number']) ?></span>
                                <span class="text-xs text-gray-400 ml-2">Placed: <?= date('d M Y, h:i A', strtotime($o['created_at'])) ?></span>
                            </div>

                            <form method="POST" class="flex items-center gap-2">
                                <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                <span class="text-xs font-bold text-gray-500">Status:</span>
                                <select name="status" onchange="this.form.submit()" class="bg-white border text-xs font-bold rounded-lg px-3 py-1.5 focus:outline-none focus:border-spice-red">
                                    <option value="Pending" <?= $o['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Processing" <?= $o['status'] === 'Processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="Shipped" <?= $o['status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="Delivered" <?= $o['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <option value="Cancelled" <?= $o['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                            <div>
                                <strong class="block text-gray-700">Customer Details:</strong>
                                <span><?= sanitize($o['customer_name']) ?></span><br>
                                <span>Email: <?= sanitize($o['customer_email']) ?></span><br>
                                <span>Phone: <?= sanitize($o['customer_phone']) ?></span>
                            </div>

                            <div>
                                <strong class="block text-gray-700">Delivery Address:</strong>
                                <span><?= sanitize($o['shipping_address']) ?></span><br>
                                <span><?= sanitize($o['city']) ?> - <?= sanitize($o['postal_code']) ?></span>
                            </div>

                            <div>
                                <strong class="block text-gray-700">Payment & Total:</strong>
                                <span>Method: <?= strtoupper(sanitize($o['payment_method'])) ?></span><br>
                                <span class="text-sm font-extrabold text-spice-red">Total: <?= formatCurrency($o['total_amount']) ?></span>
                            </div>
                        </div>

                        <!-- Items Breakdown -->
                        <div class="bg-white p-3 rounded-xl border border-gray-200">
                            <strong class="text-[11px] uppercase text-gray-400 block mb-1">Ordered Spice Items:</strong>
                            <div class="flex flex-wrap gap-3 text-xs">
                                <?php foreach ($items as $it): ?>
                                    <span class="bg-amber-50 text-amber-900 px-2.5 py-1 rounded-lg border border-amber-200 font-semibold">
                                        <?= sanitize($it['product_name']) ?> (<?= sanitize($it['weight']) ?>) &times; <?= $it['quantity'] ?> = <?= formatCurrency($it['price'] * $it['quantity']) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>
