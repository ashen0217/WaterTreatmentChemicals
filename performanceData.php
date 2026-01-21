<?php


include 'includes/header.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Data-Driven Solutions</h2>
        <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
            We measure our success by your water quality. Explore our performance metrics and case studies.
        </p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Average Turbidity Removal</p>
                <p class="text-2xl font-bold text-gray-900">98.5%</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Cost Savings / Year</p>
                <p class="text-2xl font-bold text-gray-900">~15%</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Compliance Rate</p>
                <p class="text-2xl font-bold text-gray-900">100%</p>
            </div>
        </div>
    </div>

    <!-- SECTION 3: Performance Analytics (Charts) -->
    <section id="analytics-section" class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
        <!-- Chart 1: Efficiency Comparison -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-900">Turbidity Removal Efficiency</h3>
                <p class="text-sm text-gray-500">Comparison of coagulant effectiveness at standard dosage (20ppm).</p>
            </div>
            <div class="chart-container">
                <canvas id="efficiencyChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Cost Analysis -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-900">Cost-Benefit Analysis</h3>
                <p class="text-sm text-gray-500">Price per kg vs. Active Chemical Concentration.</p>
            </div>
            <div class="chart-container">
                <canvas id="costChart"></canvas>
            </div>
        </div>
    </section>

    <!-- Case Study Section -->
    <section class="bg-brand-900 rounded-2xl overflow-hidden shadow-2xl text-white">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="p-12 flex flex-col justify-center">
                <div class="uppercase tracking-wide text-sm text-brand-300 font-semibold mb-2">Case Study</div>
                <h3 class="text-3xl font-extrabold mb-4">Metropolis Municipal Plant</h3>
                <p class="text-brand-100 mb-6">
                    By switching to our high-basicity Poly Aluminium Chloride, Metropolis Water reduced their sludge production by 30% and improved filter run times significantly.
                </p>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-brand-800 p-4 rounded-lg">
                        <span class="block text-2xl font-bold text-white">30%</span>
                        <span class="text-xs text-brand-300">Less Sludge</span>
                    </div>
                    <div class="bg-brand-800 p-4 rounded-lg">
                        <span class="block text-2xl font-bold text-white">2.5x</span>
                        <span class="text-xs text-brand-300">Filter Run Time</span>
                    </div>
                </div>
            </div>
            <div class="relative h-64 lg:h-auto">
                <img class="absolute inset-0 w-full h-full object-cover opacity-80" src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1350&q=80" alt="Industrial piping">
                <div class="absolute inset-0 bg-gradient-to-l from-brand-900 to-transparent"></div>
            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        initCharts();
    });

    // --- CHART VISUALIZATION ---
    function initCharts() {
        if (typeof globalProducts === 'undefined') {
            console.error("Products data missing for charts");
            return;
        }

        // Chart 1: Efficiency (Coagulants)
        const coagulants = globalProducts.filter(p => p.category === 'Coagulation');
        const ctxEfficiency = document.getElementById('efficiencyChart').getContext('2d');
        
        new Chart(ctxEfficiency, {
            type: 'bar',
            data: {
                labels: coagulants.map(p => p.name.split(' ')[0]), // Short names
                datasets: [{
                    label: 'Turbidity Removal (%)',
                    data: coagulants.map(p => p.effectiveness),
                    backgroundColor: '#0ea5e9',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `Efficiency: ${ctx.raw}%`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: { display: true, text: 'Removal %' }
                    }
                }
            }
        });

        // Chart 2: Cost Analysis (Scatter) - Simulated Price vs Concentration
        // We map generic price indices to visual coordinates
        const ctxCost = document.getElementById('costChart').getContext('2d');
        
        const scatterData = globalProducts.map(p => ({
            x: parseInt(p.purity), // Concentration
            y: p.price_index * 10, // Simulated Price unit
            name: p.name,
            category: p.category
        })).filter(d => !isNaN(d.x)); // Filter out text purities like "Iodine"

        new Chart(ctxCost, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Chemicals',
                    data: scatterData,
                    backgroundColor: (ctx) => {
                        const cat = ctx.raw?.category;
                        if(cat === 'Coagulation') return '#0ea5e9';
                        if(cat === 'Disinfection') return '#10b981';
                        return '#8b5cf6';
                    },
                    pointRadius: 8,
                    pointHoverRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.raw.name} (${ctx.raw.x}%)`
                        }
                    },
                    legend: { display: false } // Custom legend implied by color logic context
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Active Concentration (%)' }
                    },
                    y: {
                        title: { display: true, text: 'Relative Cost Index' },
                        display: false // Hide y axis labels for cleaner abstract view
                    }
                }
            }
        });
    }
</script>

<?php include 'includes/footer.php'; ?>
