@extends('layouts.dashboard')

@section('title', 'Detail Penjualan Zoho')

@section('content')
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">

                <div class="px-6 py-4 border-b border-neutral-100">
                    <h3 class="text-base font-semibold text-neutral-800">{{ $zohoSale->deal_name }}</h3>
                    <p class="text-sm text-neutral-400 mt-0.5">Zoho ID: {{ $zohoSale->zoho_id }}</p>
                </div>

                <dl class="divide-y divide-neutral-100">
                    <div class="px-6 py-3.5 flex justify-between">
                        <dt class="text-sm text-neutral-500">Pegawai</dt>
                        <dd class="text-sm font-medium text-neutral-800">{{ $zohoSale->employee?->name ?? '-' }}</dd>
                    </div>
                    <div class="px-6 py-3.5 flex justify-between">
                        <dt class="text-sm text-neutral-500">Amount</dt>
                        <dd class="text-sm font-medium text-neutral-800">
                            Rp {{ number_format($zohoSale->amount, 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="px-6 py-3.5 flex justify-between">
                        <dt class="text-sm text-neutral-500">Stage</dt>
                        <dd class="text-sm font-medium text-neutral-800">{{ $zohoSale->stage ?? '-' }}</dd>
                    </div>
                    <div class="px-6 py-3.5 flex justify-between">
                        <dt class="text-sm text-neutral-500">Closing Date</dt>
                        <dd class="text-sm font-medium text-neutral-800">
                            {{ $zohoSale->closing_date?->translatedFormat('d F Y') ?? '-' }}
                        </dd>
                    </div>
                    <div class="px-6 py-3.5 flex justify-between">
                        <dt class="text-sm text-neutral-500">Zoho Created At</dt>
                        <dd class="text-sm font-medium text-neutral-800">
                            {{ $zohoSale->zoho_created_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                        </dd>
                    </div>
                    <div class="px-6 py-3.5 flex justify-between">
                        <dt class="text-sm text-neutral-500">Zoho Updated At</dt>
                        <dd class="text-sm font-medium text-neutral-800">
                            {{ $zohoSale->zoho_updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                        </dd>
                    </div>
                </dl>

                @if($zohoSale->payload)
                    <div class="px-6 py-4 border-t border-neutral-100">
                        <p class="text-sm text-neutral-500 mb-2">Payload</p>
                        <pre class="text-xs bg-neutral-50 border border-neutral-200 rounded-lg p-4 overflow-x-auto text-neutral-700">{{ json_encode($zohoSale->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
