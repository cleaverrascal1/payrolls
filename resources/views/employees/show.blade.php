@extends('layouts.dashboard')

@section('title', 'Detail Pegawai')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="space-y-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pegawai</label>
                <input
                    type="text"
                    value="{{ $employee->name }}"
                    disabled
                    class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                <input
                    type="text"
                    value="{{ $employee->position?->name ?? '-' }}"
                    disabled
                    class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input
                    type="text"
                    value="{{ $employee->address ?? '-' }}"
                    disabled
                    class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat Pada</label>
                <input
                    type="text"
                    value="{{ \Carbon\Carbon::parse($employee->created_at)->translatedFormat('d F Y, H:i') }}"
                    disabled
                    class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diperbarui Pada</label>
                <input
                    type="text"
                    value="{{ \Carbon\Carbon::parse($employee->updated_at)->translatedFormat('d F Y, H:i') }}"
                    disabled
                    class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                >
            </div>

            <div class="flex gap-2 justify-end">
                <a href="{{ route('employees.index') }}"
                   class="bg-gray-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700">
                    Kembali
                </a>
                <a href="{{ route('employees.edit', $employee->id) }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-50 border border-gray-300">
                    Edit
                </a>
            </div>

        </div>
    </div>
@endsection
