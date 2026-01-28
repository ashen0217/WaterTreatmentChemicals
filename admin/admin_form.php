<?php
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';
require_admin();

$page_title = 'Admin Form';
$admin = null;
$is_edit = false;

// Check if editing
if (isset($_GET['id'])) {
    $is_edit = true;
    $admin_id = intval($_GET['id']);
    $admin = get_admin_by_id($admin_id);
    
    if (!$admin) {
        $_SESSION['error_message'] = 'Admin not found';
        header("Location: admins.php");
        exit();
    }
    
    $page_title = 'Edit Admin';
}

include 'includes/header.php';
?>

<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="admins.php" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Admins List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">
            <?php echo $is_edit ? 'Edit Admin Information' : 'Add New Admin'; ?>
        </h3>

        <!-- Error/Success Messages -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-700"><?php echo htmlspecialchars($_SESSION['error_message']); ?></p>
                </div>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form method="POST" action="process_admin_action.php" class="space-y-6">
            <input type="hidden" name="action" value="<?php echo $is_edit ? 'update' : 'create'; ?>">
            <?php if ($is_edit): ?>
                <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
            <?php endif; ?>

            <!-- Full Name -->
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="full_name" 
                       name="full_name" 
                       value="<?php echo $is_edit ? htmlspecialchars($admin['full_name']) : ''; ?>"
                       required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?php echo $is_edit ? htmlspecialchars($admin['email']) : ''; ?>"
                       required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <?php echo $is_edit ? '(leave blank to keep current)' : '<span class="text-red-500">*</span>'; ?>
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       minlength="6"
                       <?php echo !$is_edit ? 'required' : ''; ?>
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-500">Minimum 6 characters</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm Password <?php echo $is_edit ? '(leave blank to keep current)' : '<span class="text-red-500">*</span>'; ?>
                </label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       minlength="6"
                       <?php echo !$is_edit ? 'required' : ''; ?>
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-sm">
                    <?php echo $is_edit ? 'Update Admin' : 'Create Admin'; ?>
                </button>
                <a href="admins.php" 
                   class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Additional Information Card (for edit mode) -->
    <?php if ($is_edit): ?>
        <div class="mt-6 bg-gray-50 rounded-lg border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Account Information</h4>
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Created:</span>
                    <span class="font-medium"><?php echo date('M j, Y g:i A', strtotime($admin['created_at'])); ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Last Login:</span>
                    <span class="font-medium"><?php echo $admin['last_login'] ? date('M j, Y g:i A', strtotime($admin['last_login'])) : 'Never'; ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Password validation
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Only validate if password is provided
    if (password || confirmPassword) {
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            alert('Password must be at least 6 characters long!');
            return false;
        }
    }
});
</script>

<?php include 'includes/footer.php'; ?>
