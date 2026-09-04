<?php
// order-success.php - Order Confirmation & Receipt Summary
$pageTitle = "Order Placed Successfully - PHBN Traders";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$orderId = intval($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: ' . url(''));
    exit;
}

// Fetch Order Items
$itemStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$itemStmt->execute([$orderId]);
$orderItems = $itemStmt->fetchAll();
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-3xl border border-spice-border p-8 md:p-12 shadow-sm text-center space-y-6">
        
        <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-4xl mx-auto">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <div>
            <span class="text-xs font-bold text-spice-gold uppercase tracking-widest">Order Placed Successfully!</span>
            <h1 class="text-3xl font-extrabold text-spice-dark tracking-tight mt-1">Thank You For Sourcing With PHBN Traders</h1>
            <p class="text-xs text-gray-500 mt-2">Your order number is <strong class="text-spice-red font-mono text-sm"><?= sanitize($order['order_number']) ?></strong>. A confirmation email has been dispatched to <strong><?= sanitize($order['customer_email']) ?></strong>.</p>
        </div>

        <!-- Receipt Table -->
        <div class="border border-spice-border rounded-2xl p-6 text-left space-y-4 bg-spice-cream/40">
            <h3 class="text-xs font-bold text-spice-dark uppercase tracking-wider border-b border-spice-border pb-2">Order & Dispatch Summary</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-gray-400 block">Shipping Address:</span>
                    <strong class="text-gray-800"><?= sanitize($order['customer_name']) ?></strong><br>
                    <?= sanitize($order['shipping_address']) ?><br>
                    <?= sanitize($order['city']) ?> - <?= sanitize($order['postal_code']) ?><br>
                    Phone: <?= sanitize($order['customer_phone']) ?>
                </div>

                <div>
                    <span class="text-gray-400 block">Payment Details:</span>
                    <strong>Method:</strong> <?= strtoupper(sanitize($order['payment_method'])) ?><br>
                    <strong>Status:</strong> <span class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded font-semibold text-[10px]"><?= sanitize($order['status']) ?></span><br>
                    <strong>Date:</strong> <?= date('d M Y, h:i A', strtotime($order['created_at'])) ?>
                </div>
            </div>

            <!-- Items -->
            <div class="pt-4 border-t border-spice-border">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="text-gray-400 uppercase text-[10px] border-b border-gray-200">
                            <th class="py-2 text-left">Spice Item</th>
                            <th class="py-2 text-center">Weight</th>
                            <th class="py-2 text-center">Qty</th>
                            <th class="py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td class="py-2 font-bold text-spice-dark"><?= sanitize($item['product_name']) ?></td>
                            <td class="py-2 text-center text-gray-500"><?= sanitize($item['weight']) ?></td>
                            <td class="py-2 text-center text-gray-500"><?= $item['quantity'] ?></td>
                            <td class="py-2 text-right font-semibold text-gray-800"><?= formatCurrency($item['price'] * $item['quantity']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="font-extrabold text-spice-red text-sm border-t border-spice-border">
                            <td colspan="3" class="pt-3 text-right">Total Paid:</td>
                            <td class="pt-3 text-right"><?= formatCurrency($order['total_amount']) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-4 pt-4">
            <button onclick="window.print()" class="btn-spice-outline text-xs flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Print Invoice
            </button>
            <a href="<?= url('products') ?>" class="btn-spice-primary text-xs flex items-center gap-2">
                <i class="fa-solid fa-cart-shopping"></i> Continue Shopping
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
