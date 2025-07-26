<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStokRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Pastikan hanya admin yang bisa melakukan ini
        return $this->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validasi hanya untuk stok aman
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_stok' => 'required|integer|min:0',
            'stok_aman' => 'required|integer|min:0',
        ];
    }
}
