<?php
// cart-action.php - Process Cart Operations
require_once __DIR__ . '/includes/functions.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $productId = intval($_POST['product_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 1);
    $weight = sanitize($_POST['weight'] ?? '250g');

    if ($productId > 0 && addToCart($productId, $quantity, $weight)) {
        $_SESSION['flash_msg'] = "Added item to your cart!";
    }
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'cart.php'));
    exit;
}

if ($action === 'update') {
    $cartKey = sanitize($_POST['cart_key'] ?? '');
    $quantity = intval($_POST['quantity'] ?? 1);
    
    updateCartQuantity($cartKey, $quantity);
    header('Location: cart.php');
    exit;
}

if ($action === 'remove') {
    $cartKey = sanitize($_GET['key'] ?? '');
    removeFromCart($cartKey);
    header('Location: cart.php');
    exit;
}

if ($action === 'clear') {
    clearCart();
    header('Location: cart.php');
    exit;
}

header('Location: cart.php');
exit;
