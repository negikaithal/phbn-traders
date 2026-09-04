<?php
// admin/index.php - Admin Dashboard
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$pdo = getDBConnection();

// KPI Stats
$totalRevenue = $pdo->query("SELECT SUM(total_amount) FROM orders")->fetchColumn() ?: 0;
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn() ?: 0;
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn() ?: 0;
$totalInquiries = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn() ?: 0;

// Fetch Recent Orders
$recentOrders = $pdo->query("SELECT * FROM orders ORDER BY id DESC LIMIT 5")->fetchAll();

// Fetch Pending Inquiries
$recentInquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | PHBN Traders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100 text-spice-dark flex flex-col min-h-screen">

    <!-- Top Admin Bar -->
    <header class="bg-spice-dark text-white px-6 py-4 shadow-md flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <a href="index.php" class="flex items-center gap-2 font-bold text-lg uppercase tracking-wider">
                <div class="w-8 h-8 bg-spice-red rounded-lg flex items-center justify-center text-sm">
                    <i class="fa-solid fa-pepper-hot"></i>
                </div>
                <span>PHBN <span class="text-spice-gold">Admin</span></span>
            </a>
            <span class="text-xs text-amber-200/60 hidden md:inline">| Store Management Panel</span>
        </div>

        <nav class="flex items-center gap-6 text-xs font-semibold">
            <a href="index.php" class="text-spice-gold">Dashboard</a>
            <a href="products.php" class="hover:text-amber-300">Products (<?= $totalProducts ?>)</a>
            <a href="categories.php" class="hover:text-amber-300">Categories</a>
            <a href="orders.php" class="hover:text-amber-300">Orders (<?= $totalOrders ?>)</a>
            <a href="inquiries.php" class="hover:text-amber-300">Wholesale Leads (<?= $totalInquiries ?>)</a>
            <a href="../index.php" target="_blank" class="text-amber-400 hover:underline"><i class="fa-solid fa-external-link text-[10px] mr-1"></i> View Live Site</a>
            <a href="logout.php" class="bg-red-700 hover:bg-red-800 text-white px-3 py-1.5 rounded-lg transition-colors"><i class="fa-solid fa-power-off text-xs mr-1"></i> Logout</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-8">
        
        <div>
            <h1 class="text-2xl font-extrabold text-spice-dark">Dashboard Overview</h1>
            <p class="text-xs text-gray-500">Live store metrics and management shortcuts.</p>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white p-6 rounded-2xl border border-spice-border shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Total Sales Revenue</span>
                    <h3 class="text-2xl font-extrabold text-spice-red mt-1"><?= formatCurrency($totalRevenue) ?></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-spice-red flex items-center justify-center text-xl">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-spice-border shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Total Orders</span>
                    <h3 class="text-2xl font-extrabold text-spice-dark mt-1"><?= $totalOrders ?></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-spice-gold flex items-center justify-center text-xl">
                    <i class="fa-solid fa-box-open"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-spice-border shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Active Spices</span>
                    <h3 class="text-2xl font-extrabold text-spice-dark mt-1"><?= $totalProducts ?></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-seedling"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-spice-border shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase">Wholesale Trade Leads</span>
                    <h3 class="text-2xl font-extrabold text-spice-dark mt-1"><?= $totalInquiries ?></h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                </div>
            </div>

        </div>

        <!-- Recent Orders & Wholesale Leads Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Recent Customer Orders -->
            <div class="bg-white rounded-3xl border border-spice-border p-6 shadow-sm space-y-4">
                <div class="flex justify-between items-center border-b border-spice-border pb-3">
                    <h3 class="font-bold text-sm text-spice-dark uppercase"><i class="fa-solid fa-cart-flatbed text-spice-red mr-1.5"></i> Recent Customer Orders</h3>
                    <a href="orders.php" class="text-xs text-spice-gold font-bold hover:underline">View All &rarr;</a>
                </div>

                <?php if (empty($recentOrders)): ?>
                    <p class="text-xs text-gray-400 py-4 text-center">No customer orders recorded yet.</p>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead>
                                <tr class="text-gray-400 uppercase border-b border-gray-100">
                                    <th class="py-2">Order #</th>
                                    <th class="py-2">Customer</th>
                                    <th class="py-2">Amount</th>
                                    <th class="py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php foreach ($recentOrders as $o): ?>
                                <tr>
                                    <td class="py-2.5 font-mono font-bold text-spice-red"><?= sanitize($o['order_number']) ?></td>
                                    <td class="py-2.5"><?= sanitize($o['customer_name']) ?></td>
                                    <td class="py-2.5 font-semibold"><?= formatCurrency($o['total_amount']) ?></td>
                                    <td class="py-2.5">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800"><?= sanitize($o['status']) ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent Wholesale Inquiries -->
            <div class="bg-white rounded-3xl border border-spice-border p-6 shadow-sm space-y-4">
                <div class="flex justify-between items-center border-b border-spice-border pb-3">
                    <h3 class="font-bold text-sm text-spice-dark uppercase"><i class="fa-solid fa-briefcase text-spice-gold mr-1.5"></i> Wholesale Trade Leads</h3>
                    <a href="inquiries.php" class="text-xs text-spice-gold font-bold hover:underline">View All &rarr;</a>
                </div>

                <?php if (empty($recentInquiries)): ?>
                    <p class="text-xs text-gray-400 py-4 text-center">No wholesale trade inquiries received yet.</p>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead>
                                <tr class="text-gray-400 uppercase border-b border-gray-100">
                                    <th class="py-2">Contact</th>
                                    <th class="py-2">Company</th>
                                    <th class="py-2">Qty Needed</th>
                                    <th class="py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php foreach ($recentInquiries as $inq): ?>
                                <tr>
                                    <td class="py-2.5 font-bold text-gray-800"><?= sanitize($inq['name']) ?></td>
                                    <td class="py-2.5 text-gray-500"><?= sanitize($inq['company'] ?: 'N/A') ?></td>
                                    <td class="py-2.5 font-medium text-amber-800"><?= sanitize($inq['quantity_needed']) ?></td>
                                    <td class="py-2.5">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800"><?= sanitize($inq['status']) ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </main>

</body>
</html>
