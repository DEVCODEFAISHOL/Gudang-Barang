<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Permintaan Barang') }}
            </h2>
            <a href="{{ route('admin.permintaan.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <strong>Whoops!</strong> Ada beberapa kesalahan dengan input Anda.
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.permintaan.store') }}" method="POST" id="permintaanForm">
                        @csrf

                        <!-- Informasi Umum -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Permintaan</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tanggal_permintaan"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Permintaan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="tanggal_permintaan" name="tanggal_permintaan"
                                        value="{{ old('tanggal_permintaan', date('Y-m-d')) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tanggal_permintaan') border-red-500 @enderror">
                                    @error('tanggal_permintaan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Keterangan
                                    </label>
                                    <textarea id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan permintaan..."
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Detail Barang -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Detail Barang</h3>
                                <button type="button" id="addItem"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Barang
                                </button>
                            </div>

                            <div id="itemContainer">
                                <!-- Template untuk item barang -->
                                <div class="item-row bg-gray-50 p-4 rounded-lg mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Pilih Barang <span class="text-red-500">*</span>
                                            </label>
                                            <select name="details[0][barang_id]"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 barang-select"
                                                required>
                                                <option value="">Pilih Barang...</option>
                                                @foreach ($barangs as $barang)
                                                    {{-- Format Baru: Nama (Kode: XXX) - Stok: YYY --}}
                                                    <option value="{{ $barang->id }}">
                                                        {{ $barang->nama_barang }} (Kode: {{ $barang->kode_barang }}) -
                                                        Stok: {{ $barang->stok->jumlah_stok ?? 0 }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Jumlah Diminta <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex">
                                                <input type="number" name="details[0][jumlah_diminta]"
                                                    value="{{ old('details.0.jumlah_diminta') }}" min="1"
                                                    placeholder="0"
                                                    class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 jumlah-input"
                                                    required>
                                                <button type="button"
                                                    class="bg-red-500 hover:bg-red-700 text-white px-3 py-2 rounded-r-md remove-item"
                                                    onclick="removeItem(this)">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <small class="text-gray-500 stok-info">Stok tersedia: -</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @error('details')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.permintaan.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Simpan Permintaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let itemIndex = 1;

            document.getElementById('addItem').addEventListener('click', function() {
                const container = document.getElementById('itemContainer');
                const newItem = createNewItem(itemIndex);
                container.appendChild(newItem);
                itemIndex++;
            });

            function createNewItem(index) {
                const div = document.createElement('div');
                div.className = 'item-row bg-gray-50 p-4 rounded-lg mb-4';
                div.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Barang <span class="text-red-500">*</span>
                        </label>
                        <select name="details[${index}][barang_id]"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 barang-select"
                                required>
                            <option value="">Pilih Barang...</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}"
                                        data-stok="{{ $barang->stok->jumlah ?? 0 }}">
                                    {{ $barang->nama_barang }} (Kode: {{ $barang->kode_barang }}) - Stok: {{ $barang->stok->jumlah ?? 0 }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Diminta <span class="text-red-500">*</span>
                        </label>
                        <div class="flex">
                            <input type="number"
                                   name="details[${index}][jumlah_diminta]"
                                   min="1"
                                   placeholder="0"
                                   class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 jumlah-input"
                                   required>
                            <button type="button"
                                    class="bg-red-500 hover:bg-red-700 text-white px-3 py-2 rounded-r-md remove-item"
                                    onclick="removeItem(this)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        <small class="text-gray-500 stok-info">Stok tersedia: -</small>
                    </div>
                </div>
            `;

                // Add event listener untuk select barang
                const select = div.querySelector('.barang-select');
                const stokInfo = div.querySelector('.stok-info');

                select.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const stok = selectedOption.getAttribute('data-stok') || '-';
                    stokInfo.textContent = `Stok tersedia: ${stok}`;
                });

                return div;
            }

            function removeItem(button) {
                const itemRow = button.closest('.item-row');
                const container = document.getElementById('itemContainer');

                // Jangan hapus jika hanya ada 1 item
                if (container.children.length > 1) {
                    itemRow.remove();
                } else {
                    alert('Minimal harus ada satu barang dalam permintaan');
                }
            }

            // Event listener untuk barang select yang sudah ada
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('barang-select')) {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const stok = selectedOption.getAttribute('data-stok') || '-';
                    const stokInfo = e.target.closest('.item-row').querySelector('.stok-info');
                    stokInfo.textContent = `Stok tersedia: ${stok}`;
                }
            });

            // Validasi form sebelum submit
            document.getElementById('permintaanForm').addEventListener('submit', function(e) {
                const barangSelects = document.querySelectorAll('.barang-select');
                const selectedBarangs = [];
                let isValid = true;

                // Cek duplikasi barang
                barangSelects.forEach(function(select) {
                    if (select.value) {
                        if (selectedBarangs.includes(select.value)) {
                            alert('Tidak boleh ada barang yang sama dalam satu permintaan');
                            isValid = false;
                            e.preventDefault();
                            return;
                        }
                        selectedBarangs.push(select.value);
                    }
                });

                // Cek minimal satu barang
                if (selectedBarangs.length === 0) {
                    alert('Minimal harus ada satu barang dalam permintaan');
                    isValid = false;
                    e.preventDefault();
                }
            });
        </script>
    @endpush
</x-app-layout>
