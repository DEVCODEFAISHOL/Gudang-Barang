<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-6 rounded-xl shadow-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium opacity-80">Total Barang</p>
                            <p class="text-3xl font-bold">{{ $totalBarang }}</p>
                        </div>
                        <x-heroicon-o-cube class="w-10 h-10 opacity-50"/>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white p-6 rounded-xl shadow-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium opacity-80">Barang Aktif</p>
                            <p class="text-3xl font-bold">{{ $barangAktif }}</p>
                        </div>
                        <x-heroicon-o-check-circle class="w-10 h-10 opacity-50"/>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-amber-600 text-white p-6 rounded-xl shadow-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium opacity-80">Stok Rendah</p>
                            <p class="text-3xl font-bold">{{ $stokRendah }}</p>
                        </div>
                        <x-heroicon-o-trending-down class="w-10 h-10 opacity-50"/>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-rose-600 text-white p-6 rounded-xl shadow-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium opacity-80">Stok Habis</p>
                            <p class="text-3xl font-bold">{{ $stokHabis }}</p>
                        </div>
                        <x-heroicon-o-x-circle class="w-10 h-10 opacity-50"/>
                    </div>
                </div>
            </div>

            <!-- Konten Utama: Filter dan Tabel -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header Aksi dan Filter -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
                        <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Barang Baru
                        </a>
                        <form action="{{ route('admin.barang.index') }}" method="GET" class="flex items-center gap-2">
                            <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" class="form-input rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600">
                            <button type="submit" class="p-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500"><x-heroicon-o-search class="w-5 h-5"/></button>
                        </form>
                    </div>

                    <!-- Notifikasi -->
                    @if(session('success')) <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div> @endif
                    @if(session('error')) <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div> @endif

                    <!-- Tabel Data -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Kode</th>
                                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3 text-center">Stok</th>
                                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barangs as $barang)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                                        <td class="px-6 py-4 font-mono text-xs text-gray-600 dark:text-gray-300">{{ $barang->kode_barang }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $barang->nama_barang }}</td>
                                        <td class="px-6 py-4">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if($barang->stok)
                                                @if($barang->stok->jumlah_stok <= 0)
                                                    <span class="font-bold text-red-500">{{ $barang->stok->jumlah_stok }}</span>
                                                @elseif($barang->stok->jumlah_stok <= $barang->stok->stok_aman)
                                                    <span class="font-bold text-yellow-500">{{ $barang->stok->jumlah_stok }}</span>
                                                @else
                                                    <span class="font-bold text-green-500">{{ $barang->stok->jumlah_stok }}</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($barang->status == 'aktif')
                                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-300">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-x-4">
                                                <a href="{{ route('admin.barang.show', $barang) }}" class="text-gray-500 hover:text-blue-600 transition" title="Lihat Detail"><x-heroicon-o-eye class="w-5 h-5"/></a>
                                                <a href="{{ route('admin.barang.edit', $barang) }}" class="text-gray-500 hover:text-yellow-600 transition" title="Edit Barang"><x-heroicon-o-pencil class="w-5 h-5"/></a>
                                                <form action="{{ route('admin.barang.destroy', $barang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-gray-500 hover:text-red-600 transition" title="Hapus Barang"><x-heroicon-o-trash class="w-5 h-5"/></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-6 py-4 text-center">Tidak ada data barang.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginasi -->
                    <div class="mt-6">{{ $barangs->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
