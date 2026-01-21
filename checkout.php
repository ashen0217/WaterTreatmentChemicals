<?php
/**
 * Checkout Page
 * Allows users to enter delivery details and payment method for quote requests
 */
$page_title = 'Checkout';
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-8 flex-grow">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
        <p class="text-gray-600">Complete your quote request with delivery details</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Delivery Information</h2>
                
                <form id="checkout-form" method="POST" action="process_checkout.php" class="space-y-5">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                            placeholder="John Doe"
                        >
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                            placeholder="+94 771234567"
                        >
                    </div>

                    <!-- Address Line 1 -->
                    <div>
                        <label for="address_line1" class="block text-sm font-medium text-gray-700 mb-2">
                            Address Line 1 <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="address_line1" 
                            name="address_line1" 
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                            placeholder="123 Main Street"
                        >
                    </div>

                    <!-- Address Line 2 -->
                    <div>
                        <label for="address_line2" class="block text-sm font-medium text-gray-700 mb-2">
                            Address Line 2 <span class="text-gray-400 text-xs">(Optional)</span>
                        </label>
                        <input 
                            type="text" 
                            id="address_line2" 
                            name="address_line2"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                            placeholder="Apartment, suite, etc."
                        >
                    </div>

                    <!-- City and Postal Code -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                City <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="city" 
                                name="city" 
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                                placeholder="Colombo"
                            >
                        </div>
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Postal Code <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="postal_code" 
                                name="postal_code" 
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                                placeholder="10100"
                            >
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="pt-4 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Method</h3>
                        <div class="space-y-3">
                            <!-- Cash on Delivery -->
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-brand-500 transition">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="cod" 
                                    checked
                                    class="w-4 h-4 text-brand-600 focus:ring-brand-500"
                                >
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Cash on Delivery</div>
                                    <div class="text-sm text-gray-500">Pay when you receive the products</div>
                                </div>
                            </label>

                            <!-- Credit/Debit Card -->
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-brand-500 transition">
                                <input 
                                    type="radio" 
                                    name="payment_method" 
                                    value="card"
                                    class="w-4 h-4 text-brand-600 focus:ring-brand-500"
                                >
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-500">Secure online payment</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Hidden field for cart items -->
                    <input type="hidden" id="cart_items" name="cart_items" value="">

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button 
                            type="submit"
                            class="w-full bg-brand-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-brand-700 transition-colors shadow-md hover:shadow-lg"
                        >
                            Submit Quote Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-20">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
                
                <div id="cart-summary" class="space-y-3 mb-6">
                    <!-- Cart items will be populated here -->
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center text-lg font-bold text-gray-900">
                        <span>Total Items:</span>
                        <span id="total-items">0</span>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>Note:</strong> A sales representative will contact you within 24 hours with pricing and delivery details.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Load cart items from localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const cart = JSON.parse(localStorage.getItem('hydrochem_cart')) || [];
        const cartSummary = document.getElementById('cart-summary');
        const totalItems = document.getElementById('total-items');
        
        console.log('Cart from localStorage:', cart);
        
        // Check if cart is empty
        if (cart.length === 0) {
            cartSummary.innerHTML = '<div class="text-center text-gray-500 py-4">Your cart is empty</div>';
            totalItems.textContent = '0';
            
            // Disable the submit button
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            return;
        }
        
        // Check if globalProducts is available
        let cartItems = [];
        if (typeof globalProducts !== 'undefined') {
            // Get cart items with product details from globalProducts
            // Use loose equality (==) to handle type mismatch between cart IDs and product IDs
            cartItems = cart.map(id => {
                const product = globalProducts.find(p => p.id == id);
                return product;
            }).filter(p => p !== undefined);
        } else {
            // Fallback: use cart IDs directly and fetch product names if available
            cartItems = cart.map(id => ({
                id: id,
                name: 'Product #' + id,
                formula: '',
                category: '',
                form: '',
                purity: '',
                desc: '',
                price_index: 0,
                effectiveness: 0
            }));
        }
        
        console.log('Cart items to display:', cartItems);
        
        // Display cart items
        cartSummary.innerHTML = '';
        cartItems.forEach(product => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0';
            itemDiv.innerHTML = `
                <div class="flex-shrink-0 w-2 h-2 bg-brand-500 rounded-full mt-2"></div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-gray-900 text-sm">${product.name}</div>
                    ${product.formula ? `<div class="text-xs text-gray-500">${product.formula}</div>` : ''}
                </div>
            `;
            cartSummary.appendChild(itemDiv);
        });
        
        totalItems.textContent = cartItems.length;
        
        // Set cart items in hidden field for form submission
        const cartItemsJson = JSON.stringify(cartItems);
        document.getElementById('cart_items').value = cartItemsJson;
        console.log('Cart items set in hidden field:', cartItemsJson);
    });
    
    // Form submission handler
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const cartItemsValue = document.getElementById('cart_items').value;
        
        console.log('Form submitting with cart items:', cartItemsValue);
        
        if (!cartItemsValue || cartItemsValue === '[]' || cartItemsValue === '') {
            e.preventDefault();
            alert('Your cart is empty. Please add items before checkout.');
            window.location.href = 'chemicalProducts.php';
            return false;
        }
        
        // Allow form to submit
        console.log('Form submission allowed');
        return true;
    });
</script>

<?php require_once 'includes/footer.php'; ?>
