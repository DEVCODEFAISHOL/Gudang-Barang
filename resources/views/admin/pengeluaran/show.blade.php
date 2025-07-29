<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengeluaran') }} - {{ $pengeluaran->kode_pengeluaran }}
            </h2>
            <div class="flex space-x-2">
                @if($pengeluaran->status == 'draft')
                    <a href="{{ route('admin.pengeluaran.edit', $pengeluaran) }}"
                       class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                @endif
                <a href="{{ route('admin.pengeluaran.index') }}"
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Informasi Pengeluaran --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pengeluaran</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Kode Pengeluaran</label>
                                <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $pengeluaran->kode_pengeluaran }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pengeluaran</label>
                                <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('d F Y') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Penerima</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengeluaran->penerima }}</p>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="mt-1">
                                    @if($pengeluaran->status == 'draft')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Draft
                                        </span>
                                    @elseif($pengeluaran->status == 'disetujui')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Dibuat Oleh</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengeluaran->user->name }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Dibuat Pada</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengeluaran->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    @if($pengeluaran->keterangan)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $pengeluaran->keterangan }}</p>
                        </div>
                    @endif

                    {{-- Informasi Persetujuan --}}
                    @if($pengeluaran->status == 'disetujui')
                        <div class="mt-6 bg-green-50 p-4 rounded-lg">
                            <h4 class="text-md font-semibold text-green-800 mb- 2">Informasi Persetujuan</h4>
                            <p class="text-sm text-green-700">Disetujui oleh: {{ $pengeluaran->approved_by->name }}</p>
                            <p class="text-sm text-green-700">Pada: {{ $pengeluaran->approved_at->format('d F Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- Detail Pengeluaran --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Detail Pengeluaran</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Dikeluarkan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pengeluaran->details as $detail)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detail->barang->nama_barang }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detail->jumlah_dikeluarkan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $detail->keterangan_detail ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
