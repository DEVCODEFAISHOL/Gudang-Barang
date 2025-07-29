<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                        {{ __('Detail Permintaan Barang') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Informasi lengkap permintaan barang</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.permintaan.index') }}"
                    class="group bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-6 rounded-xl border border-gray-200 inline-flex items-center transition-all duration-200 hover:shadow-md hover:scale-105">
                    <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Status Card dengan Design Modern -->
            <div class="relative overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 via-transparent to-purple-50 opacity-60"></div>
                <div class="relative p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                @if ($permintaan->status == 'pending')
                                    <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @elseif($permintaan->status == 'approved')
                                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-500 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @elseif($permintaan->status == 'rejected')
                                    <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-rose-500 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Status Permintaan</h3>
                                    @if ($permintaan->status == 'pending')
                                        <span class="inline-flex px-4 py-2 text-sm font-bold rounded-full bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border border-amber-200">
                                            <span class="w-2 h-2 bg-amber-500 rounded-full mr-2 animate-pulse"></span>
                                            Menunggu Persetujuan
                                        </span>
                                    @elseif($permintaan->status == 'approved')
                                        <span class="inline-flex px-4 py-2 text-sm font-bold rounded-full bg-gradient-to-r from-emerald-100 to-green-100 text-green-800 border border-green-200">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            Disetujui
                                        </span>
                                    @elseif($permintaan->status == 'rejected')
                                        <span class="inline-flex px-4 py-2 text-sm font-bold rounded-full bg-gradient-to-r from-red-100 to-rose-100 text-red-800 border border-red-200">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                            Ditolak
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-base">
                                    @if ($permintaan->status == 'pending')
                                        Permintaan sedang menunggu persetujuan dari manager
                                    @elseif($permintaan->status == 'approved')
                                        Permintaan telah disetujui dan dapat diproses
                                    @elseif($permintaan->status == 'rejected')
                                        Permintaan telah ditolak oleh manager
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="text-right bg-white bg-opacity-70 backdrop-blur-sm rounded-xl p-6 border border-gray-100">
                            <p class="text-sm font-medium text-gray-500 mb-1">Kode Permintaan</p>
                            <p class="text-2xl font-bold text-gray-900 tracking-wide">{{ $permintaan->kode_permintaan }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Detail Barang -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Daftar Barang Diminta</h3>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="overflow-hidden rounded-xl border border-gray-200">
                                <table class="min-w-full">
                                    <thead class="bg-gradient-to-r from-gray-50 to-slate-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Nama Barang
                                            </th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Jumlah Diminta
                                            </th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                                Satuan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @forelse($permintaan->details as $index => $detail)
                                            <tr class="hover:bg-gray-50 transition-colors duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50/30' }}">
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                                            <span class="text-xs font-bold text-blue-600">{{ $index + 1 }}</span>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-900">{{ $detail->barang->nama_barang }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                                        {{ $detail->jumlah_diminta }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-5 text-center">
                                                    <span class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                                        {{ $detail->barang->satuan }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-12 text-center">
                                                    <div class="flex flex-col items-center space-y-3">
                                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                            </svg>
                                                        </div>
                                                        <p class="text-gray-500 font-medium">Tidak ada barang dalam permintaan ini</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Info Tambahan -->
                <div class="space-y-6">
                    <!-- Info Card -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-5 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Informasi Lain</h3>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <div class="group">
                                <dt class="text-sm font-bold text-gray-500 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4M3 7h18l-1 10a2 2 0 01-2 2H6a2 2 0 01-2-2L3 7z"></path>
                                    </svg>
                                    <span>Tanggal Permintaan</span>
                                </dt>
                                <dd class="text-base font-semibold text-gray-900 bg-gray-50 px-4 py-3 rounded-xl">
                                    {{ \Carbon\Carbon::parse($permintaan->tanggal_permintaan)->translatedFormat('d F Y') }}
                                </dd>
                            </div>

                            <div class="group">
                                <dt class="text-sm font-bold text-gray-500 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span>Total Jenis Barang</span>
                                </dt>
                                <dd class="flex items-center space-x-3">
                                    <span class="inline-flex items-center px-4 py-3 rounded-xl text-lg font-bold text-white bg-gradient-to-r from-blue-500 to-indigo-600">
                                        {{ $permintaan->details->count() }}
                                    </span>
                                    <span class="text-sm font-medium text-gray-600">jenis barang</span>
                                </dd>
                            </div>

                            <div class="group">
                                <dt class="text-sm font-bold text-gray-500 mb-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                    <span>Keterangan</span>
                                </dt>
                                <dd class="text-sm text-gray-700 bg-gradient-to-r from-gray-50 to-slate-50 px-4 py-4 rounded-xl border border-gray-100 min-h-[80px] flex items-center">
                                    {{ $permintaan->keterangan ?? 'Tidak ada keterangan tambahan untuk permintaan ini.' }}
                                </dd>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl shadow-xl text-white overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-bold">Ringkasan</h4>
                                <svg class="w-6 h-6 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-white/80 text-sm">Total Item</span>
                                    <span class="font-bold text-xl">{{ $permintaan->details->sum('jumlah_diminta') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-white/80 text-sm">Jenis Barang</span>
                                    <span class="font-bold text-xl">{{ $permintaan->details->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
