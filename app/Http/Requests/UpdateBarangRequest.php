<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        $barangId = $this->route('barang')->id; // Ambil ID barang dari route
        return [
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => ['required', 'string', 'max:50', Rule::unique('barangs')->ignore($barangId)],
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan'      => 'required|string|max:50',
        ];
    }
}
