<?php
//Update page title and site references to reflect new brand name
$page_title = 'Sign Up - Water Treatment Chemicals';
include 'includes/header.php';

// Get error message from session
$error = $_SESSION['signup_error'] ?? '';
unset($_SESSION['signup_error']);
?>

<!-- Main Content -->
<main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative min-h-[calc(100vh-136px)]">
    <!-- Decorative Background Element -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent-500 rounded-full mix-blend-multiply filter blur-3xl opacity-5"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-brand-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-3xl">🚀</span>
            </div>
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Create Account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Join HydroChem Pro for exclusive access
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
        
        <form class="mt-8 space-y-4" action="process_signup.php" method="POST">
            
            <div>
                <label for="full-name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input id="full-name" name="full-name" type="text" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 focus:z-10 sm:text-sm" placeholder="John Doe">
            </div>

            <div>
                <label for="email-address" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 focus:z-10 sm:text-sm" placeholder="name@company.com">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input id="phone" name="phone" type="text" autocomplete="phone" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 focus:z-10 sm:text-sm" placeholder="+947XXXXXXXX">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 focus:z-10 sm:text-sm" placeholder="••••••••">
                </div>
                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="confirm-password" name="confirm-password" type="password" autocomplete="new-password" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 focus:z-10 sm:text-sm" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    I agree to the <a href="#" class="text-brand-600 hover:text-brand-500">Terms of Service</a> and <a href="#" class="text-brand-600 hover:text-brand-500">Privacy Policy</a>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-brand-500 group-hover:text-brand-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                        </svg>
                    </span>
                    Create Account
                </button>
            </div>
        </form>
        
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="login.php" class="font-medium text-brand-600 hover:text-brand-500">
                    Sign in instead
                </a>
            </p>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
