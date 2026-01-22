<?php
$page_title = 'Contact Us';
include 'includes/header.php';
?>

<main class="flex-grow">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-800 to-brand-900 text-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center animate-fade-in-up">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl text-white drop-shadow-lg">
                Get In Touch
            </h1>
            <p class="mt-6 text-xl text-brand-50 max-w-3xl mx-auto">
                Have questions about our water treatment solutions? Our team of experts is here to help you find the perfect chemical solutions for your needs.
            </p>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="card-3d bg-white p-8 animate-slide-in-left">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
                    
                    <form id="contactForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                            </div>
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                                <input type="text" id="company" name="company" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                            <select id="subject" name="subject" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm">
                                <option value="">Select a subject</option>
                                <option value="Product Inquiry">Product Inquiry</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Pricing & Quotes">Pricing & Quotes</option>
                                <option value="Partnership Opportunities">Partnership Opportunities</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                            <textarea id="message" name="message" rows="6" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 transition-all duration-300 focus:shadow-3d-sm resize-none"></textarea>
                        </div>

                        <div>
                            <button type="submit" id="submitBtn" class="btn-primary w-full md:w-auto">
                                <span id="btnText">Send Message</span>
                            </button>
                        </div>
                    </form>

                    <!-- Message Display -->
                    <div id="formMessage" class="hidden mt-4"></div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-6 animate-slide-in-right">
                <!-- Contact Details Card -->
                <div class="card-3d bg-white p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0 shadow-3d-sm">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Phone</p>
                                <p class="text-sm text-gray-600">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0 shadow-3d-sm">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Email</p>
                                <p class="text-sm text-gray-600">info@hydrochempro.com</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-brand-100 rounded-lg flex items-center justify-center flex-shrink-0 shadow-3d-sm">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Address</p>
                                <p class="text-sm text-gray-600">123 Chemical Drive<br>Industrial Park, State 12345</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Hours Card -->
                <div class="card-3d bg-white p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Business Hours</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Monday - Friday</span>
                            <span class="font-medium text-gray-900">8:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Saturday</span>
                            <span class="font-medium text-gray-900">9:00 AM - 2:00 PM</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Sunday</span>
                            <span class="font-medium text-gray-900">Closed</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-500">
                            <strong>24/7 Emergency Support:</strong> For urgent technical assistance, call our emergency hotline.
                        </p>
                    </div>
                </div>

                <!-- Quick Links Card -->
                <div class="card-3d bg-gradient-to-br from-brand-500 to-brand-600 p-6 text-white">
                    <h3 class="text-lg font-bold mb-4">Need Immediate Help?</h3>
                    <div class="space-y-3">
                        <a href="chemicalProducts.php" class="block w-full px-4 py-3 bg-white/20 backdrop-blur-sm rounded-lg hover:bg-white/30 transition-all duration-300 text-center font-medium ">
                            Browse Products
                        </a>
                        <a href="chemicalProducts.php" class="block w-full px-4 py-3 bg-white/20 backdrop-blur-sm rounded-lg hover:bg-white/30 transition-all duration-300 text-center font-medium ">
                            Browse Products
                        </a>
                        <a href="chemicalProducts.php" class="block w-full px-4 py-3 bg-white/20 backdrop-blur-sm rounded-lg hover:bg-white/30 transition-all duration-300 text-center font-medium ">
                            Browse Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
const contactForm = document.getElementById('contactForm');
const formMessage = document.getElementById('formMessage');
const submitBtn = document.getElementById('submitBtn');
const btnText = document.getElementById('btnText');

contactForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    
    // Show loading state
    btnText.textContent = 'Sending...';
    submitBtn.disabled = true;
    formMessage.className = 'hidden';
    
    // Prepare form data
    const formData = new FormData(event.target);
    formData.append("access_key", "ee2a13d2-c198-4c6f-95b6-826790c23996");
    
    try {
        const response = await fetch("https://api.web3forms.com/submit", {
            method: "POST",
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Show success message
            formMessage.className = 'mt-4 bg-green-50 border-l-4 border-green-500 p-4 rounded animate-fade-in-up';
            formMessage.innerHTML = `
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-700 text-sm">Thank you for your message! We'll get back to you within 24 hours.</p>
                </div>
            `;
            
            // Reset form
            contactForm.reset();
            
            // Hide message after 5 seconds
            setTimeout(() => {
                formMessage.className = 'hidden';
            }, 5000);
        } else {
            // Show error message
            console.error("Error", data);
            formMessage.className = 'mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded animate-fade-in-up';
            formMessage.innerHTML = `
                <div class="flex">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-700 text-sm">${data.message || 'Failed to send message. Please try again.'}</p>
                </div>
            `;
        }
    } catch (error) {
        console.error("Error submitting form:", error);
        formMessage.className = 'mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded animate-fade-in-up';
        formMessage.innerHTML = `
            <div class="flex">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-700 text-sm">Failed to submit form. Please try again.</p>
            </div>
        `;
    } finally {
        // Reset button state
        btnText.textContent = 'Send Message';
        submitBtn.disabled = false;
    }
});
</script>


<?php include 'includes/footer.php'; ?>
