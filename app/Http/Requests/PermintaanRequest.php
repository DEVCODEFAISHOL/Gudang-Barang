<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermintaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'tanggal_permintaan' => 'required|date',
            'keterangan'         => 'nullable|string',
            'details'            => 'required|array|min:1',
            'details.*.barang_id'      => 'required|exists:barangs,id',
            'details.*.jumlah_diminta' => 'required|integer|min:1',
        ];
    }
}
