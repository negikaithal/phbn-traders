<?php
// cart.php - Shopping Cart Overview
$pageTitle = "Shopping Cart - PHBN Traders";
$pageDescription = "View items in your spice shopping cart and proceed to checkout.";
require_once __DIR__ . '/includes/header.php';

$cart = getCart();
$cartTotal = getCartTotal();
$freeShippingThreshold = 999;
$amountLeftForFreeShipping = max(0, $freeShippingThreshold - $cartTotal);
?>

<div class="bg-spice-dark text-white py-10 border-b border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight">Your Spice Cart</h1>
        <p class="text-xs text-amber-200/80 mt-1">Review your selected spices, adjust quantities, and proceed to checkout.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <?php if (empty($cart)): ?>
        <div class="bg-white p-12 rounded-3xl border border-spice-border text-center space-y-4 max-w-md mx-auto my-8">
            <div class="w-16 h-16 rounded-full bg-amber-100 text-spice-gold flex items-center justify-center text-3xl mx-auto">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h2 class="text-xl font-bold text-spice-dark">Your Cart is Currently Empty</h2>
            <p class="text-xs text-gray-500">Discover our sun-dried whole spices and authentic ground blends.</p>
            <a href="<?= url('products') ?>" class="btn-spice-primary text-xs inline-block">Explore Pantry Catalog</a>
        </div>
    <?php else: ?>
        
        <!-- Free Shipping Meter -->
        <div class="mb-8 p-4 bg-amber-50 rounded-2xl border border-amber-200 text-xs text-amber-900 flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-truck-fast text-spice-gold text-lg"></i>
                <?php if ($amountLeftForFreeShipping > 0): ?>
                    <span>Add <strong><?= formatCurrency($amountLeftForFreeShipping) ?></strong> more to qualify for <strong>FREE Express Shipping</strong>!</span>
                <?php else: ?>
                    <span class="text-emerald-700 font-bold"><i class="fa-solid fa-circle-check"></i> Congratulations! You qualify for FREE Express Shipping!</span>
                <?php endif; ?>
            </div>
            <a href="<?= url('products') ?>" class="text-spice-red font-bold underline">Add More Spices</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-3xl border border-spice-border overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 border-b border-spice-border text-gray-500 uppercase">
                                <th class="p-4">Spice Product</th>
                                <th class="p-4">Weight</th>
                                <th class="p-4">Price</th>
                                <th class="p-4 text-center">Quantity</th>
                                <th class="p-4 text-right">Subtotal</th>
                                <th class="p-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($cart as $item): 
                                $subtotal = $item['price'] * $item['quantity'];
                            ?>
                            <tr>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="<?= sanitize($item['image']) ?>" class="w-12 h-12 object-cover rounded-xl border border-gray-200 shrink-0">
                                        <div>
                                            <span class="font-bold text-spice-dark block line-clamp-1">
                                                <?= sanitize($item['name']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold text-gray-600">
                                    <span class="px-2 py-1 bg-amber-50 text-amber-800 rounded-md text-[11px]"><?= sanitize($item['weight']) ?></span>
                                </td>
                                <td class="p-4 font-semibold text-gray-700">
                                    <?= formatCurrency($item['price']) ?>
                                </td>
                                <td class="p-4 text-center">
                                    <form action="<?= url('cart-action.php') ?>" method="POST" class="inline-flex items-center gap-1">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="cart_key" value="<?= sanitize($item['key']) ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="50" onchange="this.form.submit()" class="w-14 bg-gray-50 border border-gray-300 rounded-lg py-1 px-2 text-center text-xs font-bold focus:outline-none">
                                    </form>
                                </td>
                                <td class="p-4 text-right font-extrabold text-spice-red">
                                    <?= formatCurrency($subtotal) ?>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="<?= url('cart-action.php?action=remove&key=' . urlencode($item['key'])) ?>" class="text-gray-400 hover:text-spice-red transition-colors p-1" title="Remove item">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <a href="<?= url('products') ?>" class="text-xs font-bold text-spice-dark hover:text-spice-red flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left"></i> Continue Shopping
                    </a>
                    <a href="<?= url('cart-action.php?action=clear') ?>" class="text-xs text-red-600 hover:underline">Clear Entire Cart</a>
                </div>
            </div>

            <!-- Summary & Checkout Card -->
            <div>
                <div class="bg-white p-6 rounded-3xl border border-spice-border shadow-sm space-y-4 sticky top-24">
                    <h3 class="text-base font-extrabold text-spice-dark border-b border-spice-border pb-3">Order Summary</h3>
                    
                    <div class="space-y-2 text-xs text-gray-600">
                        <div class="flex justify-between">
                            <span>Bag Subtotal</span>
                            <span class="font-bold text-gray-800"><?= formatCurrency($cartTotal) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Estimated Shipping</span>
                            <span class="font-bold text-gray-800">
                                <?= $amountLeftForFreeShipping === 0 ? '<span class="text-emerald-600">FREE</span>' : formatCurrency(80) ?>
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-spice-border pt-3 flex justify-between items-baseline">
                        <span class="text-sm font-extrabold text-spice-dark">Total Amount</span>
                        <span class="text-2xl font-extrabold text-spice-red">
                            <?= formatCurrency($cartTotal + ($amountLeftForFreeShipping === 0 ? 0 : 80)) ?>
                        </span>
                    </div>

                    <a href="<?= url('checkout') ?>" class="btn-spice-primary w-full text-center block text-xs shadow-md">
                        Proceed to Checkout <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>

                    <div class="pt-3 border-t border-gray-100 text-[11px] text-gray-500 space-y-1">
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-shield text-spice-gold"></i> Safe & Secure Checkout</div>
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-rotate-left text-spice-gold"></i> Easy Purity Guarantee Return</div>
                    </div>
                </div>
            </div>

        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
