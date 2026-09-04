<?php
// wholesale.php - Commercial & Wholesale Trade Inquiries
require_once __DIR__ . '/includes/header.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $company = sanitize($_POST['company'] ?? '');
    $quantity = sanitize($_POST['quantity_needed'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        $error = "Please fill in all mandatory inquiry fields.";
    } else {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("INSERT INTO inquiries (name, email, phone, company, quantity_needed, message, status) VALUES (?, ?, ?, ?, ?, ?, 'New')");
            $stmt->execute([$name, $email, $phone, $company, $quantity, $message]);
            $success = true;
        } catch (PDOException $e) {
            $error = "Failed to submit inquiry: " . $e->getMessage();
        }
    }
}
?>

<!-- Hero Banner -->
<div class="bg-spice-dark text-white py-16 hero-gradient border-b border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl space-y-4">
        <span class="px-3 py-1 bg-spice-gold text-white text-xs font-bold rounded-full uppercase tracking-wider">B2B Trade & Exports</span>
        <h1 class="text-4xl font-extrabold tracking-tight">Wholesale & Bulk Spice Supply Desk</h1>
        <p class="text-xs sm:text-sm text-amber-200/80 leading-relaxed">
            Direct estate sourcing, custom grinding mesh sizes (40 to 100 mesh), ASTA color value verification, and moisture-controlled vacuum packaging for commercial buyers.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Left Column: Specs & Features -->
        <div class="space-y-8">
            <div>
                <span class="text-xs font-bold text-spice-gold uppercase tracking-wider">Commercial Capabilities</span>
                <h2 class="text-3xl font-extrabold text-spice-dark tracking-tight mt-1">Why Partner With PHBN Traders?</h2>
            </div>

            <div class="space-y-4 text-xs">
                <div class="bg-white p-5 rounded-2xl border border-spice-border shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-spice-red text-white flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-spice-dark">Custom Packaging Options</h4>
                        <p class="text-gray-600 mt-1">From 5kg food-grade pouches to 25kg multi-wall paper bags & 50kg jute sacks for international export shipping.</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-spice-border shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-spice-gold text-white flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-vial-circle-check"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-spice-dark">Certificate of Analysis (COA)</h4>
                        <p class="text-gray-600 mt-1">Every lot comes with batch lab test reports verifying zero adulterants, low volatile moisture, and high essential oil content.</p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-spice-border shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-spice-dark">Pan-India & Global Freight Support</h4>
                        <p class="text-gray-600 mt-1">Contract logistics partnership with surface transport, rail cargo, and ocean container export handling.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Hotline Widget -->
            <div class="p-6 bg-spice-cream rounded-2xl border border-spice-border flex items-center justify-between">
                <div>
                    <span class="text-[11px] text-gray-500 font-semibold block">Need Urgent Trade Quote over Phone?</span>
                    <span class="text-base font-extrabold text-spice-dark">+91 98765 43210</span>
                </div>
                <a href="tel:+919876543210" class="btn-spice-primary text-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-phone"></i> Call Wholesale Desk
                </a>
            </div>
        </div>

        <!-- Right Column: Inquiry Form -->
        <div class="bg-white p-8 rounded-3xl border border-spice-border shadow-md">
            <h3 class="text-xl font-extrabold text-spice-dark border-b border-spice-border pb-3 mb-6">
                Submit Bulk Trade Inquiry
            </h3>

            <?php if ($success): ?>
                <div class="p-6 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl text-center space-y-3">
                    <i class="fa-solid fa-circle-check text-4xl text-emerald-600"></i>
                    <h4 class="font-bold text-base">Inquiry Submitted Successfully!</h4>
                    <p class="text-xs text-emerald-800">Our wholesale account manager will review your specs and email a commercial quotation within 4 business hours.</p>
                </div>
            <?php else: ?>

                <?php if ($error): ?>
                    <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 text-xs rounded-xl">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-4 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase mb-1">Contact Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Vikramaditya Singh" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase mb-1">Business Email *</label>
                            <input type="email" name="email" required placeholder="trade@company.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase mb-1">Phone / WhatsApp *</label>
                            <input type="tel" name="phone" required placeholder="+91 98765 43210" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 uppercase mb-1">Company / Brand Name</label>
                            <input type="text" name="company" placeholder="e.g. Grand Spice Foods Ltd" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Estimated Quantity Needed</label>
                        <select name="quantity_needed" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red font-medium">
                            <option value="50kg - 200kg">50 kg - 200 kg (Small Bulk)</option>
                            <option value="200kg - 1 Ton">200 kg - 1 Ton (Restaurant Supply)</option>
                            <option value="1 Ton - 5 Tons">1 Ton - 5 Tons (Distributor Quantity)</option>
                            <option value="5 Tons+ Export Container">5 Tons+ (Export Container Load)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Specific Spices & Mesh Specs *</label>
                        <textarea name="message" rows="4" required placeholder="Specify the spices required (e.g., Kashmiri chilli powder 80 mesh, 8mm green cardamom, Malabar black pepper 500g vacuum packs)..." class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red"></textarea>
                    </div>

                    <button type="submit" class="btn-spice-primary w-full text-center py-3 text-xs shadow-md">
                        Submit Wholesale Quotation Request <i class="fa-solid fa-paper-plane ml-1"></i>
                    </button>
                </form>

            <?php endif; ?>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
