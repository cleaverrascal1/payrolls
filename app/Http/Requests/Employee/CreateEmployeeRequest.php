<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'address' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Karyawan wajib diisi',
            'name.string' => 'Nama Karyawan harus berupa teks',
            'name.max' => 'Nama Karyawan maksimal 255 karakter',

            'position_id.required' => 'Jabatan wajib dipilih',
            'position_id.exists' => 'Jabatan yang dipilih tidak valid',

            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Alamat harus berupa teks',
        ];
    }
}
