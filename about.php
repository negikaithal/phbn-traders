<?php
// about.php - Sourcing Story & Quality Assurance
$pageTitle = "Our Sourcing Story & Purity Standards - PHBN Traders";
$pageDescription = "Learn about PHBN Traders direct estate sourcing, non-GMO farming partnerships, and cold-grinding purity standards.";
require_once __DIR__ . '/includes/header.php';
?>

<div class="bg-spice-dark text-white py-16 hero-gradient border-b border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl space-y-4">
        <span class="px-3 py-1 bg-spice-gold text-white text-xs font-bold rounded-full uppercase tracking-wider">Heritage & Purity</span>
        <h1 class="text-4xl font-extrabold tracking-tight">The Story of PHBN Traders</h1>
        <p class="text-xs sm:text-sm text-amber-200/80 leading-relaxed">
            Bridging the gap between traditional spice estate growers and discerning culinary kitchens across the globe.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-4">
            <span class="text-xs font-bold text-spice-gold uppercase tracking-wider">Our Sourcing Philosophy</span>
            <h2 class="text-3xl font-extrabold text-spice-dark">From High-Altitude Farms Direct To Your Kitchen</h2>
            <p class="text-xs text-gray-600 leading-relaxed">
                Founded with a singular mission to restore unadulterated purity to everyday cooking, PHBN Traders partners directly with small-scale spice farmers in Kashmir, Kerala, Meghalaya, and Rajasthan.
            </p>
            <p class="text-xs text-gray-600 leading-relaxed">
                Most commercial spices pass through 5 to 7 middle traders before reaching retail shelves, losing up to 40% of their volatile essential oils. By sourcing directly at harvest and cold-grinding in small batches, we preserve peak aroma and vibrant natural color.
            </p>
        </div>
        <div class="rounded-3xl overflow-hidden shadow-lg border border-spice-border h-80">
            <img src="https://images.unsplash.com/photo-1509358217973-8898c6913c95?w=800&auto=format&fit=crop&q=80" class="w-full h-full object-cover">
        </div>
    </div>

    <!-- 4 Pillars -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-spice-border space-y-3">
            <i class="fa-solid fa-leaf text-emerald-600 text-3xl"></i>
            <h3 class="font-bold text-sm text-spice-dark">Non-GMO & Organic</h3>
            <p class="text-xs text-gray-500">Free from synthetic pesticides, chemical sprays, and artificial additives.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-spice-border space-y-3">
            <i class="fa-solid fa-sun text-amber-500 text-3xl"></i>
            <h3 class="font-bold text-sm text-spice-dark">Sun Dried</h3>
            <p class="text-xs text-gray-500">Naturally sun-cured to lock in moisture levels below 8% for enhanced shelf life.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-spice-border space-y-3">
            <i class="fa-solid fa-snowflake text-blue-500 text-3xl"></i>
            <h3 class="font-bold text-sm text-spice-dark">Cryo Cold Ground</h3>
            <p class="text-xs text-gray-500">Low temperature grinding ensures essential oil aroma stays trapped inside.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-spice-border space-y-3">
            <i class="fa-solid fa-box text-spice-gold text-3xl"></i>
            <h3 class="font-bold text-sm text-spice-dark">Triple Layer Barrier</h3>
            <p class="text-xs text-gray-500">Oxygen-absorbing vacuum sealed zip pouches prevent oxidation.</p>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
