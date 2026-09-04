<?php
// recipes.php - Spice Masterclass & Pairing Guide
$pageTitle = "Spice Masterclass & Culinary Pairing Guide - PHBN Traders";
$pageDescription = "Learn the science of tempering whole spices, slow stone cold grinding, and spice heat matrix pairings.";
require_once __DIR__ . '/includes/header.php';
?>

<div class="bg-spice-dark text-white py-16 hero-gradient border-b border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl space-y-4">
        <span class="px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full uppercase tracking-wider"><i class="fa-solid fa-utensils mr-1"></i> Culinary Artistry</span>
        <h1 class="text-4xl font-extrabold tracking-tight">The Spice Masterclass</h1>
        <p class="text-xs sm:text-sm text-amber-200/80 leading-relaxed">
            Unlock the science of dry-roasting whole botanicals, blooming spices in warm ghee, and mastering authentic regional spice blends.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">

    <!-- Article 1: Tempered Spice Blooming (Tadka) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center bg-white p-8 rounded-3xl border border-spice-border shadow-sm">
        <div class="rounded-2xl overflow-hidden h-72 lg:h-96">
            <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=800&auto=format&fit=crop&q=80" class="w-full h-full object-cover">
        </div>
        <div class="space-y-4">
            <span class="text-xs font-bold text-spice-gold uppercase tracking-wider">Technique 01</span>
            <h2 class="text-2xl font-extrabold text-spice-dark">The Art of Sputtering Whole Spices (Tadka / Tempering)</h2>
            <p class="text-xs text-gray-600 leading-relaxed">
                When whole spices like royal cumin, mustard seeds, and cloves hit hot oil or clarified ghee ($175^\circ\text{C}$ to $190^\circ\text{C}$), the heat bursts their microscopic oil sacs. This releases fat-soluble aromatic terpenes into the medium.
            </p>
            <div class="bg-amber-50 p-4 rounded-xl border border-amber-200 text-xs space-y-1 text-amber-900">
                <strong class="block font-bold">Pro Tip for Whole Spices:</strong>
                <span>Always drop heavy spices (cinnamon sticks, black cardamom) first, followed by medium (cloves, star anise), and finish with delicate seeds (cumin, mustard) so they never burn.</span>
            </div>
            <a href="<?= url('category/whole-spices') ?>" class="btn-spice-primary text-xs inline-block">Shop Whole Spices for Tempering</a>
        </div>
    </div>

    <!-- Article 2: Dry Roasting & Cold Grinding -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center bg-white p-8 rounded-3xl border border-spice-border shadow-sm">
        <div class="space-y-4 order-2 lg:order-1">
            <span class="text-xs font-bold text-spice-red uppercase tracking-wider">Technique 02</span>
            <h2 class="text-2xl font-extrabold text-spice-dark">Dry Roasting & Cold Grinding Garam Masala</h2>
            <p class="text-xs text-gray-600 leading-relaxed">
                High-speed commercial grinding generates frictional heat above $60^\circ\text{C}$, evaporating delicate essential oils. PHBN Traders uses low-temperature slow stone milling below $35^\circ\text{C}$ to guarantee that volatile aromas stay inside your masala container.
            </p>
            <ul class="text-xs space-y-2 text-gray-700">
                <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> Roast whole spices on a heavy iron skillet for 3 minutes on low flame.</li>
                <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> Cool completely before pulverizing to avoid moisture condensation.</li>
            </ul>
            <a href="<?= url('category/blended-masalas') ?>" class="btn-spice-secondary text-xs inline-block">Explore Our Artisanal Masala Blends</a>
        </div>
        <div class="rounded-2xl overflow-hidden h-72 lg:h-96 order-1 lg:order-2">
            <img src="https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=800&auto=format&fit=crop&q=80" class="w-full h-full object-cover">
        </div>
    </div>

    <!-- Flavor Matrix Chart -->
    <div class="bg-spice-cream border border-spice-border p-8 rounded-3xl space-y-6">
        <div class="text-center max-w-xl mx-auto">
            <h2 class="text-2xl font-extrabold text-spice-dark">Spice Flavor & Heat Pairing Matrix</h2>
            <p class="text-xs text-gray-500 mt-1">Match heat profiles with the right culinary pairing.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
            <div class="bg-white p-6 rounded-2xl border border-spice-border space-y-3">
                <div class="flex items-center justify-between border-b border-spice-border pb-2">
                    <h3 class="font-bold text-spice-red">Kashmiri Red Chilli</h3>
                    <span class="heat-badge Mild">Mild Heat</span>
                </div>
                <p class="text-gray-600">Deep crimson dye, fruity undertones, subtle warmth.</p>
                <div class="text-gray-500"><strong>Best paired with:</strong> Paneer tikka, butter chicken, seafood gravies, lentils.</div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-spice-border space-y-3">
                <div class="flex items-center justify-between border-b border-spice-border pb-2">
                    <h3 class="font-bold text-spice-gold">Lakadong Turmeric</h3>
                    <span class="heat-badge Medium-Hot">High Curcumin</span>
                </div>
                <p class="text-gray-600">Earthy, pepper-tinted aroma, golden pigment.</p>
                <div class="text-gray-500"><strong>Best paired with:</strong> Golden milk (Haldi doodh), dal fry, vegetable curries.</div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-spice-border space-y-3">
                <div class="flex items-center justify-between border-b border-spice-border pb-2">
                    <h3 class="font-bold text-emerald-800">Idukki Green Cardamom</h3>
                    <span class="heat-badge Mild">Sweet Aromatic</span>
                </div>
                <p class="text-gray-600">Menthol eucalyptus notes, citrus sweetness.</p>
                <div class="text-gray-500"><strong>Best paired with:</strong> Masala chai, kheer, biryani rice, kulfi desserts.</div>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
