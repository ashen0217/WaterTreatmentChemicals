<?php
/**
 * Checkout Success Page
 * Displays confirmation after successful checkout
 */
session_start();
$page_title = 'Order Confirmed';
require_once 'config.php';
require_once 'includes/header.php';

// Get checkout ID from URL
$checkout_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$reference_id = '#' . str_pad($checkout_id, 6, '0', STR_PAD_LEFT);

// Check for success message
$success_message = isset($_SESSION['checkout_success']) ? $_SESSION['checkout_success'] : '';
unset($_SESSION['checkout_success']);
?>

<div class="max-w-2xl mx-auto px-4 py-12 flex-grow">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 text-center">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <!-- Success Message -->
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Quote Request Submitted!</h1>
        
        <?php if ($success_message): ?>
            <p class="text-lg text-gray-600 mb-6"><?php echo htmlspecialchars($success_message); ?></p>
        <?php else: ?>
            <p class="text-lg text-gray-600 mb-6">Your quote request has been received successfully.</p>
        <?php endif; ?>
        
        <!-- Reference ID -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
            <p class="text-sm text-blue-800 mb-1">Your Reference ID</p>
            <p class="text-2xl font-bold text-blue-900"><?php echo htmlspecialchars($reference_id); ?></p>
        </div>
        
        <!-- Information -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
            <h2 class="font-semibold text-gray-900 mb-3">What happens next?</h2>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-brand-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Our sales team will review your quote request</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-brand-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>You will receive a call within 24 hours with pricing details</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-brand-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>We'll arrange delivery based on your preferred payment method</span>
                </li>
            </ul>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="chemicalProducts.php" class="px-6 py-3 bg-brand-600 text-white rounded-lg font-semibold hover:bg-brand-700 transition-colors">
                Continue Shopping
            </a>
            <a href="index.php" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                Back to Home
            </a>
        </div>
    </div>
</div>

<script>
    // Clear cart from localStorage after successful checkout
    localStorage.removeItem('hydrochem_cart');
    
    // Update cart UI
    if (typeof updateCartUI === 'function') {
        updateCartUI();
    }
</script>

<?php require_once 'includes/footer.php'; ?>
