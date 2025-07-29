<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'required|string|in:pcs,kg,liter,meter,unit,set,box,pack,gram,ton,ml',
            'deskripsi' => 'nullable|string|max:1000',
            'harga_beli' => 'nullable|numeric|min:0|max:999999999.99',
            'harga_jual' => 'nullable|numeric|min:0|max:999999999.99',
            'status' => 'required|string|in:aktif,tidak_aktif',
            'spesifikasi' => 'nullable|string|max:1000',
            'merk' => 'nullable|string|max:100',
            'jumlah_stok_awal' => 'nullable|integer|min:0|max:999999',
            'stok_aman' => 'nullable|integer|min:0|max:999999',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kategori_id.required' => 'Kategori harus dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'kode_barang.required' => 'Kode barang harus diisi.',
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
            'kode_barang.max' => 'Kode barang maksimal 50 karakter.',
            'nama_barang.required' => 'Nama barang harus diisi.',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter.',
            'satuan.required' => 'Satuan harus dipilih.',
            'satuan.in' => 'Satuan yang dipilih tidak valid.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'harga_beli.min' => 'Harga beli tidak boleh kurang dari 0.',
            'harga_beli.max' => 'Harga beli terlalu besar.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual tidak boleh kurang dari 0.',
            'harga_jual.max' => 'Harga jual terlalu besar.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'spesifikasi.max' => 'Spesifikasi maksimal 1000 karakter.',
            'merk.max' => 'Merk maksimal 100 karakter.',
            'jumlah_stok_awal.integer' => 'Jumlah stok awal harus berupa angka bulat.',
            'jumlah_stok_awal.min' => 'Jumlah stok awal tidak boleh kurang dari 0.',
            'jumlah_stok_awal.max' => 'Jumlah stok awal terlalu besar.',
            'stok_aman.integer' => 'Stok aman harus berupa angka bulat.',
            'stok_aman.min' => 'Stok aman tidak boleh kurang dari 0.',
            'stok_aman.max' => 'Stok aman terlalu besar.',
            'lokasi_penyimpanan.max' => 'Lokasi penyimpanan maksimal 255 karakter.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'kategori_id' => 'kategori',
            'kode_barang' => 'kode barang',
            'nama_barang' => 'nama barang',
            'satuan' => 'satuan',
            'deskripsi' => 'deskripsi',
            'harga_beli' => 'harga beli',
            'harga_jual' => 'harga jual',
            'status' => 'status',
            'spesifikasi' => 'spesifikasi',
            'merk' => 'merk',
            'jumlah_stok_awal' => 'jumlah stok awal',
            'stok_aman' => 'stok aman',
            'lokasi_penyimpanan' => 'lokasi penyimpanan',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean up kode_barang - remove spaces and convert to uppercase
        if ($this->has('kode_barang')) {
            $this->merge([
                'kode_barang' => strtoupper(trim(str_replace(' ', '', $this->kode_barang)))
            ]);
        }

        // Clean up nama_barang - trim spaces
        if ($this->has('nama_barang')) {
            $this->merge([
                'nama_barang' => trim($this->nama_barang)
            ]);
        }

        // Set default values
        $this->merge([
            'status' => $this->status ?? 'aktif',
            'jumlah_stok_awal' => $this->jumlah_stok_awal ?? 0,
            'stok_aman' => $this->stok_aman ?? 10,
        ]);
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Custom validation: harga_jual should be greater than harga_beli
            if ($this->harga_beli && $this->harga_jual) {
                if ($this->harga_jual <= $this->harga_beli) {
                    $validator->errors()->add('harga_jual', 'Harga jual harus lebih besar dari harga beli.');
                }
            }

            // Custom validation: check if kode_barang format is valid
            if ($this->kode_barang) {
                if (!preg_match('/^[A-Z0-9\-_]+$/', $this->kode_barang)) {
                    $validator->errors()->add('kode_barang', 'Kode barang hanya boleh mengandung huruf kapital, angka, tanda hubung (-), dan underscore (_).');
                }
            }
        });
    }
}
