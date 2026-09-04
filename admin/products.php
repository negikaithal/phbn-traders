<?php
// admin/products.php - Manage Spice Products
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$pdo = getDBConnection();
$msg = '';
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $delId = intval($_GET['id'] ?? 0);
    if ($delId > 0) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$delId]);
        $msg = "Spice item deleted successfully.";
    }
}

// Handle Add / Edit Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editId = intval($_POST['product_id'] ?? 0);
    $name = sanitize($_POST['name'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 1);
    $price = floatval($_POST['price'] ?? 0);
    $weight_options = sanitize($_POST['weight_options'] ?? '100g, 250g, 500g, 1kg, 5kg Bulk');
    $description = sanitize($_POST['description'] ?? '');
    $origin = sanitize($_POST['origin'] ?? '');
    $benefits = sanitize($_POST['benefits'] ?? '');
    $heat_level = sanitize($_POST['heat_level'] ?? 'Mild');
    $image = sanitize($_POST['image'] ?? '');
    $stock = intval($_POST['stock'] ?? 100);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $slug = slugify($name);

    if (empty($name) || $price <= 0) {
        $error = "Product name and price must be specified.";
    } else {
        if ($editId > 0) {
            // Update
            $stmt = $pdo->prepare("UPDATE products SET category_id=?, name=?, slug=?, price=?, weight_options=?, description=?, origin=?, benefits=?, heat_level=?, image=?, stock=?, is_featured=? WHERE id=?");
            $stmt->execute([$category_id, $name, $slug, $price, $weight_options, $description, $origin, $benefits, $heat_level, $image, $stock, $is_featured, $editId]);
            $msg = "Spice updated successfully!";
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, price, weight_options, description, origin, benefits, heat_level, image, stock, is_featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
            $stmt->execute([$category_id, $name, $slug, $price, $weight_options, $description, $origin, $benefits, $heat_level, $image, $stock, $is_featured]);
            $msg = "New spice product added to catalog!";
        }
    }
}

// Fetch categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

// Fetch products
$products = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll();

// Check if editing
$editProduct = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $editId = intval($_GET['id'] ?? 0);
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$editId]);
    $editProduct = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spice Catalog Manager | PHBN Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100 text-spice-dark flex flex-col min-h-screen">

    <header class="bg-spice-dark text-white px-6 py-4 shadow-md flex justify-between items-center sticky top-0 z-50">
        <a href="index.php" class="font-bold text-lg uppercase tracking-wider">PHBN <span class="text-spice-gold">Admin</span></a>
        <nav class="flex items-center gap-6 text-xs font-semibold">
            <a href="index.php" class="hover:text-amber-300">Dashboard</a>
            <a href="products.php" class="text-spice-gold">Products</a>
            <a href="categories.php" class="hover:text-amber-300">Categories</a>
            <a href="orders.php" class="hover:text-amber-300">Orders</a>
            <a href="inquiries.php" class="hover:text-amber-300">Wholesale Leads</a>
            <a href="logout.php" class="bg-red-700 text-white px-3 py-1.5 rounded-lg">Logout</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-8">
        
        <?php if ($msg): ?>
            <div class="p-3 bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs rounded-xl font-semibold">
                <i class="fa-solid fa-circle-check mr-1"></i> <?= $msg ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="p-3 bg-red-100 border border-red-300 text-red-700 text-xs rounded-xl font-semibold">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Form for Add / Edit -->
        <div class="bg-white p-6 rounded-3xl border border-spice-border shadow-sm space-y-4">
            <h3 class="font-extrabold text-base border-b border-spice-border pb-3">
                <?= $editProduct ? 'Edit Spice Product: ' . sanitize($editProduct['name']) : 'Add New Spice to Store' ?>
            </h3>

            <form method="POST" class="space-y-4 text-xs">
                <?php if ($editProduct): ?>
                    <input type="hidden" name="product_id" value="<?= $editProduct['id'] ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-gray-700 uppercase mb-1">Spice Name *</label>
                        <input type="text" name="name" required value="<?= sanitize($editProduct['name'] ?? '') ?>" placeholder="e.g. Malabar Black Pepper Bold" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Category *</label>
                        <select name="category_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red font-medium">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($editProduct && $editProduct['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                    <?= sanitize($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Base Price (₹ for 250g) *</label>
                        <input type="number" step="0.01" name="price" required value="<?= $editProduct['price'] ?? '' ?>" placeholder="240.00" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Heat / Flavor Profile</label>
                        <select name="heat_level" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red font-medium">
                            <option value="Mild" <?= ($editProduct && $editProduct['heat_level'] === 'Mild') ? 'selected' : '' ?>>Mild</option>
                            <option value="Medium-Hot" <?= ($editProduct && $editProduct['heat_level'] === 'Medium-Hot') ? 'selected' : '' ?>>Medium-Hot</option>
                            <option value="Hot" <?= ($editProduct && $editProduct['heat_level'] === 'Hot') ? 'selected' : '' ?>>Hot</option>
                            <option value="Zesty-Hot" <?= ($editProduct && $editProduct['heat_level'] === 'Zesty-Hot') ? 'selected' : '' ?>>Zesty-Hot</option>
                            <option value="Sweet Aromatic" <?= ($editProduct && $editProduct['heat_level'] === 'Sweet Aromatic') ? 'selected' : '' ?>>Sweet Aromatic</option>
                            <option value="Warm Spiced" <?= ($editProduct && $editProduct['heat_level'] === 'Warm Spiced') ? 'selected' : '' ?>>Warm Spiced</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Origin / Region</label>
                        <input type="text" name="origin" value="<?= sanitize($editProduct['origin'] ?? '') ?>" placeholder="e.g. Kerala, India" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Stock Quantity</label>
                        <input type="number" name="stock" value="<?= $editProduct['stock'] ?? 100 ?>" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase mb-1">Image URL</label>
                    <input type="text" name="image" value="<?= sanitize($editProduct['image'] ?? '') ?>" placeholder="https://images.unsplash.com/..." class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red"><?= sanitize($editProduct['description'] ?? '') ?></textarea>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 uppercase mb-1">Health & Bioactive Benefits</label>
                    <textarea name="benefits" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red"><?= sanitize($editProduct['benefits'] ?? '') ?></textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" <?= (!empty($editProduct['is_featured'])) ? 'checked' : '' ?> class="rounded text-spice-red">
                    <label for="is_featured" class="font-bold text-gray-700">Display on Homepage Best Sellers / Featured Section</label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-spice-primary text-xs py-2.5 px-6">
                        <?= $editProduct ? 'Save Changes' : 'Add Spice Product' ?>
                    </button>
                    <?php if ($editProduct): ?>
                        <a href="products.php" class="btn-spice-outline text-xs py-2.5 px-4">Cancel Edit</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Product Table -->
        <div class="bg-white rounded-3xl border border-spice-border p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-base text-spice-dark">All Spice Inventory (<?= count($products) ?>)</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="text-gray-400 uppercase border-b border-gray-200">
                            <th class="py-3 px-2">Image</th>
                            <th class="py-3 px-2">Name</th>
                            <th class="py-3 px-2">Category</th>
                            <th class="py-3 px-2">Base Price</th>
                            <th class="py-3 px-2">Stock</th>
                            <th class="py-3 px-2">Featured</th>
                            <th class="py-3 px-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td class="py-2.5 px-2">
                                <img src="<?= sanitize($p['image']) ?>" class="w-10 h-10 object-cover rounded-lg border">
                            </td>
                            <td class="py-2.5 px-2 font-bold text-spice-dark">
                                <?= sanitize($p['name']) ?>
                                <span class="block text-[10px] text-gray-400 font-normal">Origin: <?= sanitize($p['origin']) ?></span>
                            </td>
                            <td class="py-2.5 px-2 text-gray-600 font-medium"><?= sanitize($p['category_name']) ?></td>
                            <td class="py-2.5 px-2 font-bold text-spice-red"><?= formatCurrency($p['price']) ?></td>
                            <td class="py-2.5 px-2 font-semibold"><?= $p['stock'] ?> units</td>
                            <td class="py-2.5 px-2">
                                <?= $p['is_featured'] ? '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">Yes</span>' : '<span class="text-gray-400">No</span>' ?>
                            </td>
                            <td class="py-2.5 px-2 text-center space-x-2">
                                <a href="products.php?action=edit&id=<?= $p['id'] ?>" class="text-spice-gold hover:underline font-bold">Edit</a>
                                <a href="products.php?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to delete this spice?');" class="text-red-600 hover:underline font-bold">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>
