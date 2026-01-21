<?php
//require_once 'includes/auth_middleware.php';
//require_login();

include 'includes/header.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- SECTION 1: Interactive Process Map -->
    <section id="process-section">
        <div class="text-center mb-10">
            <h2 class="text-base font-semibold text-brand-600 tracking-wide uppercase">Interactive Workflow</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Identify Your Needs by Stage</p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Water treatment is a multi-step process. Select a stage below to browse chemicals specifically designed for that part of the workflow.
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <!-- Stage 1 -->
            <button onclick="filterByStage('Coagulation')" class="process-step group bg-white border-2 border-gray-200 rounded-xl p-6 text-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🧪</div>
                <h3 class="text-lg font-bold text-gray-900">Coagulation</h3>
                <p class="text-xs text-gray-500 mt-1">Destabilizing particles</p>
            </button>
            <!-- Stage 2 -->
            <button onclick="filterByStage('Flocculation')" class="process-step group bg-white border-2 border-gray-200 rounded-xl p-6 text-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🌀</div>
                <h3 class="text-lg font-bold text-gray-900">Flocculation</h3>
                <p class="text-xs text-gray-500 mt-1">Forming larger clumps</p>
            </button>
             <!-- Stage 3 -->
             <button onclick="filterByStage('Disinfection')" class="process-step group bg-white border-2 border-gray-200 rounded-xl p-6 text-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🛡️</div>
                <h3 class="text-lg font-bold text-gray-900">Disinfection</h3>
                <p class="text-xs text-gray-500 mt-1">Killing pathogens</p>
            </button>
            <!-- Stage 4 -->
            <button onclick="filterByStage('pH Control')" class="process-step group bg-white border-2 border-gray-200 rounded-xl p-6 text-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">⚖️</div>
                <h3 class="text-lg font-bold text-gray-900">pH Control</h3>
                <p class="text-xs text-gray-500 mt-1">Balancing acidity</p>
            </button>
             <!-- Stage 5: All -->
             <button onclick="filterByStage('All')" class="process-step active group bg-white border-2 border-gray-200 rounded-xl p-6 text-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🏭</div>
                <h3 class="text-lg font-bold text-gray-900">View All</h3>
                <p class="text-xs text-gray-500 mt-1">Full Inventory</p>
            </button>
        </div>
        
        <div class="mt-16 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Detailed Process Breakdown</h3>
                
                <!-- Stage Detail 1 -->
                <div class="flex flex-col md:flex-row gap-8 mb-12 items-center">
                    <div class="w-full md:w-1/2">
                        <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=800&q=80" alt="Coagulation Process" class="rounded-lg shadow-md w-full h-64 object-cover">
                    </div>
                    <div class="w-full md:w-1/2">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full mb-2">Stage 1</span>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Coagulation & Rapid Mixing</h4>
                        <p class="text-gray-600 mb-4">
                            Raw water often contains suspended solids that are too light to settle. Coagulants like PAC or Alum are added and mixed rapidly to neutralize the electrical charge of these particles, causing them to clump together.
                        </p>
                        <a href="chemicalProducts.php?stage=Coagulation" class="text-brand-600 font-medium hover:text-brand-800">Browse Coagulants &rarr;</a>
                    </div>
                </div>

                <!-- Stage Detail 2 -->
                <div class="flex flex-col md:flex-row-reverse gap-8 mb-12 items-center">
                    <div class="w-full md:w-1/2">
                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=800&q=80" alt="Flocculation" class="rounded-lg shadow-md w-full h-64 object-cover">
                    </div>
                    <div class="w-full md:w-1/2">
                         <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full mb-2">Stage 2</span>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Flocculation & Sedimentation</h4>
                        <p class="text-gray-600 mb-4">
                            The water is gently stirred to encourage the formation of larger "flocs". These heavier particles then settle to the bottom of the sedimentation tank, removing up to 90% of suspended matter.
                        </p>
                         <a href="chemicalProducts.php?stage=Flocculation" class="text-brand-600 font-medium hover:text-brand-800">Browse Flocculants &rarr;</a>
                    </div>
                </div>

                <!-- Stage Detail 3 -->
                <div class="flex flex-col md:flex-row gap-8 items-center">
                    <div class="w-full md:w-1/2">
                        <img src="https://images.unsplash.com/photo-1538300342682-cf57afb97285?auto=format&fit=crop&w=800&q=80" alt="Disinfection" class="rounded-lg shadow-md w-full h-64 object-cover">
                    </div>
                    <div class="w-full md:w-1/2">
                         <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full mb-2">Stage 3</span>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Disinfection & pH Adjustment</h4>
                        <p class="text-gray-600 mb-4">
                            The clear water is filtered and then disinfected using Chlorine or TCCA to kill harmful pathogens. Finally, the pH is adjusted to prevent corrosion in the distribution pipes.
                        </p>
                        <div class="flex gap-4">
                             <a href="chemicalProducts.php?stage=Disinfection" class="text-brand-600 font-medium hover:text-brand-800">Disinfectants &rarr;</a>
                             <a href="chemicalProducts.php?stage=pH Control" class="text-brand-600 font-medium hover:text-brand-800">pH Controllers &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16 bg-brand-50 rounded-xl p-8 border border-brand-100">
            <h3 class="text-xl font-bold text-brand-800 mb-4">Summary Checklist</h3>
            <div class="space-y-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-brand-200 text-brand-600 font-bold">1</div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-brand-900">Assessment</h4>
                        <p class="text-brand-700">Identify the specific contaminants and water quality parameters (turbidity, pH, pathogens) you need to address.</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-brand-200 text-brand-600 font-bold">2</div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-brand-900">Chemical Selection</h4>
                        <p class="text-brand-700">Choose the appropriate coagulants, flocculants, or disinfectants based on the stage of treatment required.</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-brand-200 text-brand-600 font-bold">3</div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-brand-900">Dosage Calculation</h4>
                        <p class="text-brand-700">Use our <a href="dosageCalculate.php" class="underline hover:text-brand-500">calculator</a> to determine the precise amount needed for your daily flow rate.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    function filterByStage(stage) {
        if(stage === 'All') {
            window.location.href = 'chemicalProducts.php';
        } else {
            window.location.href = 'chemicalProducts.php?stage=' + encodeURIComponent(stage);
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
