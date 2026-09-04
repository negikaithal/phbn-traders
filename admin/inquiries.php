<?php
// admin/inquiries.php - Manage Wholesale Trade Leads
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$pdo = getDBConnection();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inquiry_id'])) {
    $inqId = intval($_POST['inquiry_id']);
    $status = sanitize($_POST['status'] ?? 'New');
    
    $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
    $stmt->execute([$status, $inqId]);
    $msg = "Wholesale inquiry #{$inqId} status updated to '{$status}'.";
}

$inquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Trade Leads | PHBN Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100 text-spice-dark flex flex-col min-h-screen">

    <header class="bg-spice-dark text-white px-6 py-4 shadow-md flex justify-between items-center sticky top-0 z-50">
        <a href="index.php" class="font-bold text-lg uppercase tracking-wider">PHBN <span class="text-spice-gold">Admin</span></a>
        <nav class="flex items-center gap-6 text-xs font-semibold">
            <a href="index.php" class="hover:text-amber-300">Dashboard</a>
            <a href="products.php" class="hover:text-amber-300">Products</a>
            <a href="categories.php" class="hover:text-amber-300">Categories</a>
            <a href="orders.php" class="hover:text-amber-300">Orders</a>
            <a href="inquiries.php" class="text-spice-gold">Wholesale Leads</a>
            <a href="logout.php" class="bg-red-700 text-white px-3 py-1.5 rounded-lg">Logout</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-8">

        <?php if ($msg): ?>
            <div class="p-3 bg-emerald-100 text-emerald-800 text-xs rounded-xl font-bold"><?= $msg ?></div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl border border-spice-border p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-base text-spice-dark">Wholesale Trade Inquiries (<?= count($inquiries) ?>)</h3>

            <?php if (empty($inquiries)): ?>
                <p class="text-xs text-gray-400 text-center py-8">No wholesale inquiries submitted yet.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($inquiries as $inq): ?>
                    <div class="border border-spice-border rounded-2xl p-5 space-y-3 bg-gray-50/50">
                        <div class="flex justify-between items-center border-b border-spice-border pb-2">
                            <div>
                                <strong class="text-sm font-bold text-spice-dark"><?= sanitize($inq['name']) ?></strong>
                                <span class="text-xs text-gray-500 font-normal ml-2">Company: <strong><?= sanitize($inq['company'] ?: 'Individual / N/A') ?></strong></span>
                            </div>

                            <form method="POST" class="flex items-center gap-2">
                                <input type="hidden" name="inquiry_id" value="<?= $inq['id'] ?>">
                                <select name="status" onchange="this.form.submit()" class="bg-white border text-xs font-bold rounded-lg px-2.5 py-1">
                                    <option value="New" <?= $inq['status'] === 'New' ? 'selected' : '' ?>>New</option>
                                    <option value="Contacted" <?= $inq['status'] === 'Contacted' ? 'selected' : '' ?>>Contacted</option>
                                    <option value="Fulfilled" <?= $inq['status'] === 'Fulfilled' ? 'selected' : '' ?>>Fulfilled</option>
                                </select>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div><strong>Email:</strong> <?= sanitize($inq['email']) ?></div>
                            <div><strong>Phone:</strong> <?= sanitize($inq['phone']) ?></div>
                            <div><strong>Qty Needed:</strong> <span class="font-bold text-amber-800"><?= sanitize($inq['quantity_needed']) ?></span></div>
                        </div>

                        <div class="bg-white p-3 rounded-xl border text-xs text-gray-700">
                            <strong class="text-[10px] uppercase text-gray-400 block mb-1">Inquiry Specifications & Requirements:</strong>
                            <p><?= nl2br(sanitize($inq['message'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>
