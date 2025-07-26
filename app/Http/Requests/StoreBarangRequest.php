<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin'); // Hanya admin yang boleh
    }

    public function rules(): array
    {
        return [
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang',
            'kategori_id' => 'required|exists:kategoris,id',
            'satuan'      => 'required|string|max:50',
        ];
    }
}
