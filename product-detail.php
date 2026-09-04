<?php
// product-detail.php - Comprehensive Product Details
require_once __DIR__ . '/includes/functions.php';

$pdo = getDBConnection();
$productId = intval($_GET['id'] ?? 0);
$slug = sanitize($_GET['slug'] ?? '');

if (!empty($slug)) {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                           FROM products p 
                           LEFT JOIN categories c ON p.category_id = c.id 
                           WHERE p.slug = ?");
    $stmt->execute([$slug]);
    $product = $stmt->fetch();
} else {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                           FROM products p 
                           LEFT JOIN categories c ON p.category_id = c.id 
                           WHERE p.id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();
}

if (!$product) {
    header("HTTP/1.0 404 Not Found");
    $pageTitle = "Spice Not Found - PHBN Traders";
    require_once __DIR__ . '/includes/header.php';
    echo "<div class='max-w-7xl mx-auto px-4 py-20 text-center'><h2 class='text-2xl font-bold'>Spice Not Found</h2><a href='" . url('products') . "' class='btn-spice-primary mt-4 inline-block'>Return to Catalog</a></div>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Set SEO Meta
$pageTitle = sanitize($product['name']) . " - PHBN Traders";
$pageDescription = sanitize(substr($product['description'], 0, 160));
$pageImage = sanitize($product['image']);
$pageCanonical = url('spice/' . $product['slug']);

require_once __DIR__ . '/includes/header.php';

// Fetch related products
$relStmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 3");
$relStmt->execute([$product['category_id'], $product['id']]);
$relatedProducts = $relStmt->fetchAll();
?>

<!-- Schema.org JSON-LD Structured Data for Google SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<?= addslashes(sanitize($product['name'])) ?>",
  "image": ["<?= addslashes(sanitize($product['image'])) ?>"],
  "description": "<?= addslashes(sanitize($product['description'])) ?>",
  "sku": "PHBN-<?= $product['id'] ?>",
  "brand": {
    "@type": "Brand",
    "name": "PHBN Traders"
  },
  "offers": {
    "@type": "Offer",
    "url": "<?= sanitize($pageCanonical) ?>",
    "priceCurrency": "INR",
    "price": "<?= $product['price'] ?>",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "https://schema.org/InStock"
  }
}
</script>

<!-- Breadcrumbs -->
<div class="bg-gray-100 py-3 border-b border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs text-gray-500 flex items-center gap-2">
        <a href="<?= url('') ?>" class="hover:text-spice-red">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="<?= url('products') ?>" class="hover:text-spice-red">Shop</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="<?= url('category/' . sanitize($product['category_slug'])) ?>" class="hover:text-spice-red"><?= sanitize($product['category_name']) ?></a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-spice-dark font-semibold"><?= sanitize($product['name']) ?></span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Product Image Gallery -->
        <div class="space-y-4">
            <div class="rounded-3xl overflow-hidden border border-spice-border bg-white shadow-sm h-96 sm:h-[480px]">
                <img id="main-product-img" src="<?= sanitize($product['image']) ?>" alt="<?= sanitize($product['name']) ?>" class="w-full h-full object-cover">
            </div>
            
            <div class="grid grid-cols-3 gap-4">
                <div class="border-2 border-spice-red rounded-xl overflow-hidden h-24 bg-gray-50 cursor-pointer">
                    <img src="<?= sanitize($product['image']) ?>" class="w-full h-full object-cover">
                </div>
                <div class="border border-spice-border rounded-xl overflow-hidden h-24 bg-gray-50 flex items-center justify-center text-xs text-gray-500 font-medium">
                    <i class="fa-solid fa-leaf text-emerald-500 text-lg mr-1"></i> 100% Pure
                </div>
                <div class="border border-spice-border rounded-xl overflow-hidden h-24 bg-gray-50 flex items-center justify-center text-xs text-gray-500 font-medium">
                    <i class="fa-solid fa-box text-amber-500 text-lg mr-1"></i> Vacuum Packaged
                </div>
            </div>
        </div>

        <!-- Product Information & Purchasing Form -->
        <div class="space-y-6">
            <div>
                <span class="heat-badge <?= sanitize($product['heat_level']) ?> mb-2">
                    <i class="fa-solid fa-pepper-hot"></i> Heat Level: <?= sanitize($product['heat_level']) ?>
                </span>
                <h1 class="text-3xl font-extrabold text-spice-dark tracking-tight mt-1"><?= sanitize($product['name']) ?></h1>
                
                <div class="flex items-center gap-4 mt-2 text-xs">
                    <span class="text-gray-500"><i class="fa-solid fa-location-dot text-spice-gold mr-1"></i> Sourced from: <strong><?= sanitize($product['origin']) ?></strong></span>
                    <span class="text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i> In Stock & Ready to Ship</span>
                </div>
            </div>

            <!-- Price & Purchasing Form -->
            <div class="bg-white p-6 rounded-2xl border border-spice-border space-y-4 shadow-sm">
                <div class="flex items-baseline gap-3">
                    <span id="display-price" data-base-price="<?= $product['price'] ?>" class="text-3xl font-extrabold text-spice-red">
                        <?= formatCurrency($product['price']) ?>
                    </span>
                    <span class="text-xs text-gray-400">Inclusive of all taxes</span>
                </div>

                <form action="<?= url('cart-action.php') ?>" method="POST" class="space-y-4 pt-4 border-t border-gray-100">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Select Weight Option</label>
                            <select id="weight-selector" name="weight" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl px-3 py-3 focus:outline-none focus:border-spice-red font-semibold">
                                <option value="250g" selected>250g Pouch (Standard)</option>
                                <option value="100g">100g Pouch</option>
                                <option value="500g">500g Pack</option>
                                <option value="1kg">1kg Saver Pack</option>
                                <option value="5kg Bulk">5kg Bulk Sack</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Quantity</label>
                            <input type="number" name="quantity" value="1" min="1" max="20" class="w-full bg-gray-50 border border-gray-200 text-xs rounded-xl px-3 py-3 font-semibold focus:outline-none focus:border-spice-red">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <button type="submit" class="btn-spice-primary w-full text-center flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                        </button>
                        <a href="<?= url('wholesale') ?>" class="btn-spice-secondary w-full text-center flex items-center justify-center gap-2 text-xs">
                            <i class="fa-solid fa-truck-ramp-box"></i> Wholesale Rate Quote
                        </a>
                    </div>
                </form>
            </div>

            <!-- Detailed Tabs & Features -->
            <div class="space-y-4 text-xs">
                <div class="bg-amber-50/60 p-4 rounded-xl border border-amber-200/60">
                    <h4 class="font-bold text-spice-dark text-xs uppercase mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-align-left text-spice-gold"></i> Product Description
                    </h4>
                    <p class="text-gray-700 leading-relaxed"><?= sanitize($product['description']) ?></p>
                </div>

                <div class="bg-emerald-50/60 p-4 rounded-xl border border-emerald-200/60">
                    <h4 class="font-bold text-emerald-900 text-xs uppercase mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-heart-pulse text-emerald-600"></i> Health Benefits & Bioactives
                    </h4>
                    <p class="text-emerald-950 leading-relaxed"><?= sanitize($product['benefits']) ?></p>
                </div>
            </div>

        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="mt-20 pt-12 border-t border-spice-border">
        <h3 class="text-2xl font-extrabold text-spice-dark tracking-tight mb-6">More Spices from <?= sanitize($product['category_name']) ?></h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <?php foreach ($relatedProducts as $rel): ?>
            <div class="spice-card rounded-2xl overflow-hidden p-4 space-y-3">
                <img src="<?= sanitize($rel['image']) ?>" class="w-full h-40 object-cover rounded-xl">
                <h4 class="font-bold text-sm text-spice-dark hover:text-spice-red">
                    <a href="<?= url('spice/' . sanitize($rel['slug'])) ?>"><?= sanitize($rel['name']) ?></a>
                </h4>
                <div class="flex justify-between items-center text-xs">
                    <span class="font-bold text-spice-red"><?= formatCurrency($rel['price']) ?></span>
                    <a href="<?= url('spice/' . sanitize($rel['slug'])) ?>" class="text-spice-gold font-semibold hover:underline">View</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
