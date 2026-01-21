<?php
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | HydroChem Pro</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-50">
    <!-- Header Component -->
    <custom-header></custom-header>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-900 to-brand-800 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900 to-brand-800 opacity-90"></div>
        <!-- Decorative Elements -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Privacy Policy</h1>
            <p class="text-xl text-brand-100 max-w-2xl mx-auto">Your trust is important to us. Learn how we protect your information.</p>
            <div class="w-24 h-1 bg-brand-300 mx-auto mt-6"></div>
        </div>
    </div>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 info-card">
            <div class="p-8 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50">
                <h2 class="text-2xl font-bold text-gray-900">Last Updated: June 2023</h2>
                <p class="text-gray-600 mt-2">This policy explains how we collect, use, and protect your information.</p>
            </div>

            <div class="p-8 space-y-8">
                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i data-feather="shield" class="mr-2 text-brand-600"></i>
                        Information We Collect
                    </h3>
                    <p class="text-gray-700 mb-4">We collect information to provide better services to all our users. The types of information we collect include:</p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700">
                        <li><strong>Contact Information:</strong> Name, email, phone number when you inquire about our services</li>
                        <li><strong>Business Information:</strong> Company name, facility size, water treatment needs</li>
                        <li><strong>Technical Data:</strong> IP address, browser type, pages visited on our website</li>
                        <li><strong>Usage Data:</strong> How you use our website and services</li>
                    </ul>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i data-feather="lock" class="mr-2 text-brand-600"></i>
                        How We Use Your Information
                    </h3>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700">
                        <li>To provide and maintain our water treatment services</li>
                        <li>To notify you about changes to our services</li>
                        <li>To allow you to participate in interactive features of our service</li>
                        <li>To provide customer support</li>
                        <li>To gather analysis or valuable information so that we can improve our services</li>
                        <li>To monitor the usage of our service</li>
                        <li>To detect, prevent and address technical issues</li>
                    </ul>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i data-feather="database" class="mr-2 text-brand-600"></i>
                        Data Security
                    </h3>
                    <p class="text-gray-700 mb-4">We implement appropriate technical and organizational measures to protect personal data against accidental or unlawful destruction, loss, alteration, unauthorized disclosure or access.</p>
                    <p class="text-gray-700">All chemical formulation data and client information is stored on secure servers with enterprise-grade encryption. Our team undergoes regular security training to ensure your data remains protected.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i data-feather="share-2" class="mr-2 text-brand-600"></i>
                        Third-Party Sharing
                    </h3>
                    <p class="text-gray-700 mb-4">We may share your information with:</p>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700">
                        <li>Service providers who assist in our business operations (payment processing, analytics, etc.)</li>
                        <li>Regulatory bodies when required by law for water treatment compliance</li>
                        <li>Business partners for joint water treatment solutions (with your consent)</li>
                    </ul>
                    <p class="text-gray-700 mt-4">We never sell your personal information to third parties.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i data-feather="cookie" class="mr-2 text-brand-600"></i>
                        Cookies & Tracking
                    </h3>
                    <p class="text-gray-700 mb-4">We use cookies and similar tracking technologies to track activity on our website and hold certain information to improve your experience.</p>
                    <p class="text-gray-700">You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, some features of our website may not function properly without cookies.</p>
                </section>

                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i data-feather="mail" class="mr-2 text-brand-600"></i>
                        Contact Us
                    </h3>
                    <p class="text-gray-700">For any questions about this Privacy Policy, please contact our Data Protection Officer:</p>
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700"><strong>Email:</strong> privacy@hydrochempro.com</p>
                        <p class="text-gray-700"><strong>Phone:</strong> +1 (800) 555-WATER</p>
                        <p class="text-gray-700"><strong>Address:</strong> 123 Clean Water Ave, Suite 500, Pureville, PV 98765</p>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script>
        // Initialize Feather Icons
        feather.replace();
    </script>
</body>
</html>

<?php include 'includes/footer.php'; ?>