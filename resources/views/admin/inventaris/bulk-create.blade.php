<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bulk Stock Opname') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.inventaris.export-template') }}"
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                    <i class="fas fa-download mr-1"></i> Download Template
                </a>
                <button type="button"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm"
                        onclick="openImportModal()">
                    <i class="fas fa-upload mr-1"></i> Import Excel
                </button>
                <a href="{{ route('admin.inventaris.index') }}"
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Alert Messages -->
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

                    <form action="{{ route('admin.inventaris.bulk.store') }}" method="POST" id="bulkOpnameForm">
                        @csrf

                        <!-- Form Header -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="tanggal_opname" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Opname <span class="text-red-500">*</span>
                                </label>
                                <input type="date"
                                       id="tanggal_opname"
                                       name="tanggal_opname"
                                       value="{{ old('tanggal_opname', date('Y-m-d')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tanggal_opname') border-red-500 @enderror"
                                       required>
                                @error('tanggal_opname')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan
                                </label>
                                <input type="text"
                                       id="keterangan"
                                       name="keterangan"
                                       placeholder="Keterangan bulk opname"
                                       value="{{ old('keterangan') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('keterangan') border-red-500 @enderror">
                                @error('keterangan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Table Header Actions -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Daftar Barang</h3>
                            <div class="flex space-x-2">
                                <button type="button"
                                        onclick="toggleAllItems(true)"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    <i class="fas fa-check-square mr-1"></i> Pilih Semua
                                </button>
                                <button type="button"
                                        onclick="toggleAllItems(false)"
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">
                                    <i class="fas fa-square mr-1"></i> Batal Pilih
                                </button>
                                <button type="button"
                                        onclick="copySystemStock()"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                    <i class="fas fa-copy mr-1"></i> Copy Stok Sistem
                                </button>
                                <button type="button"
                                        onclick="showOnlyDifferences()"
                                        class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm">
                                    <i class="fas fa-filter mr-1"></i> Hanya Selisih
                                </button>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                                            <input type="checkbox"
                                                   id="selectAll"
                                                   onchange="toggleAllItems(this.checked)"
                                                   class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kode Barang
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Barang
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Satuan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Stok Sistem
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Stok Fisik
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Selisih
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Keterangan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($barangs as $index => $barang)
                                    <tr class="barang-row hover:bg-gray-50" data-barang-id="{{ $barang['id'] }}">
                                        <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                            <input type="checkbox"
                                                   class="item-checkbox absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                   name="barangs[{{ $index }}][include]"
                                                   value="1"
                                                   onchange="updateRowStyle(this)">
                                            <input type="hidden" name="barangs[{{ $index }}][barang_id]" value="{{ $barang['id'] }}">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $barang['kode_barang'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $barang['nama_barang'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $barang['satuan'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            <span class="stok-sistem font-medium">{{ number_format($barang['stok_sistem'], 0) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <input type="number"
                                                   class="stok-fisik w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center"
                                                   name="barangs[{{ $index }}][stok_fisik]"
                                                   value="{{ $barang['stok_fisik'] }}"
                                                   step="0.01"
                                                   min="0"
                                                   data-sistem="{{ $barang['stok_sistem'] }}"
                                                   onchange="calculateDifference(this)">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                            <span class="selisih inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                0
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <input type="text"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                   name="barangs[{{ $index }}][keterangan_detail]"
                                                   placeholder="Keterangan...">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Stats and Submit -->
                        <div class="mt-6 flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                <span id="selectedCount" class="font-medium">0</span> barang dipilih |
                                <span id="differenceCount" class="font-medium">0</span> barang dengan selisih
                            </div>
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow">
                                <i class="fas fa-save mr-2"></i> Simpan Bulk Opname
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Import Bulk Opname</h3>
                    <button type="button" onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.inventaris.import-bulk') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">File Excel/CSV</label>
                        <input type="file"
                               name="file"
                               accept=".csv,.xlsx,.xls"
                               required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="mt-1 text-sm text-gray-500">
                            Format: CSV atau Excel.
                            <a href="{{ route('admin.inventaris.export-template') }}" class="text-indigo-600 hover:text-indigo-500">Download template</a>
                        </p>
                    </div>

                    <div class="mb-4">
                        <label for="import_tanggal_opname" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Opname</label>
                        <input type="date"
                               name="tanggal_opname"
                               value="{{ date('Y-m-d') }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label for="import_keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <input type="text"
                               name="keterangan"
                               placeholder="Keterangan import"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button"
                                onclick="closeImportModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function toggleAllItems(checked) {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const selectAllCheckbox = document.getElementById('selectAll');

        checkboxes.forEach(checkbox => {
            checkbox.checked = checked;
            updateRowStyle(checkbox);
        });

        selectAllCheckbox.checked = checked;
        updateCounts();
    }

    function updateRowStyle(checkbox) {
        const row = checkbox.closest('tr');
        if (checkbox.checked) {
            row.classList.add('bg-indigo-50');
            row.style.opacity = '1';
        } else {
            row.classList.remove('bg-indigo-50');
            row.style.opacity = '0.6';
        }
        updateCounts();
    }

    function calculateDifference(input) {
        const row = input.closest('tr');
        const sistemValue = parseFloat(input.dataset.sistem) || 0;
        const fisikValue = parseFloat(input.value) || 0;
        const selisih = fisikValue - sistemValue;

        const selisihSpan = row.querySelector('.selisih');
        selisihSpan.textContent = selisih.toFixed(0);

        // Update badge color based on difference
        selisihSpan.className = 'selisih inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ';
        if (selisih > 0) {
            selisihSpan.className += 'bg-green-100 text-green-800';
        } else if (selisih < 0) {
            selisihSpan.className += 'bg-red-100 text-red-800';
        } else {
            selisihSpan.className += 'bg-gray-100 text-gray-800';
        }

        updateCounts();
    }

    function copySystemStock() {
        const inputs = document.querySelectorAll('.stok-fisik');
        inputs.forEach(input => {
            input.value = input.dataset.sistem;
            calculateDifference(input);
        });
    }

    function showOnlyDifferences() {
        const rows = document.querySelectorAll('.barang-row');
        let hasFilter = document.querySelector('.barang-row[style*="display: none"]');

        rows.forEach(row => {
            const selisih = row.querySelector('.selisih').textContent;
            if (hasFilter) {
                // Show all
                row.style.display = '';
            } else {
                // Hide rows without difference
                if (parseFloat(selisih) === 0) {
                    row.style.display = 'none';
                }
            }
        });
    }

    function updateCounts() {
        const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
        const differenceCount = Array.from(document.querySelectorAll('.selisih')).filter(span =>
            parseFloat(span.textContent) !== 0
        ).length;

        document.getElementById('selectedCount').textContent = selectedCount;
        document.getElementById('differenceCount').textContent = differenceCount;
    }

    function openImportModal() {
        document.getElementById('importModal').classList.remove('hidden');
    }

    function closeImportModal() {
        document.getElementById('importModal').classList.add('hidden');
    }

    // Initialize calculations on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.stok-fisik').forEach(input => {
            calculateDifference(input);
        });
        updateCounts();
    });

    // Form validation
    document.getElementById('bulkOpnameForm').addEventListener('submit', function(e) {
        const selectedItems = document.querySelectorAll('.item-checkbox:checked').length;
        if (selectedItems === 0) {
            e.preventDefault();
            alert('Pilih minimal satu barang untuk diproses!');
            return false;
        }

        if (!confirm(`Anda akan memproses ${selectedItems} barang. Lanjutkan?`)) {
            e.preventDefault();
            return false;
        }
    });

    // Close modal when clicking outside
    document.getElementById('importModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImportModal();
        }
    });
    </script>
    @endpush
</x-app-layout>
