@extends('layouts.dashboard')

@section('title', 'Detail Absensi')

@section('content')
    <div class="w-full space-y-4">
        <div class="flex gap-4">
            <div class="flex flex-1 bg-white h-fit rounded-xl border border-gray-300 p-6 gap-8">
                <div class="w-32 h-32 bg-black rounded-full flex items-center justify-center text-white hover:bg-black/60 transition-colors duration-200">
                    <span class="text-4xl font-bold">AS</span>
                </div>

                <div class="flex-1 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Nama</p>
                        <p>{{ $attendance->employee->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Jabatan</p>
                        <p>{{ $attendance->employee->position->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Periode</p>
                        <p>{{ \Carbon\Carbon::create($year, $month, 1)->translatedFormat('F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Tanggal Gabung</p>
                        <p>{{ $attendance->employee->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-[340px] flex flex-col gap-4">
                @php
                    $date = \Carbon\Carbon::create($year, $month, 1);
                    $daysInMonth = $date->daysInMonth;
                    $startDow = $date->dayOfWeek;

                    $statusConfig = [
                        'hadir' => ['label' => 'H', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'ring' => 'ring-emerald-300'],
                        'sakit' => ['label' => 'S', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'ring' => 'ring-yellow-300'],
                        'izin'  => ['label' => 'I', 'bg' => 'bg-gray-100',   'text' => 'text-gray-700',   'ring' => 'ring-gray-300'],
                        'alpa'  => ['label' => 'A', 'bg' => 'bg-red-100',    'text' => 'text-red-700',    'ring' => 'ring-red-300'],
                    ];
                @endphp

                <div class="bg-white rounded-xl border border-gray-300 p-4 space-y-4">
                    @php
                        $currentPeriod = \Carbon\Carbon::create($year, $month, 1);
                        $prevPeriod    = $currentPeriod->copy()->subMonth();
                        $nextPeriod    = $currentPeriod->copy()->addMonth();
                    @endphp

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold">
                            {{ $currentPeriod->translatedFormat('F Y') }}
                        </span>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('attendances.show', [$attendance->id, 'month' => $prevPeriod->month, 'year' => $prevPeriod->year]) }}"
                               class="flex p-2 text-sm rounded-lg hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left w-4 h-4"><path d="m15 18-6-6 6-6"/></svg>
                            </a>

                            @if ($nextPeriod->lte(\Carbon\Carbon::now()))
                                <a href="{{ route('attendances.show', [$attendance->id, 'month' => $nextPeriod->month, 'year' => $nextPeriod->year]) }}"
                                   class="flex p-2 text-sm rounded-lg hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right w-4 h-4"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                            @else
                                <span class="flex p-2 text-sm rounded-lg hover:bg-gray-50 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right w-4 h-4"><path d="m9 18 6-6-6-6"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-7 mb-1">
                        @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                            <div class="text-center text-xs font-medium text-gray-800 py-1">{{ $day }}</div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-1.5">
                        @for ($i = 0; $i < $startDow; $i++)
                            <div></div>
                        @endfor

                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $currentDate = $date->copy()->setDay($day);
                                $dateKey = $currentDate->format('Y-m-d');
                                $isWeekend = $currentDate->isWeekend();
                                $rec = $monthlyAttendances[$dateKey] ?? null;

                                $status = null;
                                if ($rec) {
                                    if ($rec->hadir) $status = 'hadir';
                                    elseif ($rec->sakit) $status = 'sakit';
                                    elseif ($rec->izin) $status = 'izin';
                                    elseif ($rec->alpa) $status = 'alpa';
                                }

                                $isToday = $currentDate->isToday();
                            @endphp

                            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-xs
                                {{ $isWeekend ? 'bg-transparent' : '' }}
                                {{ $isToday ? 'ring-2 ring-gray-500 bg-transparent' : '' }}
                                {{ $status ? $statusConfig[$status]['bg'] . ' ' . $statusConfig[$status]['text'] : '' }}
                            ">
                                <span class="font-medium leading-none">{{ $day }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                @php
                    $rekap = [
                        'hadir' => $monthlyAttendances->where('hadir', true)->count(),
                        'sakit' => $monthlyAttendances->where('sakit', true)->count(),
                        'izin'  => $monthlyAttendances->where('izin', true)->count(),
                        'alpa'  => $monthlyAttendances->where('alpa', true)->count(),
                    ];
                @endphp

                <div class="flex flex-col gap-3">
                    @foreach ($rekap as $key => $count)
                        <div class="flex items-center gap-4 rounded-lg p-2 {{ $statusConfig[$key]['bg'] }} ring-1 {{ $statusConfig[$key]['ring'] }}">
                            <div class="w-12 h-12 bg-white/50 rounded-sm"></div>
                            <div>
                                <p class="text-2xl font-bold {{ $statusConfig[$key]['text'] }}">{{ $count }}</p>
                                <p class="text-sm {{ $statusConfig[$key]['text'] }} capitalize">{{ ucfirst($key) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('attendances.index') }}"
               class="bg-gray-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-700">
                Kembali
            </a>
        </div>

    </div>
@endsection
