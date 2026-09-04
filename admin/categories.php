<?php
// admin/categories.php - Manage Spice Categories
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$pdo = getDBConnection();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $image = sanitize($_POST['image'] ?? '');
    $slug = slugify($name);

    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $slug, $description, $image]);
        $msg = "Category added successfully!";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $delId = intval($_GET['id'] ?? 0);
    if ($delId > 0) {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$delId]);
        $msg = "Category deleted.";
    }
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY id ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Manager | PHBN Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="bg-gray-100 text-spice-dark flex flex-col min-h-screen">

    <header class="bg-spice-dark text-white px-6 py-4 shadow-md flex justify-between items-center sticky top-0 z-50">
        <a href="index.php" class="font-bold text-lg uppercase tracking-wider">PHBN <span class="text-spice-gold">Admin</span></a>
        <nav class="flex items-center gap-6 text-xs font-semibold">
            <a href="index.php" class="hover:text-amber-300">Dashboard</a>
            <a href="products.php" class="hover:text-amber-300">Products</a>
            <a href="categories.php" class="text-spice-gold">Categories</a>
            <a href="orders.php" class="hover:text-amber-300">Orders</a>
            <a href="inquiries.php" class="hover:text-amber-300">Wholesale Leads</a>
            <a href="logout.php" class="bg-red-700 text-white px-3 py-1.5 rounded-lg">Logout</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-8">

        <?php if ($msg): ?>
            <div class="p-3 bg-emerald-100 text-emerald-800 text-xs rounded-xl font-bold"><?= $msg ?></div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Add Form -->
            <div class="bg-white p-6 rounded-3xl border border-spice-border shadow-sm space-y-4 text-xs">
                <h3 class="font-bold text-sm border-b pb-2">Add New Category</h3>
                <form method="POST" class="space-y-3">
                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Category Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Exotic Masalas" class="w-full bg-gray-50 border rounded-xl p-3 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Image URL / Path</label>
                        <input type="text" name="image" placeholder="assets/images/ground-spices.svg or https://..." class="w-full bg-gray-50 border rounded-xl p-3 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full bg-gray-50 border rounded-xl p-3 focus:outline-none"></textarea>
                    </div>
                    <button type="submit" class="btn-spice-primary w-full py-2.5">Create Category</button>
                </form>
            </div>

            <!-- List -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-spice-border shadow-sm space-y-4">
                <h3 class="font-bold text-sm">Existing Categories (<?= count($categories) ?>)</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="text-gray-400 uppercase border-b">
                                <th class="py-2">Image</th>
                                <th class="py-2">Name</th>
                                <th class="py-2">Description</th>
                                <th class="py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td class="py-2"><img src="<?= imageUrl($cat['image']) ?>" class="w-12 h-12 object-cover rounded-lg border"></td>
                                <td class="py-2 font-bold text-spice-dark"><?= sanitize($cat['name']) ?></td>
                                <td class="py-2 text-gray-500 max-w-xs truncate"><?= sanitize($cat['description']) ?></td>
                                <td class="py-2 text-center">
                                    <a href="categories.php?action=delete&id=<?= $cat['id'] ?>" onclick="return confirm('Delete category?')" class="text-red-600 font-bold hover:underline">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

</body>
</html>
