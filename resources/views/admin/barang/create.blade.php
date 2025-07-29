<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Barang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.barang.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-8">

                        <!-- Bagian 1: Informasi Dasar -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Informasi Dasar</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                    <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full" :value="old('nama_barang')" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('nama_barang')" />
                                </div>
                                <div>
                                    <x-input-label for="kode_barang" :value="__('Kode Barang')" />
                                    <x-text-input id="kode_barang" name="kode_barang" type="text" class="mt-1 block w-full" :value="old('kode_barang', $suggestedKode)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('kode_barang')" />
                                </div>
                                <div>
                                    <x-input-label for="kategori_id" :value="__('Kategori')" />
                                    <select id="kategori_id" name="kategori_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('kategori_id')" />
                                </div>
                                <div>
                                    <x-input-label for="satuan" :value="__('Satuan')" />
                                    <select id="satuan" name="satuan" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                        <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>Unit</option>
                                        <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
                                        <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
                                        <option value="gram" {{ old('satuan') == 'gram' ? 'selected' : '' }}>Gram</option>
                                        <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                                        <option value="meter" {{ old('satuan') == 'meter' ? 'selected' : '' }}>Meter</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('satuan')" />
                                </div>
                            </div>
                        </div>

                        <!-- Bagian 2: Stok dan Harga -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Stok & Harga</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="jumlah_stok_awal" :value="__('Jumlah Stok Awal')" />
                                    <x-text-input id="jumlah_stok_awal" name="jumlah_stok_awal" type="number" class="mt-1 block w-full" :value="old('jumlah_stok_awal', 0)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('jumlah_stok_awal')" />
                                </div>
                                <div>
                                    <x-input-label for="stok_aman" :value="__('Batas Stok Aman')" />
                                    <x-text-input id="stok_aman" name="stok_aman" type="number" class="mt-1 block w-full" :value="old('stok_aman', 10)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('stok_aman')" />
                                </div>
                                <div>
                                    <x-input-label for="harga_beli" :value="__('Harga Beli (Opsional)')" />
                                    <x-text-input id="harga_beli" name="harga_beli" type="number" step="0.01" class="mt-1 block w-full" :value="old('harga_beli')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('harga_beli')" />
                                </div>
                                <div>
                                    <x-input-label for="harga_jual" :value="__('Harga Jual (Opsional)')" />
                                    <x-text-input id="harga_jual" name="harga_jual" type="number" step="0.01" class="mt-1 block w-full" :value="old('harga_jual')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('harga_jual')" />
                                </div>
                            </div>
                        </div>

                        <!-- Bagian 3: Detail Tambahan -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Detail Tambahan</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="merk" :value="__('Merk (Opsional)')" />
                                    <x-text-input id="merk" name="merk" type="text" class="mt-1 block w-full" :value="old('merk')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('merk')" />
                                </div>
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                                    <textarea id="deskripsi" name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('admin.barang.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            Batal
                        </a>
                        <x-primary-button>
                            {{ __('Simpan Barang') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
