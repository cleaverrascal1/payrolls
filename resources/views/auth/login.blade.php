@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="flex h-screen items-center justify-center">
        <div class="mx-auto flex w-full max-w-sm flex-col">
            <div class="mb-8 text-left tracking-tight">
                <h2 class="text-3xl font-bold text-neutral-800">Masuk ke Akun Anda</h2>
                <p class="text-neutral-500">
                    Akses sistem untuk mengelola operasional bisnis
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email Anda"
                        class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                        {{ $errors->has('email') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                    >
                    @error('email')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password Anda"
                        class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                        {{ $errors->has('password') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                    >
                    @error('password')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="remember"
                            class="h-4 w-4 rounded border-neutral-300 text-blue-600 focus:ring-blue-500"
                        />
                        <label for="remember" class="ml-2 block text-sm text-neutral-700">
                            Ingat saya
                        </label>
                    </div>
                    <div>
                        <button type="button" class="text-sm font-medium hover:underline">
                            lupa password?
                        </button>
                    </div>
                </div>

                <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-[#347839] text-white px-4 py-2.5 text-sm font-medium hover:bg-[#22552d] transition-colors duration-200 cursor-pointer">
                    Masuk
                </button>
            </form>

            <div class="mt-10 border-t border-neutral-300 pt-6">
                <p class="text-center text-xs text-neutral-500">
                    Dengan masuk, Anda setuju dengan
                    <a href="#" class="text-[#347839] hover:text-[#22552d]">
                        Syarat & Ketentuan
                    </a>
                    dan
                    <a href="#" class="text-[#347839] hover:text-[#22552d]">
                        Kebijakan Privasi
                    </a>
                    dari Waykopi
                </p>
            </div>
        </div>
    </div>
@endsection
