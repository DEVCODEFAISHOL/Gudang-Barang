@extends('layouts.frontend')

@section('title', 'Katalog Produk - YourBrand')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-fade-in text-white">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Product Catalog</h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto">
                Temukan berbagai produk berkualitas tinggi dengan harga terjangkau
            </p>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="py-8 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
            <!-- Search Bar -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text"
                           placeholder="Search products..."
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Options -->
            <div class="flex flex-wrap gap-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>All Categories</option>
                    <option>Electronics</option>
                    <option>Fashion</option>
                    <option>Home & Garden</option>
                    <option>Sports</option>
                    <option>Books</option>
                </select>

                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Price Range</option>
                    <option>Under Rp 100,000</option>
                    <option>Rp 100,000 - Rp 500,000</option>
                    <option>Rp 500,000 - Rp 1,000,000</option>
                    <option>Above Rp 1,000,000</option>
                </select>

                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Sort By</option>
                    <option>Latest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Most Popular</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 inline-flex items-center">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">Katalog</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @php
                $products = [
                    ['name' => 'Smartphone Premium', 'price' => 2500000, 'category' => 'Electronics', 'rating' => 4.8],
                    ['name' => 'Wireless Headphones', 'price' => 750000, 'category' => 'Electronics', 'rating' => 4.6],
                    ['name' => 'Designer T-Shirt', 'price' => 125000, 'category' => 'Fashion', 'rating' => 4.4],
                    ['name' => 'Coffee Maker', 'price' => 350000, 'category' => 'Home & Garden', 'rating' => 4.7],
                    ['name' => 'Running Shoes', 'price' => 800000, 'category' => 'Sports', 'rating' => 4.9],
                    ['name' => 'Bluetooth Speaker', 'price' => 450000, 'category' => 'Electronics', 'rating' => 4.5],
                    ['name' => 'Casual Jacket', 'price' => 275000, 'category' => 'Fashion', 'rating' => 4.3],
                    ['name' => 'Kitchen Set', 'price' => 650000, 'category' => 'Home & Garden', 'rating' => 4.6],
                    ['name' => 'Gaming Mouse', 'price' => 225000, 'category' => 'Electronics', 'rating' => 4.8],
                    ['name' => 'Yoga Mat', 'price' => 95000, 'category' => 'Sports', 'rating' => 4.4],
                    ['name' => 'Leather Wallet', 'price' => 175000, 'category' => 'Fashion', 'rating' => 4.7],
                    ['name' => 'Air Purifier', 'price' => 1200000, 'category' => 'Home & Garden', 'rating' => 4.9]
                ];
            @endphp

            @foreach($products as $index => $product)
            <div class="card-hover bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Product Image -->
                <div class="relative h-56 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                    <i class="fas fa-box text-4xl text-gray-400"></i>
                    <!-- Badge -->
                    @if($index < 3)
                    <div class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $index == 0 ? 'Best Seller' : ($index == 1 ? 'New' : 'Sale') }}
                    </div>
                    @endif
                    <!-- Wishlist Button -->
                    <button class="absolute top-3 right-3 w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition duration-300">
                        <i class="far fa-heart text-gray-600 hover:text-red-500"></i>
                    </button>
                </div>

                <!-- Product Info -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded">
                            {{ $product['category'] }}
                        </span>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($product['rating']) ? '' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-1">({{ $product['rating'] }})</span>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600 transition duration-300">
                        <a href="{{ route('katalog.show', $index + 1) }}">{{ $product['name'] }}</a>
                    </h3>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        Produk berkualitas tinggi dengan fitur terdepan dan desain yang menarik untuk memenuhi kebutuhan sehari-hari Anda.
                    </p>

                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            @if($index < 4)
                            <span class="text-sm text-gray-400 line-through">Rp {{ number_format($product['price'] + 50000, 0, ',', '.') }}</span>
                            @endif
                            <span class="text-xl font-bold text-purple-600">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                        </div>

                        <div class="flex gap-2">
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-lg transition duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                                <i class="fas fa-cart-plus mr-1"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-12">
            <nav class="flex items-center space-x-2">
                <button class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition duration-300">
                    <i class="fas fa-chevron-left"></i>
                </button>

                @for($i = 1; $i <= 5; $i++)
                <button class="px-4 py-2 {{ $i == 1 ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition duration-300">
                    {{ $i }}
                </button>
                @endfor

                <button class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition duration-300">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </nav>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 gradient-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-white">
            <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
            <p class="text-xl text-gray-200 mb-8">
                Dapatkan notifikasi produk terbaru dan penawaran khusus
            </p>
            <div class="max-w-md mx-auto">
                <div class="flex gap-3">
                    <input type="email"
                           placeholder="Enter your email"
                           class="flex-1 px-4 py-3 rounded-full border-0 focus:ring-2 focus:ring-white/50 focus:outline-none">
                    <button class="bg-white text-purple-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition duration-300">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Add smooth scrolling and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('input[placeholder="Search products..."]');
    const productCards = document.querySelectorAll('.card-hover');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            productCards.forEach(card => {
                const productName = card.querySelector('h3').textContent.toLowerCase();
                if (productName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Wishlist functionality
    const wishlistButtons = document.querySelectorAll('.fa-heart');
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('far');
            this.classList.toggle('fas');
            this.classList.toggle('text-red-500');
        });
    });
});
</script>
@endpush
