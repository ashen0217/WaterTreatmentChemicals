<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);

function isActive($page) {
    global $current_page;
    return $current_page === $page ? 'border-brand-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-brand-500 hover:text-gray-700';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | HydroChem Pro' : 'HydroChem Pro | Water Treatment Solutions'; ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS with 3D Effects and Animations -->
    <link rel="stylesheet" href="style.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
                            500: '#2CB091', // Primary greenish-blue
                            600: '#238d75',
                            700: '#1a6a58',
                            800: '#12463a',
                            900: '#09231d',
                        },
                        accent: {
                            400: '#3dd5b8',
                            500: '#2CB091', // Matching primary
                            600: '#27a082',
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
        /* Custom Styles for Chart Containers */
        .chart-container {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            height: 300px;
            max-height: 400px;
        }
        @media (min-width: 768px) {
            .chart-container {
                height: 350px;
            }
        }
        
        /* Process Flow Styling */
        .process-step {
            transition: all 0.3s ease;
        }
        .process-step:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .process-step.active {
            border-color: #0ea5e9;
            background-color: #f0f9ff;
        }

        /* Custom Scrollbar for Catalog */
        .custom-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="flex-shrink-0 flex items-center gap-2">
                        <span class="text-2xl sm:text-3xl text-brand-600 font-bold">HydroChem</span>
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="index.php" class="<?php echo isActive('index.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Home page</a>
                    <a href="processGuide.php" class="<?php echo isActive('processGuide.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Process Guide</a>
                    <a href="chemicalProducts.php" class="<?php echo isActive('chemicalProducts.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Chemical Catalog</a>
                    <a href="dosageCalculate.php" class="<?php echo isActive('dosageCalculate.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Dosage Calculator</a>
                    <a href="performanceData.php" class="<?php echo isActive('performanceData.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium no-underline">Performance Data</a>
                </div>
                
                <!-- Desktop Right Side -->
                <div class="hidden sm:flex items-center gap-4">
                    <button class="bg-brand-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm" onclick="window.location.href='cart.php'">
                        View Cart (<span id="cart-count">0</span>)
                    </button>
                    <!-- Auth Links / User Menu -->
                    <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                        <!-- Logged In User Menu -->
                        <a href="user/dashboard.php" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center">
                                <span class="text-brand-600 font-semibold text-sm"><?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?></span>
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden md:block"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                        </a>
                    <?php elseif (!strpos($current_page, 'login.php') && !strpos($current_page, 'signup.php')): ?>
                        <!-- Not Logged In - Show Login/Signup -->
                        <div class="flex items-center space-x-2 text-sm font-medium text-gray-500">
                            <a href="login.php" class="hover:text-brand-600">Login</a>
                            <span>|</span>
                            <a href="signup.php" class="hover:text-brand-600">Sign Up</a>
                        </div>
                    <?php endif; ?>
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
                <a href="index.php" class="<?php echo $current_page === 'index.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Home page</a>
                <a href="processGuide.php" class="<?php echo $current_page === 'processGuide.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Process Guide</a>
                <a href="chemicalProducts.php" class="<?php echo $current_page === 'chemicalProducts.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Chemical Catalog</a>
                <a href="dosageCalculate.php" class="<?php echo $current_page === 'dosageCalculate.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Dosage Calculator</a>
                <a href="performanceData.php" class="<?php echo $current_page === 'performanceData.php' ? 'bg-brand-50 border-brand-500 text-brand-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'; ?> block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors no-underline">Performance Data</a>
            </div>
            
            <!-- Mobile Cart and Auth -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-4 space-y-3">
                    <button class="w-full bg-brand-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm" onclick="window.location.href='cart.php'">
                        View Cart (<span id="cart-count-mobile">0</span>)
                    </button>
                    
                    <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                        <!-- Logged In User -->
                        <a href="user/dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center">
                                <span class="text-brand-600 font-semibold"><?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?></span>
                            </div>
                            <span class="text-base font-medium text-gray-700"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                        </a>
                    <?php elseif (!strpos($current_page, 'login.php') && !strpos($current_page, 'signup.php')): ?>
                        <!-- Not Logged In -->
                        <div class="flex gap-2">
                            <a href="login.php" class="flex-1 text-center px-4 py-2 border border-brand-600 text-brand-600 rounded-md text-sm font-medium hover:bg-brand-50 transition-colors">Login</a>
                            <a href="signup.php" class="flex-1 text-center px-4 py-2 bg-brand-600 text-white rounded-md text-sm font-medium hover:bg-brand-700 transition-colors">Sign Up</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
