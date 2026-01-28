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

<script>
// Form validation
const productForm = document.querySelector('form');
const nameInput = document.getElementById('name');
const formulaInput = document.getElementById('formula');
const categorySelect = document.getElementById('category');
const formInput = document.getElementById('form');
const purityInput = document.getElementById('purity');
const priceIndexInput = document.getElementById('price_index');
const effectivenessInput = document.getElementById('effectiveness');
const descriptionInput = document.getElementById('description');
const imageInput = document.getElementById('product_image');

// Real-time validation for product name
nameInput.addEventListener('blur', function() {
    const value = this.value.trim();
    if (value.length < 3) {
        showFieldError(this, 'Product name must be at least 3 characters long');
    } else if (value.length > 200) {
        showFieldError(this, 'Product name is too long (max 200 characters)');
    } else {
        clearFieldError(this);
    }
});

// Real-time validation for formula
formulaInput.addEventListener('blur', function() {
    const value = this.value.trim();
    if (value.length < 1) {
        showFieldError(this, 'Chemical formula is required');
    } else if (value.length > 50) {
        showFieldError(this, 'Formula is too long (max 50 characters)');
    } else {
        clearFieldError(this);
    }
});

// Real-time validation for category
categorySelect.addEventListener('change', function() {
    if (this.value === '') {
        showFieldError(this, 'Please select a category');
    } else {
        clearFieldError(this);
    }
});

// Real-time validation for price index
priceIndexInput.addEventListener('input', function() {
    const value = parseInt(this.value);
    if (isNaN(value) || value < 1 || value > 3) {
        showFieldError(this, 'Price index must be between 1 and 3');
    } else {
        clearFieldError(this);
    }
});

// Real-time validation for effectiveness
effectivenessInput.addEventListener('input', function() {
    const value = parseInt(this.value);
    if (isNaN(value) || value < 0 || value > 100) {
        showFieldError(this, 'Effectiveness must be between 0 and 100');
    } else {
        clearFieldError(this);
    }
});

// Real-time validation for description
descriptionInput.addEventListener('blur', function() {
    const value = this.value.trim();
    if (value.length < 10) {
        showFieldError(this, 'Description must be at least 10 characters long');
    } else if (value.length > 1000) {
        showFieldError(this, 'Description is too long (max 1000 characters)');
    } else {
        clearFieldError(this);
    }
});

// Image file validation
imageInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!validTypes.includes(file.type)) {
            showFieldError(this, 'Invalid file type. Please upload JPG, PNG, GIF, or WebP');
            this.value = '';
            document.getElementById('image-preview').classList.add('hidden');
        } else if (file.size > maxSize) {
            showFieldError(this, 'File is too large. Maximum size is 5MB');
            this.value = '';
            document.getElementById('image-preview').classList.add('hidden');
        } else {
            clearFieldError(this);
        }
    }
});

// Form submission validation
productForm.addEventListener('submit', function(e) {
    let isValid = true;
    
    // Validate product name
    const name = nameInput.value.trim();
    if (name.length < 3) {
        showFieldError(nameInput, 'Product name must be at least 3 characters');
        isValid = false;
    } else if (name.length > 200) {
        showFieldError(nameInput, 'Product name is too long');
        isValid = false;
    }
    
    // Validate formula
    const formula = formulaInput.value.trim();
    if (formula.length < 1) {
        showFieldError(formulaInput, 'Chemical formula is required');
        isValid = false;
    }
    
    // Validate category
    if (categorySelect.value === '') {
        showFieldError(categorySelect, 'Please select a category');
        isValid = false;
    }
    
    // Validate form
    const formValue = formInput.value.trim();
    if (formValue.length < 2) {
        showFieldError(formInput, 'Physical form is required');
        isValid = false;
    }
    
    // Validate purity
    const purity = purityInput.value.trim();
    if (purity.length < 1) {
        showFieldError(purityInput, 'Purity/concentration is required');
        isValid = false;
    }
    
    // Validate price index
    const priceIndex = parseInt(priceIndexInput.value);
    if (isNaN(priceIndex) || priceIndex < 1 || priceIndex > 3) {
        showFieldError(priceIndexInput, 'Price index must be between 1 and 3');
        isValid = false;
    }
    
    // Validate effectiveness
    const effectiveness = parseInt(effectivenessInput.value);
    if (isNaN(effectiveness) || effectiveness < 0 || effectiveness > 100) {
        showFieldError(effectivenessInput, 'Effectiveness must be between 0 and 100');
        isValid = false;
    }
    
    // Validate description
    const description = descriptionInput.value.trim();
    if (description.length < 10) {
        showFieldError(descriptionInput, 'Description must be at least 10 characters');
        isValid = false;
    } else if (description.length > 1000) {
        showFieldError(descriptionInput, 'Description is too long (max 1000 characters)');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
        // Scroll to first error
        const firstError = document.querySelector('.border-red-500');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
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
