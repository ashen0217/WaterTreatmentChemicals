<?php
$page_title = 'Reset Password';
include 'includes/header.php';

// Get token from URL
$token = $_GET['token'] ?? '';

// Get error/success messages from session
$error = $_SESSION['reset_error'] ?? '';
unset($_SESSION['reset_error']);

// Validate token
$valid_token = false;
$email = '';

if (empty($token)) {
    $error = 'Invalid or missing reset token';
} else {
    require_once 'config.php';
    $conn = getDatabaseConnection();
    
    if ($conn) {
        // Check if token exists and hasn't expired
        $stmt = $conn->prepare("SELECT email, full_name, reset_token_expires FROM users WHERE reset_token = ? AND is_active = 1");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $email = $user['email'];
            
            // Check if token has expired
            $expires = strtotime($user['reset_token_expires']);
            $now = time();
            
            if ($now > $expires) {
                $error = 'This reset link has expired. Please request a new one.';
            } else {
                $valid_token = true;
            }
        } else {
            $error = 'Invalid reset token';
        }
        
        $stmt->close();
        $conn->close();
    } else {
        $error = 'Database connection failed';
    }
}
?>

<!-- Main Content -->
<main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative min-h-[calc(100vh-136px)]">
    <!-- Decorative Background Element -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
            <div class="absolute top-1/2 left-0 w-64 h-64 bg-accent-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-brand-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-3xl">🔐</span>
            </div>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Reset Your Password</h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your new password below
            </p>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                </div>
            </div>
            
            <div class="text-center">
                <a href="forgot_password.php" class="inline-block w-full py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors shadow-lg">
                    Request New Reset Link
                </a>
            </div>
        <?php elseif ($valid_token): ?>
            <form class="mt-8 space-y-6" action="process_reset_password.php" method="POST" id="reset-form">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input id="email" name="email" type="email" readonly value="<?php echo htmlspecialchars($email); ?>" class="appearance-none relative block w-full px-3 py-3 border border-gray-300 bg-gray-50 text-gray-600 rounded-lg sm:text-sm cursor-not-allowed">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input id="password" name="password" type="password" required minlength="6" class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 focus:z-10 sm:text-sm" placeholder="Enter new password (min. 6 characters)">
                    <p class="mt-1 text-xs text-gray-500">Password must be at least 6 characters long</p>
                </div>
                
                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input id="confirm-password" name="confirm_password" type="password" required minlength="6" class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 focus:z-10 sm:text-sm" placeholder="Confirm new password">
                </div>
                
                <div id="password-match-error" class="hidden bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-700 text-sm">Passwords do not match</p>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors shadow-lg">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-brand-500 group-hover:text-brand-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Reset Password
                    </button>
                </div>
            </form>
        <?php endif; ?>
        
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Remember your password? 
                <a href="login.php" class="font-medium text-brand-600 hover:text-brand-500">
                    Back to login
                </a>
            </p>
        </div>
    </div>
</main>

<script>
// Client-side password validation
document.getElementById('reset-form')?.addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const errorDiv = document.getElementById('password-match-error');
    
    if (password !== confirmPassword) {
        e.preventDefault();
        errorDiv.classList.remove('hidden');
        document.getElementById('confirm-password').focus();
    } else {
        errorDiv.classList.add('hidden');
    }
});

// Hide error when user starts typing
document.getElementById('confirm-password')?.addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    const errorDiv = document.getElementById('password-match-error');
    
    if (password === confirmPassword) {
        errorDiv.classList.add('hidden');
    }
});
</script>

<?php include 'includes/footer.php'; ?>
