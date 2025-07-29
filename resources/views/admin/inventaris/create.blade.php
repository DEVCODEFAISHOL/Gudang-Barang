<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Inventaris') }}
            </h2>
            <a href="{{ route('admin.inventaris.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.inventaris.store') }}" method="POST" id="inventarisForm">
                @csrf

                <!-- Form Header -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Inventaris</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tanggal_inventaris" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Inventaris <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="tanggal_inventaris"
                                   id="tanggal_inventaris"
                                   value="{{ old('tanggal_inventaris', date('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_inventaris') border-red-500 @enderror"
                                   required>
                            @error('tanggal_inventaris')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan
                            </label>
                            <textarea name="keterangan"
                                      id="keterangan"
                                      rows="3"
                                      placeholder="Keterangan inventaris (stok opname)..."
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Detail Barang -->
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Detail Barang</h3>
                        <div class="flex space-x-2">
                            <button type="button"
                                    onclick="addDetailRow()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                                <i class="fas fa-plus"></i>
                                <span>Tambah Barang</span>
                            </button>

                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="detailTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Barang <span class="text-red-500">*</span>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stok Sistem
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stok Fisik <span class="text-red-500">*</span>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Selisih
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keterangan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="detailTableBody">
                                <!-- Detail rows will be added here -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-sm text-gray-600">
                        <p><span class="text-red-500">*</span> Wajib diisi</p>
                        <p class="mt-1">Stok sistem akan diambil otomatis berdasarkan barang yang dipilih.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.inventaris.index') }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                            Simpan Inventaris
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Pilih Barang -->
    <div id="barangModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Pilih Barang</h3>
                    <button type="button" onclick="closeBarangModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mb-4">
                    <input type="text"
                           id="searchBarang"
                           placeholder="Cari barang..."
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="max-h-96 overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode Barang
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Barang
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok Sistem
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="barangTableBody">
                            @foreach($barangs as $barang)
                                <tr class="barang-row hover:bg-gray-50" data-nama="{{ strtolower($barang->nama_barang) }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $barang->kode_barang }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $barang->nama_barang }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $barang->stok->jumlah_stok ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <button type="button"
                                                onclick="selectBarang({{ $barang->id }}, '{{ $barang->kode_barang }}', '{{ $barang->nama_barang }}', {{ $barang->stok->jumlah_stok ?? 0 }})"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        let detailIndex = 0;
        let currentRow = null;

        function addDetailRow() {
            currentRow = detailIndex;
            openBarangModal();
        }

        function openBarangModal() {
            document.getElementById('barangModal').classList.remove('hidden');
        }

        function closeBarangModal() {
            document.getElementById('barangModal').classList.add('hidden');
            currentRow = null;
        }

        function selectBarang(id, kode, nama, stokSistem) {
            // Check if barang already selected
            const existingRows = document.querySelectorAll('input[name="details[][barang_id]"]');
            for (let row of existingRows) {
                if (row.value == id) {
                    alert('Barang sudah dipilih!');
                    closeBarangModal();
                    return;
                }
            }

            const tableBody = document.getElementById('detailTableBody');
            const row = document.createElement('tr');
            row.className = 'detail-row';

            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="details[${detailIndex}][barang_id]" value="${id}">
                    <div class="text-sm font-medium text-gray-900">${kode}</div>
                    <div class="text-sm text-gray-500">${nama}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="number"
                           class="stok-sistem w-20 border border-gray-300 rounded px-2 py-1 text-center bg-gray-100"
                           value="${stokSistem}"
                           readonly>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="number"
                           name="details[${detailIndex}][stok_fisik]"
                           class="stok-fisik w-20 border border-gray-300 rounded px-2 py-1 text-center focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="0"
                           min="0"
                           required
                           onchange="calculateSelisih(this)">
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="selisih text-sm px-2 py-1 rounded font-medium">0</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="text"
                           name="details[${detailIndex}][keterangan_detail]"
                           class="w-32 border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Keterangan...">
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button type="button"
                            onclick="removeDetailRow(this)"
                            class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs transition-colors">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            tableBody.appendChild(row);
            detailIndex++;

            closeBarangModal();
        }

        function removeDetailRow(button) {
            if (confirm('Hapus barang ini dari daftar?')) {
                button.closest('tr').remove();
            }
        }

        function calculateSelisih(input) {
            const row = input.closest('tr');
            const stokSistem = parseInt(row.querySelector('.stok-sistem').value) || 0;
            const stokFisik = parseInt(input.value) || 0;
            const selisih = stokFisik - stokSistem;

            const selisihElement = row.querySelector('.selisih');
            selisihElement.textContent = selisih;

            // Add color coding
            selisihElement.className = 'selisih text-sm px-2 py-1 rounded font-medium ';
            if (selisih > 0) {
                selisihElement.className += 'bg-green-100 text-green-800';
            } else if (selisih < 0) {
                selisihElement.className += 'bg-red-100 text-red-800';
            } else {
                selisihElement.className += 'bg-gray-100 text-gray-800';
            }
        }

        // Search functionality for barang modal
        document.getElementById('searchBarang').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.barang-row');

            rows.forEach(row => {
                const namaBarang = row.getAttribute('data-nama');
                if (namaBarang.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Form validation
        document.getElementById('inventarisForm').addEventListener('submit', function(e) {
            const detailRows = document.querySelectorAll('.detail-row');

            if (detailRows.length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 barang dalam daftar inventaris!');
                return false;
            }
        });

        // Add initial row
        document.addEventListener('DOMContentLoaded', function() {
            // Auto focus on tanggal
            document.getElementById('tanggal_inventaris').focus();
        });
    </script>
</x-app-layout>
