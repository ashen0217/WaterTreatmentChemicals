<?php
require_once '../includes/auth_middleware.php';
require_login();


$user = get_logged_in_user();
if (!$user) {
    header("Location: ../login.php");
    exit();
}

$page_title = 'My Dashboard';

// Get success/error messages
$success = $_SESSION['profile_success'] ?? '';
$error = $_SESSION['profile_error'] ?? '';
unset($_SESSION['profile_success'], $_SESSION['profile_error']);

// Active page detection function
$current_page = basename($_SERVER['PHP_SELF']);

function isActive($page) {
    global $current_page;
    // For dashboard, we need to check relative paths
    $page_name = basename($page);
    return $current_page === $page_name ? 'border-brand-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-brand-500 hover:text-gray-700';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | HydroChem Pro</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS with 3D Effects and Animations -->
    <link rel="stylesheet" href="../style.css">
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#e6f9f4',
                            100: '#ccf3e9',
                            200: '#99e7d3',
                            300: '#66dbbd',
                            400: '#33cfa7',
                            500: '#24C7A0',
                            600: '#1da082',
                            700: '#167963',
                            800: '#0f5245',
                            900: '#082b26',
                        },
                        accent: {
                            400: '#2dd5b8',
                            500: '#24C7A0',
                            600: '#1da082',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="../index.php" class="flex-shrink-0 flex items-center gap-2">
                        <img src="../assets/images/logo.jpeg" alt="HydroChem Pro" class="h-12 sm:h-14 w-auto object-contain">
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="../index.php" class="<?php echo isActive('index.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Home page</a>
                    <a href="../processGuide.php" class="<?php echo isActive('processGuide.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Process Guide</a>
                    <a href="../chemicalProducts.php" class="<?php echo isActive('chemicalProducts.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Chemical Catalog</a>
                    <a href="../dosageCalculate.php" class="<?php echo isActive('dosageCalculate.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Dosage Calculator</a>
                    <a href="../performanceData.php" class="<?php echo isActive('performanceData.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Performance Data</a>
                </div>
                <!-- Desktop Right Side -->
                <div class="hidden sm:flex items-center gap-4">
                    <button class="bg-brand-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm" onclick="window.location.href='../cart.php'">
                        View Cart (<span id="cart-count">0</span>)
                    </button>
                    <!-- Logged In User Menu -->
                    <a href="dashboard.php" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center">
                            <span class="text-brand-600 font-semibold text-sm"><?php echo strtoupper(substr($user['full_name'], 0, 1)); ?></span>
                        </div>
                        <span class="text-sm font-medium text-gray-700 hidden md:block"><?php echo htmlspecialchars($user['full_name']); ?></span>
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="flex items-center sm:hidden">
                    <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-brand-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500 transition-colors">
                        <span class="sr-only">Open main menu</span>
                        <!-- Hamburger Icon -->
                        <svg id="menu-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Close Icon -->
                        <svg id="close-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden sm:hidden border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="../index.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Home page</a>
                <a href="../processGuide.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'processGuide.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Process Guide</a>
                <a href="../chemicalProducts.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'chemicalProducts.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Chemical Catalog</a>
                <a href="../dosageCalculate.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'dosageCalculate.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Dosage Calculator</a>
                <a href="../performanceData.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'performanceData.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Performance Data</a>
            </div>
            
            <!-- Mobile Cart and User -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-4 space-y-3">
                    <button class="w-full bg-brand-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm" onclick="window.location.href='../cart.php'">
                        View Cart (<span id="cart-count-mobile">0</span>)
                    </button>
                    
                    <!-- Logged In User -->
                    <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center">
                            <span class="text-brand-600 font-semibold"><?php echo strtoupper(substr($user['full_name'], 0, 1)); ?></span>
                        </div>
                        <span class="text-base font-medium text-gray-700"><?php echo htmlspecialchars($user['full_name']); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-3xl font-extrabold text-gray-900">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>
                <p class="mt-2 text-gray-600">Manage your account and view your quote requests</p>
            </div>

            <!-- Success/Error Messages -->
            <?php if ($success): ?>
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-700 text-sm"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-700 text-sm"><?php echo htmlspecialchars($error); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="lg:col-span-2">
                    <div class="card-3d bg-white overflow-hidden animate-slide-in-left">
                        <div class="bg-gradient-to-r from-brand-500 to-brand-600 px-6 py-8">
                            <div class="flex items-center">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-3d animate-pulse-3d">
                                    <span class="text-4xl text-brand-500 font-bold"><?php echo strtoupper(substr($user['full_name'], 0, 1)); ?></span>
                                </div>
                                <div class="ml-6">
                                    <h2 class="text-2xl font-bold text-white drop-shadow-md"><?php echo htmlspecialchars($user['full_name']); ?></h2>
                                    <p class="text-brand-100"><?php echo htmlspecialchars($user['email']); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Profile Information</h3>
                            
                            <form id="profileForm" action="update_profile.php" method="POST" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                                    </div>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                                </div>

                                <div class="border-t border-gray-200 pt-4 mt-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Change Password (Optional)</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                            <input type="password" id="new_password" name="new_password" placeholder="Leave blank to keep current" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                                        </div>
                                        <div>
                                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="btn-primary">
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6" style="position: relative; z-index: 20;">
                    <!-- Account Stats -->
                    <div class="card-3d bg-white p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Account Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Member Since</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Account Status</span>
                                <span class="text-sm font-medium text-green-600">Active</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm text-gray-600">User ID</span>
                                <span class="text-sm font-medium text-gray-900">#<?php echo str_pad($user['id'], 6, '0', STR_PAD_LEFT); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="../chemicalProducts.php" class="block w-full px-4 py-3 bg-brand-50 text-brand-700 rounded-lg hover:bg-brand-100 transition-colors text-center font-medium">
                                Browse Products
                            </a>
                            <a href="../dosageCalculate.php" class="block w-full px-4 py-3 bg-brand-50 text-brand-700 rounded-lg hover:bg-brand-100 transition-colors text-center font-medium">
                                Calculate Dosage
                            </a>
                            <a href="../logout.php" class="block w-full px-4 py-3 bg-brand-50 text-brand-700 rounded-lg hover:bg-brand-100 transition-colors text-center font-medium">
                                Logout
                            </a>
                            <button onclick="toggleCartModal()" class="block w-full px-4 py-3 bg-accent-50 text-accent-700 rounded-lg hover:bg-accent-100 transition-colors text-center font-medium">
                                View Quote Requests
                            </button>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-red-50 rounded-2xl border border-red-200 p-6 shadow-3d">
                        <h3 class="text-lg font-bold text-red-900 mb-2">Danger Zone</h3>
                        <p class="text-sm text-red-700 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                        <button onclick="confirmDelete()" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Hidden Delete Account Form -->
    <form id="deleteAccountForm" action="delete_account.php" method="POST" style="display: none;">
        <input type="hidden" name="confirm_delete" value="yes">
    </form>



    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    // Toggle menu visibility
                    mobileMenu.classList.toggle('hidden');
                    
                    // Toggle icons
                    menuIcon.classList.toggle('hidden');
                    menuIcon.classList.toggle('block');
                    closeIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('block');
                });
            }
            
            // Update cart count
            updateCartCount();
        });
        
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('hydrochem_cart')) || [];
            const countEl = document.getElementById('cart-count');
            const countElMobile = document.getElementById('cart-count-mobile');
            
            if(countEl) countEl.innerText = cart.length;
            if(countElMobile) countElMobile.innerText = cart.length;
        }
    
        function confirmDelete() {
            if (confirm('Are you absolutely sure you want to delete your account? This action cannot be undone and all your data will be permanently removed.')) {
                if (confirm('This is your final warning. Click OK to permanently delete your account.')) {
                    // Submit the hidden form
                    document.getElementById('deleteAccountForm').submit();
                }
            }
        }

        // Cart modal placeholder function
        function toggleCartModal() {
            window.location.href = '../cart.php';
        }
    </script>
</body>
</html>
<?php include 'footer.php'; ?>
