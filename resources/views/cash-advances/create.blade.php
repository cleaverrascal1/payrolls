@extends('layouts.dashboard')

@section('title', 'Tambah Kasbon')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-4">
        <form method="POST" action="{{ route('cash-advances.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="employee_id" class="block text-sm font-medium text-neutral-700 mb-1">
                    Pilih Pegawai
                </label>

                <select
                    name="employee_id"
                    id="employee_id"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('employee_id') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                    <option value="">Pilih Pegawai</option>

                    @foreach ($employees as $employee)
                        <option
                            value="{{ $employee->id }}"
                            {{ old('position_id') == $employee->id ? 'selected' : '' }}
                        >
                            {{ $employee->name }} - {{ $employee->position->name }}
                        </option>
                    @endforeach
                </select>

                @error('employee_id')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="amount" class="block text-sm font-medium text-neutral-700 mb-1">Amount</label>
                <input
                    type="number"
                    name="amount"
                    id="amount"
                    placeholder="Contoh: 100000"
                    value="{{ old('amount') }}"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('amount') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                @error('amount')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-neutral-700 mb-1">Deskripsi</label>
                <textarea
                    name="description"
                    id="description"
                    placeholder="Masukan deskripsi kasbon"
                    rows="5"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('address') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2 flex gap-2 justify-end">
                <a href="{{ route('cash-advances.index') }}" class="bg-neutral-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-neutral-700">Kembali</a>
                <button type="submit" class="bg-[#347839] text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-[#22552d]">Simpan</button>
            </div>
        </form>
    </div>
@endsection
