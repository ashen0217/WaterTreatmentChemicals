<?php
/**
 * Admin Checkouts Management Page
 * View and manage quote request checkouts
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

$page_title = 'Checkout Requests';

// Get status filter from URL
$status_filter = isset($_GET['status']) ? $_GET['status'] : null;

// Get all checkouts
$checkouts = get_all_checkouts($status_filter);
$checkout_stats = get_checkout_stats();
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Checkout Requests</h1>
    <p class="text-gray-600">Manage customer quote requests and delivery information</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Requests</p>
                <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo $checkout_stats['total']; ?></p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-yellow-600 mt-1"><?php echo $checkout_stats['pending']; ?></p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Approved</p>
                <p class="text-2xl font-bold text-green-600 mt-1"><?php echo $checkout_stats['approved']; ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Ignored</p>
                <p class="text-2xl font-bold text-red-600 mt-1"><?php echo $checkout_stats['ignored']; ?></p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <a href="checkouts.php" class="<?php echo !$status_filter ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                All Requests
            </a>
            <a href="checkouts.php?status=pending" class="<?php echo $status_filter === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                Pending
            </a>
            <a href="checkouts.php?status=approved" class="<?php echo $status_filter === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                Approved
            </a>
            <a href="checkouts.php?status=ignored" class="<?php echo $status_filter === 'ignored' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                Ignored
            </a>
        </nav>
    </div>
</div>

<!-- Checkouts Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($checkouts)): ?>
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                            No checkout requests found
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($checkouts as $checkout): ?>
                        <tr class="hover:bg-gray-50" id="checkout-row-<?php echo $checkout['id']; ?>">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #<?php echo str_pad($checkout['id'], 6, '0', STR_PAD_LEFT); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($checkout['full_name']); ?></div>
                                <?php if ($checkout['user_email']): ?>
                                    <div class="text-xs text-gray-500"><?php echo htmlspecialchars($checkout['user_email']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($checkout['phone']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($checkout['city']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo $checkout['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Card'; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo count($checkout['cart_items_decoded']); ?> items
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php 
                                        echo $checkout['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($checkout['status'] === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); 
                                    ?>">
                                    <?php echo ucfirst($checkout['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('M d, Y', strtotime($checkout['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button onclick="viewCheckout(<?php echo $checkout['id']; ?>)" class="text-blue-600 hover:text-blue-900">
                                    View
                                </button>
                                <?php if ($checkout['status'] === 'pending'): ?>
                                    <button onclick="updateStatus(<?php echo $checkout['id']; ?>, 'approved')" class="text-green-600 hover:text-green-900">
                                        Approve
                                    </button>
                                    <button onclick="updateStatus(<?php echo $checkout['id']; ?>, 'ignored')" class="text-red-600 hover:text-red-900">
                                        Ignore
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- View Details Modal -->
<div id="view-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Checkout Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="modal-content" class="p-6">
            <!-- Content loaded via JavaScript -->
        </div>
    </div>
</div>

<script>
function viewCheckout(id) {
    // Fetch checkout details via AJAX
    fetch('get_checkout_details.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayCheckoutDetails(data.checkout);
                document.getElementById('view-modal').classList.remove('hidden');
            } else {
                alert('Error loading checkout details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading checkout details');
        });
}

function displayCheckoutDetails(checkout) {
    const cartItems = checkout.cart_items_decoded.map(item => 
        `<div class="flex items-start gap-2 py-2 border-b border-gray-100 last:border-0">
            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
            <div>
                <div class="font-medium text-gray-900">${item.name}</div>
                <div class="text-sm text-gray-500">${item.formula} - ${item.category}</div>
            </div>
        </div>`
    ).join('');
    
    const statusBadge = checkout.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                       (checkout.status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800');
    
    const content = `
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Reference ID</p>
                    <p class="mt-1 text-sm text-gray-900">#${String(checkout.id).padStart(6, '0')}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p class="mt-1"><span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusBadge}">${checkout.status.charAt(0).toUpperCase() + checkout.status.slice(1)}</span></p>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <h4 class="font-semibold text-gray-900 mb-3">Customer Information</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Name</p>
                        <p class="mt-1 text-sm text-gray-900">${checkout.full_name}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Phone</p>
                        <p class="mt-1 text-sm text-gray-900">${checkout.phone}</p>
                    </div>
                    ${checkout.user_email ? `
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="mt-1 text-sm text-gray-900">${checkout.user_email}</p>
                    </div>` : ''}
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <h4 class="font-semibold text-gray-900 mb-3">Delivery Address</h4>
                <p class="text-sm text-gray-900">${checkout.address_line1}</p>
                ${checkout.address_line2 ? `<p class="text-sm text-gray-900">${checkout.address_line2}</p>` : ''}
                <p class="text-sm text-gray-900">${checkout.city}, ${checkout.postal_code}</p>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <h4 class="font-semibold text-gray-900 mb-3">Payment Method</h4>
                <p class="text-sm text-gray-900">${checkout.payment_method === 'cod' ? 'Cash on Delivery' : 'Credit/Debit Card'}</p>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <h4 class="font-semibold text-gray-900 mb-3">Requested Items (${checkout.cart_items_decoded.length})</h4>
                <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                    ${cartItems}
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <p class="text-sm text-gray-500">Submitted on ${new Date(checkout.created_at).toLocaleString()}</p>
            </div>
        </div>
    `;
    
    document.getElementById('modal-content').innerHTML = content;
}

function closeModal() {
    document.getElementById('view-modal').classList.add('hidden');
}

function updateStatus(id, status) {
    const statusText = status.charAt(0).toUpperCase() + status.slice(1);
    
    if (!confirm(`Are you sure you want to ${status} this checkout request?`)) {
        return;
    }
    
    // Send AJAX request to update status
    fetch('process_checkout_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating status');
    });
}

// Close modal when clicking outside
document.getElementById('view-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

<?php include 'includes/footer.php'; ?>
