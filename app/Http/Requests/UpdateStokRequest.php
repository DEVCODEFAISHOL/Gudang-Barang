<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStokRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jumlah_stok' => 'required|integer|min:0|max:999999',
            'stok_aman' => 'required|integer|min:1|max:999999',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'stok_aman.required' => 'Batas stok aman wajib diisi.',
            'stok_aman.integer' => 'Batas stok aman harus berupa angka bulat.',
            'stok_aman.min' => 'Batas stok aman minimal adalah 1.',
            'stok_aman.max' => 'Batas stok aman maksimal adalah 999,999.',
            'lokasi_penyimpanan.string' => 'Lokasi penyimpanan harus berupa teks.',
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
            'stok_aman' => 'batas stok aman',
            'lokasi_penyimpanan' => 'lokasi penyimpanan',
        ];
    }
}
