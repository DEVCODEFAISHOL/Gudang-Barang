<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pengeluaran Barang') }}
            </h2>
            <a href="{{ route('admin.pengeluaran.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Pengeluaran
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Alert Messages --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Filter Form --}}
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" action="{{ route('admin.pengeluaran.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            {{-- Status Filter --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Semua Status</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>

                            {{-- Date From --}}
                            <div>
                                <label for="tanggal_dari" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                                <input type="date" name="tanggal_dari" id="tanggal_dari"
                                       value="{{ request('tanggal_dari') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Date To --}}
                            <div>
                                <label for="tanggal_sampai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                                <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                                       value="{{ request('tanggal_sampai') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Search --}}
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                                <div class="flex">
                                    <input type="text" name="search" id="search"
                                           placeholder="Kode pengeluaran atau keterangan"
                                           value="{{ request('search') }}"
                                           class="flex-1 border-gray-300 rounded-l-md shadow-sm">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-r-md">
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode Pengeluaran
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Penerima
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Item
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dibuat Oleh
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pengeluarans as $pengeluaran)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $pengeluaran->kode_pengeluaran }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pengeluaran->penerima }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pengeluaran->details->sum('jumlah_dikeluarkan') }} item
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($pengeluaran->status == 'draft')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Draft
                                                </span>
                                            @elseif($pengeluaran->status == 'disetujui')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pengeluaran->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                {{-- View Button --}}
                                                <a href="{{ route('admin.pengeluaran.show', $pengeluaran) }}"
                                                   class="text-blue-600 hover:text-blue-900">
                                                    Lihat
                                                </a>

                                                @if($pengeluaran->status == 'draft')
                                                    {{-- Edit Button --}}
                                                    <a href="{{ route('admin.pengeluaran.edit', $pengeluaran) }}"
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        Edit
                                                    </a>

                                                    {{-- Approve Button --}}
                                                    <form action="{{ route('admin.pengeluaran.approve', $pengeluaran) }}"
                                                          method="POST" class="inline"
                                                          onsubmit="return confirm('Yakin ingin menyetujui pengeluaran ini?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                                            Setujui
                                                        </button>
                                                    </form>

                                                    {{-- Cancel Button --}}
                                                    <form action="{{ route('admin.pengeluaran.cancel', $pengeluaran) }}"
                                                          method="POST" class="inline"
                                                          onsubmit="return confirm('Yakin ingin membatalkan pengeluaran ini?')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-orange-600 hover:text-orange-900">
                                                            Batal
                                                        </button>
                                                    </form>

                                                    {{-- Delete Button --}}
                                                    <form action="{{ route('admin.pengeluaran.destroy', $pengeluaran) }}"
                                                          method="POST" class="inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data pengeluaran
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $pengeluarans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
