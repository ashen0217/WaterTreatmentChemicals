<?php
$page_title = 'Reset Link Generated';
include 'includes/header.php';

// Get token from session
$token = $_SESSION['reset_token'] ?? '';
$email = $_SESSION['reset_email'] ?? '';
$name = $_SESSION['reset_name'] ?? '';

// Clear the session variables
unset($_SESSION['reset_token'], $_SESSION['reset_email'], $_SESSION['reset_name']);

// If no token, redirect back
if (empty($token)) {
    header("Location: forgot_password.php");
    exit();
}

// Generate reset link
$reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;
?>

<!-- Main Content -->
<main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative min-h-[calc(100vh-136px)]">
    <!-- Decorative Background Element -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
            <div class="absolute top-1/2 left-0 w-64 h-64 bg-accent-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    </div>

    <div class="max-w-2xl w-full space-y-8 relative z-10 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-3xl">✅</span>
            </div>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Reset Link Generated!</h2>
            <p class="mt-2 text-sm text-gray-600">
                Hello <?php echo htmlspecialchars($name); ?>, your password reset link has been generated.
            </p>
        </div>
        
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
            <h3 class="text-blue-800 font-semibold mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Development Mode
            </h3>
            <p class="text-blue-700 text-sm mb-3">
                In a production environment, this link would be sent to your email address <strong><?php echo htmlspecialchars($email); ?></strong>. 
                For development purposes, the link is displayed below.
            </p>
            <p class="text-blue-700 text-sm">
                ⏰ This link will expire in <strong>15 minutes</strong>.
            </p>
        </div>
        
        <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg">
            <label class="block text-sm font-medium text-gray-700 mb-2">Your Password Reset Link:</label>
            <div class="flex gap-2">
                <input type="text" readonly value="<?php echo htmlspecialchars($reset_link); ?>" id="reset-link" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg bg-white text-sm font-mono">
                <button onclick="copyLink()" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition-colors text-sm font-medium">
                    Copy
                </button>
            </div>
        </div>
        
        <div class="text-center">
            <a href="<?php echo htmlspecialchars($reset_link); ?>" class="inline-block w-full py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors shadow-lg">
                Reset Password Now
            </a>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Didn't request a password reset? 
                <a href="login.php" class="font-medium text-brand-600 hover:text-brand-500">
                    Back to login
                </a>
            </p>
        </div>
    </div>
</main>

<script>
function copyLink() {
    const linkInput = document.getElementById('reset-link');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(linkInput.value).then(function() {
        // Show success feedback
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.add('bg-green-600');
        button.classList.remove('bg-brand-600');
        
        setTimeout(function() {
            button.textContent = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-brand-600');
        }, 2000);
    });
}
</script>

<?php include 'includes/footer.php'; ?>
