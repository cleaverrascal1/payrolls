@extends('layouts.dashboard')

@section('title', 'Tambah Absensi')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-4">
        <form method="POST" action="{{ route('attendances.store') }}" class="space-y-4">
            @csrf

            {{-- Tanggal --}}
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal
                </label>
                <input
                    type="date"
                    name="date"
                    id="date"
                    value="{{ old('date', today()->toDateString()) }}"
                    class="w-full border text-sm border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-cyan-600"
                >
                @error('date')
                <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tabel Absensi Pegawai --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Data Absensi Pegawai
                </label>

                @if ($employees->isEmpty())
                    <div class="text-center py-6 text-sm text-gray-400 border border-dashed border-gray-200 rounded-lg">
                        Belum ada data pegawai.
                    </div>
                @else
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="text-left px-4 py-3 font-medium w-8">#</th>
                                <th class="text-left px-4 py-3 font-medium">Nama Pegawai</th>
                                <th class="text-left px-4 py-3 font-medium">Jabatan</th>
                                <th class="text-center px-4 py-3 font-medium">Hadir</th>
                                <th class="text-center px-4 py-3 font-medium">Sakit</th>
                                <th class="text-center px-4 py-3 font-medium">Izin</th>
                                <th class="text-center px-4 py-3 font-medium">Alpa</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            @foreach ($employees as $i => $employee)
                                @php
                                    $oldStatus = old("attendances.{$i}.status", 'hadir');
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        {{ $employee->name }}
                                        <input type="hidden" name="attendances[{{ $i }}][employee_id]" value="{{ $employee->id }}">
                                    </td>
                                    <td class="px-4 py-3 text-gray-500">{{ $employee->position->name }}</td>

                                    @foreach (['hadir', 'sakit', 'izin', 'alpa'] as $status)
                                        <td class="px-4 py-3 text-center">
                                            <input
                                                type="radio"
                                                name="attendances[{{ $i }}][status]"
                                                value="{{ $status }}"
                                                {{ $oldStatus === $status ? 'checked' : '' }}
                                                class="w-4 h-4 accent-cyan-600 cursor-pointer"
                                            >
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- Error row --}}
                                @if ($errors->has("attendances.{$i}.status"))
                                    <tr>
                                        <td colspan="7" class="px-4 pb-2">
                                                <span class="text-red-500 text-xs">
                                                    {{ $errors->first("attendances.{$i}.status") }}
                                                </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex gap-2 justify-end">

               <a href="{{ route('attendances.index') }}"
                class="bg-gray-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700"
                >
                Kembali
                </a>
                <button
                    type="submit"
                    class="bg-cyan-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-cyan-700"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
