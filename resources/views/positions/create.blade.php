@extends('layouts.dashboard')

@section('title', 'Tambah Jabatan Baru')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-4">
        <form method="POST" action="{{ route('positions.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-neutral-700 mb-1">Nama Jabatan</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Contoh: Project Manager"
                    value="{{ old('name') }}"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('name') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                @error('name')
                    <p class="mt-1 text-red-500 text-xs font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="basic_salary" class="block text-sm font-medium text-neutral-700 mb-1">Gaji Pokok</label>
                <input
                    type="number"
                    name="basic_salary"
                    id="basic_salary"
                    placeholder="Contoh: 2000000"
                    value="{{ old('basic_salary') }}"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('basic_salary') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                @error('basic_salary')
                    <p class="mt-1 text-red-500 text-xs font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex gap-1.5">
                    <label for="sales_target" class="block text-sm font-medium text-neutral-700 mb-1">Target Penjualan</label>
                    <span class="text-sm text-neutral-500">(Opsional)</span>
                </div>
                <input
                    type="number"
                    name="sales_target"
                    id="sales_target"
                    placeholder="Contoh: 4000000"
                    value="{{ old('sales_target') }}"
                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none active:bg-white
                    {{ $errors->has('sales_target') ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]' }}"
                >
                @error('sales_target')
                q<p class="mt-1 text-red-500 text-xs font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{
                    rules: {{ json_encode(old('bonusRules', [])) }},
                    errors: {{ json_encode(
                        collect($errors->keys())
                            ->filter(fn($k) => str_starts_with($k, 'bonusRules.'))
                            ->mapWithKeys(fn($k) => [
                                preg_replace('/bonusRules\.(\d+)\.(.+)/', '$1.$2', $k) => $errors->first($k)
                            ])
                            ->toArray()
                    ) }}
                }"
            >
                <div class="flex items-center justify-between mb-2">
                    <div class="flex gap-1.5">
                        <label class="block text-sm font-medium text-neutral-700">Aturan Bonus Pencapaian Target</label>
                        <span class="text-sm text-neutral-500">(Opsional)</span>
                    </div>
                    <button
                        type="button"
                        @click="rules.push({ min_percentage: '', max_percentage: '', bonus: '' })"
                        class="flex items-center gap-2 bg-transparent border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-neutral-100 transition-colors duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Aturan
                    </button>
                </div>

                <div class="space-y-2">
                    <template x-if="rules.length > 0">
                        <div class="grid grid-cols-3 gap-2 px-1">
                            <span class="text-xs text-neutral-500">Min %</span>
                            <span class="text-xs text-neutral-500">Max % <span class="text-neutral-400">(opsional)</span></span>
                            <span class="text-xs text-neutral-500">Bonus (Rp)</span>
                        </div>
                    </template>

                    <template x-for="(rule, index) in rules" :key="index">
                        <div class="grid grid-cols-3 gap-2 items-start">
                            <div>
                                <input
                                    type="number"
                                    :name="`bonusRules[${index}][min_percentage]`"
                                    x-model="rule.min_percentage"
                                    placeholder="Contoh: 80"
                                    :class="errors[index + '.min_percentage'] ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]'"
                                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none"
                                >
                                <p x-show="errors[index + '.min_percentage']" x-text="errors[index + '.min_percentage']" class="mt-1 text-red-500 text-xs font-medium"></p>
                            </div>
                            <div>
                                <input
                                    type="number"
                                    :name="`bonusRules[${index}][max_percentage]`"
                                    x-model="rule.max_percentage"
                                    placeholder="Contoh: 99"
                                    :class="errors[index + '.max_percentage'] ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]'"
                                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none"
                                >
                                <p x-show="errors[index + '.max_percentage']" x-text="errors[index + '.max_percentage']" class="mt-1 text-red-500 text-xs font-medium"></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <div class="flex-1">
                                    <input
                                        type="number"
                                        :name="`bonusRules[${index}][bonus]`"
                                        x-model="rule.bonus"
                                        placeholder="Contoh: 500000"
                                        :class="errors[index + '.bonus'] ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]'"
                                        class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none"
                                    >
                                    <p x-show="errors[index + '.bonus']" x-text="errors[index + '.bonus']" class="mt-1 text-red-500 text-xs font-medium"></p>
                                </div>
                                <button type="button" @click="rules.splice(index, 1)" class="bg-red-500 w-fit h-fit p-2 rounded-md hover:bg-red-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2 w-4 h-4"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div x-data="{
                bonuses: {{ json_encode(old('performanceBonuses', [])) }},
                errors: {{ json_encode(
                    collect($errors->keys())
                        ->filter(fn($k) => str_starts_with($k, 'performanceBonuses.'))
                        ->mapWithKeys(fn($k) => [
                            preg_replace('/performanceBonuses\.(\d+)\.(.+)/', '$1.$2', $k) => $errors->first($k)
                        ])
                        ->toArray()
                ) }}
            }">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex gap-1.5">
                        <label class="block text-sm font-medium text-neutral-700">Bonus Kinerja</label>
                        <span class="text-sm text-neutral-500">(Opsional)</span>
                    </div>
                    <button
                        type="button"
                        @click="bonuses.push({ name: '', amount: '' })"
                        class="flex items-center gap-2 bg-transparent border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-neutral-100 transition-colors duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Bonus
                    </button>
                </div>

                <div class="space-y-2">
                    <template x-if="bonuses.length > 0">
                        <div class="grid grid-cols-2 gap-2 px-1">
                            <span class="text-xs text-neutral-500">Nama Bonus</span>
                            <span class="text-xs text-neutral-500">Nominal (Rp)</span>
                        </div>
                    </template>

                    <template x-for="(bonus, index) in bonuses" :key="index">
                        <div class="grid grid-cols-2 gap-2 items-start">
                            <div>
                                <input
                                    type="text"
                                    :name="`performanceBonuses[${index}][name]`"
                                    x-model="bonus.name"
                                    placeholder="Contoh: Kualitas Tim Terjaga"
                                    :class="errors[index + '.name'] ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]'"
                                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none"
                                >
                                <p x-show="errors[index + '.name']" x-text="errors[index + '.name']" class="mt-1 text-red-500 text-xs font-medium"></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <div class="flex-1">
                                    <input
                                        type="number"
                                        :name="`performanceBonuses[${index}][amount]`"
                                        x-model="bonus.amount"
                                        placeholder="Contoh: 500000"
                                        :class="errors[index + '.amount'] ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]'"
                                        class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none"
                                    >
                                    <p x-show="errors[index + '.amount']" x-text="errors[index + '.amount']" class="mt-1 text-red-500 text-xs font-medium"></p>
                                </div>
                                <button type="button" @click="bonuses.splice(index, 1)" class="bg-red-500 w-fit h-fit p-2 rounded-md hover:bg-red-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div x-data="{
                penalties: {{ json_encode(old('penalties', [])) }},
                errors: {{ json_encode(
                    collect($errors->keys())
                        ->filter(fn($k) => str_starts_with($k, 'penalties.'))
                        ->mapWithKeys(fn($k) => [
                            preg_replace('/penalties\.(\d+)\.(.+)/', '$1.$2', $k) => $errors->first($k)
                        ])
                        ->toArray()
                ) }}
            }">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex gap-1.5">
                        <label class="block text-sm font-medium text-neutral-700">Penalti</label>
                        <span class="text-sm text-neutral-500">(Opsional)</span>
                    </div>
                    <button
                        type="button"
                        @click="penalties.push({ name: '', type: '', value: '' })"
                        class="flex items-center gap-2 bg-transparent border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-neutral-100 transition-colors duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Penalti
                    </button>
                </div>

                <div class="space-y-2">
                    <template x-if="penalties.length > 0">
                        <div class="grid grid-cols-3 gap-2 px-1">
                            <span class="text-xs text-neutral-500">Kondisi</span>
                            <span class="text-xs text-neutral-500">Tipe</span>
                            <span class="text-xs text-neutral-500">Nilai</span>
                        </div>
                    </template>

                    <template x-for="(penalty, index) in penalties" :key="index">
                        <div class="grid grid-cols-3 gap-2 items-start">
                            <div>
                                <input
                                    type="text"
                                    :name="`penalties[${index}][name]`"
                                    x-model="penalty.name"
                                    placeholder="Contoh: Manipulasi Data"
                                    :class="errors[index + '.name'] ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]'"
                                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none"
                                >
                                <p x-show="errors[index + '.name']" x-text="errors[index + '.name']" class="mt-1 text-red-500 text-xs font-medium"></p>
                            </div>
                            <div>
                                <select
                                    :name="`penalties[${index}][type]`"
                                    x-model="penalty.type"
                                    @change="if (penalty.type === 'void') penalty.value = 0"
                                    :class="errors[index + '.type'] ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]'"
                                    class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none"
                                >
                                    <option value="" disabled>Pilih Tipe</option>
                                    <option value="void">Bonus Hangus</option>
                                    <option value="percentage">Dipotong (%)</option>
                                </select>
                                <p x-show="errors[index + '.type']" x-text="errors[index + '.type']" class="mt-1 text-red-500 text-xs font-medium"></p>
                            </div>
                            <div class="flex items-start gap-2">
                                <div class="flex-1">
                                    <input
                                        type="number"
                                        :name="`penalties[${index}][value]`"
                                        x-model="penalty.value"
                                        :placeholder="penalty.type === 'percentage' ? 'Contoh: 50' : ''"
                                        :readonly="penalty.type === 'void'"
                                        :class="[
                        errors[index + '.value'] ? 'border-red-400 focus:border-red-400' : 'border-neutral-300 focus:border-[#347839]',
                        penalty.type === 'void' ? 'opacity-50 cursor-not-allowed' : ''
                    ]"
                                        class="w-full border text-sm bg-neutral-50 px-4 py-2 rounded-lg focus:outline-none"
                                    >
                                    <p x-show="errors[index + '.value']" x-text="errors[index + '.value']" class="mt-1 text-red-500 text-xs font-medium"></p>
                                </div>
                                <button type="button" @click="penalties.splice(index, 1)" class="bg-red-500 w-fit h-fit p-2 rounded-md hover:bg-red-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="col-span-2 flex gap-2 justify-end">
                <a href="{{ route('positions.index') }}" class="bg-neutral-600 text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-neutral-700">Batal</a>
                <button type="submit" class="bg-[#347839] text-white px-4 py-2 text-sm font-medium rounded-lg hover:bg-[#22552d]">Simpan</button>
            </div>
        </form>
    </div>
@endsection
