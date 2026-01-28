<?php
if (!defined('ADMIN_PAGE')) {
    die('Direct access not permitted');
}

$current_admin = get_admin_user();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Dashboard'; ?> - HydroChem Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-link {
            transition: all 0.2s;
        }
        .sidebar-link:hover {
            background-color: rgba(59, 130, 246, 0.1);
            border-left-color: #3b82f6;
        }
        .sidebar-link.active {
            background-color: rgba(59, 130, 246, 0.1);
            border-left-color: #3b82f6;
            color: #3b82f6;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex-shrink-0">
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="p-6 border-b border-gray-200">
                    <img src="../assets/images/logo.jpeg" alt="HydroChem Pro" class="h-12 w-auto object-contain mb-2">
                    <p class="text-sm text-gray-500">Admin Panel</p>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto p-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="index.php" class="sidebar-link <?php echo $current_page === 'index.php' ? 'active' : ''; ?> flex items-center px-4 py-3 text-gray-700 rounded-lg border-l-4 border-transparent">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="users.php" class="sidebar-link <?php echo $current_page === 'users.php' || $current_page === 'user_form.php' ? 'active' : ''; ?> flex items-center px-4 py-3 text-gray-700 rounded-lg border-l-4 border-transparent">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Manage Users
                            </a>
                        </li>
                        <li>
                            <a href="checkouts.php" class="sidebar-link <?php echo $current_page === 'checkouts.php' ? 'active' : ''; ?> flex items-center px-4 py-3 text-gray-700 rounded-lg border-l-4 border-transparent">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Checkout Requests
                            </a>
                        </li>
                        <li>
                            <a href="contacts.php" class="sidebar-link <?php echo $current_page === 'contacts.php' ? 'active' : ''; ?> flex items-center px-4 py-3 text-gray-700 rounded-lg border-l-4 border-transparent">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Contact Messages
                            </a>
                        </li>
                        <li>
                            <a href="products.php" class="sidebar-link <?php echo $current_page === 'products.php' || $current_page === 'product_form.php' ? 'active' : ''; ?> flex items-center px-4 py-3 text-gray-700 rounded-lg border-l-4 border-transparent">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Manage Products
                            </a>
                        </li>
                        <li>
                            <a href="admins.php" class="sidebar-link <?php echo $current_page === 'admins.php' || $current_page === 'admin_form.php' ? 'active' : ''; ?> flex items-center px-4 py-3 text-gray-700 rounded-lg border-l-4 border-transparent">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Manage Admins
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- User Info & Logout -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold"><?php echo strtoupper(substr($current_admin['full_name'], 0, 1)); ?></span>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($current_admin['full_name']); ?></p>
                            <p class="text-xs text-gray-500"><?php echo htmlspecialchars($current_admin['email']); ?></p>
                        </div>
                    </div>
                    <a href="admin_self_delete.php" class="flex items-center justify-center px-4 py-2 mb-2 bg-orange-50 text-orange-600 rounded-lg hover:bg-orange-100 transition text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Delete My Account
                    </a>
                    <a href="logout.php" class="flex items-center justify-center px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900"><?php echo $page_title ?? 'Dashboard'; ?></h2>
                    <a href="../index.php" target="_blank" class="text-sm text-blue-600 hover:text-blue-700 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Website
                    </a>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
