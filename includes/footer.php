<?php
// Load products from database for JavaScript
require_once __DIR__ . '/../config.php';
$conn = getDatabaseConnection();
$products_json = '[]';

if ($conn) {
    $result = $conn->query("SELECT id, name, formula, category, form, purity, description as `desc`, price_index, effectiveness, image_path FROM products WHERE is_active = 1 ORDER BY category, name");
    $products_array = [];
    while ($row = $result->fetch_assoc()) {
        $products_array[] = $row;
    }
    $products_json = json_encode($products_array);
    $conn->close();
}
?>
    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 border-t border-gray-700 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-4">HydroChem Pro</h3>
                <p class="text-sm text-gray-400">
                    Leading supplier of industrial water treatment chemicals. Committed to safety, purity, and sustainability.
                </p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="contact.php" class="hover:text-brand-400 transition-colors">Contact Us</a></li>
                    <li><a href="#" class="hover:text-brand-400 transition-colors">Safety Data Sheets (SDS)</a></li>
                    <li><a href="#" class="hover:text-brand-400 transition-colors">Technical Support</a></li>
                    <li><a href="#" class="hover:text-brand-400 transition-colors">Shipping Policy</a></li>
                    <li><a href="./FAQ's.php" class="hover:text-brand-400 transition-colors">FAQ's</a></li>
                    <li><a href="./privacyPolicy.php" class="hover:text-brand-400 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Contact Sales</h4>
                <p class="text-sm text-gray-400 mb-2">📞 +1 (555) 123-4567</p>
                <p class="text-sm text-gray-400">📧 sales@hydrochempro.com</p>
                <div class="mt-4 flex space-x-4">
                    <!-- Unicode Social Icons -->
                    <span class="cursor-pointer hover:text-white">FB</span>
                    <span class="cursor-pointer hover:text-white">IN</span>
                    <span class="cursor-pointer hover:text-white">TW</span>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-4 border-t border-gray-700 text-center text-xs text-gray-500">
            &copy; 2024 HydroChem Pro Solutions. All rights reserved.
        </div>
    </footer>

    <!-- Cart Modal (Redirects to cart page) -->
    <div id="quote-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Shopping Cart - <span id="quote-count">0</span> Items</h3>
            <div id="quote-list" class="max-h-48 overflow-y-auto mb-4 text-sm text-gray-600 space-y-2 border p-2 rounded">
                <!-- Items populated here -->
            </div>
            <p class="text-xs text-gray-500 mb-4">Click "View Cart" to manage your items and proceed to checkout.</p>
            <div class="flex justify-end gap-3">
                <button onclick="toggleCartModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">Close</button>
                <button onclick="window.location.href='cart.php'" class="px-4 py-2 text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 rounded-md">View Cart</button>
            </div>
        </div>
    </div>

    <!-- Global Scripts -->
    <script>
        // --- DATA STORE (Sourced from PHP) ---
        // Make products available globally
        const globalProducts = <?php echo $products_json; ?>;

        // --- STATE MANAGEMENT ---
        let cart = JSON.parse(localStorage.getItem('hydrochem_cart')) || [];

        document.addEventListener('DOMContentLoaded', () => {
            updateCartUI();
        });

        // --- CART/QUOTE LOGIC ---
        function toggleCart(id) {
            // Check if user is logged in (PHP session check)
            <?php if (!is_logged_in()): ?>
                // User is not logged in, redirect to login page
                alert('Please login to add products to your cart');
                window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
                return;
            <?php endif; ?>
            
            id = parseInt(id);
            if (cart.includes(id)) {
                cart = cart.filter(itemId => itemId !== id);
            } else {
                cart.push(id);
            }
            localStorage.setItem('hydrochem_cart', JSON.stringify(cart));
            updateCartUI();
            
            // If on catalog page, update buttons
            if (typeof renderProducts === 'function') {
                renderProducts();
            }
        }

        function updateCartUI() {
            const countEl = document.getElementById('cart-count');
            const countElMobile = document.getElementById('cart-count-mobile');
            const quoteCountEl = document.getElementById('quote-count');
            
            if(countEl) countEl.innerText = cart.length;
            if(countElMobile) countElMobile.innerText = cart.length;
            if(quoteCountEl) quoteCountEl.innerText = cart.length;
            
            const list = document.getElementById('quote-list');
            if(!list) return;

            list.innerHTML = '';
            
            if(cart.length === 0) {
                list.innerHTML = '<div class="text-center italic p-4">No items selected</div>';
            } else {
                cart.forEach(id => {
                    const p = globalProducts.find(prod => prod.id === id);
                    if (p) {
                        const item = document.createElement('div');
                        item.className = "flex justify-between items-center border-b border-gray-100 last:border-0 py-2";
                        item.innerHTML = `<span>${p.name}</span> <span class="text-xs text-red-500 cursor-pointer hover:underline" onclick="toggleCart(${p.id})">Remove</span>`;
                        list.appendChild(item);
                    }
                });
            }
        }

        function toggleCartModal() {
            const modal = document.getElementById('quote-modal');
            modal.classList.toggle('hidden');
        }
    </script>
    
    <!-- Include custom script for mobile menu and other functionality -->
    <script src="/WaterTreatmentChemicals/script.js"></script>
</body>
</html>
