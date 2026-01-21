<?php


include 'includes/header.php';
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- SECTION 4: Dosage Calculator -->
    <section id="calculator-section" class="bg-brand-900 rounded-3xl text-white overflow-hidden shadow-2xl relative">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-accent-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-10 flex flex-col justify-center border-r border-brand-700">
                <h2 class="text-3xl font-bold mb-4">Chemical Dosage Calculator</h2>
                <p class="text-brand-100 mb-8">
                    Estimate the daily chemical requirement for your plant. Accurate dosing is critical for cost efficiency and water safety.
                </p>
                <ul class="space-y-4 text-sm text-brand-200">
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-700 flex items-center justify-center text-xs">1</span>
                        Enter your daily water flow.
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-700 flex items-center justify-center text-xs">2</span>
                        Input desired dosage (PPM).
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-brand-700 flex items-center justify-center text-xs">3</span>
                        Select chemical concentration.
                    </li>
                </ul>
            </div>

            <div class="p-10 bg-brand-800">
                <form onsubmit="event.preventDefault(); calculateDosage();" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-brand-100 mb-1">Water Volume (Liters/Day)</label>
                        <input type="number" id="calc-volume" value="100000" class="w-full px-4 py-2 bg-brand-900 border border-brand-600 rounded-lg focus:ring-accent-500 focus:border-accent-500 text-white placeholder-brand-400">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-brand-100 mb-1">Target Dosage (PPM)</label>
                            <input type="number" id="calc-ppm" value="15" class="w-full px-4 py-2 bg-brand-900 border border-brand-600 rounded-lg focus:ring-accent-500 focus:border-accent-500 text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-brand-100 mb-1">Active Strength (%)</label>
                            <input type="number" id="calc-strength" value="90" max="100" class="w-full px-4 py-2 bg-brand-900 border border-brand-600 rounded-lg focus:ring-accent-500 focus:border-accent-500 text-white">
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-brand-700">
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-sm text-brand-300">Required Amount:</p>
                                <p id="calc-result" class="text-4xl font-bold text-white">1.67 <span class="text-lg text-brand-300 font-normal">kg/day</span></p>
                            </div>
                            <button type="submit" class="bg-accent-500 hover:bg-accent-600 text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-lg">
                                Calculate
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
    // --- CALCULATOR LOGIC ---
    function calculateDosage() {
        // Formula: (Volume (L) * PPM) / (Strength% * 10000) = kg required
        // Adjusted: (Volume * PPM) / (1,000,000) = kg (pure)
        // kg (commercial) = kg (pure) / (Strength / 100)
        
        const volume = parseFloat(document.getElementById('calc-volume').value) || 0;
        const ppm = parseFloat(document.getElementById('calc-ppm').value) || 0;
        const strength = parseFloat(document.getElementById('calc-strength').value) || 100;

        if (volume > 0 && strength > 0) {
            const kgPure = (volume * ppm) / 1000000;
            const kgCommercial = kgPure / (strength / 100);
            document.getElementById('calc-result').innerHTML = `${kgCommercial.toFixed(2)} <span class="text-lg text-brand-300 font-normal">kg/day</span>`;
        } else {
            document.getElementById('calc-result').innerText = "---";
        }
    }
    
    // Add listeners to calc inputs for real-time update
    document.addEventListener('DOMContentLoaded', () => {
        calculateDosage();
        ['calc-volume', 'calc-ppm', 'calc-strength'].forEach(id => {
            document.getElementById(id).addEventListener('input', calculateDosage);
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
