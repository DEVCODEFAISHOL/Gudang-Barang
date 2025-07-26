<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Manager') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                    <div class="text-lg font-semibold text-gray-800 dark:text-white">Permintaan Pending</div>
                    <div class="text-3xl font-bold text-indigo-600 mt-2">{{ $pendingPermintaans }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                    <div class="text-lg font-semibold text-gray-800 dark:text-white">Barang Stok Menipis</div>
                    <div class="text-3xl font-bold text-red-600 mt-2">{{ $barangs->total() }}</div>
                </div>
            </div>

            {{-- Tabel Barang Stok Menipis --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                <div class="text-xl font-bold text-gray-800 dark:text-white mb-4">Barang dengan Stok Menipis</div>

                @if($barangs->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Kode Barang</th>
                                    <th class="px-4 py-3">Nama Barang</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Stok</th>
                                    <th class="px-4 py-3">Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-4 py-3">{{ $loop->iteration + ($barangs->currentPage() - 1) * $barangs->perPage() }}</td>
                                        <td class="px-4 py-3">{{ $barang->kode_barang }}</td>
                                        <td class="px-4 py-3">{{ $barang->nama_barang }}</td>
                                        <td class="px-4 py-3">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                        <td class="px-4 py-3 text-red-600 font-bold">{{ $barang->stok->jumlah_stok ?? 0 }}</td>
                                        <td class="px-4 py-3">{{ $barang->satuan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $barangs->links() }}
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-300">Tidak ada barang dengan stok menipis.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
