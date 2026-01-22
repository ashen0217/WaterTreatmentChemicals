<?php
include 'includes/header.php';
// Products are available via globalProducts in JS from footer, but we can also access $products here if needed for server side rendering, 
// though the current implementation is client-side.
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- SECTION 2: Product Catalog (Grid) -->
    <section id="product-catalog" class="bg-white rounded-2xl shadow-3d-xl overflow-hidden border border-gray-100 min-h-[600px] animate-fade-in-up">
        <div class="p-8 border-b border-gray-200 bg-gradient-to-br from-gray-50 to-brand-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="section-title mb-2">Chemical Inventory</h3>
                <p class="text-sm text-gray-500">High-purity solutions for industrial and municipal use.</p>
                <div id="filter-display" class="mt-2 hidden">
                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-700 shadow-3d-sm">
                        Filtered by: <span id="current-filter-name" class="ml-1 font-bold"></span>
                        <button onclick="clearFilter()" class="ml-2 text-brand-600 hover:text-brand-800">×</button>
                    </span>
                </div>
            </div>
            <div class="flex gap-2">
                <input type="text" id="search-input" placeholder="Search chemicals..." class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 outline-none w-full md:w-64 transition-all duration-300 focus:shadow-3d-sm">
            </div>
        </div>

        <!-- Dynamic Product Grid -->
        <div id="product-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-8 perspective-container">
            <!-- JS will populate this -->
            <div class="col-span-full text-center text-gray-400 py-12">Loading inventory...</div>
        </div>
    </section>
</main>

<script>
    let currentFilter = 'All';

    document.addEventListener('DOMContentLoaded', () => {
        // Check URL params for filter
        const urlParams = new URLSearchParams(window.location.search);
        const stageParam = urlParams.get('stage');
        if(stageParam) {
            currentFilter = stageParam;
            document.getElementById('filter-display').classList.remove('hidden');
            document.getElementById('current-filter-name').textContent = stageParam;
        }

        renderProducts();
        setupSearch();
    });

    function clearFilter() {
        currentFilter = 'All';
        document.getElementById('filter-display').classList.add('hidden');
        // Update URL without reloading
        window.history.pushState({}, document.title, window.location.pathname);
        renderProducts();
    }

    function renderProducts() {
        const grid = document.getElementById('product-grid');
        const searchVal = document.getElementById('search-input').value.toLowerCase();
        
        // globalProducts is defined in footer.php
        if (typeof globalProducts === 'undefined') {
            console.error("Products data not loaded");
            return;
        }

        grid.innerHTML = '';

        const filtered = globalProducts.filter(p => {
            const matchesStage = currentFilter === 'All' || p.category === currentFilter;
            const matchesSearch = p.name.toLowerCase().includes(searchVal) || p.desc.toLowerCase().includes(searchVal);
            return matchesStage && matchesSearch;
        });

        if (filtered.length === 0) {
            grid.innerHTML = `<div class="col-span-3 text-center py-12 text-gray-500">No chemicals found matching your criteria.</div>`;
            return;
        }

        filtered.forEach(product => {
            const inCart = cart.includes(product.id);
            const card = document.createElement('div');
            card.className = "card-3d bg-white flex flex-col h-full group animate-scale-in";
            
            // Determine Badge Color - using new greenish-blue theme
            let badgeColor = "bg-gray-100 text-gray-800";
            if(product.category === "Coagulation") badgeColor = "bg-brand-100 text-brand-700";
            if(product.category === "Disinfection") badgeColor = "bg-green-100 text-green-700";
            if(product.category === "pH Control") badgeColor = "bg-purple-100 text-purple-700";

            card.innerHTML = `
                ${product.image_path ? `
                    <div class="w-full h-48 overflow-hidden bg-gray-100">
                        <img src="${product.image_path}" 
                             alt="${product.name}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                ` : `
                    <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                `}
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeColor}">
                            ${product.category}
                        </span>
                        <span class="text-xs text-gray-400 font-mono">${product.formula}</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-brand-500 transition-colors">${product.name}</h4>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">${product.desc}</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Form:</span>
                            <span class="font-medium text-gray-900">${product.form}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Concentration:</span>
                            <span class="font-medium text-gray-900">${product.purity}</span>
                        </div>
                    </div>
                </div>
                <div class="p-6 pt-0 mt-auto border-t border-gray-100">
                    <button onclick="toggleCart(${product.id})" class="w-full mt-4 flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white transition-all duration-300 ${inCart ? 'bg-green-600 hover:bg-green-700' : 'bg-brand-500 hover:bg-brand-600'} hover:shadow-xl hover:-translate-y-1">
                        ${inCart ? 'In Cart ✓' : 'Add to Cart'}
                    </button>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    function setupSearch() {
        document.getElementById('search-input').addEventListener('input', renderProducts);
    }
</script>

<?php include 'includes/footer.php'; ?>
