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

<script>
// Form validation
const form = document.querySelector('form');
const fullNameInput = document.getElementById('full_name');
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');
const passwordInput = document.getElementById('password');

// Real-time validation for full name
fullNameInput.addEventListener('blur', function() {
    const value = this.value.trim();
    if (value.length < 2) {
        showFieldError(this, 'Name must be at least 2 characters long');
    } else if (!/^[a-zA-Z\s.'-]+$/.test(value)) {
        showFieldError(this, 'Name can only contain letters, spaces, and common punctuation');
    } else {
        clearFieldError(this);
    }
});

// Real-time validation for email
emailInput.addEventListener('blur', function() {
    const value = this.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(value)) {
        showFieldError(this, 'Please enter a valid email address');
    } else {
        clearFieldError(this);
    }
});

// Real-time validation for phone
phoneInput.addEventListener('blur', function() {
    const value = this.value.trim();
    const phoneRegex = /^[+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/;
    if (value.length < 8) {
        showFieldError(this, 'Phone number must be at least 8 digits');
    } else if (!phoneRegex.test(value)) {
        showFieldError(this, 'Please enter a valid phone number');
    } else {
        clearFieldError(this);
    }
});

// Real-time validation for password
passwordInput.addEventListener('input', function() {
    const value = this.value;
    if (value.length > 0 && value.length < 6) {
        showFieldError(this, 'Password must be at least 6 characters');
    } else {
        clearFieldError(this);
    }
});

// Form submission validation
form.addEventListener('submit', function(e) {
    let isValid = true;
    
    // Validate full name
    const fullName = fullNameInput.value.trim();
    if (fullName.length < 2) {
        showFieldError(fullNameInput, 'Name must be at least 2 characters long');
        isValid = false;
    } else if (!/^[a-zA-Z\s.'-]+$/.test(fullName)) {
        showFieldError(fullNameInput, 'Name can only contain letters');
        isValid = false;
    }
    
    // Validate email
    const email = emailInput.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showFieldError(emailInput, 'Please enter a valid email address');
        isValid = false;
    }
    
    // Validate phone
    const phone = phoneInput.value.trim();
    if (phone.length < 8) {
        showFieldError(phoneInput, 'Phone number must be at least 8 digits');
        isValid = false;
    }
    
    // Validate password (only if provided for new users or editing)
    const password = passwordInput.value;
    const isNewUser = <?php echo $user_id == 0 ? 'true' : 'false'; ?>;
    if (isNewUser && password.length === 0) {
        showFieldError(passwordInput, 'Password is required for new users');
        isValid = false;
    } else if (password.length > 0 && password.length < 6) {
        showFieldError(passwordInput, 'Password must be at least 6 characters');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
        return false;
    }
});

function showFieldError(field, message) {
    // Remove any existing error
    clearFieldError(field);
    
    // Add error styling
    field.classList.add('border-red-500');
    field.classList.remove('border-gray-300');
    
    // Create and add error message
    const errorDiv = document.createElement('p');
    errorDiv.className = 'text-red-500 text-xs mt-1 field-error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('border-red-500');
    field.classList.add('border-gray-300');
    
    // Remove error message if exists
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}
</script>

<?php include 'includes/footer.php'; ?>
