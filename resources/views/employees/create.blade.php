@extends('layouts.dashboard')

@section('title', 'Tambah Pegawai Baru')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-4">
        <form method="POST" action="{{ route('employees.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-neutral-700 mb-1">Nama Pegawai</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Contoh: John Doe"
                    value="{{ old('name') }}"
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
                            {{ old('position_id') == $position->id ? 'selected' : '' }}
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
                <label for="address" class="block text-sm font-medium text-neutral-700 mb-1">Alamat</label>
                <textarea
                    name="address"
                    id="address"
                    placeholder="Masukan alamat pegawai"
                    rows="5"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('address') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2 flex gap-2 justify-end">
                <a href="{{ route('employees.index') }}" class="bg-neutral-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-neutral-700">Kembali</a>
                <button type="submit" class="bg-[#347839] text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-[#22552d]">Simpan</button>
            </div>
        </form>
    </div>
@endsection
