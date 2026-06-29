@extends('layouts.dashboard')

@section('title', 'Slip Gaji')

@section('content')
    <div class="w-full space-y-4">
        <div class="bg-white rounded-xl border border-gray-300 overflow-auto">
            <div class="flex items-center justify-between gap-3 p-6">
                <div class="">
                    <img src="https://www.digitalpowertalent.com/images/logo.png" alt="Logo" class="w-12 h-12">
                </div>

                <div class="flex flex-col items-start gap-2">
                    <div class="w-full flex items-center justify-between gap-8 text-sm">
                        <p class="font-semibold">Tanggal</p>
                        <p class="text-neutral-800">{{ \Carbon\Carbon::parse($payroll->payday)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="w-full flex items-center justify-between gap-8 text-sm  text-nowrap">
                        <p class="font-semibold">No. Slip Gaji</p>
                        <p class="text-neutral-800">{{ $payroll->id }}</p>
                    </div>
                </div>
            </div>

            <div class="h-[1px] w-full bg-gray-300"></div>

            <div class="grid grid-cols-2 gap-3 p-6">
                <div>
                    <p class="text-xs mb-0.5">Nama Pegawai</p>
                    <p class="text-sm">{{ $payroll->employee->name }}</p>
                </div>
                <div>
                    <p class="text-xs mb-0.5">Jabatan</p>
                    <p class="text-sm">{{ $payroll->position }}</p>
                </div>

                <div>
                    <p class="text-xs mb-0.5">Alamat</p>
                    <p class="text-sm">{{ $payroll->employee->address }}</p>
                </div>

                <div>
                    <p class="text-xs mb-0.5">Periode</p>
                    <p class="text-sm">
                        {{ DateTime::createFromFormat('!m', $payroll->monthly_period)->format('F') }}
                        {{ $payroll->year_period }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 md:gap-20 px-6 py-3 border-y border-gray-300">
                <p class="text-sm font-medium">Absensi</p>
                <p class="text-sm font-medium">Pendapatan</p>
                <p class="text-sm font-medium">Potongan</p>
            </div>

            <div class="px-6 pt-2 pb-6">
                <div class="grid grid-cols-3 gap-4 md:gap-20 mb-4">
                    <div class="overflow-hidden">

                        <div class="flex justify-between items-center py-1 text-sm">
                            <span>Hadir</span>
                            <span>{{ $attendances->where('hadir', true)->count() }} hari</span>
                        </div>
                        <div class="flex justify-between items-center py-1 text-sm">
                            <span>Sakit</span>
                            <span>{{ $attendances->where('sakit', true)->count() }} hari</span>
                        </div>
                        <div class="flex justify-between items-center py-1 text-sm">
                            <span>Izin</span>
                            <span>{{ $attendances->where('izin', true)->count() }} hari</span>
                        </div>
                        <div class="flex justify-between items-center py-1 text-sm">
                            <span>Alfa</span>
                            <span>{{ $attendances->where('alpa', true)->count() }} hari</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center py-1 text-sm">
                            <span>Gaji Pokok</span>
                            <span>Rp{{ number_format($payroll->salary, 0, ',', '.') }}</span>
                        </div>
                        @foreach ($payroll->payrollItems->where('type', '!=', 'deduction') as $item)
                            <div class="flex justify-between items-center py-1 text-sm">
                                    <span>
                                        {{ $item->name }}
                                    </span>
                                <span>+ Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        @forelse ($payroll->payrollItems->where('type', 'deduction') as $item)
                            <div class="flex justify-between items-center py-1 text-sm">
                                <span>{{ $item->name }}</span>
                                <span>- Rp{{ number_format($item->amount, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <div class="px-3 py-4 text-center text-gray-400 text-xs">Tidak ada potongan</div>
                        @endforelse
                    </div>

                </div>

                <div class="flex justify-between items-center">
                    <span class="font-bold ">Total Gaji Diterima</span>
                    <span class="font-bold">Rp{{ number_format($payroll->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="px-7 py-4 border-t border-gray-300 flex justify-between items-end">
                <div>
                    <p class="text-xs text-gray-400">Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="text-xs text-gray-400">Dokumen ini digenerate secara otomatis.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-400">Menyetujui,</p>
                    <p class="text-sm text-gray-400 mt-20 font-medium ">HRD / Pimpinan</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('payrolls.index') }}"
               class="bg-gray-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700">
                Kembali
            </a>
            <a href="{{ route('payrolls.download', $payroll->id) }}"
               class="bg-cyan-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-cyan-700">
                Download PDF
            </a>
        </div>

    </div>
@endsection
