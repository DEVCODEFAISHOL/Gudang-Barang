<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
             <!-- OPSI 3: Desain Outline (Sangat Ringan) -->
<div class="w-14 h-14 border-2 border-slate-300 dark:border-slate-700 rounded-2xl flex items-center justify-center">
    <svg class="w-7 h-7 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
    </svg>
</div>
                <div>
                    <h2 class="font-bold text-3xl text-gray-900 dark:text-gray-100 leading-tight">
                        {{ __('Dashboard Gudang Utama') }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitoring sistem inventaris secara
                        real-time</p>
                </div>
            </div>
            <div class="hidden lg:flex items-center space-x-4">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl px-4 py-2 shadow-md border border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Last Update</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ now()->format('H:i') }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- 1. ZONA PERINGATAN (SYSTEM ALERTS) dengan Design Modern -->
            @if ($alerts->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($alerts as $alert)
                        <div
                            class="relative overflow-hidden rounded-2xl shadow-lg border @if ($alert['type'] == 'danger') bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-red-200 dark:border-red-800 @endif @if ($alert['type'] == 'warning') bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 border-amber-200 dark:border-amber-800 @endif @if ($alert['type'] == 'info') bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-blue-200 dark:border-blue-800 @endif">
                            <div
                                class="absolute left-0 top-0 bottom-0 w-1 @if ($alert['type'] == 'danger') bg-gradient-to-b from-red-500 to-rose-600 @endif @if ($alert['type'] == 'warning') bg-gradient-to-b from-amber-500 to-yellow-600 @endif @if ($alert['type'] == 'info') bg-gradient-to-b from-blue-500 to-indigo-600 @endif">
                            </div>

                            <div class="p-6 flex items-center gap-6">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 rounded-xl flex items-center justify-center @if ($alert['type'] == 'danger') bg-gradient-to-br from-red-500 to-rose-600 @endif @if ($alert['type'] == 'warning') bg-gradient-to-br from-amber-500 to-yellow-600 @endif @if ($alert['type'] == 'info') bg-gradient-to-br from-blue-500 to-indigo-600 @endif shadow-lg">
                                        @if ($alert['type'] == 'danger')
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                                                </path>
                                            </svg>
                                        @endif
                                        @if ($alert['type'] == 'warning')
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                        @if ($alert['type'] == 'info')
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-1">
                                        {{ $alert['title'] }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300">{{ $alert['message'] }}</p>
                                </div>
                                <a href="{{ $alert['url'] }}"
                                    class="group bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 px-6 py-3 rounded-xl font-semibold text-gray-700 dark:text-gray-300 transition-all duration-200 hover:shadow-md hover:scale-105 border border-gray-200 dark:border-gray-600">
                                    <span class="group-hover:mr-1 transition-all duration-200">Lihat Detail</span>
                                    <svg class="w-4 h-4 inline ml-2 group-hover:translate-x-1 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- 2. ZONA KPI (KEY PERFORMANCE INDICATORS) dengan Design Gradient -->
<!-- 2. ZONA KPI (KEY PERFORMANCE INDICATORS) - Desain Monokromatik Abu-abu/Slate -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Barang -->
    <div class="group bg-white dark:bg-slate-800/50 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 overflow-hidden relative p-6">
        <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-slate-100 dark:bg-slate-700/50 rounded-full transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-600">
                    <x-heroicon-o-cube class="w-6 h-6 text-slate-500 dark:text-slate-300"/>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Barang</p>
                </div>
            </div>
            <p class="text-4xl font-bold tracking-tight text-slate-900 dark:text-white">{{ number_format($totalBarang) }}</p>
        </div>
    </div>

    <!-- Permintaan Disetujui -->
    <div class="group bg-white dark:bg-slate-800/50 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 overflow-hidden relative p-6">
        <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-slate-100 dark:bg-slate-700/50 rounded-full transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-600">
                    <x-heroicon-o-check-circle class="w-6 h-6 text-slate-500 dark:text-slate-300"/>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Disetujui</p>
                </div>
            </div>
            <p class="text-4xl font-bold tracking-tight text-slate-900 dark:text-white">{{ number_format($approvedPermintaan) }}</p>
        </div>
    </div>

    <!-- Permintaan Pending -->
    <div class="group bg-white dark:bg-slate-800/50 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 overflow-hidden relative p-6">
        <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-slate-100 dark:bg-slate-700/50 rounded-full transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-600">
                    <x-heroicon-o-clock class="w-6 h-6 text-slate-500 dark:text-slate-300"/>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pending</p>
                </div>
            </div>
            <p class="text-4xl font-bold tracking-tight text-slate-900 dark:text-white">{{ number_format($pendingPermintaan) }}</p>
        </div>
    </div>

    <!-- Total Pengguna -->
    <div class="group bg-white dark:bg-slate-800/50 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 overflow-hidden relative p-6">
        <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-slate-100 dark:bg-slate-700/50 rounded-full transition-transform duration-500 group-hover:scale-150"></div>
        <div class="relative">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-600">
                    <x-heroicon-o-users class="w-6 h-6 text-slate-500 dark:text-slate-300"/>
                </div>
                <div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pengguna</p>
                </div>
            </div>
            <p class="text-4xl font-bold tracking-tight text-slate-900 dark:text-white">{{ number_format($totalUser) }}</p>
        </div>
    </div>

</div>

            <!-- 4. ZONA TABEL INFORMASI dengan Modern Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Barang Paling Banyak Diminta -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Top 10 Barang Diminta (30
                                Hari)</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse ($topRequestedItems as $index => $item)
                                <div
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-slate-50 dark:from-gray-700 dark:to-gray-800 rounded-xl hover:shadow-md transition-all duration-200 group">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-gray-100 transition-colors">{{ $item->nama_barang }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="text-sm font-bold px-3 py-1 bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 dark:from-emerald-900 dark:to-teal-900 dark:text-emerald-300 rounded-full">{{ $item->total }}</span>
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                        </svg>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div
                                        class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada data permintaan</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Barang Stok Rendah -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Top 10 Barang Stok Rendah
                            </h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse ($lowStockItems as $index => $item)
                                <div
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-slate-50 dark:from-gray-700 dark:to-gray-800 rounded-xl hover:shadow-md transition-all duration-200 group">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-red-500 to-rose-600 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-gray-100 transition-colors">{{ $item->barang->nama_barang }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="text-sm font-bold px-3 py-1 bg-gradient-to-r from-red-100 to-rose-100 text-red-800 dark:from-red-900 dark:to-rose-900 dark:text-red-300 rounded-full">{{ $item->jumlah_stok }}</span>
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div
                                        class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-green-600 dark:text-green-400 font-medium">Semua stok dalam kondisi
                                        aman</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
<!-- 5. ZONA AKTIVITAS TERBARU - Desain "Cascading Flow Timeline" -->
@php
    // Array untuk mengatur offset vertikal (efek tangga).
    // Anda bisa mengubah nilai ini untuk efek yang berbeda.
    // Dibuat 4 agar polanya berulang secara menarik.
    $offsets = ['mt-0', 'mt-12', 'mt-6', 'mt-16'];
@endphp

<div class="bg-slate-50 rounded-2xl shadow-lg shadow-indigo-500/5 border border-gray-100 overflow-hidden">

    <!-- Header -->
    <div class="px-8 py-6 border-b border-gray-200 bg-white/50 backdrop-blur-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Alur Aktivitas</h3>
                    <p class="text-sm text-gray-500">Jelajahi peristiwa terbaru dengan ritme yang dinamis.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Horizontal Scrollable Body -->
    <div class="p-8 lg:p-12">
        <div id="timeline-scroll-cascading" class="relative flex items-start space-x-24 overflow-x-auto pb-10 -mb-10">
            @foreach ($recentActivities as $activity)
                <!-- Timeline Item Wrapper (mengatur posisi vertikal) -->
                <div class="group relative flex-shrink-0 {{ $offsets[$loop->index % count($offsets)] }}">

                    <!-- Kartu Aktivitas -->
                    <a href="{{ $activity['url'] }}" class="block w-80 lg:w-96 bg-white rounded-xl border border-gray-200 shadow-lg transition-all duration-300 transform hover:-translate-y-2
                        @if ($activity['type'] == 'barang') hover:shadow-2xl hover:shadow-blue-500/20 @endif
                        @if ($activity['type'] == 'permintaan') hover:shadow-2xl hover:shadow-amber-500/20 @endif
                        @if ($activity['type'] == 'pengeluaran') hover:shadow-2xl hover:shadow-red-500/20 @endif
                        @if ($activity['type'] == 'user') hover:shadow-2xl hover:shadow-purple-500/20 @endif
                        ">

                        <div class="p-5">
                            <div class="flex items-start justify-between">
                                <!-- Konten Teks -->
                                <div class="pr-10">
                                    <div class="flex items-center space-x-2 mb-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($activity['user_name'] ?? 'S') }}&background=e5e7eb&color=4b5563&bold=true" alt="Avatar" class="w-6 h-6 rounded-full">
                                        <p class="text-sm font-medium text-gray-600">
                                            <span class="font-semibold text-gray-900">{{ $activity['user_name'] ?? 'Sistem' }}</span>
                                            {{ $activity['action_text'] ?? 'melakukan aksi' }}
                                        </p>
                                    </div>
                                    <h4 class="font-bold text-lg text-gray-800">{{ $activity['title'] }}</h4>
                                </div>
                                <!-- Jendela Ikon -->
                                <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center transition-colors duration-300
                                    @if ($activity['type'] == 'barang') bg-blue-100 text-blue-600 @endif
                                    @if ($activity['type'] == 'permintaan') bg-amber-100 text-amber-600 @endif
                                    @if ($activity['type'] == 'pengeluaran') bg-red-100 text-red-600 @endif
                                    @if ($activity['type'] == 'user') bg-purple-100 text-purple-600 @endif
                                    ">
                                    @if ($activity['type'] == 'barang') <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg> @endif
                                    @if ($activity['type'] == 'permintaan') <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> @endif
                                    @if ($activity['type'] == 'pengeluaran') <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg> @endif
                                    @if ($activity['type'] == 'user') <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg> @endif
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <time datetime="{{ $activity['time']->toIso8601String() }}" class="text-xs font-semibold text-gray-400">
                                    {{ $activity['time']->diffForHumans() }}
                                </time>
                            </div>
                        </div>
                    </a>

                    <!-- Konektor Kurva SVG (hanya muncul jika bukan item terakhir) -->
                    @if (!$loop->last)
                        <div class="absolute top-1/2 left-full w-24 h-20 -translate-y-1/2">
                            <svg class="w-full h-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 40 C 25 40, 75 0, 95 0" stroke="#CBD5E1" stroke-width="2" stroke-dasharray="4 4" />
                            </svg>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    </div>
</div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isDarkMode = document.documentElement.classList.contains('dark');
                const textColor = isDarkMode ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.8)';
                const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

                // Modern Chart Configuration
                Chart.defaults.font.family = "'Inter', 'system-ui', 'sans-serif'";
                Chart.defaults.font.size = 12;
                Chart.defaults.color = textColor;

                // Monthly Stats Chart with Modern Styling
                const monthlyStatsData = @json($monthlyStats);
                new Chart(document.getElementById('monthlyStatsChart'), {
                    type: 'bar',
                    data: {
                        labels: monthlyStatsData.months,
                        datasets: [{
                                label: 'Permintaan',
                                data: monthlyStatsData.permintaan,
                                backgroundColor: 'rgba(56, 189, 248, 0.8)', // sky-400
                                borderColor: 'rgb(56, 189, 248)',
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false,
                            },
                            {
                                label: 'Pengeluaran',
                                data: monthlyStatsData.pengeluaran,
                                backgroundColor: 'rgba(94, 234, 212, 0.8)', // teal-300
                                borderColor: 'rgb(94, 234, 212)',
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false,
                            },
                            {
                                label: 'Barang Masuk',
                                data: monthlyStatsData.inventaris,
                                backgroundColor: 'rgba(165, 180, 252, 0.8)', // indigo-200
                                borderColor: 'rgb(165, 180, 252)',
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: textColor,
                                    usePointStyle: true,
                                    font: {
                                        weight: '600'
                                    },
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: isDarkMode ? 'rgba(0, 0, 0, 0.8)' :
                                    'rgba(255, 255, 255, 0.95)',
                                titleColor: textColor,
                                bodyColor: textColor,
                                borderColor: gridColor,
                                borderWidth: 1,
                                cornerRadius: 12,
                                padding: 12
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: textColor,
                                    font: {
                                        weight: '500'
                                    }
                                },
                                border: {
                                    color: gridColor
                                }
                            },
                            y: {
                                grid: {
                                    color: gridColor,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: textColor,
                                    font: {
                                        weight: '500'
                                    }
                                },
                                border: {
                                    display: false
                                }
                            }
                        }
                    }
                });

                // Category Distribution Chart with Modern Styling
                const categoryData = @json($categoryDistribution);
                new Chart(document.getElementById('categoryDistributionChart'), {
                    type: 'doughnut',
                    data: {
                        labels: categoryData.labels,
                        datasets: [{
                            data: categoryData.data,
                            backgroundColor: [
                                'rgba(56, 189, 248, 0.8)', // sky-400
                                'rgba(94, 234, 212, 0.8)', // teal-300
                                'rgba(253, 224, 71, 0.8)', // yellow-300
                                'rgba(251, 113, 133, 0.8)', // pink-300
                                'rgba(196, 181, 253, 0.8)', // purple-300
                                'rgba(129, 140, 248, 0.8)' // indigo-400
                            ],
                            borderColor: [
                                'rgb(56, 189, 248)',
                                'rgb(94, 234, 212)',
                                'rgb(253, 224, 71)',
                                'rgb(251, 113, 133)',
                                'rgb(196, 181, 253)',
                                'rgb(129, 140, 248)'
                            ]

                            borderWidth: 3,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        weight: '500'
                                    },
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: isDarkMode ? 'rgba(0, 0, 0, 0.8)' :
                                    'rgba(255, 255, 255, 0.95)',
                                titleColor: textColor,
                                bodyColor: textColor,
                                borderColor: gridColor,
                                borderWidth: 1,
                                cornerRadius: 12,
                                padding: 12
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
