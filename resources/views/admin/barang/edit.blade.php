<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Barang: ') }} <span class="text-indigo-600 dark:text-indigo-400">{{ $barang->nama_barang }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.barang.update', $barang) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-8">

                        <!-- Bagian 1: Informasi Dasar -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Informasi Dasar</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                    <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full" :value="old('nama_barang', $barang->nama_barang)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('nama_barang')" />
                                </div>
                                <div>
                                    <x-input-label for="kode_barang" :value="__('Kode Barang')" />
                                    <x-text-input id="kode_barang" name="kode_barang" type="text" class="mt-1 block w-full" :value="old('kode_barang', $barang->kode_barang)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('kode_barang')" />
                                </div>
                                <div>
                                    <x-input-label for="kategori_id" :value="__('Kategori')" />
                                    <select id="kategori_id" name="kategori_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('kategori_id')" />
                                </div>
                                <div>
                                    <x-input-label for="satuan" :value="__('Satuan')" />
                                    <select id="satuan" name="satuan" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="pcs" {{ old('satuan', $barang->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                        <option value="unit" {{ old('satuan', $barang->satuan) == 'unit' ? 'selected' : '' }}>Unit</option>
                                        <option value="box" {{ old('satuan', $barang->satuan) == 'box' ? 'selected' : '' }}>Box</option>
                                        <option value="kg" {{ old('satuan', $barang->satuan) == 'kg' ? 'selected' : '' }}>Kg</option>
                                        <option value="gram" {{ old('satuan', $barang->satuan) == 'gram' ? 'selected' : '' }}>Gram</option>
                                        <option value="liter" {{ old('satuan', $barang->satuan) == 'liter' ? 'selected' : '' }}>Liter</option>
                                        <option value="meter" {{ old('satuan', $barang->satuan) == 'meter' ? 'selected' : '' }}>Meter</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('satuan')" />
                                </div>
                            </div>
                        </div>

                        <!-- Catatan: Stok & Harga tidak diedit di sini untuk menjaga integritas data transaksi -->
                        <!-- Jika Anda ingin mengeditnya, Anda bisa menambahkan formnya di sini -->

                        <!-- Bagian 3: Detail Tambahan -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">Detail Tambahan</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="merk" :value="__('Merk (Opsional)')" />
                                    <x-text-input id="merk" name="merk" type="text" class="mt-1 block w-full" :value="old('merk', $barang->merk)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('merk')" />
                                </div>
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                        <option value="aktif" {{ old('status', $barang->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="tidak_aktif" {{ old('status', $barang->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                                    <textarea id="deskripsi" name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
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
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
