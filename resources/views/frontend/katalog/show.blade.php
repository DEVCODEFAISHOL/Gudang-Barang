@extends('layouts.frontend')

@section('title', 'Product Detail - YourBrand')

@section('content')
    <!-- Product Detail Section -->
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
                            <a href="{{ route('katalog.index') }}" class="text-gray-700 hover:text-blue-600">Katalog</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500">{{ $barang->nama }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Product Detail -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama }}"
                            class="w-full max-w-md rounded-lg shadow-lg">
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $barang->nama }}</h1>
                        <p class="text-gray-600 mb-4">{{ $barang->deskripsi }}</p>
                        <div class="flex items-center mb-4">
                            <span class="text-2xl font-bold text-purple-600">Rp
                                {{ number_format($barang->harga, 0, ',', '.') }}</span>
                            <span class="ml-4 text-gray-500 text-sm">Stok: {{ $barang->stok }}</span>
                        </div>
                        <div class="flex space-x-4">
                            <button
                                class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-blue-600 hover:to-purple-700 transition duration-300">
                                <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                            </button>
                            <button
                                class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition duration-300">
                                <i class="fas fa-heart mr-2"></i> Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Products Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                    <div class="card-hover bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                            <img src="{{ asset('storage/' . $related->gambar) }}" alt="{{ $related->nama }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $related->nama }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($related->deskripsi, 50) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-purple-600">Rp {{ number_format($related->harga, 0, ',', '.') }}</span>
                                <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-purple-700 transition duration-300">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('katalog.index') }}"
                   class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-4 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition duration-300 transform hover:scale-105 inline-block">
                    <i class="fas fa-eye mr-2"></i> View All Products
                </a>
            </div>
        </div>
    </section>
@endsection
