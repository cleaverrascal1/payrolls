@extends('layouts.dashboard')

@section('title', 'Profil')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-4">
        @if (session('success'))
            <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 px-4 py-2 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-neutral-700 mb-1">Nama</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    placeholder="Nama lengkap"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                        {{ $errors->has('name') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                @error('name')
                <p class="mt-1 text-red-500 text-xs font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', auth()->user()->email) }}"
                    placeholder="email@example.com"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                        {{ $errors->has('email') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                @error('email')
                <p class="mt-1 text-red-500 text-xs font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">
                    Password Baru <span class="text-neutral-400 font-normal ml-0.5">(kosongkan jika tidak ingin mengubah)</span>
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Min. 8 karakter"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                        {{ $errors->has('password') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                @error('password')
                <p class="mt-1 text-red-500 text-xs font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-1">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Ulangi password baru"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white border-neutral-300 focus:border-[#347839]"
                >
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-[#347839] text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-[#22552d]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
