<?php
// checkout.php - Customer Order & Checkout
require_once __DIR__ . '/includes/header.php';

$cart = getCart();
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$cartTotal = getCartTotal();
$shippingFee = ($cartTotal >= 999) ? 0 : 80;
$grandTotal = $cartTotal + $shippingFee;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $city = sanitize($_POST['city'] ?? '');
    $postal_code = sanitize($_POST['postal_code'] ?? '');
    $payment_method = sanitize($_POST['payment_method'] ?? 'cod');

    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($city) || empty($postal_code)) {
        $error = "Please complete all required shipping fields.";
    } else {
        try {
            $pdo = getDBConnection();
            $orderNumber = 'PHBN-' . date('Ymd') . '-' . rand(1000, 9999);

            $stmt = $pdo->prepare("INSERT INTO orders 
                (order_number, customer_name, customer_email, customer_phone, shipping_address, city, postal_code, payment_method, total_amount, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
            
            $stmt->execute([
                $orderNumber,
                $name,
                $email,
                $phone,
                $address,
                $city,
                $postal_code,
                $payment_method,
                $grandTotal
            ]);

            $orderId = $pdo->lastInsertId();

            // Insert Items
            $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, weight) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($cart as $item) {
                $itemStmt->execute([
                    $orderId,
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['quantity'],
                    $item['weight']
                ]);
            }

            // Clear cart
            clearCart();

            // Redirect to success page
            header("Location: order-success.php?id=" . $orderId);
            exit;

        } catch (PDOException $e) {
            $error = "Order processing failed: " . $e->getMessage();
        }
    }
}
?>

<div class="bg-spice-dark text-white py-10 border-b border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight">Checkout Order</h1>
        <p class="text-xs text-amber-200/80 mt-1">Provide your delivery address to dispatch your freshly packaged spices.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <?php if ($error): ?>
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 text-xs rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Address & Payment Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Address Form -->
            <div class="bg-white p-8 rounded-3xl border border-spice-border shadow-sm space-y-4">
                <h3 class="text-base font-extrabold text-spice-dark border-b border-spice-border pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-truck-ramp-box text-spice-gold"></i> Shipping Information
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Full Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Ramesh Verma" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Address *</label>
                        <input type="email" name="email" required placeholder="ramesh@example.com" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Mobile Phone *</label>
                        <input type="tel" name="phone" required placeholder="+91 98765 43210" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">City / Location *</label>
                        <input type="text" name="city" required placeholder="e.g. Mumbai" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Complete Street Address *</label>
                        <input type="text" name="address" required placeholder="Flat/House No., Building Name, Street" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pincode *</label>
                        <input type="text" name="postal_code" required placeholder="400001" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>
                </div>
            </div>

            <!-- Payment Method Selection -->
            <div class="bg-white p-8 rounded-3xl border border-spice-border shadow-sm space-y-4">
                <h3 class="text-base font-extrabold text-spice-dark border-b border-spice-border pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-spice-gold"></i> Payment Selection
                </h3>

                <div class="space-y-3">
                    <label class="flex items-center p-4 border border-spice-border rounded-2xl cursor-pointer hover:bg-amber-50/50 transition-colors">
                        <input type="radio" name="payment_method" value="cod" checked class="text-spice-red focus:ring-spice-red">
                        <div class="ml-3">
                            <span class="block text-xs font-bold text-spice-dark">Cash on Delivery (COD)</span>
                            <span class="block text-[11px] text-gray-500">Pay cash upon receiving your spice package</span>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border border-spice-border rounded-2xl cursor-pointer hover:bg-amber-50/50 transition-colors">
                        <input type="radio" name="payment_method" value="upi" class="text-spice-red focus:ring-spice-red">
                        <div class="ml-3">
                            <span class="block text-xs font-bold text-spice-dark">Instant UPI / QR Code (Mock Integration)</span>
                            <span class="block text-[11px] text-gray-500">GPay, PhonePe, Paytm, BHIM UPI</span>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border border-spice-border rounded-2xl cursor-pointer hover:bg-amber-50/50 transition-colors">
                        <input type="radio" name="payment_method" value="card" class="text-spice-red focus:ring-spice-red">
                        <div class="ml-3">
                            <span class="block text-xs font-bold text-spice-dark">Credit / Debit Card</span>
                            <span class="block text-[11px] text-gray-500">Visa, Mastercard, RuPay</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Order Summary Side Card -->
        <div>
            <div class="bg-white p-6 rounded-3xl border border-spice-border shadow-sm space-y-4 sticky top-24">
                <h3 class="text-base font-extrabold text-spice-dark border-b border-spice-border pb-3">Items in Order</h3>

                <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                    <?php foreach ($cart as $item): ?>
                    <div class="flex items-center justify-between text-xs py-1 border-b border-gray-50">
                        <div>
                            <span class="font-bold text-spice-dark block line-clamp-1"><?= sanitize($item['name']) ?></span>
                            <span class="text-[10px] text-gray-400"><?= sanitize($item['weight']) ?> &times; <?= $item['quantity'] ?></span>
                        </div>
                        <span class="font-semibold text-gray-800"><?= formatCurrency($item['price'] * $item['quantity']) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-spice-border pt-3 space-y-2 text-xs text-gray-600">
                    <div class="flex justify-between">
                        <span>Items Subtotal</span>
                        <span class="font-bold"><?= formatCurrency($cartTotal) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Delivery Fee</span>
                        <span class="font-bold"><?= formatCurrency($shippingFee) ?></span>
                    </div>
                    <div class="flex justify-between text-sm font-extrabold text-spice-dark pt-2 border-t border-gray-100">
                        <span>Grand Total</span>
                        <span class="text-spice-red text-xl"><?= formatCurrency($grandTotal) ?></span>
                    </div>
                </div>

                <button type="submit" class="btn-spice-primary w-full text-center text-xs py-3 shadow-md mt-4">
                    Place Spice Order <i class="fa-solid fa-circle-check ml-1"></i>
                </button>
            </div>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
