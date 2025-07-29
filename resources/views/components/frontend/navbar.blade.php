<nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-store text-white text-lg"></i>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-800">YourBrand</span>
                    </a>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}"
                   class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300 {{ request()->routeIs('home') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <a href="{{ route('about') }}"
                   class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300 {{ request()->routeIs('about') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                    <i class="fas fa-info-circle mr-1"></i> About
                </a>
                <a href="{{ route('katalog.index') }}"
                   class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300 {{ request()->routeIs('katalog.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                    <i class="fas fa-th-large mr-1"></i> Katalog
                </a>
                <a href="{{ route('contact') }}"
                   class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-300 {{ request()->routeIs('contact') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                    <i class="fas fa-envelope mr-1"></i> Contact
                </a>

                <!-- CTA Button -->
                <a href="{{ route('katalog.index') }}"
                   class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-medium hover:from-blue-600 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                    <i class="fas fa-shopping-cart mr-1"></i> Shop Now
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600 p-2">
                    <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-xl" x-show="mobileMenuOpen"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="md:hidden bg-white border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition duration-300 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                <i class="fas fa-home mr-2"></i> Home
            </a>
            <a href="{{ route('about') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition duration-300 {{ request()->routeIs('about') ? 'text-blue-600 bg-blue-50' : '' }}">
                <i class="fas fa-info-circle mr-2"></i> About
            </a>
            <a href="{{ route('katalog.index') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition duration-300 {{ request()->routeIs('katalog.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                <i class="fas fa-th-large mr-2"></i> Katalog
            </a>
            <a href="{{ route('contact') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition duration-300 {{ request()->routeIs('contact') ? 'text-blue-600 bg-blue-50' : '' }}">
                <i class="fas fa-envelope mr-2"></i> Contact
            </a>
            <div class="pt-2">
                <a href="{{ route('katalog.index') }}"
                   class="block mx-3 px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full text-center font-medium hover:from-blue-600 hover:to-purple-700 transition duration-300">
                    <i class="fas fa-shopping-cart mr-1"></i> Shop Now
                </a>
            </div>
        </div>
    </div>
</nav>
