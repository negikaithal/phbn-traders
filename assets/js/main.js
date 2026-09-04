/* assets/js/main.js - Interactive Shopping & UI Handling */

document.addEventListener('DOMContentLoaded', () => {
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Weight Selector Price Multiplier on Product Detail Page
    const weightSelector = document.getElementById('weight-selector');
    const displayPrice = document.getElementById('display-price');
    if (weightSelector && displayPrice) {
        const basePrice = parseFloat(displayPrice.getAttribute('data-base-price'));
        weightSelector.addEventListener('change', (e) => {
            const weight = e.target.value;
            let mult = 1.0;
            if (weight === '100g') mult = 0.45;
            else if (weight === '250g') mult = 1.0;
            else if (weight === '500g') mult = 1.9;
            else if (weight === '1kg') mult = 3.6;
            else if (weight === '5kg Bulk') mult = 16.5;

            const newPrice = (basePrice * mult).toFixed(2);
            displayPrice.textContent = '₹' + newPrice;
        });
    }

    // Image Error Fallback to Authentic Spice Vector Asset
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
            if (!this.getAttribute('data-fallback-applied')) {
                this.setAttribute('data-fallback-applied', 'true');
                this.src = 'assets/images/ground-spices.svg';
            }
        });
    });
});

// Toast Helper
function showToast(message) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = 'toast-msg';
    toast.innerHTML = `<i class="fa-solid fa-circle-check text-spice-gold text-lg"></i> <span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.4s ease';
        setTimeout(() => toast.remove(), 400);
    }, 3000);
}
