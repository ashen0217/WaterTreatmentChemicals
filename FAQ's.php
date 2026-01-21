<?php
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs | HydroChem Pro</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-50">
    <!-- Header Component -->
    <custom-header></custom-header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Find answers to common questions about our water treatment solutions and services.</p>
            <div class="w-24 h-1 bg-brand-600 mx-auto mt-6"></div>
        </div>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-8 border-b border-gray-200 bg-gray-50">
                <h2 class="text-2xl font-bold text-gray-900">Product Questions</h2>
            </div>

            <div class="divide-y divide-gray-200">
                <!-- FAQ Item -->
                <div class="p-8">
                    <button class="faq-toggle w-full flex justify-between items-center text-left group" aria-expanded="false">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition-colors">
                            What types of water treatment chemicals do you offer?
                        </h3>
                        <i data-feather="chevron-down" class="text-gray-500 group-hover:text-brand-600 transition-transform duration-200"></i>
                    </button>
                    <div class="faq-content mt-4 hidden">
                        <div class="text-gray-700 space-y-4">
                            <p>We provide a comprehensive range of industrial-grade water treatment chemicals including:</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>Coagulants:</strong> Poly Aluminium Chloride (PAC), Aluminium Sulfate, Ferric Chloride</li>
                                <li><strong>Disinfectants:</strong> Sodium Hypochlorite, Chlorine Dioxide, Hydrogen Peroxide</li>
                                <li><strong>pH Adjusters:</strong> Caustic Soda, Soda Ash, Sulfuric Acid</li>
                                <li><strong>Specialty Chemicals:</strong> Anti-scalants, Corrosion Inhibitors, Flocculants</li>
                            </ul>
                            <p>All our products meet or exceed industry purity standards and come with detailed technical specifications.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="p-8">
                    <button class="faq-toggle w-full flex justify-between items-center text-left group" aria-expanded="false">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition-colors">
                            How do I determine the right chemical for my water treatment needs?
                        </h3>
                        <i data-feather="chevron-down" class="text-gray-500 group-hover:text-brand-600 transition-transform duration-200"></i>
                    </button>
                    <div class="faq-content mt-4 hidden">
                        <div class="text-gray-700 space-y-4">
                            <p>Selecting the appropriate chemical depends on several factors:</p>
                            <ol class="list-decimal pl-6 space-y-2">
                                <li><strong>Water Analysis:</strong> Conduct a complete water analysis to identify contaminants</li>
                                <li><strong>Treatment Goals:</strong> Clarify whether you need coagulation, disinfection, pH adjustment, etc.</li>
                                <li><strong>System Compatibility:</strong> Consider your existing treatment system's specifications</li>
                                <li><strong>Regulatory Requirements:</strong> Ensure compliance with local water quality standards</li>
                            </ol>
                            <p>Our technical team offers free consultation services to help you select the optimal chemical solution based on your specific water profile and treatment objectives.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="p-8">
                    <button class="faq-toggle w-full flex justify-between items-center text-left group" aria-expanded="false">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition-colors">
                            What safety measures should be taken when handling your chemicals?
                        </h3>
                        <i data-feather="chevron-down" class="text-gray-500 group-hover:text-brand-600 transition-transform duration-200"></i>
                    </button>
                    <div class="faq-content mt-4 hidden">
                        <div class="text-gray-700 space-y-4">
                            <p>All our chemicals come with detailed Material Safety Data Sheets (MSDS). General safety precautions include:</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>Always wear appropriate PPE (gloves, goggles, protective clothing)</li>
                                <li>Store chemicals in properly labeled, corrosion-resistant containers</li>
                                <li>Ensure adequate ventilation in storage and handling areas</li>
                                <li>Never mix chemicals unless directed by our technical team</li>
                                <li>Have emergency wash stations and spill kits readily available</li>
                                <li>Train all personnel in proper handling procedures</li>
                            </ul>
                            <p>We provide complimentary safety training sessions with large chemical orders.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 border-t border-b border-gray-200 bg-gray-50">
                <h2 class="text-2xl font-bold text-gray-900">Ordering & Delivery</h2>
            </div>

            <div class="divide-y divide-gray-200">
                <!-- FAQ Item -->
                <div class="p-8">
                    <button class="faq-toggle w-full flex justify-between items-center text-left group" aria-expanded="false">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition-colors">
                            What are your minimum order quantities?
                        </h3>
                        <i data-feather="chevron-down" class="text-gray-500 group-hover:text-brand-600 transition-transform duration-200"></i>
                    </button>
                    <div class="faq-content mt-4 hidden">
                        <div class="text-gray-700 space-y-4">
                            <p>Our minimum order quantities vary by product and packaging:</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>Liquid Chemicals:</strong> Minimum 250L (55-gallon drum) or bulk tanker (20,000L+)</li>
                                <li><strong>Powder/Granular:</strong> Minimum 25kg bag or 1 metric ton pallet</li>
                                <li><strong>Specialty Chemicals:</strong> Case quantities (typically 4 x 20L or equivalent)</li>
                            </ul>
                            <p>For first-time customers, we may accept smaller trial quantities to evaluate product performance before committing to larger orders.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="p-8">
                    <button class="faq-toggle w-full flex justify-between items-center text-left group" aria-expanded="false">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition-colors">
                            Do you offer emergency delivery services?
                        </h3>
                        <i data-feather="chevron-down" class="text-gray-500 group-hover:text-brand-600 transition-transform duration-200"></i>
                    </button>
                    <div class="faq-content mt-4 hidden">
                        <div class="text-gray-700 space-y-4">
                            <p>Yes, we understand that water treatment emergencies can occur. We offer:</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>24/7 Emergency Hotline:</strong> +1 (800) 555-EMER (3637)</li>
                                <li><strong>Same-Day Delivery:</strong> Available for most locations within 300 miles of our regional distribution centers</li>
                                <li><strong>Emergency Kits:</strong> Pre-packaged emergency response kits for common scenarios</li>
                            </ul>
                            <p>Emergency service fees apply but are waived for customers with our Premium Service Agreement.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="p-8">
                    <button class="faq-toggle w-full flex justify-between items-center text-left group" aria-expanded="false">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition-colors">
                            What is your return policy for chemical products?
                        </h3>
                        <i data-feather="chevron-down" class="text-gray-500 group-hover:text-brand-600 transition-transform duration-200"></i>
                    </button>
                    <div class="faq-content mt-4 hidden">
                        <div class="text-gray-700 space-y-4">
                            <p>Due to the nature of chemical products, our return policy is as follows:</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>Unopened Containers:</strong> May be returned within 30 days for full credit (less shipping)</li>
                                <li><strong>Opened Containers:</strong> Generally not returnable except for documented quality issues</li>
                                <li><strong>Bulk Deliveries:</strong> Non-returnable unless contamination or specification variance is confirmed by our lab</li>
                            </ul>
                            <p>We strongly recommend ordering samples or small test quantities before large purchases. Our technical team can help you estimate your chemical usage requirements.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 border-t border-b border-gray-200 bg-gray-50">
                <h2 class="text-2xl font-bold text-gray-900">Technical Support</h2>
            </div>

            <div class="divide-y divide-gray-200">
                <!-- FAQ Item -->
                <div class="p-8">
                    <button class="faq-toggle w-full flex justify-between items-center text-left group" aria-expanded="false">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition-colors">
                            Do you provide on-site technical support?
                        </h3>
                        <i data-feather="chevron-down" class="text-gray-500 group-hover:text-brand-600 transition-transform duration-200"></i>
                    </button>
                    <div class="faq-content mt-4 hidden">
                        <div class="text-gray-700 space-y-4">
                            <p>Yes, we offer comprehensive technical support services:</p>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><strong>Remote Support:</strong> 24/7 phone and video consultation with our chemical engineers</li>
                                <li><strong>On-Site Visits:</strong> Available for system audits, startup assistance, and troubleshooting</li>
                                <li><strong>Training Programs:</strong> Customized training for your operations team</li>
                                <li><strong>Process Optimization:</strong> Full system evaluations to improve efficiency</li>
                            </ul>
                            <p>Basic technical support is included with all orders. Premium support packages are available for facilities requiring regular on-site assistance.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="p-8">
                    <button class="faq-toggle w-full flex justify-between items-center text-left group" aria-expanded="false">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition-colors">
                            How often should we test our water when using your chemicals?
                        </h3>
                        <i data-feather="chevron-down" class="text-gray-500 group-hover:text-brand-600 transition-transform duration-200"></i>
                    </button>
                    <div class="faq-content mt-4 hidden">
                        <div class="text-gray-700 space-y-4">
                            <p>Testing frequency depends on your system size and regulatory requirements, but we generally recommend:</p>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parameter</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Minimum Frequency</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">pH</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">Continuous monitoring or hourly tests</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">Residual Disinfectant</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">Hourly for critical systems</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">Turbidity</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">Every 4 hours</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">Complete Chemical Analysis</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">Weekly to monthly</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>We can provide customized testing schedules based on your specific treatment process and water source characteristics.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-gray-50 text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Still have questions?</h3>
                <p class="text-gray-700 mb-6">Our water treatment experts are ready to help you find the right solutions.</p>
                <a href="contact.html" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-brand-600 hover:bg-brand-700">
                    Contact Our Team
                    <i data-feather="arrow-right" class="ml-2"></i>
                </a>
            </div>
        </div>
    </main>
</body>
</html>
<?php include 'includes/footer.php'; ?>