<?php include 'includes/header.php'; ?>

    <!-- Hero Section with Video Background -->
    <div class="relative overflow-hidden min-h-[600px] md:min-h-[700px]">
        <!-- Video Background -->
        <video 
            autoplay 
            muted 
            loop 
            playsinline
            class="absolute inset-0 w-full h-full object-cover"
        >
            <source src="assets/videos/Water Treatment Plant Design ｜ Water Management ｜ Tejjy Inc. [y1wwCjJ-TSo].mkv" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <!-- Dark Overlay for Text Visibility -->
        <div class="absolute inset-0 bg-gradient-to-br from-brand-900/85 to-brand-800/85"></div>
        
        <!-- Decorative Circles with 3D Effect -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-accent-400 rounded-full mix-blend-multiply filter blur-3xl opacity-15 animate-pulse-3d"></div>
        
        <!-- Content Overlay -->
        <div class="relative max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center z-10 min-h-[600px] md:min-h-[700px]">
            <div class="md:w-1/2 text-center md:text-left mb-8 md:mb-0 animate-fade-in-up">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl text-white drop-shadow-lg">
                    Industrial Grade <br><span class="text-brand-200">Water Treatment</span>
                </h1>
                <p class="mt-6 text-xl text-white max-w-3xl drop-shadow-md">
                    Premium chemical solutions for coagulation, disinfection, and pH control. Optimize your treatment plant's efficiency with our certified range of products.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="chemicalProducts.php" class="inline-flex items-center justify-center px-8 py-4 bg-brand-500 text-white font-semibold rounded-lg shadow-2xl hover:bg-brand-600 transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 text-center">
                        Browse Catalog
                    </a>
                    <a href="dosageCalculate.php" class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white font-semibold rounded-lg border-2 border-white shadow-2xl hover:bg-white hover:text-brand-600 transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 text-center">
                        Calculate Dosage
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center animate-slide-in-right">
                
            </div>
        </div>
    </div>

    <!-- Abstract Representation of Purity with 3D Float -->
    <!--<div class="relative w-64 h-64 md:w-80 md:h-80 bg-gradient-to-br from-brand-300/80 to-accent-400/80 rounded-full backdrop-blur-sm animate-float flex items-center justify-center shadow-3d-xl perspective-container">
                     <span class="text-9xl text-white opacity-95 animate-pulse-3d drop-shadow-2xl">💧</span>
    </div>  -->           


    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-20">
        <?php if (isset($_GET['account_deleted']) && $_GET['account_deleted'] == '1'): ?>
            <!-- Account Deleted Success Message -->
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-700 font-medium">Your account has been successfully deleted. We're sorry to see you go!</p>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Optional: Brief Overview or Call to Actions could go here -->
        <div class="text-center animate-fade-in-up">
            <h2 class="section-title">Comprehensive Water Solutions</h2>
            <p class="mt-4 text-gray-500 max-w-2xl mx-auto">
                Explore our tools and catalog to find exactly what you need for your water treatment facility.
            </p>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 perspective-container">
                <a href="processGuide.php" class="card-3d p-6 bg-white border border-gray-200 hover-lift stagger-1 animate-scale-in">
                    <div class="text-4xl mb-4">🛠️</div>
                    <h3 class="text-lg font-bold text-gray-900">Process Guide</h3>
                    <p class="text-sm text-gray-500 mt-2">Step-by-step workflow to identify your needs.</p>
                </a>
                <a href="chemicalProducts.php" class="card-3d p-6 bg-white border border-gray-200 hover-lift stagger-2 animate-scale-in">
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="text-lg font-bold text-gray-900">Full Catalog</h3>
                    <p class="text-sm text-gray-500 mt-2">Browse our complete inventory of chemicals.</p>
                </a>
                <a href="performanceData.php" class="card-3d p-6 bg-white border border-gray-200 hover-lift stagger-3 animate-scale-in">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-lg font-bold text-gray-900">Performance Data</h3>
                    <p class="text-sm text-gray-500 mt-2">Analyze efficiency and cost-effectiveness.</p>
                </a>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="bg-gradient-to-br from-gray-50 to-brand-50 rounded-2xl p-8 sm:p-12 shadow-3d-lg animate-fade-in-up">
            <div class="text-center mb-12">
                <h2 class="section-title">Why Choose HydroChem Pro?</h2>
                <p class="mt-4 text-lg text-gray-500">We deliver more than just chemicals; we provide guaranteed results.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 perspective-container">
                <div class="flex flex-col items-center text-center info-card p-6 bg-white rounded-xl shadow-md stagger-1 animate-scale-in">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-brand-100 text-brand-600 mb-4 shadow-3d">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Certified Purity</h3>
                    <p class="text-gray-500">All our products undergo rigorous lab testing to ensure 99.9% effectiveness and safety compliance.</p>
                </div>
                <div class="flex flex-col items-center text-center info-card p-6 bg-white rounded-xl shadow-md stagger-2 animate-scale-in">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-brand-100 text-brand-600 mb-4 shadow-3d">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Fast Action</h3>
                    <p class="text-gray-500">Our formulations are optimized for rapid coagulation and disinfection, reducing processing time.</p>
                </div>
                <div class="flex flex-col items-center text-center info-card p-6 bg-white rounded-xl shadow-md stagger-3 animate-scale-in">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-brand-100 text-brand-600 mb-4 shadow-3d">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Technical Support</h3>
                    <p class="text-gray-500">24/7 access to our team of chemical engineers for dosage consultation and troubleshooting.</p>
                </div>
            </div>
        </div>

        <!-- Featured Application -->
        <div class="relative bg-white overflow-hidden border border-gray-100 rounded-2xl shadow-3d-lg hover-lift animate-fade-in-up">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">
                                <span class="block xl:inline">Clean Water for</span>
                                <span class="block text-brand-500 xl:inline">Communities</span>
                            </h2>
                            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Municipal water treatment requires consistency and scale. Our Poly Aluminium Chloride (PAC) solutions are ensuring safe drinking water for over 5 million people daily.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="chemicalProducts.php?stage=Coagulation" class="btn-primary w-full flex items-center justify-center">
                                        View Solutions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="assets/images/waterTreat2.jpg">
            </div>
            </div>
        </div>

        <!-- About HydroChem Pro Section -->
        <div class="rounded-2xl p-8 sm:p-12 shadow-3d-xl transform-3d hover-lift animate-fade-in-up" style="background-color: #E9F2F2;">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold mb-4 text-gray-900">About HydroChem Pro</h2>
                    <div class="w-24 h-1 bg-brand-500 mx-auto mb-6 shadow-3d"></div>
                </div>
                <div class="space-y-4 text-gray-800 leading-relaxed">
                    <p class="text-lg text-gray-700">
                        HydroChem is a leading supplier of industrial-grade water treatment chemicals, serving municipalities, 
                        industrial facilities, and commercial water treatment plants across the region. With over two decades of 
                        experience, we've built our reputation on delivering consistent quality, technical expertise, and 
                        reliable supply chain management.
                    </p>
                    <p class="text-gray-700">
                        Our comprehensive product portfolio includes high-purity coagulants, disinfectants, pH control agents, 
                        and specialty chemicals designed to optimize every stage of the water treatment process. Each product 
                        undergoes rigorous quality testing to ensure it meets international standards for safety and effectiveness.
                    </p>
                    <p class="text-gray-700">
                        We don't just supply chemicals – we partner with our clients to deliver complete water treatment solutions. 
                        Our team of certified chemical engineers provides 24/7 technical support, helping you optimize dosing 
                        strategies, troubleshoot operational challenges, and achieve regulatory compliance while minimizing costs.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 pt-8 border-t border-brand-400">
                        <div class="text-center transform hover:scale-110 transition-transform duration-300">
                            <div class="text-4xl font-bold text-brand-600 mb-2">20+</div>
                            <div class="text-sm text-gray-600">Years of Excellence</div>
                        </div>
                        <div class="text-center transform hover:scale-110 transition-transform duration-300">
                            <div class="text-4xl font-bold text-brand-600 mb-2">500+</div>
                            <div class="text-sm text-gray-600">Active Clients</div>
                        </div>
                        <div class="text-center transform hover:scale-110 transition-transform duration-300">
                            <div class="text-4xl font-bold text-brand-600 mb-2">99.9%</div>
                            <div class="text-sm text-gray-600">Product Purity</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // Fetch featured products from database
        require_once 'config.php';
        $conn = getDatabaseConnection();
        $featured_products = [];
        
        if ($conn) {
            // Get 3 featured products (one from each major category)
            $result = $conn->query("
                SELECT id, name, formula, category, form, purity, description as `desc`, price_index, effectiveness, image_path 
                FROM products 
                WHERE is_active = 1 
                AND category IN ('Coagulation', 'Disinfection', 'pH Control')
                GROUP BY category
                LIMIT 3
            ");
            
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $featured_products[] = $row;
                }
            }
            $conn->close();
        }
        ?>

        <!-- Featured Chemical Products Section -->
        <?php if (!empty($featured_products)): ?>
        <div class="bg-white rounded-2xl shadow-3d-xl overflow-hidden border border-gray-100 animate-fade-in-up">
            <div class="p-8 border-b border-gray-200 bg-gradient-to-br from-gray-50 to-brand-50 text-center">
                <h2 class="section-title mb-2">Featured Chemical Products</h2>
                <p class="text-gray-500">Discover our most popular water treatment solutions</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8 perspective-container">
                <?php foreach ($featured_products as $index => $product): 
                    // Determine badge color based on category - using new greenish-blue theme
                    $badgeColor = "bg-gray-100 text-gray-800";
                    if($product['category'] === "Coagulation") $badgeColor = "bg-brand-100 text-brand-700";
                    if($product['category'] === "Disinfection") $badgeColor = "bg-green-100 text-green-700";
                    if($product['category'] === "pH Control") $badgeColor = "bg-purple-100 text-purple-700";
                    $stagger = "stagger-" . ($index + 1);
                ?>
                <div class="card-3d bg-white flex flex-col h-full group animate-scale-in <?php echo $stagger; ?>">
                    <!-- Product Image -->
                    <?php if (!empty($product['image_path']) && file_exists(__DIR__ . '/' . $product['image_path'])): ?>
                        <div class="w-full h-48 overflow-hidden bg-gray-100">
                            <img src="<?php echo htmlspecialchars($product['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badgeColor; ?>">
                                <?php echo htmlspecialchars($product['category']); ?>
                            </span>
                            <span class="text-xs text-gray-400 font-mono"><?php echo htmlspecialchars($product['formula']); ?></span>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-brand-500 transition-colors">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h4>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            <?php echo htmlspecialchars($product['desc']); ?>
                        </p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Form:</span>
                                <span class="font-medium text-gray-900"><?php echo htmlspecialchars($product['form']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Concentration:</span>
                                <span class="font-medium text-gray-900"><?php echo htmlspecialchars($product['purity']); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Effectiveness:</span>
                                <span class="font-medium text-brand-500"><?php echo htmlspecialchars($product['effectiveness']); ?>%</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-0 mt-auto border-t border-gray-100">
                        <a href="chemicalProducts.php" class="block w-full text-center px-4 py-3 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            View Details
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="p-6 bg-gradient-to-br from-gray-50 to-brand-50 border-t border-gray-200 text-center">
                <a href="chemicalProducts.php" class="inline-flex items-center text-brand-500 hover:text-brand-600 font-semibold transition-colors">
                    Browse Full Catalog
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
        <?php endif; ?>
    </main>

<?php include 'includes/footer.php'; ?>
