<?php
// includes/header.php
require_once __DIR__ . '/functions.php';
$cartCount = getCartCount();

$metaTitle = $pageTitle ?? 'PHBN Traders | Pure, Aromatic & Wholesale Standard Spices';
$metaDesc = $pageDescription ?? 'PHBN Traders provides 100% pure single-origin whole spices, cold-ground masalas, and luxury Kashmiri saffron. Direct estate sourced, lab tested, and vacuum packed.';
$metaImage = $pageImage ?? url('assets/images/spice-banner.jpg');
$metaCanonical = $pageCanonical ?? ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title><?= sanitize($metaTitle) ?></title>
    <meta name="description" content="<?= sanitize($metaDesc) ?>">
    <meta name="keywords" content="spices, whole spices, ground masalas, Kashmiri saffron, turmeric powder, green cardamom, black pepper, wholesale spices, PHBN Traders">
    <link rel="canonical" href="<?= sanitize($metaCanonical) ?>">
    
    <!-- OpenGraph / Social Sharing -->
    <meta property="og:title" content="<?= sanitize($metaTitle) ?>">
    <meta property="og:description" content="<?= sanitize($metaDesc) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= sanitize($metaCanonical) ?>">
    <meta property="og:image" content="<?= sanitize($metaImage) ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        spice: {
                            red: '#c0392b',
                            gold: '#d35400',
                            green: '#1e824c',
                            dark: '#2c221e',
                            brown: '#4a2c11',
                            cream: '#fdfbf7',
                            border: '#e8ded2'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="bg-spice-cream text-spice-dark flex flex-col min-h-screen">

    <!-- Top Announcement Bar -->
    <div class="bg-spice-dark text-amber-100 text-xs py-2 px-4 text-center flex justify-between items-center px-6 md:px-12 border-b border-amber-900/40">
        <div class="hidden md:flex items-center gap-4">
            <span><i class="fa-solid fa-seedling text-emerald-400 mr-1"></i> 100% Sun-Dried & Lab Tested Purity</span>
            <span><i class="fa-solid fa-truck-fast text-amber-400 mr-1"></i> Express Shipping Across India</span>
        </div>
        <div class="w-full md:w-auto text-center md:text-right font-medium">
            <span>Commercial & Restaurant Bulk Orders? <a href="<?= url('wholesale') ?>" class="text-spice-amber underline hover:text-white font-semibold ml-1">Get Wholesale Quote <i class="fa-solid fa-arrow-right text-xs"></i></a></span>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-spice-border shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Brand Logo -->
                <a href="<?= url('') ?>" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-spice-red to-spice-gold flex items-center justify-center text-white text-2xl shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-pepper-hot"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-bold tracking-tight text-spice-dark uppercase block leading-none font-sans">PHBN <span class="text-spice-red">Traders</span></span>
                        <span class="text-[10px] font-semibold tracking-widest text-amber-700 uppercase">Pure Spices & Herbs</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold tracking-wide text-gray-700">
                    <a href="<?= url('') ?>" class="hover:text-spice-red transition-colors py-2">Home</a>
                    <a href="<?= url('products') ?>" class="hover:text-spice-red transition-colors py-2">Shop All Spices</a>
                    
                    <!-- Dropdown for Categories -->
                    <div class="relative group">
                        <a href="<?= url('products') ?>" class="hover:text-spice-red transition-colors py-2 flex items-center gap-1">
                            Categories <i class="fa-solid fa-chevron-down text-xs group-hover:rotate-180 transition-transform"></i>
                        </a>
                        <div class="absolute top-full left-0 w-60 bg-white rounded-xl shadow-xl border border-spice-border p-2 hidden group-hover:block transition-all">
                            <a href="<?= url('category/ground-spices') ?>" class="block px-4 py-2.5 rounded-lg text-sm hover:bg-amber-50 hover:text-spice-red transition-colors">Ground Spices</a>
                            <a href="<?= url('category/whole-spices') ?>" class="block px-4 py-2.5 rounded-lg text-sm hover:bg-amber-50 hover:text-spice-red transition-colors">Whole Spices</a>
                            <a href="<?= url('category/blended-masalas') ?>" class="block px-4 py-2.5 rounded-lg text-sm hover:bg-amber-50 hover:text-spice-red transition-colors">Blended Masalas</a>
                            <a href="<?= url('category/exotic-premium') ?>" class="block px-4 py-2.5 rounded-lg text-sm hover:bg-amber-50 hover:text-spice-red transition-colors">Exotic & Premium</a>
                            <a href="<?= url('category/organic-wellness') ?>" class="block px-4 py-2.5 rounded-lg text-sm hover:bg-amber-50 hover:text-spice-red transition-colors">Organic & Wellness</a>
                        </div>
                    </div>

                    <a href="<?= url('wholesale') ?>" class="hover:text-spice-red transition-colors py-2 text-spice-gold font-bold">Wholesale Trade</a>
                    <a href="<?= url('spice-masterclass') ?>" class="hover:text-spice-red transition-colors py-2">Spice Masterclass</a>
                    <a href="<?= url('about-us') ?>" class="hover:text-spice-red transition-colors py-2">Our Story</a>
                    <a href="<?= url('contact-us') ?>" class="hover:text-spice-red transition-colors py-2">Contact Us</a>
                </nav>

                <!-- Search Bar & Actions -->
                <div class="flex items-center gap-4">
                    <form action="<?= url('products') ?>" method="GET" class="hidden md:flex items-center relative">
                        <input type="text" name="search" placeholder="Search cardamom, turmeric..." 
                               class="bg-gray-100 border border-gray-200 text-xs rounded-full pl-4 pr-9 py-2.5 focus:outline-none focus:ring-2 focus:ring-spice-red w-48 transition-all focus:w-64">
                        <button type="submit" class="absolute right-3 text-gray-500 hover:text-spice-red">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </form>

                    <!-- Cart Icon Button -->
                    <a href="<?= url('cart') ?>" class="relative p-2 text-gray-700 hover:text-spice-red transition-colors">
                        <i class="fa-solid fa-bag-shopping text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-spice-red text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow">
                            <?= $cartCount ?>
                        </span>
                    </a>

                    <!-- Admin Portal Link -->
                    <a href="<?= url('admin/index.php') ?>" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700 hover:bg-spice-dark hover:text-white transition-colors">
                        <i class="fa-solid fa-lock text-xs"></i> Admin
                    </a>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-700 hover:text-spice-red focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Menu Dropdown -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-spice-border px-4 pt-3 pb-6 space-y-3">
            <form action="<?= url('products') ?>" method="GET" class="flex items-center relative mb-4">
                <input type="text" name="search" placeholder="Search spices..." class="w-full bg-gray-100 border border-gray-200 text-xs rounded-lg px-4 py-3 focus:outline-none">
                <button type="submit" class="absolute right-3 text-gray-500"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <a href="<?= url('') ?>" class="block px-3 py-2 rounded-md font-medium text-gray-800 hover:bg-amber-50">Home</a>
            <a href="<?= url('products') ?>" class="block px-3 py-2 rounded-md font-medium text-gray-800 hover:bg-amber-50">Shop All Spices</a>
            <div class="pl-4 space-y-1 border-l-2 border-spice-red my-2">
                <a href="<?= url('category/ground-spices') ?>" class="block px-2 py-1 text-sm text-gray-600">Ground Spices</a>
                <a href="<?= url('category/whole-spices') ?>" class="block px-2 py-1 text-sm text-gray-600">Whole Spices</a>
                <a href="<?= url('category/blended-masalas') ?>" class="block px-2 py-1 text-sm text-gray-600">Blended Masalas</a>
                <a href="<?= url('category/exotic-premium') ?>" class="block px-2 py-1 text-sm text-gray-600">Exotic & Premium</a>
            </div>
            <a href="<?= url('wholesale') ?>" class="block px-3 py-2 rounded-md font-medium text-spice-gold font-bold hover:bg-amber-50">Wholesale Trade</a>
            <a href="<?= url('spice-masterclass') ?>" class="block px-3 py-2 rounded-md font-medium text-gray-800 hover:bg-amber-50">Spice Masterclass</a>
            <a href="<?= url('about-us') ?>" class="block px-3 py-2 rounded-md font-medium text-gray-800 hover:bg-amber-50">Our Story</a>
            <a href="<?= url('contact-us') ?>" class="block px-3 py-2 rounded-md font-medium text-gray-800 hover:bg-amber-50">Contact Us</a>
            <a href="<?= url('admin/index.php') ?>" class="block px-3 py-2 rounded-md font-medium text-gray-800 hover:bg-gray-100"><i class="fa-solid fa-lock text-xs mr-2"></i>Admin Dashboard</a>
        </div>
    </header>
