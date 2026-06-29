@extends('layouts.dashboard')

@section('title', 'Detail Jabatan')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-4">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1">Nama Jabatan</label>
                <input type="text" value="{{ $position->name }}" disabled
                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-1">Gaji Pokok</label>
                <input type="text" value="Rp{{ number_format($position->basic_salary, 0, ',', '.') }}" disabled
                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
            </div>

            @if ($position->sales_target)
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Target Penjualan</label>
                    <input type="text" value="Rp{{ number_format($position->sales_target, 0, ',', '.') }}" disabled
                           class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                </div>
            @endif

            @if ($position->bonusRules->isNotEmpty())
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Aturan Bonus Pencapaian Target</label>
                    <div class="grid grid-cols-3 gap-2 px-1 mb-1">
                        <span class="text-xs text-neutral-500">Min %</span>
                        <span class="text-xs text-neutral-500">Max %</span>
                        <span class="text-xs text-neutral-500">Bonus (Rp)</span>
                    </div>
                    <div class="space-y-2">
                        @foreach ($position->bonusRules as $rule)
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" value="{{ $rule->min_percentage }}%" disabled
                                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                                <input type="text" value="{{ $rule->max_percentage ? $rule->max_percentage . '%' : '∞' }}" disabled
                                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                                <input type="text" value="Rp{{ number_format($rule->bonus, 0, ',', '.') }}" disabled
                                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($position->performanceBonuses->isNotEmpty())
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Bonus Kinerja</label>
                    <div class="grid grid-cols-2 gap-2 px-1 mb-1">
                        <span class="text-xs text-neutral-500">Nama Bonus</span>
                        <span class="text-xs text-neutral-500">Nominal (Rp)</span>
                    </div>
                    <div class="space-y-2">
                        @foreach ($position->performanceBonuses as $bonus)
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" value="{{ $bonus->name }}" disabled
                                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                                <input type="text" value="{{ $bonus->amount ? 'Rp' . number_format($bonus->amount, 0, ',', '.') : '-' }}" disabled
                                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($position->penalties->isNotEmpty())
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Penalti</label>
                    <div class="grid grid-cols-3 gap-2 px-1 mb-1">
                        <span class="text-xs text-neutral-500">Kondisi</span>
                        <span class="text-xs text-neutral-500">Tipe</span>
                        <span class="text-xs text-neutral-500">Nilai</span>
                    </div>
                    <div class="space-y-2">
                        @foreach ($position->penalties as $penalty)
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" value="{{ $penalty->name }}" disabled
                                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                                <input type="text" value="{{ $penalty->type === 'void' ? 'Bonus Hangus' : 'Dipotong (%)' }}" disabled
                                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                                <input type="text" value="{{ $penalty->type === 'void' ? '-' : $penalty->value . '%' }}" disabled
                                       class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Dibuat Pada</label>
                    <input type="text" value="{{ $position->created_at->locale('id')->translatedFormat('d F Y, H:i') }}" disabled
                           class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Diperbarui Pada</label>
                    <input type="text" value="{{ $position->updated_at->locale('id')->translatedFormat('d F Y, H:i') }}" disabled
                           class="w-full border text-sm border-neutral-200 px-4 py-2 rounded-lg bg-gray-50 text-neutral-500 cursor-not-allowed">
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                <a href="{{ route('positions.index') }}" class="bg-neutral-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-neutral-700">
                    Kembali
                </a>
                <a href="{{ route('positions.edit', $position->id) }}" class="px-4 py-2 text-sm font-medium rounded-lg hover:bg-neutral-50 border border-neutral-300">
                    Edit
                </a>
            </div>

        </div>
    </div>
@endsection
