@extends('layouts.dashboard')

@section('title', 'Pegawai')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200">
        <div class="flex flex-col md:flex-row items-center justify-between p-4 gap-4">
            <form method="GET" action="{{ route('employees.index') }}" class="relative w-full max-w-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari Nama Pegawai, atau Jabatan..."
                    class="w-full bg-neutral-50 border border-neutral-200 text-sm rounded-lg pl-9 pr-4 py-2 focus:outline-none focus:border-[#347839] focus:bg-white"
                >
            </form>

            <a href="{{ route('employees.create') }}" class="w-full md:w-fit text-center bg-[#347839] text-white rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-[#22552d] transition-colors duration-200">
                Tambah Pegawai
            </a>
        </div>

        <div class="w-full overflow-auto">
            <x-table :headers="['Nama Pegawai', 'Jabatan', 'Alamat', 'Aksi']" :data="$employees">
                @foreach ($employees as $item)
                    <tr class="cursor-pointer even:bg-neutral-100 hover:bg-neutral-50 transition-colors duration-200">
                        <td class="px-4 py-2.5">{{ $item->name }}</td>
                        <td class="px-4 py-2.5 text-neutral-500">{{ $item->position?->name ?? '-' }}</td>
                        <td class="px-4 py-2.5 text-neutral-500">{{ $item->address }}</td>
                        <td class="flex items-center gap-4 px-4 py-2.5 text-neutral-500">
                            <a href="{{ route('employees.show', $item->id) }}" class="flex items-center gap-1 text-sm font-medium hover:text-black transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye w-3 h-3"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                                <span>
                                Lihat
                            </span>
                            </a>
                            <a href="{{ route('employees.edit', $item->id) }}" class="flex items-center gap-1 text-sm font-medium hover:text-black transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen w-3 h-3"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                                <span>
                                Edit
                            </span>
                            </a>
                            <form method="POST" action="{{ route('employees.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ addslashes($item->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-1 text-sm font-medium hover:text-red-600 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 w-3 h-3"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    <span>
                                Hapus
                            </span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>

        @if ($employees->hasPages())
            <div class="p-4">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
@endsection
