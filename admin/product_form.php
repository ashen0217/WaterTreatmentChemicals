<?php
/**
 * Product Add/Edit Form
 */
define('ADMIN_PAGE', true);
require_once 'auth.php';
require_once 'includes/functions.php';

// Require admin authentication
require_admin();

$page_title = 'Product Form';
$error = '';
$success = '';

// Check if editing existing product
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($product_id > 0) {
    $product = get_product_by_id($product_id);
    if (!$product) {
        header("Location: products.php");
        exit();
    }
    $page_title = 'Edit Product';
} else {
    $page_title = 'Add New Product';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => sanitize_input($_POST['name'] ?? ''),
        'formula' => sanitize_input($_POST['formula'] ?? ''),
        'category' => sanitize_input($_POST['category'] ?? ''),
        'form' => sanitize_input($_POST['form'] ?? ''),
        'purity' => sanitize_input($_POST['purity'] ?? ''),
        'description' => sanitize_input($_POST['description'] ?? ''),
        'price_index' => intval($_POST['price_index'] ?? 1),
        'effectiveness' => intval($_POST['effectiveness'] ?? 0),
        'image_path' => $product['image_path'] ?? null // Keep existing image by default
    ];
    
    // Validation
    if (empty($data['name']) || empty($data['formula']) || empty($data['category']) || 
        empty($data['form']) || empty($data['purity']) || empty($data['description'])) {
        $error = 'Please fill in all required fields';
    } elseif ($data['price_index'] < 1 || $data['price_index'] > 3) {
        $error = 'Price index must be between 1 and 3';
    } elseif ($data['effectiveness'] < 0 || $data['effectiveness'] > 100) {
        $error = 'Effectiveness must be between 0 and 100';
    } else {
        // Handle image upload
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload_result = handle_product_image_upload($_FILES['product_image']);
            if ($upload_result['success']) {
                $data['image_path'] = $upload_result['path'];
            } else {
                $error = $upload_result['message'];
            }
        } elseif (isset($_POST['remove_image']) && $_POST['remove_image'] === '1') {
            // Remove image if checkbox is checked
            $data['image_path'] = null;
        }
        
        // Create or update product if no errors
        if (empty($error)) {
            if ($product_id > 0) {
                $result = update_product($product_id, $data);
            } else {
                $result = create_product($data);
            }
            
            if ($result['success']) {
                header("Location: products.php");
                exit();
            } else {
                $error = $result['message'];
            }
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Form -->
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900"><?php echo $product_id > 0 ? 'Edit Product' : 'Add New Product'; ?></h3>
            <p class="text-sm text-gray-500 mt-1">
                <?php echo $product_id > 0 ? 'Update product information' : 'Create a new chemical product'; ?>
            </p>
        </div>
        
        <?php if ($error): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-800 text-sm"><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required
                        value="<?php echo htmlspecialchars($product['name'] ?? $_POST['name'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        placeholder="Poly Aluminium Chloride"
                    >
                </div>
                
                <div>
                    <label for="formula" class="block text-sm font-medium text-gray-700 mb-2">
                        Chemical Formula <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="formula" 
                        name="formula" 
                        required
                        value="<?php echo htmlspecialchars($product['formula'] ?? $_POST['formula'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        placeholder="Al₂(SO₄)₃"
                    >
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    >
                        <option value="">Select Category</option>
                        <option value="Coagulation" <?php echo ($product['category'] ?? $_POST['category'] ?? '') === 'Coagulation' ? 'selected' : ''; ?>>Coagulation</option>
                        <option value="Disinfection" <?php echo ($product['category'] ?? $_POST['category'] ?? '') === 'Disinfection' ? 'selected' : ''; ?>>Disinfection</option>
                        <option value="pH Control" <?php echo ($product['category'] ?? $_POST['category'] ?? '') === 'pH Control' ? 'selected' : ''; ?>>pH Control</option>
                        <option value="Flocculation" <?php echo ($product['category'] ?? $_POST['category'] ?? '') === 'Flocculation' ? 'selected' : ''; ?>>Flocculation</option>
                        <option value="Stabilization" <?php echo ($product['category'] ?? $_POST['category'] ?? '') === 'Scale Inhibitor' ? 'selected' : ''; ?>>Scale Inhibitor</option>
                        <option value="Stabilization" <?php echo ($product['category'] ?? $_POST['category'] ?? '') === 'Scale Inhibitor/Dispersant' ? 'selected' : ''; ?>>Scale Inhibitor/Dispersant</option>
                        <option value="Dispersant" <?php echo ($product['category'] ?? $_POST['category'] ?? '') === 'Dispersant' ? 'selected' : ''; ?>>Dispersant</option>
                        <option value="Polymerization" <?php echo ($product['category'] ?? $_POST['category'] ?? '') === 'Polymerization' ? 'selected' : ''; ?>>Polymerization</option>
                    </select>
                </div>
                
                <div>
                    <label for="form" class="block text-sm font-medium text-gray-700 mb-2">
                        Physical Form <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="form" 
                        name="form" 
                        required
                        value="<?php echo htmlspecialchars($product['form'] ?? $_POST['form'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        placeholder="Powder, Liquid, Granular, etc."
                    >
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="purity" class="block text-sm font-medium text-gray-700 mb-2">
                        Purity/Concentration <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="purity" 
                        name="purity" 
                        required
                        value="<?php echo htmlspecialchars($product['purity'] ?? $_POST['purity'] ?? ''); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        placeholder="30%, 98%, etc."
                    >
                </div>
                
                <div>
                    <label for="price_index" class="block text-sm font-medium text-gray-700 mb-2">
                        Price Index (1-3) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="price_index" 
                        name="price_index" 
                        required
                        min="1"
                        max="3"
                        value="<?php echo htmlspecialchars($product['price_index'] ?? $_POST['price_index'] ?? '1'); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    >
                    <p class="text-xs text-gray-500 mt-1">1 = Low, 2 = Medium, 3 = High</p>
                </div>
                
                <div>
                    <label for="effectiveness" class="block text-sm font-medium text-gray-700 mb-2">
                        Effectiveness (0-100) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="effectiveness" 
                        name="effectiveness" 
                        required
                        min="0"
                        max="100"
                        value="<?php echo htmlspecialchars($product['effectiveness'] ?? $_POST['effectiveness'] ?? '0'); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    >
                    <p class="text-xs text-gray-500 mt-1">Percentage (0-100)</p>
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    required
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    placeholder="Detailed product description..."
                ><?php echo htmlspecialchars($product['description'] ?? $_POST['description'] ?? ''); ?></textarea>
            </div>
            
            <!-- Product Image Upload -->
            <div>
                <label for="product_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Product Image
                </label>
                
                <?php if ($product_id > 0 && !empty($product['image_path'])): ?>
                    <!-- Show current image in edit mode -->
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                        <img src="../<?php echo htmlspecialchars($product['image_path']); ?>" 
                             alt="Current product image" 
                             class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Remove current image</span>
                            </label>
                        </div>
                    </div>
                <?php endif; ?>
                
                <input 
                    type="file" 
                    id="product_image" 
                    name="product_image" 
                    accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    onchange="previewImage(this)"
                >
                <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG, GIF, WebP (Max 5MB)</p>
                
                <!-- Image Preview -->
                <div id="image-preview" class="mt-4 hidden">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img id="preview-img" src="" alt="Image preview" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                </div>
            </div>
            
            <script>
            function previewImage(input) {
                const preview = document.getElementById('image-preview');
                const previewImg = document.getElementById('preview-img');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.classList.add('hidden');
                }
            }
            </script>
            
            <div class="flex gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition"
                >
                    <?php echo $product_id > 0 ? 'Update Product' : 'Create Product'; ?>
                </button>
                <a 
                    href="products.php" 
                    class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition text-center"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
