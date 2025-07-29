<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengeluaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'tanggal_pengeluaran' => ['required', 'date'],
            'penerima' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'details' => ['required', 'array', 'min:1'],

            'details.*.barang_id' => ['required', 'exists:barangs,id'],
            'details.*.jumlah_keluar' => ['required', 'integer', 'min:1'],
            'details.*.keterangan_detail' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_pengeluaran.required' => 'Tanggal pengeluaran wajib diisi.',
            'penerima.required' => 'penerima pengeluaran harus diisi.',
            'details.required' => 'Minimal satu barang harus ditambahkan.',
            'details.*.barang_id.required' => 'Barang harus dipilih.',
            'details.*.jumlah_keluar.required' => 'Jumlah keluar harus diisi.',
            'details.*.jumlah_keluar.min' => 'Jumlah keluar minimal 1.',
        ];
    }
}
