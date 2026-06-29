@extends('layouts.dashboard')

@section('title', 'Tambah Penggajian')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-4">
        <form method="POST" action="{{ route('payrolls.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Pegawai
                </label>

                <select
                    name="employee_id"
                    id="employee_id"
                    class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                >
                    <option value="">Pilih Pegawai</option>

                    @foreach ($employees as $employee)
                        <option
                            value="{{ $employee->id }}"
                            {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                        >
                            {{ $employee->name }} - {{ $employee->position->name }}
                        </option>
                    @endforeach
                </select>

                @error('employee_id')
                    <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="monthly_period" class="block text-sm font-medium text-gray-700 mb-1">Periode Bulan</label>
                    <input
                        type="text"
                        name="monthly_period"
                        id="monthly_period"
                        placeholder="Contoh: 7"
                        value="{{ old('monthly_period', now()->month) }}"
                        class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                    >
                    @error('monthly_period')
                    <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="year_period" class="block text-sm font-medium text-gray-700 mb-1">Periode Tahun</label>
                    <input
                        type="text"
                        name="year_period"
                        id="year_period"
                        placeholder="Contoh: 2026"
                        value="{{ old('year_period', now()->year) }}"
                        class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                    >
                    @error('year_period')
                        <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-medium text-gray-700">Rincian Gaji</label>
                    <button
                        type="button"
                        onclick="addPayrollItem()"
                        class="flex items-center gap-2 bg-transparent border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-neutral-100 transition-colors duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Rincian
                    </button>
                </div>

                <div id="payroll-items" class="space-y-2">
                    @if (old('payrollItems'))
                        @foreach (old('payrollItems') as $i => $item)
                            <div class="payroll-item grid grid-cols-12 gap-2 items-start">
                                <div class="col-span-5">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                    <input
                                        type="text"
                                        name="payrollItems[{{ $i }}][name]"
                                        placeholder="Keterangan"
                                        value="{{ $item['name'] ?? '' }}"
                                        class="w-full border text-sm border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                                    >
                                    @error("payrollItems.{$i}.name")
                                    <div class="mt-1 text-red-500 text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-4">
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                                    <select
                                        name="payrollItems[{{ $i }}][type]"
                                        class="w-full border text-sm border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                                    >
                                        <option value="">Tipe</option>
                                        <option value="addition" {{ ($item['type'] ?? '') === 'addition' ? 'selected' : '' }}>Addition</option>
                                        <option value="deduction" {{ ($item['type'] ?? '') === 'deduction' ? 'selected' : '' }}>Deduction</option>
                                    </select>
                                    @error("payrollItems.{$i}.type")
                                    <div class="mt-1 text-red-500 text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Nominal</label>
                                    <input
                                        type="number"
                                        name="payrollItems[{{ $i }}][amount]"
                                        placeholder="Nominal"
                                        value="{{ $item['amount'] ?? '' }}"
                                        min="0"
                                        class="w-full border text-sm border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                                    >
                                    @error("payrollItems.{$i}.amount")
                                    <div class="mt-1 text-red-500 text-xs">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-1 flex justify-center pt-6">
                                    <button type="button" onclick="removePayrollItem(this)" class="bg-red-500 w-fit h-fit p-2 rounded-md hover:bg-red-600 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 w-4 h-4"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div id="payroll-empty" class="{{ old('payrollItems') ? 'hidden' : '' }} text-center py-4 text-sm text-gray-400 border border-dashed border-gray-200 rounded-lg">
                    Belum ada rincian. Klik "Tambah Rincian" untuk menambahkan.
                </div>
            </div>

            <div class="col-span-2 flex gap-2 justify-end">
                <a href="{{ route('payrolls.index') }}" class="bg-gray-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="bg-cyan-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-cyan-700">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = {{ old('payrollItems') ? count(old('payrollItems')) : 0 }};

        function addPayrollItem() {
            const container = document.getElementById('payroll-items');
            const empty = document.getElementById('payroll-empty');

            const row = document.createElement('div');
            row.className = 'payroll-item grid grid-cols-12 gap-2';
            row.innerHTML = `
                <div class="col-span-5">
                    <label for="payrollItems[${itemIndex}][name]" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <input
                        type="text"
                        name="payrollItems[${itemIndex}][name]"
                        placeholder="Contoh: PPH21, Bonus, dll"
                        class="w-full border text-sm border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                    >
                </div>
                <div class="col-span-4">
                    <label for="payrollItems[${itemIndex}][type]" class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <select
                        name="payrollItems[${itemIndex}][type]"
                        class="w-full border text-sm border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                    >
                        <option value="">Pilih Tipe</option>
                        <option value="addition">Addition</option>
                        <option value="deduction">Deduction</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="payrollItems[${itemIndex}][amount]" class="block text-sm font-medium text-gray-700 mb-1">Nominal</label>
                    <input
                        type="number"
                        name="payrollItems[${itemIndex}][amount]"
                        placeholder="Nominal"
                        min="0"
                        class="w-full border text-sm border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                    >
                </div>
                <div class="col-span-1 flex justify-center pt-6">
                    <button type="button" onclick="removePayrollItem(this)" class="bg-red-500 w-fit h-fit p-2 rounded-md hover:bg-red-600 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 w-4 h-4"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </div>
            `;

            container.appendChild(row);
            empty.classList.add('hidden');
            itemIndex++;
        }

        function removePayrollItem(btn) {
            const row = btn.closest('.payroll-item');
            row.remove();

            const container = document.getElementById('payroll-items');
            const empty = document.getElementById('payroll-empty');
            if (container.children.length === 0) {
                empty.classList.remove('hidden');
            }
        }
    </script>
@endsection
