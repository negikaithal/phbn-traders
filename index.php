<?php
// index.php - Home Page
$pageTitle = "PHBN Traders | Pure, Aromatic & Wholesale Standard Spices";
$pageDescription = "Discover PHBN Traders range of 100% pure single-origin whole spices, cold-ground masalas, and luxury Kashmiri saffron. Sourced direct from spice estates.";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// Fetch Categories
$catStmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
$categories = $catStmt->fetchAll();

// Fetch Featured Products
$featStmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.is_featured = 1 AND p.status = 'active' LIMIT 6");
$featuredProducts = $featStmt->fetchAll();
?>

<!-- Hero Banner -->
<section class="relative bg-spice-dark text-white py-20 lg:py-28 overflow-hidden hero-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-2xl space-y-6">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-spice-gold/30 border border-spice-gold/50 text-amber-200 text-xs font-semibold uppercase tracking-wider">
                <i class="fa-solid fa-award text-amber-400"></i> Direct Estate Sourced Spices
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-white">
                Uncompromising <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-200">Aroma & Purity</span> Direct From Source
            </h1>
            <p class="text-base sm:text-lg text-amber-100/80 font-light leading-relaxed">
                Elevate your culinary creations with PHBN Traders’ handpicked whole spices, vibrant cold-ground masalas, and luxury Kashmiri saffron. 100% natural, lab-tested, and vacuum-sealed for peak essential oil freshness.
            </p>
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="<?= url('products') ?>" class="btn-spice-primary text-sm flex items-center gap-2 shadow-lg">
                    <i class="fa-solid fa-cart-shopping"></i> Explore Spice Collection
                </a>
                <a href="<?= url('wholesale') ?>" class="btn-spice-secondary text-sm flex items-center gap-2 shadow-lg">
                    <i class="fa-solid fa-truck-ramp-box"></i> Bulk & Commercial Orders
                </a>
            </div>
            
            <!-- Quick Metrics -->
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-amber-900/60 max-w-lg">
                <div>
                    <div class="text-2xl font-bold text-amber-300">100%</div>
                    <div class="text-xs text-amber-200/70">Pure & Adulterant Free</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-amber-300">5.2%+</div>
                    <div class="text-xs text-amber-200/70">High Active Curcumin</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-amber-300">500+</div>
                    <div class="text-xs text-amber-200/70">Restaurants & Export Partners</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Badges Bar -->
<section class="bg-white border-b border-spice-border py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex items-center gap-4 p-2">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-spice-gold flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-sun"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-spice-dark">Sun-Dried & Cold Ground</h4>
                    <p class="text-xs text-gray-500">Preserves vital aromatic oils</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-2">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-vial"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-spice-dark">100% Lab Tested Purity</h4>
                    <p class="text-xs text-gray-500">Zero synthetic colors or lead</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-2">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-spice-red flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-spice-dark">Triple Vacuum Sealed</h4>
                    <p class="text-xs text-gray-500">Locks in crisp flavor & aroma</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-2">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-spice-dark">Direct Farmer Sourcing</h4>
                    <p class="text-xs text-gray-500">Fair price to spice growers</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Showcase -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
        <div>
            <span class="text-xs font-bold text-spice-gold uppercase tracking-wider">Explore By Type</span>
            <h2 class="text-3xl font-extrabold text-spice-dark tracking-tight">Our Spice Categories</h2>
        </div>
        <a href="<?= url('products') ?>" class="text-sm font-bold text-spice-red hover:underline flex items-center gap-1">
            View All Categories <i class="fa-solid fa-chevron-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <?php foreach ($categories as $cat): ?>
        <a href="<?= url('category/' . sanitize($cat['slug'])) ?>" class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-spice-border h-64 flex flex-col justify-end p-5">
            <img src="<?= sanitize($cat['image']) ?>" alt="<?= sanitize($cat['name']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
            <div class="relative z-10">
                <h3 class="text-lg font-bold text-white group-hover:text-amber-300 transition-colors"><?= sanitize($cat['name']) ?></h3>
                <p class="text-xs text-gray-200/80 line-clamp-2 mt-1"><?= sanitize($cat['description']) ?></p>
                <span class="inline-flex items-center gap-1 text-xs text-amber-400 font-semibold mt-3">
                    Shop Now <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Best Seller / Featured Products -->
<section class="py-16 bg-amber-900/5 border-y border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
            <div>
                <span class="text-xs font-bold text-spice-red uppercase tracking-wider"><i class="fa-solid fa-fire text-amber-500 mr-1"></i> Kitchen Staples</span>
                <h2 class="text-3xl font-extrabold text-spice-dark tracking-tight">Best Selling Premium Spices</h2>
            </div>
            <a href="<?= url('products') ?>" class="btn-spice-outline text-xs">Browse Complete Pantry</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="spice-card rounded-2xl overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Image container -->
                    <div class="relative h-56 overflow-hidden bg-gray-100">
                        <img src="<?= sanitize($product['image']) ?>" alt="<?= sanitize($product['name']) ?>" class="w-full h-full object-cover">
                        
                        <!-- Heat Badge -->
                        <span class="absolute top-3 left-3 heat-badge <?= sanitize($product['heat_level']) ?>">
                            <i class="fa-solid fa-pepper-hot"></i> <?= sanitize($product['heat_level']) ?>
                        </span>

                        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-md text-spice-dark text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                            <?= sanitize($product['category_name']) ?>
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="p-6">
                        <div class="flex items-center gap-1 text-amber-500 text-xs mb-1">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span class="text-gray-400 ml-1 text-[11px]">(4.9/5)</span>
                        </div>

                        <h3 class="text-lg font-bold text-spice-dark hover:text-spice-red transition-colors line-clamp-1">
                            <a href="<?= url('spice/' . sanitize($product['slug'])) ?>"><?= sanitize($product['name']) ?></a>
                        </h3>

                        <p class="text-xs text-gray-600 line-clamp-2 mt-2 leading-relaxed">
                            <?= sanitize($product['description']) ?>
                        </p>

                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                            <span><i class="fa-solid fa-location-dot text-spice-gold mr-1"></i> Origin: <?= sanitize($product['origin']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Footer / Price & Add to Cart -->
                <div class="p-6 pt-0 bg-white">
                    <form action="<?= url('cart-action.php') ?>" method="POST" class="space-y-3">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs text-gray-500 block">Base Price (250g)</span>
                                <span class="text-xl font-extrabold text-spice-red"><?= formatCurrency($product['price']) ?></span>
                            </div>
                            
                            <select name="weight" class="bg-gray-50 border border-gray-200 text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-spice-red font-medium">
                                <option value="250g">250g</option>
                                <option value="100g">100g</option>
                                <option value="500g">500g</option>
                                <option value="1kg">1kg</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="<?= url('spice/' . sanitize($product['slug'])) ?>" class="text-center py-2 px-3 border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                View Details
                            </a>
                            <button type="submit" class="bg-spice-red hover:bg-spice-red-hover text-white text-xs font-bold py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1 shadow-sm">
                                <i class="fa-solid fa-plus"></i> Add to Cart
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Wholesale & Bulk Trade Banner -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-gradient-to-r from-spice-dark via-amber-950 to-spice-brown text-white rounded-3xl p-8 lg:p-14 relative overflow-hidden shadow-2xl">
        <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-20 pointer-events-none hidden lg:block">
            <i class="fa-solid fa-dolly text-[280px] text-white"></i>
        </div>
        <div class="max-w-2xl space-y-5 relative z-10">
            <span class="bg-spice-gold text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Commercial Supply</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Supplying Bulk Spices to Hotels, Restaurants & Exporters Worldwide</h2>
            <p class="text-sm text-amber-200/80 leading-relaxed">
                Need bulk 5kg, 25kg, or custom vacuum jute bag packaging? We offer wholesale rates, custom grinding mesh sizes, and certificate of analysis (COA) for commercial buyers.
            </p>
            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="<?= url('wholesale') ?>" class="bg-spice-gold hover:bg-amber-600 text-white font-bold text-sm px-6 py-3 rounded-xl transition-all shadow-lg flex items-center gap-2">
                    Request Wholesale Rate List <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                <a href="tel:+919876543210" class="border border-amber-500/40 text-amber-200 hover:bg-white/10 text-sm font-semibold px-5 py-3 rounded-xl transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-phone text-xs"></i> Trade Desk: +91 98765 43210
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Customer Reviews -->
<section class="py-16 bg-white border-t border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-12">
            <span class="text-xs font-bold text-spice-gold uppercase tracking-wider">Trusted Quality</span>
            <h2 class="text-3xl font-extrabold text-spice-dark tracking-tight mt-1">What Chefs & Home Cooks Say</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-spice-cream p-6 rounded-2xl border border-spice-border space-y-4 shadow-sm">
                <div class="flex items-center gap-1 text-amber-500 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-gray-700 leading-relaxed italic">
                    "The Kashmiri Red Chilli powder from PHBN Traders gives my biryani gravies the exact rich red color without turning it too spicy. The freshness when opening the seal is incredible!"
                </p>
                <div class="flex items-center gap-3 pt-2 border-t border-spice-border">
                    <div class="w-9 h-9 rounded-full bg-spice-red text-white flex items-center justify-center font-bold text-xs">RK</div>
                    <div>
                        <h4 class="text-xs font-bold text-spice-dark">Chef Rajesh Kumar</h4>
                        <span class="text-[10px] text-gray-500">Executive Chef, Royal Heritage Bistro</span>
                    </div>
                </div>
            </div>

            <div class="bg-spice-cream p-6 rounded-2xl border border-spice-border space-y-4 shadow-sm">
                <div class="flex items-center gap-1 text-amber-500 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-gray-700 leading-relaxed italic">
                    "Their Lakadong turmeric powder is true grade 1. You can immediately feel the deep golden yellow color and aroma compared to supermarket turmeric."
                </p>
                <div class="flex items-center gap-3 pt-2 border-t border-spice-border">
                    <div class="w-9 h-9 rounded-full bg-spice-gold text-white flex items-center justify-center font-bold text-xs">PS</div>
                    <div>
                        <h4 class="text-xs font-bold text-spice-dark">Priya Sharma</h4>
                        <span class="text-[10px] text-gray-500">Wellness & Culinary Blogger</span>
                    </div>
                </div>
            </div>

            <div class="bg-spice-cream p-6 rounded-2xl border border-spice-border space-y-4 shadow-sm">
                <div class="flex items-center gap-1 text-amber-500 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-gray-700 leading-relaxed italic">
                    "We order 25kg bulk bags of Green Cardamom and Pepper for our catering chain. Timely delivery, superb vacuum packaging, and clean wholesale pricing."
                </p>
                <div class="flex items-center gap-3 pt-2 border-t border-spice-border">
                    <div class="w-9 h-9 rounded-full bg-spice-dark text-white flex items-center justify-center font-bold text-xs">AM</div>
                    <div>
                        <h4 class="text-xs font-bold text-spice-dark">Anand Mehta</h4>
                        <span class="text-[10px] text-gray-500">Director, Grand Feast Caterers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
