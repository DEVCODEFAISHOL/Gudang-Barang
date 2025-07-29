<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $barang->nama_barang }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Detail Barang - {{ $barang->kode_barang }}</p>
            </div>
            <a href="{{ route('admin.barang.edit', $barang) }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Edit Barang
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Detail Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Detail Barang -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detail Utama</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Barang</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $barang->nama_barang }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kode Barang</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $barang->kode_barang }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $barang->kategori->nama_kategori ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if($barang->status == 'aktif')
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-300">Tidak Aktif</span>
                                @endif
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $barang->deskripsi ?? 'Tidak ada deskripsi.' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Card Grafik Stok -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Grafik Pergerakan Stok (30 Hari Terakhir)</h3>
                    <div class="h-64"><canvas id="stockMovementChart"></canvas></div>
                </div>
            </div>

            <!-- Kolom Kanan: Stok & Aktivitas -->
            <div class="space-y-6">
                <!-- Card Info Stok -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Stok</h3>
                    @if($barang->stok)
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Stok Saat Ini</p>
                            <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $barang->stok->jumlah_stok ?? 0 }} {{ $barang->satuan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Batas Stok Aman</p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $barang->stok->stok_aman ?? 0 }} {{ $barang->satuan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Lokasi Penyimpanan</p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $barang->stok->lokasi_penyimpanan ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @else
                    <p class="text-center text-gray-500">Data stok tidak ditemukan.</p>
                    @endif
                </div>

                <!-- Card Aktivitas Terbaru -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Aktivitas Terbaru</h3>
                    <ul class="space-y-4">
                        @forelse($recentActivities as $activity)
                            <li class="flex items-start space-x-3">
                                <div class="flex-shrink-0 p-2 rounded-full
                                    @if($activity['type'] == 'pengeluaran') bg-red-100 dark:bg-red-900
                                    @elseif($activity['type'] == 'inventaris') bg-green-100 dark:bg-green-900
                                    @else bg-blue-100 dark:bg-blue-900 @endif">
                                    @if($activity['type'] == 'pengeluaran') <x-heroicon-o-arrow-circle-down class="w-5 h-5 text-red-500"/>
                                    @elseif($activity['type'] == 'inventaris') <x-heroicon-o-arrow-circle-up class="w-5 h-5 text-green-500"/>
                                    @else <x-heroicon-o-document-text class="w-5 h-5 text-blue-500"/> @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($activity['date'])->translatedFormat('d M Y, H:i') }}</p>
                                </div>
                            </li>
                        @empty
                            <li class="text-center text-gray-500 py-4">Tidak ada aktivitas terbaru.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const stockData = @json($stockMovement);
                const ctx = document.getElementById('stockMovementChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: stockData.dates,
                        datasets: [
                        {
                            label: 'Jumlah Stok',
                            data: stockData.stockLevels,
                            borderColor: '#4F46E5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#4F46E5',
                        },
                        {
                            label: 'Stok Aman',
                            data: Array(stockData.dates.length).fill(stockData.stokAman),
                            borderColor: '#F59E0B',
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                        }
                    ]},
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
