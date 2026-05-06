<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_file' => ['required', 'string', 'max:255'],
            'bahasa'    => ['required', 'in:id,en'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_file.required' => 'Nama file CV wajib diisi.',
            'nama_file.max'      => 'Nama file tidak boleh lebih dari 255 karakter.',
            'bahasa.required'    => 'Pilih bahasa CV.',
            'bahasa.in'          => 'Bahasa harus berupa Indonesia atau English.',
        ];
    }
}
