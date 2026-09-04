<?php
// includes/functions.php - Utility Functions & Helpers

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db.php';

// Format currency
function formatCurrency($amount) {
    return '₹' . number_format($amount, 2);
}

// Sanitize string output
function sanitize($string) {
    return htmlspecialchars(trim($string ?? ''), ENT_QUOTES, 'UTF-8');
}

// Initialize Shopping Cart in Session
function getCart() {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

// Get Cart Item Count
function getCartCount() {
    $cart = getCart();
    $count = 0;
    foreach ($cart as $item) {
        $count += $item['quantity'];
    }
    return $count;
}

// Get Cart Total Price
function getCartTotal() {
    $cart = getCart();
    $total = 0;
    foreach ($cart as $item) {
        $total += ($item['price'] * $item['quantity']);
    }
    return $total;
}

// Add Item to Cart
function addToCart($productId, $quantity = 1, $weight = '250g') {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if (!$product) {
        return false;
    }

    // Weight multiplier adjustment for demo if price is per 250g
    $multiplier = 1;
    if ($weight === '100g') $multiplier = 0.45;
    elseif ($weight === '500g') $multiplier = 1.9;
    elseif ($weight === '1kg') $multiplier = 3.6;
    elseif ($weight === '5kg Bulk') $multiplier = 16.5;

    $calculatedPrice = round($product['price'] * $multiplier, 2);

    $cartKey = $productId . '_' . $weight;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$cartKey] = [
            'key' => $cartKey,
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $calculatedPrice,
            'weight' => $weight,
            'image' => $product['image'],
            'quantity' => $quantity
        ];
    }
    return true;
}

// Update Cart Quantity
function updateCartQuantity($cartKey, $quantity) {
    if (isset($_SESSION['cart'][$cartKey])) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$cartKey]);
        } else {
            $_SESSION['cart'][$cartKey]['quantity'] = $quantity;
        }
    }
}

// Remove Item from Cart
function removeFromCart($cartKey) {
    if (isset($_SESSION['cart'][$cartKey])) {
        unset($_SESSION['cart'][$cartKey]);
    }
}

// Clear Entire Cart
function clearCart() {
    $_SESSION['cart'] = [];
}

// Check Admin Login
function isAdminLoggedIn() {
    return isset($_SESSION['admin_user']);
}

// Require Admin Login
function requireAdmin() {
    if (!isAdminLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Generate Slug
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text);
}
