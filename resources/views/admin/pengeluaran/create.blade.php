<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Pengeluaran Barang') }}
            </h2>
            <a href="{{ route('admin.pengeluaran.index') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Alert Messages --}}
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.pengeluaran.store') }}" id="pengeluaranForm">
                        @csrf

                        {{-- Form Header --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- Tanggal Pengeluaran --}}
                            <div>
                                <label for="tanggal_pengeluaran" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Pengeluaran <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_pengeluaran" id="tanggal_pengeluaran"
                                       value="{{ old('tanggal_pengeluaran', date('Y-m-d')) }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                            </div>

                            {{-- Penerima --}}
                            <div>
                                <label for="penerima" class="block text-sm font-medium text-gray-700 mb-2">
                                    Penerima <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="penerima" id="penerima"
                                       value="{{ old('penerima') }}"
                                       placeholder="Nama penerima barang"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-6">
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan
                            </label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                      placeholder="Keterangan pengeluaran (opsional)"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- Detail Barang --}}
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Detail Barang</h3>
                                <button type="button" id="tambahBarang"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Tambah Barang
                                </button>
                            </div>

                            <div id="detailBarangContainer">
                                {{-- Detail barang akan ditambahkan di sini via JavaScript --}}
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.pengeluaran.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Draft
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        let detailIndex = 0;
        const barangs = @json($barangs);

        document.getElementById('tambahBarang').addEventListener('click', function() {
            tambahDetailBarang();
        });

        function tambahDetailBarang() {
            const container = document.getElementById('detailBarangContainer');
            const detailHtml = `
                <div class="detail-barang-item border border-gray-200 rounded-lg p-4 mb-4" data-index="${detailIndex}">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-md font-medium text-gray-800">Barang #${detailIndex + 1}</h4>
                        <button type="button" class="hapus-detail text-red-600 hover:text-red-900" onclick="hapusDetail(${detailIndex})">
                            Hapus
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Barang <span class="text-red-500">*</span></label>
                            <select name="details[${detailIndex}][barang_id]" class="barang-select w-full border-gray-300 rounded-md shadow-sm" required onchange="updateStok(${detailIndex})">
                                <option value="">Pilih Barang</option>
                                ${barangs.map(barang => `
                                    <option value="${barang.id}" data-stok="${barang.stok ? barang.stok.jumlah_stok : 0}">
                                        ${barang.nama_barang} (Stok: ${barang.stok ? barang.stok.jumlah_stok : 0})
                                    </option>
                                `).join('')}
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Keluar <span class="text-red-500">*</span></label>
                            <input type="number" name="details[${detailIndex}][jumlah_keluar]"
                                   class="jumlah-input w-full border-gray-300 rounded-md shadow-sm"
                                   min="1" required onchange="validateJumlah(${detailIndex})">
                            <small class="stok-info text-gray-500">Stok tersedia: <span class="stok-tersedia">0</span></small>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                            <input type="text" name="details[${detailIndex}][keterangan_detail]"
                                   placeholder="Keterangan detail (opsional)"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', detailHtml);
            detailIndex++;
        }

        function hapusDetail(index) {
            const detailItem = document.querySelector(`[data-index="${index}"]`);
            if (detailItem) {
                detailItem.remove();
            }

            // Update nomor urut
            updateNomorUrut();
        }

        function updateNomorUrut() {
            const detailItems = document.querySelectorAll('.detail-barang-item');
            detailItems.forEach((item, index) => {
                const header = item.querySelector('h4');
                header.textContent = `Barang #${index + 1}`;
            });
        }

        function updateStok(index) {
            const select = document.querySelector(`[data-index="${index}"] .barang-select`);
            const stokSpan = document.querySelector(`[data-index="${index}"] .stok-tersedia`);
            const jumlahInput = document.querySelector(`[data-index="${index}"] .jumlah-input`);

            const selectedOption = select.options[select.selectedIndex];
            const stok = selectedOption ? selectedOption.dataset.stok : 0;

            stokSpan.textContent = stok;
            jumlahInput.max = stok;
            jumlahInput.value = '';
        }

        function validateJumlah(index) {
            const jumlahInput = document.querySelector(`[data-index="${index}"] .jumlah-input`);
            const stokTersedia = parseInt(document.querySelector(`[data-index="${index}"] .stok-tersedia`).textContent);
            const jumlah = parseInt(jumlahInput.value);

            if (jumlah > stokTersedia) {
                alert('Jumlah keluar tidak boleh melebihi stok tersedia!');
                jumlahInput.value = stokTersedia;
            }
        }

        // Validasi form sebelum submit
        document.getElementById('pengeluaranForm').addEventListener('submit', function(e) {
            const detailItems = document.querySelectorAll('.detail-barang-item');

            if (detailItems.length === 0) {
                e.preventDefault();
                alert('Minimal satu barang harus ditambahkan!');
                return;
            }

            // Validasi setiap detail
            let valid = true;
            detailItems.forEach((item, index) => {
                const barangSelect = item.querySelector('.barang-select');
                const jumlahInput = item.querySelector('.jumlah-input');

                if (!barangSelect.value) {
                    alert(`Barang #${index + 1} harus dipilih!`);
                    valid = false;
                    return;
                }

                if (!jumlahInput.value || jumlahInput.value < 1) {
                    alert(`Jumlah keluar untuk Barang #${index + 1} harus diisi!`);
                    valid = false;
                    return;
                }
            });

            if (!valid) {
                e.preventDefault();
            }
        });

        // Tambah satu detail barang secara default
        tambahDetailBarang();
    </script>
</x-app-layout>
