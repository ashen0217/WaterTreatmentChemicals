<?php
/**
 * Product Management Page
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

$page_title = 'Manage Products';

// Handle delete request
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    $result = delete_product($product_id);
    $message = $result['message'];
    $message_type = $result['success'] ? 'success' : 'error';
}

// Get filter and search parameters
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

// Get products
$products = get_all_products($category, $search);
?>
<?php include 'includes/header.php'; ?>

<!-- Success/Error Messages -->
<?php if (isset($message)): ?>
    <div class="mb-6 p-4 rounded-lg <?php echo $message_type === 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'; ?>">
        <p class="<?php echo $message_type === 'success' ? 'text-green-800' : 'text-red-800'; ?> text-sm">
            <?php echo htmlspecialchars($message); ?>
        </p>
    </div>
<?php endif; ?>

<!-- Header Actions -->
<div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
    <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
        <!-- Category Filter -->
        <select 
            onchange="window.location.href='?category=' + this.value + '<?php echo $search ? '&search=' . urlencode($search) : ''; ?>'"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
        >
            <option value="">All Categories</option>
            <option value="Coagulation" <?php echo $category === 'Coagulation' ? 'selected' : ''; ?>>Coagulation</option>
            <option value="Disinfection" <?php echo $category === 'Disinfection' ? 'selected' : ''; ?>>Disinfection</option>
            <option value="pH Control" <?php echo $category === 'pH Control' ? 'selected' : ''; ?>>pH Control</option>
            <option value="Flocculation" <?php echo $category === 'Flocculation' ? 'selected' : ''; ?>>Flocculation</option>
        </select>
        
        <!-- Search -->
        <form method="GET" action="" class="flex gap-2">
            <?php if ($category): ?>
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <?php endif; ?>
            <input 
                type="text" 
                name="search" 
                placeholder="Search products..." 
                value="<?php echo htmlspecialchars($search); ?>"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
            >
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Search
            </button>
            <?php if ($search || $category): ?>
                <a href="products.php" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Clear
                </a>
            <?php endif; ?>
        </form>
    </div>
    
    <a href="product_form.php" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center whitespace-nowrap">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Add New Product
    </a>
</div>

<!-- Products Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($products)): ?>
        <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-gray-500">
                <?php echo $search || $category ? 'No products found matching your criteria.' : 'No products available.'; ?>
            </p>
        </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <?php
            // Determine badge color
            $badgeColor = "bg-gray-100 text-gray-800";
            if($product['category'] === "Coagulation") $badgeColor = "bg-blue-100 text-blue-800";
            if($product['category'] === "Disinfection") $badgeColor = "bg-green-100 text-green-800";
            if($product['category'] === "pH Control") $badgeColor = "bg-purple-100 text-purple-800";
            if($product['category'] === "Flocculation") $badgeColor = "bg-orange-100 text-orange-800";
            ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                <!-- Product Image -->
                <div class="w-full h-48 bg-gray-100 overflow-hidden">
                    <?php if (!empty($product['image_path']) && file_exists(__DIR__ . '/../' . $product['image_path'])): ?>
                        <img src="../<?php echo htmlspecialchars($product['image_path']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>" 
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeColor; ?>">
                            <?php echo htmlspecialchars($product['category']); ?>
                        </span>
                        <span class="text-xs text-gray-400 font-mono"><?php echo htmlspecialchars($product['formula']); ?></span>
                    </div>
                    
                    <!-- Product Info -->
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-3"><?php echo htmlspecialchars($product['description']); ?></p>
                    
                    <!-- Details -->
                    <div class="space-y-2 mb-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Form:</span>
                            <span class="font-medium text-gray-900"><?php echo htmlspecialchars($product['form']); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Purity:</span>
                            <span class="font-medium text-gray-900"><?php echo htmlspecialchars($product['purity']); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Effectiveness:</span>
                            <span class="font-medium text-gray-900"><?php echo $product['effectiveness']; ?>%</span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex gap-2">
                    <a href="product_form.php?id=<?php echo $product['id']; ?>" 
                       class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                        Edit
                    </a>
                    <a href="?delete=<?php echo $product['id']; ?><?php echo $category ? '&category=' . urlencode($category) : ''; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" 
                       onclick="return confirm('Are you sure you want to delete this product?')" 
                       class="flex-1 text-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                        Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Product Count -->
<?php if (!empty($products)): ?>
    <div class="mt-6 text-center text-sm text-gray-600">
        Showing <?php echo count($products); ?> product(s)
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
