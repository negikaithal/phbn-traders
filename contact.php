<?php
// contact.php - Contact Support & FAQ
require_once __DIR__ . '/includes/header.php';

$messageSent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageSent = true;
}
?>

<div class="bg-spice-dark text-white py-12 border-b border-spice-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight">Contact PHBN Traders</h1>
        <p class="text-xs text-amber-200/80 mt-1">Reach out to our customer care team or wholesale trade desk.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Info -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-spice-border shadow-sm space-y-4 text-xs">
                <h3 class="font-bold text-sm text-spice-dark border-b border-spice-border pb-2 uppercase">Headquarters & Warehouse</h3>
                
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-location-dot text-spice-gold text-lg shrink-0 mt-0.5"></i>
                    <div>
                        <strong class="block text-gray-800">PHBN Traders Pvt Ltd</strong>
                        <span class="text-gray-600">Plot 45, Spice Trade Park, Industrial Estate,<br>Cochin / Mumbai, India</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-phone text-spice-red text-lg shrink-0"></i>
                    <div>
                        <strong class="block text-gray-800">Phone Support</strong>
                        <span class="text-gray-600">+91 98765 43210 / +91 22 2400 1122</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-envelope text-spice-gold text-lg shrink-0"></i>
                    <div>
                        <strong class="block text-gray-800">Email Inquiries</strong>
                        <span class="text-gray-600">support@phbntraders.com</span>
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 p-6 rounded-2xl border border-amber-200 text-xs text-amber-900 space-y-2">
                <h4 class="font-bold flex items-center gap-1.5"><i class="fa-solid fa-clock"></i> Working Hours</h4>
                <p>Monday – Saturday: 9:00 AM – 7:00 PM IST</p>
                <p>Orders placed before 2:00 PM are dispatched same day.</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl border border-spice-border shadow-sm">
            <h3 class="text-xl font-extrabold text-spice-dark mb-6">Send Us a Message</h3>

            <?php if ($messageSent): ?>
                <div class="p-6 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl text-center space-y-2">
                    <i class="fa-solid fa-circle-check text-4xl text-emerald-600"></i>
                    <h4 class="font-bold text-base">Message Sent!</h4>
                    <p class="text-xs">Thank you for reaching out. We will reply to your message promptly.</p>
                </div>
            <?php else: ?>
                <form method="POST" class="space-y-4 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase mb-1">Your Name *</label>
                            <input type="text" required placeholder="Enter full name" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 uppercase mb-1">Email Address *</label>
                            <input type="email" required placeholder="name@domain.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Subject</label>
                        <input type="text" placeholder="Order status, general question, etc." class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 uppercase mb-1">Message *</label>
                        <textarea rows="5" required placeholder="How can we assist you?" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-spice-red"></textarea>
                    </div>

                    <button type="submit" class="btn-spice-primary text-xs py-3 px-6">Send Message</button>
                </form>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
