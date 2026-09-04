<?php
// products.php - Product Catalog Page
require_once __DIR__ . '/includes/functions.php';

$pdo = getDBConnection();

// Filters & Query params
$selectedCatSlug = sanitize($_GET['cat'] ?? '');
$searchQuery = sanitize($_GET['search'] ?? '');
$sort = sanitize($_GET['sort'] ?? 'newest');

// Dynamic Page Meta
$pageTitle = !empty($selectedCatSlug) ? ucwords(str_replace('-', ' ', $selectedCatSlug)) . " - PHBN Traders" : "All Premium Spices - PHBN Traders";
$pageDescription = "Browse PHBN Traders collection of pure single-origin ground spices, whole botanicals, and hand-crafted masalas.";

require_once __DIR__ . '/includes/header.php';

// Fetch all categories for filter sidebar
$catStmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$allCategories = $catStmt->fetchAll();

// Build SQL query
$sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'active'";
$params = [];

if (!empty($selectedCatSlug)) {
    $sql .= " AND c.slug = ?";
    $params[] = $selectedCatSlug;
}

if (!empty($searchQuery)) {
    $sql .= " AND (p.name LIKE ? OR p.description LIKE ? OR p.origin LIKE ?)";
    $searchTerm = "%{$searchQuery}%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Sorting logic
if ($sort === 'price_low') {
    $sql .= " ORDER BY p.price ASC";
} elseif ($sort === 'price_high') {
    $sql .= " ORDER BY p.price DESC";
} elseif ($sort === 'name') {
    $sql .= " ORDER BY p.name ASC";
} else {
    $sql .= " ORDER BY p.id DESC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<!-- Header Banner -->
<div class="bg-spice-dark text-white py-12 border-b border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">
                <?= !empty($selectedCatSlug) ? ucwords(str_replace('-', ' ', $selectedCatSlug)) : 'Spice Pantry Catalog' ?>
            </h1>
            <p class="text-xs text-amber-200/80 mt-1">Explore our range of 100% pure single-origin whole spices, ground masalas, & luxury saffron.</p>
        </div>
        <div class="text-xs text-amber-300 font-medium">
            Showing <span class="font-bold text-white"><?= count($products) ?></span> Spices Available
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar Filters -->
        <aside class="space-y-8">
            
            <!-- Category Filter -->
            <div class="bg-white p-6 rounded-2xl border border-spice-border shadow-sm">
                <h3 class="text-sm font-bold text-spice-dark uppercase tracking-wider mb-4 border-b border-spice-border pb-2">Categories</h3>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="<?= url('products') ?>" class="flex justify-between items-center py-1.5 px-3 rounded-lg <?= empty($selectedCatSlug) ? 'bg-spice-dark text-white font-bold' : 'text-gray-700 hover:bg-amber-50' ?>">
                            <span>All Categories</span>
                        </a>
                    </li>
                    <?php foreach ($allCategories as $c): ?>
                    <li>
                        <a href="<?= url('category/' . sanitize($c['slug'])) ?>" class="flex justify-between items-center py-1.5 px-3 rounded-lg <?= $selectedCatSlug === $c['slug'] ? 'bg-spice-dark text-white font-bold' : 'text-gray-700 hover:bg-amber-50' ?>">
                            <span><?= sanitize($c['name']) ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Sort By Filter -->
            <div class="bg-white p-6 rounded-2xl border border-spice-border shadow-sm">
                <h3 class="text-sm font-bold text-spice-dark uppercase tracking-wider mb-4 border-b border-spice-border pb-2">Sort By</h3>
                <form action="<?= !empty($selectedCatSlug) ? url('category/' . $selectedCatSlug) : url('products') ?>" method="GET" class="space-y-3">
                    <?php if ($searchQuery): ?>
                        <input type="hidden" name="search" value="<?= sanitize($searchQuery) ?>">
                    <?php endif; ?>

                    <select name="sort" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-spice-red font-medium">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest Additions</option>
                        <option value="price_low" <?= $sort === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_high" <?= $sort === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Name (A-Z)</option>
                    </select>
                </form>
            </div>

            <!-- Wholesale Callout Widget -->
            <div class="bg-gradient-to-br from-spice-red to-spice-gold text-white p-6 rounded-2xl shadow-md space-y-3">
                <i class="fa-solid fa-truck-ramp-box text-3xl"></i>
                <h4 class="font-bold text-sm">Need Bulk Quantities?</h4>
                <p class="text-xs text-amber-100/90 leading-relaxed">
                    Order 5kg, 25kg, or container-load packaging directly from PHBN Traders at wholesale rates.
                </p>
                <a href="<?= url('wholesale') ?>" class="inline-block bg-white text-spice-red text-xs font-bold px-4 py-2 rounded-lg hover:bg-amber-50 transition-colors">
                    Request Quote
                </a>
            </div>

        </aside>

        <!-- Product Grid Container -->
        <main class="lg:col-span-3">
            
            <?php if (!empty($searchQuery)): ?>
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-900 flex justify-between items-center">
                    <span>Search results for: "<strong><?= sanitize($searchQuery) ?></strong>"</span>
                    <a href="<?= url('products') ?>" class="text-spice-red font-bold underline">Clear Search</a>
                </div>
            <?php endif; ?>

            <?php if (empty($products)): ?>
                <div class="bg-white p-12 rounded-2xl border border-spice-border text-center space-y-4">
                    <i class="fa-solid fa-pepper-hot text-5xl text-gray-300"></i>
                    <h3 class="text-xl font-bold text-spice-dark">No Spices Found</h3>
                    <p class="text-xs text-gray-500 max-w-sm mx-auto">We couldn't find any spices matching your selected filter or search term.</p>
                    <a href="<?= url('products') ?>" class="btn-spice-primary text-xs inline-block">Reset Filters</a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($products as $product): ?>
                    <div class="spice-card rounded-2xl overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 overflow-hidden bg-gray-100">
                                <img src="<?= sanitize($product['image']) ?>" alt="<?= sanitize($product['name']) ?>" class="w-full h-full object-cover">
                                <span class="absolute top-3 left-3 heat-badge <?= sanitize($product['heat_level']) ?>">
                                    <i class="fa-solid fa-pepper-hot"></i> <?= sanitize($product['heat_level']) ?>
                                </span>
                            </div>

                            <div class="p-5">
                                <span class="text-[10px] font-bold text-spice-gold uppercase tracking-wider block mb-1">
                                    <?= sanitize($product['category_name']) ?>
                                </span>
                                <h3 class="text-base font-bold text-spice-dark hover:text-spice-red transition-colors line-clamp-1">
                                    <a href="<?= url('spice/' . sanitize($product['slug'])) ?>"><?= sanitize($product['name']) ?></a>
                                </h3>
                                <p class="text-xs text-gray-600 line-clamp-2 mt-2 leading-relaxed">
                                    <?= sanitize($product['description']) ?>
                                </p>
                            </div>
                        </div>

                        <div class="p-5 pt-0 bg-white">
                            <form action="<?= url('cart-action.php') ?>" method="POST" class="space-y-3">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                    <div>
                                        <span class="text-[10px] text-gray-400 block">250g Price</span>
                                        <span class="text-lg font-bold text-spice-red"><?= formatCurrency($product['price']) ?></span>
                                    </div>
                                    <select name="weight" class="bg-gray-50 border border-gray-200 text-xs rounded-lg px-2 py-1 focus:outline-none">
                                        <option value="250g">250g</option>
                                        <option value="100g">100g</option>
                                        <option value="500g">500g</option>
                                        <option value="1kg">1kg</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <a href="<?= url('spice/' . sanitize($product['slug'])) ?>" class="text-center py-2 px-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                        Details
                                    </a>
                                    <button type="submit" class="bg-spice-red hover:bg-spice-red-hover text-white text-xs font-bold py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-plus"></i> Add
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </main>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
