<?php

namespace App\Http\Requests\Position;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePositionRequest extends FormRequest
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
            'name'         => ['required', 'string', 'max:255', Rule::unique('positions', 'name')->ignore($this->route('position'))],
            'basic_salary' => 'required|numeric',
            'sales_target' => 'nullable|numeric',

            'bonusRules'                   => 'nullable|array',
            'bonusRules.*.min_percentage'  => 'required|numeric|min:0',
            'bonusRules.*.max_percentage'  => 'nullable|numeric|min:0',
            'bonusRules.*.bonus'           => 'required|integer|min:0',

            'performanceBonuses'           => 'nullable|array',
            'performanceBonuses.*.name'    => 'required|string|max:255',
            'performanceBonuses.*.amount'  => 'nullable|numeric|min:0',

            'penalties'            => 'nullable|array',
            'penalties.*.name'     => 'required|string|max:255',
            'penalties.*.type'     => 'required|in:void,percentage',
            'penalties.*.value'    => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Nama Jabatan wajib diisi',
            'name.unique'      => 'Nama Jabatan sudah ada',

            'basic_salary.required' => 'Gaji Pokok wajib diisi',
            'basic_salary.numeric'  => 'Gaji Pokok harus berupa angka',

            'sales_target.numeric' => 'Target Penjualan harus berupa angka',

            'bonusRules.*.min_percentage.required' => 'Min. persentase wajib diisi',
            'bonusRules.*.min_percentage.numeric'  => 'Min. persentase harus berupa angka',
            'bonusRules.*.max_percentage.numeric'  => 'Max. persentase harus berupa angka',
            'bonusRules.*.bonus.required'          => 'Bonus wajib diisi',
            'bonusRules.*.bonus.integer'           => 'Bonus harus berupa angka',
            'bonusRules.*.bonus.min'               => 'Bonus tidak boleh negatif',

            'performanceBonuses.*.name.required'   => 'Nama bonus kinerja wajib diisi',
            'performanceBonuses.*.name.max'        => 'Nama bonus kinerja maksimal 255 karakter',
            'performanceBonuses.*.amount.numeric'  => 'Nominal bonus kinerja harus berupa angka',
            'performanceBonuses.*.amount.min'      => 'Nominal bonus kinerja tidak boleh negatif',

            'penalties.*.name.required'  => 'Nama penalti wajib diisi',
            'penalties.*.name.max'       => 'Nama penalti maksimal 255 karakter',
            'penalties.*.type.required'  => 'Tipe penalti wajib dipilih',
            'penalties.*.type.in'        => 'Tipe penalti harus void atau percentage',
            'penalties.*.value.required' => 'Nilai penalti wajib diisi',
            'penalties.*.value.numeric'  => 'Nilai penalti harus berupa angka',
            'penalties.*.value.min'      => 'Nilai penalti tidak boleh negatif',
        ];
    }
}
