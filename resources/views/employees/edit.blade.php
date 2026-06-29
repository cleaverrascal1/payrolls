@extends('layouts.dashboard')

@section('title', 'Edit Pegawai')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-4">
        <form method="POST" action="{{ route('employees.update', $employee->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-neutral-700 mb-1">Category Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $employee->name) }}"
                    placeholder="Masukan nama pegawai"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('name') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                @error('name')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="position_id" class="block text-sm font-medium text-neutral-700 mb-1">
                    Jabatan
                </label>

                <select
                    name="position_id"
                    id="position_id"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('position_id') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                    <option value="">Pilih Jabatan</option>

                    @foreach ($positions as $position)
                        <option
                            value="{{ $position->id }}"
                            @selected(old('position_id', $employee->position_id) == $position->id)
                        >
                            {{ $position->name }}
                        </option>
                    @endforeach
                </select>

                @error('position_id')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea
                    name="address"
                    id="address"
                    placeholder="Masukan alamat pegawai"
                    rows="5"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('address') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >{{ old('address') ?? $employee->address }}</textarea>
                @error('address')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2 flex gap-2 justify-end">
                <a href="{{ route('employees.index') }}" class="bg-gray-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="bg-cyan-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-cyan-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
