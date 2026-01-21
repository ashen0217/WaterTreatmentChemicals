<?php
$page_title = 'Forgot Password';
include 'includes/header.php';

// Get error/success messages from session
$error = $_SESSION['forgot_error'] ?? '';
$success = $_SESSION['forgot_success'] ?? '';
unset($_SESSION['forgot_error'], $_SESSION['forgot_success']);
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
                <span class="text-3xl">🔑</span>
            </div>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Forgot Password?</h2>
            <p class="mt-2 text-sm text-gray-600">
                No worries! Enter your email address and we'll help you reset your password.
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
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
                </div>
            </div>
        <?php endif; ?>
        
        <form class="mt-8 space-y-6" action="process_forgot_password.php" method="POST">
            <div>
                <label for="email-address" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 focus:z-10 sm:text-sm" placeholder="name@company.com">
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-brand-500 group-hover:text-brand-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </span>
                    Send Reset Link
                </button>
            </div>
        </form>
        
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

<?php include 'includes/footer.php'; ?>
