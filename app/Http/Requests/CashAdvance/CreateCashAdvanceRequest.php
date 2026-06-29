<?php

namespace App\Http\Requests\CashAdvance;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCashAdvanceRequest extends FormRequest
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
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Pegawai wajib dipilih.',
            'employee_id.exists' => 'Pegawai yang dipilih tidak valid.',

            'amount.required' => 'Nominal kasbon wajib diisi.',
            'amount.integer' => 'Nominal kasbon harus berupa angka bulat.',
            'amount.min' => 'Nominal kasbon minimal Rp1.',

            'description.string' => 'Keterangan harus berupa teks.',
            'description.max' => 'Keterangan maksimal 1000 karakter.',
        ];
    }
}
