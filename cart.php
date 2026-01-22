<?php
/**
 * Shopping Cart Page
 * Allows users to view and manage items in their cart before checkout
 */
$page_title = 'Shopping Cart';
require_once 'includes/auth_middleware.php';
require_login();
require_once 'includes/header.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="mb-8 animate-fade-in-up">
        <h1 class="section-title mb-2">Shopping Cart</h1>
        <p class="text-gray-600">Review and manage your items before checkout</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="card-3d bg-white animate-slide-in-left">
                <!-- Cart Header -->
                <div class="p-6 border-b border-gray-200 bg-gradient-to-br from-gray-50 to-brand-50">
                    <h2 class="text-xl font-bold text-gray-900">
                        Cart Items (<span id="cart-item-count">0</span>)
                    </h2>
                </div>

                <!-- Cart Items List -->
                <div id="cart-items-container" class="divide-y divide-gray-200">
                    <!-- Items will be populated here by JavaScript -->
                    <div class="p-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="text-lg font-medium">Your cart is empty</p>
                        <p class="text-sm mt-2">Add some chemicals to get started</p>
                    </div>
                </div>

                <!-- Empty Cart State (hidden by default, shown when cart is empty) -->
                <div id="empty-cart-message" class="hidden p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <p class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</p>
                    <p class="text-sm text-gray-500 mb-6">Add some chemicals to get started</p>
                    <a href="chemicalProducts.php" class="btn-primary inline-flex items-center">
                        Browse Products
                    </a>
                </div>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="lg:col-span-1">
            <div class="card-3d bg-white p-6 sticky top-20 animate-slide-in-right">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center text-base">
                        <span class="text-gray-600">Total Items:</span>
                        <span id="summary-item-count" class="font-semibold text-gray-900">0</span>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6 space-y-3">
                    <button 
                        id="checkout-btn"
                        onclick="proceedToCheckout()"
                        disabled
                        class="btn-primary w-full disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Proceed to Checkout
                    </button>
                    
                    <a 
                        href="chemicalProducts.php"
                        class="btn-secondary w-full block text-center"
                    >
                        Continue Shopping
                    </a>
                </div>

                <div class="mt-6 p-4 bg-brand-50 rounded-lg border border-brand-100">
                    <p class="text-sm text-brand-700">
                        <strong>Note:</strong> A sales representative will contact you within 24 hours with pricing and delivery details.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Load and display cart items
    document.addEventListener('DOMContentLoaded', function() {
        loadCartItems();
    });

    function loadCartItems() {
        const cart = JSON.parse(localStorage.getItem('hydrochem_cart')) || [];
        const container = document.getElementById('cart-items-container');
        const emptyMessage = document.getElementById('empty-cart-message');
        const checkoutBtn = document.getElementById('checkout-btn');
        const itemCount = document.getElementById('cart-item-count');
        const summaryCount = document.getElementById('summary-item-count');

        // Update counts
        itemCount.textContent = cart.length;
        summaryCount.textContent = cart.length;

        // Check if cart is empty
        if (cart.length === 0) {
            container.innerHTML = '';
            emptyMessage.classList.remove('hidden');
            checkoutBtn.disabled = true;
            return;
        }

        // Hide empty message and enable checkout
        emptyMessage.classList.add('hidden');
        checkoutBtn.disabled = false;

        // Clear container
        container.innerHTML = '';

        // Check if globalProducts is available
        if (typeof globalProducts === 'undefined') {
            container.innerHTML = '<div class="p-6 text-center text-red-500">Error loading products. Please refresh the page.</div>';
            return;
        }

        // Display each cart item
        cart.forEach(id => {
            const product = globalProducts.find(p => p.id == id);
            if (!product) return;

            // Determine badge color - using new greenish-blue theme
            let badgeColor = "bg-gray-100 text-gray-800";
            if(product.category === "Coagulation") badgeColor = "bg-brand-100 text-brand-700";
            if(product.category === "Disinfection") badgeColor = "bg-green-100 text-green-700";
            if(product.category === "pH Control") badgeColor = "bg-purple-100 text-purple-700";

            const itemDiv = document.createElement('div');
            itemDiv.className = 'p-6 hover:bg-gray-50 transition-all duration-300 hover:shadow-3d-sm';
            itemDiv.innerHTML = `
                <div class="flex items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">${product.name}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeColor} mt-1">
                                    ${product.category}
                                </span>
                            </div>
                            <button 
                                onclick="removeFromCart(${product.id})"
                                class="text-red-500 hover:text-red-700 transition-colors p-2 hover:bg-red-50 rounded-lg transform hover:scale-110 duration-200"
                                title="Remove from cart"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-4 text-sm">
                            <div>
                                <span class="text-gray-500">Formula:</span>
                                <span class="font-medium text-gray-900 ml-2">${product.formula}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Form:</span>
                                <span class="font-medium text-gray-900 ml-2">${product.form}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-500">Concentration:</span>
                                <span class="font-medium text-gray-900 ml-2">${product.purity}</span>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mt-3 line-clamp-2">${product.desc}</p>
                    </div>
                </div>
            `;
            container.appendChild(itemDiv);
        });
    }

    function removeFromCart(productId) {
        // Use the global toggleCart function from footer.php
        if (typeof toggleCart === 'function') {
            toggleCart(productId);
            // Reload cart items
            loadCartItems();
        }
    }

    function proceedToCheckout() {
        const cart = JSON.parse(localStorage.getItem('hydrochem_cart')) || [];
        if (cart.length === 0) {
            alert('Your cart is empty. Please add items before checkout.');
            return;
        }
        window.location.href = 'checkout.php';
    }
</script>

<?php require_once 'includes/footer.php'; ?>
