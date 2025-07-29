<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <span class="ml-3 text-xl font-bold">YourBrand</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Kami adalah perusahaan yang berkomitmen untuk memberikan produk dan layanan terbaik untuk pelanggan kami.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300">
                        <i class="fab fa-linkedin-in text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition duration-300 text-sm">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition duration-300 text-sm">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i> About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('katalog.index') }}" class="text-gray-400 hover:text-white transition duration-300 text-sm">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i> Katalog
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition duration-300 text-sm">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Contact Info</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-blue-400 mt-1 mr-3"></i>
                        <span class="text-gray-400 text-sm">
                            Jl. Contoh No. 123<br>
                            Jakarta, Indonesia 12345
                        </span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone text-blue-400 mr-3"></i>
                        <span class="text-gray-400 text-sm">+62 123 456 789</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope text-blue-400 mr-3"></i>
                        <span class="text-gray-400 text-sm">info@yourbrand.com</span>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Newsletter</h3>
                <p class="text-gray-400 text-sm">
                    Berlangganan newsletter kami untuk mendapatkan update terbaru.
                </p>
                <form class="space-y-3">
                    <div class="relative">
                        <input type="email"
                               placeholder="Email address"
                               class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none text-sm">
                    </div>
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-blue-600 hover:to-purple-700 transition duration-300">
                        <i class="fas fa-paper-plane mr-1"></i> Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">
                    © {{ date('Y') }} YourBrand. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
