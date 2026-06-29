@extends('layouts.dashboard')

@section('title', 'Edit Slip Gaji')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-5">
        <form method="POST" action="{{ route('payrolls.update', $payroll->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1">Pegawai</label>
                <select name="employee_id"
                        class="w-full border text-sm border-neutral-300 px-4 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                    <option value="">Pilih Pegawai</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"
                            {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }} - {{ $employee->position->name }}
                        </option>
                    @endforeach
                </select>
                @error('employee_id')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Periode Bulan</label>
                    <select name="monthly_period"
                            class="w-full border text-sm border-neutral-300 px-4 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}"
                                {{ old('monthly_period', $payroll->monthly_period) == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                    @error('monthly_period')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Periode Tahun</label>
                    <input type="number" name="year_period"
                           value="{{ old('year_period', $payroll->year_period) }}"
                           class="w-full border text-sm border-neutral-300 px-4 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                    @error('year_period')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-neutral-700">Rincian Gaji</label>
                    <button type="button" onclick="addPayrollItem()"
                            class="flex items-center gap-2 border border-neutral-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-neutral-50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Rincian
                    </button>
                </div>

                <div id="payroll-items" class="space-y-2">
                    @php $oldItems = old('payrollItems', $payroll->payrollItems->toArray()); @endphp
                    @foreach ($oldItems as $i => $item)
                        <div class="payroll-item grid grid-cols-12 gap-2 items-start">
                            <div class="col-span-5">
                                <label class="block text-sm font-medium text-neutral-700 mb-1">Keterangan</label>
                                <input type="text" name="payrollItems[{{ $i }}][name]"
                                       value="{{ $item['name'] ?? '' }}"
                                       class="w-full border text-sm border-neutral-300 px-3 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                                @error("payrollItems.{$i}.name")
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-4">
                                <label class="block text-sm font-medium text-neutral-700 mb-1">Tipe</label>
                                <select name="payrollItems[{{ $i }}][type]"
                                        class="w-full border text-sm border-neutral-300 px-3 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                                    <option value="addition" {{ ($item['type'] ?? '') === 'addition' ? 'selected' : '' }}>Tunjangan</option>
                                    <option value="deduction" {{ ($item['type'] ?? '') === 'deduction' ? 'selected' : '' }}>Potongan</option>
                                </select>
                                @error("payrollItems.{$i}.type")
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-neutral-700 mb-1">Nominal</label>
                                <input type="number" name="payrollItems[{{ $i }}][amount]"
                                       value="{{ $item['amount'] ?? '' }}" min="0"
                                       class="w-full border text-sm border-neutral-300 px-3 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                                @error("payrollItems.{$i}.amount")
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-1 flex justify-center pt-6">
                                <button type="button" onclick="removePayrollItem(this)"
                                        class="bg-red-500 p-2 rounded-md hover:bg-red-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <path d="M10 11v6"/><path d="M14 11v6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                        <path d="M3 6h18"/>
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="payroll-empty" class="{{ count($oldItems) > 0 ? 'hidden' : '' }} text-center py-4 text-sm text-neutral-400 border border-dashed border-neutral-200 rounded-lg mt-2">
                    Belum ada rincian. Klik "Tambah Rincian" untuk menambahkan.
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                <a href="{{ route('payrolls.index') }}"
                   class="border border-neutral-200 text-sm font-medium px-4 py-2 rounded-lg hover:bg-neutral-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                        class="bg-neutral-800 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-neutral-700 transition-colors duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = {{ count($oldItems) }};

        function addPayrollItem() {
            const container = document.getElementById('payroll-items');
            const empty = document.getElementById('payroll-empty');

            const row = document.createElement('div');
            row.className = 'payroll-item grid grid-cols-12 gap-2 items-start';
            row.innerHTML = `
                <div class="col-span-5">
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Keterangan</label>
                    <input type="text" name="payrollItems[${itemIndex}][name]" placeholder="Contoh: PPH21, Bonus, dll"
                           class="w-full border text-sm border-neutral-300 px-3 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                </div>
                <div class="col-span-4">
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Tipe</label>
                    <select name="payrollItems[${itemIndex}][type]"
                            class="w-full border text-sm border-neutral-300 px-3 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                        <option value="">Pilih Tipe</option>
                        <option value="addition">Tunjangan</option>
                        <option value="deduction">Potongan</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Nominal</label>
                    <input type="number" name="payrollItems[${itemIndex}][amount]" placeholder="0" min="0"
                           class="w-full border text-sm border-neutral-300 px-3 py-2 rounded-lg focus:outline-none focus:border-neutral-500">
                </div>
                <div class="col-span-1 flex justify-center pt-6">
                    <button type="button" onclick="removePayrollItem(this)"
                            class="bg-red-500 p-2 rounded-md hover:bg-red-600 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                            <path d="M3 6h18"/>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                    </button>
                </div>
            `;

            container.appendChild(row);
            empty.classList.add('hidden');
            itemIndex++;
        }

        function removePayrollItem(btn) {
            btn.closest('.payroll-item').remove();
            const container = document.getElementById('payroll-items');
            if (container.children.length === 0) {
                document.getElementById('payroll-empty').classList.remove('hidden');
            }
        }
    </script>
@endsection
