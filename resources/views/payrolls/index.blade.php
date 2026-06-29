@extends('layouts.dashboard')

@section('title', 'Penggajian')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-4 mb-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
            <form method="POST" action="{{ route('payrolls.generate') }}" class="flex items-end gap-4">
                @csrf
                <div>
                    <label class="block text-xs text-neutral-500 mb-1">Bulan</label>
                    <select name="monthly_period"
                            class="border border-neutral-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-neutral-400">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ old('monthly_period', now()->month) == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                    @error('monthly_period')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs text-neutral-500 mb-1">Tahun</label>
                    <input type="number" name="year_period"
                           value="{{ old('year_period', now()->year) }}"
                           class="w-28 border border-neutral-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-neutral-400">
                    @error('year_period')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="bg-[#347839] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#22552d] transition-colors duration-200">
                    Buat Slip Gaji
                </button>
            </form>

            <a href="{{ route('payrolls.create') }}"
               class="flex items-center gap-2 border border-neutral-200 text-sm font-medium px-4 py-2 rounded-lg hover:bg-neutral-50 transition-colors duration-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus w-4 h-4"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                <span>Tambah Slip Gaji</span>
            </a>

            <button type="button" disabled title="Segera hadir"
                    class="flex items-center gap-2 border border-neutral-200 text-sm font-medium px-4 py-2 rounded-lg opacity-40 cursor-not-allowed bg-neutral-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <path d="M8 13h8"/><path d="M8 17h8"/><path d="M8 9h2"/>
                </svg>
                Unduh Rekap Gaji
            </button>

            <form method="POST" action="{{ route('payrolls.downloadBatch') }}">
                @csrf
                <input type="hidden" name="monthly_period" value="{{ request('monthly_period', now()->month) }}">
                <input type="hidden" name="year_period" value="{{ request('year_period', now()->year) }}">
                <button
                    type="submit"
                    class="flex items-center gap-2 border border-neutral-200 text-sm font-medium px-4 py-2 rounded-lg hover:bg-neutral-50 transition-colors duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <path d="M20 17a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3.9a2 2 0 0 1-1.69-.9l-.81-1.2a2 2 0 0 0-1.67-.9H8a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2Z"/>
                        <path d="M2 8v11a2 2 0 0 0 2 2h14"/>
                    </svg>
                    Unduh Semua Slip
                </button>
            </form>
        </div>
    </div>

    @if (session('info'))
        <div class="mb-4 flex items-center gap-2 rounded-lg bg-blue-50 border border-blue-500 p-4 text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info-icon lucide-info w-4 h-4"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            <span class="text-sm font-medium">{{ session('info') }}</span>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 flex items-center gap-2 rounded-lg bg-[#e9f7ef] border border-[#347839] p-4 text-[#347839]">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check w-4 h-4"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg border border-neutral-200">
        <form method="GET" action="{{ route('payrolls.index') }}" class="flex flex-col sm:flex-row items-end gap-4 p-4">
            <div class="relative w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400">
                    <path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari pegawai..."
                       class="w-full bg-neutral-50 border border-neutral-200 text-sm rounded-lg pl-9 pr-4 py-2 focus:outline-none focus:border-[#347839] focus:bg-white">
            </div>

            <div>
                <select name="position"
                        class="border border-neutral-200 bg-neutral-50 rounded-lg px-3 py-2 text-sm text-neutral-600 focus:outline-none focus:border-[#347839] focus:bg-white">
                    <option value="">Semua Jabatan</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>
                            {{ $pos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="monthly_period"
                        class="border border-neutral-200 bg-neutral-50 rounded-lg px-3 py-2 text-sm text-neutral-600 focus:outline-none focus:border-[#347839] focus:bg-white">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('monthly_period') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <input type="number" name="year_period" value="{{ request('year_period') }}"
                       placeholder="Tahun"
                       class="w-24 border border-neutral-200 bg-neutral-50 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#347839] focus:bg-white">
            </div>

            <button
                type="submit"
                class="flex items-center gap-2 bg-[#347839] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#22552d] transition-colors duration-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel w-4 h-4"><path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"/></svg>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['search', 'position', 'monthly_period', 'year_period']))
                <a href="{{ route('payrolls.index') }}"
                   class="bg-neutral-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-neutral-700 transition-colors duration-200"
                >
                    Reset
                </a>
            @endif
        </form>

        <div class="w-full overflow-auto">
            <x-table :headers="['Nama Pegawai', 'Jabatan', 'Periode', 'Tanggal', 'Total Gaji', 'Status']" :data="$payrolls">
                @foreach ($payrolls as $item)
                    <tr class="cursor-pointer even:bg-neutral-100 hover:bg-neutral-50 transition-colors duration-200">
                        <td class="px-4 py-2.5">{{ $item->employee->name }}</td>
                        <td class="px-4 py-2.5 text-neutral-500">{{ $item->position }}</td>
                        <td class="px-4 py-2.5 text-neutral-500">{{ $item->monthly_period }}/{{ $item->year_period }}</td>
                        <td class="px-4 py-2.5 text-neutral-500">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2.5 text-neutral-500">Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-2.5">
                            <p class="flex w-fit items-center gap-1 bg-yellow-100 border border-yellow-300 text-xs text-yellow-600 px-3 text-center py-1 rounded-full ">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock3-icon lucide-clock-3 w-3 h-3"><circle cx="12" cy="12" r="10"/><path d="M12 6v6h4"/></svg>
                                <span class="capitalize">{{ $item->status }}</span>
                            </p>
                        </td>
                        <td class="flex items-center gap-4 px-4 py-2.5 text-neutral-500">
                            <a href="{{ route('payrolls.show', $item->id) }}" class="flex items-center gap-1 text-sm font-medium hover:text-black transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye w-3 h-3"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                                <span>
                                Lihat
                            </span>
                            </a>
                            <a href="{{ route('payrolls.edit', $item->id) }}" class="flex items-center gap-1 text-sm font-medium hover:text-black transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen w-3 h-3"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                                <span>
                                Edit
                            </span>
                            </a>
                            <form method="POST">
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

        @if ($payrolls->hasPages())
            <div class="p-4">
                {{ $payrolls->links() }}
            </div>
        @endif
    </div>
@endsection
