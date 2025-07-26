<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventarisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'tanggal_inventaris' => 'required|date',
            'catatan'            => 'nullable|string',
            'details'            => 'required|array|min:1',
            'details.*.barang_id'   => 'required|exists:barangs,id',
            'details.*.stok_fisik'  => 'required|integer|min:0',
            'details.*.keterangan'  => 'nullable|string',
        ];
    }
}
