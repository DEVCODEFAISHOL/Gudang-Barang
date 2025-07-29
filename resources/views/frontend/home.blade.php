@extends('layouts.frontend')

@section('title', 'Dashboard - PT. Anugerah Inovasi Sejahtera')

@section('content')
    <!-- Hero Section - Company Overview -->
    <section
        class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 min-h-screen flex items-center relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60"
                viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" fill-rule="evenodd">
                    <g fill="%23ffffff" fill-opacity="0.1">
                        <rect width="11" height="11" rx="2" />
                        <rect x="20" y="20" width="11" height="11" rx="2" />
                        <rect x="40" y="40" width="11" height="11" rx="2" />
                    </g>
                </g></svg>');">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="text-white">
                    <div class="mb-6">
                        <span
                            class="inline-block bg-blue-600/20 text-blue-200 px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm border border-blue-400/20">
                            Inventory Management System
                        </span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">
                            PT. Anugerah
                        </span>
                        <br>
                        <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
                            Inovasi Sejahtera
                        </span>
                    </h1>
                    <p class="text-xl mb-8 text-blue-100 leading-relaxed max-w-2xl">
                        Sistem manajemen inventori modern yang membantu perusahaan mengelola aset, stok, dan permintaan
                        barang dengan efisien dan akurat.
                    </p>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-2xl font-bold text-white">{{ number_format($stats['total_items']) }}</div>
                            <div class="text-blue-200 text-sm">Total Items</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-2xl font-bold text-yellow-400">{{ number_format($stats['low_stock_items']) }}
                            </div>
                            <div class="text-blue-200 text-sm">Low Stock Alert</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('katalog.index') }}"
                            class="bg-white text-blue-900 px-8 py-4 rounded-xl font-semibold hover:bg-blue-50 transition duration-300 transform hover:scale-105 text-center shadow-lg">
                            <i class="fas fa-boxes mr-2"></i> View Inventory
                        </a>
                        <a href="{{ route('about') }}"
                            class="border-2 border-white/30 text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/10 transition duration-300 text-center backdrop-blur-sm">
                            <i class="fas fa-info-circle mr-2"></i> Learn More
                        </a>
                    </div>
                </div>

                <!-- Dashboard Preview -->
                <div class="relative">
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 shadow-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-white font-semibold text-lg">Inventory Overview</h3>
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        </div>

                        <!-- Mock Chart -->
                        <div class="space-y-4">
                            @foreach ($inventoryByCategory->take(4) as $category)
                                <div class="flex items-center justify-between">
                                    <span class="text-blue-200 text-sm">{{ $category['name'] }}</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-20 h-2 bg-white/20 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-blue-400 to-purple-400 rounded-full"
                                                style="width: {{ min(($category['total_stock'] / 100) * 100, 100) }}%">
                                            </div>
                                        </div>
                                        <span class="text-white text-sm font-medium">{{ $category['total_stock'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div
                        class="absolute -top-6 -right-6 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl p-4 shadow-lg animate-bounce">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <div
                        class="absolute -bottom-6 -left-6 bg-gradient-to-r from-green-400 to-teal-400 rounded-2xl p-4 shadow-lg animate-pulse">
                        <i class="fas fa-warehouse text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Key Features</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Fitur-fitur unggulan sistem inventory management yang membantu optimalisasi operasional perusahaan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-boxes text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Inventory Tracking</h3>
                    <p class="text-gray-600">
                        Pantau stok barang secara real-time dengan sistem tracking yang akurat dan notifikasi otomatis untuk
                        stok rendah.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-clipboard-list text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Request Management</h3>
                    <p class="text-gray-600">
                        Kelola permintaan barang dari berbagai departemen dengan sistem approval dan tracking yang
                        terstruktur.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Analytics & Reports</h3>
                    <p class="text-gray-600">
                        Dapatkan insights mendalam dengan laporan komprehensif dan analisis tren penggunaan inventori.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Low Stock Alerts</h3>
                    <p class="text-gray-600">
                        Sistem peringatan otomatis untuk mencegah kehabisan stok dan memastikan kontinuitas operasional.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-tags text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Category Management</h3>
                    <p class="text-gray-600">
                        Organisasi inventori yang efisien dengan sistem kategorisasi yang fleksibel dan mudah dikelola.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">User Management</h3>
                    <p class="text-gray-600">
                        Kontrol akses berbasis role dengan sistem permission yang aman dan audit trail lengkap.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Low Stock Alert Section -->
    @if ($lowStockItems->count() > 0)
        <section class="py-20 bg-red-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center bg-red-100 text-red-800 px-6 py-3 rounded-full mb-4">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="font-semibold">Low Stock Alert</span>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Items Requiring Attention</h2>
                    <p class="text-xl text-gray-600">
                        Barang-barang berikut memiliki stok rendah dan memerlukan perhatian segera
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($lowStockItems as $item)
                        <div
                            class="bg-white rounded-xl shadow-lg border-l-4 border-red-500 p-6 hover:shadow-xl transition duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item->nama_barang }}</h3>
                                    <span class="text-sm text-gray-500">{{ $item->kode_barang }}</span>
                                    @if ($item->kategori)
                                        <div class="mt-2">
                                            <span
                                                class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                                                {{ $item->kategori->nama_kategori }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-red-600">{{ $item->stok }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->satuan }}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-red-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <span class="text-sm font-medium">Critical Level</span>
                                </div>
                                <a href="{{ route('katalog.show', $item->kode_barang) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Recent Items Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Recently Added Items</h2>
                <p class="text-xl text-gray-600">Item terbaru yang ditambahkan ke dalam sistem inventory</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($recentItems as $item)
                    <div
                        class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition duration-300 group">
                        <div
                            class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden">
                            @if ($item->gambar && file_exists(public_path('storage/' . $item->gambar)))
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_barang }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <i class="fas fa-cube text-4xl text-gray-400"></i>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="mb-3">
                                @if ($item->kategori)
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                        {{ $item->kategori->nama_kategori }}
                                    </span>
                                @endif
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full ml-1">
                                    New
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->nama_barang }}</h3>
                            <p class="text-sm text-gray-500 mb-3">{{ $item->kode_barang }}</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-lg font-bold text-gray-900">
                                        {{ $item->stok->jumlah_stok ?? 0 }} {{ $item->satuan }}
                                    </div>
                                    <div class="text-sm text-gray-500">Available Stock</div>
                                </div>
                                <a href="{{ route('katalog.show', $item->kode_barang) }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 text-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl text-gray-500">No recent items found</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('katalog.index') }}"
                    class="bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition duration-300 transform hover:scale-105 inline-block">
                    <i class="fas fa-boxes mr-2"></i> View Full Inventory
                </a>
            </div>
        </div>
    </section>

    <!-- Categories Overview -->
    @if ($categories->count() > 0)
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Inventory Categories</h2>
                    <p class="text-xl text-gray-600">Jelajahi inventori berdasarkan kategori yang tersedia</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach ($categories as $kategori)
                        <a href="{{ route('katalog.index', ['kategori' => $kategori->id]) }}"
                            class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 text-center group">
                            <div
                                class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                                <i class="fas fa-layer-group text-white text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 text-sm mb-2">{{ $kategori->nama_kategori }}</h3>
                            <div class="text-2xl font-bold text-blue-600">{{ $kategori->barangs_count }}</div>
                            <div class="text-xs text-gray-500">Items</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Stats Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">{{ number_format($stats['total_items']) }}</div>
                    <div class="text-lg text-blue-100">Total Items</div>
                    <i class="fas fa-boxes text-2xl mt-3 text-blue-200"></i>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">{{ number_format($stats['total_categories']) }}</div>
                    <div class="text-lg text-blue-100">Categories</div>
                    <i class="fas fa-tags text-2xl mt-3 text-blue-200"></i>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2 text-yellow-400">{{ number_format($stats['low_stock_items']) }}
                    </div>
                    <div class="text-lg text-blue-100">Low Stock Alerts</div>
                    <i class="fas fa-exclamation-triangle text-2xl mt-3 text-yellow-400"></i>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">{{ number_format($stats['total_requests']) }}</div>
                    <div class="text-lg text-blue-100">Total Requests</div>
                    <i class="fas fa-clipboard-list text-2xl mt-3 text-blue-200"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Ready to Optimize Your Inventory?</h2>
            <p class="text-xl text-gray-600 mb-8">
                Mulai kelola inventori perusahaan Anda dengan sistem yang modern dan efisien
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('katalog.index') }}"
                    class="bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition duration-300 transform hover:scale-105">
                    <i class="fas fa-boxes mr-2"></i> Browse Inventory
                </a>
                <a href="{{ route('contact') }}"
                    class="border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:border-blue-500 hover:text-blue-600 transition duration-300">
                    <i class="fas fa-envelope mr-2"></i> Contact Support
                </a>
            </div>
        </div>
    </section>
@endsection
