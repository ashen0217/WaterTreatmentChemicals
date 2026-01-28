<?php
/**
 * Admin Self-Delete Page
 * Allows administrators to delete their own account
 */

define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';
require_admin();

$page_title = 'Delete My Account';
$current_admin = get_admin_user();

// Count total admins
$total_admins = count_total_admins();

// Handle POST request for deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    // Validate password
    if (empty($_POST['password'])) {
        $error_message = 'Password is required to confirm deletion';
    } else {
        // Verify password
        $conn = getDatabaseConnection();
        if ($conn) {
            $stmt = $conn->prepare("SELECT password_hash FROM admin_users WHERE id = ?");
            $stmt->bind_param("i", $current_admin['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $admin_data = $result->fetch_assoc();
            $stmt->close();
            
            if ($admin_data && password_verify($_POST['password'], $admin_data['password_hash'])) {
                // Check if this is the last admin
                if ($total_admins <= 1) {
                    $error_message = 'Cannot delete account. You are the only administrator. Please create another admin account first.';
                } else {
                    // Delete the account
                    $result = delete_admin($current_admin['id']);
                    
                    if ($result['success']) {
                        // Logout and redirect
                        session_destroy();
                        header("Location: ../index.php?message=account_deleted");
                        exit();
                    } else {
                        $error_message = $result['message'];
                    }
                }
            } else {
                $error_message = 'Incorrect password';
            }
            
            $conn->close();
        } else {
            $error_message = 'Database connection failed';
        }
    }
}

include 'includes/header.php';
?>

<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="index.php" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Warning Card -->
    <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg mb-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-red-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-bold text-red-900 mb-2">Danger Zone</h3>
                <p class="text-red-700 text-sm">
                    This action will permanently delete your administrator account and cannot be undone. 
                    <?php if ($total_admins <= 1): ?>
                        <strong>You are currently the only administrator. You must create another admin account before deleting yours.</strong>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Delete Account Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Delete Your Account</h3>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-700"><?php echo htmlspecialchars($error_message); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Account Information -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Your Account Information</h4>
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Name:</span>
                    <span class="font-medium"><?php echo htmlspecialchars($current_admin['full_name']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Email:</span>
                    <span class="font-medium"><?php echo htmlspecialchars($current_admin['email']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Created:</span>
                    <span class="font-medium"><?php echo date('M j, Y', strtotime($current_admin['created_at'])); ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Total Admins:</span>
                    <span class="font-medium"><?php echo $total_admins; ?></span>
                </div>
            </div>
        </div>

        <!-- Consequences List -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">What will happen when you delete your account:</h4>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Your administrator account will be permanently deleted
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    You will immediately lose access to the admin panel
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    This action cannot be reversed
                </li>
            </ul>
        </div>

        <?php if ($total_admins > 1): ?>
            <!-- Confirmation Form -->
            <form method="POST" action="" class="space-y-6" id="deleteForm">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Enter your password to confirm deletion <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <div class="flex items-start">
                    <input type="checkbox" 
                           id="confirm_checkbox" 
                           required
                           class="mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                    <label for="confirm_checkbox" class="ml-2 text-sm text-gray-700">
                        I understand that this action is permanent and cannot be undone
                    </label>
                </div>

                <div class="flex gap-4 pt-4 border-t">
                    <button type="submit" 
                            name="confirm_delete"
                            class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-sm">
                        Delete My Account Permanently
                    </button>
                    <a href="index.php" 
                       class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium text-center">
                        Cancel
                    </a>
                </div>
            </form>
        <?php else: ?>
            <!-- Cannot Delete Message -->
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="text-yellow-700 text-sm">
                            <strong>Account deletion is not available.</strong> You are the only administrator in the system. 
                            Please create another admin account before attempting to delete yours.
                        </p>
                        <a href="admin_form.php" class="inline-block mt-3 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors text-sm font-medium">
                            Create New Admin
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Additional confirmation before submit
document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
    if (!confirm('Are you absolutely sure you want to delete your account? This cannot be undone!')) {
        e.preventDefault();
        return false;
    }
});
</script>

<?php include 'includes/footer.php'; ?>
