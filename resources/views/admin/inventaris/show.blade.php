<x-app-layout>
    {{-- CSS Khusus untuk Halaman Cetak --}}
    @push('styles')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                -webkit-print-color-adjust: exact; /* Chrome, Safari */
                color-adjust: exact; /* Firefox */
            }
            .print-container {
                padding: 0;
                margin: 0;
            }
            .print-shadow {
                box-shadow: none !important;
            }
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Inventaris #') }}{{ $inventaris->kode_inventaris }}
            </h2>
            <a href="{{ route('admin.inventaris.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 print-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Informasi Utama -->
            <div class="bg-white shadow rounded-lg p-6 mb-6 print-shadow">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Kolom 1 -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Kode Inventaris</h4>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $inventaris->kode_inventaris }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Tanggal Inventaris</h4>
                        <p class="mt-1 text-lg text-gray-900">{{ \Carbon\Carbon::parse($inventaris->tanggal_inventaris)->isoFormat('D MMMM Y') }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="mt-1">
                            @if($inventaris->status == 'selesai')
                                <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Selesai</span>
                            @elseif($inventaris->status == 'berlangsung')
                                <span class="px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">Berlangsung</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">Dibatalkan</span>
                            @endif
                        </p>
                    </div>

                    <!-- Kolom 2 -->
                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-500">Keterangan</h4>
                        <p class="mt-1 text-gray-900">{{ $inventaris->keterangan ?: '-' }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Dibuat oleh</h4>
                        <p class="mt-1 text-gray-900">{{ $inventaris->user->name }}</p>
                    </div>

                    <!-- Info Persetujuan (hanya jika selesai) -->
                    @if($inventaris->status == 'selesai')
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Diselesaikan oleh</h4>
                            <p class="mt-1 text-gray-900">{{ $inventaris->approver->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Tanggal Selesai</h4>
                            <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($inventaris->tanggal_disetujui)->isoFormat('D MMMM Y, HH:mm') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detail Barang -->
            <div class="bg-white shadow rounded-lg p-6 mb-6 print-shadow">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Barang</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Sistem</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Fisik</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Selisih</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan Detail</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($inventaris->details as $detail)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $detail->barang->nama_barang }}</div>
                                        <div class="text-sm text-gray-500">{{ $detail->barang->kode_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $detail->stok_sistem }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">{{ $detail->stok_fisik }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold">
                                        @if($detail->selisih > 0)
                                            <span class="text-green-600">+{{ $detail->selisih }}</span>
                                        @elseif($detail->selisih < 0)
                                            <span class="text-red-600">{{ $detail->selisih }}</span>
                                        @else
                                            <span class="text-gray-500">{{ $detail->selisih }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->keterangan_detail ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada detail barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="bg-white shadow rounded-lg p-6 flex justify-between items-center no-print print-shadow">
                <div>
                    {{-- Tombol aksi di kiri jika ada --}}
                    @if($inventaris->status == 'berlangsung')
                        <form action="{{ route('admin.inventaris.destroy', $inventaris) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data inventaris ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                                <i class="fas fa-trash"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="flex space-x-3">
                    {{-- Tombol aksi di kanan --}}
                    <button type="button" onclick="window.print()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                        <i class="fas fa-print"></i>
                        <span>Cetak</span>
                    </button>

                    @if($inventaris->status == 'berlangsung')
                        <a href="{{ route('admin.inventaris.edit', $inventaris) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                            <i class="fas fa-pencil-alt"></i>
                            <span>Edit</span>
                        </a>

                        <form action="{{ route('admin.inventaris.approve', $inventaris) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan stok opname ini? Stok barang akan disesuaikan dan tidak dapat diubah lagi.');">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                                <i class="fas fa-check-circle"></i>
                                <span>Selesaikan Stok Opname</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
