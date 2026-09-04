<?php
// includes/footer.php
?>
    <!-- Footer Section -->
    <footer class="bg-spice-dark text-amber-100/90 pt-16 pb-12 mt-auto border-t-4 border-spice-gold">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-amber-900/60">
                
                <!-- Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <a href="<?= url('') ?>" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-spice-red to-spice-gold flex items-center justify-center text-white text-xl">
                            <i class="fa-solid fa-pepper-hot"></i>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-white uppercase">PHBN <span class="text-spice-gold">Traders</span></span>
                    </a>
                    <p class="text-xs text-amber-200/70 leading-relaxed max-w-sm">
                        PHBN Traders is a premier spice house specializing in 100% pure, ethically sourced single-origin spices, hand-picked whole botanicals, and artisanal blended masalas direct from traditional spice gardens.
                    </p>
                    <div class="flex items-center gap-4 pt-2">
                        <a href="#" class="w-9 h-9 rounded-full bg-amber-900/50 hover:bg-spice-gold text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-amber-900/50 hover:bg-spice-gold text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-instagram text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-amber-900/50 hover:bg-spice-gold text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-amber-900/50 hover:bg-spice-gold text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4 border-b border-amber-800/40 pb-2">Categories</h4>
                    <ul class="space-y-2 text-xs text-amber-200/80">
                        <li><a href="<?= url('category/ground-spices') ?>" class="hover:text-amber-400 transition-colors">Ground Spices</a></li>
                        <li><a href="<?= url('category/whole-spices') ?>" class="hover:text-amber-400 transition-colors">Whole Spices</a></li>
                        <li><a href="<?= url('category/blended-masalas') ?>" class="hover:text-amber-400 transition-colors">Blended Masalas</a></li>
                        <li><a href="<?= url('category/exotic-premium') ?>" class="hover:text-amber-400 transition-colors">Exotic & Premium</a></li>
                        <li><a href="<?= url('category/organic-wellness') ?>" class="hover:text-amber-400 transition-colors">Organic & Wellness</a></li>
                    </ul>
                </div>

                <!-- Commercial & Wholesale -->
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4 border-b border-amber-800/40 pb-2">Business & Services</h4>
                    <ul class="space-y-2 text-xs text-amber-200/80">
                        <li><a href="<?= url('wholesale') ?>" class="hover:text-amber-400 transition-colors font-bold text-spice-amber">Bulk Wholesale Inquiries</a></li>
                        <li><a href="<?= url('spice-masterclass') ?>" class="hover:text-amber-400 transition-colors">Spice Pairing Guide</a></li>
                        <li><a href="<?= url('about-us') ?>" class="hover:text-amber-400 transition-colors">Sourcing & Purity Standards</a></li>
                        <li><a href="<?= url('contact-us') ?>" class="hover:text-amber-400 transition-colors">Contact Support</a></li>
                        <li><a href="<?= url('admin/index.php') ?>" class="hover:text-amber-400 transition-colors">Admin Dashboard</a></li>
                    </ul>
                </div>

                <!-- Newsletter & Support -->
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4 border-b border-amber-800/40 pb-2">Subscribe for Offers</h4>
                    <p class="text-xs text-amber-200/70 mb-3">Join 15,000+ spice lovers & culinary experts receiving seasonal spice harvest updates.</p>
                    <form onsubmit="event.preventDefault(); showToast('Thank you for subscribing to PHBN Traders!');" class="space-y-2">
                        <input type="email" placeholder="Your email address" required class="w-full bg-amber-950/60 border border-amber-900 text-xs rounded-lg px-3 py-2.5 text-white placeholder-amber-400/50 focus:outline-none focus:border-spice-gold">
                        <button type="submit" class="w-full bg-spice-gold hover:bg-amber-600 text-white font-semibold text-xs py-2.5 rounded-lg transition-colors">Subscribe Now</button>
                    </form>
                </div>

            </div>

            <!-- Footer Bottom Bar -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-amber-300/60 gap-4">
                <p>&copy; <?= date('Y') ?> PHBN Traders. All Rights Reserved. Crafted for Purity & Culinary Excellence.</p>
                <div class="flex items-center gap-6">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-amber-400"></i> FSSAI Certified</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-leaf text-emerald-400"></i> Non-GMO</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-box text-amber-400"></i> Vacuum Packaged</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Container Target -->
    <div id="toast-container"></div>

    <!-- Main JavaScript -->
    <script src="<?= url('assets/js/main.js') ?>"></script>
</body>
</html>
