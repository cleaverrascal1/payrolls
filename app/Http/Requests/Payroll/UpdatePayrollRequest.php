<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => [
                'required',
                'exists:employees,id',
                Rule::unique('payrolls')
                    ->where(fn($query) => $query
                        ->where('monthly_period', $this->monthly_period)
                        ->where('year_period', $this->year_period)
                    )
                    ->ignore($this->route('payroll')),
            ],
            'monthly_period' => 'required|integer|between:1,12',
            'year_period'    => 'required|integer|digits:4',

            'payrollItems'          => 'nullable|array',
            'payrollItems.*.name'   => 'required|string|max:255',
            'payrollItems.*.type'   => ['required', 'in:addition,deduction'],
            'payrollItems.*.amount' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Pegawai wajib dipilih',
            'employee_id.exists'   => 'Pegawai yang dipilih tidak valid',
            'employee_id.unique'   => 'Pegawai ini sudah memiliki slip gaji untuk periode tersebut.',

            'monthly_period.required' => 'Periode bulan wajib dipilih',
            'monthly_period.integer'  => 'Periode bulan tidak valid',
            'monthly_period.between'  => 'Periode bulan harus antara 1 sampai 12',

            'year_period.required' => 'Periode tahun wajib diisi',
            'year_period.integer'  => 'Periode tahun harus berupa angka',
            'year_period.digits'   => 'Periode tahun harus terdiri dari 4 digit',

            'payrollItems.array'           => 'Format payroll item tidak valid',
            'payrollItems.*.name.required' => 'Nama rincian wajib diisi',
            'payrollItems.*.type.required' => 'Tipe rincian wajib diisi',
            'payrollItems.*.type.in'       => 'Tipe rincian harus berupa addition atau deduction',
            'payrollItems.*.amount.required' => 'Nominal rincian wajib diisi',
            'payrollItems.*.amount.integer'  => 'Nominal rincian harus berupa angka',
            'payrollItems.*.amount.min'      => 'Nominal rincian tidak boleh negatif',
        ];
    }
}
