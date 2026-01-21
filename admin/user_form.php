<?php
/**
 * User Add/Edit Form
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

$page_title = 'User Form';
$error = '';
$success = '';

// Check if editing existing user
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = null;

if ($user_id > 0) {
    $user = get_user_by_id($user_id);
    if (!$user) {
        header("Location: users.php");
        exit();
    }
    $page_title = 'Edit User';
} else {
    $page_title = 'Add New User';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => sanitize_input($_POST['full_name'] ?? ''),
        'email' => sanitize_input($_POST['email'] ?? ''),
        'phone' => sanitize_input($_POST['phone'] ?? ''),
        'password' => $_POST['password'] ?? ''
    ];
    
    // Validation
    if (empty($data['full_name']) || empty($data['email']) || empty($data['phone'])) {
        $error = 'Please fill in all required fields';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } elseif ($user_id == 0 && empty($data['password'])) {
        $error = 'Password is required for new users';
    } else {
        // Create or update user
        if ($user_id > 0) {
            $result = update_user($user_id, $data);
        } else {
            $result = create_user($data);
        }
        
        if ($result['success']) {
            header("Location: users.php");
            exit();
        } else {
            $error = $result['message'];
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Form -->
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900"><?php echo $user_id > 0 ? 'Edit User' : 'Add New User'; ?></h3>
            <p class="text-sm text-gray-500 mt-1">
                <?php echo $user_id > 0 ? 'Update user information' : 'Create a new user account'; ?>
            </p>
        </div>
        
        <?php if ($error): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-800 text-sm"><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="space-y-6">
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="full_name" 
                    name="full_name" 
                    required
                    value="<?php echo htmlspecialchars($user['full_name'] ?? $_POST['full_name'] ?? ''); ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    placeholder="John Doe"
                >
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    value="<?php echo htmlspecialchars($user['email'] ?? $_POST['email'] ?? ''); ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    placeholder="john@example.com"
                >
            </div>
            
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="phone" 
                    name="phone" 
                    required
                    value="<?php echo htmlspecialchars($user['phone'] ?? $_POST['phone'] ?? ''); ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    placeholder="+947XXXXXXXX"
                >
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <?php echo $user_id > 0 ? '(leave blank to keep current)' : '<span class="text-red-500">*</span>'; ?>
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    <?php echo $user_id == 0 ? 'required' : ''; ?>
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    placeholder="••••••••"
                >
                <?php if ($user_id > 0): ?>
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep the current password</p>
                <?php endif; ?>
            </div>
            
            <div class="flex gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition"
                >
                    <?php echo $user_id > 0 ? 'Update User' : 'Create User'; ?>
                </button>
                <a 
                    href="users.php" 
                    class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition text-center"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
