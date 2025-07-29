<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBarangRequest extends FormRequest
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
        $barangId = $this->route('barang')->id;

        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_barang' => [
                'required',
                'string',
                'max:50',
                Rule::unique('barangs', 'kode_barang')->ignore($barangId)
            ],
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'required|string|in:pcs,kg,liter,meter,unit,set,box,pack,gram,ton,ml',
            'deskripsi' => 'nullable|string|max:1000',
            'harga_beli' => 'nullable|numeric|min:0|max:999999999.99',
            'harga_jual' => 'nullable|numeric|min:0|max:999999999.99',
            'status' => 'required|string|in:aktif,tidak_aktif',
            'spesifikasi' => 'nullable|string|max:1000',
            'merk' => 'nullable|string|max:100',
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
            'kode_barang.unique' => 'Kode barang sudah digunakan oleh barang lain.',
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
        ];
    }
}
